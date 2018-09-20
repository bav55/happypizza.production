@extends('layouts.guest')

@section('meta-content')
    <title>{{ $product[0]->seo_title }}</title>
    <meta name="keywords" content="{{ $product[0]->seo_keywords }}">
    <meta name="description" content="{{ $product[0]->seo_description }}">
@endsection

@section('content')
    <div id="wrapper" class="is-full">
        <div id="content" class="container">
            <div class="row">
                @include('view.blocks.left-block')
                <div class="col-md-9 col-sm-8 col-xs-12 no-lp inner-content menu-inner-content">
                     <div id="breadcrumbs" class="is-full" data-url="supi-i-salati">
                         <a href="{{ route('index') }}">Главная</a> / <a href="{{ route('category_link',$categoryProduct[0]->url) }}">{{ $categoryProduct[0]->title }}</a> / <span>{{ $product[0]->title }}</span>
                    </div>
                    <div class="tovar-block">
                    	<div class="top-side clearfix">
                            <div class="left-top-side">
                    			<img src="{{ isset($product[0]->image_full) ? $product[0]->image_full : $product[0]->image }}" alt="tovar">
                    		</div>
                    		<div class="right-top-side">
                    			<div class="tovar-name">
                                    <p>{{ $product[0]->title }}</p>  
                                </div>
                                <div class="consist-tovar">
                                    {!! $product[0]->content !!}
                                </div>
                                <div class="choose-pizza">
                                     <select id="effectTypes" data-select="{{ $product[0]->id }}" onchange="/*rePriceProduct();*/ StatusSelect();" class="product-size-select">
                                        {!! App\Http\Controllers\View\ApiController::getGoodPortions($product[0]->id) !!}
                                    </select>
                                    @if ($product[0]->category_id == 1)
                                    <div class="change-ingred">
                                        <span class="plus-span" onclick="$('#ingredients').click(); return false;">+</span><span class='change-ing' onclick="$('#ingredients').click(); return false;">Изменить ингредиенты</span>
                                    </div>
                                    @endif
                                </div>

                                <div class="bottom-choose-pizza">
                                  <div class="menu-list-count">
                                     <span class="minus" onclick="minusNew();">-</span>
                                     <span id="ml-countproduct" class="ml-count">1</span>
                                     <span class="plus" onclick="plusNew();">+</span>
                                 </div>  
                                   
                                 <div class="price-tovar">
                                     <h4 id="menu-list-price-{{ $product[0]->id }}"><span>{!! App\Http\Controllers\View\ApiController::getGoodfiresPortionPrice($product[0]->id) !!}</span> тг</h4>
                                     <a href="" class="buy-button" onclick="$('#button-cart').click(); return false;">
                                         <img  src="/tpl/images/product/cart.png" alt="cart"><p>В корзину</p>
                                     </a>
                                 </div>
                                 
                                </div>
                    		</div>
                                        
                                <div style="display:none;" class="col-md-4 col-xs-6 good-block" data-preference="{{ $product[0]->preference_id }}" data-ingredient="{{  $product[0]->ingredient_id }}">
                                    <div class="menu-list-item is-full">
                                        <div class="menu-list-image menu-image-index"><img src="{{ asset($product[0]->image) }}" alt="{{ $product[0]->title }}"></div>
                                        {!! ($product[0]->is_hit == '1') ? '<div class="is-hit"></div>' : '' !!}
                                        {!! ($product[0]->is_new == '1') ? '<div class="is-new"></div>' : '' !!}
                                        <div class="menu-list-text is-full">
                                            <div class="menu-list-title"><h4>{{ $product[0]->title }}</h4></div>
                                            <div class="menu-list-announce">{!! $product[0]->content !!}</div>
                                        </div>
                                        <div class="menu-items-el">
                                            @if ($product[0]->category_id == 1)
                                                <div class="change-ing"><a id="ingredients" href="#" onclick="ChangeComposition(this, {{ $product[0]->id }});return false;" data-auth="{{ Auth::guest() ? 'false' : 'true' }}">Изменить состав</a></div>
                                                <img class="hidden" src="{{ asset('tpl/images/loader.gif') }}">
                                            @endif
                                            <div class="is-full">
                                                <div class="menu-list-settings">
                                                    <div class="menu-list-size">
                                                        <select id="main-select" data-select="{{ $product[0]->id }}" onchange="/*rePriceProduct()*/" class="product-size-select">
                                                            {!! App\Http\Controllers\View\ApiController::getGoodPortions($product[0]->id) !!}
                                                        </select>
                                                    </div>
                                                    <div class="menu-list-count">
                                                        <span id="minus" class="minus">-</span>
                                                        <span id="count-product" class="ml-count">1</span>
                                                        <span id="plus" class="plus">+</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="menu-list-price" id="menu-list-price-{{ $product[0]->id }}"><span>{!! App\Http\Controllers\View\ApiController::getGoodfiresPortionPrice($product[0]->id) !!}</span> тг</div>
                                            <div class="to-cart-button">
                                                <a id="button-cart" href="#" onclick="addToCart(this); return false;" data-good="{{ $product[0]->id }}" class="red-button">В корзину</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                        
                    	</div>
                        <div class="top-side-small">
                            <div class="tovar-name">
                                    <p>{{ $product[0]->title }}</p>  
                                </div>
                            <div class="left-top-side">
                                <img src="{{ $product[0]->image }}" alt="tovar">
                            </div>
                             <div class="consist-tovar">
                                    <p>{{ $product[0]->title }}</p>
                                </div>
                                 <div class="wrapper-small-block">
                                     <div class="choose-pizza">
                                     <select id="effectTypes2" data-select="{{ $product[0]->id }}" onchange="/*rePriceProduct();*/ StatusSelect2();" class="product-size-select">
                                        {!! App\Http\Controllers\View\ApiController::getGoodPortions($product[0]->id) !!}
                                    </select>
                                </div>
                                <div class="bottom-choose-pizza small-choose-pizza">
                                     <div class="menu-list-count">
                                     <span class="minus" onclick="minusNew2();">-</span>
                                     <span id="ml-countproduct2" class="ml-count">1</span>
                                     <span class="plus" onclick="plusNew2();">+</span>
                                 </div> 
                                </div>
                                 </div>
                                <div class="wrapper-small-block">
                                   @if ($product[0]->category_id == 1)
                                    <div class="change-ingred">
                                        <span class="plus-span" onclick="$('#ingredients').click(); return false;">+</span><span class='change-ing' onclick="$('#ingredients').click(); return false;">Изменить ингредиенты</span>
                                    </div>
                                   @endif
                                 <div class="price-tovar">
                                    <h4 id="menu-list-price-{{ $product[0]->id }}"><span>{!! App\Http\Controllers\View\ApiController::getGoodfiresPortionPrice($product[0]->id) !!}</span> тг</h4>
                                    
                                 </div>
                                </div>
                                  <div class="wrapper-button-small">
                                      <a href="" class="buy-button" onclick="$('#button-cart').click(); return false;">
                                         <img src="/tpl/images/product/smallcart.png" alt="cart"><p>В корзину</p>
                                     </a>
                                  </div>
                        </div>
                        
                        <div class="bottom-block-text">
                            @if (!empty($product[0]->text))
                            <h5>Описание товара</h5>
                            {!! $product[0]->text !!}
                        @endif
                         <div class="bottom-add">
                            <h3>Закажи доставку прямо сейчас: </h3><span class="ringo-phone">+7 (727) 391-11-99</span>
                        </div>
                        </div>
                       
                    </div>
                    
                     
                    
                    
            </div>
            </div>
            
            @if($product[0]->recommended)
             <div class="col-lg-12 block-addons clearfix">
                 @foreach($banners as $banner)
                <div class="add-block cola-block">
                <img src="{{ asset($banner->image) }}" >
                    <div class="text-banner">{!! $banner->text !!}</div>
                    <a href="{{ $banner->url }}">{{ $banner->name_button }}</a>
                </div>
                @endforeach 
            </div> 
            @endif
            
            
        </div>
    </div>

    @if ($categoryProduct[0]->id == 1)
        @include('view.blocks.constructor')
    @endif

