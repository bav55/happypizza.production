//вспомогательные - размер экрана и всего документа
function getClientWidth(){return document.compatMode=='CSS1Compat' && !window.opera?document.documentElement.clientWidth:document.documentElement.clientWidth;}//document.body.clientWidth
function getClientHeight(){return document.compatMode=='CSS1Compat' && !window.opera?document.documentElement.clientHeight:document.documentElement.clientHeight;}//document.body.clientHeight
function getBodyScrollTop(){return self.pageYOffset || (document.documentElement && document.documentElement.scrollTop) || (document.body && document.body.scrollTop);}
function getBodyScrollLeft(){return self.pageXOffset || (document.documentElement && document.documentElement.scrollLeft) || (document.body && document.body.scrollLeft);}

function removeFromCart(button) {
    var $button  = $(button);
    var productId   = $button.data('good'),
        requestData = {
            good_id    : productId,
            size: $button.data('size')
        };
    $.ajax({
        url: link + '/remove-at-cart',
        type: "get",
        data: requestData,
        dataType: "html",
        success: function (msg) {
            location.reload();
            $('#data-'+productId).remove();
            $('body').append('<div class="product-add-to-cart"><p>' + msg + '</p></div>');
            setTimeout(function () {
                $('.product-add-to-cart').remove();
            }, 1400);
            setTimeout(cartUpdate, 500);
        }
    });
}

/* rePriceGood */
function CartRePrice(val) {
    var $button  = $(val);
    var $product = $button.parents('.cart-products-list-item');
	
	localStorage.clear();
	localStorage.setItem('ScrollTop',getBodyScrollTop());

    var protocol = window.location.protocol;
    var hostname = window.location.hostname;
    var link = protocol+'//'+hostname;

    var productId = $(val).data('select');
    var old_size = $(val).data('gredient');
    var size_id = $(val).val();
    var count = $product.find('.ml-count').text(),
        requestData = {
            good_id    : productId,
            size_id    : size_id,
            count      : count,
            old_size   : old_size
        };
    $.ajax({
        url: link+'/api/portion',
        type: "GET",
        data: requestData,
        dataType: "html",
        success: function (msg) {
            $('#cart-product-item-price-' + productId + ' span').html(msg);
            location.reload();
        }
    });
}
/* rePriceGood */

/* plus and minus good count */
$('.cart-item-bottom .plus').click(function () {
    var $count = $(this).prev(),
        count  = parseInt($count.text(), 10);
    count++;
    GoodCountUpdate($(this), count);
    $count.text(count);
});

$('.cart-item-bottom .minus').click(function () {
    var $count = $(this).next(),
        count  = parseInt($count.text(), 10);
    count--;
    if (count < 1) {
        count = 1;
    }
    GoodCountUpdate($(this), count);
    $count.text(count);
});
/* plus and minus good count */

/* update cart good count */
function GoodCountUpdate(button, amount) {
    var $button  = $(button);
    var $product = $button.parents('.cart-products-list-item');
	
	localStorage.clear();
	localStorage.setItem('ScrollTop',getBodyScrollTop());

    var productId = $product.data('good'),
        size_id = $product.find('.cart-size-select').val(),
        count = amount,
        requestData = {
            good_id    : productId,
            size_id    : size_id,
            count      : count
        };
    $.ajax({
        url: link + '/good-count',
        type: "GET",
        data: requestData,
        dataType: "html",
        success: function (msg) {
            if (msg == 'ok'){
                location.reload();
            }
        }
    });
}
/* update cart good count */

/* Apply Promo Code in Cart */
function applyCode() {
    var code = $('#promo-code').val();
    //console.log(code);
    $.ajax({
        url: link + '/apply-promo/'+code,
        type: "GET",
        dataType: "html",
        complete: function (xhr) {
        if (xhr.status == 200){
            location.reload();
        } else {
            $('#promo-error').html('Неверный промо-код');
        }
    }
    });
}
/* Apply Promo Code in Cart */