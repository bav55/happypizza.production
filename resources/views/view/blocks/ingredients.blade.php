<div class="dropdown filter-ingredients select-element pull-right" style="margin-right: 0">
    <button id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        по ингредиентам
        <span class="caret"></span>
    </button>

    <ul class="dropdown-menu" aria-labelledby="dLabel">
        <li><a href="#" onclick="FilteringIngredient(this); return false;" value="0" data-label="по ингредиентам">показать все</a></li>
        @foreach($ingredients as $ingredient)
            <li><a href="#" onclick="FilteringIngredient(this); return false;" value="{{ $ingredient->id }}">{{ $ingredient->title }}</a></li>
        @endforeach
    </ul>
</div>