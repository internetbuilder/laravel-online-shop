<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Models\Attribute;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use InvalidArgumentException;

class AttributeController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->setPageTitle('Attributes', 'List of all attributes');
        $attributes = Attribute::all();
        return view('admin.attributes.index', compact('attributes'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->setPageTitle('Attributes', 'Create Attribute');
        return view('admin.attributes.create');
    
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $attributes = $request->validate([
            'code'          =>  'required',
            'name'          =>  'required',
            'frontend_type' =>  'required'   
        ]);


        try {


            $collection = collect($request)->except('_token');


            $is_filterable = $collection->has('is_filterable') ? 1 : 0;
            $is_required = $collection->has('is_required') ? 1 : 0;
            $merge = $collection->merge(compact('is_required', 'is_filterable'));


            $attribute = Attribute::create($merge->all());

            if (!$attribute) {
                return $this->responseRedirectBack('Error occurred while creating attribute.', 'error', true, true);
            }
            return $this->responseRedirect('admin.attributes.index', 'Attribute added successfully' ,'success',false, false);
                
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
    public function edit(Attribute $attribute)
    {
        $attributes = Attribute::all();

        $this->setPageTitle('Attributes', 'Edit Attribute : '.$attribute->name);
        return view('admin.attributes.edit', compact('attributes', 'attribute'));
    

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attribute $attribute)
    {
        $attributes = $request->validate([
            'code'          =>  'required',
            'name'          =>  'required',
            'frontend_type' =>  'required'   
        ]);


        try {
            $attributes = collect($request);

    
            $is_filterable = $attributes->has('is_filterable') ? 1 : 0;
            $is_required = $attributes->has('is_required') ? 1 : 0;
    
            $merge = $attributes->merge(compact('is_required', 'is_filterable'));
    
            $attribute = $attribute->update($merge->all());

            if (!$attribute) {
                return $this->responseRedirectBack('Error occurred while updating attribute.', 'error', true, true);
            }
            return $this->responseRedirectBack('Attribute updated successfully' ,'success',false, false);
                        
        } catch (QueryException $e) {
            throw new InvalidArgumentException($e->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attribute $attribute)
    {
        $attribute = $attribute->delete();

        if (!$attribute) {
            return $this->responseRedirectBack('Error occurred while deleting attribute.', 'error', true, true);
        }
        return $this->responseRedirect('admin.attributes.index', 'Attribute deleted successfully' ,'success',false, false);        

    }

    
}
