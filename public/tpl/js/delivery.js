
    $(function() {
        $.checkDelivery();

        $(window).resize(function() {
            $.checkDelivery();
        });
    });

    $.checkDelivery = function() {
        $('.delivery-item').css({
            height: 'auto'
        });

        MQ = deviceType();

        if (MQ > 992) {
            var split = 2;

            var i = 0;
            var max = 0;
            var allCount = $('.delivery-item').length;
            var cnt = 0;
            var blockH;

            $('.delivery-item').each(function() {
                i++;
                cnt++;

                $(this).addClass('spliter');
                blockH = $(this).height() + 30;

                if (blockH > max) {
                    max = blockH;
                }

                if ((i % split == 0) || (cnt == allCount)) {
                    i = 0;
                    $('.spliter').css({ height: max });
                    max = 0;
                    $('.delivery-item').removeClass('spliter');
                }
            });
        }
    }