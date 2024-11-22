<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CardController extends Controller
{
    public function removeFromCart(Request $request)
    {
        $listing_id = $request->input('id');

        if (isset($listing_id)) {
            $user = Auth::user();

            $result = DB::select('call CartPop(?, ?)', [$user->id, $listing_id]);
        }

        return back()->with('success', 'Item removed from cart successfully');
    }

    public function addToCart(Request $request)
    {
        $listing_id = $request->input('id');

        if (isset($listing_id)) {
            $user = Auth::user();

            $result = DB::select('call CartPush(?, ?)', [$user->id, $listing_id]);
        }

        return back()->with('success', 'Item removed from cart successfully');
    }
}
