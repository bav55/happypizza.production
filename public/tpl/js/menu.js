
    $(function() {
        $.checkMenu();

        $(window).resize(function() {
            $.checkMenu();
        });
    });

    $.checkMenu = function() {
        $('.menu-list-text, .menu-list-item').css({
            height: 'auto'
        });

        MQ = deviceType();

        if (MQ > 768) {
            $('.menu-list-block').each(function() {
                var split = 3;
                var $parent = $(this);

                if (MQ <= 992) {
                    split = 2;
                }

                var i = 0;
                var max = 0;
                var allCount = $parent.find('.menu-list-item').length;
                var cnt = 0;
                var blockH;

                $parent.find('.menu-list-item').each(function() {
                    i++;
                    cnt++;

                    $(this).find('.menu-list-text').addClass('spliter');
                    blockH = $(this).find('.menu-list-text').height();

                    if (blockH > max) {
                        max = blockH;
                    }

                    if ((i % split == 0) || (cnt == allCount)) {
                        i = 0;
                        $('.spliter').css({ height: max });
                        max = 0;
                        $parent.find('.menu-list-text').removeClass('spliter');
                    }
                });

                var i = 0;
                var max = 0;
                var allCount = $parent.find('.menu-list-item').length;
                var cnt = 0;
                var blockH;

                $parent.find('.menu-list-item').each(function() {
                    i++;
                    cnt++;

                    $(this).addClass('spliter');
                    blockH = $(this).height();

                    if (blockH > max) {
                        max = blockH;
                    }

                    if ((i % split == 0) || (cnt == allCount)) {
                        i = 0;
                        $('.spliter').css({ height: max });
                        max = 0;
                        $parent.find('.menu-list-item').removeClass('spliter');
                    }
                });
            });
        }
    };

    $.showIngredients = function (button) {
        var $button = $(button);
        var $modal  = $('#ingredients-modal');

        var product_size_id = $button.parent().next().find('select').val();

        $.get('/menu/ingredients/' + product_size_id, function (response) {
            $modal.find('.modal-body').html(response);
            $modal.modal('show');
            $.calculateTotalIngredients($('#ingredients-modal'));

            $modal.find('.ingredient-portions a').hover(function () {
                var $this     = $(this);
                var isDefault = $this.parents('.ingredient-item').hasClass('default-ingredient-item');
                var price     = $this.data('price');
                var count     = $this.data('count');

                if (isDefault) {
                    count--;
                }

                $this.parents('.ingredient-item').find('.ingredient-price').find('span').text(price * count);
            })
        });
    };

    $.checkIngredientCount = function (count) {
        var $error                 = $("#ingredients-error");
        var $ok                    = $("#ingredients-ok");
        if (count>=15) {
            $error.show();
            $ok.hide();
            return false;
        } else {
            $error.hide();
            $ok.show();
            return true;
        }
    };

    $.addIngredient = function (button, count) {
        var $button                = $(button);
        var weight                 = parseFloat($button.data('weight'));
        var $row                   = $button.parents('.ingredient-item');
        var isDefault              = $row.hasClass('default-ingredient-item');
        var ingredientId           = $row.find('input[type="hidden"]').val();
        //var $rowHtml               = $('<div class="row ingredient-item">' + $button.parents('.row').html() + '</div>');
        var $calculatedIngredients = $button.parents('.modal-body').find('#calculated-ingredients');

        if ($.checkIngredientCount($calculatedIngredients.find('.ingredient-name').length) === false) {
            return false;
        }

        if (isDefault) {
            var $r = $calculatedIngredients.find('input[value="' + ingredientId + '"]').parents('.ingredient-item');
            $r.removeClass('hidden');
            $r.find('.active').removeClass('active');

            $r.find('a[data-count="' + count + '"]').addClass('active');

            if ($row.parents('#calculated-ingredients').length == 0) {
                $row.addClass('hidden');
            }
        } else {
            var $rowHtml = $button.parents('.ingredient-item');
            $rowHtml.find('.col-xs-1').html('<span class="ingredient-remove"><a href="#" onclick="$.removeIngredient(this); return false;">x</a></span>');
            $rowHtml.find('a').removeClass('active');
            $rowHtml.find('[data-weight="'+weight+'"]').addClass('active');
            $rowHtml.appendTo($calculatedIngredients);
        }

        $.calculateTotalIngredients($('#ingredients-modal'));
    };

    $.removeIngredient = function (button) {
        var $button      = $(button);
        var isDefault    = $button.parents('.ingredient-item').hasClass('default-ingredient-item');
        var ingredientId = $button.parents('.ingredient-item').find('input[type="hidden"]').val();

        $button.parents('.modal-body').find('#available-ingredients').find('input[value="' + ingredientId + '"]').parents('.ingredient-item').removeClass('hidden');

        if (isDefault) {
            $button.parents('.ingredient-item').addClass('hidden');
        } else {
            var $rowHtml = $button.parents('.ingredient-item');
            $rowHtml.find('a').removeClass('active');
            $rowHtml.find('.col-xs-1').html('');
            $rowHtml.appendTo($('#available-ingredients'));
        }

        $.calculateTotalIngredients($('#ingredients-modal'));
    };

    $.calculateTotalIngredients = function ($modal) {
        $modal.find('.error').hide();

        var total = 0, totalWeight = 0, $total, $totalWeight, totalCount = 0;
        var $calculatedIngredients = $modal.find('#calculated-ingredients');

        totalWeight += parseInt($calculatedIngredients.data("base-weight"));

        $calculatedIngredients.find('.ingredient-item').not(':hidden').each(function () {
            var $row = $(this), $price, count, price, weight;
            var isDefault = $row.hasClass('default-ingredient-item');

            if (isDefault) {
                var $active = $row.find('.ingredient-portions').find('.active');
                count  = parseInt($active.data('count'), 10) - 1;
                price  = parseFloat($active.data('price'));
                weight = parseFloat($active.data('weight'));

                total += price * count;
                totalWeight += weight;
                totalCount += count + 1;
            } else {
                total += parseFloat($row.find('.ingredient-price').find('span').text());
                totalCount += parseInt($row.find('.ingredient-portions').find('.active').data('count'));
                totalWeight += parseFloat($row.find('.ingredient-portions').find('.active').data('weight'));
            }
        });

        $total = $modal.find('#calculated-ingredients-total');
        $totalWeight = $modal.find('#calculated-ingredients-weight');

        total += parseFloat($total.data('base-price'));

        $total.find('span').text(number_format(total, 0, '.', ' ') + ' ТГ.');
        $totalWeight.find('span').text(number_format(totalWeight, 0, '.', ' ') + ' г.');

        $.checkIngredientCount(totalCount);
    };

    $.customProductSubmit = function (button) {
        var $button = $(button);
        var $modal = $button.parents('.modal');

        var ingredients = [];

        $modal.find('#calculated-ingredients').find(':input').each(function() {
            ingredients.push($(this).val());
        });

        var name = $modal.find(':input[name="name"]').val();
        var product_size_id = $modal.find(':input[name="product_size_id"]').val();

        $.post('/cart/custom', { name : name, ingredients : ingredients, product_size_id : product_size_id }, function(response) {
            if (response.result == 'success') {
                var productsCount = size(response.cart.products);

                $('.cart-mini-count').text(productsCount);
                $('.cart-mini-products').text(productsCount + ' ' + response.p);
                $('.cart-mini-total').text(response.cart.total.text);

                $('.cart-mini').addClass('not-empty');

                $modal.modal('hide');
            }
        }, 'json');
    };

    $.setMenuSorting = function (button) {
        $('.menu-sorting').removeClass('active');

        $(button).addClass('active');

        $.applyFilter();
    };

    $.setMenuFiltering = function (button) {
        var $button   = $(button), $label;
        var $dropdown = $button.parents('.dropdown');

        $dropdown.find('.active').removeClass('active');

        if ($button.data('label')) {
            $label = $button.data('label');
        } else {
            $label = $button.text();
        }

        $dropdown.find('button').html($label + '<span class="caret"></span>');

        $button.addClass('active');

        $.applyFilter();
    };

    $.applyFilter = function () {
        var loader = new SVGLoader(document.getElementById('loader'), {speedIn : 700, easingIn : mina.easeinout});
        loader.show();

        var filters = {
            menu              : $('#breadcrumbs').data('url'),
            sort              : $('.menu-sorting.active').data('sort'),
            filter_preference : $('.filter-preferences').find('.active').data('filter-preference'),
            filter_ingredient : $('.filter-ingredients').find('.active').data('filter-ingredient')
        };

        $.post('/menu/grid', filters, function (response) {
            $('#menu-list').replaceWith(response.content);
            $.checkMenu();

            loader.hide();
        }, 'json');
    };