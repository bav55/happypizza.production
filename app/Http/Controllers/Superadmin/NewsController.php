<?php

namespace App\Http\Controllers\Superadmin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Lang;
use App\Models\News;
use App\User;
use App\Models\Mediafile;

class NewsController extends Controller
{
    public function index(){
        $news = News::paginate(8);
        return view(User::UserRoleName(Auth::user()->id).'.news.index', compact('news') );
    }

    public function store(Request $request){
        $data = $request->except(['_token']);
        if($data['url'] == null){
            $data['url'] = GlobalController::getTranslit($data['title']);
            $validation = Validator::make($data, [
                'url' => 'min:2|max:20|unique:pages,url',
            ]);
            if ($validation->fails()){
                return Redirect::back()->with('error', Lang::get('validation.error'))->withInput($request->all())->withErrors($validation);
            }
        }
        else {
            $validation = Validator::make($request->all(), [
                'url' => 'required|min:2|max:20|unique:pages,url|regex:/(^[A-Za-z0-9_-]+$)+/',
            ]);
            if ($validation->fails()){
                return Redirect::back()->with('error', Lang::get('validation.error'))->withInput($request->all())->withErrors($validation);
            }
        }
        News::create($data);
        return Redirect::back()->with('success', 'Новость добавлена');
    }

    public function edit($id){
        return view(User::UserRoleName(Auth::user()->id).'.news.edit',
            [
                'new' => News::all()->find($id),
                'medias' => Mediafile::all()
            ]
        );
    }

    public function update(Request $request, $id){
        $data = $request->except(['_token']);
        $new = News::all()->find($id);

        if($data['url'] == null){
            $data['url'] = GlobalController::getTranslit($data['title']);
            $validation = Validator::make($data, [
                'url' => 'min:2|max:20|unique:news,url',
            ]);
            if ($validation->fails()){
                return Redirect::back()->with('error', Lang::get('validation.error'))->withInput($request->all())->withErrors($validation);
            }
        }
        elseif ($new->url != $data['url']){
            $validation = Validator::make($request->all(), [
                'url' => 'required|min:2|max:20|unique:news,url|regex:/(^[A-Za-z0-9_-]+$)+/',
            ]);
            if ($validation->fails()){
                return Redirect::back()->with('error', Lang::get('validation.error'))->withInput($request->all())->withErrors($validation);
            }
        }

        $new->update($data);
        return redirect('administrator/news')->with('success', 'Данные обновлены');

    }

    public function destroy($id){
        News::all()->find($id)->delete();
        return Redirect::back()->with('success', 'Новость удалена');
    }
}
