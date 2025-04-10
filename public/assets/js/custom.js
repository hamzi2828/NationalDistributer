let selected        = [];
let selectedVoucher = null;

/**
 -------------
 * on form submit,
 * disable button
 * show loader
 * -------------
 */

$ ( 'form' ).on ( 'submit', function () {
    $ ( 'form button' ).prop ( 'disabled', 'true' );
    $ ( '.loading' ).removeClass ( 'd-none' );
    $ ( '.loading' ).addClass ( 'd-flex' );
    $ ( 'form button' ).text ( 'Processing...' );
} );

/**
 -------------
 * on dropdown open, select2
 * focus on search
 * -------------
 */

$ ( document ).on ( 'select2:open', () => {
    document.querySelector ( '.select2-search__field' ).focus ();
} );

/**
 -------------
 * configure datatable
 * -------------
 */

$ ( '.datatable' ).DataTable ( {
                                   order        : [ [ 0, "asc" ] ],
                                   dom          : '<"card-header border-bottom p-1"<"head-label"><"dt-action-buttons text-end"B>><"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
                                   displayLength: 50,
                                   lengthMenu   : [ 50, 75, 100, 125, 150, 500 ],
                                   buttons      : [
                                       'excelHtml5',
                                       'csvHtml5',
                                   ],
                                   autoWidth    : true,
                                   responsive   : true,
                                   language     : { paginate: { previous: "&nbsp;", next: "&nbsp;" } }
                               } );

/**
 -------------
 * check all privileges
 * -------------
 */

$ ( '#check-all' ).on ( 'click', function () {
    $ ( '#privileges input:checkbox' ).not ( this ).prop ( 'checked', this.checked );
} );

/**
 -------------
 * search privileges
 * -------------
 */

$ ( "#search-privileges" ).on ( "keyup", function () {
    let value = this.value.toLowerCase ().trim ();

    $ ( "table tr" ).each ( function ( index ) {
        if ( !index ) return;
        $ ( this ).find ( "td" ).each ( function () {
            let id        = $ ( this ).text ().toLowerCase ().trim ();
            let not_found = ( id.indexOf ( value ) == -1 );
            $ ( this ).closest ( 'tr' ).toggle ( !not_found );
            return not_found;
        } );
    } );
} );

/**
 -------------
 * show delete dialog box
 * for Yes or NO
 * -------------
 */

$ ( '#delete-confirmation-dialog button' ).on ( 'click', function ( e ) {
    e.preventDefault ();
    Swal.fire ( {
                    title            : "Are you sure?",
                    text             : "You won't be able to revert this!",
                    icon             : "warning",
                    showCancelButton : !0,
                    confirmButtonText: "Yes, delete it!",
                    customClass      : {
                        confirmButton: "btn btn-primary",
                        cancelButton : "btn btn-outline-danger ms-1"
                    },
                    buttonsStyling   : !1
                } ).then ( ( function ( t ) {
        if ( t.value == true )
            $ ( '#delete-confirmation-dialog' ).submit ();
    } ) )
} );

function delete_dialog ( id ) {
    Swal.fire ( {
                    title            : "Are you sure?",
                    text             : "You won't be able to revert this!",
                    icon             : "warning",
                    showCancelButton : !0,
                    confirmButtonText: "Yes, delete it!",
                    customClass      : {
                        confirmButton: "btn btn-primary",
                        cancelButton : "btn btn-outline-danger ms-1"
                    },
                    buttonsStyling   : !1
                } ).then ( ( function ( t ) {
        if ( t.value == true )
            $ ( '#delete-confirmation-dialog-' + id ).submit ();
    } ) )
}

function confirm_dialog ( id ) {
    Swal.fire ( {
                    title            : "Are you sure?",
                    text             : "The review will be updated.",
                    icon             : "warning",
                    showCancelButton : !0,
                    confirmButtonText: "Yes, do it!",
                    customClass      : {
                        confirmButton: "btn btn-primary",
                        cancelButton : "btn btn-outline-danger ms-1"
                    },
                    buttonsStyling   : !1
                } ).then ( ( function ( t ) {
        if ( t.value == true )
            $ ( '#confirmation-dialog-' + id ).submit ();
    } ) )
}

/**
 -------------
 * add more terms
 * -------------
 */

let row = 1;
$ ( '#add-more-terms' ).on ( 'click', function () {
    let nextRow = parseInt ( row ) + 1;
    row         = nextRow;
    $ ( '#add-more' ).append ( '<div class="row"><div class="col-md-9 mb-1 offset-md-3"> <label class="col-form-label font-small-4" for="title"><counter class="counter">' + row + '</counter>Title</label> <input type="text" id="title" class="form-control" name="title[]" placeholder="Term"> </div></div>' )
} );

/**
 -------------
 * show image preview
 * -------------
 */

$ ( ( function () {
    let e = $ ( "#account-upload-img" ),
        n = $ ( "#account-upload" ),
        c = $ ( ".uploadedAvatar" );
    if ( c ) {
        let s = c.attr ( "src" );
        n.on ( "change", ( function ( t ) {
            let n = new FileReader,
                c = t.target.files;
            n.onload = function () {
                e && e.attr ( "src", n.result )
            }, n.readAsDataURL ( c[ 0 ] )
        } ) )
    }
} ) );


/**
 * -------------
 * calculate tp/unit value
 * by tp/box and quantity
 * -------------
 */

function calculate_tp_unit_price () {
    let tp_box   = $ ( '.tp-box' ).val ();
    let quantity = $ ( '.quantity' ).val ();
    let tp_unit  = 0;
    if ( tp_box > 0 && quantity > 0 ) {
        tp_unit = parseFloat ( tp_box ) / parseFloat ( quantity );
    }
    $ ( '.tp-unit' ).val ( tp_unit.toFixed ( 2 ) );

    calculate_sale_unit_price ();
    increaseSalePrice ();
}

/**
 * -------------
 * calculate sale/unit value
 * by sale/box and quantity
 * -------------
 */

function calculate_sale_unit_price () {
    let quantity  = jQuery ( '.quantity' ).val ();
    let sale_box  = jQuery ( '.sale-box' ).val ();
    let sale_unit = 0;
    if ( quantity > 0 && sale_box > 0 ) {
        sale_unit = parseFloat ( sale_box ) / parseFloat ( quantity );
    }
    jQuery ( '.sale-unit' ).val ( sale_unit.toFixed ( 2 ) );
}

/**
 * -------------
 * setup ajax
 *  -------------
 */

function ajaxSetup () {
    jQuery.ajaxSetup ( {
                           headers: {
                               'X-CSRF-TOKEN': jQuery ( 'meta[name="csrf-token"]' ).attr ( 'content' )
                           }
                       } );
}

/**
 * -------------
 * ajax errors
 * @param xHR
 * @param exception
 * -------------
 */

function ajaxErrors ( xHR, exception ) {
    let msg = '';
    if ( xHR.status === 0 ) {
        msg = 'Not connect.\n Verify Network.';
    }
    else if ( xHR.status == 404 ) {
        msg = 'Requested page not found. [404]';
    }
    else if ( xHR.status == 500 ) {
        msg = 'Internal Server Error [500].';
    }
    else if ( exception === 'parsererror' ) {
        msg = 'Requested JSON parse failed.';
    }
    else if ( exception === 'timeout' ) {
        msg = 'Time out error.';
    }
    else if ( exception === 'abort' ) {
        msg = 'Ajax request aborted.';
    }
    else {
        msg = 'Uncaught Error.\n' + xHR.responseText;
    }
    Swal.fire ( {
                    title         : "Error!",
                    text          : msg,
                    icon          : "error",
                    customClass   : { confirmButton: "btn btn-primary" },
                    buttonsStyling: !1
                } );
}

/**
 * -------------
 * validate invoice no
 * should be unique
 * -------------
 */

function validateInvoiceNo () {
    let vendor_id  = $ ( '#vendors' ).val ();
    let invoice_no = $ ( '#invoice-no' ).val ();

    if ( vendor_id > 0 && invoice_no.length > 0 ) {
        ajaxSetup ();
        jQuery.ajax ( {
                          type   : 'GET',
                          url    : '/validate-invoice-no',
                          data   : {
                              invoice_no,
                              vendor_id
                          },
                          success: function ( response ) {
                              if ( response === 'true' ) {
                                  Swal.fire ( {
                                                  title         : "Error!",
                                                  text          : 'Invoice already exists.',
                                                  icon          : "error",
                                                  customClass   : { confirmButton: "btn btn-primary" },
                                                  buttonsStyling: !1
                                              } );
                              }
                          },
                          error  : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                          }
                      } )
    }
}

/**
 * -------------
 * validate invoice no
 * should be unique
 * -------------
 */

function validateAdjustmentInvoiceNo () {
    let invoice_no = $ ( '#invoice-no' ).val ();

    if ( invoice_no.length > 0 ) {
        ajaxSetup ();
        jQuery.ajax ( {
                          type   : 'GET',
                          url    : '/validate-invoice-no',
                          data   : {
                              invoice_no,
                              adjustment: 'true'
                          },
                          success: function ( response ) {
                              if ( response === 'true' ) {
                                  Swal.fire ( {
                                                  title         : "Error!",
                                                  text          : 'Invoice already exists.',
                                                  icon          : "error",
                                                  customClass   : { confirmButton: "btn btn-primary" },
                                                  buttonsStyling: !1
                                              } );
                                  $ ( '.form button' ).prop ( 'disabled', true );
                              }
                          },
                          error  : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                          }
                      } )
    }
}

/**
 * -------------
 * stop form submission
 * -------------
 */

function stopFormSubmission () {
    $ ( 'form' ).on ( 'submit', function ( e ) {
        return false;
    } );
    $ ( 'form button' ).prop ( 'disabled', true );
}

/**
 * -------------
 * start form submission
 * -------------
 */

function allowFormSubmission () {
    $ ( 'form button' ).prop ( 'disabled', false );
}

/**
 * -------------
 * let dropdown open
 * when item is selected
 * -------------
 */

$ ( "#products" ).select2 ( {
                                closeOnSelect: false,
                                multiple     : true,
                                allowClear   : true
                            } );

// $ ( "#stock-add-products" ).select2 ( {
//     closeOnSelect: false,
//     multiple: true,
//     allowClear: true,
//     createTag: function ( params ) {
//         let option = $ ( '<option>', {
//             value: params.term,
//             text: params.term
//         } );
//
//         option.insertBefore ( this.$element.find ( 'option:first-child' ) );
//
//         return {
//             id: params.term,
//             text: params.term
//         };
//     }
// } );

