<?php

namespace App\Http\Services;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleProducts;
use App\Models\Stock;
use App\Models\StockReturn;
use App\Models\StockTake;
use App\Models\StockTakeItem;
use Illuminate\Support\Facades\DB;

class InvoiceService {

    public function daily_closing_summary_service($startDate, $endDate, $branchId, $userId = null)
    {
        // Fetch active products (assuming this method retrieves all relevant products)
        $products =  Product ::with ( [
            'manufacturer',
            'category',
            'term',
        ] ) -> active () -> latest () -> get ();

        // Initialize totals
        $totalRevenue = 0;
        $totalReturnAmount = 0;
        $totalRefundedAmount = 0;
        $netSale = 0;

        // Process each product
        $sortedProducts = $products->map(function ($product) use ($startDate, $endDate, $branchId, $userId, &$totalRevenue, &$totalReturnAmount, &$totalRefundedAmount, &$netSale) {
            // Get the total revenue, return amount, and refunded amount for each product
            $TotalRevenue = $product->revenue_between_dates_by_product_by_branchand_by_user($startDate, $endDate, '', $branchId, $userId);
            $ReturnAmount = $product->returned_amount_between_dates($startDate, $endDate, $userId);
            $RefundedAmount = $product->refund_amount_between_dates($startDate, $endDate);

            // Accumulate totals
            $totalRevenue += $TotalRevenue;
            $totalReturnAmount += $ReturnAmount;
            $totalRefundedAmount += $RefundedAmount;
            $netSale += $TotalRevenue - ($ReturnAmount + $RefundedAmount);

            // Filter products that have transactions
            if ($TotalRevenue > 0 || $ReturnAmount > 0 || $RefundedAmount > 0) {
                return $product;
            }

            return null;
        })->filter()->sortByDesc('TotalRevenue');

        // Return the necessary data
        return [
            'products' => $sortedProducts,
            'totalRevenue' => $totalRevenue,
            'totalReturnAmount' => $totalReturnAmount,
            'totalRefundedAmount' => $totalRefundedAmount,
            'netSale' => $netSale
        ];
    }

    public function high_low_sale_reports_online_service($startDate, $endDate, $branchId)
    {

        // Fetch active products
        $products =  Product ::with ( [
            'manufacturer',
            'category',
            'term',
        ] ) -> active () -> latest () -> get ();

        // Initialize totals
        $totalSoldQuantity = 0;
        $totalSaleValue = 0;

        // Process each product
        $sortedProducts = $products->map(function ($product) use ($startDate, $endDate, $branchId, &$totalSoldQuantity, &$totalSaleValue) {
            $saleType = 1;
            
            // Calculate the sold quantity and sale value for each product
            $soldQuantity = $product->sold_quantity_between_dates_by_product_branch_wise($startDate, $endDate, '', $branchId, $saleType);
            $saleValue = $product->revenue_between_dates_by_product($startDate, $endDate);

            if ($soldQuantity > 0) {  // Only include products with soldQuantity > 0
                $product->soldQuantity = $soldQuantity;
                $product->saleValue = $saleValue;

                // Accumulate totals
                $totalSoldQuantity += $soldQuantity;
                $totalSaleValue += $saleValue;

                return $product;
            }
            
            return null; // Return null for products with soldQuantity of 0
        })->filter()->sortByDesc('soldQuantity'); // Filter out null values and sort


        // Return the sorted products and total values
        return [
            'products' => $sortedProducts,
            'totalSoldQuantity' => $totalSoldQuantity,
            'totalSaleValue' => $totalSaleValue,
        ];
    }

    public function high_low_sale_reports_pos_service($startDate, $endDate, $branchId)
    {
        // Similar logic for POS report
        // Fetch active products
        $products =  Product ::with ( [
            'manufacturer',
            'category',
            'term',
        ] ) -> active () -> latest () -> get ();
        $totalSoldQuantity = 0;
        $totalSaleValue = 0;

        $sortedProducts = $products->map(function ($product) use ($startDate, $endDate, $branchId, &$totalSoldQuantity, &$totalSaleValue) {
            $saleType = 0; // POS Sale Type
            $soldQuantity = $product->sold_quantity_between_dates_by_product_branch_wise($startDate, $endDate, '', $branchId, $saleType);
            $saleValue = $product->revenue_between_dates_by_product($startDate, $endDate);

            if ($soldQuantity > 0) {
                $product->soldQuantity = $soldQuantity;
                $product->saleValue = $saleValue;
                $totalSoldQuantity += $soldQuantity;
                $totalSaleValue += $saleValue;

                return $product;
            }
            return null;
        })->filter()->sortByDesc('soldQuantity');

        return [
            'products' => $sortedProducts,
            'totalSoldQuantity' => $totalSoldQuantity,
            'totalSaleValue' => $totalSaleValue,
        ];
    }


    public function high_low_sale_report_pos_vs_online_service($startDate, $endDate, $branchId)
    {
        // Fetch active products
        $products =  Product ::with ( [
            'manufacturer',
            'category',
            'term',
        ] ) -> active () -> latest () -> get ();

        // Initialize totals
        $totalSoldQuantity = 0;
        $totalSaleValue = 0;
        $totalSoldQuantityPos = 0;
        $totalSaleValuePos = 0;

        // Process each product
        $sortedProducts = $products->map(function ($product) use ($startDate, $endDate, $branchId, &$totalSoldQuantity, &$totalSaleValue, &$totalSoldQuantityPos, &$totalSaleValuePos) {
            $saleTypeOnline = 1; // Online Sale Type
            $saleTypePos = 0;    // POS Sale Type

            // Calculate online sales data
            $soldQuantity = $product->sold_quantity_between_dates_by_product_branch_wise($startDate, $endDate, '', $branchId, $saleTypeOnline);
            $saleValue = $product->revenue_between_dates_by_product_sale_type($startDate, $endDate, '', $saleTypeOnline);

            // Calculate POS sales data
            $soldQuantityPos = $product->sold_quantity_between_dates_by_product_branch_wise($startDate, $endDate, '', $branchId, $saleTypePos);
            $saleValuePos = $product->revenue_between_dates_by_product_sale_type($startDate, $endDate, '', $saleTypePos);

            // Filter products with any sales (online or POS)
            if ($soldQuantity > 0 || $soldQuantityPos > 0) {
                $product->soldQuantity = $soldQuantity;
                $product->saleValue = $saleValue;
                $product->soldQuantityPos = $soldQuantityPos;
                $product->saleValuePos = $saleValuePos;

                // Accumulate totals
                $totalSoldQuantity += $soldQuantity;
                $totalSaleValue += $saleValue;
                $totalSoldQuantityPos += $soldQuantityPos;
                $totalSaleValuePos += $saleValuePos;

                return $product;
            }

            return null;
        })->filter()->sortByDesc('soldQuantity');

        // Return the data for products and totals
        return [
            'products' => $sortedProducts,
            'totalSoldQuantity' => $totalSoldQuantity,
            'totalSaleValue' => $totalSaleValue,
            'totalSoldQuantityPos' => $totalSoldQuantityPos,
            'totalSaleValuePos' => $totalSaleValuePos,
        ];
    }
}
