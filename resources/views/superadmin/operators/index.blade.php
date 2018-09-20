@extends('layouts.admin')


@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
        <li class="breadcrumb-item"><a href="{{ route('operators.index') }}">Операторы</a></li>
    </ol>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <a href="{{ route('operators.index') }}" style="color: #000000;" class="col-10"><i class="fa fa-star-half-o"></i> Все операторы</a>
                        <a href="{{ route('operators.create') }}" class="col-2 btn btn-primary btn-sm">Добавить</a>
                    </div>
                </div>
                @if (count($operators) > 0)
                    <div>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <td><strong>Имя</strong></td>
                                <td><strong>email</strong></td>
                                <td><strong>Телефон</strong></td>
                                <td><strong>Дата создания</strong></td>
                                <td></td><td></td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($operators as $operator)
                                <tr>
                                    <td>{{ $operator->name }}</td>
                                    <td>{{ $operator->email }}</td>
                                    <td>{{ $operator->phone }}</td>
                                    <td>{{ \Carbon\Carbon::parse($operator->created_at)->format('d.m.Y') }}</td>
                                    <td>
                                        <form action="{{ route('operators.edit', $operator->id ) }}" method="post">
                                            <input type="hidden" name="_method" value="get">
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-primary btn-sm">Редактировать</button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{ route('operators.destroy', $operator->id) }}" method="post">
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
                        {{ $operators->render() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection