<?php

namespace App\View\Composers;

use App\Models\Order;
use Illuminate\View\View;

class RecentOrdersComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view)
    {
        $recentOrders = Order::orderBy('created_at', 'desc')
            ->limit(4)
            ->get();

        $view->with('recentOrders', $recentOrders);
    }
}