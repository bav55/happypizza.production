@extends('layouts.admin')

@section('content')

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
    </ol>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <a href="{{ route('frontpad.index') }}" style="color: #000000;" class="col-10"><i class="fa fa-archive"></i> Общий список</a>
                        <a href="{{ route('frontpad.index') }}/sync" class="col-2 btn btn-primary btn-sm">Синхронизация</a>
                    </div>
                </div>
                @if (count($gsp) > 0)
                    <div>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <td><strong>id</strong></td>
                                <td><strong>Название<br>Сайт</strong></td>
                                <td><strong>Название<br>порции</strong></td>
                                <td><strong>Стоимость<br>порции</strong></td>
                                <td><strong>Артикул<br>FrontPad</strong></td>
                                <td><strong>Название<br>FrontPad</strong></td>
                                <td></td><td></td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($gsp as $gsp_item)
                                <tr>
                                    <td>{{ $gsp_item->id }}</td>
                                    <td>{{ $gsp_item->getGoodName($gsp_item->good) }}</td>
                                    <td>{{ $gsp_item->getPortionName($gsp_item->portion) }}</td>

                                    <td>{{ $gsp_item->portion_price }}</td>
                                    <td>{{ $gsp_item->frontpad_article }}</td>
                                    <td>{{ $gsp_item->frontpad_title }}</td>
                                    <td>
                                        <form action="{{ route('frontpad.edit', $gsp_item->id ) }}" method="post">
                                            <input type="hidden" name="_method" value="get">
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-primary btn-sm">Редактировать</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                <div class="card-footer small text-muted">
                    <div class="dataTables_paginate paging_simple_numbers" id="dataTable_paginate">
                        {{ $gsp->render() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection