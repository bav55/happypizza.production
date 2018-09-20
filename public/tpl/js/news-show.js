
    $(function() {
        $.checkTilDate();

        $(window).resize(function() {
            $.checkTilDate();
        });
    });

    $.checkTilDate = function() {
        MQ = deviceType();

        $('.news-show-description').css('min-height', 'auto');

        if ($('.news-show-image').length > 0) {
            if (MQ > 992) {
                $('.news-show-description').css('min-height', $('.news-show-image').height());
            }
        }
    }