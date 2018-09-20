@extends('layouts.admin')

@section('content')

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
        <li class="breadcrumb-item"><a href="{{ route('action-pickup.index') }}">Акции (кол-во заказов)</a></li>
        <li class="breadcrumb-item"><a href="#">Редактирование</a></li>
        <li class="breadcrumb-item"><a href="{{ route('action-pickup.edit', $action->id) }}">{{ $action->title }}</a></li>
    </ol>

    <form action="{{ route('action-pickup.update', $action->id) }}" enctype="multipart/form-data" method="post">
        <input type="hidden" name="_method" value="put">
        {{ csrf_field() }}
        <div class="box box-warning">
            <div class="box-header with-border row">
                <div class="col-md-9"><h3 class="box-title">Редактирорвание {{ $action->title }}</h3></div>
                <div class="col-md-3">
                    <a href="{{ route('action-pickup.index') }}" type="button" class="btn btn-primary pull-left">Назад</a>
                    <button type="submit" class="btn btn-primary pull-right">Сохранить</button>
                </div>
            </div>
            <hr>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-9">
                    <div class="form-group">
                        <label>Заголовок</label>
                        <input type="text" name="title" class="form-control" required value="{{ $action->title }}">
                    </div>
                    <div class="form-group">
                        <label>url</label>
                        <input type="text" name="url" class="form-control" required value="{{ $action->url }}">
                    </div>
                    <div class="form-group">
                        <label>Анонс</label>
                        <textarea class="textarea" name="excerpt" style="display: block;width: 100%;">{{ $action->excerpt }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Контент</label>
                        <textarea class="textarea" name="content">{{ $action->content }}</textarea>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label count-mediafiles" for="inputMediafile">Изображение</label>
                        <input type="text" class="form-control" onclick="MediaModal(this)" id="inputMediafile" required="" name="image" placeholder="url изображение" value="{{ empty($action->image) ? '' : $action->image }}">
                    </div>
                    <div class="form-group">
                        <img src="{{ empty($action->image) ? '' : $action->image }}" class="img-responsive" id="preview-post-img">
                    </div>

                    <div class="form-group">
                        <label class="control-label">Дата начало</label>
                        <input type="text" class="form-control datepicker" name="date_at" value="{{ $action->date_at }}">
                    </div>


                    <div class="form-group">
                        <label class="control-label">Дата конца</label>
                        <input type="text" class="form-control datepicker" name="date_to" value="{{ $action->date_to }}">
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label">В каждом n-м заказе</label>
                        <input type="text" class="form-control" name="days" value="{{ $action->days }}">
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label">Сортировка</label>
                        <input type="text" class="form-control" name="sort" value="{{ $action->sort ? $action->sort : 0 }}">
                    </div>
                    
                    <fieldset class="form-group">
                        <label>Показать на главной</label>
                        <div class="row">
                            <div class="form-check col-3">
                                <label class="form-check-label"><input type="radio" class="form-check-input" name="show_main" id="show_main" value="true" {{ $action->show_main == 1 ? ' checked' : '' }}> Да</label>
                            </div>
                            <div class="form-check col-3">
                                <label class="form-check-label"><input type="radio" class="form-check-input" name="show_main" id="show_main" value="false" {{ $action->show_main == 0 ? 'checked' : '' }}> Нет</label>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="form-group">
                        <label>В сумме</label>
                        <div class="row">
                            <div class="form-check col-3">
                                <label class="form-check-label"><input type="radio" class="form-check-input" name="is_sum" id="is_sum" value="true" {{ $action->is_sum == 1 ? ' checked' : '' }}> Да</label>
                            </div>
                            <div class="form-check col-3">
                                <label class="form-check-label"><input type="radio" class="form-check-input" name="is_sum" id="is_sum" value="false" {{ $action->is_sum == 0 ? 'checked' : '' }}> Нет</label>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="form-group">
                        <label>В проценте</label>
                        <div class="row">
                            <div class="form-check col-3">
                                <label class="form-check-label"><input type="radio" class="form-check-input" name="is_percent" id="is_percent" value="true" {{ $action->is_percent == 1 ? 'checked' : '' }}> Да</label>
                            </div>
                            <div class="form-check col-3">
                                <label class="form-check-label"><input type="radio" class="form-check-input" name="is_percent" id="is_percent" value="false" {{ $action->is_percent == 0 ? 'checked' : '' }}> Нет</label>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset class="form-group">
                        <label>Подарок</label>
                        <div class="row">
                            <div class="form-check col-3">
                                <label class="form-check-label"><input type="radio" class="form-check-input" name="is_present" id="is_present" value="true" {{ $action->is_present == 1 ? 'checked' : '' }}> Да</label>
                            </div>
                            <div class="form-check col-3">
                                <label class="form-check-label"><input type="radio" class="form-check-input" name="is_present" id="is_present" value="false" {{ $action->is_present == 0 ? 'checked' : '' }}> Нет</label>
                            </div>
                        </div>
                    </fieldset>
                    
                    <fieldset class="form-group">
                        <label>Самовывоз?</label>
                        <div class="row">
                            <div class="form-check col-3">
                                <label class="form-check-label"><input type="radio" class="form-check-input" name="pickup" id="pickup" value="true" {{ $action->pickup == 1 ? 'checked' : '' }}> Да</label>
                            </div>
                            <div class="form-check col-3">
                                <label class="form-check-label"><input type="radio" class="form-check-input" name="pickup" id="pickup" value="false" {{ $action->pickup == 0 ? 'checked' : '' }}> Нет</label>
                            </div>
                        </div>
                    </fieldset>
                    
                </div>
            </div>
            <hr>
            <div style="display: none;" class="row">
                <div class="form-group col-md-11">
                    <label>Суммарное количество товаров участвующих в акции</label>
                    <input type="text" value="{{ $action->good_count }}" name="good_count" class="form-control">
                </div>
            </div>
            <div style="display: none;" class="row">
                <div class="form-group col-md-11">
                    <label>Суммарная стоимость товаров акции</label>
                    <input type="text" value="{{ $action->goods_sum }}" name="goods_sum" class="form-control">
                </div>
            </div>
            <div style="display: none;" class="row">
                <div class="form-group col-md-11">
                    <input type="text" value="Условие акции" class="form-control" disabled>
                </div>
                <div class="form-group col-md-1 pull-right">
                    <a href="#" onclick="addActionBlock(); return false;" class="btn btn-primary"><i class="fa fa-plus"></i> </a>
                </div>
            </div>
            <div id="share_condition">
                @php $action_list = json_decode($action->action); $score = 1; @endphp
                @if(!empty($action_list))
                    @foreach($action_list as $item)
                        <div class="row" data-attr="100">
                            <div class="form-group col-md-3">
                                <label>Категория</label>
                                <select class="form-control" name="action[{{ $score }}][category_id]" onchange="getCategoryGoods(this)" onchange="this.value=this.oldvalue;" onfocus="this.oldvalue=this.value;this.blur();" readonly="">
                                     @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ $category->id ==  $item->category_id ? 'selected' : '' }}>{{ $category->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-md-2 goods">
                                <label>Товары</label>
                                <input type="text" class="form-control" onclick="showMultiselect(this);" value="{{ isset($item->good_id) ? $item->good_id : '[]' }}" onfocus="this.blur()">
                                <input type="hidden" name="action[{{ $score }}][good_id]" value="{{ isset($item->good_id) ? $item->good_id : '[]' }}">
                            </div>
                            <div class="form-group col-md-2 sizes">
                                <label>Размеры</label>
                                <input type="text" class="form-control" onclick="showMultiselect(this);" value="{{ isset($item->sizes_id) ? $item->sizes_id : '[]' }}" onfocus="this.blur()">
                                <input type="hidden" name="action[{{ $score }}][sizes_id]" value="{{ isset($item->sizes_id) ? $item->sizes_id : '[]' }}">
                            </div>
                            <div class="form-group col-md-2">
                                <label>Кол-во</label>
                                <input type="number" class="form-control" name="action[{{ $score }}][count]" value="{{ $item->count }}">
                            </div>
                            <div class="form-group col-md-2">
                                <label>Пов-ие</label>
                                <input type="checkbox" class="form-control" name="action[{{ $score }}][checkbox]" {{ isset($item->checkbox) && $item->checkbox == 'on' ? 'checked' : '' }}>
                            </div>
                            <div class="form-group col-md-1 pull-right">
                                <label style="visibility: hidden">Удалить</label>
                                <a href="#" onclick="removeActionBlock(this); return false;" class="btn btn-danger"><i class="fa fa-close"></i> </a>
                            </div>
                        </div>
                        @php $score++; @endphp
                    @endforeach
                @endif
            </div>
            <div class="clearfix"></div>
            <div id="present">
                <div class="row">
                    <div class="form-group col-md-12">
                        <input type="text" value="Подарок / Скидка % / Скаидка Сумма" class="form-control" disabled>
                    </div>
                    <div class="col-md-4 action-block" id="input_is_present">
                        <div class="form-group present_category">
                            <label>Категория</label>
                            <select class="form-control" onchange="getPresentCategoryGoods(this);">
                                <option style="display: none;">Выберите</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        @if ($condition == 'true')
                            <div class="form-group present_good">
                                <label>Товар</label>
                                <input class="form-control" id="present_good_visual" value="{{ \App\Http\Controllers\Superadmin\ApiController::getGoodAttr($present->good)['title'] }}" data-good="{{ $present->good }}" data-category="{{ \App\Http\Controllers\Superadmin\ApiController::getGoodAttr($present->good)['category'] }}" onfocus="this.blur()">
                            </div>
                            <div class="form-group present_good">
                                <input type="number" class="form-control" name="present[count]" value="{{ $present->count }}" placeholder="Кол-во">
                            </div>
                        @else
                            <div class="form-group present_good">
                                <label>Товар</label>
                                <input class="form-control" id="present_good_visual" value="Выберите" onfocus="this.blur()">
                            </div>
                            <div class="form-group present_good">
                                <input type="number" class="form-control" name="present[count]" placeholder="Кол-во">
                            </div>
                        @endif
                    </div>
                    <div class="col-md-4 action-block" id="input_is_present">
                        <div class="form-group present_good">
                            <label>Скидка в %</label>
                            <input type="number" class="form-control" name="sales_percent" value="{{ $condition == 'false' && $action->is_percent == true ? $present : ''}}" placeholder="Скидка в %">
                        </div>
                    </div>
                    <div class="col-md-4 action-block" id="input_is_sum">
                        <div class="form-group present_good">
                            <label>Скидка в сумме</label>
                            <input type="number" class="form-control" name="sales_sum" value="{{ $condition == 'false' && $action->is_sum == true ? $present : ''}}" placeholder="Скидка в сумме">
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </form>

    @include('superadmin.media-modal')

@endsection


@section('script')
    <script src="{{ asset('assets/js/action.js') }}"></script>
    <script src="{{ asset('assets/js/media-modal.js') }}"></script>
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/plugins/codesnippet/plugin.js') }}"></script>
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/plugins/filetools/plugin.js') }}"></script>
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/plugins/font/plugin.js') }}"></script>
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/plugins/justify/plugin.js') }}"></script>
    <script>
        CKEDITOR.replace( 'content',{extraPlugins: 'codesnippet,filetools,font,justify'});
    </script>

@endsection