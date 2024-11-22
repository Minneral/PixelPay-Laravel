<div class="list">
    @if (count($listings))
        @if ($search)
            @foreach ($listings as $item)
                @if (str_contains(mb_strtolower($item['item']), mb_strtolower($search)))
                    @include('includes.card', ['props' => $item])
                @endif
            @endforeach
        @else
            @foreach ($listings as $item)
                @include('includes.card', ['props' => $item])
            @endforeach
        @endif
    @else
        <h1>Нет результатов</h1>
    @endif
</div>
