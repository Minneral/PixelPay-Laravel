<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Responses\ApiResponse;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Vite;

class AuthPageController extends Controller
{
    public function loginPage()
    {
        return view('pages.login');
    }

    public function registerPage()
    {
        return view('pages.register');
    }

    public function performLogin(Request $request)
    {
        $name = $request->input('name');
        $password = $request->input('password');

        $user = User::where('name', $name)->first();

        if ($user instanceof User) {
            if (Hash::check($password, $user->password)) {
                $path = resource_path() . "\\avatars\\" . $user->name . ".jpg";
                $defaultPath = resource_path() . "\\avatars\\" . "default.webp";

                if ($user instanceof User) {
                    if (file_exists($path)) {
                        $user->avatar = Vite::asset('resources/avatars/' . $user->name . ".jpg");
                    } else {
                        $user->avatar = Vite::asset('resources/avatars/default.webp');
                    }
                    $user->save();
                }
                Auth::login($user);
                return redirect()->route('home');
            }
        }

        return redirect()->back()->withErrors(['password' => 'Неверное имя пользователя или пароль!']);
    }

    public function performRegister(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password');

        $hashedPassword = Hash::make($password);

        $user = User::where('name', $name)->first();
        if ($user !== null)
            return back(200);

        User::create([
            "name" => $name,
            "email" => $email,
            "password" => $hashedPassword,
            "balance" => 0,
            "tradelink" => null,
            "avatar" => null
        ]);

        return redirect()->route('login');
    }
}
