{{-- <tr>
    <td colspan="2">
        <h5 class="mb-0">stock return (customer)</h5>
    </td>
    <td> 
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="stock-return-customer-privilege" @checked(!empty($permission) && in_array ('stock-return-customer-privilege', $permission -> permission))>
            <label class="form-check-label">stocks return (customer)</label>
        </div>
    </td>
</tr> --}}
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">All returns (customer)</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="all-stock-return-customer-privilege" @checked(!empty($permission) && in_array ('all-stock-return-customer-privilege', $permission -> permission))>
            <label class="form-check-label">All returns (customer)</label>
        </div>
    </td>
</tr>
<tr> 
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="edit-stock-return-customer-privilege" @checked(!empty($permission) && in_array ('edit-stock-return-customer-privilege', $permission -> permission))>
                <label class="form-check-label">Edit return (customer)</label>
            </div>

            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="delete-stock-return-customer-privilege" @checked(!empty($permission) && in_array ('delete-stock-return-customer-privilege', $permission -> permission))>
                <label class="form-check-label">Delete return (customer)</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Add return (customer)</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="add-stock-return-customer-privilege" @checked(!empty($permission) && in_array ('add-stock-return-customer-privilege', $permission -> permission))>
            <label class="form-check-label">Add return (customer)</label>
        </div>
    </td>
</tr>