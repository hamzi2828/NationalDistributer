<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="Add More Stock Products"
     aria-hidden="true" data-bs-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-top modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Add More Stock Products</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" action="{{ route ('stocks.add-more-products', ['stock' => $stock -> id]) }}">
                @csrf
                <div class="modal-body">
                    <div class="col-md-12">
                        <label class="col-form-label font-small-4">Products</label>
                        <select id="stock-add-products" name="product[]"
                                class="form-control select2 add-stock-products"
                                required="required" data-placeholder="Select"
                                multiple="multiple">
                            <option></option>
                            @if(count ($stock_products))
                                @foreach($stock_products as $key => $product)
                                    <option value="{{ $product -> id }}" @if(old ('product'))
                                        @selected(in_array ($product -> id, old ('product')))
                                            @endif>
                                        {{ $product -> productTitle() }}
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary me-1">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>