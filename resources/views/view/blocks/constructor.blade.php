<div class="modal modal-happypizza modal-happypizza-white" id="ingredients-modal" tabindex="-1" role="dialog">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog modal-xlg vertical-align-center">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>

                <div class="modal-body" style="padding-top: 0">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xs-12">
                                <p>Введите запоминающееся имя, оно поможет вам в следующий раз быстрее заказать свою любимую пиццу.</p>

                                <div class="row"><div class="col-xs-12">&nbsp;</div></div>

                                <div class="form-group"><input type="text" name="name" class="form-control" placeholder="Название моей пиццы"></div>

                                <input type="hidden" id="product_size_id" name="product_size_id" value="">
                                <input type="hidden" id="constructor_good_id" value="">
                            </div>
                        </div>

                        <div class="row"><div class="col-xs-12">&nbsp;</div></div>

                        <div class="row">
                            <div class="col-md-6 col-xs-12">
                                <div style="/* height: 38px; */display: inline-block;position: relative;font-family: 'BebasNeue', 'Arial', serif;font-size: 36px;font-weight: bold;text-transform: uppercase;color: #c32b2a;line-height: 38px;">Ингредиенты</div>
                                

                                <p>Ваша пицца уже содержит:</p>

                                <div class="row"><div class="col-xs-12" id="calculated-ingredients" data-base-weight="0"></div>




                                    <div class="col-xs-12">&nbsp;</div><div class="col-xs-12">&nbsp;</div><div class="col-xs-12">&nbsp;</div>
                                </div>
                            </div>

                            <div class="col-md-6 col-xs-12">
                                <div style="height: 38px;">&nbsp;</div>

                                <p>Доступные ингредиенты*:</p>

                                <div class="row"><div class="col-xs-12" id="available-ingredients"></div></div>
                            </div>
                            <div class="col-md-12 col-xs-12">
                                <div class="row">
                                    <div class="col-lg-6 col-xs-12">
                                        <span id="calculated-ingredients-weight" class="pull-right" style="margin-left: 10px; line-height: 36px;">ВЕС: <span></span></span>
                                        <span id="calculated-ingredients-total" class="pull-right" style="line-height: 36px;">ИТОГО: <span></span> </span>
                                        <button type="button" onclick="clearConstructor(this); return false;" class="btn red-button">Сбросить</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row"><div class="col-xs-12">&nbsp</div></div>

                        <div class="row">
                            <div class="col-xs-12">
                                <p id="ingredients-count">* У пиццы может быть до 15 любых ингредиентов, иначе она просто не пропечется.</p>
                                <p>Стоимость дополнительных ингредиентов прибавляется к стоимости пиццы.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer text-center">
                    <a id="ingredients-error" class="error is-hidden">Вы не можете использовать более 15 ингредиентов.</a>
                    <button id="ingredients-ok" onclick="customGoodSave(this)" class="btn red-button">СОХРАНИТЬ И ДОБАВИТЬ В КОРЗИНУ</button>
                    <img class="hidden" src="{{ asset('tpl/images/loader.gif') }}">
                </div>
            </div>
        </div>
    </div>
</div>