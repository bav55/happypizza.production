
    $(function() {
        $('input[name=is_expert]').click(function() {
            if ($(this).is(":checked")) {
                $('.hidden-blocks').hide();
                $('input[name=url]').val('experts');
            }
            else {
                $('.hidden-blocks').show();
                $('input[name=url]').val('');
            }
        });
    });