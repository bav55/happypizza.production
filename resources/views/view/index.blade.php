@extends('layouts.guest')

@section('meta-content')
    <title>{{ json_decode(\App\Models\Setting::all()->find(1)->seo)->title }}</title>
    <meta name="keywords" content="{{ json_decode(\App\Models\Setting::all()->find(1)->seo)->keywords }}">
    <meta name="description" content="{{ json_decode(\App\Models\Setting::all()->find(1)->seo)->description }}">
@endsection

@section('content')

    <div id="slides" class="is-full hidden-xs">
        <div class="container">
            <div id="index-slide">
                <div class="swiper-container">
                    <div class="swiper-wrapper">
                        @foreach($slider as $value)
                        <div class="swiper-slide">
                            <a href="{{ $value->title }}" class="slide-item" style="background-image: url({{ asset($value->url) }});">
                                <!--<span class="red-button">Подробнее</span>-->
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="swiper-pagination"></div>
                <div id="prev" class="swiper-button-prev"></div>
                <div id="next" class="swiper-button-next"></div>
            </div>

            <div class="slides-left is-lft">
                <div id="pizza-girl" class="is-abs"></div>

                <div class="delivery-title is-full"></div>
                <div class="delivery-60 is-full">
                    <span></span> ОПОЗДАЕМ
                </div>
                <div class="delivery-sub is-full">пицца в подарок</div>
            </div>
        </div>
    </div>

    <div id="menu-list" class="is-full menu-list-block i-menu-list">
        <div class="container index-container">
            <div id="index-menu-list" class="row">
                <div class="col-xs-12 text-center">
                    <h3>Закажи вкуснейшую пиццу</h3>
                </div>
            </div>

            <div class="row menu-list-row">
                @foreach($goods as $good)
                    @include('view.blocks.good-block')
                @endforeach
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <div class="look-all is-full">
                        <a href="{{ route('category_link','pizza') }}">СМОТРЕТЬ ВСЕ</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="gray-curve"></div>
    </div>

    <div id="index-news" class="is-full">
        <div class="wood-shadow-holder is-abs">
            <div></div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-xs-12 text-center">
                    <h3>Новости и акции</h3>
                </div>
                @foreach($actions as $action)
                    <div class="col-sm-4 col-xs-6 text-center">
                        @if (empty($action->url_product))
                        <a class="index-news-item" href="{{ route('action', $action->url) }}">
                        @else 
                        <a class="index-news-item" href="{{ $action->url_product }}">
                        @endif
                            <img src="{{ asset($action->image) }}" alt="{{ $action->title }}">
                            <!--<span class="red-button">Подробнее</span>-->
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @include('view.blocks.constructor')

@endsection

@if( json_decode(\App\Models\Setting::all()->find(1)->seo)->content )
    @php
        $seo_block_title = json_decode(\App\Models\Setting::all()->find(1)->seo)->content_title;
        $seo_block_content = json_decode(\App\Models\Setting::all()->find(1)->seo)->content;
    @endphp
    @include('view.blocks.seo-text-block')
@endif

@section('script')
   <?php /* @if (Auth::guest())
        <script>
            function ChangeComposition() {
                alert('Необходимо авторизоваться');
            }
        </script>
    @else */ ?>
        <script src="{{ asset('tpl/js/constructor.js') }}"></script>
        <script>
            @php
                $ingredients = \App\Models\Ingredient::where('category_id','1')->get();
                $count = count($ingredients);
                $string = 'ing = {';
                $in = 0;
                    foreach ($ingredients as $ingredient){
                        $string .= '"'.$ingredient->id .'": {';
                            $string .= 'part_1:' . $ingredient->part_1 .',';
                            $string .= 'part_2:' . $ingredient->part_2 .',';
                            $string .= 'port: 0,';
                            $string .= 'w_1: 100,';
                            $string .= 'w_2: 200';
                        $string .= '}'; $count-1 != $in ? $string .= ',' : $string .='';
                        $in++;
                    }
                $string .= '}';
            echo $string;
            @endphp
            
            if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) 
    || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) {
            var html = $('#index-news');
            $('#slides').after(html);
            $('#index-news').css('margin-top', '110px');
        }
        </script>
   <?php /*  @endif */ ?>

@endsection