<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="Add More Stock Products"
     aria-hidden="true" data-bs-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-top modal-xl">
        <div class="modal-content">
            <div class="modal-header mb-2">
                <h5 class="modal-title" id="exampleModalCenterTitle">Add Product
                                                                     ({{ str () -> title ($request -> type) }})</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            @if($request -> input('type') == 'simple')
                <form class="form" method="post" enctype="multipart/form-data" id="addNewProduct"
                      onsubmit="submitAddNewProductForm(event, '{{ route ('products.store') }}', this)">
                    @csrf
                    
                    @include('products.simple-product-form')
                    <div class="card-footer border-top">
                        <button type="submit" class="btn btn-primary me-1">Submit</button>
                    </div>
                </form>
            @else
                <form class="form" method="post" enctype="multipart/form-data" id="addNewProduct"
                      onsubmit="submitAddNewProductForm(event, '{{ route ('products.store.variable') }}', this)">
                    @csrf
                    
                    @include('products.variable-product-form')
                    <div class="card-footer border-top">
                        <button type="submit" class="btn btn-primary me-1">Submit</button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>