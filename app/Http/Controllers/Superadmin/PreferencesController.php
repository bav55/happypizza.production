<?php

namespace App\Http\Controllers\Superadmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Preference;
use App\Models\Mediafile;
use App\Models\Category;

class PreferencesController extends Controller
{

    public function index(){
        return view(User::UserRoleName(Auth::user()->id).'.kitchen.index',
            [
                'values' => Preference::paginate(8),
                'title' => 'Предпочтения',
                'url' => 'preferences',
                'categories' => Category::all(),
                'medias' => Mediafile::all()
            ]
        );
    }

    public function store(Request $request){
        $data = $request->except(['_token']);
        Preference::create($data);
        return Redirect::back()->with('success', 'Предпочтение добавлено');
    }

    public function destroy($id){
        Preference::all()->find($id)->delete();
        return Redirect::route('preferences.index')->with('success', 'Предпочтение удалено');
    }

    public function edit($id){
        return view(User::UserRoleName(Auth::user()->id).'.kitchen.edit',
            [
                'val'=>Preference::all()->find($id),
                'values' => Preference::paginate(8),
                'title' => 'Предпочтения',
                'url' => 'preferences',
                'categories' => Category::all(),
                'medias' => Mediafile::all()
            ]
        );
    }

    public function update(Request $request, $id){
        $data = $request->except(['_token']);
        Preference::findOrFail($id)->update($data);
        return Redirect::route('preferences.index')->with('success', 'Предпочтение обновлено');
    }

}
