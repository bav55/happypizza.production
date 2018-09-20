var reviewSwiper;

$(function () {
    var reviewSwiper = new Swiper('#review-slider .swiper-container', {
        nextButton     : '#next-review',
        prevButton     : '#prev-review',
        pagination     : '#review-pagination',
        paginationType : 'progress',
        slidesPerView  : 3,
        spaceBetween   : 30,
        breakpoints    : {
            992 : {
                slidesPerView : 2
            },
            768 : {
                slidesPerView : 1,
                spaceBetween  : 5
            }
        }
    });

    var $reviewStars = $('#review-stars');
    $reviewStars.find('span').mouseover(function () {
        $reviewStars.removeClass('selected');
        $reviewStars.find('span').removeClass('active');

        var id = $(this).data('id') * 1;
        var i  = 0;

        $reviewStars.find('span').each(function () {
            i++;

            if (i <= id) {
                $(this).addClass('active');
            }
        });
    });

    $reviewStars.mouseleave(function () {
        if (!$reviewStars.hasClass('selected')) {
            $reviewStars.find('span').removeClass('active');
        }
    });

    $reviewStars.on('click', function () {
        var $this = $(this);
        if ($this.hasClass('selected')) {
            $this.removeClass('selected');
        } else {
            $this.addClass('selected');
        }
    });
});

var $review = $('#send-review-block');


function validate_review(starts) {
    var errors = false;
    $review.find('input, textarea').each(function () {
        if ($(this).val() == '') {
            send_error($(this), 'поле обязательное для заполнения');
            errors = true;
        }
    });
    if (starts <= 0){
        $('#review-stars-error p').html('Вам необходимо выбрать оценку').css('display','block');
        errors = true;
    }
    return errors;
}

function send_error(elem, text) {
    elem.parent('.form-group').addClass('has-error');
    elem.next('p').html(text).css('display','block');
}

function sendReview (button) {

    $review.find('input, textarea').parent('.form-group').removeClass('has-error');
    $review.find('input, textarea').next('p').css('display','none');
    $('#review-stars-error p').css('display','none');

    var score = $('#review-stars').find('.active').length;

    if (validate_review(score) == false){
        send_loader(button);
        var requestData = {
            name    : $review.find('input[name="name"]').val(),
            phone   : $review.find('input[name="phone"]').val(),
            message : $review.find('textarea[name="message"]').val(),
            rating   : score
        };

        $.ajax({
            url: link+'/add-reviews',
            type: "post",
            data: requestData,
            dataType: "json",
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            complete: function (xhr) {
                if (xhr.status == '200'){
                    send_loader_error(button);
                    $('#review-modal-success').modal('show');
                    $review.find('input,textarea').val('');
                    $('#review-stars').find('.active').removeClass('active');
                }
            }
        });

    }
}