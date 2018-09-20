/* modal mediafiles */
var inputMediafile = $( "#inputMediafile" );
$( function() {
    $( "#dialog-textarea,#modal-dialog" ).dialog({
        autoOpen: false,
        show: {
            effect: "blind",
            duration: 100
        },
        hide: {
            effect: "explode",
            duration: 100
        }
    });
} );

/* вставка изображение в input */
var insert_media = $('#insertMedia');
var modalDialog = $( ".modalMedia-dialog" );

function MediaModal(input) {
    modalDialog.dialog( "open" );
    $(".modalMedia-dialog img").click(function () {
        src_img = $(this).attr('src');
        $(input).attr('value',src_img);
        $('#preview-post-img').attr('src',src_img);
        modalDialog.dialog( "close" );
    });
}
/* вставка изображение в input */

/* вставка изображение визивиг */
textarea_image();
function textarea_image() {
    var input_select = document.querySelector('div[class="cke_dialog_ui_input_text"]');
    if(!input_select){
        setTimeout(textarea_image,500);
    }
    else {
        $(input_select).children('input').click(function () {
            var modal_ta = '.modalMedia-textarea';
            $( ".modalMedia-textarea" ).dialog( "open" );
            $(".modalMedia-textarea img").click(function () {
                $(input_select).children('input').val($(this).attr('src'));
                $( ".modalMedia-textarea" ).dialog( "close" );
            });
        });
    }
}
/* вставка изображение визивиг */

/* modal mediafiles */