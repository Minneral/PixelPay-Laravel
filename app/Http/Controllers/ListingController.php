<?php

namespace App\Http\Controllers;

use App\Http\Responses\ApiResponse;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListingController extends Controller
{
    public function getListings($game = '')
    {
        $result = DB::select('call GetAvailableListings(?)', [$game]);
        return ApiResponse::send($result, 'Success');
    }

    public function GetListingFilters($game = '', Request $request)
    {
        $filter_ids = htmlspecialchars(strip_tags($request->input('filter_ids')));
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
                    $result[] = $item;
                }
            }

            if (empty($result)) {
                return ApiResponse::send(null, "No matching records found", 200, true);
            } else {
                return ApiResponse::send($result, "Success", 200);
            }
        } catch (Exception $e) {
            return ApiResponse::send(null, "Unable to fetch data from table", 200, true);
        }
    }
}
