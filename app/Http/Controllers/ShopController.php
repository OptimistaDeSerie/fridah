<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductSize;

class ShopController extends Controller
{
    public function index(Request $request){
    /* // Clear View caches
    Artisan::call('view:clear'); */

    $size = $request->query('size', 12);
    $orderby = $request->query('order', -1);
    $filter_categories = $request->query('categories')
        ? explode(',', $request->query('categories'))
        : [];

    $min_price = $request->query('min_price', 1);
    $max_price = $request->query('max_price', 10000);

    // 🔥 SORTING
    $o_column = 'products.id';
    $o_order  = 'DESC';

    switch ($orderby) {
        case 1:
            $o_column = 'products.created_at';
            $o_order = 'DESC';
            break;
        case 2:
            $o_column = 'products.created_at';
            $o_order = 'ASC';
            break;
        case 3:
            $o_column = 'prices.effective_price'; // 🔥 size-based price
            $o_order = 'ASC';
            break;
        case 4:
            $o_column = 'prices.effective_price'; // 🔥 size-based price
            $o_order = 'DESC';
            break;
    }

    // 🔥 CATEGORIES
    $categories = Category::withCount('products')
        ->orderBy('created_at', 'DESC')
        ->get();

    // 🔥 SUBQUERY: COMPUTE EFFECTIVE PRICE PER PRODUCT
    $priceSubQuery = \DB::table('product_sizes')
        ->select(
            'product_id',
            \DB::raw('MIN(
                CASE
                    WHEN sale_price IS NOT NULL AND sale_price > 0
                    THEN sale_price
                    ELSE regular_price
                END
            ) as effective_price')
        )
        ->groupBy('product_id');

    // 🔥 MAIN PRODUCT QUERY (NO GROUP BY PROBLEMS)
    $products = Product::with('sizes')
        ->leftJoinSub($priceSubQuery, 'prices', function ($join) {
            $join->on('products.id', '=', 'prices.product_id');
        })
        ->select('products.*', 'prices.effective_price');

    // 🔥 CATEGORY FILTER
    if (!empty($filter_categories)) {
        $products->whereIn('products.category_id', $filter_categories);
    }

    // 🔥 PRICE FILTER (NOW NORMAL WHERE, NOT HAVING)
    if ($min_price !== null && $max_price !== null) {
        $products->whereBetween('prices.effective_price', [$min_price, $max_price]);
    }

    // 🔥 SEARCH
    $search_term = $request->query('q');
    //$search_category = $request->query('cat');

    if ($search_term) {
        $products->where(function ($query) use ($search_term) {
            $query->where('products.name', 'LIKE', "%{$search_term}%")
                ->orWhere('products.short_description', 'LIKE', "%{$search_term}%")
                ->orWhere('products.description', 'LIKE', "%{$search_term}%");
        });
    }

    // Remove this part entirely if you want no category filtering on search
    // if ($search_category) {
    //     $products->where('products.category_id', $search_category);
    // }

    // 🔥 APPLY SORT + PAGINATION
    $products = $products
        ->orderBy($o_column, $o_order)
        ->paginate($size)
        ->withQueryString();

    $currency = '₦';

    return view('shop', compact(
        'products',
        'currency',
        'categories',
        'size',
        'orderby',
        'filter_categories',
        'min_price',
        'max_price'
    ));
}


    public function product_details($product_slug){
        $currency = "₦";
        $product = Product::with('sizes') // 🔥 LOAD SIZES
            ->where('slug', $product_slug)
            ->firstOrFail();
        $relatedproducts = Product::where('slug', '<>', $product_slug)
            ->take(8)
            ->get();
        return view('shop-detail', compact('product',"currency","relatedproducts"));
    }
}
