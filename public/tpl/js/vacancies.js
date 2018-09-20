
    $(function() {
        $.checkVac();

        $(window).resize(function() {
            $.checkVac();
        });
    });

    $.checkVac = function() {
        MQ = deviceType();

        $('.vacancie-item').css({
            height: 'auto'
        });

        MQ = deviceType();

        if (MQ > 992) {
            var split = 3;

            var i = 0;
            var max = 0;
            var allCount = $('.vacancie-item').length;
            var cnt = 0;
            var blockH;

            $('.vacancie-item').each(function() {
                i++;
                cnt++;

                $(this).addClass('spliter');
                blockH = $(this).height() + 47;

                if (blockH > max) {
                    max = blockH;
                }

                if ((i % split == 0) || (cnt == allCount)) {
                    i = 0;
                    $('.spliter').css({ height: max });
                    max = 0;
                    $('.vacancie-item').removeClass('spliter');
                }
            });
        }
    }