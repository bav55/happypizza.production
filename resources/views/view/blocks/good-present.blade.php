@php $good_present = \App\Http\Controllers\View\ApiController::getGood($value['good']); @endphp
<div class="col-md-6 col-xs-12 cart-products-list-item" id="data-{{ $value['good'] }}" data-good="{{ $value['good'] }}">
    <div class="row">
        <div class="col-xs-4">
            <img class="cart-products-list-item-image" src="{{ $good_present['image'] }}" alt="{{ $good_present['title'] }}">
        </div>

        <div class="col-xs-8 cart-products-list-item-description">
            <div class="row">
                <div class="col-xs-12">
                    <span class="cart-products-list-item-title">{{ $good_present['title'] }}</span>
                </div>
            </div>

            <div class="row cart-item-bottom">
                <div class="col-md-5">
                </div>
                <div class="col-md-3">
                </div>
                <div class="col-md-4">

                </div>
            </div>
        </div>
    </div>
</div>