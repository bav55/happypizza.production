    
    var slides;

    $(function() {
        $.checkIndex();

        $(window).resize(function() {
            $.checkIndex();
        });

        slides = new Swiper('#index-slide .swiper-container', {
            nextButton: '#next',
            prevButton: '#prev',
            slidesPerView: 1,
            loop: true,
            speed: 500,
            simulateTouch: false,
            pagination: '.swiper-pagination',
            paginationClickable: true,
            autoHeight : true,
            autoplay : 4000
        });
    });

    $.checkIndex = function() {
        var w = $('#slides').width() - Math.round(($('#slides').width() - $('#slides .container').width()) / 2) - 305;

        $('#index-slide').css({
            width: w,
            visibility: 'visible'
        });

        $('.slide-item').css({
            height: $('#slides').height()
        });
    }