@endsection

@if( $categoryProduct[0]->content != null )
    @php
        $seo_block_title = $categoryProduct[0]->seo_title;
        $seo_block_content = $categoryProduct[0]->content;
    @endphp
    @include('view.blocks.seo-text-block')
@endif


@section('style')
    <link rel="stylesheet" href="{{ asset('tpl/css/product.css') }}">
@endsection
@section('script')
    @if ($categoryProduct[0]->id == 1)
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
            </script>
       <?php /* @endif */ ?>
    @endif
    <script src="{{ asset('tpl/js/filters.js') }}"></script>
     <script>
        function plusNew() {
          $('#plus').click();
          var count = $('#count-product').text();
          $('#ml-countproduct').text(count);
          //rePriceProduct();
        }
        function plusNew2() {
          $('#plus').click();
          var count = $('#count-product').text();
          $('#ml-countproduct2').text(count);
          //rePriceProduct();
        }
        function minusNew() {
          $('#minus').click();
          var count = $('#count-product').text();
          $('#ml-countproduct').text(count);
          //rePriceProduct();
        }
        function minusNew2() {
          $('#minus').click();
          var count = $('#count-product').text();
          $('#ml-countproduct2').text(count);
          //rePriceProduct();
        }
        function StatusSelect(){
           //var selected = $('#effectTypes').find('option[selected]'); 
           var selectOption = $("#effectTypes option:selected").val();
           $("#main-select").val(selectOption).change();
        };
        function StatusSelect2(){
           console.log('StatusSelect2');
           var selectOption = $("#effectTypes2 option:selected").val();
           $("#main-select").val(selectOption).change();
        };
        
        /* rePriceProduct */
        function rePriceProduct() {
            var productId = $('#main-select').data('select');
            var size_id = $('#main-select').val();
            var requestData = {
                size_id    : size_id
            };
               // var menuListSize = $(val).parent().parent();
                //var count = $(menuListSize).find('span.ml-count').text();
               var countProduct = $('#count-product').text();
console.log(countProduct);
            $.ajax({
                url: link + '/api/portion-reprice',
                type: "GET",
                data: requestData,
                dataType: "html",
                success: function (msg) {
                    console.log(msg);
                    $('#menu-list-price-' + productId + ' span').html(msg*countProduct);
                }
            });
        }
        /* rePriceProduct */
        
        //var html = '<div class="recommend-text"><p>Рекомендуем</p></div>';
        //$("#inner-menu").after(html);
        </script>
@endsection