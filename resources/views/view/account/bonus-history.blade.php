@extends('layouts.guest')
@section('content')

<div id="wrapper" class="is-full">
    <div class="container">
        <div class="row">
            @include('view.account.menu')
            <div class="col-md-9 col-sm-8 col-xs-7 no-lp inner-content">
                <div id="breadcrumbs" class="is-full">
                    <a href="{{ route('index') }}">Главная</a> / <a href="{{ route('account') }}">Личный кабинет</a> / <span>История заказов</span>
                </div>

                <div id="page-title">
                    <h1>История по Вашему бонусному счету</h1>
                </div>

                <div class="row">
                    <div class="col-lg-8 table-responsive">
                        @if(count($bonus_log) > 0)
                            <div class="account-orders">
                                <table class="table table-orders">
                                    <tbody>
                                    </tbody><thead>
                                    <tr>
                                        <th>Бонусы</th>
                                        <th>Описание</th>
                                        <th>Дата операции</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($bonus_log as $one_row)
                                    <tr><td>{{ $one_row->bonus }}</td><td>{{ $one_row->notes }}</td><td>{{ \Carbon\Carbon::parse($one_row->created_at)->format('d.m.Y H:i') }}</td><td></td></tr>
                                    @endforeach
                                    </tbody>
                                </table>

                                <div class="row">
                                    <div class="col-xs-12">
                                        {{ $bonus_log->render() }}
                                    </div>
                                </div>
                            </div>
                        @else
                            <p>Список заказов пуст</p>
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection