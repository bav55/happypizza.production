@php 
$sql_q = \Illuminate\Support\Facades\DB::table('user_bonuses')->where('user_id',Auth::user()->id)->get();
if (!empty($sql_q[0])) {
    $bonus = $sql_q[0]->bonus; 
}
else { $bonus = 0;}
@endphp
<div class="col-md-3 col-sm-4 col-xs-5 inner-menu-holder hidden-xs">
    <div id="inner-menu" class="is-full account-menu" style="top: 0px;">
        <ul style="border-top: none;">
            <li><a href="{{ route('orderHistory') }}">История заказов</a></li>
            <li><a href="{{ route('createdPizza') }}">Созданные пиццы</a></li>
            @if ($bonus && $bonus != 0)
                <li><a href="{{ route('account') }}">Мои данные</a></li>
                <li style="border-bottom: none"><a href="#" onclick="return false;">Бонусов: <b>{{ $bonus }}</b>ТГ</a></li>
            @else
                <li style="border-bottom: none"><a href="{{ route('account') }}">Мои данные</a></li>
            @endif
        </ul>
    </div>
</div>