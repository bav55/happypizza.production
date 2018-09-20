@extends('layouts.admin')

@section('content')

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
        <li class="breadcrumb-item"><a href="{{ route('faqs.index') }}">ЧаВо</a></li>
        <li class="breadcrumb-item"><a href="#">Редактирование</a></li>
        <li class="breadcrumb-item"><a href="{{ route('faqs.edit',$faq_o->id) }}">{{ $faq_o->question }}</a></li>
    </ol>
    <div class="row">
        <div class="col-lg-6">
            <form action="{{ route('faqs.update',$faq_o->id) }}" method="post">
                <input type="hidden" name="_method" value="put">
                {{ csrf_field() }}
                <div class="card">
                    <div class="card-header"><i class="fa fa-list-alt"></i> Редактирование ЧаВо</div>
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" class="form-control" name="question" placeholder="Вопрос" required autofocus value="{{ $faq_o->question }}">
                        </div>
                        <div class="form-group">
                            <textarea class="form-control"placeholder="Ответ" required name="answer" rows="5">{{ $faq_o->answer }}</textarea>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="checkbox" {{ $faq_o->is_active == 1 ? 'checked' : '' }} name="is_active" class="form-check-input"> Показать на сайте
                            </label>
                        </div>
                    </div>
                    <div class="card-footer small text-muted">
                        <button type="submit" class="btn btn-primary">Сохранить</button>
                    </div>
                </div>
            </form>
        </div>

        @include(App\User::UserRoleName(Auth::user()->id).'.faq.faqs')

    </div>

@endsection