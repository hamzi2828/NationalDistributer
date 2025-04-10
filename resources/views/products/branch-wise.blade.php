<option></option>
@if(count ($products) > 0)
    @foreach($products as $product)
        @if($product -> product -> available_quantity() > 0)
            <option value="{{ $product -> product -> id }}">
                {{ $product -> product -> productTitle() }}
            </option>
        @endif
    @endforeach
@endif