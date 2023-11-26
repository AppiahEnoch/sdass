<div id="wrapper20" class="container justify-content-center align-items-center mt-2 d-none">
  <h1 class="text-center text-primary">Add student Older Debt</h1>


  <div class="row justify-content-center align-items-center">
      <div class="col-auto">
        <div class="search-box">
          <input
            type="text"
            class="search-input"
            id="students_old_debt_payment_search_input"
            name="students_old_debt_payment_search_input"
            placeholder="Search any thing"
          />
          <i class="fas fa-search search-icon"></i>

          <div id="students_old_debt_payment_list" class="card ae-search-option d-none">
            <ul id="students_old_debt_payment_suggestion" class="list-group">
              <li class="list-group-item">An item</li>
              <li class="list-group-item">A second item</li>
              <li class="list-group-item">A third item</li>
              <li class="list-group-item">A fourth item</li>
              <li class="list-group-item">And a fifth one</li>
            </ul>
          </div>
        </div>
      </div>
    </div>



  <div class="row justify-content-center align-items-center">
    <div class="col-12 col-sm-10 col-md-8 col-lg-8">
      <form id="student_debt_payment_form" class="custom-form justify-content-center align-items-center">

      <h5> Student: <span class="me-5" id="selected_student_name"> #####</span>  <span id="print_old_debt" class="ae-print float-end"> <i class="fa fa-print" aria-hidden="true"></i> </span></h5>
        <!-- Student ID Input -->
        <div class="mb-3 justify-content-center align-items-center">
          <div class="input-group">
            <span class="input-group-text">
              <i class="fas fa-user-graduate"></i>
            </span>
            <input required readonly type="text" class="form-control ae-no-focus" id="student_id_input" name="student_id_input" placeholder="Student ID">
         
          </div>
        </div>

       
             
        
        <!-- Debt Amount Input -->
        <div class="mb-3 justify-content-center align-items-center">
          <div class="input-group">
            <span class="input-group-text">
            <i class="fa fa-comments-o" aria-hidden="true"></i>
            </span>
            <input required type="text" class="form-control" id="debt_description_input" name="debt_description_input" placeholder="Debt Description">
          </div>
        </div>
  


        <!-- Debt Amount Input -->
        <div class="mb-3 justify-content-center align-items-center">
          <div class="input-group">
            <span class="input-group-text">
              <i class="fas fa-dollar-sign"></i>
            </span>
            <input required type="number" class="form-control" id="debt_amount_input" name="debt_amount_input" placeholder="Debt Amount">
          </div>
        </div>

        <!-- Payment Date Input -->
        <div class="mb-3 justify-content-center align-items-center">
          <div class="input-group">
            <span class="input-group-text">
              <i class="fas fa-calendar-alt"></i>
            </span>
            <input required type="date" class="form-control" id="payment_date_input" name="payment_date_input">
          </div>
        </div>

        <!-- Submit and Cancel Buttons -->
        <div class="row">
          <div class="col-lg-8 mb-3">
            <button type="submit" class="btn btn-primary w-100">Submit</button>
          </div>
          <div class="col-lg-4 mb-3">
            <button type="button" class="btn btn-secondary w-100 ae-reset">Reset</button>
          </div>
        </div>

      </form>
    </div>
  </div>

  <div id="admin_add_student_old_debt_wrapper" class=" ae-table container justify-content-center align-items-center mt-2">
  <div class="row justify-content-center align-items-center">
    <div class="col-12 col-sm-10 col-md-8 col-lg-8">
      <div class="justify-content-center align-items-center">
        <div class="mb-3 justify-content-center align-items-center">
          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Amount</th>
                <th scope="col">Del</th>
              </tr>
            </thead>
            <tbody>
              <tr>
            
              </tr>
              <!-- More rows as needed -->
            </tbody>
          </table>
        </div>
        <div class="row ae-total">
          <div class="col-12 col-md-6">
        
            
            <h4 class="ae-table-total">  <span class="total">Records: <span class="total_records"><span id="total_records"> 0</span></span> </span> </h4>
         
          </div>
          <div class="col-12 col-md-6">
          <h4 class="ae-table-total">  <span class="total">Total Amount: <span class="total_amount"><span id="total_amount">0</span></span> </span> </h4>
     
          </div>
        </div>
      
      
      </div>
    </div>
  </div>
</div>


</div>




