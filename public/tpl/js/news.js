
    $(function() {
        $.checkNews();

        $(window).resize(function() {
            $.checkNews();
        });
    });

    $.checkNews = function() {
        $('.news-list-item').css({
            height: 'auto'
        });

        MQ = deviceType();

        if (MQ > 430) {
            var split = 3;

            if (MQ <= 992) {
                split = 2;
            }

            var i = 0;
            var max = 0;
            var allCount = $('.news-list-item').length;
            var cnt = 0;
            var blockH;

            $('.news-list-item').each(function() {
                i++;
                cnt++;

                $(this).addClass('spliter');
                blockH = $(this).height() + 20;

                if (blockH > max) {
                    max = blockH;
                }

                if ((i % split == 0) || (cnt == allCount)) {
                    i = 0;
                    $('.spliter').css({ height: max });
                    max = 0;
                    $('.news-list-item').removeClass('spliter');
                }
            });
        }
    }