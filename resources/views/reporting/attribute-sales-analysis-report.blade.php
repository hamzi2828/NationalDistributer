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
                                    <form method="get" action="{{ route ('attribute-sales-analysis-report') }}">
                                        <div class="row">
                                            <div class="form-group col-md-3 mb-1">
                                                <label class="mb-25">Start Date</label>
                                                <input type="text" class="form-control flatpickr-basic"
                                                       name="start-date" value="{{ request ('start-date') }}">
                                            </div>

                                            <div class="form-group col-md-3 mb-1">
                                                <label class="mb-25">End Date</label>
                                                <input type="text" class="form-control flatpickr-basic"
                                                       name="end-date" value="{{ request ('end-date') }}">
                                            </div>

                                            <div class="form-group col-md-4 mb-1">
                                                <label class="mb-25">Attribute</label>
                                                <select name="attribute-id" class="form-control select2"
                                                        data-placeholder="Select">
                                                    <option></option>
                                                    @if(count ($attributes) > 0)
                                                        @foreach($attributes as $attribute)
                                                            <option value="{{ $attribute -> id }}" @selected(request('attribute-id') == $attribute -> id)>
                                                                {{ $attribute -> title }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>

                                            <div class="form-group col-md-2 mb-1">
                                                <button type="submit"
                                                        class="btn w-100 mt-2 btn-primary d-block ps-0 pe-0">Search
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                @if(count ($sales) > 0)
                                    <div class="row">
                                        <div class="col-md-12 d-flex justify-content-end">
                                            <a href="{{ route ('attribute-sales-analysis-invoice', $_SERVER['QUERY_STRING']) }}"
                                               target="_blank"
                                               class="btn btn-dark me-2 mb-1 btn-sm">
                                                <i data-feather="printer"></i> Print
                                            </a>
                                        </div>
                                    </div>
                                @endif

                                <div class="table-responsive">
                                    <table class="table w-100 table-hover table-responsive table-striped table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Attribute</th>
                                            <th class="text-center">Sold Quantity</th>
                                            <th class="text-center">Revenue</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php
                                            $quantity = 0;
                                            $revenue = 0;
                                        @endphp
                                        @if(count ($sales) > 0)
                                            @foreach($sales as $sale)
                                                @php
                                                    $quantity += $sale -> quantity;
                                                    $revenue += ($sale -> net - $sale -> discount);
                                                @endphp
                                                <tr>
                                                    <td class="text-center">
                                                        {{ $loop -> iteration }}
                                                    </td>
                                                    <td class="text-start text-nowrap d-flex flex-column">
                                                        <span class="font-small-3">
                                                            {{ $sale -> title }}
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format ($sale -> quantity) }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ number_format (($sale -> net - $sale -> discount), 2) }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <td colspan="1"></td>
                                            <td colspan="1"> <strong>Total</strong></td>

                                            <td class="text-center">
                                                <strong>{{ number_format ($quantity, 2) }}</strong>
                                            </td>
                                            <td class="text-center">
                                                <strong>{{ number_format ($revenue, 2) }}</strong>
                                            </td>
                                        </tr>
                                        </tfoot>
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
</x-dashboard>