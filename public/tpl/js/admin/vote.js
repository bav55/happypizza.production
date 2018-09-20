$.addVoteOption = function() {
    $('#vote-options').append($('#vote-option-template').html());
};
$("#reset-vote").click(function () {
    if (confirm("Точно сбросить результаты этого опроса?")) {
        $.get("/admin/vote/reset/"+$(this).data("id"), function (response) {
            var $modal = $("#vote-reset");
            if (!response.result == 'success') {
                $modal.find(".modal-header").html(response.message);
            }
            $modal.modal("show");
        });
    }
});