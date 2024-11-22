<div class="strip">
    <div class="strip__info">
        <div class="strip__game">
            <div class="strip__icon">
                <img src="{{ $iconUrl }}" alt="icon">
            </div>
            <div class="strip__name">
                {{ $game }}
            </div>
        </div>
        <div class="strip__market">
            <a href="{{ route('market', ['game' => $game]) }}">Посмотреть все скины ></a>
        </div>
    </div>
    <div class="strip__cards">
        @foreach ($listings as $listing)
            @include('includes.card', ['props' => $listing])
        @endforeach
    </div>
</div>
