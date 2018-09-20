<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Review;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        if(Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('operator')) {
            $orders = Order::where('is_new',true)->where('is_paid',true)->get();
            $reviews = Review::where('is_look', false)->get();
            return view(User::UserRoleName(Auth::user()->id).'.index', compact('orders','reviews'));
        }
        else{
            return redirect()->route('index');
        }
    }
}
