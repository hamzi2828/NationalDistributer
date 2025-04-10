<!DOCTYPE html>
<html class="loading {{ auth () -> user () -> theme }}" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">

    <meta name="csrf-token" content="{{ csrf_token () }}">
    <title>{{ $title . ' | ' . config ('app.name') }}</title>
    <link rel="shortcut icon" type="image/x-icon"
          href="{{ asset ('/public/assets/img/ims.png') }}">

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
          rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/vendors/css/forms/select/select2.min.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('/app-assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('/app-assets/vendors/css/tables/datatable/buttons.bootstrap5.min.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('/app-assets/vendors/css/tables/datatable/rowGroup.bootstrap5.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/vendors/css/charts/apexcharts.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/vendors/css/extensions/toastr.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css/bootstrap-extended.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css/colors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css/components.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css/themes/dark-layout.min.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('/app-assets/css/core/menu/menu-types/vertical-menu.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css/pages/dashboard-ecommerce.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/css/plugins/charts/chart-apex.min.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('/app-assets/css/plugins/extensions/ext-component-toastr.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/app-assets/vendors/css/extensions/sweetalert2.min.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('/app-assets/css/plugins/extensions/ext-component-sweet-alerts.min.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('/app-assets/vendors/css/pickers/pickadate/pickadate.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('/app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('/app-assets/css/plugins/forms/pickers/form-flat-pickr.min.css') }}">
    <link rel="stylesheet" type="text/css"
          href="{{ asset('/app-assets/css/plugins/forms/pickers/form-pickadate.min.css') }}">

    @stack('styles')

    <link rel="stylesheet" type="text/css" href="{{ asset('/assets/css/style.css?ver='.rand ()) }}">

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->
<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static" data-open="click"
      data-menu="vertical-menu-modern" data-col="">

<div
    class="loading position-fixed zindex-4 w-100 h-100 d-none justify-content-center align-items-center bg-white bg-opacity-75">
    <div class="spinner-grow" role="status"></div>
</div>

@include('partials._top-header')
@include('partials._sidebar')

{{ $slot }}

<div id="ajaxContent"></div>
<div class="sidenav-overlay"></div>
<div class="drag-target"></div>

@include('partials._footer')

<script src="{{ asset('/app-assets/vendors/js/vendors.min.js') }}"></script>
<script src="{{ asset('/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
<script src="{{ asset('/app-assets/vendors/js/forms/select/select2.full.min.js') }}"></script>
<script src="{{ asset('/app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/app-assets/vendors/js/tables/datatable/dataTables.bootstrap5.min.js') }}"></script>
<script src="{{ asset('/app-assets/vendors/js/tables/datatable/datatables.buttons.min.js') }}"></script>
<script src="{{ asset('/app-assets/vendors/js/tables/datatable/jszip.min.js') }}"></script>
<script src="{{ asset('/app-assets/vendors/js/tables/datatable/pdfmake.min.js') }}"></script>
<script src="{{ asset('/app-assets/vendors/js/tables/datatable/vfs_fonts.js') }}"></script>
<script src="{{ asset('/app-assets/vendors/js/tables/datatable/buttons.html5.min.js') }}"></script>
<script src="{{ asset('/app-assets/vendors/js/tables/datatable/buttons.print.min.js') }}"></script>
<script src="{{ asset('/app-assets/vendors/js/tables/datatable/dataTables.rowGroup.min.js') }}"></script>
<script src="{{ asset('/app-assets/js/scripts/forms/form-select2.min.js') }}"></script>
<script src="{{ asset('/app-assets/vendors/js/forms/cleave/cleave.min.js') }}"></script>
<script src="{{ asset('/app-assets/js/scripts/forms/form-input-mask.min.js') }}"></script>
<script src="{{ asset('/app-assets/js/scripts/extensions/ext-component-toastr.min.js') }}"></script>
<script src="{{ asset('/app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('/app-assets/js/scripts/extensions/ext-component-sweet-alerts.min.js') }}"></script>
<script src="{{ asset('/app-assets/vendors/js/pickers/pickadate/picker.js') }}"></script>
<script src="{{ asset('/app-assets/vendors/js/pickers/pickadate/picker.date.js') }}"></script>
<script src="{{ asset('/app-assets/vendors/js/pickers/pickadate/picker.time.js') }}"></script>
<script src="{{ asset('/app-assets/vendors/js/pickers/pickadate/legacy.js') }}"></script>
<script src="{{ asset('/app-assets/vendors/js/pickers/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ asset('/app-assets/js/scripts/forms/pickers/form-pickers.min.js') }}"></script>
<script src="{{ asset('/app-assets/js/core/app-menu.min.js') }}"></script>
<script src="{{ asset('/app-assets/js/core/app.min.js') }}"></script>
<script src="{{ asset('/app-assets/js/scripts/customizer.min.js') }}"></script>
<script src="{{ asset('/assets/ckeditor/ckeditor.js') }}"></script>
<script src="{{ asset('/assets/js/custom.js?ver='.rand ()) }}"></script>
<script src="{{ asset('/assets/js/xlxs.js') }}"></script>
<script src="{{ asset('/assets/js/analytics.js?ver=1.0.1') }}"></script>
@stack('scripts')
@include('errors.errors')

<script>
    $ ( window ).on ( 'load', function () {
        if ( feather ) {
            feather.replace ( { width: 14, height: 14 } );
        }

        @if(request () -> routeIs ('dashboard'))
        get_open_orders_count ();
        get_closed_orders_count ();
        get_sales_count ();
        get_daily_sales_count ();
        get_daily_profit_count ();
        get_revenue_report_chart ();
        get_daily_sales_chart ();
        get_monthly_sales_chart ();
        get_payable_count (); // HEAVY
        get_receivable_count (); // HEAVY
        get_inventory_value_tp_wise (); // HEAVY
        inventory_value_sale_wise (); // HEAVY
        @endif
    } );
</script>
@stack('custom-scripts')
</body>
<!-- END: Body-->
</html>
