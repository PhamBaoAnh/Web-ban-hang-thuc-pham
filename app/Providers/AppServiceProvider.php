<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Product;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $categories = Category::all();
        $brands = Brand::all();

        $sevenDaysAgo = now()->subDays(7);
        $topProduct_ids = Product::select('products.id as product_id', DB::raw('SUM(order_product.quantity) as totalSold'))
                    ->join('order_product', 'products.id', '=', 'order_product.product_id')
                    ->join('orders', 'order_product.order_id', '=', 'orders.id')
                    ->where('orders.created_at', '>=', $sevenDaysAgo)
                    ->groupBy('product_id')
                    ->orderByDesc('totalSold')
                    ->limit(3)
                    ->get();
        $topProducts = [];
        foreach ($topProduct_ids as $item) {
            $product = Product::find($item['product_id']);

            if ($product) {
                $product->totalSold = $item['totalSold'];
                $topProducts[] = $product;
            }
        }            
        View::share(compact('categories', 'brands', 'topProducts'));

        Paginator::useBootstrapFive();
        Paginator::useBootstrapFour();
    }
}
