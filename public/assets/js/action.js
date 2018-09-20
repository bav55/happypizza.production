function removeActionBlock(btn) {
    $(btn).parent().parent('.row').remove();
}

var click_count = 100;
var row_attr;
var checkboxParentValue;


function addActionBlock(str) {
    if (!str) {
        ajax_action(link+'/ip5woctv9f990lc/api/categories', "GET", '', getAllCategories);
    } else if (str){
        click_count++;
        $('#share_condition').append('' +
            '<div class="row" data-attr="' + click_count + '">\n' +
                '<div class="form-group col-md-3">\n' +
                    '<label>Категория</label>\n' +
                    '<select class="form-control" name="action['+click_count+'][category_id]" onchange="getCategoryGoods(this)">\n' +
                    '<option style="display: none;">Выберите</option>'+ str +'</select>\n' +
                '</div>\n' +
                '<div class="form-group col-md-2 goods">\n' +
                    '<label>Товары</label>\n' +
                    '<input type="text" class="form-control" onclick="showMultiselect(this);" value="Выбрать" onfocus="this.blur()">\n' +
                    '<input type="hidden" name="action['+click_count+'][good_id]" value="[]">\n' +
                '</div>\n' +
                '<div class="form-group col-md-2 sizes">\n' +
                    '<label>Размеры</label>\n' +
                    '<input type="text" class="form-control" onclick="showMultiselect(this);" value="Выбрать" onfocus="this.blur()">\n' +
                    '<input type="hidden" name="action['+click_count+'][sizes_id]" value="[]">\n' +
                '</div>\n' +
                '<div class="form-group col-md-2">\n' +
                    '<label>Кол-во</label>\n' +
                    '<input type="number" class="form-control" name="action['+click_count+'][count]">\n' +
                '</div>\n' +
                '<div class="form-group col-md-2">\n' +
                    '<label>Пов-ие</label>\n' +
                    '<input type="checkbox" class="form-control" name="action['+click_count+'][checkbox]">\n' +
                '</div>\n' +
                '<div class="form-group col-md-1 pull-right">\n' +
                    '<label style="visibility: hidden">Удалить</label>\n' +
                    '<a href="#" onclick="removeActionBlock(this); return false;" class="btn btn-danger"><i class="fa fa-close"></i> </a>\n' +
                '</div>\n' +
            '</div>'
        );
    }
}

function getCategoryGoods(btn) {
    var select = $(btn),
        goods, str, portions, str_options;
    select.parents('.row').find('.goods .multiselect-action').remove();
    select.parents('.row').find('.sizes .multiselect-action').remove();
    select.parents('.row').find('input[type="hidden"]').attr('value','[]');
    select.attr('onfocus', 'this.oldvalue=this.value;this.blur();');
    select.attr('onchange', 'this.value=this.oldvalue;');
    $.ajax({
        url: link+'/ip5woctv9f990lc/api/category-goods/'+select.val(),
        type: "GET",
        data: '',
        dataType: 'json',
        complete: function (xhr) {
            goods = xhr.responseJSON;
            var arr = [];
            $.each(goods, function () { arr.push(this.id); });
            str = '<ul class="multiselect-action"><li><label><input class="all-goods first-el" onclick="FirstElemMultiselectFunction(this)" data-list="'+ JSON.stringify(arr) +'" data-title="Все товары" type="checkbox">  Все товары</label></li>';
            $.each(goods, function () {
                str += '<li><label><input type="checkbox" value="'+ this.id +'">  '+ this.title +'</label></li>';
            });
            str += '</ul>';
            select.parents('.row').find('.goods').append(str);
        }
    });

    //if (select.val() == 1) {
        $.ajax({
            url: link+'/ip5woctv9f990lc/api/category-size/',
            type: "GET",
            dataType: 'json',
            complete: function (xhr) {
                portions = xhr.responseJSON;
                var arr = [];
                $.each(portions, function () { arr.push(this.id); });
                str_options  = '<ul class="multiselect-action"><li><label><input class="all-size first-el" onclick="FirstElemMultiselectFunction(this)" data-list="'+ JSON.stringify(arr) +'" data-title="Все размеры" type="checkbox">  Все размеры</label></li>';
                $.each(portions, function () {
                    str_options += '<li><label><input type="checkbox" value="'+ this.id +'">  '+ this.title +'</label></li>';
                });
                str_options += '</ul>';
                select.parents('.row').find('.sizes').append(str_options);
            }
        });
    //}
    // goodMultiselectFunction();
    // sizeMultiselectFunction();
    //MultiselectFunction();
}

function FirstElemMultiselectFunction(btn) {
    var goodinDOM = $(btn);
    //goodinDOM.on('click',function () {
        if (goodinDOM.is(':checked')){
            if (goodinDOM.parents('.goods')){
                multiselect_all($(this),'.goods');
            } else if (goodinDOM.parents('.sizes')){
                multiselect_all($(this),'.sizes');
            }
        } else {
            if (goodinDOM.parents('.goods')){
                multiselect_all_unchecked($(this),'.goods');
            } else if (goodinDOM.parents('.sizes')){
                multiselect_all_unchecked($(this),'.sizes');
            }
        }
    //});
}

function multiselect_all_unchecked(element, parent) {
    var array = element.attr('data-list'),
        html = element.attr('data-title');
    element.parents(parent).find('ul.multiselect-action li input').prop('checked',false);
    element.parents(parent).find('.form-control').attr('value','Выбрать');
    element.parents(parent).find('input[type="hidden"]').attr('value', '[]');
    element.prop('checked',false);
}

