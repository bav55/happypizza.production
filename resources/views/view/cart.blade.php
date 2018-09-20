@extends('layouts.guest')

@section('meta-content')
    <title>Корзина</title>
@endsection

@section('content')

    @php $cart_sum = \App\Http\Controllers\View\CartController::getCartSum(); @endphp

    <div id="wrapper" class="is-full cart">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 inner-content">
                    <div id="breadcrumbs" class="is-full"><a href="{{ route('index') }}">Главная</a> / Корзина</div>
                    <div id="page-title" class="is-full"><h1>Корзина</h1></div>
                    <p>Заказывайте на сайте и получайте бонусы!</p>
                </div>
            </div>

            <div id="cat-data-wrapper">
                @if ($goods != null)
                    <div class="row"><div class="col-xs-12"><h4>Ваш заказ:</h4></div></div>

                    <div class="row cart-products-list">
                    @foreach($goods as $key => $value)
                        @foreach($value as $val)
                            @php $good = $val['good'] @endphp
                            @include('view.blocks.good-cart')
                        @endforeach
                    @endforeach
                    </div>

                    @if($present)
                        <hr>
                        <div class="row"><div class="col-xs-12"><h4>Ваши подарки:</h4></div></div>

                        <div class="row cart-products-list">
                            @foreach($present as $value)
                                @include('view.blocks.good-present')
                            @endforeach
                        </div>
                    @endif

                    <div class="row cart-total">
                        <div class="col-xs-12 col-sm-4">
                            <p>Сумма заказа: <span id="cart-total-products" class="cart-total-products">{!! $cart_sum['str'] !!}</span></p>
                            
                                <br><p>Минимальная сумма заказа: <strong>3 000 тг</strong></p>
                            
                        </div>
                    </div>
                    
                    @if (isset($_SESSION['action_title']) )
                    <div class="row cart-total">
                        <div class="col-xs-12 col-sm-4">
                            @foreach ($_SESSION['action_title'] as $result)
                                <br><p>Акция: <strong>{{ $result }}</strong></p>  
                            @endforeach
                            
                           
                        </div>
                    </div>
                    @endif
                    
                    @if ($promo > 0 && !isset($_SESSION['promo']) )
                    <div class="row">
                        <div class="col-xs-12 col-sm-4">
                            <div class="row cart-actions">
                                <div class="col-sm-6">
                                    <input type="text" id="promo-code" name="promo_code" class="form-control" style="height: 31px;" placeholder="Промо-код">
                                    <br>
                                    <span id="promo-error"></span>
                                </div>
                                <div class="col-sm-6">
                                    <a id="promo-code-button" class="btn red-button" onclick="applyCode()">Применить</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="row cart-actions">
                        <div class="col-xs-12">
                            <a href="{{ route('category_link','pizza') }}" class="white-button">Назад</a>
                            @if ( $cart_sum['sum'] >= 3000 )
                                <a href="{{ route('checkout') }}" class="red-button">Оформить заказ</a>
                            @else
                                <a href="javascript:void(0);" class="red-button disabled">Оформить заказ</a>
                            @endif
                        </div>
                    </div>
                @else
                    <div class="row"><div class="col-xs-12"><p style="padding-top: 30px;">Ваша корзина пуста</p></div></div>
                @endif
            </div>
        </div>
    </div>

@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('tpl/css/cart.css') }}">
@endsection

@section('script')
    <script src="{{ asset('tpl/js/cart.js') }}"></script>
@endsection