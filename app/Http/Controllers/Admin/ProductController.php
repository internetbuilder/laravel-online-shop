<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\StoreProductFormRequest;
use App\Http\Requests\UpdateProductFormRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Traits\UploadAble;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use InvalidArgumentException;

class ProductController extends BaseController
{
    use UploadAble;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->setPageTitle('Products', 'List of all products');
        $products = Product::all()->load('categories');
        return view('admin.products.index', compact('products'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->setPageTitle('Products', 'Create Product');
        $products = Product::all();
        $brands = Brand::all();
        $categories = Category::all();
        return view('admin.products.create', compact('products', 'brands', 'categories'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductFormRequest $request)
    {

        try {
            $collection = collect($request->validated());

            $featured = $request->has('featured') ? 1 : 0;
            $status = $request->has('status') ? 1 : 0;
    
            $merge = $collection->merge(compact('featured', 'status'));
    
            $product = Product::create($merge->all());

            if ($collection->has('categories')) {
                $product->categories()->sync($collection['categories']);
            }

            if (!$product) {
                return $this->responseRedirectBack('Error occurred while creating product.', 'error', true, true);
            }
            return $this->responseRedirect('admin.products.index', 'Product added successfully' ,'success',false, false);
        
        } catch (QueryException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $brands = Brand::all();
        $product = $product->load('brand', 'categories');

        $this->setPageTitle('Products', 'Edit Product : '.$product->name);
        return view('admin.products.edit', compact('categories', 'brands', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreProductFormRequest $request, Product $product)
    {
        try {
            $collection = collect($request->validated());

            $featured = $request->has('featured') ? 1 : 0;
            $status = $request->has('status') ? 1 : 0;
    
            $merge = $collection->merge(compact('featured', 'status'));

            $product->update($merge->all());

            if ($collection->has('categories')) {
                $product->categories()->sync($collection['categories']);
            }

            if (!$product) {
                return $this->responseRedirectBack('Error occurred while updating product.', 'error', true, true);
            }
            return $this->responseRedirectBack('Product updated successfully' ,'success',false, false);
                
        } catch (QueryException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {

        $product = $product->delete();

        if (!$product) {
            return $this->responseRedirectBack('Error occurred while deleting product.', 'error', true, true);
        }
        return $this->responseRedirect('admin.products.index', 'Product deleted successfully' ,'success',false, false);
    

    }
}
