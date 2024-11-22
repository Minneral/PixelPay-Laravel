<?php

namespace App\Http\Requests;

use App\Http\Responses\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'password' => 'required|min:8',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Имя обязательно для заполнения',
            'password.required' => 'Пароль обязателен для заполнения',
            'password.min' => 'Длина пароля должна быть как минимум 8 символов',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        // Взять первую ошибку
        $errors = $validator->errors()->all()[0];
        // $errorMessage = implode(' ', $errors);

        throw new HttpResponseException(ApiResponse::send(null, 'Ошибка: ' . $errors, 400, true));
    }
    
}
