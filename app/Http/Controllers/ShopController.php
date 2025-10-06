<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use App\Models\Product;
use App\Models\Category;

class ShopController extends Controller
{
    public function index(Request $request){      
        /* // Clear View caches
        Artisan::call('view:clear'); */
        $size = $request->query('size') ? $request->query('size') : 12;
        $o_column = "";
        $o_order = "";
        $orderby = $request->query('order') ? $request->query('order') : -1;
        $filter_categories = $request->query('categories') ? explode(',', $request->query('categories')) : [];
        $min_price = $request->query('min_price') ? $request->query('min_price') : 1;
        $max_price = $request->query('max_price') ? $request->query('max_price') : 10000; //default max price
        switch($orderby){
            case 1:
                $o_column = "created_at";
                $o_order = "DESC";
                break;
            case 2:
                $o_column = "created_at";
                $o_order = "ASC";
                break;
            case 3:
                $o_column = "sale_price"; // fixed typo from 'saleprice'
                $o_order = "ASC";
                break;
            case 4:
                $o_column = "sale_price";
                $o_order = "DESC";
                break;
            default:
                $o_column = "id";
                $o_order = "DESC";
        }
        $categories = Category::withCount('products') // products is the relationship name
            ->orderBy('created_at', 'DESC')
            ->get();
        $products = Product::orderBy($o_column, $o_order);

        // ✅ Only filter if categories are posted
        if (!empty($filter_categories)) {
            $products->whereIn('category_id', $filter_categories);
        }

        // ✅ Only filter if min and max price are posted
        if (!empty($min_price) && !empty($max_price)) {
            $products->whereBetween('sale_price', [$min_price, $max_price]);
        }
        $products = $products->paginate($size);
        $currency = "₦";
        return view('shop',compact("products","currency","categories","size", "orderby", "filter_categories", "min_price", "max_price"));
    }

    public function product_details($product_slug){
        $currency = "₦";
        $product = Product::where('slug', $product_slug)->firstOrFail();
        $relatedproducts = Product::where('slug','<>',$product_slug)->get()->take(8);
        return view('shop-detail', compact('product',"currency","relatedproducts"));
    }
}
