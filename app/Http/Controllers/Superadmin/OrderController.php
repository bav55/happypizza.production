<?php

namespace App\Http\Controllers\Superadmin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    public function index(Request $request){

        $orders = Order::select('*');
        if ($request->has('id')){
            $orders->where('id', 'like', '%' . $request->get('id') . '%');
        }
        if ($request->has('order_id')){
            $orders->where('order_id', 'like', '%' . $request->get('order_id') . '%');
        }
        if ($request->has('frontpad_order_number')){
            $orders->where('frontpad_order_number', '=', $request->get('frontpad_order_number'));
        }

        $orders = $orders->orderby('id','desc')->paginate('15');

        return view(User::UserRoleName(Auth::user()->id).'.orders.index', compact('orders') );
    }

    public function show($id){
        $order = Order::all()->find($id);
        $order -> update(['is_new'=>false]);
        $goods = json_decode($order->good_list);
        $extra = json_decode($order->extra);
        $delivery_adress = $order->delivery_address != null ? json_decode($order->delivery_address) : null;
        $presents = $order->present_list != null ? json_decode($order->present_list, true) : null;
        return view(User::UserRoleName(Auth::user()->id).'.orders.show', compact('order','goods','delivery_adress','extra','presents') );
    }

}
