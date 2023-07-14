<div>
    <div class="tile">
        <h3 class="tile-title">Upload Image</h3>
        <hr>
        <div class="tile-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-3">
                        <input wire:model="images" type="file" multiple class="form-control" >
                      </div>
                      @error('images')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                @error('images.*')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
                </div>
            </div>
            <div class="row d-print-none mt-2">
                <div class="col-12 text-right">
                    <button wire:click="upload({{$product->id}})" class="btn btn-success" type="button" id="uploadButton">
                        <i class="fa fa-fw fa-lg fa-upload"></i>Upload Images
                    </button>
                </div>
                

            </div>
            @if ($product->images)
                <hr>
                <div class="row">
                    @foreach($product->images as $image)
                        <div class="col-md-3">
                            <div class="card my-3">
                                <div class="card-body">
                                    <img src="{{ asset('storage/'.$image->full) }}" id="brandLogo" class="img-fluid" alt="img">
                                    <a wire:click="delete({{$image->id}})" type="button" class="card-link float-right text-danger" >
                                        <i class="fa fa-fw fa-lg fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>