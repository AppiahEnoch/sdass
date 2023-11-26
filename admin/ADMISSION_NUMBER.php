<div id="wrapper22" class="container justify-content-center align-items-center mt-2 d-none">
  <div class="row justify-content-center align-items-center">
    <div class="col-12 col-sm-10 col-md-8 col-lg-8">
      <form id="update_admission_number_form" class="custom-form justify-content-center align-items-center">

        <!-- Form Header -->
        <h3 class="text-center">Update Admission Numbers</h3>

        <!-- File Upload Input -->
        <div class="mb-3 justify-content-center align-items-center">
          <div class="input-group">
            <span class="input-group-text">
              <i class="fas fa-file-excel"></i>
            </span>
            <input type="file" class="form-control" id="admission_number_list_excel_file" name="admission_number_list_excel_file" accept=".xlsx, .xls" required>
        
        
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
    <h class="text-center">ADMISSION NUMBERS</h>
    <div class="row">
        <div class="col-12 mb-3">
        <div class="row admission_number_totals">
  <div class="col">
    <p id="totalUsed">Total Used: <span>0</span></p>
  </div>
  <div class="col">
    <p id="totalUnused">Total Unused: <span>0</span></p>
  </div>
  <div class="col">
    <p id="totalLoaded">Total Loaded: <span>0</span></p>
  </div>
</div>

            
 



    <div class="row ae-table">
        <table id="admission_numbers_table" class="table">
            <thead>
                <tr>
                    <th>NUMBER</th>
                    <th>Status</th>
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
        <div class="col-12">
            <button type="button" class="btn btn-secondary w-50 m-2 mb-3" id="delete_admission_number_button">Delete All</button>
        </div>
    </div>
    </div>
    
  </div>











</div>





