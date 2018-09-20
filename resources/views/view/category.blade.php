@extends('layouts.guest')

@section('meta-content')
    <title>{{ $category[0]->seo_title }}</title>
    <meta name="keywords" content="{{ $category[0]->seo_keywords }}">
    <meta name="description" content="{{ $category[0]->seo_description }}">
@endsection

@section('content')
    <div id="wrapper" class="is-full">
        <div class="container">
            <div class="row">
                @include('view.blocks.left-block')
                <div class="col-md-9 col-sm-8 col-xs-7 no-lp inner-content menu-inner-content">
                    <div id="breadcrumbs" class="is-full" data-url="supi-i-salati">
                        <a href="{{ route('index') }}">Главная</a> / <span>{{ $category[0]->title }}</span>
                    </div>
                    <div id="page-title" class="is-full"><h1>{{ $category[0]->title }}</h1></div>
                    <div id="sort-by" class="is-full">
                        <div class="row">
                            <div class="col-lg-6 col-xs-12">
                                <span>Сортировать по:</span>
                                <a href="{{ route('category_link',$category[0]->url ) }}" class="menu-sorting {{ !request('order') ? 'active' : '' }}" data-sort="position">популярности</a>
                                <a href="{{ route('category_link',$category[0]->url.'?order=title' ) }}" class="menu-sorting {{ request('order') == 'title' ? 'active' : '' }}" data-sort="title">названию</a>
                                <a href="{{ route('category_link',$category[0]->url.'?order=price' ) }}" class="menu-sorting {{ request('order') == 'price' ? 'active' : '' }}" data-sort="price">цене</a>
                            </div>

                            <div class="col-lg-6 col-xs-12">
                                @if(count($ingredients) > 0)
                                    @include('view.blocks.ingredients')
                                @endif

                                @if(count($preferences) > 0)
                                    @include('view.blocks.preferences')
                                @endif
                            </div>
                        </div>
                    </div>

                    <div id="menu-list" class="is-full menu-list-block">
                        <div class="row menu-list-row">
                            @foreach($goods as $good)
                                @if($good->activation == 1)
                                    @include('view.blocks.good-block')
                                @endif
                            @endforeach
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @if ($category[0]->id == 1)
        @include('view.blocks.constructor')
    @endif

@endsection

@if( $category[0]->content != null )
    @php
        $seo_block_title = $category[0]->seo_title;
        $seo_block_content = $category[0]->content;
    @endphp
    @include('view.blocks.seo-text-block')
@endif

@section('script')
    @if ($category[0]->id == 1)
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
@endsection