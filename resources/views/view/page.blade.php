@extends('layouts.guest')
@section('meta-content')
    <title>{{ $page[0]->title }}</title>
@endsection
@section('content')
    <div id="wrapper" class="is-full">
        <div class="container">
            <div class="row">
                @include('view.blocks.left-block')
                <div class="col-md-9 col-sm-8 col-xs-7 no-lp inner-content">
                    <div id="breadcrumbs" class="is-full"><a href="{{ route('index') }}">Главная</a> / <span>{{ $page[0]->title }}</span></div>
                    <div id="page-title" class="is-full"><h1>{{ $page[0]->title }}</h1></div>
                    <div class="delivery-info">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="content-holder">
                                    @if ($page[0]->content != null)
                                        {!! $page[0]->content !!}
                                    @else
                                        {!! $page[0]->excerpt !!}
                                    @endif
                                    <style>
                                        .documentation-block {
                                            padding: 0 0 20px;
                                        }

                                        .documentation-title {
                                            display: block;
                                            margin: 0 0 11px;
                                            font-weight: bold;
                                            font-size: 16px;
                                            line-height: 20px;
                                            color: #000;
                                        }

                                        .documentation-text {
                                            font-size: 14px;
                                            line-height: 20px;
                                            color: #363636;
                                            padding: 0 0 31px;
                                        }
                                        #page-title h1 {
                                            text-align: left;
                                            margin-top: 8px;
                                            margin-bottom: 30px;
                                        }
                                    </style>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection