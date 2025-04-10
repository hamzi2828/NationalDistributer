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
                                      action="{{ route ('categories.store') }}">
                                    @csrf
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-md-3 mb-1">
                                                <label class="col-form-label font-small-4"
                                                       for="parent-id">Parent Category</label>
                                                <select name="parent-id" class="form-control select2"
                                                        data-placeholder="Select" id="parent-id">
                                                    <option></option>
                                                    {!! $categories !!}
                                                </select>
                                            </div>
                                            
                                            <div class="col-md-3 mb-1">
                                                <label class="col-form-label font-small-4"
                                                       for="icon">Icon</label>
                                                <input type="text" id="icon" class="form-control" name="icon"
                                                       autofocus="autofocus"
                                                       value="{{ old ('icon') }}" />
                                            </div>
                                            
                                            <div class="col-md-4 mb-1">
                                                <label class="col-form-label font-small-4"
                                                       for="title">Title</label>
                                                <input type="text" id="title" class="form-control"
                                                       required="required" name="title"
                                                       value="{{ old ('title') }}" />
                                            </div>
                                            
                                            <div class="col-md-2 mb-1">
                                                <label class="col-form-label font-small-4">Banner Image</label>
                                                <div class="align-items-center border d-flex flex-column justify-content-center pt-50 rounded-2">
                                                    <div class="custom-avatar ps-1 pe-1">
                                                        <img src="{{ asset ('/assets/img/default-thumbnail.jpg') }}"
                                                             id="account-upload-img" class="uploadedAvatar rounded"
                                                             alt="profile image"
                                                             style="max-width: 100%; max-height: 100%" />
                                                        <div class="mt-1">
                                                            <label for="account-upload"
                                                                   class="btn btn-sm btn-primary mb-75 me-25">Upload</label>
                                                            <input type="file" id="account-upload" hidden="hidden"
                                                                   name="image"
                                                                   accept="image/*" />
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