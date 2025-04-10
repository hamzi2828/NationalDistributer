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

                                @if($settings->count() > 0)
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="d-flex gap-1 justify-content-end pt-1 pb-1">
                                            <a href="javascript:void(0)" class="btn btn-primary rounded btn-sm" onclick="downloadExcel('Newsletter Report')">
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
                                                <th>IP Address</th>
                                                <th>User Email</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($settings->count() > 0)
                                                @foreach($settings as $newsletter)
                                                    <tr>
                                                        <td align="center">{{ $loop->iteration }}</td>
                                                        <td>{{ $newsletter->ip ?? 'N/A' }}</td>
                                                        <td>{{ $newsletter->email ?? 'N/A' }}</td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="3" class="text-center">No records found</td>
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

    <!-- Include xlsx library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

    <script>
    function downloadExcel(reportName) {
        console.log("Download function called");
        var table = document.getElementById('newsletter-table');
        var wb = XLSX.utils.table_to_book(table, {sheet: "Sheet1"});
        var filename = reportName + '.xlsx';
        XLSX.writeFile(wb, filename);
    }
    </script>

    @push('custom-scripts')
        <script type="text/javascript">
            $("div.head-label").html('<h4 class="fw-bolder mb-0">{{ $title }}</h4>');
        </script>
    @endpush
</x-dashboard>
