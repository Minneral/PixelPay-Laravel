<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use App\Models\Filter;
use App\Models\FilterCategories;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    function getFilters($game = null)
    {
        if ($game)
            $filters = Filter::join('Filter_categories', 'Filters.filter_category_id', '=', 'Filter_categories.id')
                ->join('Games', 'Filter_categories.game_id', '=', 'Games.id')
                ->select('Filters.id', 'Filters.filter_name', 'Filter_categories.category', 'Games.game')
                ->where('games.game', $game)
                ->get();
        else
            $filters = Filter::join('Filter_categories', 'Filters.filter_category_id', '=', 'Filter_categories.id')
                ->join('Games', 'Filter_categories.game_id', '=', 'Games.id')
                ->select('Filters.id', 'Filters.filter_name', 'Filter_categories.category', 'Games.game')
                ->get();

        return ApiResponse::send($filters, 'Success');
    }

    function getCategories($game = null)
    {
        if ($game)
            $categories = FilterCategories::join('games', 'Filter_categories.game_id', '=', 'Games.id')
                ->select('Filter_categories.id', 'Filter_categories.category', 'Games.game')
                ->where('games.game', $game)
                ->get();
        else
            $categories = FilterCategories::join('games', 'Filter_categories.game_id', '=', 'Games.id')
                ->select('Filter_categories.id', 'Filter_categories.category', 'Games.game')
                ->get();

        return ApiResponse::send($categories, 'Success');
    }
}
