<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use App\Models\Brand;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {   
        $product_code = $request->input('product_code');

        $products = Product::when($product_code, function($query, $product_code){
                $query->where('product_code', $product_code);
            })
            ->orderByDesc('id')
            ->paginate(5);
        return view('admin.product.list', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.product.create', compact('categories','brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();
        $arrimages = $data['images'];
        DB::beginTransaction();
        try {
            unset($data['images']);
            $product = Product::create($data);
            $this->createProductImage($product,$arrimages);
            DB::commit();
            return redirect()->route('product.show', $product->id)->with('success', 'Thêm sản phẩm thành công.');
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('admin.product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('admin.product.edit', compact('product','categories','brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();
        DB::beginTransaction();
        try {
            unset($data['images']);
            $product->update($data);
            if($request->file('images')){
                $arrimages = $request->file('images');
                $this->createProductImage($product,$arrimages);
            }
            DB::commit();
            return redirect()->route('product.show', $product->id)->with('success', 'Cập nhật sản phẩm thành công.');
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return back()->with('success', 'Xóa sản phẩm thành công.');
    }

    protected function createProductImage($product, $arrimages){
        DB::beginTransaction();
        try {
            if($product->images){
               foreach($product->images as $image){
                    $image->delete();
               }
            }
            foreach($arrimages as $image){
                $productImage = new ProductImage();
                $productImage->product_id = $product->id;
                $productImage->image = $this->saveImage($image);
                $productImage->save();
            }
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            throw $e;
        }
    }

    protected function saveImage($image){
        $imageName = $image->hashName();
        $res = $image->storeAs('products', $imageName, 'public');
        if($res){
            $path = 'products/'. $imageName;
        } 
        return $path;

    }
}
