@extends('layouts.admin')

@section('content')

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
        <li class="breadcrumb-item"><a href="{{ route($url.'.index') }}">{{ $title }}</a></li>
        @php
            if(isset($_GET['page'])){
                echo '<li class="breadcrumb-item"><a href="#">Страница '. $_GET['page'] .'</a></li>';
            }
        @endphp
    </ol>
    <div class="row">
        <div class="col-lg-6">
            <form action="{{ route($url.'.store') }}" method="post">
                <input type="hidden" name="_method" value="post">
                {{ csrf_field() }}
                <div class="card">
                    <div class="card-header"><i class="fa fa-list-alt"></i> Создание {{ $title }}</div>
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" class="form-control" name="title" placeholder="Название" required autofocus>
                        </div>
                        <label>Текс</label>
                        <div class="form-group">
                            <input id="short-text" type="text" class="form-control" name="text" placeholder="Короткий текст" required>
                        </div>
                        <label>Url для перехода</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="url" placeholder="/url" required>
                        </div>
                       <label>Надпись на кнопке</label>
                        <div class="form-group">
                            <input type="text" class="form-control" name="name_button" placeholder="" required>
                        </div>
                        
                        <div class="form-group has-success">
                            <label class="control-label count-mediafiles" for="inputMediafile">Изображение</label>
                            <input type="text" class="form-control" onclick="MediaModal(this)" id="inputMediafile" value="" name="image" placeholder="url изображение">
                        </div>
                        <div class="form-group">
                            <img src="" class="img-responsive" id="preview-post-img">
                        </div>
                    </div>
                    <div class="card-footer small text-muted">
                        <button type="submit" class="btn btn-primary">Создать</button>
                    </div>
                </div>
            </form>
        </div>

        @include(App\User::UserRoleName(Auth::user()->id).'.kitchen.kitchens')

    </div>

    @include('superadmin.media-modal')

@endsection

@section('script')
    <script src="{{ asset('assets/js/option-checkbox.js') }}"></script>
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/plugins/codesnippet/plugin.js') }}"></script>
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/plugins/filetools/plugin.js') }}"></script>
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/plugins/font/plugin.js') }}"></script>
    <script src="{{ asset('vendor/unisharp/laravel-ckeditor/plugins/justify/plugin.js') }}"></script>
    <script src="{{ asset('assets/js/media-modal.js') }}"></script>
    
    <script>
        CKEDITOR.replace( 'short-text',{extraPlugins: 'codesnippet,filetools,font,justify'});
    </script>
@endsection

