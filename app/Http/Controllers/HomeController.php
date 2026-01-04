<?php

namespace App\Http\Controllers;
use App\Models\HomeSlider;
use App\Models\PopularCategorySlider;
use App\Models\HotDealProduct;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\HomeBanner;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $currency = "₦";
        // Fetch only active sliders, ordered by sort_order then by latest
        $homeSliders = HomeSlider::where('status', true)
            ->orderBy('sort_order', 'ASC')
            ->orderBy('id', 'DESC')
            ->get();
        $popularCategoryItems = PopularCategorySlider::where('status', true)
            ->orderBy('sort_order', 'ASC')
            ->orderBy('id', 'DESC')
            ->get();
        $hotDeals = HotDealProduct::with('product')
            ->where('status', true)
            ->orderBy('sort_order', 'ASC')
            ->get();
        $leftBanner = HomeBanner::where('banner_type', 'left')->where('status', 1)->orderBy('sort_order')->first();
        $rightBanner = HomeBanner::where('banner_type', 'right')->where('status', 1)->orderBy('sort_order')->first();

        // Top Sellers – Pure Eloquent, no DB::table, no raw SQL issues
        $topSellerIds = OrderItem::select('product_id')
            ->selectRaw('SUM(quantity) as total_sold')
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->limit(9)
            ->pluck('product_id');
        if ($topSellerIds->isEmpty()) {
            // No orders yet → show 9 random in-stock products
            $topSellers = Product::with('category')
                ->where('quantity', '>', 0) // optional: only products with stock
                ->inRandomOrder()
                ->limit(9)
                ->get();
        } else {
            // Get products in exact sales rank order using preserve order trick
            $topSellers = Product::with('category')
                ->findMany($topSellerIds) // fetches in the order of the IDs array
                ->sortBy(function ($product) use ($topSellerIds) {
                    return $topSellerIds->search($product->id);
                })
                ->values();
        }
        // Split for layout
        $featuredSeller = $topSellers->shift(); // #1 bestseller (left)
        $gridSellers = $topSellers;             // remaining 8 (right grid)

        return view('index', compact(
            'homeSliders',
            'popularCategoryItems',
            'hotDeals',
            'leftBanner',
            'rightBanner',
            'featuredSeller',
            'gridSellers',
            'currency'
        ));
    }

    public function about_us(){
        return view('about-us');
    }

    public function contact_us(){
        return view('contact-us');
    }

    public function shipping_policy(){
        return view('shipping-policy');
    }

    public function return_policy(){
        return view('return-policy');
    }

    public function terms_condition(){
        return view('terms-condition');
    }

    public function privacy_policy(){
        return view('privacy-policy');
    }
}
