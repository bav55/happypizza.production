@extends('layouts.guest')

@section('meta-content')
    <title>Оформление заказа</title>
@endsection

@section('content')

    <div id="wrapper" class="is-full cart">
        <div class="container">
            <form action="{{ route('order') }}" id="order-cart">
                <div class="row">
                    <div class="col-xs-12 inner-content">
                        <div id="breadcrumbs" class="is-full"><a href="{{ route('index') }}">Главная</a> / Оформление заказа</div>
                        <div id="page-title" class="is-full"><h1>Оформление заказа</h1></div>
                    </div>
                </div>
                <div class="row"><div class="col-xs-12">&nbsp;</div></div>
                <div class="row"><div class="col-xs-12">&nbsp;</div></div>
                <div class="row"><div class="col-xs-12"><strong>Ваши контактные данные</strong></div></div>
                <div class="row"><div class="col-xs-12">&nbsp;</div></div>
                <div class="row checkout-form">
                    <div class="col-sm-7">
                        <div class="form-horizontal" id="account">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label" style="text-align: left; font-weight: normal;">Ваше имя *</label>
                                <div class="col-sm-6">
                                    <input type="text" id="account-name" name="name" class="form-control" placeholder="" required value="{{ Auth::guest() ? '' : Auth::user()->name }}">
                                    <small class="has-error-text">Поле обязательное</small>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="phone" class="col-sm-2 control-label" style="text-align: left; font-weight: normal;">Телефон *</label>
                                <div class="col-sm-6">
                                    <input type="text" id="account-phone" name="phone" class="form-control masked-phone" required value="{{ Auth::guest() ? '' : Auth::user()->phone }}">
                                    <small class="has-error-text">Поле обязательное</small>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="email" class="col-sm-2 control-label" style="text-align: left; font-weight: normal;">Email </label>
                                <div class="col-sm-6">
                                    <input type="email" id="account-email" name="email" class="form-control"  placeholder="" value="{{ Auth::guest() ? '' : Auth::user()->email }}">
                                    <small class="has-error-text">Поле обязательное</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row"><div class="col-xs-12">&nbsp;</div></div>
                <div class="row"><div class="col-xs-12"><strong>Выберите способ доставки</strong></div></div>
                <div class="row"><div class="col-xs-12">&nbsp;</div></div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="btn-group btn-group-happypizza" role="group" aria-label="...">
                            <input data-type="1" type="button" data-tab="delivery-pickup" class="btn btn-default btn-left delivery_type_id" value="Самовывоз">
                            <input data-type="2" type="button" data-tab="delivery-courier" class="btn btn-default btn-right delivery_type_id btn-active" value="Курьером">
                        </div>
                        <input type="hidden" id="delivery_type_id" name="delivery_type_id" value="2">
                    </div>
                </div>
                <div class="row"><div class="col-xs-12">&nbsp;</div></div>
                <div class="row">
                    <div class="col-sm-7 delivery-pickup is-hidden">
                        <p>Вы можете забрать ваш заказ по адресу г. Алматы, Жандосова 10, уг. Манаса.<br> Время работы: с 09:00 до 22:00</p>
                    </div>

                    <div class="col-sm-4 delivery-courier">
                        <!--<div class="form-group">
                            <div class="dropdown">
                                <button class="form-control" id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Квадрат доставки
                                    <span class="caret"></span>
                                    <input type="hidden" name="delivery_zone_id" value="2" id="delivery_zone_id">
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dLabel">
                                    <li class="delivery_zone_id" data-type="1">
                                        В квадрате улиц Аль-Фараби - Момышулы -<br>
                                        Райымбека - Калдаякова<br>
                                        <br>
                                        Время доставки: в течение 60 минут
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <li class="delivery_zone_id" data-type="2">
                                        За пределами квадрата улиц Аль-Фараби -<br>
                                        Момышулы - Райымбека - Калдаякова<br>
                                        <br>
                                        Время доставки: в течение 1 - 1,5 часа
                                    </li>
                                </ul>
                            </div>
                        </div>--->
                        <div class="form-group"><input type="text" id="street" name="delivery[Улица]" maxlength="40" class="form-control" placeholder="Улица *" value=""><small class="has-error-text">Поле обязательное</small></div>
                        <div class="form-group"><input type="text" id="house" name="delivery[Дом]" maxlength="5" class="form-control" placeholder="Дом *" value=""><small class="has-error-text">Поле обязательное</small></div>
                        <div class="form-group"><input type="text" id="apartment" name="delivery[Квартира]" maxlength="5" class="form-control" placeholder="Квартира" value=""></div>
                        <div class="form-group"><input type="text" id="square" name="delivery[Подъезд]" maxlength="5" class="form-control" placeholder="Подъезд" value=""></div>
                        <div class="form-group"><input type="text" id="floor" name="delivery[Этаж]" maxlength="5" class="form-control" placeholder="Этаж" value=""></div>
                        <div class="form-group"><input type="text" id="code" name="delivery[Код домофона]" maxlength="5" class="form-control" placeholder="Код домофона" value=""></div>
                    </div>
                </div>
                <div class="row"><div class="col-xs-12">&nbsp;</div></div>
                <div class="row"><div class="col-xs-12"><strong>Способ оплаты</strong></div></div>
                <div class="row"><div class="col-xs-12">&nbsp;</div></div>
                <div class="row">
                    <div class="col-xs-12">
                        <div class="btn-group btn-group-happypizza" role="group" aria-label="...">
                            <input type="button" data-type="1" class="pay_type_id btn btn-default btn-left btn-active" value="Наличными">
                            <input type="button" data-type="2" class="pay_type_id btn btn-default btn-right" value="Банковской картой">
                        </div>
                    </div>
                </div>
                <div class="row"><div class="col-xs-12">&nbsp;</div></div>
                <div class="row"><div class="col-xs-12"><strong>Дополнительно</strong></div></div>
                <div class="row checkout-form">
                    <div class="col-sm-7">
                        <div class="form-horizontal" id="contact">
                            <input id="pay_type_id" type="hidden" name="pay_type_id" value="1">

                            @if (Auth::check() && $bonus != null && $bonus != 0)
                                <div class="form-group">
                                    <label for="time" class="col-sm-4 control-label" style="text-align: left; font-weight: normal;">Использовать баллы</label>
                                    <div class="col-sm-6">
                                        <input type="number" id="bonus" name="extra[bonus]" maxlength="5" class="form-control" max="{{ $bonus }}" min="0" data-max-value="{{ $bonus }}" placeholder="До {{ $bonus }} ТГ">
                                    </div>
                                </div>
                            @endif

                            <div class="form-group">
                                <label for="time" class="col-sm-4 control-label" style="text-align: left; font-weight: normal;">Когда доставить заказ?</label>
                                <div class="col-sm-6">
                                    <input type="time" id="time" name="extra[time]" maxlength="5" class="form-control" placeholder="Время" value="">
                                </div>

                                <div class="col-sm-8">
                                    <p style="font-size: 12px;">Заказ будет доставлен на ранее 1-1,5 часа после его оформления.</p>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="money" class="col-sm-4 control-label" style="text-align: left; font-weight: normal;">Нужна сдача с</label>
                                <div class="col-sm-6">
                                    <input type="text" id="money" name="extra[money]" maxlength="6" max="100000" class="form-control" placeholder="Сумма" value="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="comment" class="col-sm-4 control-label" style="text-align: left; font-weight: normal;">Комментарий к заказу</label>
                                <div class="col-sm-6">
                                    <input type="text" id="comment" name="extra[comment]" class="form-control" placeholder="Комментарий" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row cart-actions">
                    <div class="col-xs-12">
                        <a href="{{ route('cart') }}" class="white-button">Назад</a>
                        <button type="submit" class="red-button" id="cart-confirm">Оформить заказ</button>
                        <img class="hidden" src="{{ asset('tpl/images/loader.gif') }}">
                    </div>
                </div>
            </form>

        </div>
    </div>

    <div class="modal modal-happypizza modal-happypizza-white" id="cart-success" tabindex="-1" role="dialog">
        <div class="vertical-alignment-helper">
            <div class="modal-dialog modal-sm vertical-align-center">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><strong>Спасибо за заказ</strong></h4>
                    </div>

                    <div class="modal-body">
                        <div style="margin-bottom: 30px;">
                            <p>Ваша заявка 
                                в обработке. Для подтверждения заказа
                                с вами свяжется оператор.</p>
                        </div>

                        <div style="margin-bottom: 20px;">
                            <p class="order-id">Номер заказа: <strong></strong></p>
                        </div>

                        <div style="margin-bottom: 20px;">
                            <p class="order-time">Время оформления: <strong></strong></p>
                        </div>
                        <div id="sms"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="https://widget.cloudpayments.ru/bundles/cloudpayments"></script>
    <script src="{{ asset('/tpl/js/order.js') }}"></script>
@endsection