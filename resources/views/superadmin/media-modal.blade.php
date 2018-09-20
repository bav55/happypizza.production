<div id="modal-dialog" class="modalMedia-dialog" title="Выберите изображение">
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
                        <input type="hidden" name="modal" value="true">
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
                <div class="box-body flexbox list-media">
                    @foreach($medias as $media)
                        <div class="imgList">
                            <!-- <input type="checkbox" name="image[]" value="{{$media->id}}" id="myCheckbox-{{$media->id}}" /> -->
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
</div>


<div id="dialog-textarea" class="modalMedia-textarea" title="Выберите изображение">
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Загрузка медиафайлов</h3>
            </div>
            <div class="box-body">
                <form id="imageform-textarea" method="post" enctype="multipart/form-data" action='{{ route('media.create') }}'>
                    <input type="hidden" name="_method" value="get">
                    {{ csrf_field() }}
                    <div id='imageloadstatus-textarea' style='display:none'><img src="{{ asset('assets/img/loader.gif') }}" alt="Загрузка ..."/></div>
                    <div id='imageloadbutton-textarea'>
                        <input type="file" name="photos[]" id="photoimg-textarea" multiple="true" />
                        <input type="hidden" name="modal" value="true">
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
                <div class="box-body flexbox list-media">
                    @foreach($medias as $media)
                        <div class="imgList">
                        <!-- <input type="checkbox" name="image[]" value="{{$media->id}}" id="myCheckbox-{{$media->id}}" /> -->
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
</div>