<?php

namespace App\Http\Controllers\Superadmin;

use App\Models\Mailing;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Models\Subscription;
use Illuminate\Support\Facades\Redirect;

class MailingController extends Controller
{

    public function index(Request $request){
        $mails = Mailing::paginate('15');
        return view(User::UserRoleName(Auth::user()->id).'.mailing.index', compact('mails') );
    }

    public function create(){
        return view(User::UserRoleName(Auth::user()->id).'.mailing.create');
    }

    public function store(Request $request){
        $data = $request->except(['_token']);
        if ($data['mail_to'] == 'all'){
            $users = User::all();
            $subs = Subscription::all();
            foreach ($users as $user){
                self::MailingSend($user->email,$data['mail_title'],$data['mail_content']);
            }
            foreach ($subs as $sub){
                self::MailingSend($sub->email,$data['mail_title'],$data['mail_content']);
            }
        } else {
            $mail_to = $data['mail_to']::all();
            foreach ($mail_to as $value){
                self::MailingSend($value->email,$data['mail_title'],$data['mail_content']);
            }
        }
        Mailing::create($data);
        return Redirect::route('mailing.index')->with('success', 'Рассылка отправлена и сохранена');
    }

    public function update(Request $request, $id){
        $data = $request->except(['_token']);
        if ($data['mail_to'] == 'all'){
            $users = User::all();
            $subs = Subscription::all();
            foreach ($users as $user){
                self::MailingSend($user->email,$data['mail_title'],$data['mail_content']);
            }
            foreach ($subs as $sub){
                self::MailingSend($sub->email,$data['mail_title'],$data['mail_content']);
            }
        } else {
            $mail_to = $data['mail_to']::all();
            foreach ($mail_to as $value){
                self::MailingSend($value->email,$data['mail_title'],$data['mail_content']);
            }
        }
        Mailing::all()->find($id)->update($data);
        return Redirect::route('mailing.index')->with('success', 'Рассылка отправлена и обновлена');
    }

    public function edit($id){
        return view(User::UserRoleName(Auth::user()->id).'.mailing.edit',
            [
                'mail' => Mailing::all()->find($id)
            ]
        );
    }

    public function destroy($id){
        Mailing::all()->find($id)->delete();
        return Redirect::route('mailing.index')->with('success', 'Рассылка удалена');
    }

    public static function MailingSend($email, $title, $content){
        $to = $email; /*Укажите адрес, га который должно приходить письмо*/
        $sendfrom   = "mail@happypizza.kz"; /*Укажите адрес, с которого будет приходить письмо, можно не настоящий, нужно для формирования заголовка письма*/
        $headers  = "From: " . strip_tags($sendfrom) . "\r\n";
        $headers .= "Reply-To: ". strip_tags($sendfrom) . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html;charset=utf-8 \r\n";
        $subject =  $title;
        $message = $content;
        mail ($to, $subject, $message, $headers);
    }

}
