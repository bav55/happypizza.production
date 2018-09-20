<?php

namespace App\Http\Controllers\Superadmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Portion;

class PortionsController extends Controller
{
    public function index(){
        return view(User::UserRoleName(Auth::user()->id).'.portion.index',
            [
                'values' => Portion::paginate(8),
                'title' => 'Порции',
                'url' => 'portions'
            ]
        );
    }

    public function store(Request $request){
        $data = $request->except(['_token']);
        Portion::create($data);
        return Redirect::back()->with('success', 'Порция добавлена');
    }

    public function destroy($id){
        Portion::all()->find($id)->delete();
        return Redirect::route('portions.index')->with('success', 'Порция удалена');
    }

    public function edit($id){
        return view(User::UserRoleName(Auth::user()->id).'.portion.edit',
            [
                'val'=>Portion::all()->find($id),
                'values' => Portion::paginate(8),
                'title' => 'Порции',
                'url' => 'portions'
            ]
        );
    }

    public function update(Request $request, $id){
        $data = $request->except(['_token']);
        Portion::findOrFail($id)->update($data);
        return Redirect::route('portions.index')->with('success', 'Порция обновлена');
    }
}
