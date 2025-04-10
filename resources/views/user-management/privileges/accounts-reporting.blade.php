<tr>
    <td colspan="2">
        <h5 class="mb-0">Accounts Reporting</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="accounts-reporting-privilege" @checked(!empty($permission) && in_array ('accounts-reporting-privilege', $permission -> permission))>
            <label class="form-check-label">Accounts Reporting</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Trial Balance Sheet</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="trial-balance-sheet-privilege" @checked(!empty($permission) && in_array ('trial-balance-sheet-privilege', $permission -> permission))>
            <label class="form-check-label">Trial Balance Sheet</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Customers Payable</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="customers-payable-privilege" @checked(!empty($permission) && in_array ('customers-payable-privilege', $permission -> permission))>
            <label class="form-check-label">Customers Payable</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Vendors Payable</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="vendors-payable-privilege" @checked(!empty($permission) && in_array ('vendors-payable-privilege', $permission -> permission))>
            <label class="form-check-label">Vendors Payable</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Profit & Loss Report</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="profit-and-loss-report-privilege" @checked(!empty($permission) && in_array ('profit-and-loss-report-privilege', $permission -> permission))>
            <label class="form-check-label">Profit & Loss Report</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Balance Sheet</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="balance-sheet-privilege" @checked(!empty($permission) && in_array ('balance-sheet-privilege', $permission -> permission))>
            <label class="form-check-label">Balance Sheet</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Customer Ageing Report</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="customer-ageing-report-privilege" @checked(!empty($permission) && in_array ('customer-ageing-report-privilege', $permission -> permission))>
            <label class="form-check-label">Customer Ageing Report</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Vendor Ageing Report</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="vendor-ageing-report-privilege" @checked(!empty($permission) && in_array ('vendor-ageing-report-privilege', $permission -> permission))>
            <label class="form-check-label">Vendor Ageing Report</label>
        </div>
    </td>
</tr>