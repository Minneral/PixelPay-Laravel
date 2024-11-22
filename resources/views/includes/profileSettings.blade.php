<div class="body">
    <div class="body__inner">
        <div class="body__general">
            <div class="body__title">
                <span>Общее</span>
                <span id="change_password"
                    onclick="handleChangeAvatarState('{{ $avatarState ? 'true' : 'false' }}')">{{ $avatarState ? 'Изменить пароль' : 'Изменить аватар' }}</span>
            </div>

            <div class="item">
                <div class="item__title">Имя пользователя:</div>
                <div class="item__value">{{ Auth::user()->name }}</div>
            </div>

            <div class="item">
                <div class="item__title">Email:</div>
                <div class="item__value">{{ Auth::user()->email }}</div>
            </div>

            <div class="item">
                <div class="item__title">Ссылка на обмен:</div>
                <div class="item__value">
                    <form class="TradeLinkform" action="{{ route('updateTradeLink') }}" method="post">
                        @csrf
                        <input type="text" name="tradelink" value="{{ Auth::user()->tradelink }}"
                            onchange="setTradeLink(event.target.value)">
                        <button type="submit"><img src="{{ Vite::asset('resources/icons/ok.png') }}" alt="OK"></button>
                    </form>
                </div>
            </div>

            <form action="{{ route('logout') }}" method="get">
                @csrf
                <button type="submit">Выйти из учетной записи</button>
            </form>
        </div>

        <div class="body__social">
            <div class="body__socialContent">
                <div class="body__title">
                    <span>{{ $avatarState ? 'Аватар' : 'Обновите пароль' }}</span>
                </div>

                @if ($avatarState)
                    <div class="body__avatar">
                        <img src="{{ Auth::user()->avatar }}" alt="avatar">
                        <form id="avatarForm" action="{{ route('changeAvatar') }}" method="post">
                            @csrf
                            <button type="submit">Обновить аватар</button>
                        </form>
                    </div>
                @else
                    <div class="body__changePassword">
                        <form action="{{ route('changePassword') }}" method="post">
                            @csrf
                            <div class="form__item">
                                <input type="password" name="oldPass" placeholder="Старый пароль"
                                    value="{{ $credentials['oldPass'] }}"
                                    onchange="setCredentials(event.target.name, event.target.value)">
                            </div>
                            <div class="form__item">
                                <input type="password" name="newPass" placeholder="Новый пароль"
                                    value="{{ $credentials['newPass'] }}"
                                    onchange="setCredentials(event.target.name, event.target.value)">
                            </div>
                            <div class="form__item">
                                <input type="password" name="newConf" placeholder="Повторите новый пароль"
                                    value="{{ $credentials['newConf'] }}"
                                    onchange="setCredentials(event.target.name, event.target.value)">
                            </div>
                            <div class="form__item">
                                <button type="submit">Изменить пароль</button>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

