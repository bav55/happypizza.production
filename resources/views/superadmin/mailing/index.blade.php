@extends('layouts.admin')

@section('content')

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
        <li class="breadcrumb-item"><a href="{{ route('mailing.index') }}">Рассылка</a></li>
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
                        <div style="color: #000000;" class="col-10"><i class="fa fa-envelope-o"></i> Все рассылки</div>
                        <a href="{{ route('mailing.create') }}" class="col-2 btn btn-primary btn-sm">Добавить</a>
                    </div>
                </div>
                <div>
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <td><strong>id</strong></td>
                            <td><strong>Заголовок</strong></td>
                            <td><strong>Кому</strong></td>
                            <td><strong>Дата</strong></td>
                            <td></td>
                            <td></td>
                        </tr>
                        </thead>
                        <tbody>
                        @if($mails)
                            @foreach($mails as $mail)
                                <tr>
                                    <td>{{ $mail->id }}</td>
                                    <td>{{ $mail->mail_title }}</td>
                                    <td>{{ $mail->mail_to }}</td>
                                    <td>{{ \Carbon\Carbon::parse($mail->created_at)->format('d.m.Y H:i') }}</td>
                                    <td>
                                        <form action="{{ route('mailing.edit', $mail->id) }}" method="post">
                                            <input type="hidden" name="_method" value="get">
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-primary btn-sm">Редактировать</button>
                                        </form>
                                    </td>
                                    <td>
                                        <form action="{{ route('mailing.destroy', $mail->id) }}" method="post">
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
                        {{ $mails->render() }}
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection