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
                        <td><strong>id</strong></td>
                        <td><strong>Номер заказа</strong></td>
                        <td><strong>Сумма</strong></td>
                        <td><strong>Статус</strong></td>
                        <td><strong>Дата заказа</strong></td>
                        <td><strong>Доставка</strong></td>
                        <td></td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->order_id }}</td>
                            <td>{{ $order->order_sum }} ТГ</td>
                            <td>{{ $order->is_new != true ? 'Просмотрен' : 'Новый'  }}</td>
                            <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d.m.Y H:i') }}</td>
                            <td>{{ $order->delivery_type_id == true ? 'Самовывоз' : 'Доставка' }}</td>
                            <td><a href="{{ route('selling.show',$order->id) }}" type="button" class="btn btn-primary btn-sm">Подробнее</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer small text-muted">
                <div class="dataTables_paginate paging_simple_numbers" id="dataTable_paginate">
                    {{ $orders->render() }}
                </div>
            </div>
        </div>
    </div>
</div>


@endsection