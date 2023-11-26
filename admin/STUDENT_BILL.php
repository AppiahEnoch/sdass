
<div id="wrapper7" class="container justify-content-center align-items-center mt-2 d-none">
  <div class="row justify-content-center align-items-center">
    <div class="col-12 col-sm-10 col-md-8 col-lg-6">
      <form class="custom-form justify-content-center align-items-center" id="student_bill_form">
        <h5 class="text-center text-primary">CLASS BILL FORM</h5>
      <h6 class="academic_year">  <span> FOR:</span> <span id="student_bill_academicYear" > </span></h6>
        <div class="row">
          <div class="col-12">
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <span class="input-group-text">
                  <i class="fas fa-chalkboard-teacher"></i>
                </span>
                <select required class="form-control" id="student_bill_studentClass" name="student_bill_studentClass">
                  <option value="">Select Class</option>
                  <!-- Add class options here -->
                </select>
              </div>
            </div>
          </div>
      
          <div class="col-12">


    <div class="mb-3 justify-content-center align-items-center">
    <div class="input-group">
      <span class="input-group-text">
        <label for="student_bill_addBillItem">
          <i class="fas fa-plus-square"></i>
        </label>
      </span>
      <input type="text" class="form-control" id="student_bill_addBillItem" name="student_bill_addBillItem" placeholder="Add New Bill Item to List">
      <span class="input-group-text">
        <button type="button" class="btn btn-primary" id="student_bill_addBillItemButton">Add</button>
      </span>
    </div>
  </div>
</div>

      
          <div class="col-12 col-lg-6">
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <span class="input-group-text">
                  <i class="fas fa-list-alt"></i>
                </span>
                <select required class="form-control" id="student_bill_selectBillItem" name="student_bill_selectBillItem">
                  <option value="0">Select Bill Item</option>
                  <!-- Add bill item options here -->
                </select>
                <span class="input-group-text">
                  <i id="delete_bill_item" class="fas fa-trash del-icon"></i>
                </span>
              </div>
            </div>
          </div>
          
      
          <div class="col-12">
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <span class="input-group-text">
                  <i class="fa fa-money" aria-hidden="true"></i>
                </span>
                <input required type="number" step="0.01" class="form-control" id="student_bill_billAmount" name="student_bill_billAmount" placeholder="Bill Amount">
              </div>
            </div>
          </div>


      
          <div class="col-12 col-lg-8">
            <button type="submit" class="btn btn-primary w-100 mb-2">Add Bill</button>
          </div>
          <div class="col-12 col-lg-4">
            <button type="button" class="btn btn-secondary w-100" id="student_bill_cancel">Cancel</button>
          </div>
        </div>

        
      </form>


  <div class="row view">
  <div class="card mb-3" id="card_academic_terms">
  <div class="card-header">
    <h5>Select Academic Term <i class="fas fa-print  float-right ms-5 class_bill_print_icon"  onclick="printAllCards()"></i> 
</h5>
  </div>
  <div class="card-body">
    <div class="mb-3 justify-content-center align-items-center">
      <div class="input-group">
        <span class="input-group-text">
          <i class="fas fa-calendar-alt"></i>
        </span>
        <select class="form-control" id="academic_terms_dropdown" name="academic_terms_dropdown">
          <option value="0">Select Academic Term</option>
     
        </select>
      </div>
    </div>
  </div>
</div>


<div id="class_bills" class="row">
  

</div>

</div>

    </div>

    



  </div>
</div>
