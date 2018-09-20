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
use App\Models\Recomend;

class RecomendController extends Controller
{

    public function index(){
        return view(User::UserRoleName(Auth::user()->id).'.recomend.index',
            [
                'values' => Recomend::paginate(8),
                'title' => 'Рекомендуемые',
                'url' => 'recomend',
                'medias' => Mediafile::all()
            ]
        );
    }

    public function store(Request $request){
        $data = $request->except(['_token']);
        
        if (empty($data['text'])) {
            $data['text'] = '';
        }
        Recomend::create($data);
        return Redirect::back()->with('success', 'Бннер добавлен');
    }

    public function destroy($id){
        Recomend::all()->find($id)->delete();
        return Redirect::route('recomend.index')->with('success', 'Баннер удален');
    }

    public function edit($id){
        return view(User::UserRoleName(Auth::user()->id).'.recomend.edit',
            [
                'val'=>Recomend::all()->find($id),
                'values' => Recomend::paginate(8),
                'title' => 'Рекомендуемые',
                'url' => 'recomend',
                'categories' => Category::all(),
                'medias' => Mediafile::all()
            ]
        );
    }

    public function update(Request $request, $id){
        $data = $request->except(['_token']);
        if (empty($data['text'])) {
            $data['text'] = '';
        }
        Recomend::findOrFail($id)->update($data);
        return Redirect::route('recomend.index')->with('success', 'Баннер обновлен');
    }

}
