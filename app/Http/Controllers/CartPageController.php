<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartPageController extends Controller
{
    public function index()
    {
        $cart = session('cart') != null ? session('cart') : [];
        $cartGames = session('cartGames') != null ? session('cartGames') : [];

        return view('pages.cart', ['cart' => $cart, 'cartGames' => $cartGames]);
    }

    public function clearCart()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $result = DB::select('call ClearCart(?)', [$user->id]);
        }
        return back()->with('success');
    }

    public function buyCart()
    {
        if (Auth::check()) {
            $user = Auth::user();
            $result = DB::select('call BuyCart(?)', [$user->id]);
        }
        return back()->with('success');
    }
}
