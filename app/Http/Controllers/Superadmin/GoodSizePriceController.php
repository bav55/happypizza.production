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

class GoodSizePriceController extends Controller
{

    public function index(Request $request){

        $gsp = Good_Size_Price::select('*');

        $gsp = $gsp->paginate('15');
        return view(User::UserRoleName(Auth::user()->id).'.gsp.index', compact('gsp') );
    }

    public function create(){
  /*
        return view(User::UserRoleName(Auth::user()->id).'.goods.create',
            [
                'categories' => Category::all(),
                'ingredients' => Ingredient::all(),
                'portions' => Portion::all(),
                'preferences' => Preference::all(),
                'medias' => Mediafile::all()
            ]
        );
  */
    }

    public function store(Request $request){
/*
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
*/
    }

    public function update(Request $request,$id){

        $gsp = Good_Size_Price::find($id);
        $gsp->frontpad_article = $request->input('frontpad_article');
        $gsp->frontpad_title = $request->input('frontpad_title');
        $gsp->save();
        return Redirect::route('frontpad.index')->with('success', 'Товар обновлен');
    }

    public function edit($id){

        return view(User::UserRoleName(Auth::user()->id).'.gsp.edit',
            [
                'gsp' => Good_Size_Price::all()->find($id),
            ]
        );
    }

    public function destroy($id){
/*
        Good::all()->find($id)->delete();
        return Redirect::route('goods.index')->with('success', 'Товар удален');
*/
    }
    public function sync(){
        $gsp = Good_Size_Price::select('*');
        $params = ['secret' => 'ihYN4HbYFGnGkdhB4ezbhBG7KsTQr4ZDaGb4deKHN3d35nnYyNZEbsBNKfr49as9Gy4NBDhbrn4hEe52TQsY7SyF3Ny2QQ2i8QZze7ByhsFQzzBe9S37AiBkZZaBA2KyDyTGrf5BAzbZTE4TiSQH5dYR4YdnHQKa9tGnDBR32SNGhErti54b8NS2zZb7AN7z7ENz5riS82kfsDBDysEt6ies7hktYfSRNtbFKniGazQs3dThzkDrzHHtSY'];
        $frontpad_url = 'https://app.frontpad.ru/api/index.php?get_products';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $frontpad_url);
        curl_setopt($ch, CURLOPT_FAILONERROR, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        $result = curl_exec($ch);
        curl_close($ch);
        $data = json_decode($result,1);
        //dd($data);
        if($data['result'] == 'success'){
            $frontpad_products = [];
            //$gsp = Good_Size_Price::all();
            $gsp = Good_Size_Price::join('goods', 'goods.id', '=', 'good__size__prices.good_id')->orderBy('goods.title','desc')->select('good__size__prices.*')->with('good')->get();
            //dd($gsp);
            for($i = 0; $i < count($data['product_id']); $i++){
                $frontpad_products[$data['product_id'][$i]] = ['product_id' => $data['product_id'][$i], 'name' => $data['name'][$i], 'price' => $data['price'][$i]];
            }
            //dd($frontpad_products);
            foreach($gsp as $key => $gsp_item){
                $product_name = $gsp_item->getGoodName($gsp_item->good);
                $portion_name = $gsp_item->getPortionName($gsp_item->portion);
                if(isset($gsp_item->good->category)) $category_name = Category::getCategoryName($gsp_item->good->category);
                //preg_match_all('/[а-яА-Я0-9]+/u', $product_name.' '.$portion_name, $site_str, PREG_SET_ORDER, 0);
                $site_str = explode(' ', str_replace(['.',',','(',')'],'',mb_strtoupper($product_name.' '.$portion_name, 'UTF-8')));
                if($category_name == "Закуски"){
                    echo 'закуски!';
                }
                foreach($frontpad_products as $article => $frontpad_product){
                    //preg_match_all('/[а-яА-Я0-9]+/u', $frontpad_product['name'], $frontpad_str, PREG_SET_ORDER, 0);
                    $frontpad_str = explode(' ', str_replace(['.',',','(',')'],'',mb_strtoupper($frontpad_product['name'],'UTF-8')));
                    $key1 = array_search('ТРАДИЦ', $frontpad_str);
                    if($key1 != false) $frontpad_str[$key1] = 'ТРАДИЦИОННОЕ';
                    $arr = array_intersect($site_str, $frontpad_str);
                    if((count($arr) == count($frontpad_str) && $frontpad_product['price'] > 0)
                    || ($category_name != "Пицца" && $category_name != "На компанию" && $frontpad_product['price'] > 0 && count($arr) == count($frontpad_str) -1 and count($arr) > 1)
                    ){
                        $gsp_found = Good_Size_Price::find($gsp_item->id);
                        $gsp_found->frontpad_article = $frontpad_product['product_id'];
                        $gsp_found->frontpad_title = $frontpad_product['name'];
                        //$gsp->portion_price = $frontpad_product['price'];
                        $gsp_found->save();
                        //break;
                    }
                }
            }

        }


        return view(User::UserRoleName(Auth::user()->id).'.gsp.sync', compact('gsp') );
    }

}
