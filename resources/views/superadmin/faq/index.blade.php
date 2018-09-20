@extends('layouts.admin')

@section('content')

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
        <li class="breadcrumb-item"><a href="{{ route('faqs.index') }}">ЧаВо</a></li>
        @php
            if(isset($_GET['page'])){
                echo '<li class="breadcrumb-item"><a href="#">Страница '. $_GET['page'] .'</a></li>';
            }
        @endphp
    </ol>
    <div class="row">
        <div class="col-lg-6">
            <form action="{{ route('faqs.store') }}" enctype="multipart/form-data" method="post">
                <input type="hidden" name="_method" value="post">
                {{ csrf_field() }}
                <div class="card">
                    <div class="card-header"><i class="fa fa-list-alt"></i> Создание ЧаВо</div>
                    <div class="card-body">
                        <div class="form-group">
                            <input type="text" class="form-control" name="question" placeholder="Вопрос" required autofocus>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control"placeholder="Ответ" required name="answer" rows="5"></textarea>
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="checkbox" name="is_active" class="form-check-input"> Показать на сайте
                            </label>
                        </div>
                    </div>
                    <div class="card-footer small text-muted">
                        <button type="submit" class="btn btn-primary">Создать</button>
                    </div>
                </div>
            </form>
        </div>

        @include(App\User::UserRoleName(Auth::user()->id).'.faq.faqs')

    </div>

@endsection