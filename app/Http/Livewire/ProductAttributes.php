<?php

namespace App\Http\Livewire;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Product;
use App\Models\ProductAttribute;
use Livewire\Component;

class ProductAttributes extends Component
{
    public $product_id, $selectedAttribute_id = 0, $value_name , $values = [], $qty, $price;
    
    public function render()
    {
        $attributes = Attribute::all()->load('values');
        $product = Product::find($this->product_id)->load('attributes');
        return view('livewire.product-attributes', compact('attributes', 'product'));
    }

    public function updateValues()
    {

        if ($this->selectedAttribute_id != 0){
            $selectedAttribute = Attribute::find($this->selectedAttribute_id)->load('values');
            $this->values = $selectedAttribute->values;
        }
    }

    public function resetFields()
    {
        $this->qty = '';
        $this->price = '';
        $this->selectedAttribute_id = 0;
        $this->value_name = 0;
    }

    public function addAttribute(Product $product) 
    {
        $validatedData = $this->validate([
            'selectedAttribute_id' =>'required',
            'qty' => 'nullable|integer|numeric',
            'price' => 'nullable|integer|numeric',
        ]);
        $productAttribute = $product->attributes()->create([
            'value' => $this->value_name,
            'price' => $this->price,
            'quantity' => $this->qty,
            'attribute_id' => $this->selectedAttribute_id,
        ]);
        if ($productAttribute){
            session()->flash('message', 'Product Attribute Created Successfully.');
        } else {
            session()->flash('error', 'Product Attribute Failes, Please Try Again.');
        }
        $this->resetFields();

    }

    public function deleteAttribute(ProductAttribute $attribute)
    {
        $attribute->delete();
        session()->flash('message', 'Product Attribute Deleted Successfully.');
    }
}
