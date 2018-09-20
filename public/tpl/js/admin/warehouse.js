$(function () {
    $("#add-item").click(function () {
        addItem();
    });

    addItem();
});

var addItem = function () {
    var $html = $("#item-template").children(":first").clone();
    var $div = $("#items");
    var id = $div.find(".item").length;
    $html.find("select[name='material[]']").attr("name", "material["+id+"]");
    $html.find("input[name='count[]']").attr("name", "count["+id+"]");
    $html.find("select").fastselect();
    $div.append($html);
};