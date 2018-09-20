@extends('layouts.admin')

@section('search')
    <li class="nav-item">
        <form class="form-inline my-2 my-lg-0 mr-lg-2" action="{{ route('goods.index') }}" method="get">
            <div class="input-group">
                <input type="text" class="form-control" name="title" value="{{ request('title') }}" placeholder="Поиск товаров">
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
        <li class="breadcrumb-item"><a href="{{ route('goods.index') }}">Товары</a></li>
        @php
            if(isset($_GET['page'])){
                echo '<li class="breadcrumb-item"><a href="#">Страница '. $_GET['page'] .'</a></li>';
            }
        @endphp
    </ol>
    @php
        if(isset($_GET['title'])){
            echo '<ol class="breadcrumb"><p>Результат поиска по: <strong>'. $_GET['title'] .'</strong></p></ol>';
        }
    @endphp

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <a href="{{ route('goods.index') }}" style="color: #000000;" class="col-10"><i class="fa fa-archive"></i> Все товары</a>
                        <a href="{{ route('goods.create') }}" class="col-2 btn btn-primary btn-sm">Добавить товар</a>
                    </div>
                </div>
                @if (count($goods) > 0)
                    <div>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <td><strong>Название</strong></td>
                                <td><strong>Категория</strong></td>
                                <td></td><td></td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($goods as $good)
                                @if (isset($good->category) && empty($good->user_id))
                                <tr>
                                    <td>{{ $good->title }}</td>
                                    <td>{{ \App\Models\Category::getCategoryName($good->category) }}</td>
                                    <td>
                                        <form action="{{ route('goods.edit', $good->id ) }}" method="post">
                                            <input type="hidden" name="_method" value="get">
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-primary btn-sm">Редактировать</button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{ route('goods.destroy', $good->id) }}" method="post">
                                            <input type="hidden" name="_method" value="delete">
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-danger btn-sm">Удалить</button>
                                        </form>
                                    </td>
                                </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                <div class="card-footer small text-muted">
                    <div class="dataTables_paginate paging_simple_numbers" id="dataTable_paginate">
                        {{ $goods->render() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection