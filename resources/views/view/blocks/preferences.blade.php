<div class="dropdown filter-preferences select-element pull-right">
    <button id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        по предпочтениям
        <span class="caret"></span>
    </button>

    <ul class="dropdown-menu" aria-labelledby="dLabel">
        <li><a href="#" onclick="FilteringPreference(this); return false;" value="0" data-label="по предпочтениям">показать все</a></li>
        @foreach($preferences as $preference)
            <li><a href="#" onclick="FilteringPreference(this); return false;" value="{{ $preference->id }}">{{ $preference->title }}</a></li>
        @endforeach
    </ul>
</div>