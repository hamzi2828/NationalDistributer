<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="Sale Tracking No"
     aria-hidden="true" data-bs-keyboard="false" data-bs-backdrop="static">
    <div class="modal-dialog modal-dialog-top modal-md">
        <div class="modal-content">
            <div class="modal-header mb-2">
                <h5 class="modal-title" id="exampleModalCenterTitle">
                    {{ $title }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="form" method="post" enctype="multipart/form-data"
                  action="{{ route ('sales.add-tracking', ['sale' => $sale -> id]) }}">
                @csrf
                @method('PUT')
                <div class="card-body pt-0 pb-0">
                    <div class="row">
                        <div class="col-md-12 mb-1">
                            <label class="col-form-label font-small-4"
                                   for="tracking-no">Tracking No</label>
                            <input type="text" id="tracking-no" class="form-control"
                                   required="required" autofocus="autofocus"
                                   name="tracking-no" placeholder="Tracking No"
                                   value="{{ old ('tracking-no', $sale -> tracking_no) }}" />
                        </div>
                    </div>
                    <div class="card-footer border-top ps-0">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>