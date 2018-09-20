/**
 * Created by https://t.me/ppc21
 */

var lastCheck;

$(function () {
    lastCheck = Math.floor(Date.now() / 1000);
    var orderNotify = setInterval(checkNewOrders, 60000);
});

var checkNewOrders = function () {
    $.post('/admin/orders/check', {stamp:lastCheck}, function (data) {
        if (data.result == 'success') {
            var audio = new Audio();
            audio.src = '/audio/new_order.wav';
            audio.autoplay = true;

            for (var p in data.ids) {
                var id= data.ids[p];
                $.notify({
                    message: 'Новый заказ № Е'+id
                },{
                    // settings
                    type: 'success',
                    delay: 0,
                    animate: {
                        enter: 'animated fadeInDown',
                        exit: 'animated fadeOutUp'
                    }
                });
            }

            lastCheck = Math.floor(Date.now() / 1000);
        }
    });
};