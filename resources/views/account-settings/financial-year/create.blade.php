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
                                      action="{{ route ('financial-year.store') }}">
                                    @csrf
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="form-group col-md-3 mb-1">
                                                <label class="mb-25" for="start-date">Start Date</label>
                                                <input type="text" class="form-control flatpickr-basic" id="start-date"
                                                       data-date-format="d-m-Y"
                                                       name="start-date"
                                                       value="{{ old ('start-date', date ('d-m-Y', strtotime ($financial_year ?-> start_date))) }}">
                                            </div>
                                            
                                            <div class="form-group col-md-3 mb-1">
                                                <label class="mb-25" for="end-date">End Date</label>
                                                <input type="text" class="form-control flatpickr-basic" id="end-date"
                                                       data-date-format="d-m-Y"
                                                       name="end-date"
                                                       value="{{ old ('end-date', date ('d-m-Y', strtotime ($financial_year ?-> end_date))) }}">
                                            </div>
                                        </div>
                                    
                                    </div>
                                    <div class="card-footer">
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