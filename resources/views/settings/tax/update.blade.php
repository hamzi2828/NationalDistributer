<x-dashboard :title="$title">
    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper p-0">
            <div class="content-body">
                <section id="basic-horizontal-layouts">
                    <div class="row">
                        <div class="col-md-12">
                            @include('errors.validation-errors')

                            <div class="card">
                                <div class="border-bottom-light card-header mb-2 pb-1">
                                    <h4 class="card-title">{{ $title }}</h4>
                                </div>

                                <form class="form" method="post"
                                      action="{{ route('taxes.update', ['tax' => $tax->id]) }}">
                                    @csrf
                                    @method('PUT')

                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <!-- Title Input -->
                                            <div class="col-md-12 mb-1">
                                                <label class="col-form-label font-small-4" for="title">Title</label>
                                                <input type="text" id="title" class="form-control"
                                                       required autofocus
                                                       name="title" placeholder="Tax Name"
                                                       value="{{ old('title', $tax->title) }}"/>
                                            </div>

                                            <!-- Rate Input -->
                                            <div class="col-md-12 mb-1">
                                                <label class="col-form-label font-small-4" for="rate">Rate (%)</label>
                                                <input type="number" id="rate" class="form-control"
                                                       required step="0.01" min="0"
                                                       name="rate" placeholder="Enter tax rate (e.g., 5.50)"
                                                       value="{{ old('rate', $tax->rate) }}"/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary me-1">Update Tax</button>
                                    </div>
                                </form>
                            </div> <!-- End of Card -->
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-dashboard>
