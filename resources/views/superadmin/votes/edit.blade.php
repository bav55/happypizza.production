@extends('layouts.admin')

@section('content')

    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Главная</a></li>
        <li class="breadcrumb-item"><a href="{{ route('votes.index') }}">Опросы</a></li>
        <li class="breadcrumb-item"><a href="{{ route('votes.edit',$vote->id) }}">Редактирование</a></li>
    </ol>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-warning">
                <form role="form" action="{{ route('votes.update',$vote->id) }}" method="post">
                    <input type="hidden" name="_method" value="put">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Заголовок</label>
                                <input type="text" name="title" class="form-control" required placeholder="Enter ..." value="{{ $vote->title }}">
                            </div>
                            <fieldset class="form-group">
                                <label>Отображать на сайте?</label>
                                <div class="row">
                                    <div class="form-check col-3">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="is_show" value="true" {{ $vote->is_show == true ? 'checked' : '' }}> Да</label>
                                    </div>
                                    <div class="form-check col-3">
                                        <label class="form-check-label">
                                            <input type="radio" class="form-check-input" name="is_show" value="false" {{ $vote->is_show != true ? 'checked' : '' }}> Нет</label>
                                    </div>
                                </div>
                            </fieldset>
                            <div class="form-group">
                                <label>Сортировка</label>
                                <input type="number" name="sort" value="{{ $vote->sort }}" class="form-control" placeholder="Enter ...">
                            </div>
                            <div class="form-group has-success">
                                <label class="control-label count-mediafiles" for="inputMediafile">Изображение</label>
                                <input type="text" class="form-control" onclick="MediaModal(this)" id="inputMediafile" name="image" placeholder="url изображение" value="{{ $vote->image }}">
                                <small>Для замены выбериту другое изображение</small>
                            </div>
                            <div class="form-group">
                                <img src="{{ $vote->image }}" class="img-responsive" id="preview-post-img">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Вопросы</label>
                                <input type="button" class="btn btn-primary form-control" data-count="1" onclick="addVoteForm(this)" value="Добавить">
                            </div>
                            <div id="form-input-votes">
                                @if($vote->getVoteList->toArray())
                                    @foreach($vote->getVoteList as $list)
                                        <div class="row">
                                            <div class="form-group col-10">
                                                <input type="text" class="form-control" name="form[]" value="{{ $list->title }}">
                                            </div>
                                            <div class="form-group col-1"><a href="#" class="btn btn-danger" onclick="removeVacancyForm(this); return false;"><i class="fa fa-close"></i></a></div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="clearfix"></div>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                    <hr>
                </form>
            </div>
        </div>
    </div>

    @include('superadmin.media-modal')

@endsection

@section('script')
    <script src="{{ asset('assets/js/media-modal.js') }}"></script>
@endsection