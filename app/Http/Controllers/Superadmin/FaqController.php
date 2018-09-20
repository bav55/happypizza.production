<?php

namespace App\Http\Controllers\Superadmin;

use App\Models\Faq;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Auth;
use App\User;

class FaqController extends Controller
{

    public function index(){
        $faqs = Faq::paginate(8);
        return view(User::UserRoleName(Auth::user()->id).'.faq.index', compact('faqs') );
    }

    public function store(Request $request){
        $data = $request->except(['_token']);
        //dump($data);
        isset($data['is_active']) && $data['is_active'] == 'on' ? $data['is_active'] = true : $data['is_active'] = false;
        Faq::create($data);
        return Redirect::back()->with('success', 'ЧаВо добавлен');
    }

    public function edit(Request $request, $id){
        $faqs = Faq::paginate(8);
        $faq_o = Faq::all()->find($id);
        return view(User::UserRoleName(Auth::user()->id).'.faq.edit', compact('faqs','faq_o') );
    }

    public function update(Request $request, $id){
        $data = $request->except(['_token']);
        //dump($data);
        isset($data['is_active']) && $data['is_active'] == 'on' ? $data['is_active'] = true : $data['is_active'] = false;
        Faq::all()->find($id)->update($data);
        return Redirect::route('faqs.index')->with('success', 'ЧаВо обновлен');
    }

    public function destroy($id){
        Faq::all()->find($id)->delete();
        return Redirect::route('faqs.index')->with('success', 'ЧаВо Удален');
    }

}
