<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    function getGames()
    {
        $games = Game::all();

        return ApiResponse::send($games, "Success");
    }
}
