     <div id="wrapper21" class="container justify-content-center align-items-center mt-2 d-none">
  <div class="row justify-content-center align-items-center">
    <div class="col-12 col-sm-10 col-md-8 col-lg-8">
      <form id="update_ges_list_form" class="custom-form justify-content-center align-items-center">

        <!-- Form Header -->
        <h3 class="text-center">Update GES List</h3>

        <!-- File Upload Input -->
        <div class="mb-3 justify-content-center align-items-center">
          <div class="input-group">
            <span class="input-group-text">
              <i class="fas fa-file-excel"></i>
            </span>
            <input type="file" class="form-control" id="student_list_excel_file" name="student_list_excel_file" accept=".xlsx, .xls" required>
        
        
        </div>
        </div>

        <!-- Submit and Cancel Buttons -->
        <div class="row">
          <div class="col-lg-8 mb-3">
            <button type="submit" class="btn btn-primary w-100">Upload</button>
          </div>
          <div class="col-lg-4 mb-3">
            <button type="button" class="btn btn-secondary w-100 ae-reset">Reset</button>
          </div>
        </div>

      </form>



      <form id="filter_form" class="custom-form">




<!-- Table -->
<div class="mt-4">
    <h4 class="text-center">GES List </h4>
    <p>TOTAL RECORDS:  <span id="total_ges_records"> </span></p>



    <!-- Search Input and Button -->
    <div class="d-flex justify-content-center align-items-center mb-3">
        <input type="text" class="form-control me-2" id="search_input" placeholder="Search by Name or index number">
        <button type="button" class="btn btn-primary" id="search_button">Search </button>
    </div>

    <div class="row ae-table">
        <table id="ges_list_table" class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <!-- Table rows will be populated here -->
            </tbody>
        </table>
    </div>
</div>
<div class="row">
    <div class="col-12">
            <button type="button" class="btn btn-secondary w-50 m-2 mb-3" id="delete_ges_list_button">Delete All</button>
        </div>
    </div>



</form>
    </div>
    
  </div>











</div>





