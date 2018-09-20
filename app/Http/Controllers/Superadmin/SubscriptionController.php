<?php

namespace App\Http\Controllers\Superadmin;

use App\Models\Subscription;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Redirect;

class SubscriptionController extends Controller
{

    public function index(){
        return view(User::UserRoleName(Auth::user()->id).'.subscription.index',
            [
                'subscriptions' => Subscription::paginate(15)
            ]
        );
    }

    public function destroy($id){
        Subscription::all()->find($id)->delete();
        return Redirect::back()->with('success', 'E-mail удален');
    }

}
