<?php

namespace App\Http\Controllers\Superadmin;

use App\Models\Category;
use App\Models\Good;
use App\Models\Good_Size_Price;
use App\Models\Mediafile;
use App\Models\Portion;
use App\Models\Ingredient;
use App\Models\Setting;
use App\Models\Recomend;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ApiController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function get_potion(){
        return json_encode(Portion::all());
    }
    
    public function get_ingridients(){
        return json_encode(Ingredient::all());
    }
    
    public function get_recommendeds(){
        return json_encode(Recomend::all());
    }
    
    public function setting(){
        $medias = Mediafile::all();
        $setting = Setting::all()->find(1);
        $sliders = json_decode($setting->slider);
        $socials = json_decode($setting->social);
        $phones  = json_decode($setting->phone);
        $work  = json_decode($setting->work);
        $seo = json_decode($setting->seo);
        return view(User::UserRoleName(Auth::user()->id).'.setting', compact('medias','sliders','socials','phones','work','setting','seo'));
    }

    public function settingUpdate(Request $request){
        $data = $request->except(['_token']);
        $data['slider'] = json_encode($data['slider']);
        $data['social'] = json_encode($data['social']);
        $data['phone'] = json_encode($data['phone']);
        $data['work'] = json_encode($data['work']);
        $data['seo'] = json_encode($data['seo']);
        Setting::all()->find(1)->update($data);
        return Redirect::back()->with('success', 'Настройки сохранены');
    }

    public function getCategories(){
        $cat = Category::all();
        $json = json_encode($cat);
        return $json;
    }

    public static function getGoodAttr($id){
        $good = Good::all()->find($id);
        return [
            'category' => $good->category_id,
            'title' => $good->title
        ];
    }

    public function getCategoryGoods($id){
        return json_encode(Good::where('category_id', $id)->get());
    }

    public function getCategorySize(){
        return json_encode(Portion::all());
    }

    public static function getPortioninSezeId($id){
        $size = Good_Size_Price::all()->find($id);
        return [
            'portion' => $size->portion_id,
            'good_id' => $size->good_id,
            'price' => $size->portion_price
        ];
        }
}