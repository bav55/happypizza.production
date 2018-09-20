$(function () {
    $("#feedback").submit(function () {
        var $form = $(this), $field, error = false;

        $form.find(':input').each(function () {
            $field = $(this);

            if ($field.val().length == 0) {
                $field.parent().addClass('has-error');
                error = true;
            }
        });

        if (error) {
            return false;
        }
    });
});