<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="Add Product Variations"
     aria-hidden="true" data-bs-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-top modal-xl">
        <div class="modal-content">
            <div class="modal-header mb-2">
                <h5 class="modal-title" id="exampleModalCenterTitle">
                    Edit Product
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="form" method="post" enctype="multipart/form-data"
                  action="{{ route ('products.quick-update', ['product' => $product -> id]) }}">
                @csrf
                @method('PUT')
                <div class="card-body pt-0 pb-0">
                    <div class="row">
                        <div class="col-md-10 mb-1">
                            <div class="row">
                                <div class="col-md-6 mb-1">
                                    <label class="col-form-label font-small-4"
                                           for="title">Title</label>
                                    <input type="text" id="title" class="form-control"
                                           required="required" autofocus="autofocus"
                                           name="title" placeholder="Product Title"
                                           value="{{ old ('title', $product -> title) }}" />
                                </div>
                                
                                <div class="col-md-3 mb-1">
                                    <label class="col-form-label font-small-4"
                                           for="category-id">Category</label>
                                    <select name="category-id" class="form-control select2" id="category-id"
                                            required="required" data-placeholder="Select">
                                        <option></option>
                                        @if(count ($categories) > 0)
                                            @foreach($categories as $category)
                                                <option value="{{ $category -> id }}" @selected(old ('category-id', $product -> category_id) == $category -> id)>
                                                    {{ $category -> title }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                
                                <div class="col-md-3 mb-1">
                                    <label class="col-form-label font-small-4"
                                           for="manufacturer-id">Manufacturer</label>
                                    <select name="manufacturer-id" class="form-control select2" id="manufacturer-id"
                                            required="required" data-placeholder="Select">
                                        <option></option>
                                        @if(count ($manufacturers) > 0)
                                            @foreach($manufacturers as $manufacturer)
                                                <option value="{{ $manufacturer -> id }}" @selected(old ('manufacturer-id', $product -> manufacturer_id) == $manufacturer -> id)>
                                                    {{ $manufacturer -> title }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-3 mb-1">
                                    <label class="col-form-label font-small-4"
                                           for="title">SKU</label>
                                    <input type="text" id="title" class="form-control"
                                           required="required"
                                           name="sku" placeholder="SKU"
                                           value="{{ old ('sku', $product -> sku) }}" />
                                </div>
                                
                                <div class="col-md-3 mb-1">
                                    <label class="col-form-label font-small-4"
                                           for="title">Barcode</label>
                                    <input type="text" id="title" class="form-control"
                                           name="barcode" placeholder="Barcode"
                                           value="{{ old ('barcode', $product -> barcode) }}" />
                                </div>
                                
                                <div class="col-md-3 mb-1">
                                    <label class="col-form-label font-small-4"
                                           for="title">Threshold</label>
                                    <input type="number" id="title" class="form-control"
                                           required="required"
                                           name="threshold" placeholder="Threshold"
                                           value="{{ old ('threshold', $product -> threshold) }}" />
                                </div>
                                
                                <div class="col-md-3 mb-1">
                                    <label class="col-form-label font-small-4"
                                           for="title">TP/Box</label>
                                    <input type="number" id="title" class="form-control tp-box"
                                           required="required"
                                           name="tp-box" placeholder="TP/Box" step="0.01"
                                           value="{{ old ('tp-box', $product -> tp_box) }}" />
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-3 mb-1">
                                    <label class="col-form-label font-small-4"
                                           for="title">Pack Size</label>
                                    <input type="number" id="title" class="form-control quantity"
                                           required="required"
                                           name="pack-size" placeholder="Pack Size"
                                           value="{{ old ('pack-size', $product -> pack_size) }}" />
                                </div>
                                
                                <div class="col-md-3 mb-1">
                                    <label class="col-form-label font-small-4"
                                           for="title">TP/Unit</label>
                                    <input type="number" id="title" class="form-control tp-unit"
                                           required="required" step="0.01"
                                           onchange="increaseSalePrice()"
                                           name="tp-unit" placeholder="TP/Unit"
                                           value="{{ old ('tp-unit', $product -> tp_unit) }}" />
                                </div>
                                
                                <div class="col-md-3 mb-1">
                                    <label class="col-form-label font-small-4"
                                           for="sale-increase">Sale Increase (%)</label>
                                    <input type="number" id="sale-increase" class="form-control"
                                           required="required" min="0"
                                           onchange="increaseSalePrice()"
                                           placeholder="Sale Increase"
                                           value="{{ old ('sale-increase', '0') }}" />
                                </div>
                                
                                <div class="col-md-3 mb-1">
                                    <label class="col-form-label font-small-4"
                                           for="title">Sale/Box</label>
                                    <input type="number" id="title" class="form-control sale-box"
                                           required="required" step="0.01"
                                           onchange="calculate_sale_unit_price()"
                                           name="sale-box" placeholder="Sale/Box"
                                           value="{{ old ('sale-box', $product -> sale_box) }}" />
                                </div>
                                
                                <div class="col-md-3 mb-1">
                                    <label class="col-form-label font-small-4"
                                           for="title">Sale/Unit</label>
                                    <input type="number" id="title" class="form-control sale-unit"
                                           required="required" step="0.01"
                                           name="sale-unit" placeholder="Sale/Unit"
                                           value="{{ old ('sale-unit', $product -> sale_unit) }}" />
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-2 mb-1">
                            <div class="align-items-center border d-flex flex-column justify-content-center pt-50 rounded-2">
                                <div class="custom-avatar align-items-center d-flex flex-column justify-content-center">
                                    <img
                                            src="{{ !empty(trim ($product -> image)) ? asset ($product -> image) : asset ('/assets/img/default-thumbnail.jpg') }}"
                                            id="account-upload-img"
                                            class="uploadedAvatar rounded"
                                            alt="profile image"
                                            height="95%"
                                            width="95%"
                                    />
                                    <div class="mt-1">
                                        <label for="account-upload"
                                               class="btn btn-sm btn-primary mb-75 me-25">Upload</label>
                                        <input type="file" id="account-upload" hidden="hidden"
                                               name="image"
                                               accept="image/*" />
                                        <button type="button" id="account-reset"
                                                class="btn btn-sm btn-outline-secondary mb-75">Reset
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer border-top">
                    <button type="submit" class="btn btn-primary me-1">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>