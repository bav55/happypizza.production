<ul>
    <li>
        <span>Меню</span>
        <ul>
            @include('view.blocks.food-block')
        </ul>
    </li>
    
    <li><a href="{{ url('promotions') }}">Акции</a></li>
    <li><a href="{{ url('delivery-and-payment') }}">Доставка и оплата</a></li>
    <li><a href="{{ route('reviews') }}">Отзывы</a></li>
    
</ul>