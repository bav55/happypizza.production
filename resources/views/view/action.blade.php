@extends('layouts.guest')

@section('meta-content')
    <title>Акции | Happy Pizza</title>
@endsection

@section('content')

    <div id="wrapper" class="is-full">
        <div class="container">
            <div class="row">
                @include('view.blocks.left-block')

                <div class="col-md-9 col-sm-8 col-xs-7 no-lp inner-content">
                    <div id="breadcrumbs" class="is-full">
                        <a href="{{ route('index') }}">Главная</a> / <span>Акции</span>
                    </div>

                    <div id="page-title" class="is-full">
                        <h1>Акции</h1>
                    </div>

                    <div class="news-list is-full">
                        <div class="row news-list-row">
                            @foreach($actions as $action)
                            
                                <div class="col-md-4 col-xs-6">
                                    <div class="news-list-item is-full" style="height: 267px;">
                                        <div class="news-list-image is-full">
                                            @if (empty($action->url_product))
                                            <a href="{{ route('action', $action->url) }}">
                                            @else 
                                            <a href="{{ $action->url_product }}">    
                                            @endif
                                                <img src="{{ asset($action->image) }}" alt="{{ $action->title }}" class="img-responsive">
                                            </a>
                                        </div>
                                        <div class="news-list-title is-full">
                                            <h4>{{ $action->title }}</h4>
                                        </div>
                                        <div class="news-list-date is-full">{{ \Carbon\Carbon::parse($action->date_at)->format('d.m.Y')}}</div>
                                        <div class="news-list-more">
                                            @if (empty($action->url_product))
                                            <a href="{{ route('action', $action->url) }}">подробнее</a>
                                            @else 
                                            <a href="{{ $action->url_product }}">подробнее</a>
                                            @endif
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