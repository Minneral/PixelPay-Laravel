<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Responses\ApiResponse;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function getUserInfo()
    {
        $user = Auth::user();
        $path = resource_path() . "\\avatars\\" . $user->name . ".jpg";
        $defaultPath = resource_path() . "\\avatars\\" . "default.webp";

        if ($user instanceof User) {
            if (file_exists($path)) {
                $binaryData = file_get_contents($path);
            } else {
                $binaryData = file_get_contents($defaultPath);
            }
            $base64Data = base64_encode($binaryData);
            $user->avatar = $base64Data;

            return ApiResponse::send($user, "Success");
        }
    }

    public function login(LoginRequest $request)
    {
        $validated = $request->validated();

        $name = $validated['name'];
        $password = $validated['password'];

        $user = User::where('name', $name)->first();

        if ($user instanceof User) {
            if (Hash::check($password, $user->password)) {
                $token = $user->createToken('auth_token')->plainTextToken;
                return ApiResponse::send($token, "Success");
            }
        }

        return ApiResponse::send(null, "Неверно указан логин или пароль!", 200, true);
    }

    public function loginValidate(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|max:255',
                'password' => 'required|min:8',
            ], [
                'name.required' => 'Имя обязательно для заполнения',
                'name.max' => 'Имя пользователя не должно быть больше 255 символов',
                'password.required' => 'Пароль обязателен для заполнения',
                'password.min' => 'Длина пароля должна быть как минимум 8 символов',
            ]);


            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();

                if ($request->input('fieldName') != null) {
                    $fieldName = $request->input('fieldName');
                    if (array_key_exists($fieldName, $errors)) {
                        return ApiResponse::send([], $errors[$fieldName], 200, true);
                    }
                } else {
                    return ApiResponse::send([], $errors, 200, true);
                }
            }

            return ApiResponse::send([], "Success", 200);
        } catch (Exception $e) {
            return ApiResponse::send([], "Success", 200);
        }
    }

    public function registerValidate(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|max:255|unique:users',
                    'email' => 'required|email',
                    'password' => 'required|min:8',
                    'passConf' => 'required|same:password'
                ],
                [
                    'name.required' => 'Имя обязательно для заполнения',
                    'email.required' => 'Email обязателен для заполнения',
                    'password.required' => 'Пароль обязателен для заполнения',
                    'name.unique' => 'Пользователь с таким именем уже существует',
                    'email.email' => "Почта не соответствует требованиям",
                    'password.min' => 'Длина пароля должна быть как минимум 8 символов',
                    'passConf.same' => 'Пароли не совпадают',
                    'passConf.required' => 'Заполните это поле',
                ]
            );


            if ($validator->fails()) {
                $errors = $validator->errors()->toArray();

                if ($request->input('fieldName') != null) {
                    $fieldName = $request->input('fieldName');
                    if (array_key_exists($fieldName, $errors)) {
                        return ApiResponse::send([], $errors[$fieldName], 200, true);
                    }
                } else {
                    return ApiResponse::send([], $errors, 200, true);
                }
            }

            return ApiResponse::send([], "Success", 200);
        } catch (Exception $ex) {
            return ApiResponse::send(null, $ex->getMessage(), 200, true);
        }
    }

    public function register(RegisterRequest $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');

        $hashedPassword = Hash::make($password);

        $user = User::where('name', $name)->first();
        if ($user !== null)
            return ApiResponse::send(null, "Пользователь с таким именем уже существует", 200, true);

        User::create([
            "name" => $name,
            "email" => $email,
            "password" => $hashedPassword,
            "balance" => 0,
            "tradelink" => null,
            "avatar" => null
        ]);

        return ApiResponse::send(null, "You successfuly registered!");
    }
    public function isNameAvailable(Request $request)
    {
        $name = $request->input('name');

        $user = User::where('name', $name)->first();
        if ($user === null)
            ApiResponse::send(null, "NAME_EXISTS");
        else
            ApiResponse::send(null, "NAME_AVAILABLE");
    }
    public function ChangePassword(Request $request)
    {
        try {
            $user = Auth::user();

            $oldPass = htmlspecialchars(strip_tags($request->input('oldPass')));
            $newPass = htmlspecialchars(strip_tags($request->input('newPass')));
            $newConf = htmlspecialchars(strip_tags($request->input('newConf')));


            if (empty($oldPass) || empty($newConf) || empty($newPass))
                throw new Exception("Заполните пустые поля!");

            if (!Hash::check($oldPass, $user->password))
                throw new Exception("Неверный старый пароль!");

            if (strcmp($newConf, $newPass))
                throw new Exception("Введенные пароли не совпадают!");

            if (!strcmp($oldPass, $newPass))
                throw new Exception("Старый и новый пароль не могут совпадать!");

            if ($user instanceof User) {
                $user->password = Hash::make($newPass);
                $user->save();
            }
            return ApiResponse::send(null, 'Success');
        } catch (Exception $ex) {
            return ApiResponse::send(null, $ex->getMessage(), 200, true);
        }
    }
    public function ChangeAvatar(Request $request)
    {
        $user = Auth::user();
        // $path = resource_path() . "\\avatars\\" . $user->name . ".jpg";
        $path = resource_path() . "\\avatars\\" . $request->input('name') . ".jpg";
        $avatar = $request->input('avatar');
        if ($avatar) {
            // Получаем содержимое изображения из строки base64
            $base64_str = preg_replace('/^data:image\/\w+;base64,/', '', $avatar);

            // Декодируем строку base64 в бинарные данные
            $imageDataBinary = base64_decode($base64_str);

            // Сохраняем изображение на сервере
            file_put_contents($path, $imageDataBinary);
        }

        return ApiResponse::send(null, 'Success');
    }
    public function GetPurchases()
    {
        $user = Auth::user();
        $result = DB::select('call GetUserPurchases(?)', [$user->id]);
        return ApiResponse::send($result, 'Success');
    }
    public function GetTransactions()
    {
        $user = Auth::user();
        $result = DB::select('call GetUserTransactions(?)', [$user->id]);
        return ApiResponse::send($result, 'Success');
    }
    public function getCart()
    {
        try {
            $user = Auth::user();
            $result = DB::select('call GetCart(?)', [$user->id]);
            return ApiResponse::send($result, 'Success');
        } catch (Exception $e) {
            return ApiResponse::send(null, 'Ошибка: ' . $e->getMessage(), 200, true);
        }
    }
    public function UpdateTradeLink(Request $request)
    {
        $tradelink = $request->input('tradeLink');
        $user = Auth::user();

        if ($user instanceof User) {
            $user->tradelink = $tradelink;
            $user->save();
        }

        return ApiResponse::send(null, 'Success');
    }
    public function CartPush(Request $request)
    {
        try {
            $user = Auth::user();
            $listing_id = $request->input('listing_id');

            $result = DB::select('call CartPush(?, ?)', [$user->id, $listing_id]);
            return ApiResponse::send($result, 'Success');
        } catch (Exception $e) {
            return ApiResponse::send(null, 'Ошибка: ' . $e->getMessage(), 200, true);
        }
    }
    public function CartPop(Request $request)
    {
        try {
            $user = Auth::user();
            $listing_id = $request->input('listing_id');

            $result = DB::select('call CartPop(?, ?)', [$user->id, $listing_id]);
            return ApiResponse::send($result, 'Success');
        } catch (Exception $e) {
            return ApiResponse::send(null, 'Ошибка: ' . $e->getMessage(), 200, true);
        }
    }
    public function BuyCart()
    {
        try {
            $user = Auth::user();
            $result = DB::select('call BuyCart(?)', [$user->id]);
            return ApiResponse::send($result, 'Success');
        } catch (Exception $e) {
            return ApiResponse::send(null, 'Ошибка: ' . $e->getMessage(), 200, true);
        }
    }
    public function ClearCart()
    {
        try {
            $user = Auth::user();
            $result = DB::select('call ClearCart(?)', [$user->id]);
            return ApiResponse::send($result, 'Success');
        } catch (Exception $e) {
            return ApiResponse::send(null, 'Ошибка: ' . $e->getMessage(), 200, true);
        }
    }
}
