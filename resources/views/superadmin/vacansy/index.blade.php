@extends('layouts.admin')

@section('content')

<ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
    <li class="breadcrumb-item"><a href="{{ route('vacancy.index') }}">Вакансии</a></li>
</ol>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div style="color: #000000;" class="col-10"><i class="fa fa-user-plus"></i> Вакансии</div>
                    <a href="{{ route('vacancy.create') }}" class="col-2 btn btn-primary btn-sm">Добавить</a>
                </div>
            </div>
            <div>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <td><strong>Имя</strong></td>
                        <td><strong>Отображать на сайте</strong></td>
                        <td></td><td></td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($vacancies as $vacancy)
                        <tr>
                            <td>{{ $vacancy->title }}</td>
                            <td>{{ $vacancy->is_show == true ? 'Да' : 'Нет' }}</td>
                            <td>
                                <form action="{{ route('vacancy.edit',$vacancy->id) }}" method="post">
                                    <input type="hidden" name="_method" value="get">
                                    <input type="hidden" name="_token" value="lI8LeypYqvhvIAIdNfLNJWauplrYrkEpZzqJuJKM">
                                    <button type="submit" class="btn btn-primary btn-sm">Редактировать</button>
                                </form>
                            </td>
                            <td>
                                <form action="{{ route('vacancy.destroy',$vacancy->id) }}" method="post">
                                    <input type="hidden" name="_method" value="delete">
                                    <input type="hidden" name="_token" value="lI8LeypYqvhvIAIdNfLNJWauplrYrkEpZzqJuJKM">
                                    <button type="submit" class="btn btn-danger btn-sm">Удалить</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer small text-muted">
                <div class="dataTables_paginate paging_simple_numbers" id="dataTable_paginate">
                    {{ $vacancies->render() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection