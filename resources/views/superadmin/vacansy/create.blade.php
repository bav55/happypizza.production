@extends('layouts.admin')

@section('content')

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
        <li class="breadcrumb-item"><a href="{{ route('vacancy.index') }}">Вакансии</a></li>
        <li class="breadcrumb-item"><a href="{{ route('vacancy.create') }}">Добавление</a></li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <form role="form" action="{{ route('vacancy.store') }}" method="post">
                    <input type="hidden" name="_method" value="post">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Заголовок</label>
                                <input type="text" name="title" class="form-control" required placeholder="Enter ...">
                            </div>
                            <div class="form-group">
                                <label>Превью</label>
                                <textarea class="form-control" name="excerpt" rows="3" placeholder="Enter ..."></textarea>
                            </div>
                            <div class="form-group">
                                <label>Контент</label>
                                <textarea id="content" class="textarea" name="content"></textarea>
                            </div>
                            <fieldset class="form-group">
                                <label>Отображать на сайте?</label>
                                <div class="row">
                                    <div class="form-check col-3">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="is_show" value="true" checked> Да</label>
                                    </div>
                                    <div class="form-check col-3">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="is_show" value="false"> Нет</label>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="form-group">
                                <label>Сортировка</label>
                                <input type="number" name="sort" class="form-control" placeholder="Enter ...">
                            </div>
                            <div class="form-group has-success">
                                <label class="control-label count-mediafiles" for="inputMediafile">Изображение</label>
                                <input type="text" class="form-control" onclick="MediaModal(this)" id="inputMediafile" name="image" placeholder="url изображение">
                                <small>Для замены выбериту другое изображение</small>
                            </div>
                            <div class="form-group">
                                <img src="" class="img-responsive" id="preview-post-img">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Анкета</label>
                                <input type="button" class="btn btn-primary form-control" data-count="1" onclick="addVacancyForm(this)" value="Добавить">
                            </div>
                            <div id="form-input">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="clearfix"></div>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                    <hr>
                </form>
            </div>
        </div>
    </div>

    @include('superadmin.media-modal')

@endsection

@section('script')
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