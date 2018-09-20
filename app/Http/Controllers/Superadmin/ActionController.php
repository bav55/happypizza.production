<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\GlobalController;
use App\Models\Action;
use App\Models\Category;
use App\Models\Mediafile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Lang;

class ActionController extends Controller
{

    public function index(){
        $actions = Action::paginate(8);
        return view(User::UserRoleName(Auth::user()->id).'.action.index',compact('actions'));
    }

    public function store(Request $request){
        $data = $request->except(['_token']);
        $data['url'] = GlobalController::getTranslit($data['title']);
        $validation = Validator::make($data, [
            'url' => 'required|min:2|max:20|unique:actions,url|regex:/(^[A-Za-z0-9_-]+$)+/',
        ]);
        if ($validation->fails()){
            $data['url'] = $data['url'] . date('dHis');
        }

        Action::create($data);
        return Redirect::back()->with('success', 'Акция добавлена');
    }

    public function edit($id){
        $categories = Category::all();
        $medias = Mediafile::all();
        $action = Action::all()->find($id);
        if ($action->is_present == '1'){
            $present = json_decode($action->total);
            $condition = 'true';
        } else {
            $present = $action->total;
            $condition = 'false';
        }

        return view(User::UserRoleName(Auth::user()->id).'.action.edit',compact('action','medias','categories','present','condition'));
    }

    public function update(Request $request, $id){
        $data = $request->except(['_token']);

        if ($data['sales_percent'] != null){
            $data['total'] = $data['sales_percent'];
        } elseif ($data['sales_sum'] != null) {
            $data['total'] = $data['sales_sum'];
        } elseif ($data['present'] != null) {
            $data['total'] = json_encode($data['present']);
        }
        if ($data['action']){
            $data['action'] = json_encode($data['action']);
        }

        $data['is_percent'] == 'true' ? $data['is_percent'] = true : $data['is_percent'] = false;
        $data['is_present'] == 'true' ? $data['is_present'] = true : $data['is_present'] = false;
        $data['is_sum'] == 'true' ? $data['is_sum'] = true : $data['is_sum'] = false;
        $data['show_main'] == 'true' ? $data['show_main'] = true : $data['show_main'] = false;

        $data['url'] = GlobalController::getTranslit($data['title']);
        
        if(empty($data['url_product'])){
            $data['url_product'] = '';
        }
        $validation = Validator::make($data, [
            'url' => 'required|min:2|max:20|unique:actions,url,'. $id .'|regex:/(^[A-Za-z0-9_-]+$)+/',
        ]);
        if ($validation->fails()){
            $data['url'] = $data['url'] . date('dHis');
        }

        Action::all()->find($id)->update($data);

        return Redirect::route('action.index')->with('success', 'Акция обновлена');
    }

    public function destroy($id){
        Action::all()->find($id)->delete();
        return Redirect::back()->with('success', 'Акция удалена');
    }

}
