function isMobile() {
    var check = false;
    (function (a) {if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4))) check = true;})(navigator.userAgent || navigator.vendor || window.opera);
    return check;
}

var protocol = window.location.protocol;
var hostname = window.location.hostname;
var link = protocol+'//'+hostname;

$(document).ready(function () {
    $('.masked-phone').mask('+7(999)9999999');
	if (localStorage.getItem('ScrollTop')){
		window.scrollTo(0,localStorage.getItem('ScrollTop'));
	} else {
		window.scrollTo(0,0);
	}
	
});

function reloded() {
    window.location.reload();
}

/* main-slider */
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

/* main-slider */

/* hover to phone */
if (isMobile()) {
    $('.phones-handler').click(function () {
        var $handler = $(this).parents('.phones-holder');

        $handler.toggleClass('hovered');
    });

    $('.phones-list li').click(function () {
        $('.main-phone').html($(this).html() + '<i class="phones-handler"></i>');
        $('.phones-holder').removeClass('hovered');
        $('.phones-list').hide();
    });
} else {
    $('.phones-holder').find('a').each(function () {
        var $link = $(this);

        $link.after($link.html());
        $link.remove();
    });

   /* $('.phones-holder').mouseover(function () {
        $(this).find('.phones-list').show();
    }).mouseout(function () {
        $('.phones-list').hide();
    });*/

   /* $('.phones-list li').click(function () {
        $('.main-phone').html($(this).html() + '<i class="phones-handler"></i>');
        $('.phones-list').hide();
    });*/
}
/* hover to phone */

/* show-hide seo content */
var read_more = $('#about .read-more');
var seo_text_block = $('#about .seo_text_block');
function readMore(val) {
    seo_text_block.stop().animate({
        height: '100%'
    }, 600);
    $(val).remove();
    read_more.append('<a onclick="hideMore(this)">Скрыть <i class="fa fa-angle-up"></i></a>');
};
function hideMore(val) {
    seo_text_block.stop().animate({
        height: '55px',
        overflow: 'hidden'
    }, 300);
    $(val).remove();
    read_more.append('<a onclick="readMore(this)">Читать далее <i class="fa fa-angle-down"></i></a>');
};
/* show-hide seo content */


/* rePriceGood */
function rePrice(val) {
    var productId = $(val).data('select');
    var size_id = $(val).val();
    var requestData = {
        size_id    : size_id
    };
    $.ajax({
        url: link + '/api/portion-reprice',
        type: "GET",
        data: requestData,
        dataType: "html",
        success: function (msg) {
            $('#menu-list-price-' + productId + ' span').html(msg);
        }
    });
}
/* rePriceGood */

/* plus and minus good count */
$('.menu-list-settings .plus').click(function (e) {
    var $count = $(this).prev(),
    count  = parseInt($count.text(), 10);
    count++;
    $count.text(count);
});

$('.menu-list-settings .minus').click(function (e) {
    var $count = $(this).next(),
        count  = parseInt($count.text(), 10);
    count--;
    if (count < 1) {
        count = 1;
    }
    $count.text(count);
});
/* plus and minus good count */

/* accordion faq */
$('.faq-question').click(function () {
    if ( $(this).hasClass('active') ){
        $(this).removeClass('active');
        $(this).next('.faq-answer').slideUp('slow');
    }
    else {
        $('.faq-question').removeClass('active');
        $('.faq-answer').slideUp('slow');
        $(this).addClass('active');
        $(this).next('.faq-answer').slideDown('slow');
    }
});
/* accordion faq */

/* faq show modal */
var faq_modal = '#faq-modal';

$.askQuestion = function() {
    $(faq_modal).modal('show');
};
/* faq show modal */

/* faq show modal send */
$(faq_modal).submit(function () {
    $(faq_modal+' .modal-footer button').hide();
    $(faq_modal+' .modal-footer img').show();
    var $faq = $(faq_modal);
    var requestData = {
        name  : $faq.find('input[name="name"]').val(),
        phone : $faq.find('input[name="phone"]').val(),
        message : $faq.find('input[name="message"]').val()
    };
    $.ajax({
        url: link + '/faq/request/',
        type: "get",
        data: requestData,
        dataType: "html",
        success: function (msg) {
            $(faq_modal+' .modal-body div').remove('div');
            $(faq_modal+' .modal-footer').remove();
            $(faq_modal+' .modal-body').append(msg);
        }
    });
    return false;
});
/* faq show modal send */

/* addToCart */
function addToCart(button) {
    var $button  = $(button);
    var $product = $button.parents('.menu-list-item');
    var productId   = $button.data('good'),
    sizeId      = $product.find('.product-size-select').val(),
    count    = $product.find('.ml-count').text(),
    requestData = {
        good_id    : productId,
        size_id    : sizeId,
        count      : count
    };
    $.ajax({
        url: link + '/add-to-cart',
        type: "get",
        data: requestData,
        dataType: "html",
        success: function (msg) {
            $('body').append('<div class="product-add-to-cart"><p>' + msg + '</p></div>');
            setTimeout(function () {
                $('.product-add-to-cart').remove();
            }, 1400);
            setTimeout(cartUpdate, 500);
        }
    });
}

function customGoodAddCart(good_id, sizeId, count) {
    requestData = {
        good_id    : good_id,
        size_id    : sizeId,
        count      : count
    };
    $.ajax({
        url: link + '/add-to-cart',
        type: "get",
        data: requestData,
        dataType: "html",
        success: function (msg) {
            $('body').append('<div class="product-add-to-cart"><p>' + msg + '</p></div>');
            setTimeout(function () {
                $('.product-add-to-cart').remove();
            }, 1400);
            setTimeout(cartUpdate, 500);
        }
    });
}

