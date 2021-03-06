var good_btn;
function ChangeComposition(good, id) {
    good_btn = $(good);
    var auth = good_btn.attr('data-auth');
    var parent = $(good).parents('.good-block'),
        good_id = id,
        size_id = parent.find('.menu-list-size select').val(),
        calc = $('#calculated-ingredients'),
        avail = $('#available-ingredients'),
        this_btn = parent.find('.change-ing'),
        price = $('#menu-list-price-' + good_id + ' span').html(),
        modal_parent = $('#ingredients-modal');
    $('#ingredients-count').removeClass('error');
    send_loader_error('#ingredients-ok');
    send_loader(this_btn);
    calc.children('div').remove();
    avail.children('div').remove();
    modal_parent.find('#calculated-ingredients-total span').html('');
    modal_parent.find('#calculated-ingredients-weight span').html('');
    modal_parent.find('#calculated-ingredients-total').attr('data-sum', '');
    modal_parent.find('#calculated-ingredients-weight').attr('data-weight', '');
    modal_parent.find('#constructor_good_id').attr('value', '');
    $.ajax({
        url: link + '/api/constructor/' + good_id,
        type: "get",
        dataType: "json",
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        complete: function (xhr) {
            if (xhr.status == 200) {
                var data = $.parseJSON(xhr.responseText);
                calc.html(data.ingredient);
                avail.html(data.add_ingredient);
                modal_parent.find('#calculated-ingredients-total span').html(price + ' ТГ.');
                modal_parent.find('#calculated-ingredients-total').attr('data-sum', price);
                modal_parent.find('#calculated-ingredients-weight span').html(data.count * 100 + ' г.');
                modal_parent.find('#calculated-ingredients-weight').attr('data-weight', data.count * 100);
                modal_parent.find('#product_size_id').attr('value', size_id);
                modal_parent.find('#constructor_good_id').attr('value', good_id);
                console.log('ChangeComposition');
    $('#calculated-ingredients .ingredient-portions a.active').click();
            }
        }
    });
    modal_parent.modal('show');
    send_loader_error(this_btn);
    
}


/* функция изменение цены при наведении на ингредиент */
function ing_hover(btn) {
    var parent = $(btn).parents('.ingredient-item'),
        price = $(btn).attr('data-price');
    parent.find('.ingredient-price span').html(price + ' тг.');
}
/* функция изменение цены при наведении на ингредиент */


function addIngredient(id, part, btn, int) {
    var a = ing[id]['part_'+part],
        parent_1 = $(btn).parent('.ingredient-portions'),
        block_parent = $(btn).parents('.ingredient-item');
    ing[id]['port'] = part;
    ing[id]['base'] = int;
    if (int == true){
        parent_1.find('a').removeClass('active');
        $(btn).addClass('active');
    } else if (int == false) {
        parent_1.find('a').removeClass('active');
        $(btn).addClass('active');
        if ( hasPerentId( $(btn).attr('data-available-ingredient'), 'available-ingredients' )  ){
            block_parent.append('<div class="col-xs-1"><span class="ingredient-remove pull-right"><a href="#" onclick="removeIngredient(this, '+ id +', false); return false;">x</a></span></div>');
            block_parent.appendTo('#calculated-ingredients');
        }

    }
    CalcIngredients();
}

function removeIngredient(btn, id, int) {
    ing[id]['port'] = 0;
    ing[id]['base'] = null;
    var block_parent = $(btn).parents('.ingredient-item');
    block_parent.find('.col-xs-1').remove();
    block_parent.appendTo('#available-ingredients');
    CalcIngredients();
}

function clearConstructor() {
    good_btn.click();
}

function hasPerentId(elem, id) {
    var el = document.querySelector('a[data-available-ingredient="'+ elem +'"] '),
        res = false;
    while(el.parentNode) {
        if(el.id.indexOf(id) !=-1 ) {
            res = true;
            break;
        }
        el = el.parentNode;
    }
    return res;
}

function CalcIngredients() {
    var summ = parseInt($('#calculated-ingredients-total').attr('data-sum'));
    var weight = parseInt($('#calculated-ingredients-weight').attr('data-weight'));
    $.each(ing, function(){
        if ((typeof this.base == 'undefined' || this.base == true) && this.port == '1'){
            summ +=  0;
        } else if (this.base == 'undefined' || this.base == false){
            var a = this.port, port_a = 'part_' + a;
            summ +=  this[port_a];
        } else if ((this.base == 'undefined' || this.base == true) && this.port == '2'){
            var b = this.port, port_b = 'part_' + b;
            summ +=  this[port_b];
        }

        if ( ( typeof this.base == 'undefined' || this.base == null) || (this.base == true && this.port == '1') ) {
            weight += 0;
        } else if (this.base == true && this.port == '2'){
            weight -= 100;
            weight += this['w_'+this.port];
        } else {
            weight += this['w_'+this.port];
        }
    });
    $('#calculated-ingredients-total span').html(summ + ' ТГ.');
    $('#calculated-ingredients-weight span').html(weight + ' г.');
}


var cons_modal = '#ingredients-modal';
function customGoodSave() {
    var input_name = $(cons_modal + ' input[name="name"]'),
        title = input_name.val(),
        price = $(cons_modal + ' #calculated-ingredients-total span').html(),
        ing_err = $('#ingredients-count'),
        modal_btn = cons_modal + ' #ingredients-ok';
    send_loader(modal_btn);
    ing_err.removeClass('error');
    input_name.removeClass('error');
    input_name.parent('.form-group').find('.help-block').remove();
    if (title == ''){
        input_name.addClass('error');
        input_name.parent('.form-group').append('<p class="help-block" style="display: block;">Это поле обязательно для заполнение</p>');
        send_loader_error(modal_btn);
        stop();
    } else {
        var json = JSON.stringify(ing);
        var requestData = {
            json: json,
            title: title,
            good_id: $(cons_modal + ' #constructor_good_id').attr('value'),
            image: good_btn.parents('.good-block').find('img').attr('src'),
            price: parseInt(price),
            size_id: $(cons_modal + ' #product_size_id').attr('value')
        };
        $.ajax({
            url: link + '/api/custom-good-save',
            type: "GET",
            data: requestData,
            dataType: "json",
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            complete: function (xhr) {
                console.log(xhr);
                console.log('xhr.status'+xhr.status);
                if (xhr.status == '413'){
                    ing_err.addClass('error');
                    send_loader_error(modal_btn);
                } else if (xhr.status == '200') {
                    var res = xhr.responseText;
                    $(cons_modal).modal('hide');
                    $('body').append('<div class="product-add-to-cart"><p>Ваш товар добавлен в корзину</p></div>');
                    setTimeout(function () {
                        $('.product-add-to-cart').remove();
                    }, 1400);
                    setTimeout(cartUpdate, 500);
                }
            }
        });
    }

}