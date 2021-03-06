<?php if (isset($urlAlias[$good->id])){
    $url = $urlAlias[$good->id];
} else {
   $url =  $good->id;
}
?>

<div class="col-md-4 col-xs-6 good-block" data-preference="{{ $good->preference_id }}" data-ingredient="{{ $good->ingredient_id }}">
    <div class="menu-list-item is-full">
        <div class="menu-list-image menu-image-index">
             @if($good->activation)
            <a href="{{ route('product_link',$url) }}"><img src="{{ asset($good->image) }}" alt="{{ $good->title }}"></a>
            @else
            <img src="{{ asset($good->image) }}" alt="{{ $good->title }}">
            @endif
        </div>
        {!! ($good->is_hit == '1') ? '<div class="is-hit"></div>' : '' !!}
        {!! ($good->is_new == '1') ? '<div class="is-new"></div>' : '' !!}
        <div class="menu-list-text is-full">
            <div class="menu-list-title">
            @if($good->activation)    
            <a href="{{ route('product_link',$url) }}"><h4>{{ $good->title }}</h4></a>
            @else
            <h4>{{ $good->title }}</h4>
            @endif
            </div>
            <div class="menu-list-announce">{!! $good->content !!}</div>
            
        </div>
        <div class="menu-items-el">
            @if ($good->category_id == 1)
                <div class="change-ing"><a href="#" onclick="ChangeComposition(this, {{ $good->id }});return false;" data-auth="{{ Auth::guest() ? 'false' : 'true' }}">Изменить состав</a></div>
                <img class="hidden" src="{{ asset('tpl/images/loader.gif') }}">
            @endif
            <div class="is-full">
                <div class="menu-list-settings">
                    <div class="menu-list-size">
                        <select data-select="{{ $good->id }}" onchange="rePrice(this)" class="product-size-select">
                            {!! App\Http\Controllers\View\ApiController::getGoodPortions($good->id) !!}
                        </select>
                    </div>
                    <div class="menu-list-count">
                        <span class="minus">-</span>
                        <span class="ml-count">1</span>
                        <span class="plus">+</span>
                    </div>
                </div>
            </div>
            <div class="menu-list-price" id="menu-list-price-{{ $good->id }}"><span>{!! App\Http\Controllers\View\ApiController::getGoodfiresPortionPrice($good->id) !!}</span> тг</div>
            <div class="to-cart-button">
                <a href="#" onclick="addToCart(this); return false;" data-good="{{ $good->id }}" class="red-button">В корзину</a>
            </div>
        </div>
    </div>
</div>