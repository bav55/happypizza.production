$.showQuestions = function (button) {
    var $button    = $(button);
    var $container = $button.prev();

    if ($container.hasClass('opened')) {
        $container.removeClass('opened');
        $button.text('Смотреть все вопросы');
    } else {
        $container.addClass('opened');
        $button.text('Свернуть');
    }
};

$('form#vacancy-request').submit(function (e) {
    e.preventDefault();
    var $this = $(this);
    send_loader($this.find('button'));
    $.ajax({
        url: link+'/api/vacancies',
        type: "post",
        data: $this.serialize(),
        dataType: "text",
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (request) {
            $this.find('input').val('');
            $this.find('input[name="title"]').attr('value' ,'Отклик на вакансию '+$('#page-title h1').html());
            $('#success-message').html(request);
            setTimeout(function () { $('#success').remove(); }, 3000);
        },
        complete: function () {
            send_loader_error($this.find('button'));
        }
    });
    return false;
});