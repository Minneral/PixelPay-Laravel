@extends('layouts.default')

@section('styles')
    @vite(['resources/scss/auth.scss'])
@endsection

@section('content')
    <div class="auth" id="registerAuth">
        <div class="auth-content">
            <div class="auth-title">Регистрация</div>
            <form class='auth-form' id="form" action="{{ route('performRegister') }}" method="POST">
                @csrf
                <div class="auth-form-item">
                    <label for="name">Имя пользователя</label>
                    <input type="text" name="name" id="name" required>
                    <span class="auth-error-message" id="name-error"></span>
                </div>
                <div class="auth-form-item">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required>
                    <span class="auth-error-message" id="email-error"></span>
                </div>
                <div class="auth-form-item">
                    <label for="password">Пароль</label>
                    <input type="password" name="password" id="password" required>
                    <span class="auth-error-message" id="password-error"></span>
                </div>
                <div class="auth-form-item">
                    <label for="password_confirmation">Повторите пароль</label>
                    <input type="password" name="password_confirmation" id="passConf" required>
                    <span class="auth-error-message" id="passConf-error"></span>
                </div>
                <div class="auth-form-item">
                    <button type='submit'>Зарегистрироваться</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('name');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const passConfInput = document.getElementById('passConf');
            const form = document.getElementById('form');

            nameInput.addEventListener('blur', function() {
                validateField(nameInput, 'name');
            });

            emailInput.addEventListener('blur', function() {
                validateField(emailInput, 'email');
            });

            passwordInput.addEventListener('blur', function() {
                validateField(passwordInput, 'password');
            });

            passConfInput.addEventListener('blur', function() {
                validateField(passConfInput, 'passConf');
            });

            form.addEventListener('submit', handleSubmit);

            function validateField(input, fieldName) {
                let errorMessage = '';
                const errorElement = document.getElementById(fieldName + '-error');
                const errorInput = document.getElementById(fieldName);

                fetch('http://127.0.0.1:8000/api/registerValidate', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            'name': nameInput.value,
                            'email': emailInput.value,
                            'password': passwordInput.value,
                            'passConf': passConfInput.value,
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