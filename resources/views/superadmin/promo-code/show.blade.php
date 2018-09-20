@extends('layouts.admin')

@section('content')

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
        <li class="breadcrumb-item"><a href="{{ route('p-cods.index') }}">Промо код</a></li>
        <li class="breadcrumb-item"><a href="#">Просмотр</a></li>
        <li class="breadcrumb-item"><a href="{{ route('p-cods.show',$code_one->id) }}">{{ $code_one->title }}</a></li>
    </ol>
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header"><i class="fa fa-barcode"></i> {{ $code_one->title }}</div>
                <div class="card-body">
                    <div class="form-group">
                        <label>Промо код</label>
                        <input type="text" readonly class="form-control" name="title" placeholder="Промо код" required autofocus value="{{ $code_one->title }}">
                    </div>

                    <div class="form-group">
                        <label>Лимит</label>
                        <input type="text" readonly class="form-control" name="limit" placeholder="Лимит" value="{{ $code_one->limit }}">
                    </div>

                    <div class="form-group">
                        <label>Использовано</label>
                        <input type="text" readonly class="form-control" name="limit" placeholder="Лимит" value="{{ $code_one->apply }}">
                    </div>

                    <div class="form-group">
                        <label>Сумма</label>
                        <input type="text" readonly class="form-control" name="sum" placeholder="Сумма" value="{{ $code_one->sum }}">
                    </div>

                    <fieldset class="form-group">
                        <div class="row">
                            <div class="col-3"> Скидка в </div>
                            <div class="col-2">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" readonly {{ $code_one->is_sum == 1 ? 'checked' : '' }} name="sales" value="is_sum"> ТГ
                                    </label>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" readonly {{ $code_one->is_percent == 1 ? 'checked' : '' }} name="sales" value="is_percent"> %
                                    </label>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <div class="form-group">
                        <label>Комментарий</label>
                        <input type="text" class="form-control" name="comment" readonly placeholder="Комментарий" value="{{ $code_one->comment }}">
                    </div>
                </div>
            </div>
        </div>

        @include(App\User::UserRoleName(Auth::user()->id).'.promo-code.codes')

    </div>

@endsection