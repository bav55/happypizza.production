@extends('layouts.guest')
@section('meta-content')
    <title>Отзывы</title>
@endsection
@section('content')

    <div id="wrapper" class="is-full">
        <div class="container">
            <div class="row">
                @include('view.blocks.left-block')

                <div class="col-md-9 col-sm-8 col-xs-7 no-lp inner-content">
                    <div id="breadcrumbs" class="is-full">
                        <a href="{{ route('index') }}">Главная</a> / <span>Отзывы</span>
                    </div>

                    <div id="page-title" class="is-full">
                        <h1>отзывы</h1>
                    </div>
                    @if (count($reviews) > 0)
                    <div id="review-slider">
                        <div class="swiper-container swiper-container-horizontal">
                            <div class="swiper-wrapper" style="transition-duration: 0ms; transform: translate3d(0px, 0px, 0px);">
                                @foreach($reviews as $review)
                                <div class="swiper-slide swiper-slide-active" style="width: 244.333px; margin-right: 30px;">
                                    <div class="review-item">
                                        <table>
                                            <tbody><tr>
                                                <td><p class="reviewer-name">{{ $review->name }}</p><p class="review-date">{{ \Carbon\Carbon::parse($review->created_at)->format('d.m.Y') }}</p></td>
                                                <td class="r-point"><p class="reviewer-point">оценка: <span class="good-point ">{{ $review->rating }}</span></p></td>
                                            </tr><tr>
                                            </tr></tbody>
                                        </table><p>{{ $review->message }}</p>
                                    </div>
                                </div>
                                @endforeach


                            </div>

                            <div id="review-pagination" class="swiper-pagination swiper-pagination-progress"><span class="swiper-pagination-progressbar" style="transform: translate3d(0px, 0px, 0px) scaleX(1) scaleY(1); transition-duration: 300ms;"></span></div>
                        </div>
                        <div id="next-review" class="swiper-button-next swiper-button-disabled"></div>
                        <div id="prev-review" class="swiper-button-prev swiper-button-disabled"></div>
                    </div>
                    @endif

                    <div id="send-review-block">
                        <div class="row">
                            <div class="col-lg-10 col-xs-12">
                                <div class="row">
                                    <div class="col-md-6 col-xs-12">
                                        <div class="left-review is-full">
                                            <table id="review-table">
                                                <tbody><tr>
                                                    <td>
                                                        <p class="review-us">Оцените нас:</p>
                                                    </td>
                                                    <td>
                                                        <div id="review-stars">
                                                            <span data-id="1" class=""></span>
                                                            <span data-id="2" class=""></span>
                                                            <span data-id="3" class=""></span>
                                                            <span data-id="4" class=""></span>
                                                            <span data-id="5" class=""></span>
                                                        </div>
                                                        <div id="review-point">
                                                            <p>средняя оценка: <span class="review-point">{{ $rating }}</span> <span class="review-count">({{ $count }})</span></p>
                                                        </div>
                                                    </td>
                                                </tr>
                                                </tbody></table>
                                        </div>

                                        <div class="row">
                                            <div class="col-xs-12">&nbsp;</div>
                                        </div>

                                        <div class="form-group" id="review-stars-error">
                                            <p class="error" style="color: #a94442; font-size: 12px;"></p>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xs-12">
                                        <div class="right-review is-full">
                                            <div class="form-group">
                                                <input type="text" class="form-control" name="name" {{ Auth::guest() ? '' : 'value='. Auth::user()->name .'' }} placeholder="Имя *">
                                                <p class="help-block"></p>
                                            </div>

                                            <div class="form-group">
                                                <input type="text" class="form-control masked-phone" {{ Auth::guest() ? '' : 'value='. Auth::user()->phone .'' }} name="phone" placeholder="Телефон *">
                                                <p class="help-block"></p>
                                            </div>

                                            <div class="form-group">
                                                <textarea name="message" class="form-control" placeholder="Сообщение *"></textarea>
                                                <p class="help-block"></p>
                                            </div>

                                            <div class="review-input review-button">
                                                <a href="#" onclick="sendReview(this); return false;" class="btn red-button">ОСТАВИТЬ ОТЗЫВ</a>
                                                <img class="hidden" src="{{ asset('tpl/images/loader.gif') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal modal-happypizza modal-happypizza-white" id="review-modal-success" tabindex="-1" role="dialog">
        <div class="vertical-alignment-helper">
            <div class="modal-dialog modal-sm vertical-align-center">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Спасибо!<br />Ваш отзыв отправлен.</h4>
                    </div>

                    <div class="modal-body">
                        <p style="text-align: center">Ваш отзыв будет опубликован на сайте после прохождения модерации.</p>
                    </div>

                    <div class="modal-footer">&nbsp;</div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('style')
    <link rel="stylesheet" href="{{ asset('/tpl/css/reviews.css') }}">
@endsection

@section('script')
    <script src="{{ asset('tpl/js/reviews.js') }}"></script>
@endsection