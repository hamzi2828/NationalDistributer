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
                                      action="{{ route ('terms.store') }}">
                                    @csrf
                                    <div class="card-body pt-0">
                                        <div class="row">

                                            <div class="col-md-3 mb-1">
                                                <label class="col-form-label font-small-4"
                                                       for="attribute">Attribute</label>
                                                <select name="attribute-id" class="form-control select2"
                                                        data-placeholder="Select" required="required" id="attribute">
                                                    <option></option>
                                                    @if(count ($attributes) > 0)
                                                        @foreach($attributes as $attribute)
                                                            <option value="{{ $attribute -> id }}" @selected(old ('attribute-id') == $attribute -> id)>
                                                                {{ $attribute -> title }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>

                                            <div class="col-md-9 mb-1">
                                                <label class="col-form-label font-small-4" for="title">
                                                    <counter class="counter">1</counter> Title
                                                </label>
                                                <input type="text" id="title" class="form-control"
                                                       required="required" autofocus="autofocus"
                                                       name="title[]" placeholder="Term" value="{{ old ('title') }}"/>
                                            </div>
                                        </div>

                                        <div id="add-more"></div>

                                    </div>
                                    <div class="card-footer">
                                        <a href="javascript:void(0)" id="add-more-terms"
                                           class="btn btn-dark me-25">Add More</a>
                                        <button type="submit" class="btn btn-primary me-1">Submit</button>
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