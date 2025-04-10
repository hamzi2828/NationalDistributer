<tr>
    <td colspan="2">
        <h5 class="mb-0">Site Settings</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="site-settings-privilege" @checked(!empty($permission) && in_array ('site-settings-privilege', $permission -> permission))>
            <label class="form-check-label">Site Settings</label>
        </div>
    </td>
</tr>
