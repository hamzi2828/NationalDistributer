<option></option>
@if(isset($products) && !empty($products) && count ($products) > 0)
    @foreach($products as $product)
        @if($product -> available_quantity() > 0)
            <option value="{{ $product -> id }}">
                {{ $product -> productTitle() }}
            </option>
        @endif
    @endforeach
@endif