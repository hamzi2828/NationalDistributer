<x-dashboard :title="$title">
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper p-0">
            <div class="content-header row"></div>
            <div class="content-body">
                <!-- Basic table --> 
                <section id="basic-datatable">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">

                                <div class="card-header">
                                    <h4 class="card-title">{{ $title }}</h4>
                                </div>
                                <div class="card-body">
                                    <form method="get" action="{{ route('review-search-report') }}" id="review-report">
                                        <div class="row">
                                            
                                            <div class="form-group col-md-6 mb-1">
                                                <label class="mb-50">Products</label>
                                                <select name="product-id" class="form-control select2" data-placeholder="Select">
                                                    <option></option>
                                                    @if(count($products) > 0)
                                                        @foreach($products as $product)
                                                            <option value="{{ $product->id }}">
                                                                ({{ $product->barcode }}) ({{ $product->sku }}) 
                                                                ({{ $product->title }})
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @error('product-id')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            
                                            <div class="form-group col-md-3 mb-1">
                                                <label class="mb-25">Start Date</label>
                                                <input type="text" class="form-control flatpickr-basic" name="start-date" value="{{ request('start-date') }}">
                                                @error('start-date')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-3 mb-1">
                                                <label class="mb-25">End Date</label>
                                                <input type="text" class="form-control flatpickr-basic" name="end-date" value="{{ request('end-date') }}">
                                                @error('end-date')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-md-3 mb-1">
                                                <label class="mb-25">Rating</label>
                                                <select name="rating[]" class="form-control select2" multiple="multiple">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        <option value="{{ $i }}" {{ in_array($i, (array) request('rating')) ? 'selected' : '' }}>
                                                            {{ $i }}
                                                        </option>
                                                    @endfor
                                                </select>
                                                @error('rating')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            
                                            <script>
                                            $(document).ready(function() {
                                                $('.select2').select2({
                                                    placeholder: "Select ratings",
                                                    allowClear: true
                                                });
                                            });
                                            </script>
                                            
                                            

                                            <div class="form-group col-md-2 mb-1">
                                                <button type="submit" class="btn w-100 mt-2 btn-primary d-block ps-0 pe-0">Search</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                

                                @if(count($reviews) > 0)
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="d-flex gap-1 justify-content-end pt-1 pb-1">
                                            <a href="javascript:void(0)" class="btn btn-primary rounded btn-sm" onclick="downloadExcel('Review Report')">
                                                <i data-feather='download-cloud'></i>
                                                Download Excel
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif 


                                <div class="table-responsive">
                                    <table class="table w-100 table-striped table-responsive" id="excel-table">
                                        <thead>
                                        <tr>
                                            <th>Sr.No</th>
                                            <th>Image</th>
                                            <th>Sku</th>
                                            <th>Product</th>
                                            <th>User Name</th>
                                            <th>User Email</th>
                                            <th>User Phone</th>
                                            <th>Rating</th>
                                            <th>Review</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @if(count ($reviews) > 0)
                                            @foreach($reviews as $review)
                                                <tr>
                                                    <td align="center">{{ $loop -> iteration }}</td>
                                                
                                                    <td>
                                                        @if(!empty(trim ($review -> product ?-> image)))
                                                            <div class="avatar avatar-lg">
                                                                <img src="{{ asset ($review -> product -> image) }}">
                                                            </div>
                                                        @endif
                                                    </td>
                                               
                                                    <td>{{ $review -> product -> sku }}</td>
                                                    <td>{{ $review -> product -> productTitle() }}</td>
                                                    <td> 
                                                        @if ($review->user_id)
                                                            {{ $review -> user ?-> name }}
                                                            @else
                                                            {{ $review->user_name }}
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($review->user_id)
                                                            {{ $review -> user ?-> email }}
                                                            @else
                                                            {{ $review->email }}
                                                        @endif
                                                    </td>
                                                    <td>{{ $review -> user ?-> phone }}</td>
                                                    <td>{{ $review -> rating }}</td>
                                                    <td>{{ $review -> review }}</td>
                                                  
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!--/ Basic table -->
            </div>
        </div>
    </div>

    <!-- Edit Review Modal -->
    <div class="modal fade" id="editReviewModal" tabindex="-1" aria-labelledby="editReviewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editReviewModalLabel">Edit Review</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="editReviewForm" method="POST">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <input type="hidden" name="review_id" id="review_id">
                        <div class="mb-3">
                            <label for="edit_rating" class="form-label">Rating</label>
                            <select class="form-control" id="edit_rating" name="rating" required>
                                <option value="" disabled selected>Select a rating</option>
                                @for ($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="edit_review" class="form-label">Review</label>
                            <textarea class="form-control" id="edit_review" name="review" rows="3" required></textarea>
                        </div>
                     
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openEditReviewModal(id, rating, review, userName, email) {
            document.getElementById('editReviewForm').action = '/edit-reviews/' + id;
            document.getElementById('review_id').value = id;
            document.getElementById('edit_rating').value = rating;
            document.getElementById('edit_review').value = review;


            var editReviewModal = new bootstrap.Modal(document.getElementById('editReviewModal'));
            editReviewModal.show();
        }
    </script>

    @push('custom-scripts')
        <script type="text/javascript">
            $ ( "div.head-label" ).html ( '<h4 class="fw-bolder mb-0">{{ $title }}</h6>' );
        </script>
    @endpush
</x-dashboard>