function multiselect_all(element, parent) {
    var array = element.attr('data-list'),
        html = element.attr('data-title');
    element.parents(parent).find('ul.multiselect-action li input').prop('checked',false);
    element.parents(parent).find('.form-control').attr('value', html);
    element.parents(parent).find('input[type="hidden"]').attr('value', array);
    element.prop('checked',true);
}


function MultiselectFunction(cls) {
    var Multiselect = $('div[data-attr="' + row_attr + '"]').children(cls);
    if (!Multiselect) {
        setTimeout(MultiselectFunction, 500);
    } else {
        var multiselectDOM = $(cls + ' ul.multiselect-action > li > label > input[type=checkbox]');
        multiselectDOM.on('click',function () {
            if (!$(this).hasClass('first-el')) {
                var parentMultiselect = $(this).parents(cls);
                checkboxParentValue = eval(parentMultiselect.find('input[type="hidden"]').attr('value'));
                console.log(checkboxParentValue);
                create_json_add($(this).attr('value'), checkboxParentValue);
                parentMultiselect.find('input[type="hidden"]').attr('value', JSON.stringify(checkboxParentValue));
                parentMultiselect.find('.form-control').attr('value', 'элементов '+checkboxParentValue.length);
            } else {
                var goodinDOM = $(this);
                if (goodinDOM.is(':checked')){
                    multiselect_all($(this),cls);
                } else {
                    multiselect_all_unchecked($(this),cls);
                }
            }
        });
    }
}


function showMultiselect(btn) {
    row_attr = $(btn).parents('.row').attr('data-attr');
    var multiselect_action = $('.multiselect-action'),
        multiselect = $(btn).parent('.form-group').find('.multiselect-action');
    if ($(btn).hasClass('avtive-multiselect')){
        $(btn).removeClass('avtive-multiselect');
        multiselect.css('margin-top', '0');
        multiselect.hide();
    } else if(!$(btn).hasClass('avtive-multiselect')){
        $('.form-control').removeClass('avtive-multiselect');
        multiselect_action.css('margin-top', '0');
        multiselect_action.hide();

        $(btn).addClass('avtive-multiselect');
        multiselect.css('margin-top', -(multiselect.height()+51));
        multiselect.show();
    }
    var parentClass;
    if ($(btn).parent('.form-group').hasClass('goods')) {parentClass = '.goods'}
    else if ($(btn).parent('.form-group').hasClass('sizes')) {parentClass = '.sizes'}
    MultiselectFunction(parentClass);
}

function getAllCategories(categories) {
    var str = '<option style="display: none;">Выберите</option>';
    $.each(categories, function () {
        str += ('<option value="'+ this.id +'">'+ this.title +'</option>');
    });
    addActionBlock(str);
}

function ajax_action(url, type, requestData, fuct) {
    var data;
    $.ajax({
        url: url,
        type: type,
        data: requestData,
        dataType: 'json',
        complete: function (xhr) {
            data = xhr.responseJSON;
            fuct(data);
        }
    });
}

getPresentCategoryGoodsDOMReady();
function getPresentCategoryGoodsDOMReady() {
    var elem = $('#present_good_visual');
    var cat_id = elem.attr('data-category');
    var good_id = elem.attr('data-good'),
        str;
    $('.present_category select option').each(function (i) {
        if(this.value == cat_id){
            $(this).prop('selected', true);
        }
    });
    var protocol = window.location.protocol;
    var hostname = window.location.hostname;
    var link = protocol+'//'+hostname;
    $.ajax({
        url: link+'/ip5woctv9f990lc/api/category-goods/' + cat_id,
        type: "GET",
        data: '',
        dataType: 'json',
        complete: function (xhr) {
            var goods = xhr.responseJSON;
            var arr = [];
            str = '<ul class="multiselect-presents">';
            $.each(goods, function () {
                if (good_id == this.id){
                    str += '<li><label><input type="radio" name="present[good]" value="'+ this.id +'" checked="checked" data-title="'+ this.title +'">  '+ this.title +'</label></li>';
                } else {
                    str += '<li><label><input type="radio" name="present[good]" value="'+ this.id +'" data-title="'+ this.title +'">  '+ this.title +'</label></li>';
                }

            });
            str += '</ul>';
            $('.present_good').append(str);
        }
    });

}

function getPresentCategoryGoods(select) {
    var str,
        parent = $('#input_is_present .present_good');
    parent.find('.multiselect-presents').remove();
    $.ajax({
        url: link+'/ip5woctv9f990lc/api/category-goods/'+$(select).val(),
        type: "GET",
        data: '',
        dataType: 'json',
        complete: function (xhr) {
            var goods = xhr.responseJSON;
            var arr = [];
            str = '<ul class="multiselect-presents">';
            $.each(goods, function () {
                str += '<li><label><input type="radio" name="present[good]" value="'+ this.id +'" data-title="'+ this.title +'">  '+ this.title +'</label></li>';
            });
            str += '</ul>';
            parent.append(str);
        }
    });
}

$('#present_good_visual').on('click',function () {
    if ($(this).hasClass('active-presents')){
        $(this).removeClass('active-presents');
        $(this).next('.multiselect-presents').css('margin-top', '0');
        $(this).next('.multiselect-presents').hide();
    } else {
        $(this).addClass('active-presents');
        $(this).next('.multiselect-presents').css('margin-top', -($(this).next('.multiselect-presents').height()+51));
        $(this).next('.multiselect-presents').show();
    }
    RadioButtonPrecent();
});

function RadioButtonPrecent() {
    $('.multiselect-presents li input[type="radio"]').on('click', function () {
        $('#present_good_visual').attr('value', $(this).attr('data-title'));
    });
}