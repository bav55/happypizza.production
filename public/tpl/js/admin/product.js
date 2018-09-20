$(function () {
    $('#ingredients').fastselect({
        placeholder : 'Выберите ингредиенты'
    });

    $('#preferences').fastselect({
        placeholder : 'Выберите предпочтения'
    });
});

$.addSize = function () {
    $('#sizes').append($('#sizes-block').html());
};

$.removeSize = function (button) {
    var $button = $(button);

    $button.parents('.product-size').remove();
};

$.addIngredient = function (button) {
    var $button    = $(button);
    var $modalBody = $button.parents('.modal-body');
    var $template    = $modalBody.find('#product-ingredient-template');
    var $ingredients = $modalBody.find('#product-ingredients');

    $ingredients.append($template.html());
};

$.removeIngredient = function (button) {
    var $button = $(button);

    $button.parents('.product-ingredient').remove();
};

$.saveIngredients = function (button) {
    $.post('/admin/ingredients_save', $("#product-size-ingredients-form").serialize(), function (response) {
        $('#product-ingredients-modal').modal('hide');
    }, 'json');
};

$("#product-ingredients-modal").on("shown.bs.modal", function (e) {
    var $button = $(e.relatedTarget);
    var $modal  = $(this);

    $.get($button.data('href'), function (response) {
        $modal.find('.modal-title span').html(response.title);
        $modal.find('.modal-body').html(response.content);
    }, 'json')
});

editable_size = function (elem) {
    var $checkbox = $(elem);
    var v = $checkbox.prop("checked") ? 1 : 0;
    $checkbox.parent().find('input[type="hidden"]').val(v);
};

is_default_ingredient = function (elem) {
    var $checkbox = $(elem);
    var v = $checkbox.prop("checked") ? 1 : 0;
    $checkbox.parent().find('input[type="hidden"]').val(v);
};
is_removable_ingredient = function (elem) {
    var $checkbox = $(elem);
    var v = $checkbox.prop("checked") ? 1 : 0;
    $checkbox.parent().find('input[type="hidden"]').val(v);
};
is_single_ingredient = function (elem) {
    var $checkbox = $(elem);
    var v = $checkbox.prop("checked") ? 1 : 0;
    $checkbox.parent().find('input[type="hidden"]').val(v);
};