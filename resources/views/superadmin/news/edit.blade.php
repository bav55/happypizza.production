@extends('layouts.admin')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
        <li class="breadcrumb-item"><a href="{{ route('news.index') }}">Новости</a></li>
        <li class="breadcrumb-item"><a href="#">Редактирование</a></li>
        <li class="breadcrumb-item"><a href="{{ route('news.edit', $new->id) }}">{{ $new->title }}</a></li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title">Редактирование {{ $new->title }}</h3>
                </div>
                <form role="form" action="{{route('news.update', $new->id)}}" method="post">
                    <input type="hidden" name="_method" value="put">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-9">
                            <div class="box-body pad">
                                <div class="form-group">
                                    <label>Заголовок</label>
                                    <input type="text" name="title" class="form-control" value="{{ $new->title }}" required placeholder="Enter ...">
                                </div>
                                <label for="basic-url">ЧПУ (url)</label>
                                <div class="input-group{{ $errors->has('url') ? ' has-danger' : '' }}" style="margin-bottom: 10px;">
                                    <span class="input-group-addon" id="basic-addon3">http://happypizza.kz/news/</span>
                                    <input type="text" name="url" value="{{ $new->url }}" class="form-control" id="basic-url" aria-describedby="basic-addon3">
                                    @if ($errors->has('url'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('url') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Превью</label>
                                    <textarea class="form-control" name="excerpt" rows="3" placeholder="Enter ...">{{ $new->excerpt }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Контент</label>
                                    <textarea id="content" class="textarea" name="content">{{ $new->content }}</textarea>
                                </div>
                                <hr>
                                <h3 class="box-title">SEO блок</h3>
                                <div class="form-group">
                                    <label>Заголовок</label>
                                    <input type="text" name="seo_title" class="form-control" value="{{ $new->seo_title }}" placeholder="Enter ...">
                                </div>
                                <div class="form-group">
                                    <label>description</label>
                                    <textarea name="seo_description" class="form-control" rows="2">{{ $new->seo_description }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>keywords</label>
                                    <textarea name="seo_keywords" class="form-control" rows="2">{{ $new->seo_keywords }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="box-body">
                                <a href="{{ route('news.index') }}" type="button" class="btn btn-primary pull-left">Назад</a>
                                <button type="submit" class="btn btn-primary pull-right">Сохранить</button>
                                <div class="clearfix"></div>
                                <hr>
                                <div class="form-group has-success">
                                    <label class="control-label count-mediafiles" for="inputMediafile">Изображение</label>
                                    <input type="text" class="form-control" onclick="MediaModal(this)" id="inputMediafile" value="{{ $new->image }}" name="image" placeholder="url изображение">
                                    <small>Для замены выбериту другое изображение</small>
                                </div>
                                @if ($new->image != null)
                                    <div class="form-group">
                                        <img src="{{ $new->image }}" class="img-responsive" id="preview-post-img">
                                    </div>
                                @else
                                    <div class="form-group">
                                        <img src="" class="img-responsive" id="preview-post-img">
                                    </div>
                                @endif
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
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/plugins/codesnippet/plugin.js') }}"></script>
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/plugins/filetools/plugin.js') }}"></script>
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/plugins/font/plugin.js') }}"></script>
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/plugins/justify/plugin.js') }}"></script>
    <script>
        CKEDITOR.replace( 'content',{extraPlugins: 'codesnippet,filetools,font,justify'});
    </script>
@endsection



