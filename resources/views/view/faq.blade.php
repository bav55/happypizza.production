@extends('layouts.guest')

@section('meta-content')
    <title>Частые вопросы</title>
@endsection

@section('content')
    <div id="wrapper" class="is-full">
        <div class="container">
            <div class="row">
                @include('view.blocks.left-block')
                <div class="col-md-9 col-sm-8 col-xs-7 no-lp inner-content">
                    <div id="breadcrumbs" class="is-full"><a href="{{ route('index') }}">Главная</a> / <span>Частые вопросы</span></div>
                    <div id="page-title" class="is-full"><h1>частые вопросы</h1></div>
                    <div class="faq-title"><p>В этом разделе вы найдете ответы на часто задаваемые вопросы наших клиентов.</p></div>

                    @foreach($faqs as $faq)
                    <div class="faq-item">
                        <div class="faq-question"><strong>{{ $faq->question }}</strong></div>
                        <div class="faq-answer">{!! $faq->answer !!}</div>
                    </div>
                    @endforeach

                    <div class="no-answer"><p>Не нашли ответ на свой вопрос?</p></div>
                    <div class="no-answer-button"><a href="javascript: $.askQuestion()" class="btn red-button">ЗАДАТЬ ВОПРОС</a></div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>

    <form class="modal modal-happypizza" id="faq-modal" tabindex="-1" role="dialog">
        <div class="vertical-alignment-helper">
            <div class="modal-dialog modal-sm vertical-align-center">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Задать вопрос</h4>
                    </div>

                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control" name="name" required placeholder="Ваше имя" />
                        </div>
                        <div class="form-group">
                            <input type="text" name="phone" class="form-control masked-phone" required placeholder="Телефон" />
                        </div>
                        <div class="form-group">
                            <input type="text" name="message" class="form-control" required placeholder="Ваш вопрос" />
                        </div>
                    </div>

                    <div class="modal-footer">
                        <img src="{{ asset('tpl/images/loader.gif') }}" style="display: none;">
                        <button class="btn red-button" type="submit">ОТПРАВИТЬ</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('tpl/css/faq.css') }}">
@endsection