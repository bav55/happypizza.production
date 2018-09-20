@extends('layouts.guest')

@section('meta-content')
    <title>404 - error</title>
@endsection

@section('content')
   <div class="error-container">
		<!-- <img src="img/right-top-pizza.png" alt="pizza" class="right-top"> -->
		<img src="tpl/images/404/top-left.png" alt="leftpizza" class="top-left">
		<img src="tpl/images/404/right-top.png" alt="rightpizza" class="right-top">
		<img src="tpl/images/404/bottom-img.png" alt="bottom" class="bottom-img">
		<img src="tpl/images/404/bottom-left.png" alt="pizza" class="bottom-left">
		<div class="error-message">
			<img src="tpl/images/404/404pict.png" alt="404">
			<h2>страница не найдена</h2>
			<div class="button-main">
				<button>на главную</button>
			</div>
		</div>
	</div>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('tpl/css/404.css') }}">
@endsection


@section('script')
    <script src="{{ asset('tpl/js/jquery-ui.min.js') }}"></script>
    <script>$( document ).ready(function() {
    $('#zone').remove();
    $('#footer-categories').remove();
    $('#footer-info').remove();
    $('footer').remove();
});</script>
@endsection

