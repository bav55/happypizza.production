<?php

namespace App\Http\Controllers\View;

use App\Models\Delivery_Type;
use App\Models\Delivery_Zone;
use App\Models\Order;
use App\Models\Pay_Type;
use App\Models\PromoCod;
use App\Models\Setting;
use App\Models\user_bonus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Good_Size_Price;
use App\Models\Action;
use App\Models\ActionPickup;
use App\Http\Controllers\Superadmin\ApiController;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class CartController extends Controller
{

    public function cartPage(){
//        dump($_SESSION['cart']);
        $goods = isset($_SESSION['cart']) ? $_SESSION['cart'] : null;
        $promo = count(PromoCod::all());
        self::calculatAction();
        $present = isset($_SESSION['present']) ? $_SESSION['present'] : null;
        return view('view.cart', compact('goods','promo','present'));
    }

    public function checkoutCart(){
        if (isset($_SESSION['cart'])) {
            $delivery = Delivery_Type::all();
            $pay = Pay_Type::all();
            $bonus = self::getUserBonus();
            return view('view.checkout', compact('delivery', 'pay', 'bonus'));
        }
        else {
            return Redirect::route('cart');
        }
    }

    public static function getUserBonus(){
        if(Auth::check()){
            $user_bonus = user_bonus::where('user_id',Auth::user()->id)->get();
            if($user_bonus->toArray()){
                $cart_sum = self::getCartSum()['sum'];
                $cart_percent = $cart_sum/2;
                if ($cart_percent >= $user_bonus[0]->bonus){
                    return $user_bonus[0]->bonus;
                } elseif ($cart_percent < $user_bonus[0]->bonus){
                    return ($user_bonus[0]->bonus-($user_bonus[0]->bonus-$cart_percent));
                }
            } else {
                user_bonus::create(['user_id' => Auth::user()->id]);
                self::getUserBonus();
            }
        } else {
            return null;
        }
    }

    public function orderCreate(Request $request){
        $data = $request->except(['_token']);
        $cart_sum = CartController::getCartSum()['sum'];
        $bonus_percent = Setting::all()->find(1)->bonus_percent;

        if (isset($_SESSION['promo'])) {
            $promo_cod = PromoCod::all()->find($_SESSION['promo']['code_id']);
            $promo_cod->update([
                'limit' => $promo_cod->limit - 1,
                'apply' => $promo_cod->apply + 1
            ]);
            $data['extra']['promo_cod'] = $_SESSION['promo']['code_id'];
        }
        if ($data['delivery_type_id'] == 2) {
            $data['delivery_address'] = json_encode($data['delivery']);
        }
        $cach_back = null;
       
            /*--- Добавление доп подарков в зависимости от заказов ---*/
            //$action_pickup_obj = ActionPickup::all()->find(1); 
            $action_pickup_obj = ActionPickup::where('date_at','<',date('Y-m-d').'00:00:00')->where('date_to','>',date('Y-m-d').'23:59:59')->get();
            foreach ($action_pickup_obj as $pickup) {
           //dd($pickup->id);exit();
                if($pickup['is_present'] == 1){
                    if ($pickup['pickup'] == 1) { // При галке на "Самовывоз?" 
                          //echo 'pickup';exit();
                         $user_order_delivery_1 = Order::where('phone', $data['phone'])->where('delivery_type_id', 1)->get();

                         if ((count($user_order_delivery_1)+1)%$pickup->days==0){ //days кратность (В каждом n-м заказе) %3==0
                            $_SESSION['present'][] = json_decode($pickup->total, true);
                         }
                    }
                    else {
                        $user_order_count = Order::where('phone', $data['phone'])->get();
                        if ((count($user_order_count)+1)%$pickup->days==0){ //days кратность (В каждом n-м заказе) %3==0
                            $_SESSION['present'][] = json_decode($pickup->total, true);
                         }
                    }
                }
            }
            /*$user_order_delivery_2 = Order::where('phone', $data['phone'])->get();
            
            print_r(count($user_order_delivery_2));
            print_r($_SESSION['present']);
            exit();*/
            // $actions = Action::where('date_at','<',date('Y-m-d').'00:00:00')->where('date_to','>',date('Y-m-d').'23:59:59')->get();

            /*--- End ---*/
          
        
        if(Auth::check()){
            
            $user_order = Order::where('user_id', Auth::user()->id)->where('delivery_type_id','1')->get();
            /*----- Если заказывает в течения 1 час на одну и туже сумму, бонус не начисляеться -------*/
            $old_order = Order::where('user_id', Auth::user()->id)->whereRaw('created_at > SUBDATE(now(), INTERVAL 1 HOUR)')->get();
            
            $bonus_off = FALSE;
            foreach($old_order AS $order){
                if($order->order_sum == (int)$cart_sum){
                    $bonus_off = TRUE;
                }
            }
            /*------------*/
            
           /* if (count($user_order) > 0 && count($user_order)%3==0 && !isset($_SESSION['add_present_action'])){
                $_SESSION['present'][] = ["count" => "1","good" =>"16"];
                $_SESSION['add_present_action'] = true;
            }*/
            $user_bonus = user_bonus::where('user_id',Auth::user()->id)->get();
            
            
            
            if (isset($request->extra['bonus']) && $request->extra['bonus'] != null && !$bonus_off){
                $data['apply_bonus_sum'] = $request->extra['bonus'];
                $apply_bonus_sum = $data['apply_bonus_sum'];
                $data['order_sum'] =  (int)$cart_sum - (int)$apply_bonus_sum;
                $user_end_bonus = (int)$user_bonus[0]->bonus - (int)$apply_bonus_sum;
                $cach_back = (int)$data['order_sum']/100 * (int)$bonus_percent;
                $data['bonus_sum'] = $user_end_bonus + $cach_back;
                $data['bonus_sum'] = floor($data['bonus_sum']);
                $data['extra']['cashback'] = $cach_back;
            } elseif(!$bonus_off) {
                $cach_back = (int)$cart_sum/100 *(int)$bonus_percent;
                $data['bonus_sum'] = $cach_back;
            }
            else {
                $cach_back = 0;
                $data['bonus_sum'] = $user_bonus[0]->bonus;      
            }

            if ($data['pay_type_id'] == 1){
                user_bonus::all()->find($user_bonus[0]->id)->update(['bonus' => $data['bonus_sum']]);
            }
        }
        if ( !isset($data['order_sum']) ){
            $data['order_sum'] = $cart_sum;
        }

        $data['order_id'] = 'E-'.date("mdyHsi");
        $data['good_list'] = json_encode($_SESSION['cart']);
        if(isset($_SESSION['present'])){
            $data['present_list'] = json_encode($_SESSION['present']);
        }
        $data['extra'] = json_encode($data['extra']);
        if(Auth::check()){
            $data['user_id'] = Auth::user()->id;
        }
        
        if ( !isset($data['email']) ){
            $data['email'] = '';
        }
        
        if ( !isset($data['delivery_zone']) ){
            $data['delivery_zone'] = '';
        }
        
        
        if ($data['pay_type_id'] == 1){
            $data['is_paid'] = true;
            session_unset();
        }
        
        

        $order = Order::create($data);
       if(Auth::check()){
           if (!$bonus_off) {
                $order->getBonusLog()->create([
                    'order_id' => $order->id, 
                    'user_id' => $order->user_id,
                    'bonus' => $cach_back
                ]);
           }
       }        
        $return = array(
            'order_id' => $order->id,
            'order_sum' => $order->order_sum,
            'email' => $order->email,
            'order_number' =>  $order->order_id,
            'pay_type' => $order->pay_type_id,
            'pay_date' => Carbon::parse($order->created_at)->format('d.m.Y H:i')
        );

        /* for send mail */
        $order_mail = $return;
        
        $pay = Pay_Type::find($order->pay_type_id);
        $delivery = Delivery_Type::find($order->delivery_type_id);
        $deliveryZone = Delivery_Zone::find($order->delivery_zone_id);
          
        $order_mail['name'] = $data['name'];
        $order_mail['phone'] = $data['phone'];
        $order_mail['payment_type'] = $pay->title;
        
        $order_mail['delivery_type_id'] = $order->delivery_type_id;
        $order_mail['delivery_type'] = $delivery->title;
       // $order_mail['delivery_zone'] = $deliveryZone->title;
        $order_mail['delivery_address'] = json_decode($order->delivery_address);
        
        $order_mail['bonus'] = $order->bonus_sum;
        $order_mail['time'] = $request['extra']['time'];
        $order_mail['money'] = $request['extra']['money'];
        $order_mail['comment'] = $request['extra']['comment'];
        
        $order_mail['goods'] = json_decode($order->good_list);
        
        $order_mail['order_sum'] = $order->order_sum;
        $order_mail['bonus_sum'] = $order->bonus_sum;
        $order_mail['apply_bonus_sum'] = $order->apply_bonus_sum;
       // print_r($order_mail);
        /* END for send mail */
//print_r($order_mail);exit();
        if ($data['pay_type_id'] == 1){
            self::SendMail($order->id, $order_mail);
        }

        if (Auth::check() && $data['pay_type_id'] == 1){
            $sms_messagedata = 'Ваш+заказ+'.$order->order_id.'+оформлен+на+сайте+happypizza.kz.Зачислено'.$cach_back.'+баллов.+Всего+'.$order->bonus_sum.'+баллов.';
            self::SendSMS($data['phone'], $sms_messagedata);
        }
        elseif (Auth::guest() && $data['pay_type_id'] == 1){
            $sms_messagedata = 'Спасибо за заказ! Ваша заявка в обработке. Для подтверждения заказа с вами свяжется оператор.';
            self::SendSMS($data['phone'], $sms_messagedata);
        }
//print_r($data);exit();
        
        return json_encode($return);
    }
    
    public function sensMessagePay(Request $request){
        $data = $request->except(['_token']);
        
        $order_id = $data['order_id'];
        
        $order = Order::where('id', $order_id)->get();
        
        $pay = Pay_Type::find($order[0]->pay_type_id);
        $delivery = Delivery_Type::find($order[0]->delivery_type_id);
        $deliveryZone = Delivery_Zone::find($order[0]->delivery_zone_id);
        
        $extra = json_decode($order[0]->extra);
        //print_r($extra);exit();
        $order_mail['name'] = $order[0]->name;
        $order_mail['phone'] = $order[0]->phone;
        $order_mail['payment_type'] = $pay->title;
        
        $order_mail['delivery_type_id'] = $order[0]->delivery_type_id;
        $order_mail['delivery_type'] = $delivery->title;
       // $order_mail['delivery_zone'] = $deliveryZone->title;
        $order_mail['delivery_address'] = json_decode($order[0]->delivery_address);
        
        $order_mail['bonus'] = $order[0]->bonus_sum;
        $order_mail['time'] = $extra->time;
        $order_mail['money'] = $extra->money;
        $order_mail['comment'] = $extra->comment;
        
        $order_mail['goods'] = json_decode($order[0]->good_list);
        
        $order_mail['order_sum'] = $order[0]->order_sum;
        $order_mail['bonus_sum'] = $order[0]->bonus_sum;
        $order_mail['apply_bonus_sum'] = $order[0]->apply_bonus_sum;
        
        self::SendMail($order[0]->id, $order_mail);
        
    }
    
    public function approvedOrder(Request $request){
        $invoiceId = $request->InvoiceId;
        $TransactionId = $request->TransactionId;
        $order = Order::all()->find($invoiceId);
        $order->update(['is_paid' => true, 'transaction_id' => $TransactionId]);
        self::SendMail($invoiceId);
        if (Auth::check()){
            $sms_messagedata = 'Ваш+заказ+'.$order->order_id.'+оформлен+на+сайте+happypizza.kz.+Всего+'.$order->bonus_sum.'+баллов.';
            self::SendSMS($order->phone, $sms_messagedata);
        }
        elseif (Auth::guest()){
            $sms_messagedata = 'Ваш+заказ+'.$order->order_id.'+оформлен+на+сайте+happypizza.kz';
            self::SendSMS($order->phone, $sms_messagedata);
        }
        $code = array('code' => 0);
        //session_unset();
        return json_encode($code);
    }

    public static function SendSMS($phone, $text){
       $user_number = $phone;
        $sms_username = 'happyhttp';
        $sms_password = 'LbqEOC4JH';
        $sms_recipient = preg_replace('~[^0-9]+~','',$user_number);
        $sms_originator = 'Заказ+оформлен';
        /*$postData = array(
            'action' => 'sendmessage',
            'username' => 'happyhttp',
            'password' => 'oQ4nSFwv7',
            'recipient' => preg_replace('~[^0-9]+~','',$phone),
            'messagetype' => 'SMS:TEXT',
            'messagedata' => $text

        );*/
        $postData = array(
            'action' => 'sendmessage',
            'username' => 'happyhttp',
            'password' => 'LbqEOC4JH',
            'recipient' => preg_replace('~[^0-9]+~','',$phone),
            'messagetype' => 'SMS:TEXT',
            'messagedata' => $text

        );
        $_SESSION['sms_message'][] = '<iframe style="display:none;" src="http://212.124.121.186:9501/api?action=sendmessage&username='.$sms_username.'&password='.$sms_password.'&recipient='.$sms_recipient.'&messagetype=SMS:TEXT&originator='.$sms_originator.'&messagedata='.$text.'"></iframe>';
        //echo '<iframe style="display:none;" src="http://212.124.121.186:9501/api?action=sendmessage&username='.$sms_username.'&password='.$sms_password.'&recipient='.$sms_recipient.'&messagetype=SMS:TEXT&originator='.$sms_originator.'&messagedata='.$text.'"></iframe>';
        //echo '<iframe style="display:none;" src="http://kazinfoteh.org:9501/api?action=sendmessage&username='.$sms_username.'&password='.$sms_password.'&recipient='.$sms_recipient.'&messagetype=SMS:TEXT&originator='.$sms_originator.'&messagedata='.$text.'"></iframe>';
       /* $ch = curl_init('http://kazinfoteh.org:9501/api');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
        curl_exec($ch);*/
    }

    public static function SendMail($order_id, $order =''){
        //print_r($order);exit();
        $to = Setting::all()->find(1)->email; /*Укажите адрес, га который должно приходить письмо*/
        $to .=',gabit@trustylabs.kz,nadya_0910@mail.ru,bav55@ya.ru';
//        $to = 'ahmetbay.d@yandex.ru'; /*Укажите адрес, га который должно приходить письмо*/
        $sendfrom   = "mail@pizza.diyas.info"; /*Укажите адрес, с которого будет приходить письмо, можно не настоящий, нужно для формирования заголовка письма*/
        $headers  = "From: " . strip_tags($sendfrom) . "\r\n";
        $headers .= "Reply-To: ". strip_tags($sendfrom) . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html;charset=utf-8 \r\n";
        $subject =  'Zakaz online, ' . date('Y-m-d H:i');
        if (is_array($order)) {
            $delimiter = '-----------------------------' . "\n<br>";

            $html = '';
            $html .= 'Имя: ' . $order['name'] . "\n<br>";
            $html .= 'Телефон: ' . $order['phone'] . "\n<br>";

            $html .= $delimiter;
            
            $html .= 'Способ оплаты: ' . $order['payment_type'] . "\n<br>";

            $html .= $delimiter;
            $html .= 'Способ доставки: ' . $order['delivery_type']. "\n<br>";

            if ($order['delivery_type_id'] == 2) {
                //$html .= 'Район доставки: ' . $order['delivery_zone'] . "\n<br>";
                
               /* $html .= 'Улица: ' . $order['street'] . "\n";
                $html .= 'Дом: ' . $order['house'] . "\n";
                $html .= 'Квартира: ' . $order['apartment'] . "\n";
                $html .= 'Подъезд: ' . $order['square'] . "\n";
                $html .= 'Этаж: ' . $order['floor'] . "\n";
                $html .= 'Код домофона: ' . $order['code'] . "\n";*/
                
             foreach ($order['delivery_address'] as $key => $addres) {
                 $html .= $key.': ' . $addres . "\n<br>"; 
             }
                
                
                $html .= 'Когда доставить заказ: ' . $order['time'] . "\n<br>";
                if ($order['money']) {
                    $html .= 'Нужна сдача с: ' . $order['money'] . "\n<br>";
                }
            }

            $html .= $delimiter;
            $html .= 'Комментарий: ' . $order['comment'] . "\n<br>";

            $html .= $delimiter;
            
            foreach($order['goods'] as $good){
                foreach($good as $value){
                    

                        
                    $html .= \App\Http\Controllers\View\ApiController::getGood($value->good->good_id)['title'] . ' x ' . $value->good->count . ' - ' . \App\Http\Controllers\View\ApiController::getPortionNameWithGood($value->good->size_id)->title . "\n<br>";
               }
            }

            $html    .= $delimiter;
            $html    .= 'Сумма заказа: ' . $order['order_sum']. "\n<br>";
            
            if(!empty($order['apply_bonus_sum'])) {
                $html    .= 'Скидка: ' . $order['apply_bonus_sum']. "\n<br>";
            }
            if(!empty($order['bonus_sum'])) {
                $html    .= 'Остаток бонусных средств: ' . $order['bonus_sum']. "\n<br>";
            }
            $message = $html;
        }
        else {
            $message = 'На сайте оформлен новый заказ. id заказа '.$order_id;
        }
        
        //print_r($message);
        
        mail($to, $subject, $message, $headers);
    }

    public function applyCode($code){
        if ( !isset($_SESSION['promo']) ){
            $promo = PromoCod::where('title',$code)->get();
            if ($promo[0]->limit > 0){
                $_SESSION['promo'] = array( 'code_id' => $promo[0]->id );
                return $_SESSION['promo'];
            } else {
                $response = new Response();
                return $response->setStatusCode(403);
            }
        }

    }

    public function addToCart(Request $request){
        if (!empty($_SESSION['cart'][$request->good_id][$request->size_id])){
            $_SESSION['cart'][$request->good_id][$request->size_id] = array(
                'good' => array(
                    'good_id' => $request->good_id,
                    'size_id' => $request->size_id,
                    'count' => $_SESSION['cart'][$request->good_id][$request->size_id]['good']['count'] + 1
                )
            );
            echo 'Товар уже в корзине';
        }
        else {
            $_SESSION['cart'][$request->good_id][$request->size_id] = array(
                'good' => array(
                    'good_id' => $request->good_id,
                    'size_id' => $request->size_id,
                    'count' => $request->count
                )
            );
            echo 'Ваш товар добавлен в корзину';
        }
    }

    public static function staticAddToCart($good_id, $size, $count){
        $_SESSION['cart'][$good_id][$size] = array(
            'good' => array(
                'good_id' => $good_id,
                'size_id' => $size,
                'count' => $count
            )
        );
        return 'Ваш товар добавлен в корзину';
    }

    public function updateGoodCont(Request $request){
        $_SESSION['cart'][$request->good_id][$request->size_id]['good'] = array(
            'good_id' => $request->good_id,
            'size_id' => $request->size_id,
            'count' => $request->count
        );
        self::calculatAction();
        echo 'ok';
    }

    public function removeAtCart(Request $request){
        $good_arr = $_SESSION['cart'][$request->good_id];
        if (count($good_arr) >= 2){
            unset($_SESSION['cart'][$request->good_id][$request->size]);
        } else {
            unset($_SESSION['cart'][$request->good_id]);
        }
        self::calculatAction();
        echo 'Товар уделен из корзины';
    }

    public static function getCartGoodCount(){
        $count = 0;
        if (isset($_SESSION['cart'])){
            foreach ($_SESSION['cart'] as $key => $value){
                $count += count($value);
            }
        }
        return $count;
    }

    public static function getCartSum(){
        $summ = 0;
        $str = 0;
        $sum = 0;
        if (isset($_SESSION['cart'] )) {
            foreach ($_SESSION['cart'] as $key => $value){
                foreach ($value as $cart) {
                    $summ += (Good_Size_Price::all()->find($cart['good']['size_id'])->portion_price * $cart['good']['count']);
                }
            }
            if (isset($_SESSION['promo']) && $summ != 0){
                $code = PromoCod::all()->find($_SESSION['promo']['code_id']);
                if ($code->is_sum == 1){
                    $promo_price = $summ - $code->sum;
                }
                elseif ($code->is_percent == 1) {
                    $precent = (($summ * $code->sum)/100);
                    $promo_price = $summ - $precent;
                }
                $str = '<s>'.$summ.' ТГ</s>   '. $promo_price .' ТГ';
                $sum = $promo_price;
            } else {
                $str = $summ .' ТГ';
                $sum = $summ;
            }
            if ( isset($_SESSION['act_sum']) && count($_SESSION['act_sum']) > 0 ){
                //dump($_SESSION['act_sum']);
                $act_price = 0;
                $act_price = isset($promo_price) ? $promo_price : $summ;
                foreach ($_SESSION['act_sum'] as $act){
                    $act_price -= $act;
                }
                if ($summ != $act_price){
                    $str = '<s>'.$summ.' ТГ</s>   '. $act_price .' ТГ';
                    $sum = $act_price;
                } else {
                    $str = $summ .' ТГ';
                    $sum = $summ;
                }

            }
        }

        return [
            'str' => $str,
            'sum' => $sum
        ];

    }

    public static function calculatAction(){
        unset($_SESSION['act_sum']);
        unset($_SESSION['present']);
        unset($_SESSION['add_present_action']);
        unset($_SESSION['action_title']);

        $actions = Action::where('date_at','<',date('Y-m-d').'00:00:00')
            ->where('date_to','>',date('Y-m-d').'23:59:59')->get();

        if (isset($_SESSION['cart'])) {
            $cart = $_SESSION['cart'];
//            foreach ($actions as $action) {
//                //dump(json_decode($action->action));
//            }
//            //dump($cart);
            /*
            1. Один и тот же товар в одном и том же количестве не может учавствовать в разных акциях.
            2. В одной акции могут учавствовать несколько товаров из корзины.
            3. Все акции могут проходить одновременно, если есть соответствующие товары в корзине.
            4. Товары-конструкторы не участвуют в акции.

            ApiController::getPortioninSezeId($cart_v_v['good']["size_id"])['portion']; возвращает id порции
            */

            //Нормируем товар в корзине
            $cart_good = array();
            $cart_good_count = array();
            foreach ($cart as $cart_i => $cart_v) {
                //dump($cart_v);
                foreach ($cart_v as $cart_v_i => $cart_v_v) {
                    //dump($cart_v_v);
                    //$cart_good[]=$cart_v_v['good'];
                    $cart_good[] = array("good_id" => $cart_v_v['good']["good_id"], "size_id" => (string)ApiController::getPortioninSezeId($cart_v_v['good']["size_id"])['portion']);
                    $cart_good_count[] = $cart_v_v['good']["count"];
                }
            }
			
            /*
            echo 'Товар в корзине<br>';
            dump($cart_good);
			dump($cart_good_count);
            */

            //Нормируем товар в акциях
            $act_good = array();
            $act_good_count = array();
            $act_repeat = array();
            $act_id = array(); 
            $act_good_id_input = array(); //соотношение товар - ячейка
            $act_product_in_input_count = array(); //Колво товаров в инпуте
            $act_product_in_input_povtorenie_check = array(); //Включено ли повторение
            foreach ($actions as $keyAction => $action) {
                $act = json_decode($action->action, true);
                foreach ($act as $act_i => $cood) {
                    $good_id = json_decode($cood["good_id"], true);
                    $sizes_id = json_decode($cood["sizes_id"], true);
                    //dump($good_id);
                    foreach ($good_id as $good_id_i => $good_id_v) {
                        foreach ($sizes_id as $sizes_id_i => $sizes_id_v) {
                            $act_good[] = array("good_id" => (string)$good_id_v, "size_id" => (string)$sizes_id_v);
                            $act_good_count[] = $cood["count"];
                            
                            $act_good_id_input[$action->id][(string)$good_id_v.'_'.(string)$sizes_id_v]=$act_i;
                            $act_product_in_input_count[$action->id][$act_i] = $cood["count"];
                            if(isset($cood["checkbox"])){
                                $act_product_in_input_povtorenie_check[$action->id][$act_i] = $cood["checkbox"];
                            }
                            if(isset($cood["checkbox"]) && $cood["checkbox"]=='on') $act_repeat[]=1;
                            else $act_repeat[]=0;
                            //echo $action->id;
                            $act_id[] = $action->id;
                        }
                    }

                }
            }
            //dump($act_product_in_input_count);
            //dump($act_product_in_input_povtorenie_check);exit();
//dd($act_good_id_input);
            /*
            echo 'Товар в акциях<br>';
            dump($act_good);
			dump($act_good_count);
			dump($act_repeat);
            */

            //Ищем совпадения товаров из корзины в акциях
            $mtch = array();
            $mtch_act_sum = array();
            $mtch_cart_sum = array();
            $act_sum = array();
            $act_good_repeat = array();
            
            foreach ($act_good as $act_good_i => $act_v) {
                /*
                echo '<br>Акция<br>';
                dump($act_v);
                */
                $act_sum[$act_id[$act_good_i]][$act_v['good_id'].'_'.$act_v['size_id']]=(int)$act_good_count[$act_good_i];
                
                foreach ($cart_good as $cart_good_i => $cart_v) {
                    /*
                    echo '<br>Товар<br>';
                    dump($cart_v);
                    */
                    /**/
                    if ($act_v == $cart_v) {
                        //dump($cart_v);
                        //dump($act_v);
/*echo "<br>cart_good_count - <br>";
                        dump($cart_good_count);
                        echo "<br>act_good_count - <br>";
                        dump($act_good_count);*/
                        if ($cart_good_count[$cart_good_i] >= $act_good_count[$act_good_i]) {
                            //echo $act_good_i.': '.$cart_good_count[$cart_good_i].'-----'.$act_good_count[$act_good_i].'<br>';////
                            $mtch[] = $act_id[$act_good_i];
                            //echo 'Найден товар - id: '.$cart_v['good_id'].', акция id - '.$act_id[$act_good_i].'<br>';
                            //$mtch_act_sum[$act_id[$act_good_i]][$cart_v['good_id'].'_'.$cart_v['size_id']]=(int)$act_good_count[$act_good_i]; //original string
                            
                            
                            $mtch_act_sum[$act_id[$act_good_i]][$act_good_id_input[$act_id[$act_good_i]][$cart_v['good_id'].'_'.$cart_v['size_id']]][$cart_v['good_id'].'_'.$cart_v['size_id']]=(int)$act_good_count[$act_good_i];
                            
                            $act_good_repeat[$act_id[$act_good_i]][$cart_v['good_id'].'_'.$cart_v['size_id']]=$act_repeat[$act_good_i];

                            $mtch_cart_sum[$act_id[$act_good_i]][$cart_v['good_id'].'_'.$cart_v['size_id']]=array();
                            for($j=0; $j<(isset($cart_good_count[$cart_good_i])?(int)$cart_good_count[$cart_good_i]:0); $j++) {
                                $mtch_cart_sum[$act_id[$act_good_i]][$cart_v['good_id'].'_'.$cart_v['size_id']][$j]=1;
                            }
                        }
                    }

                }
            }
            //Акции, в которых товары найдены
            /*echo 'Акции, в которых товары найдены<br>';
            dump($mtch);
            //Совпадения и количество по акциям
            echo 'Совпадения и количество по акциям<br>';
            dump($mtch_act_sum);
            //Совпадения и количество по корзине
            echo 'Совпадения и количество по корзине<br>';
            dump($mtch_cart_sum);
            //Нормированный массив всех акций
            echo 'Нормированный массив всех акций<br>';
            dump($act_sum);
            //Флаг повторения
            echo 'Флаг повторения<br>';
            dump($act_good_repeat);*/


            /**/
            //Количество товаров в акциях
            $act_count = array();
            $act_price = array();
            foreach (array_unique($mtch) as $mtch_i => $mtch_v) {
                $action = Action::all()->find($mtch_v)['attributes'];
                $act_count[$mtch_v] = (int)Action::all()->find($mtch_v)->good_count;
                $act_price[$mtch_v] = (int)Action::all()->find($mtch_v)->goods_sum;
                $action_obj = Action::all()->find($mtch_v);
                $act = json_decode($action['action'], true);
                //dump($act);
                //dump($action);//товары
            }
            
            
            
            /*echo 'Количество товаров в акциях:<br>';    
            dump($act_count);
            echo 'Стоимость товаров в акциях:<br>'; 
            dump($act_price);
            echo self::getCartSum()['sum'];  */

$mtch_act_sum_itr=$mtch_act_sum;
for($pp=0;$pp<=50;$pp++) {
$mtch_act_sum=$mtch_act_sum_itr;

            /**/
/*dump(array_unique($mtch));
echo "act_count - <br>";
dump($act_count);*/


//$act_count - кол-во товаров в акции
            $ProductsInAction = array();
            $ProductsInActionInputCountNow = array();
            foreach (array_unique($mtch) as $mtch_i => $mtch_v) {
                $j=0;
                $mtch_cart_sum_res=$mtch_cart_sum;
                $mtch_act_sum_res=$mtch_act_sum;
                for ($i=0; $i < $act_count[$mtch_v]; $i++) {
                    foreach ($act_sum[$mtch_v] as $act_sum_i => $act_sum_v) {
                        if(isset($mtch_cart_sum[$mtch_v][$act_sum_i])) {
                            foreach ($mtch_cart_sum[$mtch_v][$act_sum_i] as $mtch_cart_i => $mtch_cart_v) {
                                //if($mtch_cart_v && $j<$act_count[$mtch_v] && isset($mtch_act_sum[$mtch_v][$act_sum_i])) {
                                  if($mtch_cart_v && $j<$act_count[$mtch_v] && isset($mtch_act_sum[$mtch_v][$act_good_id_input[$mtch_v][$act_sum_i]][$act_sum_i])) {
                                    /*if(in_array ($act_sum_i, $mtch_act_sum[$mtch_v])){*/
                                      //echo key($mtch_act_sum[$mtch_v]);exit();
                                        
                                      $actionProductInput = $act_good_id_input[$mtch_v][$act_sum_i]; //ID инпута в акцие
                                      
                                      
                                      $ProductsInActionInputCountNow[$mtch_v][$actionProductInput][] =  $act_sum_i;
                                      
                                      if(isset($ProductsInAction[$mtch_v]) && !isset($act_product_in_input_povtorenie_check[$mtch_v][$actionProductInput])){
                                          $forCount = $ProductsInActionInputCountNow[$mtch_v][$actionProductInput];
                                          $countNowProduct = count($forCount);
                                          if($countNowProduct > $act_product_in_input_count[$mtch_v][$actionProductInput]){
                                            if (array_key_exists($actionProductInput, $ProductsInAction[$mtch_v])) {
                                              break;
                                            }
                                          }
                                      }
                                      
                                      //echo "<br>ProductsInActionInputCountNow ($mtch_v)($actionProductInput) <br>";
                                      if (isset($ProductsInActionInputCountNow[$mtch_v][$actionProductInput])){ 
                                          $forCount = $ProductsInActionInputCountNow[$mtch_v][$actionProductInput];
                                          $countNowProduct = count($forCount);
                                          //echo "<br>countNowProduct ($mtch_v)($actionProductInput) = ".$countNowProduct."<br>";
                                          if ($act_product_in_input_count[$mtch_v][$actionProductInput] > $countNowProduct) {
                                              
                                              
                                          }
                                          
                                      }
                                      $ProductsInAction[$mtch_v][$actionProductInput] = true;
                                      
                                      //echo "<br>ProductsInActionInputCountNow = <br>";
                                      //dump($ProductsInActionInputCountNow);
                                      
                                      
                                      /*foreach ($mtch_act_sum[$mtch_v] as $keyArrayActionInput => $znach ) {*/
                                             
                                            /* echo "<br> keyArrayActionInput =".$keyArrayActionInput."<br>";
                                             echo "<br> znach = ";
                                             print_r($znach);
                                             echo"<br>";
                                             echo "<br> act_sum_i =".$act_sum_i."<br>";*/
                                          
                                            /* if (array_key_exists($act_sum_i, $znach)) {
                                              $ProductsInAction[$mtch_v][$keyArrayActionInput] = true;
                                              $ProductsInActionInputCountNow[$mtch_v][$keyArrayActionInput][] =  $act_sum_i;
                                              echo "<br> ProductsInActionInputCountNow  <br> ";
                                              dump($ProductsInActionInputCountNow);
                                              $keyArrayActionInput2 = $keyArrayActionInput;
                                              echo "<br> keyArrayActionInput =".$keyArrayActionInput2."<br>";
                                                 break;
                                             }
                                             
                                            
                                         }*/
                                             //echo $mtch_v.' По акции  '.$mtch_v.' забираем товар '.$act_sum_i.' | <br>';

                                             $mtch_cart_sum[$mtch_v][$act_sum_i][$mtch_cart_i]=0; 
                                             $j++;


                                             foreach ($mtch_cart_sum as $sum_i => $sum_v) {
                                                 foreach ($mtch_cart_sum[$sum_i] as $sum_i1 => $sum_v1) {
                                                     foreach ($mtch_cart_sum[$sum_i][$sum_i1] as $sum_i2 => $sum_v2) {
                                                         if($sum_i!=$mtch_v && $act_sum_i==$sum_i1 && $mtch_cart_i==$sum_i2 ) {
                                                             //echo $mtch_v.' Из акции  '.$sum_i.' удаляем товар '.$sum_i1.' | <br>';
                                                             $mtch_cart_sum[$sum_i][$sum_i1][$sum_i2]=0; 
                                                         }
                                                     }
                                                 }
                                             }


                                             //echo 'Можно взять ещё такой же товар -'.$act_good_repeat[$mtch_v][$act_sum_i].'<br>';
                                             if(!$act_good_repeat[$mtch_v][$act_sum_i]) {
                                                 foreach($mtch_act_sum[$mtch_v] as $mtch_act_sum_i => $mtch_act_sum_v) {
                                                             if($mtch_act_sum_i==$act_sum_i) {
                                                                 //echo 'Удалить в '.$mtch_v.' - '.$mtch_act_sum_i.' | '.$act_sum_i.'<br>';
                                                                         unset($mtch_act_sum[$mtch_v][$mtch_act_sum_i]);
                                                         }
                                                 }
                                             }

                                         
                                  /* }*/
                                }
                            }
                            
                        }

                    }
                }

                //не хватает товаров для акции
                if($j<$act_count[$mtch_v]) {
                    foreach($mtch as $mtch_i1 => $mtch_v1) {
                        if($mtch_v1==$mtch_v) {
                            unset($mtch[$mtch_i1]);
                            $mtch_cart_sum=$mtch_cart_sum_res;
                            $mtch_act_sum=$mtch_act_sum_res;
                        }
                    }
                    //echo 'Акция  '.$mtch_v.' не прошла, откат массива <br>';
                }
                else {
                    /*echo "j = ".$j."<br>";
                    echo "act_count mtch_v - ".$act_count[$mtch_v]."<br>";
                    echo 'Акция  '.$mtch_v.' ПРОХОДИТ<br>';
                    dump($mtch_cart_sum);*/
                }
                //dump($mtch_cart_sum);

            }

            /*
            echo 'После обработки:<br>';   
            dump($mtch_cart_sum);
            dump($mtch);
            dump($mtch_act_sum);*/




            //Расчёт антикорзины
            if(!isset($act_cart)) $act_cart = array();
            foreach (array_unique($mtch) as $mtch_i => $mtch_v) {
                $action_obj = Action::all()->find($mtch_v);
                $_SESSION['action_title'][] = $action_obj->title;
                if ($action_obj->is_sum == true) {
                    //echo 'сумма';
                    //echo $action->total;
                    $act_cart[] = $act_price[$mtch_v] - ($action_obj->total);
                } elseif ($action_obj->is_percent == true) {
                    //echo 'Процент';
                    //echo $action->total;
                    $act_cart[] = $act_price[$mtch_v] - $act_price[$mtch_v] * ($action_obj->total) / 100;
                } elseif ($action_obj->is_present == true) {
                    //echo 'Подарок';
                    //echo $action->total;
                    $act_cart[] = 0;
                    $_SESSION['present'][] = json_decode($action_obj->total, true);
                    
                }
            }
            
           

}           
            /*--- Добавление доп подарков в зависимости от заказов ---*/
            //$action_pickup_obj = ActionPickup::all()->find(1); 
            /*$action_pickup_obj = ActionPickup::all();
            foreach ($action_pickup_obj as $pickup) {
           //dd($pickup->id);exit();
                if ($pickup['pickup'] == 1) {
                      //echo 'pickup';exit();
                     $_SESSION['present'][] = json_decode($pickup->total, true);
                }
            }*/
            
           
            /*--- End ---*/
            
            $_SESSION['act_sum'] = $act_cart;

            /*
            echo 'Вычеты сумм из итога<br>';
            dump($act_cart);*/


        }
    }





}
			
