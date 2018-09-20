@extends('layouts.guest')

@section('meta-content')
    <title>Опросы</title>
@endsection

@section('content')

    <div id="wrapper" class="is-full">
        <div class="container">
            <div class="row">
                @include('view.blocks.left-block')
                <div class="col-md-9 col-sm-8 col-xs-7 no-lp inner-content">
                    <div id="breadcrumbs" class="is-full">
                        <a href="{{ route('index') }}">Главная</a> / <span>Опрос</span>
                    </div>

                    <div id="page-title" class="is-full"><h1>опрос</h1></div>
                    <div class="int-archive">
                    @foreach($votes as $vote)
                        @if(!\App\Models\UserVote::getUserVoteIP($user_ip))
                            <div class="vote" id="vote-{{$vote->id}}">
                                <div class="interview-title"><p>{{ $vote->title }}</p></div>

                                <div class="interview-radios">
                                    @foreach($vote->getVoteList as $value)
                                        <div class="interview-radio" data-vote-id="{{ $vote->id }}" data-option-id="{{ $value->id }}"><div></div>{{ $value->title }}</div>
                                    @endforeach
                                </div>

                                <div class="send-interview">
                                    <button onclick="setVote(this); return false;" class="btn red-button">ГОЛОСОВАТЬ</button>
                                    <img class="hidden" src="{{ asset('tpl/images/loader.gif') }}">
                                </div>
                            </div>
                        @else
                            <div id="vote-{{$vote->id}}" class="int-item  first-int last-int ">
                                <div class="int-item-title active"><p>{{ $vote->title }}</p></div>

                                <div class="int-item-history" style="display: block;">
                                    {!! \App\Http\Controllers\View\ApiController::getVoteMark($vote->id) !!}
                                </div>
                            </div>
                        @endif
                    @endforeach
                    </div>



                </div>
            </div>
        </div>
    </div>


@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('tpl/css/interview.css') }}">
@endsection

@section('script')
    <script src="{{ asset('tpl/js/interview.js') }}"></script>
@endsection