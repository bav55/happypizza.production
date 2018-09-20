@php $api_good =  App\Http\Controllers\View\ApiController::getGood($good['good_id']); @endphp
<div class="col-md-6 col-xs-12 cart-products-list-item" id="data-{{ $good['good_id'] }}" data-good="{{ $good['good_id'] }}">
    <div class="row">
        <div class="col-xs-4">
            <img class="cart-products-list-item-image" src="{{ $api_good['image'] }}" alt="{{ $api_good['title'] }}">
        </div>

        <div class="col-xs-8 cart-products-list-item-description">
            <div class="row">
                <div class="col-xs-12">
                    <span class="cart-products-list-item-title">{{ $api_good['title'] }}</span>
                    <a href="#" onclick="removeFromCart(this);return false;" class="cart-products-list-item-delete pull-right" data-good="{{ $good['good_id'] }}" data-size="{{ $good['size_id'] }}">Удалить</a>
                </div>
            </div>

            <div class="row cart-item-bottom">
                <div class="col-md-5">
                    <select class="cart-size-select" data-select="{{ $good['good_id'] }}" data-gredient="{{ $good['size_id'] }}" onchange="CartRePrice(this)">
                        {!! \App\Http\Controllers\View\ApiController::getCartGoodSelected($good['good_id'], $good['size_id']) !!}
                    </select>
                </div>
                <div class="col-md-3">
                    <div class="menu-list-count">
                        <span class="minus">-</span>
                        <span class="ml-count">{{ $good['count'] }}</span>
                        <span class="plus">+</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <span id="cart-product-item-price-{{ $good['good_id'] }}" class="cart-products-list-item-price pull-right"><span>{{ \App\Http\Controllers\View\ApiController::PortionSizePrice($good['size_id']) }}</span> ТГ</span>
                </div>
            </div>
        </div>
    </div>

</div>