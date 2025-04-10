@php $array = [] @endphp
@if(count ($attributes) > 0)
    <option></option>
    @foreach($attributes as $attribute)
        @if(!in_array ($attribute -> id, $array))
            <option value="{{ $attribute -> id }}" class="ps-1">
                {{ $attribute -> title }}
            </option>
            @php array_push ($array, $attribute -> id) @endphp
        @endif
    @endforeach
@endif