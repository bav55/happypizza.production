var searchTimeout;

$(function () {
    $('.date').datepicker({
        language: "ru",
        format: "yyyy-mm-dd",
        todayHighlight: true,
        autoclose: true
    }).on('changeDate', function() {
        loadClientsList();
    });

    $("#name, #email, #phone, #post").keyup(function () {
        if (searchTimeout !== undefined) {
            clearTimeout(searchTimeout);
        }

        searchTimeout = setTimeout(function() {loadClientsList()}, 800);
    });

    $("#label").change(function () {
        loadClientsList();
    });

    $("#xls-export").click(function () {
        var params = getSearchParams();
        var get = '';
        for (var p in params) {
            get += p+'='+params[p]+'&'
        }

        window.location.replace('/admin/clients/xls?'+get);
    });
});

var loadClientsList = function () {
    var $l = $("#loading-gif");

    $l.removeClass('is-hidden');

    $.get('/admin/clients', getSearchParams(), function (data) {
        $("#clients_list").html(data);
        $l.addClass('is-hidden');
    });
};

var getSearchParams = function () {
    var dt = $("#birthday_from").datepicker('getDate');
    var birthdayFrom = dt === null ? null : dt.getTime()/1000;
    dt = $("#birthday_to").datepicker('getDate');
    var birthdayTo = dt === null ? null : dt.getTime()/1000;

    return {
        name: $("#name").val(),
        email: $("#email").val(),
        phone: $("#phone").val(),
        label: $("#label").val(),
        post: $("#post").val(),
        from: $("#from").datepicker('getDate').getTime() / 1000,
        to: $("#to").datepicker('getDate').getTime() / 1000,
        birthday_from: birthdayFrom,
        birthday_to: birthdayTo
    };
};