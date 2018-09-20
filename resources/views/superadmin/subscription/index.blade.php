@extends('layouts.admin')

@section('content')

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
        <li class="breadcrumb-item"><a href="{{ route('subscriptions.index') }}">Подписчики</a></li>
        @php
            if(isset($_GET['page'])){
                echo '<li class="breadcrumb-item"><a href="#">Страница '. $_GET['page'] .'</a></li>';
            }
        @endphp
    </ol>
    <div class="row">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('subscriptions.index') }}" style="color: #000000;"><i class="fa fa-list-alt"></i> Все Подписчики</a>
                </div>
                @if (count($subscriptions) > 0)
                    <div>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <td><strong>E-mail</strong></td><td></td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($subscriptions as $subscription)
                                <tr>
                                    <td>{{ $subscription->email }}</td>
                                    <td>
                                        <form action="{{ route('subscriptions.destroy', $subscription->id) }}" method="post">
                                            <input type="hidden" name="_method" value="delete">
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-danger btn-sm pull-right">Удалить</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                <div class="card-footer small text-muted">
                    <div class="dataTables_paginate paging_simple_numbers" id="dataTable_paginate">
                        {{ $subscriptions->render() }}
                    </div>
                </div>
            </div>
        </div>

    </div>


@endsection
