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
                                {{-- <div class="border-bottom-light card-header mb-2 pb-1 pb-1">
                                    <h4 class="card-title">{{ $title }}</h4>
                                </div> --}}

                                <div class="col-md-12">
                                    <h2 class="mt-1 mb-1 border-bottom text-danger fw-bolder pb-25">
                                        {{ $title }}
                                    </h2>
                                </div>
                                
                                <form class="form" method="post" enctype="multipart/form-data"
                                      action="{{ route ('home-settings.store') }}">
                                    @csrf
                                    <div class="card-body pt-0">
                                        <div class="col-md-12 mb-1">
                                            <div class="row">
                                                <div class="col-md-6 mb-1">
                                                    <div class="border rounded p-1">
                                                        @if($settings && !empty(trim ($settings -> banner_1)))
                                                            <div class="align-items-center d-flex justify-content-center w-100">
                                                                <img src="{{ $settings -> banner_1 }}"
                                                                     class="mw-100 rounded"
                                                                     alt="Banner" />
                                                            </div>
                                                        @endif
                                                        <label class="col-form-label font-small-4"
                                                               for="banner-1">
                                                            Banner 1
                                                        </label>
                                                        <input type="file" class="form-control" accept="image/*"
                                                               name="banner-1"
                                                               id="banner-1" />
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6 mb-1">
                                                    <div class="border rounded p-1">
                                                        @if($settings && !empty(trim ($settings -> banner_2)))
                                                            <div class="align-items-center d-flex justify-content-center w-100">
                                                                <img src="{{ $settings -> banner_2 }}"
                                                                     class="mw-100 rounded"
                                                                     alt="Banner" />
                                                            </div>
                                                        @endif
                                                        <label class="col-form-label font-small-4"
                                                               for="banner-2">
                                                            Banner 2
                                                        </label>
                                                        <input type="file" class="form-control" accept="image/*"
                                                               name="banner-2"
                                                               id="banner-2" />
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6 mb-1">
                                                    <div class="border rounded p-1">
                                                        @if($settings && !empty(trim ($settings -> banner_3)))
                                                            <div class="align-items-center d-flex justify-content-center w-100">
                                                                <img src="{{ $settings -> banner_3 }}"
                                                                     class="mw-100 rounded"
                                                                     alt="Banner" />
                                                            </div>
                                                        @endif
                                                        <label class="col-form-label font-small-4"
                                                               for="banner-3">
                                                            Banner 3
                                                        </label>
                                                        <input type="file" class="form-control" accept="image/*"
                                                               name="banner-3"
                                                               id="banner-3" />
                                                    </div>
                                                </div>
                                                
                                                <div class="col-md-6 mb-1">
                                                    <div class="border rounded p-1">
                                                        @if($settings && !empty(trim ($settings -> banner_4)))
                                                            <div class="align-items-center d-flex justify-content-center w-100">
                                                                <img src="{{ $settings -> banner_4 }}"
                                                                     class="mw-100 rounded"
                                                                     alt="Banner" />
                                                            </div>
                                                        @endif
                                                        <label class="col-form-label font-small-4"
                                                               for="banner-4">
                                                            Banner 4
                                                        </label>
                                                        <input type="file" class="form-control" accept="image/*"
                                                               name="banner-4"
                                                               id="banner-4" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    
                               <!-- Newsletter Section -->
                                  
                                  <div class="card-body pt-0">
                                    <div class="col-md-12">
                                        <h2 class="mt-1 mb-1 border-bottom text-danger fw-bolder pb-25">
                                            Newsletter Settings
                                        </h2>
                                    </div>
                                    

                                    
                                    <div class="row">
                                        <!-- Newsletter Title -->
                                        <div class="col-md-6 mb-1">
                                            <div class="border rounded p-2">
                                                <div class="form-group">
                                                    <label for="newsletter_title">Newsletter Title</label>
                                                    <input type="text" class="form-control" id="newsletter_title" name="newsletter_title" 
                                                        value="{{ old('newsletter_title', $settings->newsletter_title ?? '') }}">
                                                </div>
                                            </div>
                                        </div>
                                
                                        <!-- Newsletter Subtitle -->
                                        <div class="col-md-6 mb-1">
                                            <div class="border rounded p-2">
                                                <div class="form-group">
                                                    <label for="newsletter_subtitle">Newsletter Subtitle</label>
                                                    <input type="text" class="form-control" id="newsletter_subtitle" name="newsletter_subtitle" 
                                                        value="{{ old('newsletter_subtitle', $settings->newsletter_subtitle ?? '') }}">
                                                </div>
                                            </div>
                                        </div>
                                
                                        <!-- Newsletter Description -->
                                        <div class="col-md-12 mb-1">
                                            <div class="border rounded p-2">
                                                <div class="form-group">
                                                    <label for="newsletter_description">Newsletter Description</label>
                                                    <textarea class="form-control" id="newsletter_description" name="newsletter_description">{{ old('newsletter_description', $settings->newsletter_description ?? '') }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                
                                        <!-- Newsletter Image -->
                                        <div class="col-md-12 mb-1">
                                            <div class="border rounded p-2">
                                                <div class="form-group">
                                                    <label for="newsletter_image">Newsletter Image</label>
                                                    <input type="file" class="form-control-file" id="newsletter_image" name="newsletter_image" onchange="previewImage(event)">
                                                    
                                                    <!-- Display the current image if available -->
                                                    @if(!empty($settings->newsletter_image))
                                                        <div class="mt-2">
                                                            <img src="{{ asset($settings->newsletter_image) }}" alt="Newsletter Image" class="img-fluid" style="max-width: 300px; max-height: 150px;">
                                                        </div>
                                                    @endif
                                                    
                                                    <!-- Preview for new image -->
                                                    <div id="newsletter-image-preview" class="mt-2"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <script>
                                    function previewImage(event) {
                                        var file = event.target.files[0];
                                        var previewContainer = document.getElementById('newsletter-image-preview');
                                    
                                        // Clear previous previews
                                        previewContainer.innerHTML = '';
                                    
                                        if (file) {
                                            var reader = new FileReader();
                                            
                                            reader.onload = function(e) {
                                                var img = document.createElement('img');
                                                img.src = e.target.result;
                                                img.alt = 'Preview';
                                                img.className = 'img-fluid';
                                                img.style.maxWidth = '300px';
                                                img.style.maxHeight = '150px';
                                                
                                                previewContainer.appendChild(img);
                                            };
                                            
                                            reader.readAsDataURL(file);
                                        }
                                    }
                                </script>
                                  <!--end  Newsletter Section -->
                                
                                  <div class="card-body pt-0">
                                  <div class="col-md-12">
                                      <h2 class="mt-1 mb-1 border-bottom text-danger fw-bolder pb-25">
                                          Shop Banner Settings
                                      </h2>
                                  </div>
                              
                                  <div class="row">
                                      <!-- Banner Subtitle -->
                                      <div class="col-md-6 mb-1">
                                          <div class="border rounded p-2">
                                              <div class="form-group">
                                                  <label for="shop_banner_subtitle">Banner Subtitle</label>
                                                  <input type="text" class="form-control" id="shop_banner_subtitle" name="shop_banner_subtitle"
                                                      value="{{ old('shop_banner_subtitle', $settings->shop_banner_subtitle ?? '') }}">
                                              </div>
                                          </div>
                                      </div>
                              
                                      <!-- Banner Title -->
                                      <div class="col-md-6 mb-1">
                                          <div class="border rounded p-2">
                                              <div class="form-group">
                                                  <label for="shop_banner_title">Banner Title</label>
                                                  <input type="text" class="form-control" id="shop_banner_title" name="shop_banner_title"
                                                      value="{{ old('shop_banner_title', $settings->shop_banner_title ?? '') }}">
                                              </div>
                                          </div>
                                      </div>

                                           <!-- Banner Button Text -->
                                           <div class="col-md-6 mb-1">
                                            <div class="border rounded p-2">
                                                <div class="form-group">
                                                    <label for="shop_banner_button_text">Banner Button Text</label>
                                                    <input type="text" class="form-control" id="shop_banner_button_text" name="shop_banner_button_text"
                                                        value="{{ old('shop_banner_button_text', $settings->shop_banner_button_text ?? '') }}">
                                                </div>
                                            </div>
                                        </div>
                                        
                              
                                      <!-- Banner Link -->
                                      <div class="col-md-6 mb-1">
                                          <div class="border rounded p-2">
                                              <div class="form-group">
                                                  <label for="shop_banner_link">Banner Link</label>
                                                  <input type="text" class="form-control" id="shop_banner_link" name="shop_banner_link"
                                                      value="{{ old('shop_banner_link', $settings->shop_banner_link ?? '') }}">
                                              </div>
                                          </div>
                                      </div>
                                 

                              
                                      <!-- Banner Image -->
                                      <div class="col-md-12 mb-1">
                                        <div class="border rounded p-2">
                                            <div class="form-group">
                                                <label for="shop_banner_image">Banner Image</label>
                                                <input type="file" class="form-control-file" id="shop_banner_image" name="shop_banner_image" onchange="previewBannerImage(event)">
                                    
                                                <!-- Display the current image if available -->
                                                @if(!empty($settings->shop_banner_image))
                                                    <div class="mt-2 current-banner-image">
                                                        <img src="{{ asset($settings->shop_banner_image) }}" alt="Shop Banner Image" class="img-fluid" style="max-width: 300px; max-height: 150px;">
                                                    </div>
                                                @endif
                                    
                                                <!-- Preview for new image -->
                                                <div id="shop-banner-image-preview" class="mt-2"></div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                  </div>
                              </div>
                              
                              <script>
                               function previewBannerImage(event) {
                                    var file = event.target.files[0];
                                    var previewContainer = document.getElementById('shop-banner-image-preview');
                                    var currentImageContainer = document.querySelector('.current-banner-image');

                                    // Clear previous previews and current image
                                    previewContainer.innerHTML = '';
                                    if (currentImageContainer) {
                                        currentImageContainer.remove();
                                    }

                                    if (file) {
                                        var reader = new FileReader();

                                        reader.onload = function(e) {
                                            var img = document.createElement('img');
                                            img.src = e.target.result;
                                            img.alt = 'Preview';
                                            img.className = 'img-fluid';
                                            img.style.maxWidth = '300px';
                                            img.style.maxHeight = '150px';

                                            previewContainer.appendChild(img);
                                        };

                                        reader.readAsDataURL(file);
                                    }
                                }

                              </script>




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