$ ( '#stock-add-products' ).select2 ( { closeOnSelect: false } );

$ ( "#general-sales-report .select2" ).select2 ( {
                                                     allowClear: true
                                                 } );

/**
 * -------------
 * calculate quantity
 * @param product_id
 * -------------
 */

function calculate_quantity ( product_id ) {
    let boxes     = jQuery ( '.box-quantity-' + product_id ).val ();
    let pack_size = jQuery ( '.pack-size-' + product_id ).val ();

    if ( boxes >= 0 && pack_size >= 0 ) {
        let quantity = parseInt ( boxes ) * parseInt ( pack_size );
        $ ( '.quantity-' + product_id ).val ( quantity );
    }

    calculate_total_price ( product_id );
    calculate_net_bill ( product_id );
    calculate_total ( product_id );
    calculate_per_unit_price ( product_id );

    calculate_return_unit_price ( product_id );

    let sale_box = $ ( '.sale-box-' + product_id ).val ();
    calculate_sale_price ( sale_box, product_id );
}

/**
 * -------------
 * calculate total price
 * @param product_id
 * -------------
 */

function calculate_total_price ( product_id ) {
    let tp_box   = jQuery ( '.tp-box-' + product_id ).val ();
    let quantity = jQuery ( '.box-quantity-' + product_id ).val ();
    if ( tp_box >= 0 ) {
        let total_price = parseFloat ( quantity ) * parseFloat ( tp_box );
        jQuery ( '.price-' + product_id ).val ( total_price.toFixed ( 2 ) );
    }
}

/**
 * -------------
 * calculate total
 * @type {number}
 * -------------
 */

function calculate_total ( product_id ) {
    let iSum     = 0;
    let discount = 0;

    jQuery ( '.net-price' ).each ( function () {
        if ( jQuery ( this ).val () != '' && jQuery ( this ).val () >= 0 )
            iSum = iSum + parseFloat ( jQuery ( this ).val () );
    } );

    let grand_total_discount = jQuery ( '.net-discount' ).val ();

    if ( grand_total_discount != '' && grand_total_discount >= 0 )
        discount = grand_total_discount;
    else
        discount = 0;

    let total_sum = iSum - ( iSum * ( discount / 100 ) );
    jQuery ( '.grand-total' ).val ( total_sum.toFixed ( 2 ) );
    jQuery ( '#sum-total' ).val ( total_sum );
}

/**
 * -------------
 * calculate box price
 * @param product_id
 * -------------
 */

function calculate_per_unit_price ( product_id ) {
    let boxes     = jQuery ( '.box-quantity-' + product_id ).val ();
    let pack_size = jQuery ( '.pack-size-' + product_id ).val ();
    let tp_box    = jQuery ( '.tp-box-' + product_id ).val ();
    let quantity  = jQuery ( '.quantity-' + product_id ).val ();

    if ( boxes >= 0 && pack_size >= 0 && tp_box >= 0 ) {
        let tp_unit  = ( parseFloat ( tp_box ) * parseFloat ( boxes ) / parseFloat ( quantity ) );
        let netPrice = ( parseFloat ( boxes ) * parseFloat ( tp_box ) );
        jQuery ( '.tp-unit-' + product_id ).val ( tp_unit.toFixed ( 2 ) );
        jQuery ( '.net-price-' + product_id ).val ( netPrice.toFixed ( 2 ) );
        calculate_net_bill ( product_id );
    }
}

/**
 * -------------
 * calculate return price
 * @param product_id
 * -------------
 */

function calculate_return_unit_price ( product_id ) {

    let quantity    = jQuery ( '.quantity-' + product_id ).val ();
    let return_unit = jQuery ( '.return-unit-' + product_id ).val ();

    if ( return_unit >= 0 ) {
        let netPrice = ( parseFloat ( quantity ) * parseFloat ( return_unit ) );
        jQuery ( '.net-return-unit-' + product_id ).val ( netPrice.toFixed ( 2 ) );
        calculate_return_net_bill ( product_id );
    }
}

/**
 * -------------
 * calculate net price
 * @param product_id
 * -------------
 */

function calculate_net_bill ( product_id ) {
    let total_price = jQuery ( '.price-' + product_id ).val ();
    let discount    = jQuery ( '.discount-' + product_id ).val ();
    let s_tax       = jQuery ( '.s-tax-' + product_id ).val ();

    if ( total_price >= 0 && discount >= 0 ) {

        if ( discount < 0 )
            discount = 0;

        if ( discount > 100 )
            discount = 100;

        if ( s_tax < 0 )
            s_tax = 0;

        if ( s_tax > 100 )
            s_tax = 100;

        let net_price = parseFloat ( total_price ) - ( parseFloat ( total_price ) * ( parseFloat ( discount ) / 100 ) );

        if ( s_tax > 0 ) {
            let sales_tax_value = parseFloat ( net_price ) - ( parseFloat ( net_price ) * ( parseFloat ( s_tax ) / 100 ) );
            s_tax               = ( parseFloat ( net_price ) - parseFloat ( sales_tax_value ) ).toFixed ( 2 );
            net_price           = net_price + parseFloat ( s_tax );
        }

        jQuery ( '.net-price-' + product_id ).val ( net_price.toFixed ( 2 ) );

        calculate_cost_unit ( product_id );
        calculate_discounts ();
        update_cost_unit_price ( product_id );
        calculate_box_price_after_discount_tax ( product_id );
    }
}

/**
 * -------------
 * calculate return net price
 * @param product_id
 * -------------
 */

function calculate_return_net_bill ( product_id ) {
    let iSum = 0;
    $ ( '.net-return-price' ).each ( function () {
        if ( $ ( this ).val () != '' && $ ( this ).val () >= 0 )
            iSum = iSum + parseFloat ( $ ( this ).val () );
    } );
    jQuery ( '.return-grand-total' ).val ( iSum.toFixed ( 2 ) );
}

/**
 * -------------
 * calculate per unit cost
 * @param row
 * -------------
 */

function calculate_cost_unit ( row ) {
    let net   = jQuery ( '.tp-unit' + row ).val ();
    let units = jQuery ( '.quantity-' + row ).val ();

    if ( net >= 0 && units >= 0 ) {
        let net_price = net / units;
        jQuery ( '.cost-unit-' + row ).val ( net_price.toFixed ( 2 ) );
    }
    calculate_total ( row );
}

/**
 * -------------
 * calculate cost unit price
 * @param product_id
 * -------------
 */

function update_cost_unit_price ( product_id ) {
    let net      = jQuery ( '.net-price-' + product_id ).val ();
    let quantity = jQuery ( '.box-quantity-' + product_id ).val ();
    let cost_box = parseFloat ( net ) / parseFloat ( quantity );
    jQuery ( '.cost-box-' + product_id ).val ( cost_box.toFixed ( 2 ) );
}

/**
 * -------------
 * calculate box price
 * @param product_id
 * -------------
 */

function calculate_box_price_after_discount_tax ( product_id ) {
    let net       = jQuery ( '.net-price-' + product_id ).val ();
    let quantity  = jQuery ( '.quantity-' + product_id ).val ();
    let cost_unit = parseFloat ( net ) / parseFloat ( quantity );
    jQuery ( '.tp-unit-' + product_id ).val ( cost_unit.toFixed ( 2 ) );
}

/**
 * -------------
 * calculate sale price per box
 * @param sale_price
 * @param product_id
 * -------------
 */

function calculate_sale_price ( sale_price, product_id ) {
    let price    = sale_price;
    let quantity = jQuery ( '.quantity-' + product_id ).val ();
    let boxes    = jQuery ( '.box-quantity-' + product_id ).val ();

    if ( price >= 0 && quantity >= 0 ) {
        let sale_price_per_box = ( parseFloat ( price ) * parseFloat ( boxes ) ) / parseFloat ( quantity );
        jQuery ( '.sale-unit-' + product_id ).val ( sale_price_per_box.toFixed ( 2 ) );
    }
}

/**
 * -------------
 * grand_total_discount
 * @param discount
 * -------------
 */

function calculate_grand_total_discount ( discount ) {
    calculate_total ();
    // let total_price = jQuery ( '#sum-total' ).val ();
    //
    // if ( total_price > 0 && discount >= 0 ) {
    //
    //     if ( discount < 0 )
    //         discount = 0;
    //
    //     if ( discount > 100 )
    //         discount = 100;
    //
    //     let net_price = total_price - ( total_price * ( discount / 100 ) );
    //     jQuery ( '.grand-total' ).val ( net_price.toFixed ( 2 ) );
    // }
}


/**
 * -------------
 * calculate total
 * @type {number}
 * -------------
 */

function calculate_discounts () {
    let iSum = 0;
    jQuery ( '.discounts' ).each ( function () {
        iSum = iSum + parseFloat ( jQuery ( this ).val () );
    } );

    if ( iSum > 0 )
        jQuery ( '.net-discount' ).prop ( 'readonly', true );
    else
        jQuery ( '.net-discount' ).prop ( 'readonly', false );
}

/**
 * -------------
 * let dropdown open
 * when item is selected
 * -------------
 */

$ ( "#sale-products" ).select2 ( {
                                     closeOnSelect: false,
                                     allowClear   : true
                                 } );

$ ( "#quick-sale-products" ).select2 ( {
                                           closeOnSelect: false,
                                           allowClear   : true
                                       } );

/**
 -------------
 * add products, but not allow selected
 * @type {*[]}
 * -------------
 */

$ ( document ).on ( 'change', '#sale-products', function () {
    let product_id  = $ ( this ).val ();
    let customer_id = $ ( '#sale-customer' ).val ();

    if ( typeof customer_id === 'undefined' )
        customer_id = $ ( '#sale-customer-attribute' ).val ();

    if ( parseInt ( product_id ) > 0 && parseInt ( customer_id ) > 0 && !selected.includes ( product_id ) ) {
        ajaxSetup ();
        jQuery.ajax ( {
                          type   : 'GET',
                          url    : '/add-product-for-sale',
                          data   : {
                              product_id,
                              customer_id,
                              row: $ ( '#sold-products tr' ).length
                          },
                          success: function ( response ) {
                              $ ( '#sold-products' ).prepend ( response );
                              feather.replace ( { width: 14, height: 14 } );
                              selected.push ( product_id );
                              $ ( '#sale-footer' ).removeClass ( 'd-none' );

                              $ ( '#sale-products' ).val ( '' ).trigger ( 'change' );
                              $ ( '.select2-search__field' ).val ( '' );
                              $ ( '.select2-search__field' ).focus ();
                              $ ( '#select2-sale-products-results li' ).attr ( 'aria-selected', false );
                              sale_quantity ( product_id );
                          },
                          error  : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                          }
                      } );
    }
    else if ( parseInt ( product_id ) > 0 && parseInt ( customer_id ) > 0 && selected.includes ( product_id ) ) {
        let available_qty = $ ( '.available-qty-' + product_id ).val ();
        let sale_qty      = $ ( '.sale-qty-' + product_id ).val ();

        $ ( '#sale-products' ).val ( '' ).trigger ( 'change' );
        $ ( '#select2-sale-products-results li' ).attr ( 'aria-selected', false );
        $ ( '.select2-search__field' ).val ( '' );
        $ ( '.select2-search__field' ).focus ();

        if ( parseInt ( available_qty ) > parseInt ( sale_qty ) ) {
            $ ( '.sale-qty-' + product_id ).val ( parseInt ( sale_qty ) + 1 );
            sale_quantity ( product_id );
        }
    }
} );

