<?php

namespace App\Http\Controllers\Superadmin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use Illuminate\Support\Facades\Redirect;

class CategoryController extends Controller
{
    public function index(){
        $categories = Category::paginate(8);
        return view(User::UserRoleName(Auth::user()->id).'.category.index', compact('categories') );
    }

    public function store(Request $request){
        $data = $request->except(['_token']);
        Category::create($data);
        return Redirect::back()->with('success', 'Категория создана');
    }

    public function destroy($id){
        Category::all()->find($id)->delete();
        return Redirect::route('categories.index')->with('success', 'Категория удалена');
    }

    public function edit($id){
        return view(User::UserRoleName(Auth::user()->id).'.category.edit',
            [
                'category'=>Category::all()->find($id)
            ]
        );
    }

    public function update(Request $request, $id){
        $data = $request->except(['_token']);
        $category = Category::findOrFail($id);
        $category->update($data);
        return Redirect::route('categories.index')->with('success', 'Данные обновлены');
    }
}
