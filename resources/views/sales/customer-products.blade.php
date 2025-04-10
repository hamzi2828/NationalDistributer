<option></option>
@if(!empty($customer -> prices) && count ($customer -> prices) > 0)
    @foreach($customer -> prices as $price)
        @if($price -> product -> available_quantity() > 0)
            <option value="{{ $price -> product -> id }}">
                {{ $price -> product -> productTitle() }}
            </option>
        @endif
    @endforeach
@endif

@if(isset($products) && !empty($products) && count ($products) > 0)
    <option value="select-all">Select All</option>
    @foreach($products as $product)
        @if(!in_array ($product -> id, $customer_products))
            <option value="{{ $product -> id }}">
                {{ $product -> productTitle() }}
            </option>
        @endif
    @endforeach
@endif