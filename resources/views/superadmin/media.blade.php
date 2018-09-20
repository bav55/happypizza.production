@extends('layouts.admin')

@section('content')

    @php $session_id='1'; @endphp

    <section class="content">

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Загрузка медиафайлов</h3>
            </div>
            <div class="box-body">
                <form id="imageform" method="post" enctype="multipart/form-data" action='{{ route('media.create') }}'>
                    <input type="hidden" name="_method" value="get">
                    {{ csrf_field() }}
                    <div id='imageloadstatus' style='display:none'><img src="{{ asset('assets/img/loader.gif') }}" alt="Загрузка ..."/></div>
                    <div id='imageloadbutton'>
                        <input type="file" name="photos[]" id="photoimg" multiple="true" />
                    </div>
                </form>
            </div>
        </div>

    </section>
    <hr>
    <section class="content">
        <div class="box box-primary">
            <form action="{{ route('media-delete') }}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="get">
                <div class="box-header with-border">
                    <div class="col-lg-3" style="float: left;"><h3 class="box-title">Загруженные</h3></div>
                    <div class="col-lg-2" style="float: right;"><button class="btn btn-block btn-danger btn-flat btn-xs">Удалить</button></div>
                </div>
                <div class="clearfix"></div>
                <hr>
                <div class="box-body flexbox list-media">
                    @foreach($medias as $media)
                        <div class="imgList">
                            <input type="checkbox" name="image[]" value="{{$media->id}}" id="myCheckbox-{{$media->id}}" />
                            <label for="myCheckbox-{{$media->id}}">
                                <img src="/{{ $media->url }}"/>
                                <p class="text-center">{{$media->name}}</p>
                            </label>
                        </div>
                    @endforeach
                </div>
            </form>
        </div>
    </section>


@endsection