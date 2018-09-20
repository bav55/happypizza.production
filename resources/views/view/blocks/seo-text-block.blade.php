@section('seo-content')
    <div id="about" class="is-full">
        <div class="top-shadow-holder is-abs"><div></div></div>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 text-center"><h3>{{ $seo_block_title }}</h3></div>
                <div class="col-xs-12">
                    <div class="is-full">
                        <div class="is-full seo_text_block">{!! $seo_block_content !!}</div>
                        <div id="read-more-holder" class="is-full text-center">
                            <p class="read-more"><a onclick="readMore(this)">Читать далее <i class="fa fa-angle-down"></i></a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="gray-curve"></div>
    </div>
@endsection