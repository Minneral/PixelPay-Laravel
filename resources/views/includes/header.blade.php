<header class="header">
    <div class="header__container">
        <div class="header__inner">
            <div class="header__upper">
                <div class='header__upperInfo'>
                    <a href="{{ url('/') }}"><img src="{{ Vite::asset('resources/images/logo.png') }}"
                            alt="logo" /></a>

                    <div class="header__upperNav">
                        <div class="header__upperNavItem">
                            <div class="header__upperNavItem_menu">
                                <div class="header__upperNavItem_menu_title">
                                    {{ $marketGame }}
                                    <span> &#9654;</span>
                                </div>

                                <div class="header__upperNavItem_menu_body">
                                    @foreach ($games as $game)
                                        <div onclick="setMarketGame('{{ $game }}')"
                                            class="header__upperNavItem_menu_item">
                                            {{ $game }}
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="header__upperNavItem"><a href="{{ url('/market') }}">МАРКЕТ</a></div>
                    </div>
                </div>

                <form class="header__search" action=" {{ route('market') }}" method="GET">
                    <input type="text" name="query" placeholder='ПОИСК ПО CS2' />
                </form>

                <div class="header__userNav">
                    <div class="header__cart"><a href="{{ url('/cart') }}">Корзина</a></div>

                    @guest
                        <div class="header__auth">
                            <a href="{{ route('login') }}" class="header__signin">Войти</a>
                            <a href="{{ route('register') }}" class="header__signup">Регистрация</a>
                        </div>
                    @else
                        <div class='header__user'>
                            <div class="header__user-balance">
                                {{ Auth::user()->balance }} BYN
                            </div>
                            <div class="header__user-name" onclick="window.location.href='{{ route('profile') }}'">
                                {{ Auth::user()->name }}
                            </div>
                            <div class="header__user-avatar" onclick="window.location.href='{{ route('profile') }}'">
                                <img src="{{ Auth::user()->avatar }}" alt="avatar" />
                            </div>
                        </div>
                    @endguest
                </div>

                {{-- @if (session('notification'))
                    @include('includes.notification', ['message' => session('notification')])
                @endif --}}
            </div>

            <div class="header__lower">
                @foreach ($navigation as $item)
                    @include('includes.dropdown', ['data' => [$item]])
                @endforeach
            </div>
        </div>
    </div>
</header>
