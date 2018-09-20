@extends('layouts.admin')

@section('content')

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
        <li class="breadcrumb-item"><a href="{{ route('review.index') }}">Отзывы</a></li>
        <li class="breadcrumb-item"><a href="{{ route('review.edit',$review->id) }}">Редактирование</a></li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <form role="form" action="{{ route('review.update', $review->id) }}" method="post">
                    <input type="hidden" name="_method" value="put">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="box-body pad">
                                <div class="form-group">
                                    <label>Имя</label>
                                    <input type="text" name="name" class="form-control" value="{{ $review->name }}" required="" placeholder="Enter ...">
                                </div>
                                <div class="form-group">
                                    <label>Номер телефона</label>
                                    <input type="text" name="phone" class="form-control" value="{{ $review->phone }}" required="" placeholder="Enter ...">
                                </div>
                                <div class="form-group">
                                    <label>Оценка</label>
                                    <input type="number" name="rating" class="form-control" value="{{ $review->rating }}" required="" placeholder="Enter ...">
                                </div>
                                <div class="form-group">
                                    <label>Сообщение</label>
                                    <textarea class="form-control" name="message" rows="3" required="" placeholder="Enter ...">{{ $review->message }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Порядок сортировки</label>
                                    <input type="number" name="sort" class="form-control" value="{{ $review->sort }}" required="" placeholder="Enter ...">
                                </div>
                                <fieldset class="form-group">
                                    <label>Отображать на сайте?</label>
                                    <div class="row">
                                        <div class="form-check col-3">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="is_show" value="true" {{ $review->is_show==1 ? 'checked' : ''}}> Да</label>
                                        </div>
                                        <div class="form-check col-3">
                                            <label class="form-check-label">
                                                <input type="radio" class="form-check-input" name="is_show" value="false" {{ $review->is_show==0 ? 'checked' : ''}}> Нет</label>
                                        </div>
                                    </div>
                                </fieldset>
                                <hr>
                                <button type="submit" class="btn btn-primary">Сохранить</button>
                                <hr>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection