$(function() {
    $('.multipleSelect').fastselect({
        placeholder: 'Выберите товары'
    });
});

$.addFreeProduct = function () {
    $('#frees').append($('#free-form').html());
};

$.removeFreeProduct = function (button) {
    var $button = $(button);

    $button.parents('.free-product').remove();
}