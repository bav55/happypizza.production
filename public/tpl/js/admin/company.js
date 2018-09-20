/**
 * Created by ppc on 29.06.17.
 */

$(function () {
    $("#add-company-phone").click(function () {
        $("#company-phones-list").append($("#phone-template").html());
        $('.phone').mask("+7 (999) 999-99-99");
        //$("#phone-template").find("input").clone().appendTo("#company-phones-list");
    })
});