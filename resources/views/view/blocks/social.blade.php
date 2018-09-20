@foreach(json_decode(\App\Models\Setting::all()->find(1)->social) as $value)
    <a href="{!! $value->url !!}" target="_blank" rel="nofollow">{!! $value->icon !!}</a>
@endforeach