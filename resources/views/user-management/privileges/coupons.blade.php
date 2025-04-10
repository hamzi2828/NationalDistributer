<tr>
    <td colspan="2">
        <h5 class="mb-0">coupons</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="coupons-privilege" @checked(!empty($permission) && in_array ('coupons-privilege', $permission -> permission))>
            <label class="form-check-label">coupons</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">All coupons</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="all-coupons-privilege" @checked(!empty($permission) && in_array ('all-coupons-privilege', $permission -> permission))>
            <label class="form-check-label">All coupons</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="edit-coupons-privilege" @checked(!empty($permission) && in_array ('edit-coupons-privilege', $permission -> permission))>
                <label class="form-check-label">Edit coupons</label>
            </div>

            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="delete-coupons-privilege" @checked(!empty($permission) && in_array ('delete-coupons-privilege', $permission -> permission))>
                <label class="form-check-label">Delete coupons</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Add coupons</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="add-coupons-privilege" @checked(!empty($permission) && in_array ('add-coupons-privilege', $permission -> permission))>
            <label class="form-check-label">Add coupons</label>
        </div>
    </td>
</tr>