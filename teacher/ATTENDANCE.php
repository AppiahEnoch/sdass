<div id="wrapper12" class="container justify-content-center align-items-center mt-2 d-none">
  <div class="container mt-2">
    <div class="row justify-content-center align-items-center">
      <div class="col-12 col-sm-10 col-md-8 col-lg-6">
        <form id="teacher_upload_student_attendance_form" class="custom-form">
            <h5 class="text-primary">UPLOAD STUDENT ATTENDANCE</h5>

          <div class="mb-3 justify-content-center align-items-center">
            <div class="input-group">
              <span class="input-group-text">
                <i id="teacher_upload_student_attendance_upload_icon" class="fas fa-upload"></i>
              </span>
              <input required type="file" class="form-control" id="teacher_upload_student_attendance_excel_file" name="teacher_upload_student_attendance_excel_file" accept=".xls,.xlsx">
            </div>
            <label for="teacher_upload_student_attendance_excel_file">Upload Student Attendance</label>
          </div>

          <div class="mb-3 justify-content-center align-items-center">
            <div class="input-group">
              <span class="input-group-text">
                <i id="teacher_upload_student_attendance_max_icon" class="fas fa-sort-numeric-up"></i>
              </span>
              <input required type="number" class="form-control" id="teacher_upload_student_attendance_max_value" name="teacher_upload_student_attendance_max_value" placeholder="Max Attendance Value">
            </div>
            <label for="teacher_upload_student_attendance_max_value">Enter Max Attendance Value</label>
          </div>

          <div class="row">
  <div class="col-12 col-sm-8">
    <button type="submit" id="teacher_submit_attendance" class="btn btn-primary w-100">submit</button>
  </div>

  <div class="col-12 col-sm-4 mt-2 mt-sm-0">
    <button type="button" id="teacher_cancel_attendance_submission" class="btn btn-secondary w-100">Cancel</button>
  </div>
</div>

        </form>
      </div>
    </div>
  </div>

  
  <div class="container mt-2">
    <div class="row justify-content-center align-items-center">
      <div class="col-12 col-sm-10 col-md-8 col-lg-6">
        <form id="teacher_print_student_report_form" class="custom-form">
        <a id="teacher_save_attendance_changes" class="d-inline-flex align-items-center">
  <i class="fa fa-floppy-o save-icon" aria-hidden="true"></i>
  <small class="ml-1">Save Changes</small>
</a>


          <!-- Card -->
          <div class="card">
            <div class="card-header">
              Class Student Attendance List
            </div>
            <div class="card-body">
              <table class="table table-striped table-responsive" id="class_student_attendance_list">
                <thead>
                  <tr>
                    <th scope="col">Admission Number</th>
                    <th scope="col">Full Name</th>
                    <th scope="col">Attendance</th>
                    <th scope="col">Total</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Rows can be added here -->
                  <tr>
                    <td>001</td>
                    <td>John Doe</td>
                    <td>50</td>
                    <td>15</td>
                  </tr>
                  <tr>
                    <td>002</td>
                    <td>Jane Doe</td>
                    <td>10</td>
                    <td>10</td>
                  </tr>
                  <!-- ... -->
                </tbody>
              </table>
            </div>
          </div>
          <!-- End of Card -->

        </form>
      </div>
    </div>
  </div>


</div>


