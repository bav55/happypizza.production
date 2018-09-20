@extends('layouts.guest')
@section('content')

<div id="wrapper" class="is-full">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-4 col-xs-5 inner-menu-holder hidden-xs">
                <div id="inner-menu" class="is-full account-menu" style="top: 0px;">
                    <ul style="border-top: none;">
                        <li class="active"><a href="http://happypizza.kz/account/orders">История заказов</a></li>
                        <li><a href="http://happypizza.kz/account/pizza">Созданные пиццы</a></li>

                        <li style="border-bottom: none"><a href="http://happypizza.kz/account">Мои данные</a></li>
                    </ul>
                </div>

            </div>

            <div class="col-md-9 col-sm-8 col-xs-7 no-lp inner-content">
                <div id="breadcrumbs" class="is-full">
                    <a href="{{ route('index') }}">Главная</a> /
                    <a href="{{ route('account') }}">Личный кабинет</a> /
                    <a href="{{ route('orderHistory') }}">История заказов</a> /
                    <span>Просмотр заказа</span>
                </div>

                <div id="page-title"><h1>Просмотр заказа</h1></div>

                <div class="account-orders account-order-detail table-responsive">
                    <table class="table table-orders">
                        <thead><tr><th>Фото</th><th>Наименование</th><th>Размер</th><th>Количество</th></tr></thead>
                        <tbody>

                        @foreach($goods as $good)
                            @foreach($good as $value)
                                <tr>
                                    <td style="background: #f5f5f5">
                                        <div class="order-list-image">
                                            <img src="{{ \App\Http\Controllers\View\ApiController::getGood($value->good->good_id)['image'] }}" width="70" alt="{{ \App\Http\Controllers\View\ApiController::getGood($value->good->good_id)['title'] }}">
                                        </div>
                                    </td>
                                    <td style="background: #f5f5f5">{{ \App\Http\Controllers\View\ApiController::getGood($value->good->good_id)['title'] }}</td>
                                    <td style="background: #f5f5f5">{{ \App\Http\Controllers\View\ApiController::getPortionNameWithGood($value->good->size_id)->title }}</td>
                                    <td style="background: #f5f5f5">{{ $value->good->count }}</td>
                                </tr>
                            @endforeach
                        @endforeach


                        </tbody>
                    </table>
                </div>

                <div class="account-orders account-order-detail table-responsive">
                    <table class="table table-orders">
                        <tbody>
                        </tbody><thead>
                        <tr>
                            <th>Использовано баллов</th>
                            <th>Скидка по промо-коду</th>
                            <th>CashBack</th>
                            <th>Итого</th>
                        </tr>
                        </thead>
                        <tbody><tr>
                            <td>{{ isset($extras->bonus) ? $extras->bonus : '0.00' }}</td>
                            <td>{{ isset($extras->promo_cod) ? \App\Http\Controllers\View\ApiController::getPromoSum($extras->promo_cod) : '0.00' }}</td>
                            <td>{{ $order->bonus_sum }} ТГ</td>
                            <td>{{ $order->order_sum }} ТГ</td>
                        </tr>
                        </tbody></table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection