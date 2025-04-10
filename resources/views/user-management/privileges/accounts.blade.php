<tr>
    <td colspan="2">
        <h5 class="mb-0">accounts</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="accounts-privilege" @checked(!empty($permission) && in_array ('accounts-privilege', $permission -> permission))>
            <label class="form-check-label">accounts</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Chat of Accounts</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="all-accounts-privilege" @checked(!empty($permission) && in_array ('all-accounts-privilege', $permission -> permission))>
            <label class="form-check-label">Chat of Accounts</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">General Ledger</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="view-general-ledger" @checked(!empty($permission) && in_array ('view-general-ledger', $permission -> permission))>
            <label class="form-check-label">General Ledger</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="edit-accounts-privilege" @checked(!empty($permission) && in_array ('edit-accounts-privilege', $permission -> permission))>
                <label class="form-check-label">Edit accounts</label>
            </div>
            
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="active-inactive-account-heads" @checked(!empty($permission) && in_array ('active-inactive-account-heads', $permission -> permission))>
                <label class="form-check-label">active/inactive accounts</label>
            </div>
            
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="delete-accounts-privilege" @checked(!empty($permission) && in_array ('delete-accounts-privilege', $permission -> permission))>
                <label class="form-check-label">Delete accounts</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Add accounts</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="add-accounts-privilege" @checked(!empty($permission) && in_array ('add-accounts-privilege', $permission -> permission))>
            <label class="form-check-label">Add accounts</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Add transactions</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="add-transactions-privilege" @checked(!empty($permission) && in_array ('add-transactions-privilege', $permission -> permission))>
            <label class="form-check-label">Add transactions</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">quick receive</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="add-transactions-quick-privilege" @checked(!empty($permission) && in_array ('add-transactions-quick-privilege', $permission -> permission))>
            <label class="form-check-label">quick receive</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">quick pay</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="add-transactions-quick-pay-privilege" @checked(!empty($permission) && in_array ('add-transactions-quick-pay-privilege', $permission -> permission))>
            <label class="form-check-label">quick pay</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">quick expense</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="add-transactions-quick-expense-privilege" @checked(!empty($permission) && in_array ('add-transactions-quick-expense-privilege', $permission -> permission))>
            <label class="form-check-label">quick expense</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Add transactions (multiple)</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="add-multiple-transactions-privilege" @checked(!empty($permission) && in_array ('add-multiple-transactions-privilege', $permission -> permission))>
            <label class="form-check-label">Add transactions (multiple)</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Add transactions (complex JV)</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="add-transactions-complex-jv-privilege" @checked(!empty($permission) && in_array ('add-transactions-complex-jv-privilege', $permission -> permission))>
            <label class="form-check-label">Add transactions (complex JV)</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Add opening balance</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="add-opening-balance-privilege" @checked(!empty($permission) && in_array ('add-opening-balance-privilege', $permission -> permission))>
            <label class="form-check-label">Add opening balance</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Search transactions</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="search-transactions-privilege" @checked(!empty($permission) && in_array ('search-transactions-privilege', $permission -> permission))>
            <label class="form-check-label">Search transactions</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Delete transactions</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="delete-transactions-privilege" @checked(!empty($permission) && in_array ('delete-transactions-privilege', $permission -> permission))>
            <label class="form-check-label">Delete transactions</label>
        </div>
    </td>
</tr>