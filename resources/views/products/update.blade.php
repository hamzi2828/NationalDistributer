<x-dashboard :title="$title">
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper p-0">
            <div class="content-body">
                <section id="basic-horizontal-layouts">
                    <div class="row">
                        <div class="col-md-12 col-md-12">
                            @include('errors.validation-errors')
                            <div class="card">
                                <div class="border-bottom-light card-header mb-2 pb-1 pb-1">
                                    <h4 class="card-title">{{ $title }}</h4>

                                    @can('variations', \App\Models\Product::class)
                                        @if(empty(trim ($product -> parent_id)))
                                            <a href="{{ route ('products.variations', ['product' => $product -> id]) }}"
                                               class="btn btn-danger">
                                                <i data-feather="sliders"></i>
                                                Product Variations
                                            </a>
                                        @endif
                                    @endcan
                                </div>
                                <form class="form" method="post" enctype="multipart/form-data"
                                      action="{{ route ('products.update', ['product' => $product -> id]) }}">
                                    @csrf
                                    @method('PUT')
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
                                                               value="{{ old ('title', $product -> title) }}" />
                                                    </div>

                                                    <div class="col-md-3 mb-1">
                                                        <label class="col-form-label font-small-4"
                                                               for="manufacturer">Category</label>
                                                        <select name="category-id" class="form-control select2"
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
                                                               for="manufacturer">Manufacturer</label>
                                                        <select name="manufacturer-id" class="form-control select2"
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
                                                    <div class="col-md-3 mb-1">
                                                        <label class="col-form-label font-small-4"
                                                               for="title">Tax</label>
                                                        <select name="tax_id" id="tax_id" class="form-control select2">
                                                            <option value="">Select Tax</option>
                                                            @foreach($taxes as $tax)
                                                                <option value="{{ $tax -> id }}" {{ old ('tax_id', $product -> tax_id) == $tax -> id ? 'selected' : '' }}>{{ $tax -> title }}</option>
                                                            @endforeach
                                                        </select>
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

                                        @if(optional ($settings -> settings) -> e_commerce == '1')
                                            @push('styles')
                                                <link rel="stylesheet"
                                                      href="{{ asset ('/file-upload/fileUpload.css') }}" />
                                                <style>
                                                    .product-image .image {
                                                        width               : 100%;
                                                        height              : 150px;
                                                        border-radius       : 5px;
                                                        border              : 1px solid #000;
                                                        background-size     : cover !important;
                                                        background-position : center center;
                                                        background-repeat   : no-repeat;
                                                        position            : relative;
                                                    }

                                                    .product-image a {
                                                        background    : rgba(0, 0, 0, 0.8);
                                                        color         : #fff !important;
                                                        padding       : 4px;
                                                        border-radius : 4px;
                                                        position      : absolute;
                                                        top           : 0;
                                                        right         : 0;
                                                    }

                                                    .ck-editor__editable_inline {
                                                        min-height : 400px;
                                                    }
                                                </style>
                                            @endpush
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <h2 class="mt-1 mb-1 text-danger fw-bolder border-bottom-danger">
                                                        E-Commerce Options</h2>
                                                </div>

                                                <div class="col-md-10">
                                                    <div class="row">
                                                        <div class="col-md-3 mb-1">
                                                            <label class="col-form-label font-small-4"
                                                                   for="slider-product">Slider Product</label>
                                                            <select name="slider-product" class="form-control"
                                                                    id="slider-product">
                                                                <option
                                                                        value="0" @selected(old ('slider-product', $product -> slider_product) == '0')>
                                                                    No
                                                                </option>
                                                                <option
                                                                        value="1"@selected(old ('slider-product', $product -> slider_product) == '1')>
                                                                    Yes
                                                                </option>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-3 mb-1">
                                                            <label class="col-form-label font-small-4"
                                                                   for="deal-of-the-day">Deal of The Day</label>
                                                            <select name="deal-of-the-day" class="form-control"
                                                                    id="deal-of-the-day">
                                                                <option
                                                                        value="0" @selected(old ('deal-of-the-day', $product -> deal_of_they_day) == '0')>
                                                                    No
                                                                </option>
                                                                <option
                                                                        value="1"@selected(old ('deal-of-the-day', $product -> deal_of_they_day) == '1')>
                                                                    Yes
                                                                </option>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-3 mb-1">
                                                            <label class="col-form-label font-small-4" for="featured">Featured</label>
                                                            <select name="featured" class="form-control" id="featured">
                                                                <option
                                                                        value="0" @selected(old ('featured', $product -> featured) == '0')>
                                                                    No
                                                                </option>
                                                                <option
                                                                        value="1"@selected(old ('featured', $product -> featured) == '1')>
                                                                    Yes
                                                                </option>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-3 mb-1">
                                                            <label class="col-form-label font-small-4"
                                                                   for="best-seller">Best Seller</label>
                                                            <select name="best-seller" class="form-control"
                                                                    id="best-seller">
                                                                <option
                                                                        value="0" @selected(old ('best-seller', $product -> best_seller) == '0')>
                                                                    No
                                                                </option>
                                                                <option
                                                                        value="1"@selected(old ('best-seller', $product -> best_seller) == '1')>
                                                                    Yes
                                                                </option>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-3 mb-1">
                                                            <label class="col-form-label font-small-4" for="popular">Popular</label>
                                                            <select name="popular" class="form-control" id="popular">
                                                                <option
                                                                        value="0" @selected(old ('popular', $product -> popular) == '0')>
                                                                    No
                                                                </option>
                                                                <option
                                                                        value="1"@selected(old ('popular', $product -> popular) == '1')>
                                                                    Yes
                                                                </option>
                                                            </select>
                                                        </div>

                                                        <div class="col-md-3 mb-1">
                                                            <label class="col-form-label font-small-4" for="discount">Discount
                                                                                                                      (%)</label>
                                                            <input type="number" name="discount" class="form-control"
                                                                   id="discount" min="0" max="100" step="any"
                                                                   value="{{ old ('discount', $product -> discount) }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-2 mb-1">
                                                    <div class="align-items-center border d-flex flex-column justify-content-center pt-50 rounded-2">
                                                        <div class="custom-avatar align-items-center d-flex flex-column justify-content-center">
                                                            <img
                                                                    src="{{ !empty(trim ($product -> slider_image)) ? asset ($product -> slider_image) : asset ('/assets/img/default-thumbnail.jpg') }}"
                                                                    class="rounded"
                                                                    alt="slider image"
                                                                    height="95%"
                                                                    width="95%"
                                                            />
                                                            <div class="mt-1 align-items-center d-flex flex-column justify-content-center">
                                                                <label for="slider-image"
                                                                       class="btn btn-sm btn-primary mb-75 me-25">Upload
                                                                                                                  Slider</label>
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
                                                    <label for="excerpt" class="col-form-label font-small-4">Short
                                                                                                             Description</label>
                                                    <textarea name="excerpt" class="form-control" id="excerpt"
                                                              rows="3">{{ request ('excerpt', $product -> excerpt) }}</textarea>
                                                </div>
                                            </div>

                                            <div class="row mb-2">
                                                <div class="col-lg-12">
                                                    <label class="w-100">
                                                        <textarea name="description" class="form-control" id="editor"
                                                                  rows="5">{{ request ('description', $product -> description) }}</textarea>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div id="fileUpload"></div>
                                                </div>
                                            </div>

                                            <div class="row mt-2">
                                                @if(count ($product -> product_images) > 0)
                                                    @foreach($product -> product_images as $productImage)
                                                        <div class="product-image col-md-3">
                                                            <div class="image"
                                                                 style="background: url('{{ $productImage -> image }}')">
                                                                <a href="{{ route ('products.delete-product-image', ['product_image' => $productImage -> id]) }}"
                                                                   onclick="return confirm('Are you sure?')">Delete</a>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
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
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary me-1">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-dashboard>
