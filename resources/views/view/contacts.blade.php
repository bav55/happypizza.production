@extends('layouts.guest')

@section('meta-content')
    <title>Контакты</title>
@endsection

@section('content')
    <div id="wrapper" class="is-full">
        <div class="container">
            <div class="row">
                @include('view.blocks.left-block')
                <div class="col-md-9 col-sm-8 col-xs-7 no-lp inner-content">
                    <div id="breadcrumbs" class="is-full"><a href="{{ route('index') }}">Главная</a> / <span>Контакты</span></div>
                    <div id="page-title" class="is-full"><h1>Контакты</h1></div>
                    <div id="contacts-content-block">
                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                <div class="left-contact-block is-full">
                                    <div class="contact-item contact-phones">
                                        <div class="citem-icon"></div>
                                        @foreach(json_decode(\App\Models\Setting::all()->find(1)->phone) as $phone)<p>{!! $phone->visual !!}</p>@endforeach
                                    </div>
                                    <div class="contact-item contact-schedules">
                                        <div class="citem-icon"></div>
                                        {!! json_decode(\App\Models\Setting::all()->find(1)->work)->contacts !!}
                                    </div>
                                    <div class="contact-item contact-emails">
                                        <div class="citem-icon"></div>
                                        <p>{{ \App\Models\Setting::all()->find(1)->email }}</p>
                                    </div>
                                    <div class="contact-item socials">
                                        @foreach(json_decode(\App\Models\Setting::all()->find(1)->social) as $social)<a href="{!! $social->url !!}" target="_blank" style="margin-left: 5px;">{!! $social->icon !!}</a>@endforeach
                                    </div>
                                    <div class="contacts-line"></div>
                                </div>
                            </div>

                            <div class="right-contact-block col-md-6 col-xs-12">
                                <div class="right-contact-block is-full">
                                    <form id="feedback" method="post" action="{{ url('api/mail-send') }}">
                                        <div class="write-us-title">
                                            <strong>Напишите нам</strong>
                                        </div>
                                        <input type="hidden" name="title" value="Сообщение с сайта" >

                                        <div class="feedback-item">
                                            <input name="input[Имя]" type="text" class="form-control" placeholder="Имя *" {{ Auth::guest() ? '' : 'value='. Auth::user()->name .'' }}>
                                            <p class="help-block">Поле Имя обязательно для заполнения.</p>
                                        </div>

                                        <div class="feedback-item">
                                            <input name="input[Телефон]" type="text" class="form-control masked-phone phone" placeholder="Телефон *" {{ Auth::guest() ? '' : 'value='. Auth::user()->phone .'' }}>
                                            <p class="help-block">Поле Телефон обязательно для заполнения.</p>
                                        </div>

                                        <div class="feedback-item">
                                            <textarea name="input[Сообщение]" class="form-control required" placeholder="Комментарий *"></textarea>
                                            <p class="help-block">Поле Комментарий обязательно для заполнения.</p>
                                        </div>

                                        <div class="feedback-item">
                                            <button type="submit" class="btn red-button">ОТПРАВИТЬ</button>
                                            <img class="hidden" src="{{ asset('tpl/images/loader.gif') }}">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('style')
    <link rel="stylesheet" href="{{ asset('tpl/css/contacts.css') }}">
@endsection