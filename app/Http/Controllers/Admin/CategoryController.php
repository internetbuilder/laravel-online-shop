<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Category;
use App\Traits\UploadAble;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use InvalidArgumentException;

class CategoryController extends BaseController
{
    use UploadAble;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->setPageTitle('Categories', 'List of all categories');
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->setPageTitle('Categories', 'Create Category');
        $categories = Category::all();
        return view('admin.categories.create', compact('categories'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $attributes = $request->validate([
            'name'      =>  'required|max:191',
            'parent_id' =>  'required|not_in:0',
            'image'     =>  'mimes:jpg,jpeg,png|max:1000'    
        ]);


        try {
            $attributes = collect($request);
            $image = null;


            if ($attributes->has('image') && $attributes['image'] instanceof UploadedFile) {
                $image = $this->uploadOne($attributes['image'], 'categories');
            }
    
            $featured = $attributes->has('featured') ? 1 : 0;
            $menu = $attributes->has('menu') ? 1 : 0;
    
            $merge = $attributes->merge(compact('image', 'featured', 'menu'));
    
            $category = Category::create($merge->all());

            if (!$category) {
                return $this->responseRedirectBack('Error occurred while creating category.', 'error', true, true);
            }
            return $this->responseRedirect('admin.categories.index', 'Category added successfully' ,'success',false, false);
        
        } catch (QueryException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        echo 'show';
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        $categories = Category::all();

        $this->setPageTitle('Categories', 'Edit Category : '.$category->name);
        return view('admin.categories.edit', compact('categories', 'category'));
    
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $attributes = $request->validate([
            'name'      =>  'required|max:191',
            'parent_id' =>  'required|not_in:0',
            'image'     =>  'mimes:jpg,jpeg,png|max:1000'    
        ]);


        try {
            $attributes = collect($request);
            $image = null;


            if ($attributes->has('image') && $attributes['image'] instanceof UploadedFile) {
                if ($category->image != null) {
                    $this->deleteOne($category->image);
                }
                $image = $this->uploadOne($attributes['image'], 'categories');
            }
    
            $featured = $attributes->has('featured') ? 1 : 0;
            $menu = $attributes->has('menu') ? 1 : 0;
    
            $merge = $attributes->merge(compact('image', 'featured', 'menu'));
    
            $category->update($merge->all());

            if (!$category) {
                return $this->responseRedirectBack('Error occurred while updating category.', 'error', true, true);
            }
            return $this->responseRedirectBack('Category updated successfully' ,'success',false, false);
                
        } catch (QueryException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($category->image != null){
            $this->deleteOne($category->image);
        }

        $category = $category->delete();

        if (!$category) {
            return $this->responseRedirectBack('Error occurred while deleting category.', 'error', true, true);
        }
        return $this->responseRedirect('admin.categories.index', 'Category deleted successfully' ,'success',false, false);
    

    }

    
}
