<div id="wrapper24" class="container justify-content-center align-items-center mt-2 d-none1">
  <h1 class="text-center">Update Enrolled List</h1>
  <div class="row justify-content-center align-items-center">
    <div class="col-12 col-sm-10 col-md-8 col-lg-8">
      <form id="update_completed_registration_list_form" class="custom-form justify-content-center align-items-center" enctype="multipart/form-data">
      <h4 class="text-center">Total Enrolled: <span class="text-primary fw-bold" id="totalEnrolled_on_ges_list_online"></span> </h4>
        <div class="mb-3 justify-content-center align-items-center">
          <div class="input-group">
            <span class="input-group-text">
              <i class="fas fa-file-excel"></i>
            </span>
            <input required type="file" class="form-control" id="update_completed_registration_list_file" name="update_completed_registration_list_file" accept=".xlsx, .xls">
          </div>
        </div>

        <div class="row">
          <div class="col-lg-8 mb-3">
            <button type="submit" class="btn btn-primary w-100">Upload</button>
          </div>
          <div class="col-lg-4 mb-3">
            <button type="reset" class="btn btn-secondary w-100 ae-reset">Reset</button>
          </div>
        </div>
        <div class="row">
    <div class="col-12">
            <button type="button" class="btn btn-secondary w-50 m-2 mb-3" id="delete_registered_list_button">Delete All</button>
        </div>
    <div class="col-12">
    <span id="ae_not_enrolled_download"><img src="../devimage/excel.png" alt="image">Not Enrolled</span>
    <span class=" " id="ae_enrolled_download"><img src="../devimage/excel.png" alt="image">Enrolled</span>
        </div>
    </div>
      </form>
    </div>
  </div>
</div>
