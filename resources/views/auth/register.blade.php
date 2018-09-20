<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="robots" content="noindex,nofollow">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Регистрация</title>
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/sb-admin.css') }}" rel="stylesheet">
</head>
<body class="bg-dark">
<div class="container">
    <div class="card card-register mx-auto mt-5">
        <div class="card-header">Регистрация пользователя</div>
        <div class="card-body">
            <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label>Ваше имя</label>
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="{{ $errors->has('phone') ? ' has-error' : '' }}">
                                <label>Номер телефона</label>
                                <input type="text" class="form-control masked-phone" name="phone" placeholder="+7(___)___-__-__" value="{{ old('phone') }}" required>
                                @if ($errors->has('phone'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email">Ваш E-Mail</label>
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password">Пароль</label>
                                <input id="password" type="password" class="form-control" name="password" required>
                                @if ($errors->has('password'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="password-confirm">Повторите пароль</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Регистрация</button>

            </form>
            <div class="text-center">
                <a class="d-block small mt-3" href="{{ url('login') }}">Вход</a>
                <a class="d-block small" href="{{ url('password/reset') }}">Забыли пароль?</a>
            </div>
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