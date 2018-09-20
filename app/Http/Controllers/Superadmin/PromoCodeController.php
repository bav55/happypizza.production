<?php

namespace App\Http\Controllers\Superadmin;

use App\Models\PromoCod;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PromoCodeController extends Controller
{
    public function index(){
        return view(User::UserRoleName(Auth::user()->id).'.promo-code.index',
            [
                'codes' => PromoCod::paginate(8)
            ]
        );
    }

    public function store(Request $request){
        $data = $request->except(['_token']);

        $validator = Validator::make($request->all(), [
            'title' => 'min:2|max:20|unique:promo_cods,title|regex:/^[a-zA-Z0-9]+$/',
            'sum' => 'integer|numeric',
            'limit' => 'integer|numeric'
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $data['sales'] == 'is_sum' ? $data['is_sum'] = true : $data['is_sum'] = false;
        $data['sales'] == 'is_percent' ? $data['is_percent'] = true : $data['is_percent'] = false;

        PromoCod::create($data);
        return Redirect::back()->with('success', 'Промо код создан');
    }

    public function edit($id){
        return view(User::UserRoleName(Auth::user()->id).'.promo-code.edit',
            [
                'codes' => PromoCod::paginate(8),
                'code_one' => PromoCod::all()->find($id)
            ]
        );
    }

    public function update(Request $request, $id){
        $data = $request->except(['_token']);

        $code = PromoCod::all()->find($id);

        $validator = Validator::make($request->all(), [
            'title' => 'min:2|max:20|unique:promo_cods,title,'. $id .'|regex:/^[a-zA-Z0-9]+$/',
            'sum' => 'integer|numeric',
            'limit' => 'integer|numeric'
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $data['sales'] == 'is_sum' ? $data['is_sum'] = true : $data['is_sum'] = false;
        $data['sales'] == 'is_percent' ? $data['is_percent'] = true : $data['is_percent'] = false;

        $code->update($data);

        return Redirect::route('p-cods.index')->with('success', 'Данные кода обнавлены');
    }

    public function show($id){
        return view(User::UserRoleName(Auth::user()->id).'.promo-code.show',
            [
                'codes' => PromoCod::paginate(8),
                'code_one' => PromoCod::all()->find($id)
            ]
        );
    }

    public function destroy($id){
        PromoCod::all()->find($id)->delete();
        return Redirect::route('p-cods.index')->with('success', 'Промо код удален');
    }

}
