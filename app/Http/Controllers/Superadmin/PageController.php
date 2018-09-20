<?php

namespace App\Http\Controllers\Superadmin;

use App\Models\Category;
use App\Models\Mediafile;
use App\Models\Page;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Lang;

class PageController extends Controller
{

    public function index(){
        $pages = Page::paginate(8);
        return view(User::UserRoleName(Auth::user()->id).'.pages.index', compact('pages') );
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
        Page::create($data);
        return Redirect::back()->with('success', 'Страница добавлена');
    }

    public function edit($id){
        return view(User::UserRoleName(Auth::user()->id).'.pages.edit',
            [
                'page' => Page::all()->find($id),
                'medias' => Mediafile::all()
            ]
        );
    }

    public function update(Request $request, $id){
        $data = $request->except(['_token']);
        $page = Page::all()->find($id);

        if($data['url'] == null){
            $data['url'] = GlobalController::getTranslit($data['title']);
            $validation = Validator::make($data, [
                'url' => 'min:2|max:20|unique:pages,url',
            ]);
            if ($validation->fails()){
                return Redirect::back()->with('error', Lang::get('validation.error'))->withInput($request->all())->withErrors($validation);
            }
        }
        elseif ($page->url != $data['url']){
            $validation = Validator::make($request->all(), [
                'url' => 'required|min:2|max:20|unique:pages,url|regex:/(^[A-Za-z0-9_-]+$)+/',
            ]);
            if ($validation->fails()){
                return Redirect::back()->with('error', Lang::get('validation.error'))->withInput($request->all())->withErrors($validation);
            }
        }

        $page->update($data);
        return redirect('ip5woctv9f990lc/pages')->with('success', 'Данные страницы обновлены');

    }

    public function destroy($id){
        Page::all()->find($id)->delete();
        return Redirect::back()->with('success', 'Страница удалена');
    }

}
