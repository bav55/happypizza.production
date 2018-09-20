<?php
/**
 * Created by PhpStorm.
 * User: ppc
 * Date: 15.06.17
 * Time: 16:48
 */

namespace App\Http\Controllers;


//use App\Bonuses;
//use App\Debits;
use App\Models\Order;
use App\User;
use Illuminate\Http\Request;
use Response;

class OrderController extends Controller
{
    public function check(Request $request) {
        $json = [
            'code' => 0
        ];

        /*$orderId = $request->get('InvoiceId');
        $userId = $request->get('AccountId');
        $amount = $request->get('Amount');
        $currency = $request->get('Currency');
        $transaction = $request->get('TransactionId');

        if ($orderId == 'wallet') {
            $user = User::where('id', $userId);

            if (!$user) {
                $json['code'] = 13;
            }
        } else {
            $order = Order::where('id', $orderId)->get()->first();

           if ($order) {
                if ($order->user_id == $userId) {
                    if ($order->amount - $order->discount == $amount && $currency == 'KZT') {
                    if ($order->order_sum == $amount && $currency == 'KZT') {
                        if (!$order->is_paid) {
                            Order::where('id', $orderId)->update(['transaction' => $transaction]);
                        } else {
                            //$json['code'] = 13;
                        }
                    } else {
                        $json['code'] = 11;
                    }
                } else {
                    $json['code'] = 13;
                }
            } else {
                $json['code'] = 10;
            }
        }*/
            
    
            
        return Response::json($json);
    }

    public function pay(Request $request) {
        $json = [
            'code' => 0
        ];

        $transaction = $request->get('TransactionId');
        $orderId = $request->get('InvoiceId');
        $userId = $request->get('AccountId');
        $amount = $request->get('Amount');

        if ($orderId == 'wallet') {
            /*if (!Debits::plus($userId, $amount, $transaction)) {
                //TODO отправить email? поднять ахтунг?
                //Оплата удачная, но что-то пошло не так
            }*/
        } else {
            //Order::where('transaction', $transaction)->update(['paid' => 1]);

           // $order = Order::where('id', $orderId)->get()->first();

            //Bonuses::cashback($order->user_id, $order->amount, $order->id);
        }

        return Response::json($json);
    }
}