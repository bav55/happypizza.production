@extends('layouts.admin')

@section('content')

    @php $session_id='1'; @endphp

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
        <li class="breadcrumb-item"><a href="{{ route('setting') }}">Настройки</a></li>
    </ol>

    <form role="form" action="{{route('settingUpdate', '1' )}}" method="post">
        <input type="hidden" name="_method" value="put">
        {{ csrf_field() }}
        <div class="col-md-12 slider-lists">
            <div class="row">
                <div class="form-group col-md-11">
                    <input type="text" class="form-control" value="Слайдер на главной" disabled>
                </div>
                <div class="form-group col-md-1 pull-right">
                    <a href="#" onclick="addSliderInput(); return false;" class="btn btn-primary"><i class="fa fa-plus"></i> </a>
                </div>
            </div>
            @php $sl_cont = 1; @endphp
            @if (count($sliders) > 0) @foreach($sliders as $slider)
                <div class="row">
                    <div class="form-group col-md-5">
                        <input type="text" class="form-control images-modal" onclick="MediaModal(this)" value="{{ $slider->url }}" name="slider[{{ $sl_cont }}][url]" placeholder="Изображение">
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" name="slider[{{ $sl_cont }}][title]" value="{{ $slider->title }}" placeholder="Ссылка">
                    </div>
                    <div class="form-group col-md-1">
                        <a href="#" onclick="removeSliderInput(this); return false;" class="btn btn-danger"><i class="fa fa-close"></i> </a>
                    </div>
                </div>
                @php $sl_cont++; @endphp
            @endforeach @endif
        </div>
        <hr>
        <div class="col-md-12 social-lists">
            <div class="row">
                <div class="form-group col-md-11">
                    <input type="text" class="form-control" value="Соцсети" disabled>
                </div>
                <div class="form-group col-md-1 pull-right">
                    <a href="#" onclick="addSocialInput(); return false;" class="btn btn-primary"><i class="fa fa-plus"></i> </a>
                </div>
            </div>
            @php $soc_cont = 1; @endphp
            @if (count($socials) > 0) @foreach($socials as $social)
                <div class="row">
                    <div class="form-group col-md-5">
                        <input type="text" class="form-control" value="{{ $social->icon }}" name="social[{{ $soc_cont }}][icon]" placeholder="Иконка">
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" name="social[{{ $soc_cont }}][url]" value="{{ $social->url }}" placeholder="Ссылка">
                    </div>
                    <div class="form-group col-md-1">
                        <a href="#" onclick="removeSliderInput(this); return false;" class="btn btn-danger"><i class="fa fa-close"></i> </a>
                    </div>
                </div>
                @php $soc_cont++; @endphp
            @endforeach @endif
        </div>
        <hr>
        <div class="col-md-12 phone-lists">
            <div class="row">
                <div class="form-group col-md-11">
                    <input type="text" class="form-control" value="Номера телефонов" disabled>
                </div>
                <div class="form-group col-md-1 pull-right">
                    <a href="#" onclick="addPhoneInput(); return false;" class="btn btn-primary"><i class="fa fa-plus"></i> </a>
                </div>
            </div>
            @php $phone_cont = 1; @endphp
            @if (count($phones) > 0) @foreach($phones as $phone)
                <div class="row">
                    <div class="form-group col-md-5">
                        <input type="text" class="form-control" value="{{ $phone->number }}" name="phone[{{ $phone_cont }}][number]" placeholder="Номер телефона">
                    </div>
                    <div class="form-group col-md-6">
                        <input type="text" class="form-control" value="{{ $phone->visual }}" name="phone[{{ $phone_cont }}][visual]" placeholder="Номер телефона визуально">
                    </div>
                    <div class="form-group col-md-1">
                        <a href="#" onclick="removeSliderInput(this); return false;" class="btn btn-danger"><i class="fa fa-close"></i> </a>
                    </div>
                </div>
                @php $phone_cont++; @endphp
            @endforeach @endif
        </div>

        <div class="col-md-12 phone-lists">
            <div class="row">
                <div class="form-group col-md-12">
                    <input type="text" class="form-control" value="График работы" disabled>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6">
                    <textarea name="work[basic]" placeholder="График базовый" class="form-control">{!! $work->basic !!}</textarea>
                </div>
                <div class="form-group col-md-6">
                    <textarea name="work[contacts]" placeholder="Для страницы контакта" class="form-control">{!! $work->contacts !!}</textarea>
                </div>
            </div>
        </div>
        <hr>
        <div class="col-md-12">
            <div class="row">
                <div class="form-group col-md-6">
                    <label>E-mail</label>
                    <input type="text" class="form-control" value="{{ $setting->email }}" name="email" placeholder="E-mail">
                </div>
                <div class="form-group col-md-6">
                    <label>Бонус при заказе в %</label>
                    <input type="number" class="form-control" value="{{ $setting->bonus_percent }}" name="bonus_percent" placeholder="Бонус">
                </div>
            </div>
        </div>
        <hr>
        <div class="col-md-12 phone-lists">
            <div class="row">
                <div class="form-group col-md-12">
                    <input type="text" class="form-control" value="Seo Setting" disabled>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12">
                    <label>Заголовок</label>
                    <input name="seo[title]" placeholder="Заголовок" class="form-control" value="{{ isset($seo->title) ? $seo->title : '' }}">
                </div>
                <div class="form-group col-md-6">
                    <label>Description</label>
                    <textarea name="seo[description]" placeholder="Description" class="form-control">{{ isset($seo->description) ? $seo->description : '' }}</textarea>
                </div>
                <div class="form-group col-md-6">
                    <label>Keywords</label>
                    <textarea name="seo[keywords]" placeholder="Keywords" class="form-control">{{ isset($seo->keywords) ? $seo->keywords : '' }}</textarea>
                </div>
                <div class="form-group col-md-12">
                    <label>Заголовок текста</label>
                    <input name="seo[content_title]" placeholder="Заголовок" class="form-control" value="{{ isset($seo->content_title) ? $seo->content_title : '' }}">
                </div>
                <div class="form-group col-md-12">
                    <label>Текст на главной</label>
                    <textarea name="seo[content]" id="content" placeholder="Текст на главной" class="form-control">{{ isset($seo->content) ? $seo->content : '' }}</textarea>
                </div>
            </div>
        </div>
        <hr>
        <div class="col-md-12">
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>  Сохранить</button>
        </div>
        <hr>

    </form>

    @include('superadmin.media-modal')

@endsection



@section('script')
    <script src="{{ asset('assets/js/media-modal.js') }}"></script>
    <script src="{{ asset('assets/js/setting.js') }}"></script>

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