<input type="hidden" name="product-type" value="variable">
<div class="card-body pt-0">
    
    <div class="row">
        <div class="col-md-10 mb-1">
            <div class="row">
                <div class="col-md-6 mb-1">
                    <label class="col-form-label font-small-4"
                           for="title">Title</label>
                    <input type="text" id="title" class="form-control"
                           required="required" autofocus="autofocus"
                           name="title" placeholder="Product Title"
                           value="{{ old ('title') }}" />
                </div>
                
                <div class="col-md-3 mb-1">
                    <label class="col-form-label font-small-4"
                           for="manufacturer">Category</label>
                    <select name="category-id" class="form-control select2"
                            required="required" data-placeholder="Select">
                        <option></option>
                        @if(count ($categories) > 0)
                            @foreach($categories as $category)
                                <option value="{{ $category -> id }}" @selected(old ('category-id') == $category -> id)>
                                    {{ $category -> title }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
                
                <div class="col-md-3 mb-1">
                    <label class="col-form-label font-small-4"
                           for="manufacturer">Manufacturer</label>
                    <select name="manufacturer-id" class="form-control select2"
                            required="required" data-placeholder="Select">
                        <option></option>
                        @if(count ($manufacturers) > 0)
                            @foreach($manufacturers as $manufacturer)
                                <option value="{{ $manufacturer -> id }}" @selected(old ('manufacturer-id') == $manufacturer -> id)>
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
                           for="manufacturer">Attribute</label>
                    <select name="attribute-id"
                            onchange="fetch_attribute_terms(this.value)"
                            class="form-control select2"
                            required="required" data-placeholder="Select">
                        <option></option>
                        @if(count ($attributes) > 0)
                            @foreach($attributes as $attribute)
                                <option value="{{ $attribute -> id }}"
                                        class="ps-1" @selected(old ('attribute-id') == $attribute -> id)>
                                    {{ $attribute -> title }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
                
                <div class="col-md-3 mb-1">
                    <label class="col-form-label font-small-4"
                           for="manufacturer">Term</label>
                    <select id="terms-dropdown" name="term-id"
                            class="form-control select2"
                            required="required" data-placeholder="Select">
                        <option></option>
                    </select>
                </div>
                
                <div class="col-md-3 mb-1">
                    <label class="col-form-label font-small-4"
                           for="sku">SKU</label>
                    <input type="text" id="sku" class="form-control"
                           required="required"
                           onchange="validateSKU(this.value, '{{ route('products.validate-sku') }}')"
                           name="sku" placeholder="SKU"
                           value="{{ old ('sku') }}" />
                </div>
                
                <div class="col-md-3 mb-1">
                    <label class="col-form-label font-small-4"
                           for="barcode">Barcode</label>
                    <input type="text" id="barcode" class="form-control"
                           name="barcode" placeholder="Barcode"
                           onchange="validateBarcode(this.value, '{{ route('products.validate-barcode') }}')"
                           value="{{ old ('barcode') }}" />
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-3 mb-1">
                    <label class="col-form-label font-small-4"
                           for="title">Threshold</label>
                    <input type="number" id="title" class="form-control"
                           required="required"
                           name="threshold" placeholder="Threshold"
                           value="{{ old ('threshold') }}" />
                </div>
                
                <div class="col-md-3 mb-1">
                    <label class="col-form-label font-small-4"
                           for="title">TP/Box</label>
                    <input type="number" id="title" class="form-control tp-box"
                           required="required" onchange="calculate_tp_unit_price()"
                           name="tp-box" placeholder="TP/Box" step="any"
                           value="{{ old ('tp-box') }}" />
                </div>
                
                <div class="col-md-3 mb-1">
                    <label class="col-form-label font-small-4"
                           for="title">Pack Size</label>
                    <input type="number" id="title" class="form-control quantity"
                           required="required" onchange="calculate_tp_unit_price()"
                           name="pack-size" placeholder="Pack Size"
                           value="{{ old ('pack-size') }}" />
                </div>
                
                <div class="col-md-3 mb-1">
                    <label class="col-form-label font-small-4"
                           for="title">TP/Unit</label>
                    <input type="number" id="title" class="form-control tp-unit"
                           required="required" step="any"
                           onchange="increaseSalePrice()"
                           name="tp-unit" placeholder="TP/Unit"
                           value="{{ old ('tp-unit') }}" />
                </div>
            </div>
            
            <div class="row">
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
                           required="required" step="any"
                           onchange="calculate_sale_unit_price()"
                           name="sale-box" placeholder="Sale/Box"
                           value="{{ old ('sale-box') }}" />
                </div>
                
                <div class="col-md-3 mb-1">
                    <label class="col-form-label font-small-4"
                           for="title">Sale/Unit</label>
                    <input type="number" id="title" class="form-control sale-unit"
                           required="required" step="any"
                           name="sale-unit" placeholder="Sale/Unit"
                           value="{{ old ('sale-unit') }}" />
                </div>
            </div>
        </div>
        
        <div class="col-md-2 mb-1">
            <div class="align-items-center border d-flex flex-column justify-content-center pt-50 rounded-2">
                <div class="custom-avatar">
                    <img
                            src="{{ asset ('/assets/img/default-thumbnail.jpg') }}"
                            id="account-upload-img"
                            class="uploadedAvatar rounded"
                            alt="profile image"
                            height="150"
                            width="150"
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
    
    @if(optional ($settings -> settings) -> e_commerce == '1')
        @push('styles')
            <link rel="stylesheet" href="{{ asset ('/file-upload/fileUpload.css') }}" />
            <style>
                .ck-editor__editable_inline {
                    min-height : 400px;
                }
            </style>
        @endpush
        <div class="row">
            <div class="col-lg-12">
                <h2 class="mt-1 mb-1 text-danger fw-bolder border-bottom-danger">E-Commerce Options</h2>
            </div>
            
            <div class="col-md-10">
                <div class="row">
                    <div class="col-md-3 mb-1">
                        <label class="col-form-label font-small-4" for="slider-product">Slider Product</label>
                        <select name="slider-product" class="form-control" id="slider-product">
                            <option
                                    value="0" @selected(old ('slider-product') == '0')>
                                No
                            </option>
                            <option
                                    value="1"@selected(old ('slider-product') == '1')>
                                Yes
                            </option>
                        </select>
                    </div>
                    
                    <div class="col-md-3 mb-1">
                        <label class="col-form-label font-small-4" for="deal-of-the-day">Deal of The Day</label>
                        <select name="deal-of-the-day" class="form-control" id="deal-of-the-day">
                            <option
                                    value="0" @selected(old ('deal-of-the-day') == '0')>
                                No
                            </option>
                            <option
                                    value="1"@selected(old ('deal-of-the-day') == '1')>
                                Yes
                            </option>
                        </select>
                    </div>
                    
                    <div class="col-md-3 mb-1">
                        <label class="col-form-label font-small-4" for="featured">Featured</label>
                        <select name="featured" class="form-control" id="featured">
                            <option
                                    value="0" @selected(old ('featured') == '0')>
                                No
                            </option>
                            <option
                                    value="1"@selected(old ('featured') == '1')>
                                Yes
                            </option>
                        </select>
                    </div>
                    
                    <div class="col-md-3 mb-1">
                        <label class="col-form-label font-small-4" for="best-seller">Best Seller</label>
                        <select name="best-seller" class="form-control" id="best-seller">
                            <option
                                    value="0" @selected(old ('best-seller') == '0')>
                                No
                            </option>
                            <option
                                    value="1"@selected(old ('best-seller') == '1')>
                                Yes
                            </option>
                        </select>
                    </div>
                    
                    <div class="col-md-3 mb-1">
                        <label class="col-form-label font-small-4" for="popular">Popular</label>
                        <select name="popular" class="form-control" id="popular">
                            <option
                                    value="0" @selected(old ('popular') == '0')>
                                No
                            </option>
                            <option
                                    value="1"@selected(old ('popular') == '1')>
                                Yes
                            </option>
                        </select>
                    </div>
                    
                    <div class="col-md-3 mb-1">
                        <label class="col-form-label font-small-4" for="discount">Discount (%)</label>
                        <input type="number" name="discount" class="form-control" id="discount" min="0" max="100"
                               value="{{ old ('discount', 0) }}" step="any">
                    </div>
                </div>
            </div>
            
            <div class="col-md-2 mb-1">
                <div class="align-items-center border d-flex flex-column justify-content-center pt-50 rounded-2">
                    <div class="custom-avatar align-items-center d-flex flex-column justify-content-center">
                        <img
                                src="{{ asset ('/assets/img/default-thumbnail.jpg') }}"
                                class="rounded"
                                alt="slider image"
                                height="150"
                                width="150"
                        />
                        <div class="mt-1 align-items-center d-flex flex-column justify-content-center">
                            <label for="slider-image"
                                   class="btn btn-sm btn-primary mb-75 me-25">Upload Slider</label>
                            <input type="file" id="slider-image" hidden="hidden"
                                   name="slider-image"
                                   accept="image/*" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row mb-2">
            <div class="col-lg-12">
                <label for="excerpt" class="col-form-label font-small-4">Short Description</label>
                <textarea name="excerpt" class="form-control" id="excerpt"
                          rows="3">{{ request ('excerpt') }}</textarea>
            </div>
        </div>
        
        <div class="row mb-2">
            <div class="col-lg-12">
                <label class="w-100">
                    <textarea name="description" class="form-control" id="editor"
                              rows="5">{{ request ('description') }}</textarea>
                </label>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-12">
                <div id="fileUpload"></div>
            </div>
        </div>
        @push('scripts')
            <script src="{{ asset ('/file-upload/fileUpload.js') }}"></script>
            <script type="text/javascript">
                $ ( "#fileUpload" ).fileUpload ();
                
                ClassicEditor
                    .create ( document.querySelector ( '#editor' ), {
                        toolbar: [
                            'heading', 'strikethrough', 'subscript', 'superscript', 'code',
                            '|', 'bold', 'italic', 'link', 'undo', 'redo', 'numberedList', 'bulletedList', 'outdent', 'indent',
                            '|', 'fontfamily', 'fontsize', 'fontColor', 'fontBackgroundColor',
                        ]
                    } )
                    .then ( editor => {
                        window.editor = editor;
                    } )
                    .catch ( err => {
                        console.error ( err.stack );
                    } );
            </script>
        @endpush
    @endif
</div>