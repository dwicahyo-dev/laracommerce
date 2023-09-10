<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ProductController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $page = request()->has('page') ? request()->get('page') : 1;

        $params = collect([
            'name' => $request->name,
            'minimum_price' => $request->minimum_price,
            'maximum_price' => $request->maximum_price,
            'page' => $page,
        ]);

        Log::info("Getting Products with params : {$params}");

        $products = Cache::remember('products' . '_pp_' . 10 . '_p_' . $page . '_query_' . 'name=' . $request->name . '&minimum_price=' . $request->minimum_price . '&maximum_price=' . $request->maximum_price, 10, function () use ($page, $request, $params) {
            $queryName = request()->has('name') ? request()->get('name') : "";
            $minimumPrice = request()->has('minimum_price') ? request()->get('minimum_price') : "";
            $maximumPrice = request()->has('maximum_price') ? request()->get('maximum_price') : "";

            return Product::with(['category:id,name'])
                ->when(isset($request->name), function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->name . '%');
                })
                ->when(isset($request->minimum_price), function ($query) use ($request) {
                    return $query->where('price', '>=', $request->minimum_price);
                })
                ->when(isset($request->maximum_price), function ($query) use ($request) {
                    return $query->where('price', '<=', $request->maximum_price);
                })

                ->paginate(12, ['*'], 'page', $page)
                ->appends([
                    'name' => $queryName,
                    'minimum_price' => $minimumPrice,
                    'maximum_price' => $maximumPrice,
                ])
                ->withQueryString();

            Log::info("Caching Products with params : {$params}");
        });

        $categories = Cache::rememberForever('categories', function () {
            return Category::pluck('name', 'id');
        });

        Log::info("Returning view with given params");

        return view('welcome', [
            'categories' => $categories,
            'products' => $products,
        ]);
    }
}
