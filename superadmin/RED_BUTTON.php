<div id="wrapper6" class="container my-4 d-none">
  <div class="row justify-content-center">
    <div class="col-12 col-md-10 col-lg-8">
   
    <form id="red_button_form">
    <div class="card">
        <div class="card-header">
          Admin Deletion Panel
        </div>
        <div class="card-body">
          <!-- Selection Dropdown -->
          <div class="mb-3">
            <label for="deleteSelection" class="form-label">Select User/Resource</label>
            <select class="form-select" id="deleteSelection">
              <option selected>Choose...</option>
              <option value="all_students">All Students</option>
              <option value="all_teaching_staff">All Teaching Staff</option>
              <option value="all_nonteaching_staff">All Non-Teaching Staff</option>
              <option value="all_admin">All Admin</option>
              <option value="all_bill">All Bill Item</option>
              <option value="empty_trash">Empty trash</option>
            </select>
          </div>
          
          <!-- Confirmation Checkbox -->
          <div class="mb-3 form-check">
            <input required type="checkbox" class="form-check-input" id="deleteConfirmation">
            <label class="form-check-label" for="deleteConfirmation">I confirm that I want to delete the selected item.</label>
          </div>

          <!-- Delete Button -->
          <button type="submit" class="btn btn-danger" id="deleteButton" disabled> <i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
        </div>
      </div>
    </form>
    </div>
  </div>
</div>