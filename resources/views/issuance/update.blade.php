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
                                </div>
                                <form class="form" method="post"
                                      action="{{ route ('issuance.update', ['issuance' => $issuance -> id]) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="offset-md-2 col-md-4 mb-1">
                                                <label class="col-form-label font-small-4"
                                                       for="title">Transfer From</label>
                                                <select class="form-control select2" disabled="disabled"
                                                        required="required" data-placeholder="Select">
                                                    @if(count ($branches) > 0)
                                                        @foreach($branches as $branch)
                                                            <option value="{{ $branch -> id }}" @selected(old ('from-branch-id', $issuance -> from_branch) == $branch -> id)>
                                                                {{ $branch -> name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            
                                            <div class="col-md-4 mb-1">
                                                <label class="col-form-label font-small-4"
                                                       for="title">Transfer To</label>
                                                <select class="form-control select2" disabled="disabled"
                                                        required="required" data-placeholder="Select">
                                                    @if(count ($branches) > 0)
                                                        @foreach($branches as $branch)
                                                            <option value="{{ $branch -> id }}" @selected(old ('to-branch-id', $issuance -> to_branch) == $branch -> id)>
                                                                {{ $branch -> name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-12 mb-1 mt-1">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered table-hover">
                                                        <thead>
                                                        <tr>
                                                            <th width="2%"></th>
                                                            <th width="45%">Product</th>
                                                            <th width="18%">Available Qty.</th>
                                                            <th width="35%">Transfer Qty.</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="transfer-products-table">
                                                        @if(count ($issuance -> products) > 0)
                                                            @foreach($issuance -> products as $issued_product)
                                                                <tr class="sale-product-{{ $issued_product -> product -> id }}">
                                                                    <input type="hidden" name="products[]"
                                                                           value="{{ $issued_product -> product -> id }}">
                                                                    <td>
                                                                        <a href="javascript:void(0)"
                                                                           data-product-id="{{ $issued_product -> product -> id }}"
                                                                           class="remove-sale-product">
                                                                            <i data-feather="trash-2"></i>
                                                                        </a>
                                                                    </td>
                                                                    
                                                                    <td>{{ $issued_product -> product -> productTitle() }}</td>
                                                                    
                                                                    <td>
                                                                        <input class="form-control available-qty-{{ $issued_product -> product -> id }}"
                                                                               readonly="readonly"
                                                                               value="{{ $issued_product -> product -> available_quantity() }}">
                                                                    </td>
                                                                    
                                                                    <td>
                                                                        <input type="number"
                                                                               class="form-control sale-qty-{{ $issued_product -> product -> id }}"
                                                                               name="quantity[]"
                                                                               data-product-id="{{ $issued_product -> product -> id }}"
                                                                               onchange="transfer_quantity({{ $issued_product -> product -> id }})"
                                                                               required="required"
                                                                               value="{{ $issued_product -> quantity }}"
                                                                               placeholder="Quantity" min="0">
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary me-1">Update</button>
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