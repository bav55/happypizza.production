@extends('layouts.admin')

@section('content')

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
        <li class="breadcrumb-item"><a href="{{ route('review.index') }}">Отзывы</a></li>
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
                    <div class="row">
                        <a href="{{ route('review.index') }}" style="color: #000000;" class="col-10"><i class="fa fa-star-half-o"></i> Все отзывы</a>
                        <a href="{{ route('review.create') }}" class="col-2 btn btn-primary btn-sm">Добавить</a>
                    </div>
                </div>
                @if (count($reviews) > 0)
                    <div>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <td><strong>Имя</strong></td>
                                <td><strong>Дата</strong></td>
                                <td><strong>Отображать на сайте</strong></td>
                                <td><strong>Статус</strong></td>
                                <td></td><td></td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($reviews as $review)
                                <tr>
                                    <td>{{ $review->name }}</td>
                                    <td>{{ \Carbon\Carbon::parse($review->created_at)->format('d.m.Y') }}</td>
                                    <td>{{ $review->is_show == 1 ? 'Да' : 'Нет' }}</td>
                                    <td>{{ $review->is_look == 0 ? 'Новый' : 'Просмотрено' }}</td>
                                    <td>
                                        <form action="{{ route('review.edit', $review->id ) }}" method="post">
                                            <input type="hidden" name="_method" value="get">
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-primary btn-sm">Редактировать</button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{ route('review.destroy', $review->id) }}" method="post">
                                            <input type="hidden" name="_method" value="delete">
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-danger btn-sm">Удалить</button>
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
                        {{ $reviews->render() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection