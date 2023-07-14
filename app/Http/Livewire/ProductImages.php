<?php

namespace App\Http\Livewire;

use App\Models\Product;
use App\Models\ProductImage;
use App\Traits\UploadAble;
use Livewire\Component;
use Livewire\WithFileUploads;

class ProductImages extends Component
{
    use UploadAble;
    use WithFileUploads;

    public $images = [];
    public $product_id;

    protected $rules = [
        'images' => 'required|array',
        'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
    ]; 


    public function render()
    {

        $product = Product::find($this->product_id)->load('images');


        return view('livewire.product-images', [
            'product' => $product,
        ]);
    }

    public function upload(Product $product)
    {
        $this->validate();

        foreach ($this->images as $image){
            $uploadedImage = $this->uploadOne($image, 'products');
            $product->images()->create([
                'full' => $uploadedImage,
            ]);
        };
        $this->images = [];
        return response()->json(['status' => 'Success']);

    }

    public function delete(ProductImage $image)
    {

        if ($image->full != '') {
            $this->deleteOne($image->full);
        }
        $image->delete();
    
        return redirect()->back();

    }
    

}
