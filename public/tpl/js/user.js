/* авторизация пользователя */
loginAccount = function (button) {
    send_loader(button);
    /* собираем данные с элементов страницы: */
    var $modal        = $('#login-modal');
    var $modalSuccess = $('#login-modal-success'),
        requestData = {
            phone: $modal.find('.phone').val(),
            password : $modal.find('.password').val()
    };
    /* отправляем данные методом POST */
    $.ajax({
        url: link + '/login',
        type: "post",
        data: requestData,
        dataType: "POST",
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        complete: function (xhr) {
            if (xhr.status == 200){
                location.reload();
            } else {
                $modal.find('.error.is-hidden').css('display', 'block');
                send_loader_error(button);
            }
        }
    });
};
/* авторизация пользователя */

/* валидация при регистрации пользователя */
var register_id = '#registration-modal';
function validate_registrate() {
    var errors = false;
    $(register_id + ' input').each(function () {
        //console.log($(this));
        if ($(this).val() == '' && $(this).attr('name') != 'referer_id'){
            register_error($(this).attr('name'), 'поле обязательное для заполнения');
            errors = true;
        }
        var pass = $(register_id + "input[name=password]");
        var re_pass = $(register_id + "input[name=password_confirmation]");
        if (pass.val() != re_pass.val()){
            pass.addClass('error');
            re_pass.addClass('error');
            pass.next('p').css('display','block').html('пароли не совпадают');
            errors = true;
        }
    });
    return errors;
}
/* валидация при регистрации пользователя */

/* регистрация пользователя */
$(register_id + ' form').submit(function () {
    $(register_id + ' .help-block').css('display','none').html('');
    $(register_id + ' input').removeClass('error');
    if (validate_registrate() == false){
        send_loader(register_id + ' button');
        /* отправляем данные методом POST */
        $.ajax({
            url: link + '/register',
            type: "post",
            data: $(register_id + ' form').serialize(),
            dataType: "POST",
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            complete: function (xhr) {
                if (xhr.status == 422){
                    var response_text = $.parseJSON(xhr.responseText);
                    //console.log(response_text);
                    $.each( response_text, function( key, value ) {
                        register_error(key, value);
                    });
                    send_loader_error(register_id + ' button');
                }
                if (xhr.status == 200){
                    $(register_id).hide();
                    $('#registration-modal-success').show();
                }
            }
        });
    }

    return false;
});
/* регистрация пользователя */

/* востановление пароля */
var reset_modal = '#password-reset-modal';
$(reset_modal + ' form').submit(function () {
    send_loader(reset_modal + ' button');
    /* отправляем данные методом POST */
    $.ajax({
        url: link + '/password/email',
        type: "post",
        data: $(reset_modal + ' form').serialize(),
        dataType: "POST",
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        complete: function (xhr) {
            console.log(xhr);
            send_loader_error(reset_modal + ' button');
        }
    });
    return false;
});
/* востановление пароля */

/* вывод ошибки валидации */
function register_error(name, html_val){
    var input_name = $('input[name$= '+ name +' ]');
    input_name.addClass('error');
    input_name.next('p').css('display','block').html(html_val);
}
/* вывод ошибки валидации */

function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}

$(function(){
    var u = getUrlVars()["u"];
    if(typeof(u) != "undefined" && u !== null) {
        $('#registration-modal').modal('show')
    }
});
