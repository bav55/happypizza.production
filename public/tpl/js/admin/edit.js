
    $(function() {
        $('.edit').froalaEditor({
            language: 'ru',
            toolbarInline: false,
            placeholderText: 'Введите текст',
            imageUploadURL: '/admin/ajax/upload',
            imageUploadMethod: 'POST',
            imageMaxSize: 5 * 1024 * 1024,
            imageAllowedTypes: ['jpeg', 'jpg', 'png']
        });

        //setInterval("clearLic()", 10);
    });

    function clearLic() {
        $('.fr-box div a').each(function() {
            if ($(this).html() == 'Unlicensed Froala Editor') {
                $(this).hide();
            }
        });
    }