$ ( document ).on ( 'change', '#quick-sale-products', function () {
    let product_id  = $ ( this ).val ();
    let customer_id = $ ( '#sale-customer' ).val ();

    if ( typeof customer_id === 'undefined' )
        customer_id = $ ( '#sale-customer-attribute' ).val ();

    if ( parseInt ( product_id ) > 0 && parseInt ( customer_id ) > 0 && !selected.includes ( product_id ) ) {
        ajaxSetup ();
        jQuery.ajax ( {
                          type   : 'GET',
                          url    : '/add-product-for-quick-sale',
                          data   : {
                              product_id,
                              customer_id,
                              row: $ ( '#sold-products tr' ).length
                          },
                          success: function ( response ) {
                              $ ( '#sold-products' ).prepend ( response );
                              feather.replace ( { width: 14, height: 14 } );
                              selected.push ( product_id );
                              $ ( '#sale-footer' ).removeClass ( 'd-none' );

                              $ ( '#quick-sale-products' ).val ( '' ).trigger ( 'change' );
                              $ ( '.select2-search__field' ).val ( '' );
                              $ ( '.select2-search__field' ).focus ();
                              $ ( '#select2-quick-sale-products-results li' ).attr ( 'aria-selected', false );
                              sale_quantity ( product_id );

                              Swal.fire ( {
                                              position         : "top-end",
                                              icon             : "success",
                                              title            : "Product added to sale.",
                                              showConfirmButton: !1,
                                              timer            : 1000,
                                              customClass      : { confirmButton: "btn btn-primary" },
                                              buttonsStyling   : !1
                                          } )

                          },
                          error  : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                          }
                      } );
    }
    else if ( parseInt ( product_id ) > 0 && parseInt ( customer_id ) > 0 && selected.includes ( product_id ) ) {
        let available_qty = $ ( '.available-qty-' + product_id ).val ();
        let sale_qty      = $ ( '.sale-qty-' + product_id ).val ();

        $ ( '#quick-sale-products' ).val ( '' ).trigger ( 'change' );
        $ ( '#select2-quick-sale-products-results li' ).attr ( 'aria-selected', false );
        $ ( '.select2-search__field' ).val ( '' );
        $ ( '.select2-search__field' ).focus ();

        if ( parseInt ( available_qty ) > parseInt ( sale_qty ) ) {
            $ ( '.sale-qty-' + product_id ).val ( parseInt ( sale_qty ) + 1 );
            sale_quantity ( product_id );

            Swal.fire ( {
                            position         : "top-end",
                            icon             : "success",
                            title            : "Product quantity updated.",
                            showConfirmButton: !1,
                            timer            : 1000,
                            customClass      : { confirmButton: "btn btn-primary" },
                            buttonsStyling   : !1
                        } )
        }
    }
} );




$ ( document ).on ( 'change', '#apply-tax-products', function () {
    let product_id  = $ ( this ).val ();
    let tax_id = $ ( '#tax_id' ).val ();

    if ( parseInt ( product_id ) > 0 && parseInt ( tax_id ) > 0 && !selected.includes ( product_id ) ) {
        ajaxSetup ();
        jQuery.ajax ( {
                          type   : 'GET',
                          url    : '/add-tax-to-product',
                          data   : {
                              product_id,
                              tax_id,
                              row: $ ( '#sold-products tr' ).length
                          },
                          success: function ( response ) {
                              $ ( '#sold-products' ).prepend ( response );
                              feather.replace ( { width: 14, height: 14 } );
                              selected.push ( product_id );
                              $ ( '#sale-footer' ).removeClass ( 'd-none' );

                              $ ( '#sale-products' ).val ( '' ).trigger ( 'change' );
                              $ ( '.select2-search__field' ).val ( '' );
                              $ ( '.select2-search__field' ).focus ();
                              $ ( '#select2-sale-products-results li' ).attr ( 'aria-selected', false );

                          },
                          error  : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                          }
                      } );
    }

} );


/**
 -------------
 * add products, but not allow selected
 * @type {*[]}
 * -------------
 */

$ ( document ).on ( 'change', '#check-stock', function () {
    let product_id = $ ( this ).val ();

    if ( !selected.includes ( product_id ) ) {
        ajaxSetup ();
        jQuery.ajax ( {
                          type   : 'GET',
                          url    : '/get-stock-available-quantity',
                          data   : {
                              product_id,
                              row: $ ( '#sold-products tr' ).length
                          },
                          success: function ( response ) {
                              $ ( '#sold-products' ).append ( response );
                              selected.push ( product_id );
                              $ ( '#check-stock' ).val ( '' ).trigger ( 'change' );
                              $ ( '.select2-search__field' ).val ( '' );
                              $ ( '.select2-search__field' ).focus ();
                              $ ( '#select2-check-stock-results li' ).attr ( 'aria-selected', false );
                          },
                          error  : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                          }
                      } );
    }
    else if ( parseInt ( product_id ) > 0 && parseInt ( customer_id ) > 0 && selected.includes ( product_id ) ) {
        let available_qty = $ ( '.available-qty-' + product_id ).val ();
        let sale_qty      = $ ( '.sale-qty-' + product_id ).val ();

        $ ( '#sale-products' ).val ( '' ).trigger ( 'change' );
        $ ( '#select2-sale-products-results li' ).attr ( 'aria-selected', false );
        $ ( '.select2-search__field' ).val ( '' );
        $ ( '.select2-search__field' ).focus ();

        if ( parseInt ( available_qty ) > parseInt ( sale_qty ) ) {
            $ ( '.sale-qty-' + product_id ).val ( parseInt ( sale_qty ) + 1 );
            sale_quantity ( product_id );
        }
    }
} );

/**
 -------------
 * get the sale price of product
 * @param product_id
 * -------------
 */

function sale_quantity ( product_id ) {
    let available_qty = $ ( '.available-qty-' + product_id ).val ();
    let sale_qty      = $ ( '.sale-qty-' + product_id ).val ();
    let customer_id   = $ ( '#sale-customer' ).val ();

    if ( typeof customer_id === 'undefined' )
        customer_id = $ ( '#sale-customer-attribute' ).val ();

    if ( parseInt ( customer_id ) < 1 || customer_id === null || typeof customer_id === 'undefined' ) {
        alert ( 'Customer has not been chosen' );
        return;
    }

    if ( parseInt ( sale_qty ) > parseInt ( available_qty ) ) {
        $ ( 'form button' ).prop ( 'disabled', true );
        $ ( '.sale-qty-' + product_id ).css ( 'border', '1px solid #FF0000' );
    }
    else {

        ajaxSetup ();
        jQuery.ajax ( {
                          type      : 'GET',
                          url       : '/get-price-by-sale-quantity',
                          data      : {
                              product_id,
                              sale_qty,
                              customer_id,
                          },
                          beforeSend: function () {
                              $ ( 'button[type=submit]' ).prop ( 'disabled', true );
                          },
                          success   : function ( response ) {
                              let obj = JSON.parse ( response );
                                // Get net price and tax rate
                                let netPrice = parseFloat(obj.net_price);
                                let taxRate = obj.tax ? parseFloat(obj.tax.rate) : 0; // Ensure tax exists

                                // Calculate total price including tax
                                let totalPrice = netPrice + (netPrice * (taxRate / 100));


                              $ ( '.product-price-' + product_id + ' input' ).val ( obj.price.toFixed ( 2 ) );
                              $ ( '.product-net-price-' + product_id + ' input' ).val ( totalPrice.toFixed ( 2 ) );
                              $ ( 'form button' ).prop ( 'disabled', false );
                              $ ( '.sale-qty-' + product_id ).css ( 'border', '1px solid #D8D6DE' );
                              calculate_sale_net_price ();
                              $ ( 'button[type=submit]' ).prop ( 'disabled', false );
                          },
                          error     : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                              $ ( 'form button' ).prop ( 'disabled', false );
                              $ ( '.sale-qty-' + product_id ).css ( 'border', '1px solid #D8D6DE' );
                          }
                      } )
    }
}

/**
 * -------------
 * calculate total
 * @type {number}
 * -------------
 */

function calculate_sale_net_price () {
    let iSum             = 0;
    let discount         = 0;
    let total_sum        = 0;
    let paid_amount      = $ ( '#paid-amount' ).val ();
    let shipping         = $ ( '#shipping' ).val ();
    let shipping_charges = $ ( '#shipping-charges' ).val ();

    $ ( '.net-price' ).each ( function () {
        if ( $ ( this ).val () != '' && $ ( this ).val () >= 0 )
            iSum = iSum + parseFloat ( $ ( this ).val () );
    } );

    let grand_total_discount = jQuery ( '#sale-discount' ).val ();
    let flat_total_discount  = jQuery ( '#flat-discount' ).val ();


    if(flat_total_discount > 0 ){
        discount = flat_total_discount;
        total_sum = iSum - discount;

    }

    if(flat_total_discount > iSum){
        $ ( '#flat-discount' ).val ( '0' );
        discount = 0;
        total_sum = iSum - discount;

        alert( 'flat dsiscount should be less than ' + total_sum );


    }

    if (  grand_total_discount > 0 ){
        // alert( 'grand_total_discount ' + grand_total_discount );
        discount = grand_total_discount;
         total_sum = iSum - ( iSum * ( discount / 100 ) );

    }


    // if ( shipping === '0' ){

    //     total_sum = iSum ;
    // }


    if ( shipping === '1' )
    {
        total_sum += parseFloat ( shipping_charges );

    }

    // alert( 'total_sum before ' + total_sum  + 'iSum' + iSum  );

    $ ( '#sale-total' ).val ( iSum.toFixed ( 2 ) );
    $ ( '#net-price' ).val ( total_sum.toFixed ( 2 ) );

    if ( parseFloat ( paid_amount ) >= 0 )
        $ ( '#balance' ).val ( ( parseFloat ( total_sum ) - parseFloat ( paid_amount ) ).toFixed ( 2 ) );

}

