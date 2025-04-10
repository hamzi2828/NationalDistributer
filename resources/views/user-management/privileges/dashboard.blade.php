<tr>
    <td colspan="2">
        <h5 class="mb-0">dashboard</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="dashboard-privilege" @checked(!empty($permission) && in_array ('dashboard-privilege', $permission -> permission))>
            <label class="form-check-label">dashboard</label>
        </div>
    </td>
</tr>