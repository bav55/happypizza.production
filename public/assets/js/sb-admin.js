var protocol = window.location.protocol;
var hostname = window.location.hostname;
var link = protocol+'//'+hostname;

setTimeout( function () {
    $('#success-message').slideUp('slow');
}, 2000);

/* загрузка файлов */
$(document).ready(function() {
    $('#photoimg, #photoimg-textarea').on('change', function() {
        var A=$("#imageloadstatus,#imageloadstatus-textarea");
        var B=$("#imageloadbutton,#imageloadbutton-textarea");

        $("#imageform,#imageform-textarea").ajaxForm({target: '.list-media',
            beforeSubmit:function(){
                A.show();
                B.hide();
            },
            success:function(){
                A.hide();
                B.show();
                MediaModal("#inputMediafile");
                textarea_image();
            },
            error:function(){
                A.hide();
                B.show();
            }
        }).submit();
    });

});
/* загрузка файлов */


button_close_btn();
function button_close_btn() {
    var input_select = document.querySelector('button[class="ui-dialog-titlebar-close"]');
    if(!input_select){
        setTimeout(button_close_btn,500);
    }
    else {
        $(input_select).append('<i class="fa fa-close"></i>');
    }
}


$('.datepicker').datetimepicker({
    i18n:{
        'ru' :{
            months:[
                'Январь','февраль','Март','Апрель',
                'Май','Июнь','Июль','Август',
                'Сентябрь','Октябрь','Ноябрь','Декабрь'
            ],
                dayOfWeek:[
                "По", "Вт", "Ср", "Чт",
                "Пт", "Сб", "Вс"
            ]
        }
    },
    format: 'Y-m-d H:i',
    lang:'ru'
});

function create_json_add(elem, variable) {
    var elem_val = elem;
    if(variable.length > 0){
        var num = 0, foreach = false;
        for (var i = 0; i < variable.length; i++) {
            if (variable[i] === elem_val) { foreach = true; num = i; }
        }
        if (foreach == true){ variable.splice(num,1); }
        else { variable.push(elem_val); }
    }
    else { variable.push(elem_val); }
}

var v_count = 0;
function addVacancyForm(btn) {
    var elem = $(btn);
    var count = elem.attr('data-count');
    if (v_count == 0){
        v_count = count;
        v_count++;
    } else {
        v_count++;
    }
    $('#form-input').append(
        '<div class="row">\n' +
            '<div class="form-group col-7">\n' +
                '<input type="text" class="form-control" name="form['+v_count+'][question]" >\n' +
            '</div>\n' +
            '<div class="form-group col-3">\n' +
                '<select class="form-control" name="form['+v_count+'][type]">\n' +
                    '<option value="input">Текст</option>\n' +
                    '<option value="checkbox">Да/Нет</option>\n' +
                '</select>\n' +
            '</div>\n' +
            '<div class="form-group col-1"><a href="#" class="btn btn-danger" onclick="removeVacancyForm(this); return false;"><i class="fa fa-close"></i></a></div>\n' +
        '</div>'
    );
}



function addVoteForm(btn) {
    var elem = $(btn);
    $('#form-input-votes').append(
        '<div class="row">\n' +
            '<div class="form-group col-10">\n' +
                '<input type="text" class="form-control" name="form[]" >\n' +
            '</div>\n' +
            '<div class="form-group col-1"><a href="#" class="btn btn-danger" onclick="removeVacancyForm(this); return false;"><i class="fa fa-close"></i></a></div>\n' +
        '</div>'
    );
}

function removeVacancyForm(btn) {
    $(btn).parent('.form-group').parent('.row').remove();
}