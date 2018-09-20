
    $(function() {
        $('#add-phone').click(function() {
            $('#phones-block').append('<div class="row">' +
                '<div class="col-xs-12">' +
                    '<input type="text" name="phones[]" class="form-control m-top-card" placeholder="Введите телефон" autocomplete="off">' +
                '</div>' +
            '</div>');
        });

        $('#add-email').click(function() {
            $('#emails-block').append('<div class="row">' +
                '<div class="col-xs-12">' +
                    '<input type="text" name="emails[]" class="form-control m-top-card" placeholder="Введите e-mail" autocomplete="off">' +
                '</div>' +
            '</div>');
        });
    });