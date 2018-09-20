$(function () {
    $('.interview-radio').click(function () {
        $('.interview-radio').removeClass('active');
        $(this).addClass('active');
    });

    // $(document).on('click', '.int-item-title', function () {
    //     $('.int-item-title').removeClass('active');
    //     $('.int-item-history').slideUp(300);
    //     $(this).addClass('active');
    //     $(this).parent().find('.int-item-history').slideDown(300);
    // });
});

function setVote(button) {
    var $button = $(button);
    var $vote   = $button.parents('.vote');
    var $option = $vote.find('.interview-radio.active');

    if ($option.length > 0) {
        send_loader($button);
        var requestData = {
            vote_id   : $option.data('vote-id'),
            option_id : $option.data('option-id')
        };
        $.ajax({
            url: link + '/vote/request',
            type: "post",
            data: requestData,
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                document.location.reload(true);
            },
            complete: function () {
                send_loader_error($button);
            }
        });
    }
}