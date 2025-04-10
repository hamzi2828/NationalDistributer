@if($errors -> any())
    @foreach($errors -> all() as $error)
        <div class="alert alert-danger" role="alert">
            <h4 class="alert-heading">Error!</h4>
            <div class="alert-body">
                {{ $error }}
            </div>
        </div>
    @endforeach
@endif

@if(session () -> has ('error'))
    <div class="alert alert-danger" role="alert">
        <h4 class="alert-heading">Error!</h4>
        <div class="alert-body">
            {{ session ('error') }}
        </div>
    </div>
@endif