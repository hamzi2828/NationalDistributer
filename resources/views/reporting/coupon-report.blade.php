<x-dashboard :title="$title">
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper p-0">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- Basic table -->
                <section>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">{{ $title }}</h4>
                                </div>
                                <div class="card-body">
                                    <form method="get" action="{{ route('coupon-search-report') }}" id="general-sales-report">
                                        <div class="row">
                                            <div class="form-group col-md-4 mb-1">
                                                <label class="mb-50">Coupons</label>
                                                <select name="coupon-id" class="form-control select2" data-placeholder="Select">
                                                    <option></option>
                                                    @if(count($coupons) > 0)
                                                        @foreach($coupons as $coupon)
                                                            <option value="{{ $coupon->id }}" {{ $coupon->id == request('coupon-id') ? 'selected' : '' }}>
                                                                {{ $coupon->code }} 
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                                @error('coupon-id')
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
                                            <div class="form-group col-md-2 mb-1">
                                                <button type="submit" class="btn w-100 mt-2 btn-primary d-block ps-0 pe-0">Search</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                @if(count($coupons_report) > 0)
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="d-flex gap-1 justify-content-end pt-1 pb-1">
                                                <a href="javascript:void(0)" class="btn btn-primary rounded btn-sm" onclick="downloadExcel('Coupon Report')">
                                                    <i data-feather='download-cloud'></i>
                                                    Download Excel
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endif 

                                <div class="table-responsive">
                                    <table id="excel-table" class="table w-100 table-hover table-responsive table-striped">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Coupon Code</th>
                                            <th>Order Number</th>
                                            <th>Date Created</th>
                                            <th>User</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                            @if(count($coupons_report) > 0)
                                                @php $outerIndex = 1; @endphp
                                                @foreach($coupons_report as $coupon)
                                                    @foreach($coupon['sales'] as $sale)
                                                        <tr>
                                                            <td>{{ $outerIndex++ }}</td>
                                                            <td>{{ $coupon['code'] }}</td>
                                                            <td>{{ $sale['sale_id'] }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($sale['created_at'])->format('d/m/Y') }}</td>

                                                            <td>{{ isset($sale['user']['name']) ? $sale['user']['name'] : 'N/A' }}</td>
                                                        </tr>
                                                    @endforeach
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="5">No coupons found</td>
                                                </tr>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>
    <script>
        function downloadExcel(title) {
            // Get the HTML table
            let table = document.getElementById("excel-table");

            // Convert the table to a sheet object
            let sheet = XLSX.utils.table_to_sheet(table);

            // Create a workbook object
            let workbook = XLSX.utils.book_new();

            // Add the sheet to the workbook
            XLSX.utils.book_append_sheet(workbook, sheet, "Sheet1");

            // Convert the workbook to a binary string
            let wbout = XLSX.write(workbook, { bookType: "xlsx", type: "binary" });

            // Create a Blob object from the binary string
            let blob = new Blob([s2ab(wbout)], { type: "application/octet-stream" });

            // Create a download link and click it
            let url = window.URL.createObjectURL(blob);
            let a = document.createElement("a");
            a.href = url;
            a.download = title + ".xlsx";
            a.click();
            window.URL.revokeObjectURL(url);
        }

        function s2ab(s) {
            var buf = new ArrayBuffer(s.length);
            var view = new Uint8Array(buf);
            for (var i = 0; i < s.length; i++) {
                view[i] = s.charCodeAt(i) & 0xFF;
            }
            return buf;
        }
    </script>
</x-dashboard>
