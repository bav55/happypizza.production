<div id="actiions-title" class="is-full">
    <h3>Акции</h3>
</div>

<div id="actions-list" class="actions-swiper">
    <div class="swiper-container">
        <div class="swiper-wrapper">

            @foreach(\App\Models\Action::where('date_at','<',date('Y-m-d').'00:00:00')
                            ->where('date_to','>',date('Y-m-d').'23:59:59')
                            ->orderBy('id','desc')->get() as $action)
                <div class="swiper-slide">
                    <div class="action-banner">
                        <img src="{{ asset($action->image) }}" alt="{{ $action->title }}">
                        <a href="{{ url('promotions',$action->url) }}" class="red-button">Подробнее</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div id="prev-action" class="swiper-button-prev"></div>
    <div id="next-action" class="swiper-button-next"></div>
</div>