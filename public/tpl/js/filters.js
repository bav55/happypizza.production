var good_block = $('#menu-list .menu-list-row div.good-block');

function FilteringPreference(thiis) {
    var filter = $(thiis).attr('value');
    good_block.css('display','block');
    if (filter != 0){
        good_block.each(function () {
            var preference = eval( $(this).data('preference') );
            if (search_in_array(preference,filter) == false){
                $(this).css('display','none');
            }
        });
    } else {
        good_block.css('display','block');
    }

}

function FilteringIngredient(thiis) {
    var filter = $(thiis).attr('value');
    good_block.css('display','block');
    if (filter != 0){
        good_block.each(function () {
            var ingredient = eval( $(this).data('ingredient') );
            if (search_in_array(ingredient,filter) == false){
                $(this).css('display','none');
            }
        });
    } else {
        good_block.css('display','block');
    }
}

function search_in_array(arr, elem) {
    return $.inArray( elem, arr) != -1;
}