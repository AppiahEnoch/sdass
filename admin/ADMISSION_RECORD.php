<div id="wrapper14" class="container justify-content-center align-items-center mt-2 d-none">

  <div class="container mt-2">
  <div class="row justify-content-center align-items-center">
    <div class="col-12 col-sm-10 col-md-8 col-lg-6  justify-content-center align-items-center">
      
    <form id="admin_admission_list_filter_form" class="custom-form">
        <h4 class="text-primary mb-3">ADMISSION RECORDS</h4>


</h5>

<div class="card">
  <div class="card-body">
    <div class="row">
      <!-- From Date -->
      <div class="col-12 col-lg-6 mb-3">
        <label for="admission_filter_fromDate" class="form-label">From Date</label>
        <input type="date" class="form-control" id="admission_filter_fromDate" name="admission_filter_fromDate">
      </div>

      <!-- To Date -->
      <div class="col-12 col-lg-6 mb-3">
        <label for="admission_filter_toDate" class="form-label">To Date</label>
        <input type="date" class="form-control" id="admission_filter_toDate" name="admission_filter_toDate">
      </div>
    </div>

    <div class="row">
      <!-- Status -->
      <div class="col-12 col-lg-6 mb-3">
        <label for="admission_filter_status" class="form-label">Status</label>
        <select class="form-select" id="admission_filter_status" name="admission_filter_status">
          <option value="" selected>Select Status</option>
          <!-- Options will be populated here -->
        </select>
      </div>

      <!-- Programme -->
      <div class="col-12 col-lg-6 mb-3">
        <label for="admission_filter_programme" class="form-label">Programme</label>
        <select class="form-select" id="admission_filter_programme" name="admission_filter_programme">
          <option value="" selected>Select Programme</option>
          <!-- Options will be populated here -->
        </select>
      </div>
    </div>

    <div class="row">
      <!-- Gender -->
      <div class="col-12 col-lg-6 mb-3">
        <div class="mb-3">
          <label for="admission_filter_gender" class="form-label">Gender</label>
          <select class="form-select" id="admission_filter_gender" name="admission_filter_gender">
            <option value="">Select Gender</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
          </select>
        </div>
      </div>

      <!-- House -->
      <div class="col-12 col-lg-6 mb-3">
        <div class="mb-3">
          <label for="admission_filter_house" class="form-label">House</label>
          <select class="form-select" id="admission_filter_house" name="admission_filter_house">
            <option value="">Select House</option>
            <!-- Options will be populated here -->
          </select>
        </div>
      </div>
    </div>

    <div class="row">
      <!-- Religion -->
      <div class="col-12 col-lg-6 mb-3">
        <div class="mb-3">
          <label for="admission_filter_religion" class="form-label">Religion</label>
          <select class="form-select" id="admission_filter_religion" name="admission_filter_religion">
            <option value="">Select Religion</option>
            <!-- Options will be populated here -->
          </select>
        </div>
      </div>

      <!-- Health Issue -->
      <div class="col-12 col-lg-6 mb-3">
        <div class="mb-3">
          <label for="admission_filter_healthIssue" class="form-label">Health Issue</label>
          <select class="form-select" id="admission_filter_healthIssue" name="admission_filter_healthIssue">
            <option value="">Select Health Issue</option>
            <option value="No">No</option>
            <option value="Yes">Yes</option>
          </select>
        </div>
      </div>
    </div>

    <div class="row">
      <!-- Denomination -->
      <div class="col-12 col-lg-6 mb-3">
        <div class="mb-3">
          <label for="admission_filter_denomination" class="form-label">Denomination</label>
          <select class="form-select" id="admission_filter_denomination" name="admission_filter_denomination">
            <option value="">Select Denomination</option>
            <!-- Options will be populated here -->
          </select>
        </div>
      </div>

      <!-- Index Number -->
      <div class="col-12 col-lg-6 mb-3">
        <div class="mb-3">
          <label for="admission_filter_indexNumber" class="form-label">BECE Index Number</label>
          <input type="text" class="form-control" id="admission_filter_indexNumber" name="admission_filter_indexNumber" placeholder="Enter Index Number">
        </div>
      </div>
    </div>

    <!-- Buttons -->
    <div class="row m-2">
      <!-- Filter Button -->
      <div class="col-6">
        <button id="admission_filter_submit" type="submit" class="btn btn-primary w-100">Filter</button>
      </div>
      
      <!-- Cancel Button -->
      <div class="col-6">
        <button id="admission_filter_reset" type="reset" class="btn btn-secondary w-100">Reset</button>
      </div>
    </div>
  </div>
</div>




 

   
      </form>

      <form id="admin_admission_record_list_form" class="mt-3 custom-form">
      <i  onclick="print_admission_list_window('admission_list_filter_card')"  class="fa fa-print ae-print"> </i>
      <span id="ae_image_download"><img src="../devimage/excel.png" alt="image"></span>

  <div  id="admission_list_filter_card" class="card">
    <div class="card-body">
    <P> Total Records:      <span id="admin_admission_list_filter_total_record">0</span> 

      <!-- Table -->
      <table id="admission_list_filter_table" class="table">
        <thead>
          <tr>
            <th scope="col" id="admin_admission_record_table_header_id">ID</th>
            <th scope="col" id="admin_admission_record_table_header_fullName">Full Name</th>
            <th scope="col" id="admin_admission_record_table_header_image">image</th>
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





