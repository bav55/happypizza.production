@extends('layouts.admin')

@section('content')

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
        <li class="breadcrumb-item"><a href="{{ route('pages.index') }}">Новости</a></li>
        @php
            if(isset($_GET['page'])){
                echo '<li class="breadcrumb-item"><a href="#">Страница '. $_GET['page'] .'</a></li>';
            }
        @endphp
    </ol>
    <div class="row">
        <div class="col-lg-6">
            <form action="{{ route('pages.store') }}" enctype="multipart/form-data" method="post">
                <input type="hidden" name="_method" value="post">
                {{ csrf_field() }}
                <div class="card">
                    <div class="card-header"><i class="fa fa-sticky-note"></i> Создание новости</div>
                    <div class="card-body">
                        <div class="form-group{{ $errors->has('title') ? ' has-danger' : '' }}">
                            <input type="text" class="form-control" name="title" placeholder="Название" required autofocus>
                            @if ($errors->has('title'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group{{ $errors->has('url') ? ' has-danger' : '' }}">
                            <input type="text" class="form-control" name="url" placeholder="ЧПУ (url)">
                            @if ($errors->has('url'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('url') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer small text-muted">
                        <button type="submit" class="btn btn-primary">Создать</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('pages.index') }}" style="color: #000000;"><i class="fa fa-sticky-note"></i> Все новости</a>
                </div>
                @if (count($pages) > 0)
                    <div>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <td><strong>Название</strong></td><td></td><td></td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($pages as $page)
                                <tr>
                                    <td>{{ $page->title }}</td>
                                    <td>
                                        <form action="{{ route('pages.edit', $page->id) }}" method="post">
                                            <input type="hidden" name="_method" value="get">
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-primary btn-sm">Редактировать</button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{ route('pages.destroy', $page->id) }}" method="post">
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
                        {{ $pages->render() }}
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection