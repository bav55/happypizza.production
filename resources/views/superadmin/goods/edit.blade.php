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
        <li class="breadcrumb-item"><a href="#">Редактирование</a></li>
        <li class="breadcrumb-item"><a href="{{ route('goods.edit', $good->id) }}">{{ $good->title }}</a></li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">

                <form role="form" action="{{route('goods.update',$good->id)}}" method="post">
                    <input type="hidden" name="_method" value="put">
                    {{ csrf_field() }}
                    <div class="box-header with-border row">
                        <div class="col-md-9"><h3 class="box-title">Редактирорвание {{ $good->title }}</h3></div>
                        <div class="col-md-3">
                            <a href="{{ route('goods.index') }}" type="button" class="btn btn-primary pull-left">Назад</a>
                            <button type="submit" class="btn btn-primary pull-right">Сохранить</button>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-9">
                            <div class="box-body pad">
                                <div class="form-group">
                                    <label>Заголовок</label>
                                    <input type="text" name="title" class="form-control" required placeholder="Enter ..." value="{{ $good->title }}">
                                </div>
                                <div class="form-group">
                                    <label>Meta Title</label>
                                    <input type="text" name="seo_title" class="form-control"  placeholder="Enter ..." value="{{ $good->seo_title }}">
                                </div>
                                <div class="form-group">
                                    <label>Meta Description</label>
                                    <input type="text" name="seo_description" class="form-control"  placeholder="Enter ..." value="{{ $good->seo_description }}">
                                </div>
                                <div class="form-group">
                                    <label>Meta Keywords</label>
                                    <input type="text" name="seo_keywords" class="form-control" required placeholder="Enter ..." value="{{ $good->seo_keywords }}">
                                </div>
                                <div class="form-group">
                                    <label>Контент</label>
                                    <textarea id="content" class="textarea" name="content">{{ $good->content }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Описание</label>
                                    <textarea id="text-product" class="textarea" name="text">{{ $good->text }}</textarea>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group ingredient_id">
                                            <label for="exampleSelect1">Ингредиенты</label>
                                            <!--<input type="hidden" id="ingredient_id" name="ingredient_id" value="{{ $good->ingredient_id }}">-->
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
                                            <input type="hidden" id="preference_id" name="preference_id" value="{{ $good->preference_id }}">
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
                                            <label for="exampleSelect1">Дополнительные ингредиенты</label>
                                            <input type="hidden" id="add_ingredient_id" name="add_ingredient_id" value="{{ $good->add_ingredient_id }}">
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
                                            <input type="number" name="position" class="form-control" placeholder="Позиция товара" value="{{ $good->position }}">
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="col-12" id="size_price">
                                    <div class="row">
                                        <div class="col-8"><h6>Порции\Размер</h6></div>
                                        <div class="col-4"><a onclick="price_size({{ count($portions) }})" type="button" class="btn btn-primary pull-right" style="color: #FFF;">Добавить</a></div>
                                    </div>
                                    <hr>
                                    @php $i = 0; @endphp
                                    @foreach($portions as $portion)
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <input class="form-control" type="text" readonly value="{{ App\Models\Portion::getPortionName($portion->portion) }}">
                                                    <input type="hidden" name="size_price[{{ $i }}][port_id]" value="{{ $portion->portion_id }}">
                                                </div>
                                            </div>
                                            <div class="col-5">
                                                <div class="form-group">
                                                    <input class="form-control" type="number" name="size_price[{{ $i }}][port_price]" required placeholder="Цена" value="{{ $portion->portion_price }}">
                                                </div>
                                            </div>
                                            <div class="col-1">
                                                <a onclick="thiBlockRemove(this)" type="button" class="btn btn-danger" style="color: #FFF;"><i class="fa fa-close"></i></a>
                                            </div>
                                        </div>
                                        @php $i++; @endphp
                                    @endforeach
                                </div>
                                
                                
                                
                                
                                @php 
                                if (!is_null($good->ingredient_id)){
                                    $ingredient_id_array = json_decode($good->ingredient_id);
                                }
                                else {
                                    $ingredient_id_array = array();
                                }
                                @endphp        
                                <hr>
                                <div class="col-12" id="ingredient_tab">
                                    <div class="row">
                                        <div class="col-8"><h6>Ингредиенты</h6></div>
                                        <div class="col-4"><a onclick="add_ingridient({{ count($ingredient_id_array) }})" type="button" class="btn btn-primary pull-right" style="color: #FFF;">Добавить</a></div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-6"></div> 
                                        
                                        <div class="col-3">1 порция</div>
                                        <div class="col-2">Можно удалять</div>
                                        <div class="col-1"></div>
                                    </div>    
                                    <hr>
                                    
                                    @php $i = 0; @endphp
                                    @php 
                                        //$ingredient_id_array = json_decode($good->ingredient_id); 
                                        if ($good->ingredient_id_off){
                                            $ingredient_id_off = json_decode($good->ingredient_id_off);
                                        }
                                        else {
                                            $ingredient_id_off = array();
                                        }
                                        
                                       /* print_r($ingredient_id_off);
                                        print_r(json_encode($good->ingredient_id_off));exit();*/
                                        
                                        if ($good->ingredient_id_del){
                                            $ingredient_id_del = json_decode($good->ingredient_id_del);
                                        }
                                        else {
                                            $ingredient_id_del = array();
                                        }
                                        
                                        if(!$ingredient_id_del) {
                                            $ingredient_id_del = array();
                                        }
                                        
                                        //dd($good);exit();
                                    @endphp
                                    
                                    
                                     @foreach($ingredients as $ingredient)
                                        @if(isset($ingredient_id_array))
                                           @if(in_array($ingredient->id, $ingredient_id_array))         
                                           <div class="row">
                                               <div class="col-6">
                                                   <div class="form-group">

                                                       <input class="form-control" type="text" readonly value="{{ $ingredient->title }}">
                                                       <input type="hidden" name="ingredient_id[]" value="{{ $ingredient->id }}">

                                                   </div>
                                               </div>
                                               <div class="col-3">  
                                                   @if(in_array($ingredient->id, $ingredient_id_off))
                                                       <input checked="checked" type="checkbox" name="ingredient_id_off[]" value="{{ $ingredient->id }}">
                                                   @else 
                                                       <input type="checkbox" name="ingredient_id_off[]" value="{{ $ingredient->id }}">
                                                   @endif    
                                               </div>
                                               <div class="col-2">  
                                                  @if(in_array($ingredient->id, $ingredient_id_del))
                                                       <input checked="checked" type="checkbox" name="ingredient_id_del[]" value="{{ $ingredient->id }}">
                                                   @else 
                                                       <input type="checkbox" name="ingredient_id_del[]" value="{{ $ingredient->id }}">
                                                   @endif
                                               </div>
                                               <div class="col-1">
                                                   <a onclick="thiBlockRemove(this)" type="button" class="btn btn-danger" style="color: #FFF;"><i class="fa fa-close"></i></a>
                                               </div>
                                           </div>
                                           @php $i++; @endphp
                                           @endif
                                       @endif  
                                    @endforeach
                                </div>
                                
                                @php 
                                if (!is_null($good->recommended)){
                                    $recommended_id_array = json_decode($good->recommended);
                                }
                                else {
                                    $recommended_id_array = array();
                                }
                                @endphp        
                                <hr>
                                <div class="col-12" id="recommended_tab">
                                    <div class="row">
                                        <div class="col-8"><h6>Рекомендуемые</h6></div>
                                        <div class="col-4"><a onclick="add_recommended({{ count($recommended_id_array) }})" type="button" class="btn btn-primary pull-right" style="color: #FFF;">Добавить</a></div>
                                    </div>
  
                                    <hr>
                                    
                                    @php $i = 0; @endphp
                                    
                                    
                                    
                                     @foreach($recommendeds as $recommended)
                                        @if(isset($recommended_id_array))
                                           @if(in_array($recommended->id, $recommended_id_array))         
                                           <div class="row">
                                               <div class="col-6">
                                                   <div class="form-group">

                                                       <input class="form-control" type="text" readonly value="{{ $recommended->title }}">
                                                       <input type="hidden" name="recommended_id[]" value="{{ $recommended->id }}">

                                                   </div>
                                               </div>
                                               <div class="col-5"></div>
                                               
                                               <div class="col-1">
                                                   <a onclick="thiBlockRemove(this)" type="button" class="btn btn-danger" style="color: #FFF;"><i class="fa fa-close"></i></a>
                                               </div>
                                           </div>
                                           @php $i++; @endphp
                                           @endif
                                       @endif  
                                    @endforeach
                                </div>
                                
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="box-body">
                                <div class="form-group">
                                    <label>Категория</label>
                                    <select class="form-control" name="category_id" id="good_category">
                                        @foreach($categories as $category)
                                            <option {{ \App\Models\Category::getCategoryId($good->category) == $category->id ? 'selected' : '' }} value="{{ $category->id }}">{{ $category->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                 <div class="form-group">
                                    <label>SEO url</label>
                                   
                                       <input type="text" name="url" class="form-control"  value="{{ $good->url }}">
                                    
                                </div>
                                <hr>
                                <div class="form-group">
                                    <div class="form-control">
                                        <label>Базовая цена</label>
                                        <input type="number" class="form-control" name="price" required value="{{ $good->price }}">
                                    </div>
                                </div>
                                <hr>
                                <fieldset class="form-group">
                                    <label>Показывать на сайте?</label>
                                    <div class="row">
                                        <div class="form-check col-3">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="activation" id="activation" value="true" {{ $good->activation == 1 ? 'checked' : '' }}> Да</label>
                                        </div>
                                        <div class="form-check col-3">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="activation" id="activation" value="false" {{ $good->activation == 0 ? 'checked' : '' }}> Нет</label>
                                        </div>
                                    </div>
                                    
                                    <label>Популярный?</label>
                                    <div class="row">
                                        <div class="form-check col-3">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="is_popular" id="is_popular" value="true" {{ $good->is_popular == 1 ? 'checked' : '' }}> Да</label>
                                        </div>
                                        <div class="form-check col-3">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="is_popular" id="is_popular" value="false" {{ $good->is_popular == 0 ? 'checked' : '' }}> Нет</label>
                                        </div>
                                    </div>
                                </fieldset>
                                <hr>
                                <fieldset class="form-group">
                                    <label>Хит?</label>
                                    <div class="row">
                                        <div class="form-check col-3">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="is_hit" id="is_hit" value="true" {{ $good->is_hit == 1 ? 'checked' : '' }}> Да</label>
                                        </div>
                                        <div class="form-check col-3">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="is_hit" id="is_hit" value="false" {{ $good->is_hit == 0 ? 'checked' : '' }}> Нет</label>
                                        </div>
                                    </div>
                                </fieldset>
                                <hr>
                                <fieldset class="form-group">
                                    <label>Новинка?</label>
                                    <div class="row">
                                        <div class="form-check col-3">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="is_new" id="is_new" value="true" {{ $good->is_new == 1 ? 'checked' : '' }}> Да</label>
                                        </div>
                                        <div class="form-check col-3">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="is_new" id="is_new" value="false" {{ $good->is_new == 0 ? 'checked' : '' }}> Нет</label>
                                        </div>
                                    </div>
                                </fieldset>
                                <hr>
                                <div class="form-group">
                                    <label class="control-label count-mediafiles" for="inputMediafile">Изображение</label>
                                    <input type="text" class="form-control" onclick="MediaModal(this)" id="inputMediafile" required name="image" placeholder="url изображение" value="{{ $good->image }}">
                                </div>
                                <div class="form-group">
                                    <img src="{{ $good->image != 'null' ? $good->image : '' }}" class="img-responsive" id="preview-post-img">
                                </div>
                                
                                <div class="form-group">
                                    <label class="control-label count-mediafiles" for="inputMediafile">Изображение большоее</label>
                                    <input type="text" class="form-control" onclick="MediaModal(this, 2)" id="inputMediafile" required name="image_full" placeholder="url изображение" value="{{ $good->image_full }}">
                                </div>
                                <div class="form-group">
                                    <img src="{{ $good->image_full != 'null' ? $good->image_full : '' }}" class="img-responsive" id="preview-post-img-2">
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
        CKEDITOR.replace( 'text-product',{extraPlugins: 'codesnippet,filetools,font,justify'});
        
        $('.ingredient_id select').multiselect('select',ingredients);
        $('.preference_id select').multiselect('select',preferences);
        $('.add_ingredient_id select').multiselect('select',add_ingredient);

    </script>
@endsection