<?php

namespace App\Http\Controllers\Superadmin;

use App\Models\Vote;
use App\Models\VoteList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Mediafile;
use Illuminate\Support\Facades\Redirect;

class VoteController extends Controller
{

    public function index(){
        $votes = Vote::orderBy('sort','ASC')->paginate(15);
        return view(User::UserRoleName(Auth::user()->id).'.votes.index', compact('votes') );
    }

    public function create(){
        return view(User::UserRoleName(Auth::user()->id).'.votes.create',
            [
                'medias' => Mediafile::all()
            ]
        );
    }

    public function edit($id){
        return view(User::UserRoleName(Auth::user()->id).'.votes.edit',
            [
                'medias' => Mediafile::all(),
                'vote' => Vote::all()->find($id)
            ]
        );
    }

    public function update(Request $request,$id){
        $data = $request->except(['_token']);
        $vote = Vote::all()->find($id);
        foreach ($vote->getVoteList as $value){
            $value->delete();
        }
        $data['is_show'] == 'true' ? $data['is_show'] = true : $data['is_show'] = false;
        $vote->update($data);
        if ($vote){
            foreach ($data['form'] as $form){
                $vote_list = new VoteList;
                $vote_list->title = $form;
                $vote_list->vote_id = $vote->id;
                $vote_list->vote = 0;
                $vote_list->save();
            }
        }
        return Redirect::route('votes.index')->with('success', 'Опрос обновлен');
    }

    public function store(Request $request){
        $data = $request->except(['_token']);
        $data['is_show'] == 'true' ? $data['is_show'] = true : $data['is_show'] = false;
        //dump($data);
        $vote = Vote::create($data);
        if ($vote){
            foreach ($data['form'] as $form){
                $vote_list = new VoteList;
                $vote_list->title = $form;
                $vote_list->vote_id = $vote->id;
                $vote_list->vote = 0;
                $vote_list->save();
            }
        }
        return Redirect::route('votes.index')->with('success', 'Опрос добавлена');
    }

    public function destroy($id){
        Vote::all()->find($id)->delete();
        return Redirect::back()->with('success', 'Опрос удален');
    }

}
