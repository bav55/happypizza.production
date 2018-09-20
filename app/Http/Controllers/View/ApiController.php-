<?php

namespace App\Http\Controllers\View;

use App\Models\Good;
use App\Models\Good_Size_Price;
use App\Models\Ingredient;
use App\Models\Portion;
use App\Models\PromoCod;
use App\Models\Setting;
use App\Models\Vote;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    public function getPortionSizePrice(Request $request){
        if (!empty($_SESSION['cart'][$request->good_id][$request->size_id])){
            $_SESSION['cart'][$request->good_id][$request->size_id] = array(
                'good' => array(
                    'good_id' => $request->good_id,
                    'size_id' => $request->size_id,
                    'count' => $_SESSION['cart'][$request->good_id][$request->size_id]['good']['count'] + 1
                )
            );
            unset($_SESSION['cart'][$request->good_id][$request->old_size]);
            CartController::calculatAction();
        } else {
            unset($_SESSION['cart'][$request->good_id][$request->old_size]);
            $_SESSION['cart'][$request->good_id][$request->size_id] = array(
                'good' => array(
                    'good_id' => $request->good_id,
                    'size_id' => $request->size_id,
                    'count' => $request->count
                )
            );
            CartController::calculatAction();
            return Good_Size_Price::all()->find($request->size_id)->portion_price;
        }
    }

    public function goodReprice(Request $request){
        return Good_Size_Price::all()->find($request->size_id)->portion_price;
    }

    public static function getGoodPortions($id){
        $portions = Good_Size_Price::where('good_id',$id)->get();
        $str = null;
        foreach ($portions as $portion){
            $str .= '<option value="'.$portion->id.'">'.self::getPortionName($portion->portion_id).'</option>';
        }
        return $str;
    }

    public static function getPortionNameWithGood($id){
        return Portion::all()->find(Good_Size_Price::all()->find($id)->portion_id);
    }

    public static function getPromoSum($id){
        $promo = PromoCod::all()->find($id);
        if ($promo->is_percent == true){
            return $promo->sum.' %';
        } elseif ($promo->is_sum){
            return $promo->sum.' ТГ';
        }
    }

    public static function getGoodfiresPortionPrice($id){
        $portions = Good_Size_Price::where('good_id',$id)->get();
        return $portions[0]->portion_price;
    }

    public static function getPortionName($id){
        return Portion::all()->find($id)->title;
    }

    public static function PortionSizePrice($id){
        return Good_Size_Price::all()->find($id)->portion_price;
    }

    public static function getGoodPortionSizePrice($good, $portion){
        return Good_Size_Price::where('good_id', $good)->where('portion_id',$portion)->get();
    }

    public static function getGood($id){
        $good = Good::all()->find($id);
        $arr = [
            'title' => $good->title,
            'content' => $good->content,
            'is_hit' => $good->is_hit,
            'is_new' => $good->is_new,
            'category_id' => $good->category_id,
            'image' => $good->image,
            'user_id' => $good->user_id,
            'portion_id' => $good->portion_id
        ];
        return $arr;
    }

    public static function thisConstract($id){
        if(self::getGood($id)['user_id'] != null){
//            $rotion = self::getAccountGoodIng(self::getGood($id)['portion_id']);
            $portion = self::getGood($id)['portion_id'];
            $portion = json_decode($portion,true);
            $str = 'Дополнительные ингредиенты<br>';
            foreach ($portion as $value){
                $str .= '<b>'.self::getIngrediet($value['id'])['title'] .'</b>____'.$value['port'].'<br>';
            }
            //dd($str);
            return $str;
        } else {
            return 'Стандартные';
        }
    }

    public static function getCartGoodSelected($good_id, $portion_id){
        $portions = Good_Size_Price::where('good_id',$good_id)->get();
        $str = null;
        foreach ($portions as $portion){
            if ($portion->id == $portion_id) {
                $str .= '<option selected value="'.$portion->id.'">'.self::getPortionName($portion->portion_id).'</option>';
            } else {
                $str .= '<option  value="'.$portion->id.'">'.self::getPortionName($portion->portion_id).'</option>';
            }
        }
        return $str;
    }

    public static function getIngrediet($id){
        $data = Ingredient::all()->find($id);
        return [
            'title' => $data->title,
            'image' => asset($data->image),
            'part_1' => $data->part_1,
            'part_2' => $data->part_2
        ];
    }

    public function getConstractData($id){
        $good = Good::all()->find($id);
        $ingredient = null;
        $add_ingredient = null;
        if($good->ingredient_id != null ){
            
            if (!empty($good->ingredient_id_off)){
                $ingredient_id_off = json_decode($good->ingredient_id_off);
            }
            else {
                $ingredient_id_off = array();
            }
            
            if (!empty($good->ingredient_id_del)){
                $ingredient_id_del = json_decode($good->ingredient_id_del);
            }
            else {
                $ingredient_id_del = array();
            }
            
            foreach (json_decode($good->ingredient_id) as $val){
                $ingredient .= '
            <div class="row ingredient-item default-ingredient-item" style="margin-bottom: 5px;">
                <div class="col-xs-12 col-md-9">
                    <span class="ingredient-name"><img src="'. self::getIngrediet($val)['image'] .'" width="24">'. self::getIngrediet($val)['title'] .'</span>
                    <div class="ingredient-portions">';
                $ingredient .= '<a href="#" onclick="addIngredient('. $val .', 1, this, false ); return false;" onmouseover="ing_hover(this);" data-available-ingredient="'.$val.'1" data-price="0" class="active">1 порция</a>';
                if(self::getIngrediet($val)['part_2'] != 0){
                    if(!in_array($val, $ingredient_id_off) || self::getIngrediet($val)['part_2'] != 0){

                            $ingredient .= ' <a href="#" onclick="addIngredient('. $val .', 2, this, false ); return false;" onmouseover="ing_hover(this);" data-available-ingredient="'.$val.'2"  data-price="'. self::getIngrediet($val)['part_2'] .'">2 порции</a>';
                    }
                }
                    $ingredient .= '</div>
                </div>
                <div class="col-xs-10 col-xs-offset-1 col-md-2 col-md-offset-0"><span class="ingredient-price"><span></span></span></div>';
                if(in_array($val, $ingredient_id_del)){
                    $ingredient .='<div class="col-xs-1"><span class="ingredient-remove pull-right"><a href="#" onclick="removeIngredient(this, '. $val .', false); return false;">x</a></span></div>';
                }    
            $ingredient .='</div>';
            }
        }

        if ($good->add_ingredient_id != null){
            foreach (json_decode($good->add_ingredient_id) as $val){
                $add_ingredient .= '
            <div class="row ingredient-item" style="margin-bottom: 5px;">
                <div class="col-xs-12 col-md-9">
                    <span class="ingredient-name"><img src="'. self::getIngrediet($val)['image'] .'" width="24">'. self::getIngrediet($val)['title'] .'</span>
                    <div class="ingredient-portions">
                        <a href="#" onclick="addIngredient('. $val .', 1, this, false ); return false;" onmouseover="ing_hover(this);" data-available-ingredient="'.$val.'1" data-price="'. self::getIngrediet($val)['part_1'] .'">1 порция</a>';
                    if(self::getIngrediet($val)['part_2'] != 0){    
                      $add_ingredient .=  '<a href="#" onclick="addIngredient('.$val.', 2, this, false); return false;" onmouseover="ing_hover(this);" data-available-ingredient="'.$val.'2" data-price="'. self::getIngrediet($val)['part_2'] .'">2 порции</a>';
                    }        
                  $add_ingredient .=  '</div>
                </div>
                <div class="col-xs-10 col-xs-offset-1 col-md-2 col-md-offset-0"><span class="ingredient-price"><span></span></span></div>
            </div>';
                
            }
        }

        $arr = [
            'ingredient' => $ingredient,
            'add_ingredient' => $add_ingredient,
            'count' => count(json_decode($good->ingredient_id))
        ];
        return json_encode($arr);
    }

    public function customGoodSave(Request $request){
        $data = $request->except(['_token']);
        //print_r($data);exit();
        $string = null;
        $str = array();
        $count_port = null;
        $arr = json_decode($data['json'], true);
        $good = Good::all()->find($request->good_id);
        foreach (json_decode($good->ingredient_id) as $key => $value){
            $port = $arr[$value]['port'];
            //$port = ($port == '0' ?  1 : $port);
            
            $str[] = array(
                'id' => $value,
                'port' => $port
            );
        }
        //print_r($str);
        foreach (json_decode($good->add_ingredient_id) as $key => $value){
            $port = $arr[$value]['port'];
            if ($port != 0){
                $str[] = array(
                    'id' => $value,
                    'port' => $port
                );
            }
        }
        //print_r($str);exit();
        foreach($str as $value){
            $count_port += $value['port'];
        }
        if ($count_port > 15) {
            $response = new Response();
            return $response->setStatusCode(413);
        }
        $data['portion_id'] = json_encode($str);
        
        if (isset(Auth::user()->id)) {
        $data['user_id'] = Auth::user()->id;
        }
        else {
            //$data['user_id'] = 0;
        }
        $data['size_id'] = Good_Size_Price::all()->find($data['size_id'])->portion_id;

        $good = Good::create($data);
        $size = Good_Size_Price::create( ['good_id' => $good->id, 'portion_id' => $data['size_id'], 'portion_price' => $data['price'] ] );

        CartController::staticAddToCart($good->id, $size->id, '1');

        $data['size_id'] = $size->id;

        Good::all()->find($good->id)->update(['size_id' => $data['size_id']]);
    }

    public static function getAccountGoodIng($arr){
        $arr = json_decode($arr, true);
        $str = null;
        $count = count($arr);
        $i = 1;
        foreach ($arr as $value) {
            if(isset(Ingredient::all()->find($value['id'])->title)){
                $str .= Ingredient::all()->find($value['id'])->title;
            }
            $str .= $count != $i ? ', ' : '';
            $i++;
        }
        return $str;
    }

    public function customGoodRemove(Request $request){
        if ( isset($_SESSION['cart'][$request->id]) ){
            $response = new Response();
            return $response->setStatusCode(413,json_encode('Не возможно удалить. Товар в корзине.'));
        }
        Good::all()->find($request->id)->delete();
        return json_encode('Товар удален');
    }

    public function sendMail(Request $request){
        $data = $request->except(['_token']);
        $str = null;
        foreach ($data['input'] as $key => $value){
            $str .= '<p><b>'.$key.'</b>:'.$value.'</p>';
        }

        $to = Setting::all()->find(1)->email; /*Укажите адрес, га который должно приходить письмо*/
        $sendfrom   = "mail@happypizza.kz"; /*Укажите адрес, с которого будет приходить письмо, можно не настоящий, нужно для формирования заголовка письма*/
        $headers  = "From: " . strip_tags($sendfrom) . "\r\n";
        $headers .= "Reply-To: ". strip_tags($sendfrom) . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html;charset=utf-8 \r\n";
        $subject =  $data['title'];
        $message = $str;
        $send = mail ($to, $subject, $message, $headers);
        if ($send == 'true')
        {
            echo '<p>Спасибо! Ваше сообщение отправлено!</p>';
        }
        else
        {
            echo '<p class="fail"><b>Ошибка. Сообщение не отправлено! <br> попробуйте позже</b></p>';
        }
    }

    public function vacanciesSend(Request $request){
        $data = $request->except(['_token']);
        $str = null;
        foreach ($data['name'] as $key => $value) {
            $str .= $key.' => "'.$value .'"<br>';
        }

        $to = Setting::all()->find(1)->email; /*Укажите адрес, га который должно приходить письмо*/
        $sendfrom   = "mail@happypizza.kz"; /*Укажите адрес, с которого будет приходить письмо, можно не настоящий, нужно для формирования заголовка письма*/
        $headers  = "From: " . strip_tags($sendfrom) . "\r\n";
        $headers .= "Reply-To: ". strip_tags($sendfrom) . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html;charset=utf-8 \r\n";
        $subject =  $data['title'];
        $message = $str;
        $send = mail ($to, $subject, $message, $headers);
        if ($send == 'true')
        {
            echo '<p id="success" style="padding-top: 10px;">Ваша заявка отправлена!</p>';
        }
        else
        {
            echo '<p id="success" style="padding-top: 10px;" class="fail"><b>Ошибка. Сообщение не отправлено! <br> попробуйте позже</b></p>';
        }
    }

    public static function getVoteMark($id){
        $vote = Vote::all()->find($id);
        $count = 0;
        $str = null;
        foreach ($vote->getVoteList as $item){
            $count += $item->vote;
        }
        foreach ($vote->getVoteList as $value){
            $percent = ( $value->vote * 100 )/$count;
            $percent = substr($percent,0, strpos($percent,'.')+2);
            $str .= '
                    <div class="history-item">
                        <div class="history-item-text">
                            <p>'. $value->title .'</p>
                            <p style="font-size: 12px; opacity: .8;">'. $percent .'%, '. $value->vote .' голосов</p>
                        </div>
                        <div class="history-item-line">
                            <div class="out-percent">'. $percent .'%</div>
                            <div class="percent" style="width: '. $percent .'%;"></div>
                        </div>
                    </div>';
        }
        return $str;
    }

}
