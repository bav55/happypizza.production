var MQ;
var actionsSwiper;
var loader;

function isMobile() {
    var check = false;
    (function (a) {if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4))) check = true;})(navigator.userAgent || navigator.vendor || window.opera);
    return check;
}

function number_format(number, decimals, dec_point, thousands_sep) {
    var i, j, kw, kd, km;

    if (isNaN(decimals = Math.abs(decimals))) {
        decimals = 2;
    }
    if (dec_point == undefined) {
        dec_point = ",";
    }
    if (thousands_sep == undefined) {
        thousands_sep = ".";
    }

    i = parseInt(number = (+number || 0).toFixed(decimals)) + "";

    if ((j = i.length) > 3) {
        j = j % 3;
    } else {
        j = 0;
    }

    km = (j ? i.substr(0, j) + thousands_sep : "");
    kw = i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands_sep);
    //kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).slice(2) : "");
    kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).replace(/-/, 0).slice(2) : "");

    return km + kw + kd;
}

$(function () {
    loader = new SVGLoader(document.getElementById('loader'), {speedIn : 700, easingIn : mina.easeinout});
    loader.show();

    QueryLoader.init();

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

    $(document).on('change', '.product-size-select', function (e) {
        var $selector = $(this);
        var $option   = $selector.find(':selected');

        $selector.parents('.menu-items-el').find('.menu-list-price span').html(number_format($option.data('price'), 0, '.', ' '));
        $selector.parents('.menu-items-el').find('.menu-el-old-price span').html(number_format($option.data('old-price'), 0, '.', ' '));

        $.checkConstructorAvailability();
    });

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

        $('.phones-holder').mouseover(function () {
            $(this).find('.phones-list').show();
        }).mouseout(function () {
            $('.phones-list').hide();
        });

        $('.phones-list li').click(function () {
            $('.main-phone').html($(this).html() + '<i class="phones-handler"></i>');
            $('.phones-list').hide();
        });
    }

    $('.plus').click(function (e) {
        var $count = $(this).prev(),
            count  = parseInt($count.text(), 10);

        count++;

        $count.text(count);

        $.cartRecalculate();
    });

    $('.minus').click(function (e) {
        var $count = $(this).next(),
            count  = parseInt($count.text(), 10);

        count--;

        if (count < 1) {
            count = 1;
        }

        $count.text(count);

        $.cartRecalculate();
    });

    $("#subscribe").click(function () {
        var $email = $("#subscriber-email");
        var mail = /^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/;
        var $btn = $(this);

        if(!mail.test($email.val())) {
            alert("Укажите верный адрес электронной почты");
            return;
        }

        $.post("/subscribe", {email:$email.val()}, function (response) {
            if (response.result == 'success') {
                $btn.prop("disabled", true);
                $email.val("");
                alert("Вы подписаны на новости happypizza!");
            } else {
                alert(response.message);
            }
        });
    });
});

function deviceType() {
    return window.getComputedStyle(document.querySelector('body'), '::before').getPropertyValue('content').replace(/"/g, "").replace(/'/g, "") * 1;
}

$.readMore = function () {
    $('#read-more-holder p').stop().animate({
        opacity   : 0,
        marginTop : 0
    }, 300);
    $('#page_content').slideDown(300);
};

// Регистрация
$.registration = function (button) {
    var $modal = $('#registration-modal'), $input;
    var $error = $modal.find('.error');

    $modal.find('.has-error').removeClass('has-error');

    $.post('/account/registration', $modal.find(':input'), function (response) {
        if (response.redirect) {
            window.location.replace(response.redirect);
        }

        if (response.result == 'success') {
            $modal.modal('hide');

            $('#registration-modal-success').modal('show');
        }

        if (response.result == 'error') {
            if (response.errors) {
                $.each(response.errors, function (key, text) {
                    $input = $modal.find('input[name="' + key + '"]');
                    $input.next().text(text);
                    $input.parent().addClass('has-error');
                });
            }

            if (response.error) {
                $error.text(response.error);
                $error.removeClass('is-hidden');
            }
        }
    }, 'json')
};

// Авторизация
$.login = function (button) {
    var $modal        = $('#login-modal');
    var $modalSuccess = $('#login-modal-success');

    $modal.find('.error').addClass('is-hidden');

    $.post('/account/login', $modal.find(':input'), function (response) {
        if (response.result == 'success') {
            $modal.modal('hide');

            $modalSuccess.find('.user-login-bonus').text(response.bonus);
            $modalSuccess.find('.user-login-debit').text(response.debit + ' ед.');

            if (location.href.indexOf('cart') != -1) {
                $modalSuccess.find('a').attr('href', location.href);
            }

            $modalSuccess.modal('show');
        }

        if (response.result == 'error') {
            $modal.find('.error').removeClass('is-hidden');
        }
    }, 'json')
};

// Сброс пароля
$.passwordReset = function () {
    var $modal = $('#password-reset-modal');
    var $error = $modal.find('.error');

    $modal.find('.error').addClass('is-hidden');

    $.post('/account/reset_password', $modal.find(':input'), function (response) {
        if (response.result == 'success') {
            $modal.modal('hide');

            $('#password-reset-modal-success').modal('show');
        }

        if (response.result == 'error') {
            $error.text(response.errors);
            $modal.find('.error').removeClass('is-hidden');
        }
    }, 'json')
};

$.checkConstructorAvailability = function () {
    $('.product-size-select').each(function () {
        var $selector = $(this);
        var $option   = $selector.find(':selected');

        var $ingredients = $selector.parents('.menu-items-el').find('.change-ing').find('a');
        if ($option.data('editable') == 0) {
            $ingredients.hide();
        } else {
            $ingredients.show();
        }
    });
};

$.noSms = function () {
    $.post()
};

$(document).ready(function () {
    $.checkConstructorAvailability();

    $('.main-category-item').on('click', function (e) {
        e.preventDefault();

        window.location.replace($(this).attr('href'));
    });

    // Маскированный ввод
    $('.masked-phone').mask('+7 (999) 999-99-99');

    $('[data-toggle="tooltip"]').tooltip();

    $('.to-top').on('click', function () {
        $('body,html').animate({
            scrollTop: 0
        }, 800);

        return false;
    })
});

$(window).scroll(function (e) {
    var $innerMenu = $('#inner-menu');
    var scroll = $(window).scrollTop();
    var zone  = $('#zone').offset();

    if (scroll > 150 && scroll < 3550) {
        scroll -= 130;
    } else if (scroll <= 150) {
        scroll = 0;
    } else if (scroll >= 3550) {
        scroll = 3550;
    }

    $innerMenu.css({top : scroll + 'px'});

    if (scroll > 100) {
        $('.to-top').fadeIn();
    } else {
        $('.to-top').fadeOut();
    }
});

$.clearConstructor = function(button) {
    var $column = $(button).parents('.modal-body').find('#calculated-ingredients');

    $column.find('.ingredient-item').each(function () {
        var $this = $(this);

        if (!$this.hasClass('default-ingredient-item')) {
            $this.find('.ingredient-remove').find('a').click();
        }
    })

    $column.find('.default-ingredient-item').each(function () {
        console.log(this);
        $(this).find('.ingredient-portions').find('a:first').click();
    })
}