@extends('layouts.default')

@section('styles')
    @vite(['resources/scss/auth.scss'])
@endsection

@section('content')
    <div class="auth" id="loginAuth">
        <div class="auth-content">
            <div class="auth-title">Авторизация</div>
            <form class='auth-form' id="form" action="{{ route('performLogin') }}" method="POST">
                @csrf
                <div class="auth-form-item">
                    <label for="name">Имя пользователя</label>
                    <input type="text" name="name" id="name" required>
                    <span class="auth-error-message" id="name-error"></span>
                </div>
                <div class="auth-form-item">
                    <label for="password">Пароль</label>
                    <input type="password" name="password" id="password" required>
                    <span class="auth-error-message" id="password-error"></span>
                </div>
                <div class="auth-form-item">
                    <button type='submit'>Войти</button>
                </div>
                @if ($errors->has('password'))
                    <div class="error">
                        {{ $errors->first('password') }}
                    </div>
                @endif
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('name');
            const passwordInput = document.getElementById('password');
            const form = document.getElementById('form');

            nameInput.addEventListener('blur', function() {
                validateField(nameInput, 'name');
            });

            passwordInput.addEventListener('blur', function() {
                validateField(passwordInput, 'password');
            });

            form.addEventListener('submit', handleSubmit);

            function validateField(input, fieldName) {
                let errorMessage = '';
                const errorElement = document.getElementById(fieldName + '-error');
                const errorInput = document.getElementById(fieldName);
                console.log(nameInput.value);
                console.log(passwordInput.value);
                console.log(fieldName);
                fetch('http://127.0.0.1:8000/api/loginValidate', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            'name': nameInput.value,
                            'password': passwordInput.value,
                            'fieldName': fieldName
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(response => {
                        console.log(response);
                        if (response.status !== "OK") {
                            errorMessage = response.message;
                            errorElement.textContent = errorMessage;
                            errorInput.classList.add('input-error');
                        } else {
                            errorElement.textContent = "";
                            errorInput.classList.remove('input-error');
                        }
                    })
                    .catch(error => {
                        console.error('There was a problem with the fetch operation:', error);
                        errorElement.textContent = 'An error occurred while validating the field.';
                    });
            }

            function handleSubmit(e) {
                e.preventDefault();
                const errors = document.getElementsByClassName('input-error');

                if (errors.length == 0) {
                    e.target.submit();
                }
            }

        });
    </script>
@endsection
