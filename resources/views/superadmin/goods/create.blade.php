@extends('layouts.admin')

@section('search')
    <li class="nav-item">
        <form class="form-inline my-2 my-lg-0 mr-lg-2" action="{{ route('goods.index') }}" method="get">
            <div class="input-group">
                <input type="text" class="form-control" name="title" value="{{ request('title') }}" placeholder="Поиск товаров">
                <span class="input-group-btn">
                  <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
                </span>
            </div>
        </form>
    </li>
@endsection

@section('content')

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
        <li class="breadcrumb-item"><a href="{{ route('goods.index') }}">Товары</a></li>
        <li class="breadcrumb-item"><a href="{{ route('goods.create') }}">Добавление товара</a></li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">

                <form role="form" action="{{route('goods.store')}}" method="post">
                    <div class="box-header with-border row">
                        <div class="col-md-9"><h3 class="box-title">Добавление товара</h3></div>
                        <div class="col-md-3">
                            <a href="{{ route('goods.index') }}" type="button" class="btn btn-primary pull-left">Назад</a>
                            <button type="submit" class="btn btn-primary pull-right">Сохранить</button>
                        </div>
                    </div>
                    <hr>
                    <input type="hidden" name="_method" value="post">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-9">
                            <div class="box-body pad">
                                <div class="form-group">
                                    <label>Заголовок</label>
                                    <input type="text" name="title" class="form-control" required placeholder="Enter ...">
                                </div>
                                <div class="form-group">
                                    <label>Контент</label>
                                    <textarea id="content" class="textarea" name="content"></textarea>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group ingredient_id">
                                            <label for="exampleSelect1">Ингредиенты</label>
                                            <input type="hidden" id="ingredient_id" name="ingredient_id" value="[]">
                                            <select class="form-control multiselect" multiple="multiple">
                                                @foreach($ingredients as $ingredient)
                                                    <option data-category="{{ \App\Models\Category::getCategoryId($ingredient->category) }}" value="{{ $ingredient->id }}">{{ $ingredient->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group preference_id">
                                            <label for="exampleSelect1">Предпочтения</label>
                                            <input type="hidden" id="preference_id" name="preference_id" value="[]">
                                            <select class="form-control multiselect" multiple="multiple">
                                                @foreach($preferences as $preference)
                                                    <option data-category="{{ \App\Models\Category::getCategoryId($preference->category) }}" value="{{ $preference->id }}">{{ $preference->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group add_ingredient_id">
                                            <label for="exampleSelect1">Ингредиенты</label>
                                            <input type="hidden" id="add_ingredient_id" name="add_ingredient_id" value="[]">
                                            <select class="form-control multiselect" multiple="multiple">
                                                @foreach($ingredients as $ingredient)
                                                    <option data-category="{{ \App\Models\Category::getCategoryId($ingredient->category) }}" value="{{ $ingredient->id }}">{{ $ingredient->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label>Позиция товара</label>
                                            <input type="number" name="position" class="form-control" placeholder="Позиция товара">
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="col-12" id="size_price">
                                    <div class="row">
                                        <div class="col-8"><h6>Порции\Размер</h6></div>
                                        <div class="col-4"><a onclick="price_size(1)" type="button" class="btn btn-primary pull-right" style="color: #FFF;">Добавить</a></div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-6">
                                            <select class="form-control" name="size_price[1][port_id]">
                                                @foreach($portions as $portion)
                                                    <option value="{{ $portion->id }}">{{ $portion->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-5">
                                            <div class="form-group">
                                                <input class="form-control" type="number" name="size_price[1][port_price]" required placeholder="Цена">
                                            </div>
                                        </div>
                                        <div class="col-1">
                                            <a onclick="thiBlockRemove(this)" type="button" class="btn btn-danger" style="color: #FFF;"><i class="fa fa-close"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="box-body">
                                <div class="form-group">
                                    <label>Категория</label>
                                    <select class="form-control" name="category_id" id="good_category">
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <hr>
                                <div class="form-group">
                                    <label>SEO url</label>
                                   
                                       <input type="text" name="url" class="form-control">
                                    
                                </div>
                                <hr>
                                <div class="form-group">
                                    <div class="form-control">
                                        <label>Базовая цена</label>
                                        <input type="number" class="form-control" name="price" required>
                                    </div>
                                </div>
                                <hr>
                                <fieldset class="form-group">
                                    <label>Показывать на сайте?</label>
                                    <div class="row">
                                        <div class="form-check col-3">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="activation" id="activation" value="1" > Да</label>
                                        </div>
                                        <div class="form-check col-3">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="activation" id="activation" value="0" > Нет</label>
                                        </div>
                                    </div>
                                    <label>Популярный?</label>
                                    <div class="row">
                                        <div class="form-check col-3">
                                            <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="is_popular" id="is_popular" value="true"> Да</label>
                                        </div>
                                        <div class="form-check col-3">
                                            <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="is_popular" id="is_popular" value="false" checked> Нет</label>
                                        </div>
                                    </div>
                                </fieldset>
                                <hr>
                                <fieldset class="form-group">
                                    <label>Хит?</label>
                                    <div class="row">
                                        <div class="form-check col-3">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="is_hit" id="is_hit" value="true"> Да</label>
                                        </div>
                                        <div class="form-check col-3">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="is_hit" id="is_hit" value="false" checked> Нет</label>
                                        </div>
                                    </div>
                                </fieldset>
                                <hr>
                                <fieldset class="form-group">
                                    <label>Новинка?</label>
                                    <div class="row">
                                        <div class="form-check col-3">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="is_new" id="is_new" value="true"> Да</label>
                                        </div>
                                        <div class="form-check col-3">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="is_new" id="is_new" value="false" checked> Нет</label>
                                        </div>
                                    </div>
                                </fieldset>
                                <hr>
                                <div class="form-group">
                                    <label class="control-label count-mediafiles" for="inputMediafile">Изображение</label>
                                    <input type="text" class="form-control" onclick="MediaModal(this)" id="inputMediafile" required name="image" placeholder="url изображение">
                                </div>
                                <div class="form-group">
                                    <img src="" class="img-responsive" id="preview-post-img">
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('superadmin.media-modal')

@endsection

@section('script')
    <script src="{{ asset('assets/js/media-modal.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-multiselect.js') }}"></script>
    <script src="{{ asset('assets/js/option-checkbox.js') }}"></script>
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/plugins/codesnippet/plugin.js') }}"></script>
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/plugins/filetools/plugin.js') }}"></script>
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/plugins/font/plugin.js') }}"></script>
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/plugins/justify/plugin.js') }}"></script>
    <script>
        CKEDITOR.replace( 'content',{extraPlugins: 'codesnippet,filetools,font,justify'});
    </script>
@endsection