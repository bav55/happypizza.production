/**
 * Created by ppc on 29.06.17.
 */
var fastsearchResults = {};
$(function () {
    $("#phone").mask("+7 (999) 999-99-99").autocomplete({
        delay: 500,
        minLength: 3,
        source: function( request, response ) {
            $.get('/admin/users/fastsearch', {phone:request.term}, function (data) {
                var results = [];
                for (var p in data) {
                    fastsearchResults[data[p].phone] = data[p];
                    results.push(data[p].phone);
                }
                response(results);
            });
        },
        select: function( event, ui ) {
            var f = ui.item.value;
            if (fastsearchResults[f]!==undefined) {
                $("#name").val(fastsearchResults[f].name);
                $("#user_id").val(fastsearchResults[f].id);
            }
        }
    });

    $("#name").autocomplete({
        delay: 500,
        minLength: 3,
        source: function( request, response ) {
            $.get('/admin/users/fastsearch', {name:request.term}, function (data) {
                var results = [];
                for (var p in data) {
                    fastsearchResults[data[p].name] = data[p];
                    results.push(data[p].name);
                }
                response(results);
            });
        },
        select: function( event, ui ) {
            var f = ui.item.value;
            if (fastsearchResults[f]!==undefined) {
                $("#phone").val(fastsearchResults[f].phone).trigger('paste');
                $("#user_id").val(fastsearchResults[f].id);
            }
        }
    });


    $(".add-product").click(function (e) {
        e.preventDefault();

        if (order_id) {
            var $button = $(this);

            $.post('/admin/orders/update', {add: $button.data('product-size'), id: order_id}, function (responce) {
                $("#order_items").html(responce);
            })
        } else {
            alert("Сначала нужно создать заказ!");
        }
    });

    $("#delivery_type").change(function () {
        var v = $(this).val();
        var $div = $("#delivery");

        if (v==delivery_courier) {
            $div.removeClass('is-hidden');
        } else {
            $div.addClass('is-hidden');
        }
    });
});

delProduct = function(del) {
    var $button = $(this);

    $.post('/admin/orders/update', {del: del, id: order_id}, function (responce) {
        $("#order_items").html(responce);
    })
};

setPromoCode = function () {
    $.post('/admin/orders/update', {code: $("#promo_code").val(), id: order_id}, function (responce) {
        $("#order_items").html(responce);
    })
};

setUserId = function (obj) {
    $("#user_id").val(obj.value);
    $("#form-name").val(obj.name);
    $("#form-phone").val(obj.phone);
};