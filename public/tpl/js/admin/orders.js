/**
 * Created by ppc on 28.06.17.
 */
var searchTimeout;

$(function () {
    $('#from_order_datepicker, #to_order_datepicker').datepicker({
        language: "ru",
        format: "yyyy-mm-dd",
        todayHighlight: true,
        autoclose: true
    }).on('changeDate', function() {
        loadOrdersList();
    });

    $("#number, #client").keyup(function () {
        if (searchTimeout !== undefined) {
            clearTimeout(searchTimeout);
        }

        searchTimeout = setTimeout(function() {loadOrdersList()}, 800);
    });

    $("#operator, #manager, #courier, #stage").change(function () {
        loadOrdersList();
    });

    $("#xls-export").click(function () {
        var params = getSearchParams();
        var get = '';
        for (var p in params) {
            get += p+'='+params[p]+'&'
        }

        window.location.replace('/admin/orders/xls/?'+get);
    });
});

var loadOrdersList = function () {
    var $l = $("#loading-gif");

    $l.removeClass('is-hidden');

    $.get('/admin/orders/list/', getSearchParams(), function (data) {
        $("#orders_list").html(data);
        $l.addClass('is-hidden');
    });
};

var getSearchParams = function () {
    return {
        from: $("#from_order_datepicker").datepicker('getDate').getTime() / 1000,
        to: $("#to_order_datepicker").datepicker('getDate').getTime() / 1000,
        number: $("#number").val(),
        client: $("#client").val(),
        operator: $("#operator").val(),
        manager: $("#manager").val(),
        courier: $("#courier").val(),
        stage: $("#stage").val()
    };
};