/**
 -------------
 * handle discount change for sale
 * @param product_id
 * -------------
 */
function sale_discount(product_id) {
    let discount = $('.discount-' + product_id).val();
    let quantity = $('.sale-qty-' + product_id).val();
    let customer_id = $('#sale-customer').val();

    if (typeof customer_id === 'undefined')
        customer_id = $('#sale-customer-attribute').val();

    if (parseInt(customer_id) < 1 || customer_id === null || typeof customer_id === 'undefined') {
        alert('Customer has not been chosen');
        return;
    }

    // Validate discount
    if (discount < 0) {
        discount = 0;
        $('.discount-' + product_id).val(0);
    }

    // Get the product price and update net price
    ajaxSetup();
    jQuery.ajax({
        type: 'GET',
        url: '/get-price-by-sale-quantity',
        data: {
            product_id,
            sale_qty: quantity,
            customer_id,
        },
        beforeSend: function() {
            $('button[type=submit]').prop('disabled', true);
        },
        success: function(response) {
            let obj = JSON.parse(response);

            // Get price, net price and tax rate
            let price = parseFloat(obj.price);
            let netPrice = parseFloat(obj.net_price);
            console.log(price);
            let taxRate = obj.tax ? parseFloat(obj.tax.rate) : 0;

            // Calculate total price before discount
            let totalPrice = price * quantity;
            $('.product-price-' + product_id + ' input').val(totalPrice.toFixed(2));

            // Apply flat discount to the total price
            // Make sure discount doesn't exceed total price
            let flatDiscount = parseFloat(discount);
            if (flatDiscount > totalPrice) {
                flatDiscount = totalPrice;
                $('.discount-' + product_id).val(flatDiscount.toFixed(2));
            }

            let discountedPrice = totalPrice - flatDiscount;

            // Add tax if applicable
            let finalPrice = discountedPrice + (discountedPrice * (taxRate / 100));

            // Update the net price field
            $('.product-net-price-' + product_id + ' input').val(finalPrice.toFixed(2));
            $('.product-price-' + product_id + ' input').val(obj.price.toFixed(2));

            // Update the total calculations
            calculate_sale_net_price();
            $('button[type=submit]').prop('disabled', false);
        },
        error: function(xHR, exception) {
            ajaxErrors(xHR, exception);
            $('button[type=submit]').prop('disabled', false);
        }
    });
}

/**
 * -------------
 * remove the added product for sale
 * -------------
 */

$ ( document ).on ( 'click', '.remove-sale-product', function () {
    let product_id = $ ( this ).data ( 'product-id' );
    if ( product_id > 0 && confirm ( 'Are you sure?' ) ) {
        $ ( '.sale-product-' + product_id ).remove ();
        calculate_sale_net_price ();
        calculate_return_net_price ();
    }
} );

/**
 * -------------
 * calculate sale discount
 * -------------
 */

$ ( document ).on ( 'change', '#sale-discount', function () {
    let discount = $ ( this ).val ();
    let total    = $ ( '#sale-total' ).val ();

    if ( parseFloat ( total ) > 0 && parseFloat ( discount ) > 0 && parseFloat ( discount ) <= 100 ) {
        $ ( '#flat-discount' ).prop ( 'readonly', true );
        $ ( '#flat-discount' ).prop ( 'required', false );
        let total_sum = total - ( total * ( discount / 100 ) );
        $ ( '#net-price' ).val ( total_sum.toFixed ( 2 ) );
        $ ( '#balance' ).val ( total_sum.toFixed ( 2 ) );
    }
    else {
        $ ( '#flat-discount' ).prop ( 'readonly', false );
        $ ( '#flat-discount' ).prop ( 'required', true );
        $ ( '#net-price' ).val ( total );
        $ ( '#balance' ).val ( total );
    }
} );

$ ( document ).on ( 'change', '#shipping', function () {

    calculate_sale_net_price ();
} );

/**
 * -------------
 * calculate flat sale discount
 * -------------
 */

$ ( document ).on ( 'change', '#flat-discount', function () {
    let discount = $ ( this ).val ();
    let total    = $ ( '#sale-total' ).val ();

    if ( parseFloat ( discount ) > parseFloat ( total ) ) {
        discount = 0;
        $ ( '#flat-discount' ).val ( '0' );
    }
    else if ( parseFloat ( total ) > 0 && parseFloat ( discount ) > 0 ) {
        $ ( '#sale-discount' ).prop ( 'readonly', true );
        $ ( '#sale-discount' ).prop ( 'required', false );
        let total_sum = total - discount;
        $ ( '#net-price' ).val ( total_sum.toFixed ( 2 ) );
        $ ( '#balance' ).val ( total_sum.toFixed ( 2 ) );
    }
    else {
        $ ( '#sale-discount' ).prop ( 'readonly', false );
        $ ( '#sale-discount' ).prop ( 'required', true );
        $ ( '#net-price' ).val ( total );
        $ ( '#balance' ).val ( total );
    }
} );

/**
 * -------------
 * calculate balance
 * -------------
 */

$ ( document ).on ( 'keyup', '#paid-amount', function () {
    let paid  = $ ( this ).val ();
    let total = $ ( '#net-price' ).val ();

    if ( parseFloat ( total ) > 0 && parseFloat ( paid ) >= 0 ) {
        let balance = parseFloat ( total ) - parseFloat ( paid );
        $ ( '#balance' ).val ( balance.toFixed ( 2 ) );
    }
} );

/**
 * -------------
 * calculate tp/unit price
 * @param product_id
 * -------------
 */

function calculate_tp_per_unit_price ( product_id ) {
    let box_quantity = $ ( '.box-quantity-' + product_id ).val ();
    let tp_box       = $ ( '.tp-box-' + product_id ).val ();
    let discount     = $ ( '.discount-' + product_id ).val ();
    let sales_tax    = $ ( '.s-tax-' + product_id ).val ();
    let quantity     = jQuery ( '.quantity-' + product_id ).val ();
    let price        = 0;
    let net_price    = 0;

    price = parseInt ( box_quantity ) * parseFloat ( tp_box );
    $ ( '.price-' + product_id ).val ( price );

    if ( discount < 0 )
        discount = 0;

    if ( discount > 100 )
        discount = 100;

    if ( sales_tax < 0 )
        sales_tax = 0;

    if ( sales_tax > 100 )
        sales_tax = 100;

    net_price = parseFloat ( price ) - ( parseFloat ( price ) * ( parseFloat ( discount ) / 100 ) );

    if ( sales_tax > 0 ) {
        let sales_tax_value = parseFloat ( net_price ) - ( parseFloat ( net_price ) * ( parseFloat ( sales_tax ) / 100 ) );
        sales_tax           = ( parseFloat ( net_price ) - parseFloat ( sales_tax_value ) ).toFixed ( 2 );
        net_price           = net_price + parseFloat ( sales_tax );
    }

    $ ( '.net-price-' + product_id ).val ( net_price );

    let tp_unit = ( parseFloat ( tp_box ) * parseFloat ( box_quantity ) / parseFloat ( quantity ) );
    jQuery ( '.tp-unit-' + product_id ).val ( tp_unit.toFixed ( 2 ) );
    jQuery ( '.cost-box-' + product_id ).val ( parseFloat ( tp_box ).toFixed ( 2 ) );
    calculate_total ();
}

/**
 * -------------
 * let dropdown open
 * when item is selected
 * -------------
 */

$ ( "#customer-products-price" ).select2 ( {
                                               closeOnSelect: false,
                                               allowClear   : true
                                           } );

/**
 * -------------
 * let dropdown open
 * when item is selected
 * -------------
 */

$ ( "#customer-simple-products-price" ).select2 ( {
                                                      closeOnSelect: false,
                                                      allowClear   : true
                                                  } );

/**
 * -------------
 * let dropdown open
 * when item is selected
 * -------------
 */

// $ ( "#customer-products-price" ).select2 ( 'open' );
$ ( ".customer-update #attributes" ).select2 ( 'open' );

/**
 -------------
 * add products, but not allow selected
 * @type {*[]}
 * -------------
 */

$ ( '#customer-products-price' ).on ( 'change', function () {
    let product_id  = $ ( this ).val ();
    let customer_id = $ ( '#customer-id' ).val ();

    $ ( '.customer-product-prices' ).removeClass ( 'd-none' );
    if ( ( parseInt ( product_id ) > 0 && !selected.includes ( product_id ) ) ) {
        ajaxSetup ();
        jQuery.ajax ( {
                          type   : 'GET',
                          url    : '/add-product',
                          data   : {
                              product_id,
                              customer_id,
                          },
                          success: function ( response ) {
                              $ ( '#customer-product-prices' ).append ( response );
                              feather.replace ( { width: 14, height: 14 } );
                              selected.push ( product_id );
                          },
                          error  : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                          }
                      } )
    }
    else if ( product_id === 'select-all' ) {
        let select   = document.querySelector ( "#customer-products-price" );
        let options  = select.querySelectorAll ( "option" );
        let products = '';

        for ( let i = 0; i < options.length; i++ ) {
            if ( options[ i ].value.length > 0 && parseInt ( options[ i ].value ) > 0 ) {
                if ( i < 1 ) {
                    products += options[ i ].value;
                }
                else {
                    products += "," + options[ i ].value;
                }
                selected.push ( options[ i ].value );
            }
        }

        ajaxSetup ();
        jQuery.ajax ( {
                          type   : 'GET',
                          url    : '/add-product',
                          data   : {
                              products,
                              customer_id,
                              add_all: 'true'
                          },
                          success: function ( response ) {
                              $ ( '#customer-product-prices' ).append ( response );
                              feather.replace ( { width: 14, height: 14 } );
                          },
                          error  : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                          }
                      } )

    }
} );

/**
 -------------
 * add products, but not allow selected
 * @type {*[]}
 * -------------
 */

