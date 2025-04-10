<tr>
    <td colspan="2">
        <h5 class="mb-0">products</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="products-privilege" @checked(!empty($permission) && in_array ('products-privilege', $permission -> permission))>
            <label class="form-check-label">products</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">All products</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="all-products-privilege" @checked(!empty($permission) && in_array ('all-products-privilege', $permission -> permission))>
            <label class="form-check-label">All products (detailed)</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">All products</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="simple-products-privilege" @checked(!empty($permission) && in_array ('simple-products-privilege', $permission -> permission))>
            <label class="form-check-label">All products</label>
        </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="edit-products-privilege" @checked(!empty($permission) && in_array ('edit-products-privilege', $permission -> permission))>
                <label class="form-check-label">Edit products (simple)</label>
            </div>

            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="edit-variable-products-privilege" @checked(!empty($permission) && in_array ('edit-variable-products-privilege', $permission -> permission))>
                <label class="form-check-label">Edit products (variable)</label>
            </div>

            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="delete-products-privilege" @checked(!empty($permission) && in_array ('delete-products-privilege', $permission -> permission))>
                <label class="form-check-label">Delete products</label>
            </div>

            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="ticket-products-privilege" @checked(!empty($permission) && in_array ('ticket-products-privilege', $permission -> permission))>
                <label class="form-check-label">Ticket</label>
            </div>

            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="variations-products-privilege" @checked(!empty($permission) && in_array ('variations-products-privilege', $permission -> permission))>
                <label class="form-check-label">Variations</label>
            </div>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Add products (simple)</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="add-products-privilege" @checked(!empty($permission) && in_array ('add-products-privilege', $permission -> permission))>
            <label class="form-check-label">Add products (simple)</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Add products (variable)</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="add-variable-products-privilege" @checked(!empty($permission) && in_array ('add-variable-products-privilege', $permission -> permission))>
            <label class="form-check-label">Add products (variable)</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Bulk Price Update (Attribute Wise)</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="bulk-update-prices-privilege" @checked(!empty($permission) && in_array ('bulk-update-prices-privilege', $permission -> permission))>
            <label class="form-check-label">Bulk Price Update (Attribute Wise)</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">Bulk Price Update (Category Wise)</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="bulk-update-prices-category-wise-privilege" @checked(!empty($permission) && in_array ('bulk-update-prices-category-wise-privilege', $permission -> permission))>
            <label class="form-check-label">Bulk Price Update (Category Wise)</label>
        </div>
    </td>
</tr>
