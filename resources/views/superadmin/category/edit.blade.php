@extends('layouts.admin')

@section('content')

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
        <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Категории</a></li>
        <li class="breadcrumb-item"><a href="#">Редактирование</a></li>
        <li class="breadcrumb-item"><a href="#">{{ $category->title }}</a></li>
    </ol>
    <div class="row">
        <div class="col-lg-12">
            <form action="{{ route('categories.update', $category->id) }}" enctype="multipart/form-data" method="post">
                <input type="hidden" name="_method" value="put">
                {{ csrf_field() }}
                <div class="card">
                    <div class="card-header"><i class="fa fa-list-alt"></i> Редактирование категории</div>
                    <div class="card-body">
                        <div class="form-group"><input type="text" class="form-control" name="title" placeholder="Название" value="{{ $category->title }}" required autofocus></div>
                        <div class="form-group"><input type="text" class="form-control" name="url" placeholder="ЧПУ (url)" value="{{ $category->url }}" required></div>
                        <hr>
                        <h5>SEO blog</h5>
                        <hr>
                        <div class="form-group"><input type="text" class="form-control" name="seo_title" placeholder="Title" value="{{ $category->seo_title }}"></div>
                        <div class="form-group">
                            <label for="exampleTextarea">Keywords</label>
                            <textarea class="form-control" name="seo_keywords" rows="2">{{ $category->seo_keywords }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleTextarea">Description</label>
                            <textarea class="form-control" name="seo_description" rows="2">{{ $category->seo_description }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleTextarea">Content</label>
                            <textarea class="form-control textarea" name="content">{{ $category->content }}</textarea>
                        </div>
                    </div>
                    <div class="card-footer small text-muted">
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </div>
                </div>
            </form>
        </div>

    </div>

@endsection

@section('script')
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/plugins/codesnippet/plugin.js') }}"></script>
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/plugins/filetools/plugin.js') }}"></script>
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/plugins/font/plugin.js') }}"></script>
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/plugins/justify/plugin.js') }}"></script>
    <script>
        CKEDITOR.replace( 'content',{extraPlugins: 'codesnippet,filetools,font,justify'});
    </script>
@endsection