<?php

namespace App\Http\Controllers;

use App\Models\Action;
use App\Models\Faq;
use App\Models\Good;
use App\Models\Good_Size_Price;
use App\Models\News;
use App\Models\Page;
use App\Models\Review;
use App\Models\Setting;
use App\Models\Subscription;
use App\Models\UserVote;
use App\Models\Vacancy;
use App\Models\Vote;
use App\Models\VoteList;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Lang;

class IndexController extends Controller
{
    public function index(){
        $slider = json_decode(Setting::all()->find(1)->slider);
        $goods = Good::where('category_id','1')->orderBy('position','ASC')->limit('6')->get();
        $actions = Action::where('date_at','<',date('Y-m-d').'00:00:00')
                            ->where('date_to','>',date('Y-m-d').'23:59:59')
                            ->where('show_main','1')->orderBy('sort', 'DESC')->get();
        return view('view.index', compact('goods','slider','actions'));
    }

    public function page($url){
        if ($url == 'contacts'){
            return view('view.contacts');
        } else {
            $page = Page::where('url',$url)->get();
            if ($page->toArray()){
                return view('view.page', compact('page'));
            } else {
                abort(404);
            }
        }

    }

    public function news_list(){
        return view('view.news-list',
            [
                'news' => News::all()
            ]
        );
    }

    public function news($url){
        return view('view.news',
            [
                'news' => News::where('url',$url)->get()
            ]
        );
    }

    public function faq(){
        return view('view.faq',
            [
                'faqs' => Faq::where('is_active','1')->orderBy('id','desc')->get()
            ]
        );
    }

    public function faq_request(Request $request){
        $to = Setting::all()->find(1)->email; /*Укажите адрес, га который должно приходить письмо*/
        $sendfrom   = "faq@happypizza.kz"; /*Укажите адрес, с которого будет приходить письмо, можно не настоящий, нужно для формирования заголовка письма*/
        $headers  = "From: " . strip_tags($sendfrom) . "\r\n";
        $headers .= "Reply-To: ". strip_tags($sendfrom) . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html;charset=utf-8 \r\n";
        $subject = "FAQ. Vopros, ". date('Y-m-d H:i');
        $message = "<b>Имя:</b> $request->name <br><b>Телефон:</b> $request->phone<br><b>Вопрос:</b> $request->message";
        $send = mail ($to, $subject, $message, $headers);
        if ($send == 'true')
        {
            echo '<p>Спасибо! Ваш вопрос принят! Наш менеджер перезвонит вам в самое ближайшее время для уточнения деталей.</p>';
        }
        else
        {
            echo '<p class="fail"><b>Ошибка. Сообщение не отправлено! <br> попробуйте позже</b></p>';
        }
    }

    public function subscription(Response $response, $email, Request $request){
        $validation = Validator::make(['email' => $email], [
            'email' => 'required|string|email|max:255|unique:subscriptions'
        ]);
        if ($validation->fails()){
            $errors = $validation->errors();
            $errors =  json_decode($errors);
            return response()->json($errors, 422);
        }
        Subscription::create(['email' => $email]);
        $response = new Response();
        $json = json_encode('Подписка офрмлена');
        return $response->setStatusCode(200,$json);
    }

    public function action_list(Request $request){
        $actions = Action::where('date_at','<',date('Y-m-d').'00:00:00')
                        ->where('date_to','>',date('Y-m-d').'23:59:59')
                        ->orderBy('id','desc')->get();
        return view('view.action',compact('actions'));
    }

    public function action(Request $request, $url){
        $action = Action::where('url',$url)->get();
        return view('view.one-action',compact('action'));
    }

    public function addReviews(Request $request){
        $data = $request->except(['_token']);
        Review::create($data);
    }

    public function reviews(){
        $reviews = Review::where('is_show','1')->orderBy('sort', 'ASC')->get();
        $rating = 0;
        $count = 0;
        if ($reviews->toArray()){
            foreach ($reviews as $review){
                $rating += $review->rating;
                $count++;
            }
            $rating = $rating/$count;
            $rating = round($rating,2);
        }
        return view('view.reviews', compact('reviews','rating','count') );
    }

    public function vacancies(){
        return view('view.vacancies',
            [
                'vacancies' => Vacancy::where('is_show',true)->orderBy('sort','ASC')->get()
            ]
        );
    }

    public function vacancyShow($url){
        $vacancy = Vacancy::where('url',$url)->get();
        $forms = json_decode($vacancy[0]->form);
        return view('view.vacancy', compact('vacancy','forms') );
    }

    public function voteShow(Request $request){
        return view('view.vote',
            [
                'votes' => Vote::where('is_show',true)->orderBy('sort','ASC')->get(),
                'user_ip' => $request->ip()
            ]
        );
    }

    public function voteRequest(Request $request){
        $data = $request->except(['_token']);
        UserVote::create(['vote_id'=>$data['vote_id'],'user_ip'=>$request->ip()]);
        $vote = VoteList::all()->find($data['option_id']);
        $vote->update(['vote'=>$vote->vote+1]);
    }


}
