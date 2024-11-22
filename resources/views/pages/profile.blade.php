@extends('layouts.default')
@section('content')
    <div class="profile">
        <div class="profile__container">
            <div class="profile__inner">
                <div class="profile__info">
                    <div class="profile__title">
                        {{ $page }}
                    </div>

                    <div class="profile__nav">
                        <div class="profile__navLink {{ $page === 'Настройки' ? 'profile__navLink_active' : '' }}"
                            onclick="window.location.href='{{ route('profile') }}'">
                            Настройки
                        </div>
                        <div class="profile__navLink {{ $page === 'Мои покупки' ? 'profile__navLink_active' : '' }}"
                            onclick="window.location.href='{{ route('profile') }}?view=purchases'">
                            Мои покупки
                        </div>
                        <div class="profile__navLink {{ $page === 'Транзакции' ? 'profile__navLink_active' : '' }}"
                            onclick="window.location.href='{{ route('profile') }}?view=transactions'">
                            Транзакции
                        </div>
                    </div>

                </div>

                <div class="profile__body">
                    @if (Auth::check())
                        @if ($page == 'Настройки')
                            @include('includes.profileSettings', ['avatarState' => $avatarState])
                        @endif

                        @if ($page == 'Мои покупки')
                            @include('includes.profilePurchases', ['purchases' => $purchases])
                        @endif

                        @if ($page == 'Транзакции')
                            @include('includes.profileTransactions', ['transactions' => $transactions])
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    @vite(['resources/scss/profilePage.scss']);
    @if ($page == 'Настройки')
        @vite(['resources/scss/profileSettings.scss']);
    @endif

    @if ($page == 'Мои покупки')
        @vite(['resources/scss/profilePurchases.scss']);
    @endif

    @if ($page == 'Транзакции')
        @vite(['resources/scss/profileTransactions.scss']);
    @endif
@endsection


@section('scripts')
    <script>
        document.querySelector('#avatarForm').addEventListener('submit', function(event) {
            event.preventDefault();

            let input = document.createElement('input');
            input.type = 'file';

            input.onchange = e => {
                let file = e.target.files[0];
                let reader = new FileReader();
                reader.readAsDataURL(file);

                reader.onload = readerEvent => {
                    let content = readerEvent.target.result;
                    let token = document.querySelector('input[name="_token"]').value
                    const username = document.querySelector('.header__user-name').textContent
                    console.log(token)
                    fetch('http://127.0.0.1:8000/api/changeAvatar', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-Auth-Token': "",
                                'X-CSRF-TOKEN': token
                            },
                            body: JSON.stringify({
                                avatar: content,
                                name: username
                            })
                        })
                        .then(response => response.json())
                        .then(data => console.log(data))
                        .catch(error => console.error(error));
                }
            }

            input.click();
        });
    </script>
@endsection
