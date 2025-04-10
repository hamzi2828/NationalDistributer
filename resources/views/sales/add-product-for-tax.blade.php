@if(!empty($product))
    <tr class="sale-product-{{ $product -> id }}">
        <input type="hidden" name="products[]" value="{{ $product -> id }}">
        {{-- <input type="hidden" name="taxes[]" value="{{ $tax_id }}"> --}}
        <td>
            <span class="d-flex w-100 justify-content-center align-items-center fw-bold">{{ ($row + 1) }}</span>
            <a href="javascript:void(0)" data-product-id="{{ $product -> id }}" class="remove-sale-product">
                <i data-feather="trash-2"></i>
            </a>
        </td>

        <td>{{ $product -> productTitle() }}</td>

        <td>
            {{  $product -> tax -> title ?? 'N/A' }}
        </td>

        <td>
            {{  $product -> tax -> rate ?? '0' }}%
        </td>


    </tr>
@endif
