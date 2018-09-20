<?php

namespace App\Http\Controllers\Superadmin;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ReviewController extends Controller
{

    public function index(){
        $reviews = Review::orderby('id','DESC')->paginate('15');
        return view(User::UserRoleName(Auth::user()->id).'.reviews.index', compact('reviews') );
    }

    public function edit($id){
        Review::all()->find($id)->update(['is_look' => true]);
        $review = Review::all()->find($id);
        return view(User::UserRoleName(Auth::user()->id).'.reviews.edit', compact('review') );
    }

    public function update(Request $request, $id){
        $data = $request->except(['_token']);
        $data['is_show'] == 'true' ? $data['is_show'] = true : $data['is_show'] = false;
        Review::all()->find($id)->update($data);
        return Redirect::route('review.index')->with('success', 'Изменения внесены');
    }

    public function destroy($id){
        Review::all()->find($id)->delete();
        return Redirect::route('review.index')->with('success', 'Отзыв удален');
    }

    public function store(Request $request){
        $data = $request->except(['_token']);
        $data['is_show'] == 'true' ? $data['is_show'] = true : $data['is_show'] = false;
        $data['sort'] == null ? $data['sort'] = false : $data['sort'];
        $data['is_look'] = true;
        Review::create($data);
        return Redirect::route('review.index')->with('success', 'Отзыв добавлен');
    }

    public function create(){
        return view(User::UserRoleName(Auth::user()->id).'.reviews.create');
    }

}
