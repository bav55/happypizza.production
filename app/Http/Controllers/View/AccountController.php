<?php

namespace App\Http\Controllers\View;

use App\Models\Good;
use App\Models\Order;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class AccountController extends Controller
{

    public function account(){
        return view('view.account.account',
            [
                'user' => User::all()->find(Auth::user()->id)
            ]
        );
    }

    public function update_data(Request $request){
        foreach ($request->input() as $key => $value) {
            if (isset($value) ){
                User::where('id', Auth::user()->id)->update($request->input());
            }
        }
    }

    public function update_password(Request $request){
        $var = null;
        foreach ($request->input() as $key => $value) {
            if (isset($value) ) {
                User::where('id', Auth::user()->id)->update(['password' => bcrypt($value)]);
            }
            $var = $value;
        }
        return $var != null ? 'Пароль изменен' : 'Пароль не может быть пустым';
    }

    public function createdPizza(){
        return view('view.account.created',
            [
                'goods' => Good::where('user_id', Auth::user()->id)->get()
            ]
        );
    }

    public function orderHistory(Request $request){
        if (isset($request->page) && $request->page == 1){
            return Redirect::route('orderHistory');
        }
        return view('view.account.order-history',
            [
               // 'orders' => Order::where('user_id', Auth::user()->id)->where('is_paid','1')->orderBy('id','desc')->paginate(10)
               'orders' => Order::where('phone', Auth::user()->phone)->where('is_paid','1')->orderBy('id','desc')->paginate(10)
//                'orders' => Order::where('user_id', Auth::user()->id)->paginate(2)
            ]
        );
    }

    public function showOrder($id){
        $order = Order::all()->find($id);
        if ($order->user_id == Auth::user()->id){
            $goods = json_decode($order->good_list);
            $extras = json_decode($order->extra);
            return view('view.account.show-order', compact('order','goods','extras'));
        } else if ($order->phone == Auth::user()->phone){
            $goods = json_decode($order->good_list);
            $extras = json_decode($order->extra);
            return view('view.account.show-order', compact('order','goods','extras'));
        } else {    
            return Redirect::route('orderHistory');
        }

    }

}
