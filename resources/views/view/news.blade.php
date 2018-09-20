@extends('layouts.guest')

@section('meta-content')
    <title>{{ $news[0]->title }}</title>
@endsection

@section('content')
    <div id="wrapper" class="is-full">
            <div class="container">
                <div class="row">
                    @include('view.blocks.left-block')
                    <div class="col-md-9 col-sm-8 col-xs-7 no-lp inner-content">
                        <div id="breadcrumbs" class="is-full">
                            <a href="{{ route('index') }}">Главная</a> /
                            <a href="{{ route('news_list') }}">Новости</a> /
                            <span>{{ $news[0]->title }}</span>
                        </div>
                        <div id="page-title" class="is-full"><h1>{{ $news[0]->title }}</h1></div>
                        <div id="news-show-content">
                            <div class="row">
                                @if ($news[0]->image != 'null')
                                    <div class="col-md-6 col-xs-12">
                                        <div class="news-show-image">
                                            <img src="{{ $news[0]->image }}" alt="">
                                        </div>
                                    </div>
                                    <div class="news-show-description  col-md-6  col-xs-12">
                                @else
                                    <div class="news-show-description  col-md-12  col-xs-12">
                                @endif
                                    <div class="news-show-date">{{ $news[0]->created_at->format('d.m.Y') }}</div>
                                    <div class="news-show-text content">{!! $news[0]->content !!}</div>
                                </div>
                            </div>
                        </div>
                        <div class="look-all is-full look-all-news">
                            <a href="{{ route('news_list') }}">СМОТРЕТЬ ВСЕ НОВОСТИ</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('tpl/css/news.css') }}">
@endsection