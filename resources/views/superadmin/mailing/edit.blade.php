@extends('layouts.admin')

@section('content')



    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
        <li class="breadcrumb-item"><a href="{{ route('mailing.index') }}">Рассылка</a></li>
        <li class="breadcrumb-item"><a href="{{ route('mailing.edit',$mail->id) }}">Редактирование</a></li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <form role="form" action="{{ route('mailing.update', $mail->id) }}" method="post">
                    <input type="hidden" name="_method" value="put">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box-body pad">
                                <div class="form-group">
                                    <label>Получатели *</label>
                                    <select class="form-control" name="mail_to" required>
                                        <option value="all" {{ $mail->mail_to == "all" ? 'selected' : '' }}>Все</option>
                                        <option value="App\Models\Subscription" {{ $mail->mail_to == "App\Models\Subscription" ? 'selected' : '' }}>Подписчики</option>
                                        <option value="App\User" {{ $mail->mail_to == "App\User" ? 'selected' : '' }}>Зарегистрированные пользователи</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Заголовок письма</label>
                                    <input type="text" name="mail_title" class="form-control" required="" placeholder="Enter ..." value="{{ $mail->mail_title }}">
                                </div>
                                <div class="form-group">
                                    <label>Текст *</label>
                                    <textarea class="form-control" id="content" name="mail_content">{{ $mail->mail_content }}</textarea>
                                </div>
                                <hr>
                                <a href="{{ route('mailing.index') }}" type="button" class="btn btn-danger"><i class="fa fa-ban"></i> Отмена</a>
                                <button type="submit" class="btn btn-primary pull-right">Переотправить и сохранить</button>
                                <hr>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
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