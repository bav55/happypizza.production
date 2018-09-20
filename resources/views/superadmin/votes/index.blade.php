@extends('layouts.admin')

@section('content')

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
        <li class="breadcrumb-item"><a href="{{ route('votes.index') }}">Опросы</a></li>
    </ol>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div style="color: #000000;" class="col-10"><i class="fa fa-thumbs-o-up"></i> Опросы</div>
                        <a href="{{ route('votes.create') }}" class="col-2 btn btn-primary btn-sm">Добавить</a>
                    </div>
                </div>
                <div>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <td><strong>Заголовок</strong></td>
                            <td><strong>Отображать на сайте</strong></td>
                            <td></td><td></td>
                        </tr>
                        </thead>
                        <tbody>
                        @if($votes)
                            @foreach($votes as $vote)
                                <tr>
                                    <td>{{ $vote->title }}</td>
                                    <td>{!! $vote->is_show == true ? '<i class="fa fa-check-square-o"></i>' : '<i class="fa fa-times-rectangle-o"></i>' !!}</td>
                                    <td>
                                        <form action="{{ route('votes.edit',$vote->id) }}" method="post">
                                            <input type="hidden" name="_method" value="get">
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-primary btn-sm">Редактировать</button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{ route('votes.destroy',$vote->id) }}" method="post">
                                            <input type="hidden" name="_method" value="delete">
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-danger btn-sm">Удалить</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                <div class="card-footer small text-muted">
                    <div class="dataTables_paginate paging_simple_numbers" id="dataTable_paginate">
                        {{ $votes->render() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection