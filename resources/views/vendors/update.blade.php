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
                                      action="{{ route ('vendors.update', ['vendor' => $vendor -> id]) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-md-3 mb-1">
                                                <label class="col-form-label font-small-4">Company Name</label>
                                                <input type="text" class="form-control"
                                                       required="required" autofocus="autofocus"
                                                       name="name" placeholder="Company Name" value="{{ old ('name', $vendor -> name) }}"/>
                                            </div>

                                            <div class="col-md-3 mb-1">
                                                <label class="col-form-label font-small-4">License No</label>
                                                <input type="text" class="form-control"
                                                       name="license" placeholder="License No"
                                                       value="{{ old ('license', $vendor -> license) }}"/>
                                            </div>

                                            <div class="col-md-3 mb-1">
                                                <label class="col-form-label font-small-4">Email</label>
                                                <input type="email" class="form-control"
                                                       name="email" placeholder="Email"
                                                       value="{{ old ('email', $vendor -> email) }}"/>
                                            </div>

                                            <div class="col-md-3 mb-1">
                                                <label class="col-form-label font-small-4">Mobile No.</label>
                                                <input type="text" class="form-control"
                                                       name="mobile" placeholder="Mobile No"
                                                       value="{{ old ('mobile', $vendor -> mobile) }}"/>
                                            </div>

                                            <div class="col-md-3 mb-1">
                                                <label class="col-form-label font-small-4">Phone No.</label>
                                                <input type="text" class="form-control"
                                                       name="phone" placeholder="Phone No"
                                                       value="{{ old ('phone', $vendor -> phone) }}"/>
                                            </div>

                                            <div class="col-md-3 mb-1">
                                                <label class="col-form-label font-small-4">Representative Name</label>
                                                <input type="text" class="form-control"
                                                       name="representative" placeholder="Representative Name"
                                                       value="{{ old ('representative', $vendor -> representative) }}"/>
                                            </div>

                                            <div class="col-md-3 mb-1">
                                                <label class="col-form-label font-small-4">Address</label>
                                                <textarea class="form-control" name="address"
                                                          rows="5">{{ old ('address', $vendor -> address) }}</textarea>
                                            </div>

                                            <div class="col-md-3 mb-1">
                                                <div class="align-items-center border d-flex flex-column justify-content-center pt-50 rounded-2">
                                                    <div class="custom-avatar d-flex justify-content-center align-items-center flex-column">
                                                        <img
                                                                src="{{ $vendor -> picture() }}"
                                                                id="account-upload-img"
                                                                class="uploadedAvatar rounded w-75"
                                                                alt="profile image"
                                                        />
                                                        <div class="mt-1">
                                                            <label for="account-upload"
                                                                   class="btn btn-sm btn-primary mb-75 me-25">Upload</label>
                                                            <input type="file" id="account-upload" hidden="hidden"
                                                                   name="image"
                                                                   accept="image/*" />
                                                            <button type="button" id="account-reset"
                                                                    class="btn btn-sm btn-outline-secondary mb-75">Reset
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
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