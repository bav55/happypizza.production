$.editAccount = function (button) {
    var $button = $(button), $accountPhones;
    var $value = $button.closest('.row').find(".account-value");
    $value.find("span").addClass("hidden");
    $value.find("input").removeClass("hidden");
    if ($accountPhones = $value.find('.account-phones')) {
        $accountPhones.find('a').removeClass('hidden');
    }
    $button.attr('onclick', '$.saveAccount(this); return false;');
    $button.text('Сохранить');
};

$.saveAccount = function (button) {
    var $button = $(button);
    var $value  = $button.closest('.row').find(".account-value");
    var $input  = $value.find(':input');
    ajax_account($input.serialize(),link + '/account/update', true);
};

$.changePassword = function (button) {
    var $button = $(button);
    var $input  = $button.parent().prev().find(':input');
    var update = ajax_account($input.serialize(),link + '/account/update/password', false);
};

function ajax_account(data, url, reloaded) {
    $.ajax({
        url: url,
        type: "post",
        data: data,
        dataType: "POST",
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        complete: function (xhr) {
            if (xhr.status == 200){
                if (reloaded == true){
                    location.reload();
                } else {
                    $('body').append('<div class="product-add-to-cart"><p>' + xhr.responseText + '</p></div>');
                    setTimeout(function () {
                        $('.product-add-to-cart').remove();
                    }, 1400);
                }
            }
        }
    });
}