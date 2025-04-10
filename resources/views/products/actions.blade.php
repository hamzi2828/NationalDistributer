<a class="btn btn-success btn-sm d-block mb-25"
   href="{{ route ('products.stock', ['product' => $product -> id]) }}">
    Stock
</a>

<a class="btn btn-info btn-sm d-block mb-25"
   onclick="return confirm('Are you sure?')"
   href="{{ route ('products.status', ['product' => $product -> id]) }}">
    {{ $product -> status == '1' ? 'Active' : 'Inactive' }}
</a>

@can('ticket', $product)
    <a class="btn btn-dark btn-sm d-block mb-25" target="_blank"
       href="{{ route ('product-ticket', ['product' => $product -> id]) }}">
        Ticket
    </a>
@endcan

@can('edit', $product)
    @if($product -> product_type == 'simple')
        <a class="btn btn-primary btn-sm d-block mb-25"
           href="{{ route ('products.edit', ['product' => $product -> id]) }}">
            Edit
        </a>
    @else
        <a class="btn btn-primary btn-sm d-block mb-25"
           href="{{ route ('products.edit.variable', ['product' => $product -> id]) }}">
            Edit
        </a>
    @endif
@endcan

@can('edit', $product)
    <a class="btn btn-relief-warning btn-sm d-block mb-25"
       href="javascript:void(0)"
       onclick="quickEditProduct('{{ route ('products.quick-edit', ['product' => $product -> id]) }}')">
        Q-Edit
    </a>
@endcan

@if($product -> product_type == 'simple')
    <a class="btn btn-relief-secondary btn-sm d-block mb-25"
       href="{{ route ('products.variations', ['product' => $product -> id]) }}">
        Variations
    </a>
@endif

@can('delete', $product)
    <form method="post"
          id="delete-confirmation-dialog-{{ $product -> id }}"
          action="{{ route ('products.destroy', ['product' => $product -> id]) }}">
        @method('DELETE')
        @csrf
        <button type="button"
                onclick="delete_dialog({{ $product -> id }})"
                class="btn btn-danger btn-sm d-block w-100">
            Delete
        </button>
    </form>
@endcan
