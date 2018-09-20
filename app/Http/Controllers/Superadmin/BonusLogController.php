<?php

namespace App\Http\Controllers\Superadmin;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

use App\Models\Setting;
use App\Models\Order;
use App\Models\Bonus_Log;

class BonusLogController extends Controller
{

    public function index(Request $request){
	
		$bonus_percent = Setting::all()->find(1)->bonus_percent;
		
        //$reviews = Review::orderby('id','DESC')->paginate('15');
		$user_order = Order::where('user_id')->get();
		
		//SELECT * From orders where created_at > SUBDATE(NOW(), INTERVAL '03:53' HOUR_MINUTE)
		//$orders = Order::whereRaw('created_at > SUBDATE(now(), INTERVAL 6 HOUR)')->get();
		//dd($orders);
		 $orders = Order::select('*')->where('user_id','!=','NULL');
		 $orders = Order::has('getBonusLog');
		 //print_r($orders);exit();
       /* if ($request->has('id')){
            $orders->where('id', 'like', '%' . $request->get('id') . '%');
        }
        if ($request->has('order_id')){
            $orders->where('order_id', 'like', '%' . $request->get('order_id') . '%');
        }*/
        $orders = $orders->orderby('id','desc')->paginate('15');

        return view(User::UserRoleName(Auth::user()->id).'.bonuslog.index', compact('orders', 'user_order', 'bonus_percent') );
		
		//$order_bonus_add = 
		//print_r($user_order);exit();
        //return view(User::UserRoleName(Auth::user()->id).'.bonuslog.index', compact('reviews', 'user_order', 'bonus_percent') );
    }

    public function edit($id){
        Review::all()->find($id)->update(['is_look' => true]);
        $review = Review::all()->find($id);
        return view(User::UserRoleName(Auth::user()->id).'.reviews.edit', compact('review') );
    }

    public function update(Request $request, $id){
        $data = $request->except(['_token']);
        $data['is_show'] == 'true' ? $data['is_show'] = true : $data['is_show'] = false;
        Review::all()->find($id)->update($data);
        return Redirect::route('review.index')->with('success', 'Изменения внесены');
    }

    public function destroy($id){
        Review::all()->find($id)->delete();
        return Redirect::route('review.index')->with('success', 'Отзыв удален');
    }

    public function store(Request $request){
        $data = $request->except(['_token']);
        $data['is_show'] == 'true' ? $data['is_show'] = true : $data['is_show'] = false;
        $data['sort'] == null ? $data['sort'] = false : $data['sort'];
        $data['is_look'] = true;
        Review::create($data);
        return Redirect::route('review.index')->with('success', 'Отзыв добавлен');
    }

    public function create(){
        return view(User::UserRoleName(Auth::user()->id).'.reviews.create');
    }

}
