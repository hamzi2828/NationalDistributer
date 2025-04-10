{{-- <tr>
   
    <tr>
        <td colspan="2">
            <h5 class="mb-0">Reviews</h5>
        </td>
        <td>
            <div class="form-check mb-2 form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="review-edit-privilege" @checked(!empty($permission) && in_array ('review-edit-privilege', $permission -> permission))>
                <label class="form-check-label">Edit review</label>
            </div>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="review-delete-privilege" @checked(!empty($permission) && in_array ('review-delete-privilege', $permission -> permission))>
                <label class="form-check-label">Delete Review</label>
            </div>

            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="approve-disapprove-review-privilege" @checked(!empty($permission) && in_array ('approve-disapprove-review-privilege', $permission -> permission))>
                <label class="form-check-label">Approve Disapprove</label>
            </div>
        </div>
    </td>
</tr>
</tr> --}}


<tr>
    <td colspan="2">
        <h5 class="mb-0">Product Reviews</h5>
    </td>
    <td>
        <div class="form-check form-check-success">
            <input type="checkbox" class="form-check-input" name="privilege[]"
                   value="reviews-privilege" @checked(!empty($permission) && in_array ('reviews-privilege', $permission -> permission))>
            <label class="form-check-label">Reviews</label>
        </div>
    </td>
</tr>
<tr>
    <td></td>
    <td>
        <h5 class="mb-0">All reviews</h5>
    </td>
     <td>
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="approve-disapprove-review-privilege" @checked(!empty($permission) && in_array ('approve-disapprove-review-privilege', $permission -> permission))>
                <label class="form-check-label">Approve Disapprove</label>
            </div>
    </td>
</tr>
<tr>
    <td colspan="2"></td>
    <td>
        <div class="d-flex gap-2 flex-column">
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="review-edit-privilege" @checked(!empty($permission) && in_array ('review-edit-privilege', $permission -> permission))>
                <label class="form-check-label">Edit review</label>
            </div>

            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="review-delete-privilege" @checked(!empty($permission) && in_array ('review-delete-privilege', $permission -> permission))>
                <label class="form-check-label">Delete Review</label>
            </div>
            <div class="form-check form-check-success">
                <input type="checkbox" class="form-check-input" name="privilege[]"
                       value="review-report-privilege" @checked(!empty($permission) && in_array ('review-report-privilege', $permission -> permission))>
                <label class="form-check-label"> Review Report</label>
            </div>
      
        </div>
    </td>
</tr>
