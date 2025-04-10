function get_open_orders_count () {
    ajaxSetup ();
    jQuery.ajax ( {
        type: 'GET',
        url: '/analytics/open_orders_count',
        success: function ( response ) {
            $ ( '.open-orders-count' ).html ( response );
        },
        error: function ( xHR, exception ) {
            // ajaxErrors ( xHR, exception );
        }
    } )
}

function get_closed_orders_count () {
    ajaxSetup ();
    jQuery.ajax ( {
        type: 'GET',
        url: '/analytics/get_closed_orders_count',
        success: function ( response ) {
            $ ( '.closed-orders-count' ).html ( response );
        },
        error: function ( xHR, exception ) {
            // ajaxErrors ( xHR, exception );
        }
    } )
}

function get_payable_count () {
    ajaxSetup ();
    jQuery.ajax ( {
        type: 'GET',
        url: '/analytics/get_payable_count',
        success: function ( response ) {
            $ ( '.payable-count' ).html ( response );
        },
        error: function ( xHR, exception ) {
            // ajaxErrors ( xHR, exception );
        }
    } )
}

function get_receivable_count () {
    ajaxSetup ();
    jQuery.ajax ( {
        type: 'GET',
        url: '/analytics/get_receivable_count',
        success: function ( response ) {
            $ ( '.receivable-count' ).html ( response );
        },
        error: function ( xHR, exception ) {
            // ajaxErrors ( xHR, exception );
        }
    } )
}

function get_sales_count () {
    ajaxSetup ();
    jQuery.ajax ( {
        type: 'GET',
        url: '/analytics/get_sales_count',
        success: function ( response ) {
            $ ( '.sales-count' ).html ( response );
        },
        error: function ( xHR, exception ) {
            // ajaxErrors ( xHR, exception );
        }
    } )
}

function get_daily_sales_count () {
    ajaxSetup ();
    jQuery.ajax ( {
        type: 'GET',
        url: '/analytics/get_daily_sales_count',
        success: function ( response ) {
            $ ( '.daily-sales-count' ).html ( response );
        },
        error: function ( xHR, exception ) {
            // ajaxErrors ( xHR, exception );
        }
    } )
}

function get_daily_profit_count () {
    ajaxSetup ();
    jQuery.ajax ( {
        type: 'GET',
        url: '/analytics/get_daily_profit_count',
        success: function ( response ) {
            $ ( '.daily-profit-count' ).html ( response );
        },
        error: function ( xHR, exception ) {
            // ajaxErrors ( xHR, exception );
        }
    } )
}

function get_inventory_value_tp_wise () {
    ajaxSetup ();
    jQuery.ajax ( {
        type: 'GET',
        url: '/analytics/get_inventory_value_tp_wise',
        success: function ( response ) {
            $ ( '.inventory-value-tp-wise' ).html ( response );
        },
        error: function ( xHR, exception ) {
            // ajaxErrors ( xHR, exception );
        }
    } )
}

function inventory_value_sale_wise () {
    ajaxSetup ();
    jQuery.ajax ( {
        type: 'GET',
        url: '/analytics/inventory_value_sale_wise',
        success: function ( response ) {
            $ ( '.inventory-value-sale-wise' ).html ( response );
        },
        error: function ( xHR, exception ) {
            // ajaxErrors ( xHR, exception );
        }
    } )
}

function get_revenue_report_chart () {
    ajaxSetup ();
    jQuery.ajax ( {
        type: 'GET',
        url: '/analytics/get_revenue_report_chart',
        success: function ( response ) {
            $ ( '#revenue-report-chart' ).html ( response );
        },
        error: function ( xHR, exception ) {
            // ajaxErrors ( xHR, exception );
        }
    } )
}

function get_daily_sales_chart () {
    ajaxSetup ();
    jQuery.ajax ( {
        type: 'GET',
        url: '/analytics/get_daily_sales_chart',
        success: function ( response ) {
            $ ( '#daily-sales-chart' ).html ( response );
        },
        error: function ( xHR, exception ) {
            // ajaxErrors ( xHR, exception );
        }
    } )
}

function get_monthly_sales_chart () {
    ajaxSetup ();
    jQuery.ajax ( {
        type: 'GET',
        url: '/analytics/get_monthly_sales_chart',
        success: function ( response ) {
            $ ( '#line-chart' ).html ( response );
        },
        error: function ( xHR, exception ) {
            // ajaxErrors ( xHR, exception );
        }
    } )
}