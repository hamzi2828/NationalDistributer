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
                                <form class="form" method="post" enctype="multipart/form-data"
                                      action="{{ route ('couriers.update', ['courier' => $courier -> id]) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-md-3 mb-1">
                                                <label class="col-form-label font-small-4"
                                                       for="title">Title</label>
                                                <input type="text" id="title" class="form-control"
                                                       required="required" name="title"
                                                       value="{{ old ('title', $courier -> title) }}" />
                                            </div>
                                            
                                            <div class="col-md-3 mb-1">
                                                <label class="col-form-label font-small-4"
                                                       for="email">Email</label>
                                                <input type="email" id="email" class="form-control" name="email"
                                                       value="{{ old ('email', $courier -> email) }}" />
                                            </div>
                                            
                                            <div class="col-md-3 mb-1">
                                                <label class="col-form-label font-small-4"
                                                       for="contact-person">Contact Person</label>
                                                <input type="text" id="contact-person" class="form-control"
                                                       name="contact-person"
                                                       value="{{ old ('contact-person', $courier -> contact_person) }}" />
                                            </div>
                                            
                                            <div class="col-md-3 mb-1">
                                                <label class="col-form-label font-small-4"
                                                       for="contact-no">Contact No</label>
                                                <input type="text" id="contact-no" class="form-control"
                                                       name="phone"
                                                       value="{{ old ('phone', $courier -> phone) }}" />
                                            </div>
                                            
                                            <div class="col-md-12 mb-1">
                                                <label class="col-form-label font-small-4"
                                                       for="tracking">Tracking Link</label>
                                                <input type="text" id="tracking" class="form-control"
                                                       name="tracking"
                                                       value="{{ old ('tracking', $courier -> tracking_link) }}" />
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