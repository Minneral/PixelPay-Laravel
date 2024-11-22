<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Vite;

class ProfilePageController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $view = $request->input('view');
        $avatarState = true;
        $purchases = DB::select('call GetUserPurchases(?)', [$user->id]);
        $transactions = DB::select('call GetUserTransactions(?)', [$user->id]);


        if (!isset($view))
            $title = 'Настройки';
        else
            switch ($view):
                case 'purchases':
                    $title = "Мои покупки";
                    break;
                case 'transactions':
                    $title = 'Транзакции';
                    break;
                case 'avatarState':
                    break;
                default:
                    $avatarState = false;
                    break;
            endswitch;

        return view('pages.profile', ['page' => $title, 'avatarState' => $avatarState, 'purchases' => $purchases, 'transactions' => $transactions]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function updateTradeLink(Request $request)
    {
        // Проверка аутентификации пользователя
        if (!Auth::check()) {
            // Пользователь не аутентифицирован, перенаправляем на страницу входа
            return redirect()->route('login');
        }

        // Получаем ссылку на обмен из запроса
        $tradelink = $request->input('tradelink');

        // Получаем текущего пользователя
        $user = Auth::user();

        if ($user instanceof User) {
            $user->tradelink = $tradelink;
            $user->save();
        }
        // Возвращаемся на предыдущую страницу с кодом состояния 200 (Успешно)
        return back();
    }
}
