<tr>
    <td colspan="2">
        <h5 class="mb-0">Transfers</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="issuance-privilege" @checked(!empty($permission) && in_array ('issuance-privilege', $permission -> permission))>
            <label class="form-check-label">transfers</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">All Transfers</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="all-issuance-privilege" @checked(!empty($permission) && in_array ('all-issuance-privilege', $permission -> permission))>
            <label class="form-check-label">All transfer</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="print-issuance-privilege" @checked(!empty($permission) && in_array ('print-issuance-privilege', $permission -> permission))>
                <label class="form-check-label">Print</label>
            </div>
            
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="p-print-issuance-privilege" @checked(!empty($permission) && in_array ('p-print-issuance-privilege', $permission -> permission))>
                <label class="form-check-label">P-Print</label>
            </div>
            
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="received-issuance-privilege" @checked(!empty($permission) && in_array ('received-issuance-privilege', $permission -> permission))>
                <label class="form-check-label">Received transfer</label>
            </div>

            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="edit-issuance-privilege" @checked(!empty($permission) && in_array ('edit-issuance-privilege', $permission -> permission))>
                <label class="form-check-label">Edit transfer</label>
            </div>

            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="delete-issuance-privilege" @checked(!empty($permission) && in_array ('delete-issuance-privilege', $permission -> permission))>
                <label class="form-check-label">Delete transfer</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Add transfer</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="add-issuance-privilege" @checked(!empty($permission) && in_array ('add-issuance-privilege', $permission -> permission))>
            <label class="form-check-label">Add transfer</label>
        </div>
    </td>
</tr>