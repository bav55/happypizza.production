<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="robots" content="noindex,nofollow">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Восстановление пароля</title>
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/sb-admin.css') }}" rel="stylesheet">
</head>
<body class="bg-dark">
<div class="container">

    <div class="card card-login mx-auto mt-5">
        <div class="card-header">Восстановление пароля</div>
        <div class="card-body">
            <div class="text-center mt-4 mb-5">
                <h4>Забыли пароль?</h4>
                <p>Введите свой адрес электронной почты, и мы отправим вам инструкции о том, как сбросить пароль</p>
            </div>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                {{ csrf_field() }}

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email">Введите ваш E-mail</label>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary btn-block">Восстановить</button>
            </form>
            <div class="text-center">
                <a class="d-block small mt-3" href="{{ url('register') }}">Регистрация</a>
                <a class="d-block small" href="{{ url('login') }}">Вход</a>
            </div>
        </div>
    </div>
</div>

</body>
</html>
