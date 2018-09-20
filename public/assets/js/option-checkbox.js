$('.multiselect').multiselect({ enableFiltering: true, maxHeight: 400 });

var ingredients = eval($('#ingredient_id').attr('value'));
var add_ingredient = eval($('#add_ingredient_id').attr('value'));
var preferences = eval($('#preference_id').attr('value'));


$('.ingredient_id input[type=checkbox]').on('click', function () {
    create_json_add($(this).attr('value'), ingredients);
    $('#ingredient_id').attr('value',JSON.stringify(ingredients));
});

$('.add_ingredient_id input[type=checkbox]').on('click', function () {
    create_json_add($(this).attr('value'), add_ingredient);
    $('#add_ingredient_id').attr('value',JSON.stringify(add_ingredient));
});

$('.preference_id input[type=checkbox]').on('click', function () {
    create_json_add($(this).attr('value'), preferences);
    $('#preference_id').attr('value',JSON.stringify(preferences));
});

function thiBlockRemove(atr) {
    $(atr).parent().parent('.row').remove();
}

var preference_input = $('.preference_id ul li input');
var ingredient_input = $('.ingredient_id ul li input');
var add_ingredient_input = $('.add_ingredient_id ul li input');
var good_category = $('#good_category');

var cat_id = good_category.val();
preference_input.parent().parent().parent('li').css('display','list-item');
ingredient_input.parent().parent().parent('li').css('display','list-item');
add_ingredient_input.parent().parent().parent('li').css('display','list-item');

good_category.on('change', function () {
    var cat_id = $(this).val();
    preference_input.parent().parent().parent('li').css('display','list-item');
    ingredient_input.parent().parent().parent('li').css('display','list-item');
    add_ingredient_input.parent().parent().parent('li').css('display','list-item');
    setTimeout(show_in_category(cat_id) ,500);
});

show_in_category(cat_id);

function show_in_category(cat_id) {
    $('.preference_id select option').each(function () {
        //console.log($(this).data('category'));
        if ($(this).data('category') != cat_id){
            var this_val = $(this).attr('value');
            preference_input.each(function () {
                if ($(this).attr('value') == this_val){ $(this).parent().parent().parent('li').css('display','none'); }
            });
        }
    });

    $('.ingredient_id select option').each(function () {
        //console.log($(this).data('category'));
        if ($(this).data('category') != cat_id){
            var this_val = $(this).attr('value');
            ingredient_input.each(function () {
                if ($(this).attr('value') == this_val){  $(this).parent().parent().parent('li').css('display','none'); }
            });
        }
    });

    $('.add_ingredient_id select option').each(function () {
        //console.log($(this).data('category'));
        if ($(this).data('category') != cat_id){
            var this_val = $(this).attr('value');
            add_ingredient_input.each(function () {
                if ($(this).attr('value') == this_val){  $(this).parent().parent().parent('li').css('display','none'); }
            });
        }
    });
}


var click_value;
function price_size(value) {
    console.log('price_size');
    if (click_value == null){ click_value = value + 1; }
    else { click_value++; }
    var option;
    $.ajax({
            url: link+'/ip5woctv9f990lc/api/get-potion/',
            type: "GET",
            dataType: "json",
            success: function(msg){
                $.each(msg, function() {
                    option += ('<option value="'+this.id+'">'+this.title+'</option>');
                });
                $('#size_price').append('' +
                    '<div class="row">\n' +
                    '   <div class="col-6">\n' +
                    '       <select class="form-control" name="size_price['+click_value+'][port_id]">'+option+'</select>\n' +
                    '   </div>\n' +
                    '   <div class="col-5">\n' +
                    '       <div class="form-group">\n' +
                    '           <input class="form-control" type="number" name="size_price['+click_value+'][port_price]" required placeholder="Цена">\n' +
                    '       </div>\n' +
                    '   </div>\n'+
                    '   <div class="col-1">\n'+
                    '        <a onclick="thiBlockRemove(this)" type="button" class="btn btn-danger" style="color: #FFF;"><i class="fa fa-close"></i></a>\n'+
                    '    </div>\n'+
                    '</div>'
                );
            }
        }
    );
}

var click_add_ingr;
function add_ingridient(value) {
    console.log('add_ingridient');
    if (click_add_ingr == null){ click_add_ingr = value + 1; }
    else { click_add_ingr++; }
    var option;
    $.ajax({
            url: link+'/ip5woctv9f990lc/api/get-ingridients/',
            type: "GET",
            dataType: "json",
            success: function(msg){
                $.each(msg, function() {
                    option += ('<option value="'+this.id+'">'+this.title+'</option>');
                });
                $('#ingredient_tab').append('' +
                    '<div class="row">\n' +
                    '   <div class="col-6">\n' +
                    '       <select class="form-control" name="ingredient_id[]">'+option+'</select>\n' +
                    '   </div>\n' +
                    '   <div class="col-5">\n' +
                    '       <div class="form-group">\n' +
                    '<input type="checkbox" name="ingredient_id_off[]" value="">'+
                    '       </div>\n' +
                    '   </div>\n'+
                    '   <div class="col-1">\n'+
                    '        <a onclick="thiBlockRemove(this)" type="button" class="btn btn-danger" style="color: #FFF;"><i class="fa fa-close"></i></a>\n'+
                    '    </div>\n'+
                    '</div><br>'
                );
                
                $( "#ingredient_tab" ).change(function(event) { 
                        var ing_id = $(event.target).val();
                        var obj_row = $(event.target).parent().parent();
                        var ingredient_id_off = $(obj_row).find('[name="ingredient_id_off[]"]');
                        ingredient_id_off.val(ing_id);
               })
                
            }
        }
    );
}

var click_add_recom;
function add_recommended(value) {
    console.log('add_recommended');
    if (click_add_recom == null){ click_add_recom = value + 1; }
    else { click_add_recom++; }
    var option;
    $.ajax({
            url: link+'/ip5woctv9f990lc/api/get-recommendeds/',
            type: "GET",
            dataType: "json",
            success: function(msg){
                $.each(msg, function() {
                    option += ('<option value="'+this.id+'">'+this.title+'</option>');
                });
                $('#recommended_tab').append('' +
                    '<div class="row">\n' +
                    '   <div class="col-6">\n' +
                    '       <select class="form-control" name="recommended_id[]">'+option+'</select>\n' +
                    '   </div>\n' +
                    '   <div class="col-5">\n' +
                    '   </div>\n'+
                    '   <div class="col-1">\n'+
                    '        <a onclick="thiBlockRemove(this)" type="button" class="btn btn-danger" style="color: #FFF;"><i class="fa fa-close"></i></a>\n'+
                    '    </div>\n'+
                    '</div><br>'
                );
            }
        }
    );
}