$ ( '#customer-simple-products-price' ).on ( 'change', function () {
    let product_id  = $ ( this ).val ();
    let customer_id = $ ( '#customer-id' ).val ();

    $ ( '.customer-product-prices' ).removeClass ( 'd-none' );
    if ( ( parseInt ( product_id ) > 0 && !selected.includes ( product_id ) ) ) {
        ajaxSetup ();
        jQuery.ajax ( {
                          type   : 'GET',
                          url    : '/add-product',
                          data   : {
                              product_id,
                              customer_id,
                          },
                          success: function ( response ) {
                              $ ( '#customer-product-prices' ).append ( response );
                              feather.replace ( { width: 14, height: 14 } );
                              selected.push ( product_id );
                          },
                          error  : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                          }
                      } )
    }
} );

/**
 * -------------
 * let dropdown open
 * when item is selected
 * -------------
 */

$ ( "#sale-customer" ).select2 ( 'open' );

/**
 -------------
 * show products, based on customer
 * @type {*[]}
 * -------------
 */

// $ ( '#sale-customer' ).on ( 'change', function () {
//     let customer_id = $ ( this ).val ();
//     if ( parseInt ( customer_id ) > 0 ) {
//         ajaxSetup ();
//         jQuery.ajax ( {
//             type: 'GET',
//             url: '/get-customer-products',
//             data: {
//                 customer_id,
//             },
//             success: function ( response ) {
//                 $ ( "#sale-products" ).html ( response );
//                 $ ( "#sale-products" ).select2 ( 'open' );
//                 // $ ( '#barcode' ).focus ();
//             },
//             error: function ( xHR, exception ) {
//                 ajaxErrors ( xHR, exception );
//             }
//         } )
//     }
// } );

$ ( '#sale-customer' ).on ( 'change', function () {
    let customer_id = $ ( this ).val ();
    if ( parseInt ( customer_id ) > 0 ) {
        $ ( "#quick-sale-products" ).select2 ( 'open' );
        $ ( "#sale-products" ).select2 ( 'open' );
        $ ( '.select2-search__field' ).focus ();
    }
} );

/**
 * -------------
 * let dropdown open
 * when item is selected
 * -------------
 */

$ ( "#sale-customer-attribute" ).select2 ( 'open' );

/**
 -------------
 * show products, based on customer
 * @type {*[]}
 * -------------
 */

// $ ( '#sale-customer-attribute' ).on ( 'change', function () {
//     let customer_id = $ ( this ).val ();
//     if ( parseInt ( customer_id ) > 0 ) {
//         ajaxSetup ();
//         jQuery.ajax ( {
//             type: 'GET',
//             url: '/get-attributes',
//             data: {
//                 customer_id,
//             },
//             success: function ( response ) {
//                 $ ( "#attributes" ).html ( response );
//                 $ ( "#attributes" ).select2 ( 'open' );
//             },
//             error: function ( xHR, exception ) {
//                 ajaxErrors ( xHR, exception );
//             }
//         } )
//     }
// } );

$ ( '#sale-customer-attribute' ).on ( 'change', function () {
    let customer_id = $ ( this ).val ();
    if ( parseInt ( customer_id ) > 0 ) {
        $ ( "#attributes" ).select2 ( 'open' );
        $ ( "#sale-by-attributes" ).select2 ( 'open' );
    }
} );

/**
 -------------
 * show products, based on customer
 * @type {*[]}
 * -------------
 */

// $ ( document ).on ( 'change', '#attributes', function () {
//     let attribute_id = $ ( this ).val ();
//
//     if ( parseInt ( attribute_id ) > 0 ) {
//         // $ ( "#sale-products" ).select2 ( 'open' );
//         $ ( "#customer-products-price" ).select2 ( 'open' );
//     }
// } );

$ ( document ).on ( 'change', '#attributes', function () {
    let attribute_id = $ ( this ).val ();

    if ( parseInt ( attribute_id ) > 0 ) {
        ajaxSetup ();
        jQuery.ajax ( {
                          type   : 'GET',
                          url    : '/get-products-by-attributes',
                          data   : {
                              attribute_id,
                          },
                          success: function ( response ) {
                              $ ( "#sale-products" ).html ( response );
                              $ ( "#sale-products" ).select2 ( 'open' );
                              $ ( '.select2-search__field' ).focus ();

                              // this is for loading products in customer edit section
                              // $ ( "#customer-products-price" ).html ( response );
                              // $ ( "#customer-products-price" ).select2 ( 'open' );
                          },
                          error  : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                          }
                      } )
    }
} );

$ ( document ).on ( 'change', '#sale-by-attributes', function () {
    let attribute_id = $ ( this ).val ();

    if ( parseInt ( attribute_id ) > 0 ) {
        ajaxSetup ();
        jQuery.ajax ( {
                          type   : 'GET',
                          url    : '/sale-products-by-attributes',
                          data   : {
                              attribute_id,
                          },
                          success: function ( response ) {
                              $ ( "#sale-products" ).html ( response );
                              $ ( "#sale-products" ).select2 ( 'open' );
                              $ ( '.select2-search__field' ).focus ();
                          },
                          error  : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                          }
                      } )
    }
} );

$ ( document ).on ( 'change', '#customer-attributes', function () {
    let attribute_id = $ ( this ).val ();
    let customer_id  = $ ( '#customer-id' ).val ();

    if ( parseInt ( attribute_id ) > 0 ) {
        ajaxSetup ();
        jQuery.ajax ( {
                          type   : 'GET',
                          url    : '/get-products-by-attributes',
                          data   : {
                              attribute_id,
                              customer_id,
                          },
                          success: function ( response ) {
                              $ ( "#customer-products-price" ).html ( response );
                              $ ( "#customer-products-price" ).select2 ( 'open' );
                          },
                          error  : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                          }
                      } )
    }
} );

// $ ( document ).on ( 'change', '#attributes', function () {
//     let attribute_id = $ ( this ).val ();
//
//     if ( parseInt ( attribute_id ) > 0 ) {
//         // $ ( "#sale-products" ).select2 ( 'open' );
//         $ ( "#customer-products-price" ).select2 ( 'open' );
//     }
// } );

function get_account_head_type ( account_head_id, transaction_type ) {
    if ( account_head_id > 0 ) {
        ajaxSetup ();
        jQuery.ajax ( {
                          type      : 'GET',
                          url       : '/get-account-head-type',
                          data      : {
                              account_head_id,
                          },
                          beforeSend: function () {
                              $ ( '#' + transaction_type + '-debit' ).prop ( 'disabled', false );
                              $ ( '#' + transaction_type + '-credit' ).prop ( 'disabled', false );
                          },
                          success   : function ( response ) {
                              // $ ( '#' + transaction_type + '-' + response ).prop ( 'checked', true );
                              //
                              // if ( response === 'credit' )
                              //     $ ( '#' + transaction_type + '-debit' ).prop ( 'disabled', true );
                              // else
                              //     $ ( '#' + transaction_type + '-credit' ).prop ( 'disabled', true );
                          },
                          error     : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                          }
                      } )
    }
}

function toggleSingleTransactions ( voucher, route ) {
    if ( voucher.length > 0 ) {

        let accountHeadID = $ ( '#first-account-head' ).val ();

        if ( voucher === 'cpv' || voucher === 'bpv' ) {
            reset_transactions ();
            $ ( '#transaction-type-credit' ).prop ( 'checked', true );
            $ ( '#transaction-type-debit' ).prop ( 'disabled', true );

            $ ( '#transaction-type-2-debit' ).prop ( 'checked', true );
            $ ( '#transaction-type-2-credit' ).prop ( 'disabled', true );
        }
        else if ( voucher === 'crv' || voucher === 'brv' ) {
            reset_transactions ();
            $ ( '#transaction-type-debit' ).prop ( 'checked', true );
            $ ( '#transaction-type-credit' ).prop ( 'disabled', true );

            $ ( '#transaction-type-2-credit' ).prop ( 'checked', true );
            $ ( '#transaction-type-2-debit' ).prop ( 'disabled', true );
        }
        else {
            reset_transactions ();
        }

        if ( parseInt ( accountHeadID ) > 0 && selectedVoucher === voucher ) {
            // do not change the first transaction dropdown
        }
        else {
            if ( voucher === 'cpv' || voucher === 'crv' ) {
                load_account_head_transaction_dropdown ( 'cash', route );
                $ ( "#payment-mode" ).val ( 'cash' ).trigger ( 'change' );
            }
            else if ( voucher === 'bpv' || voucher === 'brv' ) {
                load_account_head_transaction_dropdown ( 'bank', route );
                $ ( "#payment-mode" ).val ( 'cheque' ).trigger ( 'change' );
            }
            else {
                load_account_head_transaction_dropdown ( 'all', route );
                $ ( "#payment-mode" ).val ( 'cash' ).trigger ( 'change' );
            }
        }

        selectedVoucher = voucher;
    }
}

function load_account_head_transaction_dropdown ( type = '', route ) {
    if ( type.length > 0 ) {
        ajaxSetup ();
        jQuery.ajax ( {
                          type   : 'GET',
                          url    : route,
                          data   : {
                              type
                          },
                          success: function ( response ) {
                              $ ( '#first-account-head' ).empty ();
                              $ ( '#first-account-head' ).html ( '<option></option>' );
                              $ ( '#first-account-head' ).append ( response );
                              $ ( "#first-account-head" ).trigger ( "chosen:updated" );
                              // $ ( "#first-account-head" ).select2 ();
                          },
                          error  : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                          }
                      } )
    }
}

function reset_transactions () {
    $ ( '#transaction-type-debit' ).prop ( 'checked', false );
    $ ( '#transaction-type-debit' ).prop ( 'disabled', false );
    $ ( '#transaction-type-credit' ).prop ( 'checked', false );
    $ ( '#transaction-type-credit' ).prop ( 'disabled', false );
    $ ( '#transaction-type-2-debit' ).prop ( 'checked', false );
    $ ( '#transaction-type-2-debit' ).prop ( 'disabled', false );
    $ ( '#transaction-type-2-credit' ).prop ( 'checked', false );
    $ ( '#transaction-type-2-credit' ).prop ( 'disabled', false );
}

jQuery ( '#payment-mode' ).on ( 'change', function () {
    if ( $ ( this ).val () === 'cheque' || $ ( this ).val () === 'online' ) {
        $ ( "#transaction-no" ).removeClass ( 'd-none' );
        $ ( "#transaction-no" ).prop ( 'required', true );
    }
    else {
        $ ( "#transaction-no" ).addClass ( 'd-none' );
        $ ( "#transaction-no" ).prop ( 'required', false );
    }
} )

