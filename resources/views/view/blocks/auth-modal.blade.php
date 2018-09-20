<div class="modal modal-happypizza" id="login-modal" tabindex="-1" role="dialog">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog modal-sm vertical-align-center">
            <div class="modal-content">
                <div class="modal-header"><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button><h4 class="modal-title">Вход</h4></div>
                <div class="modal-body">
                    <div class="form-group"><input type="text" name="phone" class="form-control masked-phone phone" placeholder="+7(___)___-__-__" value="{{ old('phone') }}" required autofocus></div>
                    <div class="form-group"><input type="password" class="form-control password" placeholder="Пароль" name="password" required> </div>
                    <div class="form-group"><div class="form-check"><label class="form-check-label" style="font-weight: normal"><input type="checkbox" class="form-check-input" style="position: relative;top: 2px;"> Запомнить меня</label></div></div>
                    <a href="#" data-dismiss="modal" data-toggle="modal" data-target="#password-reset-modal" style="text-decoration: underline;">Забыли пароль?</a>
                    <div class="error is-hidden">ВНИМАНИЕ! Вы ввели неверные данные.<br>Повторите снова</div>
                </div>
                <div class="modal-footer">
                    <button class="btn red-button" onclick="loginAccount(this); return false;">ВХОД</button>
                    <img class="hidden" src="{{ asset('tpl/images/loader.gif') }}">
                    <div class="row"><div class="col-xs-12">&nbsp</div></div>
                    <div class="row"><div class="col-xs-12"><a href="#" data-dismiss="modal" data-toggle="modal" data-target="#registration-modal">РЕГИСТРАЦИЯ</a></div></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-happypizza" id="registration-modal" tabindex="-1" role="dialog">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog modal-sm vertical-align-center">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Регистрация</h4>
                </div>
                <form action="" autocomplete="off">
                <div class="modal-body">
                    <input type="hidden" name="referer_id" value="{{app('request')->input('u')}}"/>
                    <div class="form-group"><input type="text" name="name" class="form-control" placeholder="Ваше имя" required/><p class="help-block"></p></div>
                    <div class="form-group"><input type="text" name="phone" class="form-control masked-phone" placeholder="+7(___)___-__-__" required/><p class="help-block"></p></div>
                    <div class="form-group"><input type="email" name="email" class="form-control" placeholder="E-mail" required/><p class="help-block"></p></div>
                    <div class="form-group"><input type="password" name="password" class="form-control" placeholder="Пароль" required/><p class="help-block"></p></div>
                    <div class="form-group"><input type="password" name="password_confirmation" class="form-control" placeholder="Повторите пароль" required/></div>

                    <div class="error is-hidden">ВНИМАНИЕ! Все поля обязательны для заполнения. Заполните их корректно.</div>
                </div>

                <div class="modal-footer">
                    <button class="btn red-button" type="submit">ЗАРЕГИСТРИРОВАТЬСЯ</button>
                    <img class="hidden" src="{{ asset('tpl/images/loader.gif') }}">
                    <div class="row"><div class="col-xs-12">&nbsp;</div></div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-happypizza modal-happypizza-white" id="registration-modal-success" tabindex="-1" role="dialog">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog modal-sm vertical-align-center">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title text-center" style="margin-top: 0"><strong>Регистрация прошла успешно!</strong></h4>
                </div>
                <div class="modal-body">
                    <p style="text-align: center"><a href="{{ route('account') }}" style="color : #4b4b4b; font-size: 15px; margin-bottom: 15px; display: block; text-decoration: underline;">Войти в личный кабинет</a></p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-happypizza" id="password-reset-modal" tabindex="-1" role="dialog">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog modal-sm vertical-align-center">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Восстановление пароля</h4>
                </div>
                <form action="" autocomplete="off">
                    <div class="modal-body">
                        <p>Введите e-mail чтобы сбросить пароль</p>
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" placeholder="Ваш E-mail" required/>
                        </div>
                        <p>Инструкция будет отправлена на вашу почту</p>
                        <div class="error is-hidden"></div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn red-button">ОТПРАВИТЬ</button>
                        <img class="hidden" src="{{ asset('tpl/images/loader.gif') }}">
                        <div class="row"><div class="col-xs-12">&nbsp;</div></div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>