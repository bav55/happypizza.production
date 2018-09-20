@extends('layouts.guest')

@section('content')

    <div id="wrapper" class="is-full">
        <div class="container">
            <div class="row">
                @include('view.account.menu')

                <div class="col-md-9 col-sm-8 col-xs-7 no-lp inner-content">
                    <div id="breadcrumbs" class="is-full">
                        <a href="{{ route('index') }}">Главная</a> / <a href="{{ route('account') }}">Личный кабинет</a> / <span>Созданные пиццы</span>
                    </div>

                    <div id="page-title">
                        <h1>Созданные пиццы</h1>
                    </div>

                    <div class="account-pizza">
                        <div id="menu-list" class="is-full menu-list-block">
                            <div class="row menu-list-row">
                                @foreach($goods as $good)
                                    <div class="col-md-4 col-xs-6 account-good-block">
                                        <div class="menu-list-item is-full">
                                            <div class="menu-list-image"><img src="{{ $good->image }}"></div>

                                            <div class="menu-list-text is-full" style="height: 120px;">
                                                <div class="menu-list-title"><h4>{{ $good->title }}</h4></div>
                                                <div class="menu-list-announce"><p>Состав: {{ \App\Http\Controllers\View\ApiController::getAccountGoodIng($good->portion_id) }}</p></div>
                                            </div>

                                            <div class="menu-items-el">
                                                <div class="to-cart-button">
                                                    <a href="#" onclick="customGoodAddCart('{{ $good->id }}', '{{ $good->size_id }}', '1'); return false;" data-product-id="4" class="red-button">В корзину</a>
                                                    <p><a href="#" class="remove-custom-good pull-right" onclick="removeCustomGood(this,'{{ $good->id }}'); return false;">удалить</a></p>
                                                </div>
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
    </div>

@endsection