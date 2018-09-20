<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="robots" content="noindex,nofollow">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Авторизация</title>
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/sb-admin.css') }}" rel="stylesheet">
</head>
<body class="bg-dark">
<div class="container">
    <div class="card card-login mx-auto mt-5">
        <div class="card-header">
            Авторизация
        </div>
        <div class="card-body">
            <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                    <label for="exampleInputEmail1">Номер телефона</label>
                    <input type="text" name="phone" class="form-control masked-phone" placeholder="+7(___)___-__-__" value="{{ old('phone') }}" required autofocus>
                    @if ($errors->has('phone'))
                        <span class="help-block">
                            <strong>{{ $errors->first('phone') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="exampleInputPassword1">Пароль</label>
                    <input type="password" class="form-control" placeholder="Пароль" name="password" required>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox" class="form-check-input">
                            Запомнить меня
                        </label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block"> Вход</button>
            </form>
        </div>
    </div>
</div>
<script src="{{ asset('tpl/js/jquery.min.js') }}"></script>
<script src="{{ asset('tpl/js/maskedinput.js') }}"></script>
<script>
    $(document).ready(function () {
        $('.masked-phone').mask('+7(999)999-99-99');
    });
</script>
</body>
</html>