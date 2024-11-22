<?php

namespace App\Providers;

use App\Http\Controllers\HomePageController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('includes.header', function ($view) {

            if (Auth::check()) {
                $user = Auth::user();
                $cart = DB::select('call GetCart(?)', [$user->id]);

                session()->put('cart', $cart);

                $uniqueGamesSet = collect($cart)->map(function ($item) {
                    return $item->game;
                })->unique();
                session()->put('cartGames', $uniqueGamesSet);
            }

            $homePageController = new HomePageController();

            $games = $homePageController->getGames();
            $marketGame = $games[0];
            $navigation = $homePageController->getNavigation();

            session()->put('marketGame', $marketGame);

            $view->with('marketGame', $marketGame)
                ->with('games', $games)
                ->with('navigation', $navigation);
        });
    }
}
