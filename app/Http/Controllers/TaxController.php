<?php

namespace App\Http\Controllers;

use App\Http\Services\TaxService;
use App\Http\Services\ProductService;
use App\Models\Tax;
use App\Models\Product;
use Illuminate\Http\Request;

class TaxController extends Controller
{
    protected TaxService $taxService;
    protected object $productService;

    public function __construct(TaxService $taxService, ProductService $productService)
    {
        $this->taxService = $taxService;
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title'] = 'All Taxes';
        $data['taxes'] = $this->taxService->all();
        return view('settings.tax.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['title'] = 'Add Tax';
        return view('settings.tax.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'rate'  => 'required|numeric|min:0'
        ]);

        $this->taxService->save($request);

        return redirect()->route('taxes.index')->with('success', 'Tax created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tax $tax)
    {
        $data['title'] = 'Edit Tax';
        $data['tax'] = $tax;
        return view('settings.tax.update', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tax $tax)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'rate'  => 'required|numeric|min:0'
        ]);

        $this->taxService->edit($request, $tax);

        return redirect()->route('taxes.index')->with('success', 'Tax updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tax $tax)
    {
        $this->taxService->delete($tax);

        return redirect()->route('taxes.index')->with('success', 'Tax deleted successfully.');
    }


    public  function  apply(){
        $data['title'] = 'Apply Tax';
        $data[ 'products' ]  = $this -> productService -> active_products_with_stock ();
        $data[ 'taxes' ]      = $this -> taxService -> all ();
        return view('settings.tax.apply' , $data);
    }


    public function add_tax_to_product ( Request $request ) {
        $product_id  = $request -> input ( 'product_id' );
        $tax_id = $request -> input ( 'tax_id' );

        if ( $product_id > 0 && is_numeric ( $product_id ) && $tax_id > 0 && is_numeric ( $tax_id ) ) {
            $product           = Product ::find ( $product_id );
            $data[ 'product' ] = $product;
            $data[ 'row' ]     = $request -> input ( 'row' );
            return view ( 'sales.add-product-for-tax', $data ) -> render ();
        }

    }

    public function applyOnProduct(Request $request)
    {
        // Get the tax ID from the request
        $taxId = $request->input('tax_id');
        $productIds = $request->input('products');

        // Loop through each product ID and update the tax_id
        foreach ($productIds as $productId) {
            $product = \App\Models\Product::find($productId);

            if ($product) {
                $product->tax_id = $taxId;
                $product->save();  // Save the changes
            }
        }
        return redirect () -> back () -> with ( 'message', 'Tax applied to products successfully.' );
    }


}
