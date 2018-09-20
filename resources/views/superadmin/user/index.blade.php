@extends('layouts.admin')

@section('content')

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
        <li class="breadcrumb-item"><a href="{{ route('bonuslog.index') }}">Пользователи</a></li>
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
                                <td><strong>id пользователя</strong></td>
								<td><strong>Имя</strong></td>
								<td><strong>Фамилия</strong></td>
                                <td><strong>E-mail</strong></td>
								<td><strong>Телефон</strong></td>
								<td><strong>бонус</strong></td>
								
                                <td><strong>Дата регистрации</strong></td>
                                
                                <td></td><td></td>
                            </tr>
                            </thead>
                            <tbody>
							
                            @foreach($users as $user)
							
                                <tr>
                                    <td>{{ $user->id }}</td>
									<td>{{ $user->name }}</td>
									<td>{{ $user->surname }}</td>
									<td>{{ $user->email }}</td>
									<td>{{ $user->phone }}</td>
									@if (isset($user->getUserBonus->bonus))
									<td>{{ $user->getUserBonus->bonus }}</td>
									@else 
									<td> 0 </td>
									@endif
                                    <td>{{ \Carbon\Carbon::parse($user->created_at)->format('d.m.Y H:i') }}</td>
                                   
                                    
                                    <td>
                                       <!-- <form action="{{ route('review.edit', $user->id ) }}" method="post">
                                            <input type="hidden" name="_method" value="get">
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-primary btn-sm">Редактировать</button>
                                        </form>-->
                                    </td>
                                    <td>
                                       <!-- <form action="{{ route('review.destroy', $user->id) }}" method="post">
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