@extends('layouts.admin')

@section('search')
<li class="nav-item">
    <form class="form-inline my-2 my-lg-0 mr-lg-2" action="{{ route('selling.index') }}" method="get">
        <div class="input-group">
            <input type="text" class="form-control" name="id" value="{{ request('id') }}" placeholder="Поиск по id">
            <span class="input-group-btn">
                  <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
                </span>
        </div>
    </form>
</li>
@endsection

@section('search-two')
<li class="nav-item">
    <form class="form-inline my-2 my-lg-0 mr-lg-2" action="{{ route('selling.index') }}" method="get">
        <div class="input-group">
            <input type="text" class="form-control" name="order_id" value="{{ request('order_id') }}" placeholder="Поиск по номеру">
            <span class="input-group-btn">
                  <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
                </span>
        </div>
    </form>
</li>
@endsection

@section('content')

<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
    <li class="breadcrumb-item"><a href="{{ route('selling.index') }}">Заказы</a></li>
    <li class="breadcrumb-item"><a href="{{ route('selling.index') }}">{{ $order->order_id }}</a></li>
</ol>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div style="color: #000000;" class="col-10"><i class="fa fa-cart-arrow-down"></i> Все товары</div>
                </div>
            </div>
            <div>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <td><strong>id</strong></td><td><strong>Номер заказа</strong></td><td><strong>Сумма</strong></td><td><strong>Дата заказа</strong></td><td><strong>Доставка</strong></td>
                    </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->order_id }}</td>
                            <td>{{ $order->order_sum }} ТГ</td>
                            <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d.m.Y H:i') }}</td>
                            <td>{{ $order->delivery_type_id == true ? 'Самовывоз' : 'Доставка' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="clearfix"></div><div style="margin-bottom: 20px; width: 100%;"></div>
    @if(!$presents)<div class="col-lg-12">@else<div class="col-lg-8">@endif
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div style="color: #000000;" class="col-10"><i class="fa fa-cart-arrow-down"></i> Все товары</div>
                </div>
            </div>
            <div>
                <table class="table table-hover">
                    <thead><tr><th>Фото</th><th>Наименование</th><th>Размер</th><th>Количество</th><th>Ингредиенты</th></tr></thead>
                    <tbody>
                    @foreach($goods as $good)
                        @foreach($good as $value)
                            <tr>
                                <td>
                                    <div class="order-list-image">
                                        <img src="{{ \App\Http\Controllers\View\ApiController::getGood($value->good->good_id)['image'] }}" width="70" alt="{{ \App\Http\Controllers\View\ApiController::getGood($value->good->good_id)['title'] }}">
                                    </div>
                                </td>
                                <td>{{ \App\Http\Controllers\View\ApiController::getGood($value->good->good_id)['title'] }}</td>
                                <td>{{ \App\Http\Controllers\View\ApiController::getPortionNameWithGood($value->good->size_id)->title }}</td>
                                <td>{{ $value->good->count }}</td>
                                <td>{!! \App\Http\Controllers\View\ApiController::thisConstract($value->good->good_id) !!} </td>
                            </tr>
                        @endforeach
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if($presents)
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-10"><i class="fa fa-cart-arrow-down"></i> Подарочные товары</div>
                    </div>
                </div>
                <div>
                    <table class="table table-hover">
                        <thead><tr><th>Фото</th><th>Наименование</th></thead>
                        <tbody>
                        @foreach($presents as $present)
                            <tr>
                                <td>
                                    <div class="order-list-image">
                                        <img src="{{ \App\Http\Controllers\View\ApiController::getGood($present['good'])['image'] }}" width="70">
                                    </div>
                                </td>
                                <td>{{ \App\Http\Controllers\View\ApiController::getGood($present['good'])['title'] }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
        <div class="clearfix"></div><div style="margin-bottom: 20px; width: 100%;"></div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-10"><i class="fa fa-cart-arrow-down"></i> Контакты</div>
                    </div>
                </div>
                <div>
                    <table class="table table-hover">
                        <tbody>
                            <tr><td>{{ $order->name }}</td></tr>
                            <tr><td>{{ $order->phone }}</td></tr>
                            <tr><td>{{ $order->email }}</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @if ($order->delivery_type_id != 1)
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div style="color: #000000;" class="col-10"><i class="fa fa-cart-arrow-down"></i> Контакты</div>
                        </div>
                    </div>
                    <div>
                        <table class="table table-hover">
                            <tbody>
                            @foreach($delivery_adress as $key => $value)
                                <tr><td>{{ $key }}</td><td>{{ $value }}</td></tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div style="color: #000000;" class="col-10"><i class="fa fa-cart-arrow-down"></i> Дополнительно</div>
                    </div>
                </div>
                <div>
                    <table class="table table-hover">
                        <tbody>
                            <tr><td>Время доставки</td><td>{{ $extra->time }}</td></tr>
                            <tr><td>Сдача с</td><td>{{ $extra->money }}</td></tr>
                            <tr><td>Комментарий</td><td>{{ $extra->comment }}</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="clearfix"></div><div style="margin-bottom: 20px; width: 100%;"></div>

</div>


@endsection