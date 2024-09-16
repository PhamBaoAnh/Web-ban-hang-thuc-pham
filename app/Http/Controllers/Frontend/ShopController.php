<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Brand;

class ShopController extends Controller
{
    public function index(){
        $topSellingProducts = Product::orderByDesc('sold')->get()->take(10);
        $latestProducts = Product::orderByDesc('id')->get()->take(8);
        return view('frontend.index', compact('topSellingProducts','latestProducts'));
    }

    public function shop(Request $request){
        
        $keyword = $request->input('search');
       
        $products = Product::when($keyword, function($query,$keyword){
            return $query->where('name','like',"%$keyword%");
        });
        $products = $this->filter($products, $request);
        $products = $this->sortByAndPaginate($products, $request);
      //  dd($products);
        return view('frontend.shop', compact('products'));
    }

    public function getProductByCategory($category_id, Request $request){
        $products = Product::where('category_id', $category_id);
        $products = $this->filter($products, $request);
        $products = $this->sortByAndPaginate($products, $request);

        return view('frontend.shop', compact('products'));
    }

    public function getProductByBrand(Request $request, $brand_id = ''){
        if(!empty($brand_id)){
            $products = Product::where('brand_id', $brand_id);
        }
        else{
            $products = Product::query();
        }
        $products = $this->filter($products, $request);
        $products = $this->sortByAndPaginate($products, $request);

        return view('frontend.shop', compact('products'));
    }
    
    public function product(Product $product){
        $relatedProducts = Product::where('category_id', $product->category_id)
                                    ->whereNot('id', $product->id)                            
                                    ->get();
        return view('frontend.product', compact('product','relatedProducts'));
    }
    protected function filter($products, $request)
{
    /* Thương hiệu */
    $brands = $request->input('brand') ?? [];
    $arr_brands = array_keys($brands);

    // Filter products by brand if brand filters are selected
    $products = $products->when($arr_brands, function($query, $arr_brands){
        return $query->whereIn('brand_id', $arr_brands);
    });

    /* Lọc giá */
    $min_price = $request->input('min_price');
    $max_price = $request->input('max_price');

    // Apply price filter based on availability of min_price and max_price
    if ($min_price !== null && $max_price !== null) {
        // Both min_price and max_price are provided
        $products->whereBetween('price', [$min_price, $max_price]);
    } elseif ($min_price !== null) {
        // Only min_price is provided
        $products->where('price', '>=', $min_price);
    } elseif ($max_price !== null) {
        // Only max_price is provided
        $products->where('price', '<=', $max_price);
    }
      
    return $products;
}

    
    protected function sortByAndPaginate($products,Request $request){
        $sortBy = $request->input('sort_by') ?? 'latest';
        
        switch ($sortBy) {
            case 'latest':
                $products = $products->orderByDesc('id');
                break;
            case 'oldest':
                $products = $products->orderBy('id');
                break;
            case 'price-ascending':
                $products = $products->orderBy('price');
                break;
            case 'price-desending':
                $products = $products->orderByDesc('price');
                break;
            
            default: $products = $products->orderByDesc('id');
        }

        $perPage = $request->input('show') ?? '9';

        $products = $products->paginate($perPage);
        $products->appends(['sort_by' => $sortBy , 'show' => $perPage]);
      //  dd($products);
        return $products;
        
    }

    public function contact(){
        return view('frontend.contact');
    }
    public function aboutus()
    {
        $teamMembers = [
            [
                'name' => 'Ngô Văn Minh',
                'position' => '',
                'bio' => '.',
                'image' => 'no-avatar.png'
            ],
            [
                'name' => 'Phạm Bảo Anh',
                'position' => '',
                'bio' => '.',
                'image' => 'no-avatar.png'
            ],
            [
                'name' => 'Lê Hùng Dũng',
                'position' => '',
                'bio' => '.',
                'image' => 'no-avatar.png'
            ],
            [
                'name' => 'Nguyễn Diệu Hương',
                'position' => '',
                'bio' => '.',
                'image' => 'no-avatar.png'
            ],
            [
                'name' => 'Hà Trọng Cường',
                'position' => '',
                'bio' => '',
                'image' => 'no-avatar.png'
            ],
        ];

        return view('frontend.aboutus', compact('teamMembers'));
    }
}
