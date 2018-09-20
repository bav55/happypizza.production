<?php

namespace App\Http\Controllers\Superadmin;

use App\Http\Controllers\GlobalController;
use App\Models\Vacancy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Mediafile;
use Illuminate\Support\Facades\Redirect;

class VacancyController extends Controller
{

    public function index(){
        $vacancies = Vacancy::paginate(15);
        return view(User::UserRoleName(Auth::user()->id).'.vacansy.index', compact('vacancies') );
    }

    public function create(){
        return view(User::UserRoleName(Auth::user()->id).'.vacansy.create',
            [
                'medias' => Mediafile::all()
            ]
        );
    }

    public function store(Request $request){
        $data = $request->except(['_token']);
        $data['is_show'] == 'true' ? $data['is_show'] = true : $data['is_show'] = false;
        $data['sort'] == null ? $data['sort'] = '0' : $data['sort'];

        if($data['url'] == null){
            $data['url'] = GlobalController::getTranslit($data['title']);
            $validation = Validator::make($data, [
                'url' => 'unique:vacancies,url',
            ]);
            if ($validation->fails()){
                $data['url'] = $data['url'].date('H');
            }
        }
        //dump($data);
        $data['form'] = json_encode($data['form']);
        Vacancy::create($data);
        return Redirect::route('vacancy.index')->with('success', 'Вакансия добавлена');
    }

    public function edit($id){
        $vacancy = Vacancy::all()->find($id);
        $forms = json_decode($vacancy->form, true);
        $medias = Mediafile::all();
        return view(User::UserRoleName(Auth::user()->id).'.vacansy.edit', compact('vacancy','forms','medias') );
    }

    public function update(Request $request,$id){
        $data = $request->except(['_token']);
        $data['is_show'] == 'true' ? $data['is_show'] = true : $data['is_show'] = false;
        $data['sort'] == null ? $data['sort'] = '0' : $data['sort'];
        $data['form'] = json_encode($data['form']);
        Vacancy::all()->find($id)->update($data);
        return Redirect::route('vacancy.index')->with('success', 'Вакансия изменена');
    }

    public function destroy($id){
        Vacancy::all()->find($id)->delete();
        return Redirect::back()->with('success', 'Вакансия удалена');
    }


}
