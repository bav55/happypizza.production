<?php

namespace App\Http\Controllers\Superadmin;

use App\Models\Category;
use App\Models\Mediafile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Ingredient;

class IngredientsController extends Controller
{

    public function index(){
        return view(User::UserRoleName(Auth::user()->id).'.ingredients.index',
            [
                'values' => Ingredient::paginate(8),
                'title' => 'Ингредиенты',
                'url' => 'ingredients',
                'categories' => Category::all(),
                'medias' => Mediafile::all()
            ]
        );
    }

    public function store(Request $request){
        $data = $request->except(['_token']);
        Ingredient::create($data);
        return Redirect::back()->with('success', 'Ингредиент добавлен');
    }

    public function destroy($id){
        Ingredient::all()->find($id)->delete();
        return Redirect::route('ingredients.index')->with('success', 'Ингредиент удален');
    }

    public function edit($id){
        return view(User::UserRoleName(Auth::user()->id).'.ingredients.edit',
            [
                'val'=>Ingredient::all()->find($id),
                'values' => Ingredient::paginate(8),
                'title' => 'Ингредиенты',
                'url' => 'ingredients',
                'categories' => Category::all(),
                'medias' => Mediafile::all()
            ]
        );
    }

    public function update(Request $request, $id){
        $data = $request->except(['_token']);
        Ingredient::findOrFail($id)->update($data);
        return Redirect::route('ingredients.index')->with('success', 'Ингредиент обновлен');
    }

}
