<x-dashboard :title="$title">
    @push('styles')
        <style>
            .ck-editor__editable_inline {
                min-height : 400px;
            }
        </style>
    @endpush
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
                                      action="{{ route ('pages.update', ['page' => $page -> id]) }}">
                                    @csrf
                                    @method('PUT')
                                    <div class="card-body pt-0">
                                        <div class="row">
                                            <div class="col-md-4 mb-1">
                                                <label class="col-form-label font-small-4"
                                                       for="page">Page</label>
                                                <select id="page" name="page-name" class="form-control select2"
                                                        data-placeholder="Select" required="required">
                                                    <option></option>
                                                    <option value="about-us" @selected(old ('page-name', $page -> page_name) == 'about-us')>
                                                        About Us
                                                    </option>
                                                    <option value="privacy-policy" @selected(old ('page-name', $page -> page_name) == 'privacy-policy')>
                                                        Privacy Policy
                                                    </option>
                                                    <option value="product-returns" @selected(old ('page-name', $page -> page_name) == 'product-returns')>
                                                        Product Returns
                                                    </option>
                                                    <option value="shipping" @selected(old ('page-name', $page -> page_name) == 'shipping')>
                                                        Shipping
                                                    </option>
                                                    <option value="terms-and-conditions" @selected(old ('page-name', $page -> page_name) == 'terms-and-conditions')>
                                                        Terms & Conditions
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 mb-1">
                                                <label class="col-form-label font-small-4"
                                                       for="content">Content</label>
                                                <textarea name="content" class="form-control" id="content"
                                                          rows="5">{{ old ('content', $page -> content) }}</textarea>
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
        @push('scripts')
            <script type="text/javascript">
                ClassicEditor
                    .create ( document.querySelector ( '#content' ), {
                        toolbar: [
                            'heading', 'strikethrough', 'subscript', 'superscript', 'code',
                            '|', 'bold', 'italic', 'link', 'undo', 'redo', 'numberedList', 'bulletedList', 'outdent', 'indent',
                            '|', 'fontfamily', 'fontsize', 'fontColor', 'fontBackgroundColor',
                        ]
                    } )
                    .then ( editor => {
                        window.editor = editor;
                    } )
                    .catch ( err => {
                        console.error ( err.stack );
                    } );
            </script>
        @endpush
</x-dashboard>