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

        $products = Product::orderBy('created_at','DESC')->paginate(12);
        $categories = Category::withCount('products') // products is the relationship name
            ->orderBy('created_at', 'DESC')
            ->get();
        $currency = "₦";
        return view('shop',compact("products","currency","categories"));
    }

    public function product_details($product_slug){
        $currency = "₦";
        $product = Product::where('slug', $product_slug)->firstOrFail();
        $relatedproducts = Product::where('slug','<>',$product_slug)->get()->take(8);
        return view('shop-detail', compact('product',"currency","relatedproducts"));
    }
}
