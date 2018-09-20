@extends('layouts.guest')

@section('content')
    <script src="https://yastatic.net/es5-shims/0.0.2/es5-shims.min.js"></script>
    <script src="https://yastatic.net/share2/share.js" charset="utf-8" async="async"></script>
    <div id="wrapper" class="is-full">
        <div class="container">
            <div class="row">

                @include('view.account.menu')

                <div class="col-md-9 col-sm-8 col-xs-7 no-lp inner-content">
                    <div id="breadcrumbs" class="is-full">
                        <a href="{{ route('index') }}">Главная</a> /
                        <a href="{{ route('account') }}">Личный кабинет</a> /
                        <span>Мои данные</span>
                    </div>

                    <div id="page-title"><h1>мои данные</h1></div>

                    <div class="container-fluid account-data">
                        <div class="row">
                            <div class="col-xs-4">Дата регистрации</div>
                            <div class="col-xs-4"><span style="color: #969696">{{ $user->created_at }}</span></div>
                            <div class="col-xs-4">&nbsp;</div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-sm-4">Ваша партнерская ссылка</div>
                            <div class="col-xs-12 col-sm-4"><span style="color: #969696"><a href="{{ route('index',['u' => $user->id]) }}">{{ route('index',['u' => $user->id]) }}</a></span></div>
                            <div class="col-xs-12 col-sm-4">&nbsp;
                                <meta property="og:title" content="HappyPizza - Быстрая доставка пиццы и суши в Алматы"/>
                                <meta property="og:description" content="Быстрая доставка пиццы и суши в Алматы"/>
                                <meta property="og:image" content="http://happypizza.kz/tpl/images/logo.png"/>
                                <meta property="og:url" content= "{{ route('index',['u' => $user->id]) }}" />
                                <div class="ya-share2" data-services="vkontakte,facebook,odnoklassniki,twitter,viber,whatsapp,skype" data-url="{{ route('index',['u' => $user->id]) }}" data-title="HappyPizza" data-description="Быстрая доставка пиццы и суши в Алматы" data-image="http://happypizza.kz/tpl/images/logo.png" data-lang="ru"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-4">Имя&nbsp;* </div>
                            <div class="col-xs-4 account-value">
                                <span>{{ $user->name }}</span>
                                <input name="name" type="text" class="account-input form-control hidden" value="{{ $user->name }}">
                            </div>
                            <div class="col-xs-4">
                                <a href="#" class="account-change" onclick="$.editAccount(this); return false;">Изменить</a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-4">Фамилия</div>
                            <div class="col-xs-4 account-value">
                                <span>{{ $user->surname != null ? $user->surname : '' }}</span>
                                <input name="surname" type="text" class="account-input form-control hidden" value="{{ $user->surname != null ? $user->surname : '' }}">
                            </div>
                            <div class="col-xs-4">
                                <a href="#" class="account-change" onclick="$.editAccount(this); return false;">Изменить</a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-4">Отчество</div>
                            <div class="col-xs-4 account-value">
                                <span>{{ $user->middlename != null ? $user->middlename : '' }}</span>
                                <input name="middlename" type="text" class="account-input form-control hidden" value="{{ $user->middlename != null ? $user->middlename : '' }}">
                            </div>
                            <div class="col-xs-4">
                                <a href="#" class="account-change" onclick="$.editAccount(this); return false;">Изменить</a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-4">Дата рождения</div>
                            <div class="col-xs-4 account-value">
                                <span>{{ $user->birthday != null ? $user->birthday : '' }}</span>
                                <input name="birthday" type="text" class="account-input form-control hidden datepicker" value="{{ $user->birthday != null ? $user->birthday : '' }}">
                            </div>
                            <div class="col-xs-4">
                                <a href="#" class="account-change" onclick="$.editAccount(this); return false;">Изменить</a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xs-4">Телефон&nbsp;*</div>
                            <div class="col-xs-4 account-value">
                                <span>{{ $user->phone }}</span>
                                <input name="phone" type="text" class="account-input masked-phone form-control hidden" value="{{ $user->phone }}">
                            </div>
                            <div class="col-xs-4">
                                <a href="#" class="account-change" onclick="$.editAccount(this); return false;">Изменить</a>
                            </div>
                        </div>

                        <div class="row no-border">
                            <div class="col-xs-12">&nbsp;</div>
                        </div>

                        <div class="row no-border">
                            <div class="col-xs-4">Сменить пароль</div>
                            <div class="col-xs-4 account-value">
                                <input name="password" type="password" class="form-control" placeholder="Введите новый пароль" style="margin-top: 5px;">
                            </div>
                            <div class="col-xs-4">
                                <a href="#" onclick="$.changePassword(this); return false;">Изменить</a>
                            </div>
                        </div>

                        <div class="row no-border"><div class="col-xs-12">&nbsp;</div></div>
                        <div class="row no-border"><div class="col-xs-12">&nbsp;</div></div>

                        <div class="row no-border"><div class="col-xs-12"><p style="font-size: 12px;">Поля, отмеченные * обязательны для заполнения</p></div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        #wrapper {background: #FFF;}
    </style>

@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('tpl/css/jquery-ui.min.css') }}">
@endsection

@section('script')
    <script src="{{ asset('tpl/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('tpl/js/datepicker.js') }}"></script>
    <script src="{{ asset('tpl/js/account.js') }}"></script>
@endsection
