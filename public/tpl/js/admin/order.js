
    $(function() {
        $('.sorted-table').sortable({
            containerSelector: 'table',
            itemPath: '> tbody',
            itemSelector: 'tr',
            handle: '.draggable',
            pullPlaceholder: false,
            placeholderClass: 'placeholder',
            placeholder: '<tr class="placeholder"/>',
            onDragStart: function ($item, container, _super) {
                $item.addClass('movable');
            },
            onDrop: function ($item, container, _super) {
                $item.removeClass('movable');

                var data = $('.sorted-table').sortable("serialize").get();

                var jsonString = JSON.stringify(data, null, ' ');

                $.ajax({
                    type: 'POST',
                    url: '/admin/ajax/order',
                    data: {
                        data  : jsonString,
                        table : orderTable
                    },
                    dataType: 'json',
                    success: function(data) {},
                    error: function (data) {
                        console.log('Error: ', data);
                    }
                });

                _super($item, container);
            }
        });
    });