function addMoreTransactions ( route = '' ) {

    let rows    = $ ( '#rows' ).val ();
    let nextRow = parseInt ( rows ) + 1;
    $ ( '#rows' ).val ( nextRow );

    ajaxSetup ();
    jQuery.ajax ( {
                      type   : 'GET',
                      url    : '/add-more-transactions',
                      data   : {
                          nextRow
                      },
                      success: function ( response ) {
                          $ ( '#add-more-transactions' ).append ( response );
                          feather.replace ( { width: 14, height: 14 } );
                          $ ( ".select2" ).select2 ();

                          let value = '';
                          if ( $ ( '#transaction-type-debit' ).is ( ':checked' ) )
                              value = 'debit';
                          else if ( $ ( '#transaction-type-credit' ).is ( ':checked' ) )
                              value = 'credit';

                          toggleMultipleTransactions ( $ ( '#voucher' ).val (), route );
                          toggleJVTransactionsAddMore ( value );
                      },
                      error  : function ( xHR, exception ) {
                          ajaxErrors ( xHR, exception );
                      }
                  } )
}

$ ( document ).on ( 'change', '.initial-amount', function () {
    let initial_amount = $ ( this ).val ();
    $ ( '.first-transaction' ).val ( initial_amount );
    sumOtherAmounts ();
} );

$ ( document ).on ( 'change', '.other-amounts', function () {
    let iSum              = 0;
    let first_transaction = $ ( '.first-transaction' ).val ();

    $ ( '.other-amounts' ).each ( function () {
        if ( jQuery ( this ).val () != '' && $ ( this ).val () >= 0 )
            iSum = iSum + parseFloat ( $ ( this ).val () );
    } );
    $ ( '.other-transactions' ).val ( iSum );

    if ( parseFloat ( first_transaction ) - parseFloat ( iSum ) == 0 )
        $ ( '#multiple-transactions-btn' ).prop ( 'disabled', false );
    else
        $ ( '#multiple-transactions-btn' ).prop ( 'disabled', true );

} );

function sumOtherAmounts () {
    let iSum              = 0;
    let first_transaction = $ ( '.initial-amount' ).val ();

    $ ( '.other-amounts' ).each ( function () {
        if ( jQuery ( this ).val () != '' && $ ( this ).val () >= 0 )
            iSum = iSum + parseFloat ( $ ( this ).val () );
    } );
    $ ( '.other-transactions' ).val ( iSum );

    if ( parseFloat ( first_transaction ) - parseFloat ( iSum ) == 0 )
        $ ( '#multiple-transactions-btn' ).prop ( 'disabled', false );
    else
        $ ( '#multiple-transactions-btn' ).prop ( 'disabled', true );

}

$ ( "#transfer-products" ).select2 ( {
                                         closeOnSelect: false,
                                         allowClear   : true
                                     } );

$ ( document ).on ( 'change', '#transfer-from-branch', function () {
    let branch_id = $ ( this ).val ();

    if ( parseInt ( branch_id ) > 0 ) {
        ajaxSetup ();
        jQuery.ajax ( {
                          type   : 'GET',
                          url    : '/get-products-branch-wise',
                          data   : {
                              branch_id
                          },
                          success: function ( response ) {
                              $ ( '#transfer-products' ).html ( response );
                              $ ( '#transfer-products' ).select2 ( 'open' );
                          },
                          error  : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                          }
                      } )
    }

} );

$ ( '#transfer-products' ).on ( 'change', function () {
    let product_id = $ ( this ).val ();

    if ( parseInt ( product_id ) > 0 && !selected.includes ( product_id ) ) {
        ajaxSetup ();
        jQuery.ajax ( {
                          type   : 'GET',
                          url    : '/transfer-product',
                          data   : {
                              product_id,
                          },
                          success: function ( response ) {
                              $ ( '#transfer-products-table' ).append ( response );
                              feather.replace ( { width: 14, height: 14 } );
                              selected.push ( product_id );

                              $ ( '#transfer-products' ).val ( '' ).trigger ( 'change' );
                              $ ( '.select2-search__field' ).val ( '' );
                              $ ( '.select2-search__field' ).focus ();
                              $ ( '#select2-transfer-products-results li' ).attr ( 'aria-selected', false );

                          },
                          error  : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                          }
                      } )
    }
} );

/**
 -------------
 * get the sale price of product
 * @param product_id
 * -------------
 */

function transfer_quantity ( product_id ) {
    let available_qty = $ ( '.available-qty-' + product_id ).val ();
    let sale_qty      = $ ( '.sale-qty-' + product_id ).val ();

    if ( parseInt ( sale_qty ) > parseInt ( available_qty ) ) {
        $ ( 'form button' ).prop ( 'disabled', true );
        $ ( '.sale-qty-' + product_id ).css ( 'border', '1px solid #FF0000' );
    }
    else {
        $ ( 'form button' ).prop ( 'disabled', false );
        $ ( '.sale-qty-' + product_id ).css ( 'border', '1px solid #D8D6DE' );
    }
}

$ ( document ).on ( 'click', '.remove-stock-product', function () {
    let stock_product_id = $ ( this ).data ( 'stock-product-id' );
    let route            = $ ( this ).data ( 'url' );

    if ( parseInt ( stock_product_id ) > 0 && confirm ( 'Are you sure?' ) ) {
        ajaxSetup ();
        jQuery.ajax ( {
                          type   : 'GET',
                          url    : route,
                          success: function () {
                              $ ( '#stock-product-id-' + stock_product_id ).remove ();
                              $ ( '#stock-id-' + stock_product_id ).remove ();
                          },
                          error  : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                          }
                      } )
    }
} );

/**
 * -------------
 * let dropdown open
 * when item is selected
 * -------------
 */

$ ( "select#return-vendor" ).select2 ( 'open' );

$ ( "#return-products" ).select2 ( {
                                       closeOnSelect: false,
                                       allowClear   : true
                                   } );

$ ( '#return-vendor' ).on ( 'change', function () {
    let vendor_id = $ ( this ).val ();
    if ( parseInt ( vendor_id ) > 0 ) {
        $ ( "#return-products" ).select2 ( 'open' );
        $ ( '.select2-search__field' ).focus ();
    }
} );

$ ( '#return-products' ).on ( 'change', function () {
    let product_id = $ ( this ).val ();

    if ( parseInt ( product_id ) > 0 && !selected.includes ( product_id ) ) {
        ajaxSetup ();
        jQuery.ajax ( {
                          type   : 'GET',
                          url    : '/add-product-for-return',
                          data   : {
                              product_id,
                          },
                          success: function ( response ) {
                              $ ( '#returned-products' ).append ( response );
                              feather.replace ( { width: 14, height: 14 } );
                              selected.push ( product_id );
                              $ ( '#return-footer' ).removeClass ( 'd-none' );

                              $ ( '#return-products' ).val ( '' ).trigger ( 'change' );
                              $ ( '.select2-search__field' ).val ( '' );
                              $ ( '.select2-search__field' ).focus ();
                              $ ( '#select2-return-products-results li' ).attr ( 'aria-selected', false );

                              return_quantity ( product_id );
                          },
                          error  : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                          }
                      } )
    }
    else if ( parseInt ( product_id ) > 0 && selected.includes ( product_id ) ) {
        let available_qty = $ ( '.available-qty-' + product_id ).val ();
        let sale_qty      = $ ( '.sale-qty-' + product_id ).val ();

        $ ( '#return-products' ).val ( '' ).trigger ( 'change' );
        $ ( '#select2-return-products-results li' ).attr ( 'aria-selected', false );
        $ ( '.select2-search__field' ).val ( '' );
        $ ( '.select2-search__field' ).focus ();

        if ( parseInt ( available_qty ) > parseInt ( sale_qty ) ) {
            $ ( '.sale-qty-' + product_id ).val ( parseInt ( sale_qty ) + 1 );
            return_quantity ( product_id );
        }
    }
} )

/**
 -------------
 * get the sale price of product
 * @param product_id
 * -------------
 */

function return_quantity ( product_id ) {
    let available_qty = $ ( '.available-qty-' + product_id ).val ();
    let sale_qty      = $ ( '.sale-qty-' + product_id ).val ();
    let vendor_id     = $ ( '#return-vendor' ).val ();

    if ( parseInt ( vendor_id ) < 1 || vendor_id === null || typeof vendor_id === 'undefined' ) {
        alert ( 'Vendor has not been chosen' );
        return;
    }

    if ( parseInt ( sale_qty ) > parseInt ( available_qty ) ) {
        $ ( 'form button' ).prop ( 'disabled', true );
        $ ( '.sale-qty-' + product_id ).css ( 'border', '1px solid #FF0000' );
    }
    else {

        ajaxSetup ();
        jQuery.ajax ( {
                          type   : 'GET',
                          url    : '/get-price',
                          data   : {
                              product_id,
                              sale_qty,
                          },
                          success: function ( response ) {
                              let obj = JSON.parse ( response );
                              $ ( '.product-price-' + product_id + ' input' ).val ( obj.price.toFixed ( 2 ) );
                              $ ( '.product-net-price-' + product_id + ' input' ).val ( obj.net_price.toFixed ( 2 ) );
                              $ ( 'form button' ).prop ( 'disabled', false );
                              $ ( '.sale-qty-' + product_id ).css ( 'border', '1px solid #D8D6DE' );
                              calculate_return_net_price ();
                          },
                          error  : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                              $ ( 'form button' ).prop ( 'disabled', false );
                              $ ( '.sale-qty-' + product_id ).css ( 'border', '1px solid #D8D6DE' );
                          }
                      } )
    }
}

/**
 * -------------
 * calculate total
 * @type {number}
 * -------------
 */

function calculate_return_net_price () {
    let iSum = 0;

    $ ( '.net-price' ).each ( function () {
        if ( $ ( this ).val () !== '' && $ ( this ).val () >= 0 )
            iSum = iSum + parseFloat ( $ ( this ).val () );
    } );

    $ ( '#return-total' ).val ( iSum.toFixed ( 2 ) );
    $ ( '#net-return-total' ).val ( iSum.toFixed ( 2 ) );

}

$ ( document ).on ( 'change', '.add-stock-products', function ( e ) {
    e.preventDefault ();
    $ ( '.select2-search__field' ).val ( '' );
    $ ( '.select2-search__field' ).focus ();
} );

function fetch_attribute_terms ( attribute_id ) {

    if ( attribute_id > 0 ) {
        ajaxSetup ();
        jQuery.ajax ( {
                          type   : 'GET',
                          url    : '/settings/fetch-attribute-terms',
                          data   : {
                              attribute_id,
                          },
                          success: function ( response ) {
                              $ ( '#terms-dropdown' ).html ( response );
                          },
                          error  : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                          }
                      } )
    }
}

