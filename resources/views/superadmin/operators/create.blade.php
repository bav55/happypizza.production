@extends('layouts.admin')

@section('content')

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
        <li class="breadcrumb-item"><a href="{{ route('operators.index') }}">Операторы</a></li>
        <li class="breadcrumb-item"><a href="{{ route('operators.create') }}">Добавление оператора</a></li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <form role="form" action="{{ route('operators.store') }}" method="post">
                    <input type="hidden" name="_method" value="post">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="box-body pad">
                                <div class="form-group">
                                    <label>Имя</label>
                                    <input type="text" name="name" class="form-control" required="" placeholder="Введите имя оператора">
                                </div>
                                <div class="form-group">
                                    <label>Номер телефона</label>
                                    <input type="text" class="form-control masked-phone" name="phone" placeholder="+7(___)___-__-__"  required>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" name="email" class="form-control" required="" placeholder="Enter ...">
                                </div>
                                <div class="form-group">
                                    <label>Пароль</label>
                                    <input type="password" name="password" class="form-control" required="" placeholder="Enter ...">
                                </div>

                                <hr>

                                <button type="submit" class="btn btn-primary">Сохранить</button>
                                <hr>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('tpl/js/jquery.min.js') }}"></script>
    <script src="{{ asset('tpl/js/maskedinput.js') }}"></script>
    <script>
        $(document).ready(function ($) {
            $('.masked-phone').mask('+7(999)9999999');
        });
    </script>
@endsection