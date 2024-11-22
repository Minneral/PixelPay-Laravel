@extends('layouts.default')

@section('styles')
    @vite(['resources/scss/cart.scss'])
@endsection

@section('content')
    <main class="cart">
        <div class="cart__container">
            <div class="cart__inner">
                <div class="cart__info">
                    @if (count($cart) === 0)
                        <p class='cart__empty'>Здесь пока ничего нет</p>
                    @else
                        @foreach ($cartGames as $currentGame)
                            <div class="cart__game">
                                <div class="cart__game-header">
                                    <div class="cart__game-name">
                                        <img src="{{ Vite::asset('/resources/icons/cs2.png') }}" alt="icon" />
                                        <p>{{ $currentGame }}</p>
                                    </div>

                                    <div class="cart__game-amount">
                                        {{ count(
                                            array_filter($cart, function ($item) use ($currentGame) {
                                                return $item->game === $currentGame;
                                            }),
                                        ) }}
                                        предмета
                                    </div>
                                </div>

                                <div class="cart__game-body">
                                    @foreach ($cart as $currentItem)
                                        @if ($currentItem->game === $currentGame)
                                            <div class="cart__game-item">
                                                <div class="cart__game-item-left">
                                                    <div class="cart__game-item-img">
                                                        <img src="{{ $currentItem->url }}" alt="icon" />
                                                    </div>

                                                    <div class="cart__game-item-info">
                                                        <p>{{ $currentItem->item }}</p>
                                                    </div>
                                                </div>

                                                <div class="cart__game-item-right">
                                                    <div class="cart__game-item-price">
                                                        {{ $currentItem->price }} <span>BYN</span>
                                                    </div>

                                                    <form method="POST" action="{{ route('removeFromCart') }}"
                                                        class="cart__game-item-delete">
                                                        @csrf
                                                        <img src="{{ Vite::asset('/resources/icons/trash.png') }}"
                                                            alt="junk" />
                                                        <input type="hidden" name="id" value="{{ $currentItem->id }}">
                                                        <input type="submit" value="Удалить">
                                                    </form>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endforeach

                        <div class="cart__clear" onclick="window.location.href='{{ route('clearCart') }}'">
                            @csrf
                            Очистить корзину
                        </div>
                    @endif
                </div>

                <div class="cart__offer">
                    <div class="cart__offer-title">
                        Подтвердите заказ
                    </div>

                    <div class="cart__offer-total-amount">
                        {{ count($cart) }} предмета в корзине
                    </div>

                    <div class="cart__offer-total-price">
                        <p>Всего</p>
                        <p>
                            {{ array_reduce(
                                $cart,
                                function ($acc, $item) {
                                    return $acc + (float) $item->price;
                                },
                                0,
                            ) }}
                            <span>BYN</span>
                        </p>
                    </div>

                    <button class="btn-add" onclick="window.location.href='{{ route('buyCart') }}'">ПЕРЕЙТИ К
                        ОПЛАТЕ</button>
                </div>
            </div>
        </div>
    </main>
@endsection
