<?php

namespace App\Http\Controllers\Superadmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Role;
use App\Models\User_Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;


class OperatorController extends Controller
{

    public function index(Request $request){
        $operators = Role::find(2)->users()->paginate('15');
        return view(User::UserRoleName(Auth::user()->id).'.operators.index', compact('operators') );
    }
    public function edit($id){
        $operator = User::all()->find($id);
        return view(User::UserRoleName(Auth::user()->id).'.operators.edit', compact('operator') );
    }

    public function update(Request $request, $id){
        $data = $request->except(['_token']);
        User::all()->find($id)->update($data);
        return Redirect::route('operators.index')->with('success', 'Изменения внесены');
    }

    public function destroy($id){
        User::find($id)->delete();
        User_Role::where('user_id','=', $id)->delete();

        return Redirect::route('operators.index')->with('success', 'Оператор удален');
    }

    public function store(Request $request){
        $data = $request->except(['_token']);
        $data['password'] = bcrypt($data['password']);
        $operator = User::create($data);
        $role_param = ['user_id' => $operator->id, 'role_id' => 2];
        $role_opeator = User_Role::create($role_param);
        return Redirect::route('operators.index')->with('success', 'Оператор добавлен');
    }

    public function create(){
        return view(User::UserRoleName(Auth::user()->id).'.operators.create');
    }
}