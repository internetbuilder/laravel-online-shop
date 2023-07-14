<?php

namespace App\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Models\Category;
use App\Traits\UploadAble;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use InvalidArgumentException;

class CategoryController extends BaseController
{

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {   
        $category->load('products', 'products.images', 'products.attributes');
        return view('site.pages.category', compact('category'));
    }

    
}
