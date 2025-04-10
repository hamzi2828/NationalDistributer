<tr>
    <td colspan="2">
        <h5 class="mb-0">General Reporting</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="reporting-privilege" @checked(!empty($permission) && in_array ('reporting-privilege', $permission -> permission))>
            <label class="form-check-label">General Reporting</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">General Sales Report</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="general-sales-report-privilege" @checked(!empty($permission) && in_array ('general-sales-report-privilege', $permission -> permission))>
            <label class="form-check-label">General Sales Report</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">General Sales Report (Attribute Wise)</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="general-sales-report-attribute-wise-privilege" @checked(!empty($permission) && in_array ('general-sales-report-attribute-wise-privilege', $permission -> permission))>
            <label class="form-check-label">General Sales Report (Attribute Wise)</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">General Sales Report (Product Wise)</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="general-sales-report-product-wise-privilege" @checked(!empty($permission) && in_array ('general-sales-report-product-wise-privilege', $permission -> permission))>
            <label class="form-check-label">General Sales Report (Product Wise)</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Stock Valuation Report (TP)</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="stock-valuation-tp-report-privilege" @checked(!empty($permission) && in_array ('stock-valuation-tp-report-privilege', $permission -> permission))>
            <label class="form-check-label">Stock Valuation Report (TP)</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Stock Valuation Report (Sale)</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="stock-valuation-sale-report-privilege" @checked(!empty($permission) && in_array ('stock-valuation-sale-report-privilege', $permission -> permission))>
            <label class="form-check-label">Stock Valuation Report (Sale)</label>
        </div>
    </td>
</tr>

<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Stock Statement  Report (Current Available)</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="stock-statement-report-privilege" @checked(!empty($permission) && in_array ('stock-statement-report-privilege', $permission -> permission))>
            <label class="form-check-label">Stock Statement Report (Current Available)</label>
        </div>
    </td>
</tr>


<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Threshold Report</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="threshold-report-privilege" @checked(!empty($permission) && in_array ('threshold-report-privilege', $permission -> permission))>
            <label class="form-check-label">Threshold Report</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Available Stock Report (Attribute Wise)</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="attribute-wise-quantity-report-privilege" @checked(!empty($permission) && in_array ('attribute-wise-quantity-report-privilege', $permission -> permission))>
            <label class="form-check-label">Available Stock Report (Attribute Wise)</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Available Stock Report (Category Wise)</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="category-wise-quantity-report-privilege" @checked(!empty($permission) && in_array ('category-wise-quantity-report-privilege', $permission -> permission))>
            <label class="form-check-label">Available Stock Report (Category Wise)</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Sales Analysis Report (Products)</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="product-sales-analysis-report-privilege" @checked(!empty($permission) && in_array ('product-sales-analysis-report-privilege', $permission -> permission))>
            <label class="form-check-label">Sales Analysis Report (Products)</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Sales Analysis Report (Attributes)</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="attribute-sales-analysis-report-privilege" @checked(!empty($permission) && in_array ('attribute-sales-analysis-report-privilege', $permission -> permission))>
            <label class="form-check-label">Sales Analysis Report (Attributes)</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Customer Return Report</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="customer-return-report-privilege" @checked(!empty($permission) && in_array ('customer-return-report-privilege', $permission -> permission))>
            <label class="form-check-label">Customer Return Report</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Vendor Return Report</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="vendor-return-report-privilege" @checked(!empty($permission) && in_array ('vendor-return-report-privilege', $permission -> permission))>
            <label class="form-check-label">Vendor Return Report</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Supplier Wise Report</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="supplier-wise-report-privilege" @checked(!empty($permission) && in_array ('supplier-wise-report-privilege', $permission -> permission))>
            <label class="form-check-label">Supplier Wise Report</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Analysis Report (Purchase)</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="purchase-analysis-report-privilege" @checked(!empty($permission) && in_array ('purchase-analysis-report-privilege', $permission -> permission))>
            <label class="form-check-label">Analysis Report (Purchase)</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Analysis Report (Sale)</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="sale-analysis-report-privilege" @checked(!empty($permission) && in_array ('sale-analysis-report-privilege', $permission -> permission))>
            <label class="form-check-label">Analysis Report (Sale)</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Profit Report</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="profit-report-privilege" @checked(!empty($permission) && in_array ('profit-report-privilege', $permission -> permission))>
            <label class="form-check-label">Profit Report</label>
        </div>
    </td>
</tr>

<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Coupon Report</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="coupon-report-privilege" @checked(!empty($permission) && in_array('coupon-report-privilege', $permission->permission))>
            <label class="form-check-label">Coupon General Report</label>
        </div>
    </td>
</tr>
