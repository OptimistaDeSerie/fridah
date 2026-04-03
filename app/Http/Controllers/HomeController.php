<?php

namespace App\Http\Controllers;
use App\Models\HomeSlider;
use App\Models\PopularCategorySlider;
use App\Models\HotDealProduct;
use App\Models\Product;
use App\Models\ProductSize;
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
        $hotDeals = HotDealProduct::with(['product' => function ($query) {
                $query->with('sizes');  // Important: load sizes
            }])
            ->where('status', true)
            ->orderBy('sort_order', 'ASC')
            ->get()
            ->filter(function ($deal) {
                // Only keep deals where the product still exists and has at least one size
                return $deal->product && $deal->product->sizes->isNotEmpty();
            });
        $leftBanner = HomeBanner::where('banner_type', 'left')->where('status', 1)->orderBy('sort_order')->first();
        $rightBanner = HomeBanner::where('banner_type', 'right')->where('status', 1)->orderBy('sort_order')->first();

        $topSellerIds = OrderItem::select('product_id')
        ->selectRaw('SUM(quantity) as total_sold')
        ->groupBy('product_id')
        ->orderByDesc('total_sold')
        ->limit(9)
        ->pluck('product_id');

        if ($topSellerIds->isEmpty()) {
            $topSellers = Product::with('category')
                ->whereHas('sizes', fn($q) => $q->where('quantity', '>', 0))
                ->inRandomOrder()
                ->limit(9)
                ->get();
        } else {
            $idsOrder = implode(',', $topSellerIds->toArray());
            $topSellers = Product::with('category')
                ->whereIn('id', $topSellerIds)
                ->when($idsOrder, fn($q) => $q->orderByRaw("FIELD(id, $idsOrder)"))
                ->get();
        }

        $featuredSeller = $topSellers->shift();   // first one = featured
        $gridSellers    = $topSellers;            // rest = grid

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
