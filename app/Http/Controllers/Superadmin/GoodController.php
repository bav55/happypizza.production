<?php

namespace App\Http\Controllers\Superadmin;

use App\Models\Category;
use App\Models\Good;
use App\Models\Good_Ingredient;
use App\Models\Good_Portion;
use App\Models\Good_Preferenc;
use App\Models\Good_Size_Price;
use App\Models\Ingredient;
use App\Models\Mediafile;
use App\Models\Portion;
use App\Models\Preference;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Controllers\GlobalController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Lang;
use App\User;
use App\Models\Recomend;

class GoodController extends Controller
{

    public function index(Request $request){

        $goods = Good::select('*');

        if ($request->has('title')){
            $goods->where('title', 'like', '%' . $request->get('title') . '%');
        }

        $goods = $goods->paginate('15');
        return view(User::UserRoleName(Auth::user()->id).'.goods.index', compact('goods') );

    }

    public function create(){
        return view(User::UserRoleName(Auth::user()->id).'.goods.create',
            [
                'categories' => Category::all(),
                'ingredients' => Ingredient::all(),
                'portions' => Portion::all(),
                'preferences' => Preference::all(),
                'medias' => Mediafile::all()
            ]
        );
    }

    public function store(Request $request){

        $data = $request->except(['_token']);

        $data['is_popular'] == 'true' ? $data['is_popular'] = true : $data['is_popular'] = false;
        $data['is_hit'] == 'true' ? $data['is_hit'] = true : $data['is_hit'] = false;
        $data['is_new'] == 'true' ? $data['is_new'] = true : $data['is_new'] = false;

        $good = Good::create($data);

        foreach ($data['size_price'] as $datum){
            $size_perice = new Good_Size_Price;
            $size_perice -> good_id = $good->id;
            $size_perice -> portion_id = $datum['port_id'];
            $size_perice -> portion_price = $datum['port_price'];
            $size_perice -> save();
        }

        return Redirect::route('goods.index')->with('success', 'Товар добавлен');
    }

    public function update(Request $request,$id){
        /*$this->validate($request, [
            'url' => 'unique:goods',
          ]);*/
        
        $data = $request->except(['_token']);
        
        if(isset($data['ingredient_id'])){
            $data['ingredient_id'] = json_encode($data['ingredient_id']);
        }
         else {
            $data['ingredient_id'] = '';
        }
        
        if(isset($data['ingredient_id_off'])){
            $data['ingredient_id_off'] = json_encode($data['ingredient_id_off']);
        }
        else {
            $data['ingredient_id_off'] = '';
        }
        
        if(isset($data['ingredient_id_del'])){
            $data['ingredient_id_del'] = json_encode($data['ingredient_id_del']);
        }
        else {
            $data['ingredient_id_off'] = '';
        }
        //dd((string)$data['ingredient_id_off']);
        
        if(isset($data['recommended_id'])){
            $data['recommended'] = json_encode($data['recommended_id']);
        }
         else {
            $data['recommended'] = '';
        }
        
        $data['is_popular'] == 'true' ? $data['is_popular'] = true : $data['is_popular'] = false;
        $data['is_hit'] == 'true' ? $data['is_hit'] = true : $data['is_hit'] = false;
        $data['is_new'] == 'true' ? $data['is_new'] = true : $data['is_new'] = false;
        $data['activation'] == 'true' ? $data['activation'] = true : $data['activation'] = false;
        
        Good::all()->find($id)->update($data);

        Good_Size_Price::where('good_id',$id)->delete();

        foreach ($data['size_price'] as $datum){
            $size_perice = new Good_Size_Price;
            $size_perice -> good_id = $id;
            $size_perice -> portion_id = $datum['port_id'];
            $size_perice -> portion_price = $datum['port_price'];
            $size_perice -> save();
        }

        return Redirect::route('goods.index')->with('success', 'Товар обновлен');
    }

    public function edit($id){

        return view(User::UserRoleName(Auth::user()->id).'.goods.edit',
            [
                'good' => Good::all()->find($id),
                'categories' => Category::all(),
                'ingredients' => Ingredient::all(),
                'recommendeds' => Recomend::all(),
                'portions' => Good_Size_Price::where('good_id',$id)->get(),
                'preferences' => Preference::all(),
                'medias' => Mediafile::all()
            ]
        );
    }

    public function destroy($id){
        Good::all()->find($id)->delete();
        return Redirect::route('goods.index')->with('success', 'Товар удален');
    }

}
