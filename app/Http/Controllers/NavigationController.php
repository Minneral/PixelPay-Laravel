<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\Navigation;
use Illuminate\Http\Request;

class NavigationController extends Controller
{
    function getNavigation($game = null)
    {
        if ($game)
            $navigation = Navigation::join('Games', 'Navigation.game_id', '=', 'Games.id')
                ->select('Navigation.id', 'Navigation.name', 'Navigation.parent_id', 'Games.game')
                ->where('games.game', $game)
                ->get();

        else
            $navigation = Navigation::join('Games', 'Navigation.game_id', '=', 'Games.id')
                ->select('Navigation.id', 'Navigation.name', 'Navigation.parent_id', 'Games.game')
                ->get();


        return ApiResponse::send($navigation, 'Success');
    }
}