$ ( document ).on ( 'click', '#cash-customer', function () {
    if ( $ ( this ).is ( ':checked' ) ) {
        $ ( '#paid-amount' ).prop ( 'readonly', false );
        $ ( '#paid-amount' ).prop ( 'required', true );
    }
    else {
        $ ( '#paid-amount' ).prop ( 'readonly', true );
        $ ( '#paid-amount' ).prop ( 'required', false );
    }
} );

$ ( document ).on ( 'click', '#credit-customer', function () {
    if ( $ ( this ).is ( ':checked' ) ) {
        $ ( '#paid-amount' ).prop ( 'readonly', true );
        $ ( '#paid-amount' ).prop ( 'required', false );
    }
    else {
        $ ( '#paid-amount' ).prop ( 'readonly', false );
        $ ( '#paid-amount' ).prop ( 'required', true );
    }
} );

function toggle_manual_price ( product_id ) {
    if ( $ ( '#manual-price-' + product_id ).is ( ':checked' ) ) {
        $ ( '.price-' + product_id ).prop ( 'readonly', false );
    }
    else {
        $ ( '.price-' + product_id ).prop ( 'readonly', true );
    }
}

$ ( '#toggleTheme' ).on ( 'click', function () {
    ajaxSetup ();
    jQuery.ajax ( {
                      type   : 'GET',
                      url    : '/users/theme',
                      success: function ( response ) {

                      },
                      error  : function ( xHR, exception ) {
                          ajaxErrors ( xHR, exception );
                      }
                  } )
} );

function update_product_prices_by_attribute ( price, attribute_id ) {
    if ( price.length > 0 && parseFloat ( price ) >= 0 ) {
        $ ( '.attribute-id-' + attribute_id ).val ( price );
    }
}

$ ( document ).on ( 'change', '#update-new-added-products-price', function () {
    let price = $ ( '#update-new-added-products-price' ).val ();
    if ( parseFloat ( price ) >= 0 )
        $ ( '.customer-product-prices .customer-product' ).val ( price );
    else
        $ ( '.customer-product-prices .customer-product' ).val ( '0' );
} );

$ ( "#check-stock" ).select2 ( {
                                   closeOnSelect: false,
                                   allowClear   : true
                               } );
$ ( "#check-stock" ).select2 ( 'open' );

function toggle_attribute_products ( attribute_id ) {
    $ ( '.attribute-products-' + attribute_id ).toggleClass ( 'd-none' );

    if ( $ ( '.attribute-products-' + attribute_id ).hasClass ( 'd-none' ) )
        $ ( '.icon-' + attribute_id ).html ( '<i data-feather="chevron-down" style="width: 25px; height: 25px;"></i>' );
    else
        $ ( '.icon-' + attribute_id ).html ( '<i data-feather="chevron-up" style="width: 25px; height: 25px;"></i>' );

    feather.replace ( { width: 25, height: 25 } );
}

function updateBulkPrice ( price, input_class ) {
    $ ( input_class ).val ( price );
}

$ ( "#user-customers" ).select2 ( {
                                      closeOnSelect: false,
                                      multiple     : true,
                                      allowClear   : true
                                  } );

function toggleMultipleTransactions ( voucher, route ) {
    if ( voucher.length > 0 ) {

        let accountHeadID = $ ( '#first-account-head' ).val ();

        if ( voucher === 'cpv' || voucher === 'bpv' ) {
            reset_other_transactions ();
            $ ( '#transaction-type-credit' ).prop ( 'checked', true );
            $ ( '#transaction-type-debit' ).prop ( 'disabled', true );

            $ ( '.other-transactions-debit' ).prop ( 'checked', true );
            $ ( '.other-transactions-credit' ).prop ( 'disabled', true );
        }
        else if ( voucher === 'crv' || voucher === 'brv' ) {
            reset_other_transactions ();
            $ ( '#transaction-type-debit' ).prop ( 'checked', true );
            $ ( '#transaction-type-credit' ).prop ( 'disabled', true );

            $ ( '.other-transactions-credit' ).prop ( 'checked', true );
            $ ( '.other-transactions-debit' ).prop ( 'disabled', true );
        }
        else {
            // reset_other_transactions ();
        }

        if ( parseInt ( accountHeadID ) > 0 && selectedVoucher === voucher ) {
            // do not change the first transaction dropdown
        }
        else {
            if ( voucher === 'cpv' || voucher === 'crv' ) {
                load_account_head_transaction_dropdown ( 'cash', route );
                $ ( "#payment-mode" ).val ( 'cash' ).trigger ( 'change' );
            }
            else if ( voucher === 'bpv' || voucher === 'brv' ) {
                load_account_head_transaction_dropdown ( 'bank', route );
                $ ( "#payment-mode" ).val ( 'cheque' ).trigger ( 'change' );
            }
            else {
                load_account_head_transaction_dropdown ( 'all', route );
                $ ( "#payment-mode" ).val ( 'cash' ).trigger ( 'change' );
            }
        }

        selectedVoucher = voucher;
    }
}

function reset_other_transactions () {
    $ ( '#transaction-type-debit' ).prop ( 'checked', false );
    $ ( '#transaction-type-debit' ).prop ( 'disabled', false );
    $ ( '#transaction-type-credit' ).prop ( 'checked', false );
    $ ( '#transaction-type-credit' ).prop ( 'disabled', false );

    $ ( '.other-transactions-debit' ).prop ( 'checked', false );
    $ ( '.other-transactions-debit' ).prop ( 'disabled', false );
    $ ( '.other-transactions-credit' ).prop ( 'checked', false );
    $ ( '.other-transactions-credit' ).prop ( 'disabled', false );
}

function setTransactionPrice ( price ) {
    $ ( '.amount' ).val ( price );
}

function toggleJVTransactions ( value, searchVoucher = '' ) {
    let voucher = $ ( '#voucher' ).val ();

    if ( searchVoucher.length > 0 )
        voucher = searchVoucher;

    if ( voucher.length > 0 && voucher === 'jv' ) {
        if ( value === 'credit' ) {
            $ ( '#transaction-type-2-debit' ).prop ( 'checked', true );
            $ ( '#transaction-type-2-credit' ).prop ( 'disabled', true );

            $ ( '#transaction-type-2-debit' ).prop ( 'disabled', false );
            $ ( '#transaction-type-2-credit' ).prop ( 'checked', false );

            $ ( '.other-transactions-credit' ).prop ( 'disabled', false );
            $ ( '.other-transactions-debit' ).prop ( 'disabled', false );
            $ ( '.other-transactions-debit' ).prop ( 'checked', true );
            $ ( '.other-transactions-credit' ).prop ( 'disabled', true );
        }
        else if ( value === 'debit' ) {
            $ ( '#transaction-type-2-credit' ).prop ( 'checked', true );
            $ ( '#transaction-type-2-debit' ).prop ( 'disabled', true );

            $ ( '#transaction-type-2-credit' ).prop ( 'disabled', false );
            $ ( '#transaction-type-2-debit' ).prop ( 'checked', false );

            $ ( '.other-transactions-credit' ).prop ( 'disabled', false );
            $ ( '.other-transactions-debit' ).prop ( 'disabled', false );
            $ ( '.other-transactions-debit' ).prop ( 'disabled', true );
            $ ( '.other-transactions-credit' ).prop ( 'checked', true );
        }
    }
}

function toggleJVTransactionsAddMore ( value ) {
    let voucher = $ ( '#voucher' ).val ();

    if ( voucher.length > 0 && voucher === 'jv' ) {
        if ( value === 'credit' ) {
            $ ( '.other-transactions-credit' ).prop ( 'disabled', false );
            $ ( '.other-transactions-debit' ).prop ( 'disabled', false );
            $ ( '.other-transactions-debit' ).prop ( 'checked', true );
            $ ( '.other-transactions-credit' ).prop ( 'disabled', true );
        }
        else if ( value === 'debit' ) {
            $ ( '.other-transactions-credit' ).prop ( 'disabled', false );
            $ ( '.other-transactions-debit' ).prop ( 'disabled', false );
            $ ( '.other-transactions-debit' ).prop ( 'disabled', true );
            $ ( '.other-transactions-credit' ).prop ( 'checked', true );
        }
    }
}

function loadCustomerOrVendorDropdown ( account_head_id, route ) {
    let voucher = $ ( '#voucher' ).val ();
    if ( account_head_id.length > 0 && voucher !== 'jv' ) {
        ajaxSetup ();
        jQuery.ajax ( {
                          type   : 'GET',
                          url    : route,
                          data   : {
                              account_head_id
                          },
                          success: function ( response ) {
                              let $transactionDropdown = $ ( '#transaction-dropdown' );
                              $transactionDropdown.empty ();
                              $transactionDropdown.html ( response );
                              $ ( '.select2' ).select2 ();
                          },
                          error  : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                          }
                      } )
    }
}

function get_account_head_running_balance ( account_head_id, route ) {
    if ( parseInt ( account_head_id ) > 0 && route.length > 0 ) {
        ajaxSetup ();
        jQuery.ajax ( {
                          type   : 'GET',
                          url    : route,
                          data   : {
                              account_head_id
                          },
                          success: function ( response ) {
                              $ ( '#due-amount' ).val ( response );
                          },
                          error  : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                          }
                      } )
    }
}

function getBanks ( payment_mode, route ) {
    if ( payment_mode.length > 0 && ( payment_mode === 'brv' || payment_mode === 'bpv' ) && route.length > 0 ) {
        ajaxSetup ();
        jQuery.ajax ( {
                          type   : 'GET',
                          url    : route,
                          success: function ( response ) {
                              let bank = $ ( '#bank-id' );
                              $ ( '#banks' ).removeClass ( 'd-none' );
                              bank.prop ( 'disabled', false );
                              bank.html ( response );
                              bank.trigger ( "chosen:updated" );
                              bank.prop ( 'required', true );
                          },
                          error  : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                          }
                      } )
    }
    else {
        $ ( '#bank-id' ).prop ( 'disabled', true );
        $ ( '#banks' ).addClass ( 'd-none' );
    }
}

function validateSKU ( sku, route ) {
    if ( sku.length > 0 && route.length > 0 ) {
        ajaxSetup ();
        jQuery.ajax ( {
                          type   : 'GET',
                          url    : route,
                          data   : { sku },
                          success: function ( response ) {
                              if ( response === '1' ) {
                                  $ ( '#sku' ).addClass ( 'border-danger' );
                                  $ ( '.card-footer button' ).prop ( 'disabled', true );
                              }
                              else {
                                  $ ( '#sku' ).removeClass ( 'border-danger' );
                                  $ ( '.card-footer button' ).prop ( 'disabled', false );
                              }
                          },
                          error  : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                          }
                      } )
    }
}

