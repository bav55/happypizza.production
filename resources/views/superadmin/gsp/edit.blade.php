@extends('layouts.admin')



@section('content')

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
        <li class="breadcrumb-item"><a href="{{ route('frontpad.index') }}">Общий список</a></li>
        <li class="breadcrumb-item"><a href="#">Редактирование</a></li>
        <li class="breadcrumb-item"><a href="{{ route('frontpad.edit', $gsp->id) }}">{{ $gsp->id }}</a></li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">

                <form role="form" action="{{route('frontpad.update',$gsp->id)}}" method="post">
                    <input type="hidden" name="_method" value="put">
                    {{ csrf_field() }}
                    <div class="box-header with-border row">
                        <div class="col-md-9"><h3 class="box-title">Редактирорвание {{ $gsp->id }}</h3></div>
                        <div class="col-md-3">
                            <a href="{{ route('frontpad.index') }}" type="button" class="btn btn-primary pull-left">Назад</a>
                            <button type="submit" class="btn btn-primary pull-right">Сохранить</button>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-9">
                            <div class="box-body pad">
                                <div class="form-group">
                                    <label>Артикул FrontPad</label>
                                    <input type="text" name="frontpad_article" class="form-control" required placeholder="Frontpad article..." value="{{ $gsp->frontpad_article }}">
                                </div>
                                <div class="form-group">
                                    <label>Название FrontPad</label>
                                    <input type="text" name="frontpad_title" class="form-control"  placeholder="Frontpad title" value="{{ $gsp->frontpad_title }}">
                                </div>
                                <div class="form-group">
                                    <label>Название товара (сайт, справочно): <strong><i>{{ $gsp->getGoodName($gsp->good) }}</i></strong></label>
                                    <input type="hidden" name="good_id" class="form-control" value="{{ $gsp->good_id }}">
                                </div>
                                <div class="form-group">
                                    <label>Название порции (сайт, справочно): <strong><i>{{ $gsp->getPortionName($gsp->portion) }}</i></strong></label>
                                    <input type="hidden" name="portion_id" class="form-control" value="{{ $gsp->portion_id }}">
                                </div>
                                <div class="form-group">
                                    <label>Стоимость порции (сайт, справочно): <strong><i>{{ $gsp->portion_price }}</i></strong></label>
                                    <input type="hidden" name="portion_price" class="form-control" value="{{ $gsp->portion_price }}">
                                    <input type="hidden" name="id" class="form-control" value="{{ $gsp->id }}">
                                </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>

@endsection

