<div class="card mb-1">
    <div class="card-header border-bottom">
        <h5 class="card-title mb-0">Search</h5>
    </div>
    <div class="card-body mt-1">
        <form method="get" action="{{ request () -> fullUrl () }}">
            <div class="row">
                <div class="col-md-3 form-group">
                    <label class="col-form-label font-small-4" for="title">Title</label>
                    <input type="text" name="title" class="form-control" id="title"
                           value="{{ request ('title') }}">
                </div>

                <div class="col-md-3 form-group">
                    <label class="col-form-label font-small-4" for="sku">SKU</label>
                    <input type="text" name="sku" class="form-control" id="sku"
                           value="{{ request ('sku') }}">
                </div>
                <div class="col-md-3 form-group">
                    <label class="col-form-label font-small-4" for="barcode">Barcode</label>
                    <input type="text" name="barcode" class="form-control" id="barcode"
                           value="{{ request ('barcode') }}">
                </div>

                <div class="col-md-3 form-group">
                    <label class="col-form-label font-small-4" for="manufacturer-id">Manufacturer</label>
                    <select name="manufacturer-id" class="form-control select2" data-placeholder="Select"
                            data-allow-clear="true"
                            id="manufacturer-id">
                        <option></option>
                        @if(count ($manufacturers) > 0)
                            @foreach($manufacturers as $manufacturer)
                                <option value="{{ $manufacturer -> id }}"
                                        @selected(request ('manufacturer-id') == $manufacturer -> id)>
                                    {{ $manufacturer -> title }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="col-md-3 form-group">
                    <label class="col-form-label font-small-4" for="category-id">Category</label>
                    <select name="category-id" class="form-control select2" data-placeholder="Select"
                            data-allow-clear="true"
                            id="category-id">
                        <option></option>
                        {!! $categories !!}
                    </select>
                </div>

                <div class="col-md-3 form-group">
                    <label class="col-form-label font-small-4" for="rows">Rows</label>
                    <select name="rows" class="form-control select2" data-placeholder="Select"
                            data-allow-clear="true" id="rows">
                        <option></option>
                        <option value="100"
                                @selected(request ('rows') == '100')>100
                        </option>
                        <option value="200"
                                @selected(request ('rows') == '200')>200
                        </option>
                        <option value="300"
                                @selected(request ('rows') == '300')>300
                        </option>
                        <option value="400"
                                @selected(request ('rows') == '400')>400
                        </option>
                        <option value="500"
                                @selected(request ('rows') == '500')>500
                        </option>
                        <option value="10000000"
                                @selected(request ('rows') == '10000000')>All
                        </option>
                    </select>
                </div>


                <div class="col-md-3 form-group">
                    <label class="col-form-label font-small-4" for="tax-id">Tax</label>
                    <select name="tax-id" class="form-control select2" data-placeholder="Select"
                            data-allow-clear="true"
                            id="tax-id">
                        <option></option>
                        @if(isset ($taxes) && count ($taxes) > 0)
                            @foreach($taxes as $tax)
                                <option value="{{ $tax -> id }}"
                                        @selected(request ('tax-id') == $tax -> id)>
                                    {{ $tax -> title }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="col-md-2 form-group">
                    <button type="submit" class="btn btn-primary w-100 mt-38">
                        Search
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
