<div id="wrapper11" class="container justify-content-center align-items-center mt-2 d-none">



  <div class="container mt-2">
  <div class="row justify-content-center align-items-center">
    <div class="col-12 col-sm-10 col-md-8 col-lg-6">
    <form id="teacher_upload_student_remark_form" class="custom-form">
        <div class="card">
          <div class="card-header" id="teacher_upload_student_remark_card_header">
            Update Your remarks
          </div>
          <div class="card-body" id="teacher_upload_student_remark_card_body">

          <div class="mb-3" id="teacher_upload_student_remark_download_div">
  <a href="#" id="teacher_upload_student_remark_download_link" onclick="get_remarks_template()">
    <i class="fas fa-download"></i> Download File Template
  </a>
</div>

            <!-- Upload Remarks File -->
            <div class="mb-3" id="teacher_upload_student_remark_upload_remarks_div">
              <label for="teacher_upload_student_remark_upload_remarks">Upload Remarks Excel File:</label>
              <input type="file" id="teacher_upload_student_remark_upload_remarks" name="teacher_upload_student_remark_upload_remarks" class="form-control">
            </div>

          </div>
        </div>
      </form>
  </div>


</div>





  </div>






  <div class="container mt-2">
  <div class="row justify-content-center align-items-center">
    <div class="col-12 col-sm-10 col-md-8 col-lg-6">
      <form id="student_interest_form" class="custom-form">
      <a id="lb_save_interest_changes">
  <i id="teacher_update_comments_manually" class="fa fa-floppy-o" aria-hidden="true"></i>Save Changes
</a>

<div class="card">
  <div class="card-header" id="student_interest_card_header">
    Student Interest
  </div>
  <div class="card-body" id="student_interest_card_body">
    <table id="student_interest_table" class="table table-bordered">
      <thead>
        <tr>
        <th id="student_interest_index_header">ID</th>
          <th id="student_interest_full_name_header">Student Name</th>
          <th id="student_interest_remarks_header">interest</th>
        </tr>
      </thead>
      <tbody id="student_interest_table_body">
        <!-- Rows will go here -->
      </tbody>
    </table>
  </div>
</div>

<!-- Student Attitude Card -->
<div class="card">
  <div class="card-header" id="student_attitude_card_header">
    Student Attitude
  </div>
  <div class="card-body" id="student_attitude_card_body">
    <table id="student_attitude_table" class="table table-bordered">
      <thead>
        <tr>
        <th id="student_attitude_index_header">ID</th>
          <th id="student_attitude_full_name_header">Student Name</th>
          <th id="student_attitude_remarks_header">Attitude</th>
        </tr>
      </thead>
      <tbody id="student_attitude_table_body">
        <!-- Rows will go here -->
      </tbody>
    </table>
  </div>
</div>

<!-- Student Remarks Card -->
<div class="card">
  <div class="card-header" id="student_remarks_card_header">
    Student Remarks
  </div>
  <div class="card-body" id="student_remarks_card_body">
    <table id="student_remarks_table" class="table table-bordered">
      <thead>
        <tr>
          <th id="student_remarks_index_header">ID</th>
          <th id="student_remarks_full_name_header">Student Name</th>
          <th id="student_remarks_remarks_header">Remarks</th>
        </tr>
      </thead>
      <tbody id="student_remarks_table_body">
        <!-- Rows will go here -->
      </tbody>
    </table>
  </div>
</div>
<a class="mt-1" id="lb_save_interest_changes2">
  <i id="teacher_update_comments_manually2" class="fa fa-floppy-o me-1" aria-hidden="true"></i> Save Changes
</a>

        </div>


      </form>
    </div>
  </div>
</div>






