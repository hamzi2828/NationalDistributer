@if(count ($terms) > 0)
    <option></option>
    @foreach($terms as $term)
        <option value="{{ $term -> id }}" class="ps-1">
            {{ $term -> title }}
        </option>
    @endforeach
@endif