function validateBarcode ( barcode, route ) {
    if ( barcode.length > 0 && route.length > 0 ) {
        ajaxSetup ();
        jQuery.ajax ( {
                          type   : 'GET',
                          url    : route,
                          data   : { barcode },
                          success: function ( response ) {
                              if ( response === '1' ) {
                                  $ ( '#barcode' ).addClass ( 'border-danger' );
                                  $ ( '.card-footer button' ).prop ( 'disabled', true );
                              }
                              else {
                                  $ ( '#barcode' ).removeClass ( 'border-danger' );
                                  $ ( '.card-footer button' ).prop ( 'disabled', false );
                              }
                          },
                          error  : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                          }
                      } )
    }
}

function togglePriceFilter () {
    let appreciation = $ ( '#price-appreciation' );
    let depreciation = $ ( '#price-depreciation' );

    if ( parseFloat ( appreciation.val () ) > 0 ) {
        depreciation.val ( '0' );
        depreciation.prop ( 'readonly', true );
    }
    else {
        depreciation.prop ( 'readonly', false );
    }

    if ( parseFloat ( depreciation.val () ) > 0 ) {
        appreciation.val ( '0' );
        appreciation.prop ( 'readonly', true );
    }
    else {
        appreciation.prop ( 'readonly', false );
    }
}

function addNewProduct ( route, type = 'simple' ) {
    if ( route.length > 0 ) {
        ajaxSetup ();
        jQuery.ajax ( {
                          type   : 'GET',
                          url    : route,
                          data   : {
                              type
                          },
                          success: function ( response ) {
                              $ ( '#ajaxContent' ).html ( response );
                              $ ( '#modal' ).modal ( 'show' );
                              $ ( '.select2' ).select2 ();
                          },
                          error  : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                          }
                      } )
    }
}

function submitAddNewProductForm ( event, route ) {
    event.preventDefault ();
    let formElement = document.getElementById ( 'addNewProduct' );

    if ( route.length > 0 ) {
        ajaxSetup ();
        jQuery.ajax ( {
                          type       : 'POST',
                          url        : route,
                          data       : new FormData ( formElement ),
                          processData: false,
                          contentType: false,
                          cache      : false,
                          success    : function ( response ) {
                              Swal.fire ( {
                                              title         : "Success!",
                                              text          : 'Product has been added. Click Add More button to load new Product',
                                              icon          : "success",
                                              customClass   : { confirmButton: "btn btn-primary" },
                                              buttonsStyling: !1
                                          } );

                              $ ( '#modal' ).modal ( 'hide' );
                              $ ( '#ajaxContent' ).empty ();
                          },
                          error      : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                          }
                      } )
    }
}

function addMoreStockProduct ( route ) {
    if ( route.length > 0 ) {
        ajaxSetup ();
        jQuery.ajax ( {
                          type   : 'GET',
                          url    : route,
                          success: function ( response ) {
                              $ ( '#ajaxContent' ).html ( response );
                              $ ( '#modal' ).modal ( 'show' );
                              $ ( '.select2' ).select2 ();
                          },
                          error  : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                          }
                      } )
    }
}

function addStockProduct ( route, product_id ) {
    if ( route.length > 0 && parseInt ( product_id ) > 0 && !selected.includes ( product_id ) ) {
        let counter = $ ( '#counter' );
        let nextRow = parseInt ( counter.val () ) + 1;
        counter.val ( nextRow );

        ajaxSetup ();
        jQuery.ajax ( {
                          type   : 'GET',
                          url    : route,
                          data   : { product_id, nextRow },
                          success: function ( response ) {
                              $ ( '#addProducts' ).append ( response );
                              feather.replace ( { width: 14, height: 14 } );
                              selected.push ( product_id );
                              $ ( '#product-option-' + product_id ).prop ( 'disabled', true );

                              $ ( '#stock-add-products' ).val ( '' ).trigger ( 'change' );
                              $ ( '.select2-search__field' ).val ( '' );
                              $ ( '.select2-search__field' ).focus ();
                              $ ( '#select2-stock-add-products-results li' ).attr ( 'aria-selected', false );
                          },
                          error  : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                          }
                      } )
    }
}

function removeStockRow ( product_id ) {
    if ( confirm ( 'Are you sure?' ) ) {
        $ ( '#row-' + product_id ).remove ();
        let counter = $ ( '#counter' );
        let nextRow = parseInt ( counter.val () ) - 1;
        counter.val ( nextRow );

        for ( let i = selected.length - 1; i >= 0; i-- ) {
            if ( parseInt ( selected[ i ] ) === parseInt ( product_id ) ) {
                selected.splice ( i, 1 );
            }
        }

        $ ( '#product-option-' + product_id ).prop ( 'disabled', false );
    }
}

function calculate_customer_return_stock_discount ( discount = 0, discount_type = 'percentage' ) {
    let iSum                = 0;
    let total_sum           = 0;
    let flat_discount       = $ ( '#flat-return-discount' );
    let percentage_discount = $ ( '#return-discount' );

    jQuery ( '.net-return-price' ).each ( function () {
        if ( jQuery ( this ).val () != '' && jQuery ( this ).val () >= 0 )
            iSum = iSum + parseFloat ( jQuery ( this ).val () );
    } );

    if ( discount_type === 'percentage' && parseFloat ( discount ) > 0 ) {
        flat_discount.val ( '0' );
        flat_discount.prop ( 'readonly', true );
        percentage_discount.prop ( 'readonly', false );

        if ( parseFloat ( discount ) < 0 )
            discount = 0;

        if ( parseFloat ( discount ) > 100 )
            discount = 100;

        total_sum = iSum - ( iSum * ( discount / 100 ) );
    }
    else if ( parseFloat ( discount ) > 0 ) {
        percentage_discount.val ( '0' );
        percentage_discount.prop ( 'readonly', true );
        flat_discount.prop ( 'readonly', false );

        total_sum = iSum - discount;
    }
    else {
        percentage_discount.val ( '0' );
        percentage_discount.prop ( 'readonly', false );
        flat_discount.val ( '0' );
        flat_discount.prop ( 'readonly', false );
    }

    jQuery ( '.return-grand-total' ).val ( total_sum.toFixed ( 2 ) );
}

function calculate_vendor_stock_return_total ( discount = 0 ) {
    let iSum      = 0;
    let total_sum = 0;

    jQuery ( '.net-price' ).each ( function () {
        if ( jQuery ( this ).val () !== '' && jQuery ( this ).val () >= 0 )
            iSum = iSum + parseFloat ( jQuery ( this ).val () );
    } );

    total_sum = iSum - discount;

    jQuery ( '#net-return-total' ).val ( total_sum.toFixed ( 2 ) );
}

function downloadExcel ( title ) {
    // Get the HTML table
    let table = document.getElementById ( "excel-table" );

    // Convert the table to a sheet object
    let sheet = XLSX.utils.table_to_sheet ( table );

    // Create a workbook object
    let workbook = XLSX.utils.book_new ();

    // Add the sheet to the workbook
    XLSX.utils.book_append_sheet ( workbook, sheet, "Sheet1" );

    // Convert the workbook to a binary string
    let wbout = XLSX.write ( workbook, { bookType: "xlsx", type: "binary" } );

    // Create a Blob object from the binary string
    let blob = new Blob ( [ s2ab ( wbout ) ], { type: "application/octet-stream" } );

    // Create a download link and click it
    let url    = window.URL.createObjectURL ( blob );
    let a      = document.createElement ( "a" );
    a.href     = url;
    a.download = title + ".xlsx";
    a.click ();
    window.URL.revokeObjectURL ( url );
}

function s2ab ( s ) {
    let buf  = new ArrayBuffer ( s.length );
    let view = new Uint8Array ( buf );
    for ( let i = 0; i < s.length; i++ ) view[ i ] = s.charCodeAt ( i ) & 0xff;
    return buf;
}

function addVariations ( route ) {
    if ( route.length > 0 ) {
        ajaxSetup ();
        jQuery.ajax ( {
                          type   : 'GET',
                          url    : route,
                          success: function ( response ) {
                              $ ( '#ajaxContent' ).html ( response );
                              $ ( '#modal' ).modal ( 'show' );
                              $ ( '.select2' ).select2 ( {
                                                             closeOnSelect: false,
                                                             multiple     : true,
                                                         } );
                          },
                          error  : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                          }
                      } )
    }
}

function quickEditProduct ( route ) {
    if ( route.length > 0 ) {
        ajaxSetup ();
        jQuery.ajax ( {
                          type   : 'GET',
                          url    : route,
                          success: function ( response ) {
                              $ ( '#ajaxContent' ).html ( response );
                              $ ( '#modal' ).modal ( 'show' );
                              $ ( '.select2' ).select2 ();
                          },
                          error  : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                          }
                      } )
    }
}

function addStockIncreaseProduct ( route, product_id ) {
    if ( route.length > 0 && parseInt ( product_id ) > 0 && !selected.includes ( product_id ) ) {
        let counter = $ ( '#counter' );
        let nextRow = parseInt ( counter.val () ) + 1;
        counter.val ( nextRow );

        ajaxSetup ();
        jQuery.ajax ( {
                          type   : 'GET',
                          url    : route,
                          data   : { product_id, nextRow },
                          success: function ( response ) {
                              $ ( '#addProducts' ).append ( response );
                              feather.replace ( { width: 14, height: 14 } );
                              selected.push ( product_id );
                              $ ( '#product-option-' + product_id ).prop ( 'disabled', true );

                              $ ( '#stock-add-products' ).val ( '' ).trigger ( 'change' );
                              $ ( '.select2-search__field' ).val ( '' );
                              $ ( '.select2-search__field' ).focus ();
                              $ ( '#select2-stock-add-products-results li' ).attr ( 'aria-selected', false );
                          },
                          error  : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                          }
                      } )
    }
}

function loadTrackingPopup ( route ) {
    if ( route.length > 0 ) {
        ajaxSetup ();
        jQuery.ajax ( {
                          type   : 'GET',
                          url    : route,
                          success: function ( response ) {
                              $ ( '#ajaxContent' ).html ( response );
                              $ ( '#modal' ).modal ( 'show' );
                          },
                          error  : function ( xHR, exception ) {
                              ajaxErrors ( xHR, exception );
                          }
                      } )
    }
}