function cartUpdate() {
    $.ajax({
        url: link + '/cart-sum',
        type: "get",
        dataType: "html",
        success: function (msg) {
            var json = $.parseJSON(msg);
            $('.cart-mini .cart-mini-total span').html(json.str);
        }
    });
    $.ajax({
        url: link + '/cart-count',
        type: "get",
        dataType: "html",
        success: function (msg) {
            $('.cart-mini .cart-mini-products span, .cart-mini .cart-mini-count span').html(msg);
            //$('.cart-mini-count').html(msg);
            var html_cart='<span class="cart-mini-count">'+msg+'</span>';
            $('a.cart-ico').html(html_cart);
             $('a.cart-ico').removeClass('empty');
        }
    });
}
/* addToCart */

/* подписка к рассылке */
var subscription = '#subscription';
$('form'+subscription).submit(function () {
    $(subscription + ' input').removeClass('error');
    $(subscription + ' .feedback-input p').css('display','none');
    send_loader($(subscription+' button'));
    $.ajax({
        url: link + '/subscription/' + $(subscription).find('input').val(),
        type: "get",
        dataType: "html",
        complete: function (response) {
            if (response.status == 200){
                var statusText = $.parseJSON(response.statusText);
                $('body').append('<div class="product-add-to-cart"><p>' + statusText + '</p></div>');
                setTimeout(function () {$('.product-add-to-cart').remove();}, 2000);
                $(subscription).find('input').val('');
                send_loader_error(subscription + ' button');
            }
            if (response.status == 422) {
                var responseText = $.parseJSON(response.responseText);
                $(subscription + ' input').addClass('error');
                $(subscription + ' .feedback-input p').css('display','block').html(responseText.email);
                send_loader_error(subscription + ' button');
            }
        }
    });
    return false;
});
/* подписка к рассылке */

/* анимация при клике отправить */
function send_loader(btn) {
    $(btn).addClass('hidden');
    $(btn).next().removeClass('hidden');
}
function send_loader_error(btn) {
    $(btn).removeClass('hidden');
    $(btn).next().addClass('hidden');
}
/* анимация при клике отправить */

/* активная страница */
$('#inner-menu ul li').removeClass('active');
var pageHref = link + window.location.pathname; // получаем адрес из адресной строки
$('#inner-menu ul li a').each(function(){ // для каждой ссылки
    var linkHref = $(this).attr('href');//получаем href
    if (pageHref == linkHref){//сравниваем полученное из адресной строки с href ссылки
        // при совпадении присваиваем класс - какому элементу хотите?????
        $(this).parent('li').addClass('active');
    }
});
/* активная страница */

function removeCustomGood(btn,id) {
    var data = {id: id},
        parent = $(btn).parents('.account-good-block');
    $.ajax({
        url: link + '/api/custom-good-remove',
        type: "delete",
        data: data,
        dataType: "json",
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        complete: function (xhr) {
            console.log(xhr);
            if (xhr.status == '413'){
                alert($.parseJSON(xhr.statusText));
            }else if (xhr.status == '200'){
                parent.remove();
                $('body').append('<div class="product-add-to-cart"><p>'+ $.parseJSON(xhr.responseText) +'</p></div>');
                setTimeout(function () {
                    $('.product-add-to-cart').remove();
                }, 1400);
            }
        }
    });
}

var actionsSwiper;
if ($('.actions-swiper').length > 0) {
    var isLoop = false;

    if ($('.swiper-slide').length > 1) {
        isLoop = true;
    }

    actionsSwiper = new Swiper('#actions-list .swiper-container', {
        loop                         : isLoop,
        autoplay                     : 2500,
        autoplayDisableOnInteraction : false,
        nextButton                   : '#next-action',
        prevButton                   : '#prev-action',
        simulateTouch                : false
    });

    if ($('.swiper-slide').length < 2) {
        $('#next-action, #prev-action').hide();
    }
}

function mail_validate(elem) {
    var errors = false;
    elem.find('input, textarea').each(function () {
        if ($(this).val() == '') {
            $(this).parent('.feedback-item').addClass('has-error');
            $(this).next('p').css('display','block');
            errors = true;
        }
    });
    return errors;
}
$('form#feedback').submit(function (e) {
    e.preventDefault();
    var elem = $(this);
    $(this).find('.feedback-item').removeClass('has-error');
    $(this).find('p.help-block').css('display','none');
    if (mail_validate( $(this) ) == false){
        send_loader($(this).find('button'));
        $.ajax({
            url: $(this).attr('action'),
            type: "post",
            data: $(this).serialize(),
            dataType: "json",
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            complete: function (xhr) {
                send_loader_error(elem.find('button'));
                if (xhr.status == '200'){
                    elem.find('input, textarea').val('');
                    $('body').append('<div class="product-add-to-cart"><p>'+ xhr.responseText +'</p></div>');
                    setTimeout(function () {
                        $('.product-add-to-cart').remove();
                    }, 1400);
                }
            }
        });
    }
    return false;
});

$(function() {
    $(window).scroll(function() {
        if($(this).scrollTop() != 0) {
            $('#to-top').fadeIn();
        } else {
            $('#to-top').fadeOut();
        }
    });
    $('#to-top').click(function() {
        $('body,html').animate({scrollTop:0},800);
    });
});

$('#mobile-menu').on('click',function () {
    console.log('click');
    if ($(this).hasClass('active-mobile')){
        $(this).removeClass('active-mobile');
        $('#mobile-menu-list').slideUp('slow');
        $(this).children('i').remove();
        $(this).append('<i class="fa fa-bars"></i>');
    } else {
        $(this).addClass('active-mobile');
        $('#mobile-menu-list').slideDown('slow');
        $(this).children('i').remove();
        $(this).append('<i class="fa fa-close"></i>');
    }
});