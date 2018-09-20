<div class="cart-mini ">
    <span class="cart-mini-count"><span>{{ \App\Http\Controllers\View\CartController::getCartGoodCount() }}</span></span>
    <div class="cart-mini-holder">
        <p>В корзине: <span class="cart-mini-products"><span>{{ \App\Http\Controllers\View\CartController::getCartGoodCount() }}</span> товаров</span></p>
        <p>На сумму: <span class="cart-mini-total"><span>{!! \App\Http\Controllers\View\CartController::getCartSum()['str'] !!}</span></span></p>
        <a href="{{ route('cart') }}" class="cart-mini-link">Перейти в корзину</a>
    </div>
</div>