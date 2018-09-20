@php $phocount=1;
$phones = json_decode(\App\Models\Setting::all()->find(1)->phone);
@endphp
<div class="phones-holder">
    <div class="main-phone">
        @foreach($phones as $phone)
            @if ($phocount == 1)
                <a href="tel:{{ $phone->number }}">{!! $phone->visual !!}</a>
            @endif
            @php $phocount++; @endphp
        @endforeach
        <!--<i class="phones-handler"></i>-->
    </div>
    <ul class="phones-list">
        @foreach($phones as $phone)
            <li><a href="tel:{{ $phone->number }}">{!! $phone->visual !!}</a></li>
        @endforeach
    </ul>
</div>