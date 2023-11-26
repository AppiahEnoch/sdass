<div id="wrapper14" class="container justify-content-center align-items-center mt-2 d-none">

  <div class="container mt-2">
  <div class="row justify-content-center align-items-center">
    <div class="col-12 col-sm-10 col-md-8 col-lg-6">
      <form id="admin_admission_list_filter_form" class="custom-form">
        <h4 class="text-primary mb-3">ADMISSION RECORDS</h4>
        <h5> Total Records:      <span id="admin_admission_list_filter_total_record">0</span> 
     
    <span">
        <i id="admission_list_download_1" class="fas fa-download ms-5"><span class="download_text"> Download List</span> </i> 
    </span>

</h5>
      <div  class="card">
      
    <div class="card-body">
      
      <!-- From Date -->
      <div class="mb-3">
        <label for="admin_admission_list_filter_fromDate" class="form-label">From Date</label>
        <input type="date" class="form-control" id="admin_admission_list_filter_fromDate" name="admin_admission_list_filter_fromDate">
      </div>

      <!-- To Date -->
      <div class="mb-3">
        <label for="admin_admission_list_filter_toDate" class="form-label">To Date</label>
        <input type="date" class="form-control" id="admin_admission_list_filter_toDate" name="admin_admission_list_filter_toDate">
      </div>

      <!-- Term -->
      <div class="mb-3">
        <label for="admin_admission_list_filter_term" class="form-label">Term</label>
        <select class="form-select" id="admin_admission_list_filter_term" name="admin_admission_list_filter_term">
          <option selected>Select Term</option>
          <!-- Options will be populated here -->
        </select>
      </div>

      <!-- Class -->
      <div class="mb-3">
        <label for="admin_admission_list_filter_class" class="form-label">Class</label>
        <select class="form-select" id="admin_admission_list_filter_class" name="admin_admission_list_filter_class">
          <option selected>Select Class</option>
          <!-- Options will be populated here -->
        </select>
      </div>

    </div>

    <div class="row m-2">
            <div class="col-12">
              <button id="admin_admission_list_filter_cancel" type="button" class="btn btn-secondary w-100">Cancel</button>
            </div>
        
          </div>
  </div>


 

   
      </form>

      <form id="admin_admission_record_list_form" class="mt-3 custom-form">
      <i  onclick="print_admission_list_window('admission_list_filter_card')"  class="fa fa-print ae-print"> </i>

  <div  id="admission_list_filter_card" class="card">
    <div class="card-body">
      
      <!-- Table -->
      <table id="admission_list_filter_table" class="table">
        <thead>
          <tr>
            <th scope="col" id="admin_admission_record_table_header_id">ID</th>
            <th scope="col" id="admin_admission_record_table_header_fullName">Full Name</th>
            <th scope="col" id="admin_admission_record_table_header_date">Date</th>
          </tr>
        </thead>
        <tbody>
          <!-- Table rows will be populated here -->
        </tbody>
      </table>

    </div>
  </div>
</form>




    </div>

    
  </div>
</div>

  </div>





