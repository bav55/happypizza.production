@extends('layouts.admin')

@section('content')

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
        <li class="breadcrumb-item"><a href="{{ route('bonuslog.index') }}">Начисленные Бонусы</a></li>
        @php
            if(isset($_GET['page'])){
                echo '<li class="breadcrumb-item"><a href="#">Страница '. $_GET['page'] .'</a></li>';
            }
        @endphp
    </ol>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <a href="{{ route('bonuslog.index') }}" style="color: #000000;" class="col-10"><i class="fa fa-star-half-o"></i> Все отзывы</a>
                        <!--<a href="{{ route('review.create') }}" class="col-2 btn btn-primary btn-sm">Добавить</a>-->
                    </div>
                </div>
                @if (count($user_order) > 0)
                    <div>
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <td><strong>id заказа</strong></td>
								<td><strong>Номер заказа</strong></td>
                                <td><strong>Дата</strong></td>
                                
                                <td><strong>бонус</strong></td>
                                <td></td><td></td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $review)
							<?php $bonus_back = (int)$review->order_sum/100 *(int)$bonus_percent; ?>
                                <tr>
                                    <td>{{ $review->id }}</td>
									<td>{{ $review->order_id }}</td>
                                    <td>{{ \Carbon\Carbon::parse($review->created_at)->format('d.m.Y H:i') }}</td>
                                   
                                    @if (isset($review->getBonusLog->bonus))
									<td>{{ $review->getBonusLog->bonus }}</td>
									@else 
									<td> 0 </td>
									@endif
                                    <td>
                                       <!-- <form action="{{ route('review.edit', $review->id ) }}" method="post">
                                            <input type="hidden" name="_method" value="get">
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-primary btn-sm">Редактировать</button>
                                        </form>-->
                                    </td>
                                    <td>
                                       <!-- <form action="{{ route('review.destroy', $review->id) }}" method="post">
                                            <input type="hidden" name="_method" value="delete">
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-danger btn-sm">Удалить</button>
                                        </form>-->
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                <div class="card-footer small text-muted">
                    <div class="dataTables_paginate paging_simple_numbers" id="dataTable_paginate">
                        {{ $orders->render() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection