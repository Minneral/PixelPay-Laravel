<div class="card">
    <div class="card__inner">
        <div class="card__img">
            <img src="{{ $props['url'] }}" alt="icon">
        </div>

        <div class="card__name">
            {{ $props['item'] }}
        </div>

        <div class="card__price">
            {{ $props['price'] }} <span>BYN</span>
        </div>

        @php
            $inCart = false;
            if (session()->has('cart')) {
                $inCart = collect(session('cart'))->contains(function ($item) use ($props) {
                    return $item->id === $props['id'];
                });
            }
        @endphp

        @if ($inCart)
            <form method="post" action="{{ route('removeFromCart') }}">
                @csrf
                <input type="hidden" name="id" value="{{ $props['id'] }}">
                <button type="submit" class="btn-delete">Удалить из корзины</button>
            </form>
        @else
            <form method="post" action="{{ route('addToCart') }}">
                @csrf
                <input type="hidden" name="id" value="{{ $props['id'] }}">
                <button type="submit" class="btn-add">В корзину</button>
            </form>
        @endif
    </div>
</div>
