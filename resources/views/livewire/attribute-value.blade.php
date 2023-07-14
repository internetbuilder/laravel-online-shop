<div>
     <div>
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
        @if (session()->has('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    </div>

    <div class="tile">
        <h3 class="tile-title">Attribute Values</h3>
        <hr>
        <div class="tile-body">
            <div class="form-group">
                <label class="control-label" for="value">Value</label>
                <input
                    class="form-control"
                    type="text"
                    placeholder="Enter attribute value"
                    id="value"
                    wire:model="value"
                />
                @error('value')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
            </div>
            <div class="form-group">
                <label  class="control-label" for="price">Price</label>
                <input
                    class="form-control"
                    wire:model="price"
                    type="number"
                    placeholder="Enter attribute value price"
                    id="price"
                />
                @error('price')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
            </div>
        </div>
        <div class="tile-footer">
            <div class="row d-print-none mt-2">
                <div class="col-12 text-right">
                    @if ($updateMode === false);
                        <button class="btn btn-success" type="submit" wire:click="store()" >
                            <i class="fa fa-fw fa-lg fa-check-circle"></i>Save
                        </button>                        
                    @endif
                    @if ($updateMode === true)
                        <button class="btn btn-success" type="submit" wire:click="update()" >
                            <i class="fa fa-fw fa-lg fa-check-circle"></i>Update
                        </button>
                        <button class="btn btn-primary" type="submit" wire:click="resetValues()">
                            <i class="fa fa-fw fa-lg fa-check-circle"></i>Reset
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div id="">
        <div class="tile">
            <h3 class="tile-title">Option Values</h3>
            <div class="tile-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                        <tr class="text-center">
                            <th>#</th>
                            <th>Value</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($values as $value)
                            <tr>
                                <td style="width: 25%" class="text-center">{{ $value->id}}</td>
                                <td style="width: 25%" class="text-center">{{ $value->value}}</td>
                                <td style="width: 25%" class="text-center">{{ $value->price}}</td>
                                <td style="width: 25%" class="text-center">
                                    <button wire:click="edit({{ $value->id }})" class="btn btn-sm btn-primary">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button wire:click="delete({{$value->id}})"  class="btn btn-sm btn-danger">
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
        
</div>
