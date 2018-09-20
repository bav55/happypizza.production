@extends('layouts.guest')

@section('meta-content')
    <title>Новости</title>
@endsection

@section('content')
    <div id="wrapper" class="is-full">
        <div class="container">
            <div class="row">
                @include('view.blocks.left-block')
                <div class="col-md-9 col-sm-8 col-xs-7 no-lp inner-content">
                    <div id="breadcrumbs" class="is-full"><a href="{{ route('index') }}">Главная</a> / <span>Новости</span></div>
                    <div id="page-title" class="is-full"><h1>Новости</h1></div>
                    <div class="news-list is-full">
                        <div class="row news-list-row">
                            @foreach($news as $new)
                            <div class="col-md-4 col-xs-6">
                                <div class="news-list-item is-full">
                                    <div class="news-list-image is-full">
                                        <a href="{{ route('news',$new->url) }}">
                                            <img src="{{ asset($new->image) }}" alt="{{ $new->title }}">
                                        </a>
                                    </div>
                                    <div class="news-list-title is-full">
                                        <h4>{{ $new->title }}</h4>
                                    </div>
                                    <div class="news-list-date is-full">{{ $new->created_at->format('d.m.Y') }}</div>
                                    <div class="news-list-more">
                                        <a href="{{ route('news',$new->url) }}">подробнее</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
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