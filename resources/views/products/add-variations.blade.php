<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="Add Product Variations"
     aria-hidden="true" data-bs-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-top modal-lg">
        <div class="modal-content">
            <div class="modal-header mb-2">
                <h5 class="modal-title" id="exampleModalCenterTitle">
                    Add Product Variations
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="form" method="post" enctype="multipart/form-data"
                  action="{{ route ('products.variations.store', ['product' => $product -> id]) }}">
                @csrf
                <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th align="center" width="5%"></th>
                        <th align="left" width="25%">Attribute</th>
                        <th align="left" width="70%">Terms</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count ($attributes) > 0)
                        @foreach($attributes as $attribute)
                            @php
                                $attribute -> load(['terms' => function($query) use ($product) {
                                    $query-> whereNotIn ( 'id', function ( $query ) use ($product) {
                                        $query
                                            -> select ( 'term_id' )
                                            -> from ( 'product_terms' )
                                            -> where('product_id', '=', $product -> id);
                                    } );
                                }]);
                            @endphp
                            <tr>
                                <td>
                                    <label class="w-100">
                                        <input type="checkbox" name="attributes[]"
                                               value="{{ $attribute -> id }}" @disabled(count ($attribute -> terms) < 1)>
                                    </label>
                                </td>
                                <td>{{ $attribute -> title }}</td>
                                <td>
                                    <label class="w-100">
                                        <select name="terms[{{ $attribute -> id }}][]" class="form-control select2"
                                                multiple="multiple" data-placeholder="Select">
                                            <option></option>
                                            @if(count ($attribute -> terms) > 0)
                                                @foreach($attribute -> terms as $term)
                                                    <option value="{{ $term -> id }}">
                                                        {{ $term -> title }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </label>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
                <div class="card-footer border-top">
                    <button type="submit" class="btn btn-primary me-1">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>