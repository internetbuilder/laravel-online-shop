<div>
    @if (session()->has('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
    @endif
    @if (session()->has('error'))
    @foreach (session('error') as $err)
    <div class="alert alert-danger">
        {{ $err }}
    </div>
    @endforeach
    
    @endif
    <div class="tile">
        <h3 class="tile-title">Product Attributes</h3>
        <div class="tile-body">
            <div class="tile">
                <h3 class="tile-title">Attributes</h3>
                <hr>
                <div class="tile-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="parent">Select an Attribute <span class="m-l-5 text-danger"> *</span></label>
                                <select id=parent class="form-control custom-select mt-15" wire:model="selectedAttribute_id" wire:change="updateValues()">
                                    <option value=0 selected > Select Attribute </option>
                                        @foreach ($attributes as $att)
                                            <option value="{{ $att->id }}" > {{ $att->name }} </option>
                                        @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if ($selectedAttribute_id != 0)
                <div class="tile" >
                    <h3 class="tile-title">Add Attributes To Product</h3>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="values">Select an value <span class="m-l-5 text-danger"> *</span></label>
                                <select id=values class="form-control custom-select mt-15" wire:model="value_name" >
                                    <option selected  > Select Value </option>
                                    @foreach ($values as $value)
                                        <option > {{ $value->value }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row" v-if="valueSelected">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="quantity">Quantity</label>
                                <input class="form-control" type="number" id="quantity" wire:model="qty"/>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="price">Price</label>
                                <input class="form-control" type="text" id="price" wire:model="price"/>
                                <small class="text-danger">This price will be added to the main price of product on frontend.</small>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <button class="btn btn-sm btn-primary" wire:click="addAttribute({{ $product->id }})">
                                <i class="fa fa-plus"></i> Add
                            </button>
                        </div>
                    </div>
                </div>   
            @endif
                        
            
            
            <div class="table-responsive">
                <table class="table table-sm">
                    <thead>
                    <tr class="text-center">
                        <th>Value</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($product->attributes as $at)
                        <tr>
                            <td style="width: 25%" class="text-center">{{ $at->value}}</td>
                            <td style="width: 25%" class="text-center">{{ $at->quantity}}</td>
                            <td style="width: 25%" class="text-center">{{ $at->price}}</td>
                            <td style="width: 25%" class="text-center">
                                <button class="btn btn-sm btn-danger" wire:click="deleteAttribute({{ $at->id }})">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
