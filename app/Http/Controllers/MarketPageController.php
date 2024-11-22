<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Responses\ApiResponse;
use App\Models\Filter;
use App\Models\FilterCategories;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Vite;

class MarketPageController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $listingController = new ListingController();
        $marketGame = session('marketGame');
        $search = $request->input('query');
        $minPrice = $request->input('minPrice');
        $maxPrice = $request->input('maxPrice');
        $searchFilter = $request->input('filter');
        if (!isset($search))
            $search = '';

        if ($searchFilter != null && !empty($searchFilter)) {
            $listings = $this->GetListingFilters($searchFilter, $marketGame);
        } else {
            $listings = json_decode($listingController->getListings($marketGame)->getContent(), true)['data'];
        }

        if ($minPrice !== null && $maxPrice !== null) {
            $listings = array_filter($listings, function ($listing) use ($minPrice, $maxPrice) {
                return $listing['price'] >= $minPrice && $listing['price'] <= $maxPrice;
            });
        }

        $categories = FilterCategories::join('games', 'Filter_categories.game_id', '=', 'Games.id')
            ->select('Filter_categories.id', 'Filter_categories.category', 'Games.game')
            ->where('games.game', $marketGame)
            ->get()
            ->toArray();

        $filters = Filter::join('Filter_categories', 'Filters.filter_category_id', '=', 'Filter_categories.id')
            ->join('Games', 'Filter_categories.game_id', '=', 'Games.id')
            ->select('Filters.id', 'Filters.filter_name', 'Filter_categories.category', 'Games.game')
            ->where('games.game', $marketGame)
            ->get()
            ->toArray();

        return view('pages.market', ['listings' => $listings, 'search' => $search, 'categories' => $categories, 'filters' => $filters, 'searchFilter' => $searchFilter]);
    }


    public function GetListingFilters($filter, $game = '')
    {
        $filter_ids = htmlspecialchars($filter);
        try {
            $listings = DB::select('call GetListingFilters(?)', [$game ?: '']);
            $availableListings = DB::select('call GetAvailableListings(?)', [$game ?: '']);
            $filter_categories = DB::select('call GetFilterCategoryID(?)', [$filter_ids ?: '']);

            $filter_ids_array = explode(",", $filter_ids);

            $found = [];
            $merged = [];

            foreach ($filter_categories as $item) {
                $found[$item->filter_category_id] = [];
            }

            foreach ($filter_ids_array as $id) {
                foreach ($listings as $listing) {
                    if (strval($listing->filter_id) === strval($id)) {
                        $found[$listing->category_id][] = $listing->id;
                    }
                }
            }

            foreach ($found as $item) {
                $merged = array_merge($merged, $item);
            }

            $intersection = count($found) > 1 ? call_user_func_array('array_intersect', $found) : reset($found);

            $result = [];

            foreach ($availableListings as $item) {
                if (in_array(strval($item->id), array_map('strval', $intersection))) {
                    $result[] = json_decode(json_encode($item), true);
                }
            }

            if (empty($result)) {
                return [];
            } else {
                return $result;
            }
        } catch (Exception $e) {
            return [];
        }
    }
}
