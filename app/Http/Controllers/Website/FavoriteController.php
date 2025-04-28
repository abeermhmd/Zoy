<?php

namespace App\Http\Controllers\Website;

use App\Models\{Favorite, Product};
use App\Services\FavoriteService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FavoriteController extends Controller
{
    protected $favoriteService;

    public function __construct(FavoriteService $favoriteService)
    {
        $this->favoriteService = $favoriteService;
    }

    public function addToFavorite(Request $request)
    {
        $addFavo = $this->favoriteService->addToFavorite($request);
        if ($addFavo) {
            $message = __('api.ok');
            return response()->json(['status' => true, 'message' => $message]);
        } else {
            $message = __('api.whoops');
            return response()->json(['status' => false, 'message' => $addFavo]);
        }
    }

    public function removeFavorite(Request $request)
    {
        $this->favoriteService->removeFavorite($request);
        $count = Favorite::where('user_id', auth('web')->id())->count();
        $message = __('api.ok');
        return response()->json(['status' => true, 'count' => $count, 'message' => $message]);
    }

}
