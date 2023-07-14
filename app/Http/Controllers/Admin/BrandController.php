<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Brand;
use App\Traits\UploadAble;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use InvalidArgumentException;

class BrandController extends BaseController
{
    use UploadAble;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->setPageTitle('Brands', 'List of all brands');
        $brands = Brand::all();
        return view('admin.brands.index', compact('brands'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->setPageTitle('Brands', 'Create brand');
        $brands = Brand::all();
        return view('admin.brands.create', compact('brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'name'      =>  'required|max:191',
            'logo'     =>  'mimes:jpg,jpeg,png|max:1000'    
        ]);


        try {
            $attributes = collect($request);
            $logo = null;


            if ($attributes->has('logo') && $attributes['logo'] instanceof UploadedFile) {
                $logo = $this->uploadOne($attributes['logo'], 'brands');
            }
    
    
            $merge = $attributes->merge(compact('logo'));
    
            $brand = Brand::create($merge->all());

            if (!$brand) {
                return $this->responseRedirectBack('Error occurred while creating brand.', 'error', true, true);
            }
            return $this->responseRedirect('admin.brands.index', 'Brand added successfully' ,'success',false, false);
        
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
    public function edit(Brand $brand)
    {
        $brands = Brand::all();

        $this->setPageTitle('Brands', 'Edit Brand : '.$brand->name);
        return view('admin.brands.edit', compact('brands', 'brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        $attributes = $request->validate([
            'name'      =>  'required|max:191',
            'logo'     =>  'mimes:jpg,jpeg,png|max:1000'    
        ]);


        try {
            $attributes = collect($request);
            $logo = null;


            if ($attributes->has('logo') && $attributes['logo'] instanceof UploadedFile) {
                if ($brand->logo != null) {
                    $this->deleteOne($brand->logo);
                }
                $logo = $this->uploadOne($attributes['logo'], 'brands');
            }
        
            $merge = $attributes->merge(compact('logo'));
    
            $brand->update($merge->all());

            if (!$brand) {
                return $this->responseRedirectBack('Error occurred while updating brand.', 'error', true, true);
            }
            return $this->responseRedirectBack('Brand updated successfully' ,'success',false, false);
                
        } catch (QueryException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        if ($brand->logo != null){
            $this->deleteOne($brand->logo);
        }

        $brand = $brand->delete();

        if (!$brand) {
            return $this->responseRedirectBack('Error occurred while deleting brand.', 'error', true, true);
        }
        return $this->responseRedirect('admin.brands.index', 'Brand deleted successfully' ,'success',false, false);
    

    }
}
