@extends('layouts.guest')
@section('meta-content')
    <title>{{ $vacancy[0]->title }}</title>
@endsection
@section('content')

    <div id="wrapper" class="is-full">
        <div class="container">
            <div class="row">
                @include('view.blocks.left-block')
                <div class="col-md-9 col-sm-8 col-xs-7 no-lp inner-content">
                    <div id="breadcrumbs" class="is-full"><a href="{{ route('index') }}">Главная</a> / <a href="{{ route('vacancies') }}">Вакансии</a> / <span>{{ $vacancy[0]->title }}</span></div>
                    <div id="page-title" class="is-full"><h1>{{ $vacancy[0]->title }}</h1></div>

                    <div id="vac-full-content">
                        <div class="row">
                            <div class="content col-md-7 col-xs-12">
                                <p class="vac-full-date">{{ $vacancy[0]->created_at->format('d.m.Y') }}</p>

                                <div class="desription">{!! $vacancy[0]->content !!}</div>
                            </div>
                            <form action="{{ route('vacanciesSend') }}" id="vacancy-request" method="get">
                                <div class="col-md-5 col-xs-12{{ count($forms) <= 6 ? ' opened' : '' }}" id="questinaire">
                                    <input type="hidden" value="Отклик на вакансию {{ $vacancy[0]->title }}" name="title">
                                    @foreach($forms as $form)
                                        <div class="ank-question">{{ $form->question }}</div>
                                        <div class="ank-input">
                                            @if ($form->type == 'checkbox')
                                                <div class="radio">
                                                    <label><input name="name[{{ $form->question }}]" value="Да" type="radio"> Да</label>
                                                    <label><input name="name[{{ $form->question }}]" value="Нет" type="radio"> Нет</label>
                                                </div>
                                            @elseif ($form->type == 'input')
                                                <input type="text" class="form-control" required name="name[{{ $form->question }}]">
                                            @endif
                                        </div>
                                    @endforeach
                                    <div class="ank-send"><button class="btn red-button">ОТПРАВИТЬ</button><img class="hidden" src="{{ asset('tpl/images/loader.gif') }}"><div id="success-message"></div></div>
                                </div>
                                {!! count($forms) >= 6 ? ' <a href="#" onclick="$.showQuestions(this); return false;" class="pull-right" style="text-decoration: underline">Смотреть все вопросы</a>' : '' !!}
                            </form>
                        </div>
                    </div>

                    <div class="look-all is-full look-all-news">
                        <a href="{{ route('vacancies') }}">СМОТРЕТЬ ВСЕ ВАКАНСИИ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('tpl/css/vacancies.css') }}">
@endsection

@section('script')
    <script src="{{ asset('tpl/js/vacancy.js') }}"></script>
@endsection