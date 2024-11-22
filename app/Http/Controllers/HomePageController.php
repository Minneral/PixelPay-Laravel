<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Navigation;
use Illuminate\Support\Facades\Auth;

class HomePageController extends Controller
{
    public function index()
    {
        $listingController = new ListingController();
        $listings = $listingController->getListings()->getContent();
        $listings = json_decode($listings, true)['data'];
        return view('pages.home', ['listings' => $listings]);
    }

    public function getMarketGame()
    {
        return "CS2";
    }

    public function getGames()
    {
        return Game::select('game')->get()->pluck('game')->toArray();
    }

    private function buildTree($data, $parentId = 0)
    {
        $tree = [];

        foreach ($data as $item) {
            if ($item['parent_id'] == $parentId) {
                $children = $this->buildTree($data, $item['id']);
                if (!empty($children)) {
                    $item['children'] = $children;
                }
                $tree[] = $item;
            }
        }

        return $tree;
    }

    public function getNavigation()
    {
        $navigation = Navigation::join('Games', 'Navigation.game_id', '=', 'Games.id')
            ->select('Navigation.id', 'Navigation.name', 'Navigation.parent_id', 'Games.game')
            ->where('games.game', $this->getMarketGame())
            ->get();

        return $this->buildTree($navigation);
    }
}
