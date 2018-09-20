var $prod, $siz;

$(function() {
    $('.multipleSelect').fastselect({});

    $("#products").fastselect();
    $("#sizes").fastselect();
});
$.changedCategory = function (sel) {
    var $select = $(sel), categories = $select.val();

    $.get('/admin/promotions/products?categories='+categories.join(','), function (data) {
        var $prod = $("#products"), $div = $prod.parent().parent();
        $prod.empty();
        var selected = $prod.val(), p, values = {};
        for (p in data) {
            values[data[p].value] = data[p].text;
            $prod.append('<option value="'+data[p].value+'"'+(selected.indexOf(data[p].value)>-1 ? 'selected="selected"' : '')+'>'+data[p].text+'</option>');
        }

        $div.empty();
        var $newProd = $prod.clone();
        $newProd.appendTo($div);
        $newProd.fastselect();

        $.changedProduct($prod);
    });
};

$.changedProduct = function (sel) {
    var $select = $(sel), products = $select.val();

    $.get('/admin/promotions/sizes?products='+products.join(','), function (data) {
        var $size = $("#sizes"), $div = $size.parent().parent();
        $size.empty();
        var selected = $size.val(), p, values = {};
        for (p in data) {
            values[data[p].value] = data[p].text;
            $size.append('<option value="'+data[p].value+'"'+(selected.indexOf(data[p].value)>-1 ? 'selected="selected"' : '')+'>'+data[p].text+'</option>');
        }

        $div.empty();
        var $newSize = $size.clone();
        $newSize.appendTo($div);
        $newSize.fastselect();
    });
};