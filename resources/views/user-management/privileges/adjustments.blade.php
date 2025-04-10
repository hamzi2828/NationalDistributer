<tr>
    <td colspan="2">
        <h5 class="mb-0">adjustments</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="adjustments-privilege" @checked(!empty($permission) && in_array ('adjustments-privilege', $permission -> permission))>
            <label class="form-check-label">adjustments</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">All adjustments (increase)</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="all-adjustments-increase-menu-privilege" @checked(!empty($permission) && in_array ('all-adjustments-increase-menu-privilege', $permission -> permission))>
            <label class="form-check-label">All adjustments (increase)</label>
        </div>
    </td>
</tr>

<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="edit-adjustments-increase-privilege" @checked(!empty($permission) && in_array ('edit-adjustments-increase-privilege', $permission -> permission))>
                <label class="form-check-label">Edit Adjustments</label>
            </div>

            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="delete-adjustments-increase-privilege" @checked(!empty($permission) && in_array ('delete-adjustments-increase-privilege', $permission -> permission))>
                <label class="form-check-label">Delete Adjustments</label>
            </div>
        </div>
    </td>
</tr>

<tr>
    <td></td>
    <td>
        <h5 class="mb-0">add adjustments (increase)</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="add-adjustments-increase-menu-privilege" @checked(!empty($permission) && in_array ('add-adjustments-increase-menu-privilege', $permission -> permission))>
            <label class="form-check-label">add adjustments (increase)</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">All adjustments (decrease)</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="all-adjustments-decrease-menu-privilege" @checked(!empty($permission) && in_array ('all-adjustments-decrease-menu-privilege', $permission -> permission))>
            <label class="form-check-label">All adjustments (decrease)</label>
        </div>
    </td>
</tr>

<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="edit-adjustments-decrease-privilege" @checked(!empty($permission) && in_array ('edit-adjustments-decrease-privilege', $permission -> permission))>
                <label class="form-check-label">Edit Adjustments</label>
            </div>

            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="delete-adjustments-decrease-privilege" @checked(!empty($permission) && in_array ('delete-adjustments-decrease-privilege', $permission -> permission))>
                <label class="form-check-label">Delete Adjustments</label>
            </div>
        </div>
    </td>
</tr>

<tr>
    <td></td>
    <td>
        <h5 class="mb-0">add adjustments (decrease)</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="add-adjustments-decrease-menu-privilege" @checked(!empty($permission) && in_array ('add-adjustments-decrease-menu-privilege', $permission -> permission))>
            <label class="form-check-label">add adjustments (decrease)</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">All damage/loss</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="all-damage-loss-menu-privilege" @checked(!empty($permission) && in_array ('all-damage-loss-menu-privilege', $permission -> permission))>
            <label class="form-check-label">All damage/loss</label>
        </div>
    </td>
</tr>

<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="edit-damage-loss-menu-privilege" @checked(!empty($permission) && in_array ('edit-damage-loss-menu-privilege', $permission -> permission))>
                <label class="form-check-label">Edit</label>
            </div>

            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="delete-damage-loss-menu-privilege" @checked(!empty($permission) && in_array ('delete-damage-loss-menu-privilege', $permission -> permission))>
                <label class="form-check-label">Delete</label>
            </div>
        </div>
    </td>
</tr>

<tr>
    <td></td>
    <td>
        <h5 class="mb-0">add damage/loss</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="add-damage-loss-menu-privilege" @checked(!empty($permission) && in_array ('add-damage-loss-menu-privilege', $permission -> permission))>
            <label class="form-check-label">add damage/loss</label>
        </div>
    </td>
</tr>
