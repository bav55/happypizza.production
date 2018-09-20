$(function () {
    $('#from_log_datepicker, #to_log_datepicker').datepicker({
        language: "ru",
        format: "yyyy-mm-dd",
        todayHighlight: true,
        autoclose: true
    }).on('changeDate', function() {
        updateLogsList("/admin/operator-logs/list/?");
    });

    $('#operation_type, #admin').change(function () {
        updateLogsList("/admin/operator-logs/list/?");
    });

    /*
    $(".pagination a").on("click", function () {
        var $a = $(this);
        $a.preventDefault();

        var href = $a.attr("href");

        updateLogsList(href+"&");
    })
    */
});

var updateLogsList = function (uri) {
    var dt_from = $("#from_log_datepicker").datepicker('getDate').getTime()/1000;
    var dt_to = $("#to_log_datepicker").datepicker('getDate').getTime()/1000;
    var code = $("#operation_type").val();
    var admin = $("#admin").val();
    var $l = $("#loading-gif");

    $l.removeClass('is-hidden');

    uri = uri + "from="+dt_from+"&to="+dt_to+"&code="+code+"&user_id="+admin;

    $("#logs_list").load(uri, function () {
        $l.addClass('is-hidden');
    });
};