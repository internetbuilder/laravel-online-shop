<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Http\Requests\StoreProductFormRequest;
use App\Http\Requests\UpdateProductFormRequest;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Traits\UploadAble;
use Darryldecode\Cart\Facades\CartFacade;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use InvalidArgumentException;

class ProductController extends BaseController
{
   

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product = $product->load('images', 'attributes', 'brand', 'categories');
        $attributes = Attribute::all();
        return view('site.pages.product', compact('product', 'attributes'));
    }

    public function addToCart(Request $request)
    {
        $product = Product::find($request->input('productId'));
        $options = $request->except('_token', 'productId', 'price', 'qty');
    
        CartFacade::add(uniqid(), $product->name, $request->input('price'), $request->input('qty'), $options);
    
        return redirect()->back()->with('message', 'Item added to cart successfully.');
    }

    
}
