<?php

namespace App\Http\Livewire;

use App\Models\AttributeValue as ModelsAttributeValue;
use Illuminate\Http\Request;
use Livewire\Component ;

class AttributeValue extends Component
{
    public  $attribute_id, $value, $price, $valueRecord;
    public $updateMode = false;

    public function render()
    {
        $values = ModelsAttributeValue::where('attribute_id', $this->attribute_id)->get();
        return view('livewire.attribute-value', compact('values'));
    }
    /**
     * Reseting all inputted fields
     * @return void
     */
    public function resetValues(){
        $this->value = '';
        $this->price = null;

        $this->updateMode = false;


    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function store(Request $request)
    {
        if ($this->updateMode === false){
            $validatedData = $this->validate([
                'value' => 'required',
                'price' => 'nullable|integer|numeric',
            ]);

            ModelsAttributeValue::create([
                'value' => $this->value,
                'price' => $this->price,
                'attribute_id' => $this->attribute_id,
    
                ]);
      
            session()->flash('message', 'Value Created Successfully.');
      
            $this->resetValues();
        } else {
            session()->flash('error', 'Press Update To Update This Record Or Press Reset Button To Add New Record.');
        }
        
    }
        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function edit(ModelsAttributeValue $value)
    {

        $this->value = $value->value;
        $this->price = $value->price;
        $this->valueRecord = $value;
  
        $this->updateMode = true;
    }
     
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function update()
    {
        if ($this->updateMode === true){

            $value = $this->valueRecord;
            $validatedDate = $this->validate([
                'value' => 'required',
                'price' => 'nullable|integer|numeric',
            ]);
    
            $value->value = $validatedDate['value'];
            $value->price = $validatedDate['price'];

            $value->save();
    
            $this->updateMode = false;
    
            session()->flash('message', 'Value Updated Successfully.');
            $this->resetValues();
        } else {
            session()->flash('error', 'Choose The Value You Need To Update Or Press Save To Add New Record.');
        }
    }
        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function delete(ModelsAttributeValue $value)
    {
    
        $value->delete();
        session()->flash('message', 'Value Deleted Successfully.');
    }

   

}
