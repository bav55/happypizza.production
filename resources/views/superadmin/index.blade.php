@extends('layouts.admin')


@section('content')

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Главная</a></li>
    </ol>
    <div class="row">
        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-success o-hidden h-100">
                <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fa fa-fw fa-shopping-cart"></i>
                    </div>
                    <div class="mr-5">Новых заказов {{ count($orders) }}</div>
                </div>
                <a href="{{ route('selling.index') }}" class="card-footer text-white clearfix small z-1">
                    <span class="float-left">Смотреть</span>
                    <span class="float-right">
                  <i class="fa fa-angle-right"></i>
                </span>
                </a>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-primary o-hidden h-100">
                <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fa fa-fw fa-comments"></i>
                    </div>
                    <div class="mr-5">Новых отзывов {{ count($reviews) }}</div>
                </div>
                <a href="{{ route('review.index') }}" class="card-footer text-white clearfix small z-1">
                    <span class="float-left">Смотреть</span>
                    <span class="float-right">
                  <i class="fa fa-angle-right"></i>
                </span>
                </a>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-warning o-hidden h-100">
                <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fa fa-fw fa-list"></i>
                    </div>
                    <div class="mr-5">
                        Начисленые бонусы
                    </div>
                </div>
               <a href="{{ route('bonuslog.index') }}" class="card-footer text-white clearfix small z-1">
                    <span class="float-left">Смотреть</span>
                    <span class="float-right">
                  <i class="fa fa-angle-right"></i>
                </span>
                </a>
            </div>
        </div>

        <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-danger o-hidden h-100">
                <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fa fa-fw fa-support"></i>
                    </div>
                    <div class="mr-5">
                        Клиенты
                    </div>
                </div>
                <a href="{{ route('user.index') }}" class="card-footer text-white clearfix small z-1">
                    <span class="float-left">Смотреть</span>
                    <span class="float-right">
                  <i class="fa fa-angle-right"></i>
                </span>
                </a>
            </div>
        </div>
    </div>



@endsection