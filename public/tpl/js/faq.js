
    $(function() {
        $('.faq-question').click(function() {
            $('.faq-question').removeClass('active');
            $('.faq-answer').slideUp(300);
            $(this).addClass('active');
            $(this).parent().find('.faq-answer').slideDown(300);
        });

        $('#popup').click(function() {
            $('#faq-popup').hide();
            $('#popup').stop().animate({
                opacity: 0
            }, 300, function() {
                $('#popup').attr('class', 'popup-state-close');
            });
        });
    });

    $.askQuestion = function() {
        $('#faq-modal').modal('show');
    }

    $.askQuestionSubmit = function (button) {
        var $faq = $('#faq-modal');
        
        var requestData = {
            name  : $faq.find('input[name="name"]').val(),
            phone : $faq.find('input[name="phone"]').val(),
            message : $faq.find('input[name="message"]').val()
        };

        $faq.find('.has-error').removeClass('has-error');
        
        $.post('/faq/request', requestData, function (response) {
            if (response.result == 'error') {
                if (response.errors.name) {
                    $faq.find('input[name="name"]').parents('.form-group').addClass('has-error');
                }

                if (response.errors.phone) {
                    $faq.find('input[name="phone"]').parents('.form-group').addClass('has-error');
                }

                if (response.errors.message) {
                    $faq.find('input[name="message"]').parents('.form-group').addClass('has-error');
                }
            } else  {
                $('#faq-modal').modal('hide');
                $('#faq-modal-success').modal('show');
            }
        }, 'json');
    }