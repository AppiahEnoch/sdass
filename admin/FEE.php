<div
  id="wrapper4"
  class="container justify-content-center align-items-center mt-2 d-none"
>
  <div class="row justify-content-center align-items-center">
    <div class="col-12 col-sm-10 col-md-8 col-lg-8">
      <form
        class="custom-form justify-content-center align-items-center"
        id="feeForm"
      >

      <h5 class="text-center text-primary">STUDENT PAYMENT FORM </h5>
      
      <div class="row">
        <div class="col-6 mb-3">
            <div class="dropdown fee_print_options">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="printDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                   Receipt
                </button>
                <ul id="student_fee" class="dropdown-menu" aria-labelledby="printDropdown">
                  <li><a class="dropdown-item d-none" href="#">Print Receipt</a></li>
                  <li><a class="dropdown-item" href="#">Student Payments</a></li>
              
                </ul>
              </div>
        </div>
        <div class="col-6 mb-3 text-end justtify-content-end">
            <button type="button" class="btn btn-secondary aligh-self-end">  <i id="filterPrint" class="fa fa-print" aria-hidden="true"></i></button>
        </div>
    </div>
    
    


      <?php include "FEE_FILTER.php";
       ?>
      
 
      
      <div class="row">
            <div class="col-12">
                <div class="mb-3 justify-content-center align-items-center">
                    <label for="fee_search" class="form-label">Search</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input
                            type="text"
                            class="form-control"
                            id="fee_search"
                            name="fee_search"
                            placeholder=" Admission Number"
                        />


                       
                    </div>
                </div>
                <div id="payee-list" class="card d-none">
                    <ul id="payee-suggestion" class="list-group">
                        <li class="list-group-item">An item</li>
                        <li class="list-group-item">A second item</li>
                        <li class="list-group-item">A third item</li>
                        <li class="list-group-item">A fourth item</li>
                        <li class="list-group-item">And a fifth one</li>
                      </ul>
                   
                </div>
            </div>

      
            
       
      </div>

      <h5>PAYER: <span id="payer">#####</span></h5>

<div class="row">
    <div class="col-12 col-lg-6">
        <div class="mb-3">
            <label for="paymentType1" class="form-label">Payment Type</label>
            <div class="input-group">
                <span class="input-group-text">
                    <i class="fas fa-money-check-alt"></i>
                </span>
                <select  class="form-control" id="paymentType1" name="paymentType1
                ">
                    <option value="0">Select...</option>
                    <option value="school fees">School Fees</option>
                    <option value="other Payment">Other payment</option>
                </select>
            </div>
        </div>
    </div>


    <div class="col-12 col-lg-6">
    <div class="mb-3">
        <label for="receiptId" class="form-label">Receipt ID</label>
        <div class="input-group">
            <span class="input-group-text">
                <i class="fas fa-receipt"></i>
            </span>
            <input required type="text" class="form-control" id="student_payment_receiptId" name="student_payment_receiptId" placeholder="Enter Receipt ID">
        </div>
    </div>
</div>






    <div class="col-12 col-lg-6">
        <div class="mb-3 d-none" id="otherPaymentDescriptionDiv">
            <label for="otherPaymentDescription" class="form-label">Payment Description</label>
            <textarea class="form-control" id="otherPaymentDescription" name="otherPaymentDescription"></textarea>
        </div>
    </div>
</div>



        <div class="row">
            <div class="col-12 col-lg-6">
                <div class="mb-3 justify-content-center align-items-center">
                    <label for="student_payment_amount" class="form-label">Payment Amount</label>
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fa fa-money" aria-hidden="true"></i>
                        </span>
                        <input
                            required
                            type="number"
                            step="0.01"
                            min="0"
                            class="form-control"
                            id="student_payment_amount"
                            name="student_payment_amount"
                            placeholder="0.00"
                        />
                    </div>
                </div>
            </div>
            

          

   

        </div>

     <div class="row aeSubmit-buttons">
        <div class="col-12 col-lg-8 mb-2">
            <button id="submitFee" type="submit" class="btn btn-primary w-100">
                Submit
              </button>

        </div>

        <div class="col-12 col-lg-4">
            <button id="fee_cancel" type="button" class="btn btn-secondary w-100">
                Cancel
              </button>

        </div>
     </div>
      </form>




    </div>

  </div>
  <div id="admin_take_payment_list_wrapper" class="ae-table container justify-content-center align-items-center mt-2">

  <div class="row justify-content-center align-items-center">
    <div class="col-12 col-sm-10 col-md-8 col-lg-8">
    <h5 id="admin-print-payment-receipt">  <i class="fa fa-print ae-print float-end" aria-hidden="true"></i></h5>
      <div class="justify-content-center align-items-center">
        <div class="mb-3 justify-content-center align-items-center">
          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">ID</th>
                <th scope="col">Type</th>
                <th scope="col">Amount</th>
                <th scope="col">Del</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td>type</td>
                <td>user1</td>
                <td><button class="btn btn-danger" onclick="deleteUser(1)">Del</button></td>
              </tr>
              <!-- More rows as needed -->
            </tbody>
          </table>
        </div>
        <div class="row ae-total">
          <div class="col-12 col-md-6">
            <h4 class="ae-table-total"> <span class="total">Records: <span class="total_records"><span id="admin_take_payment_list_total_records"> 0</span></span> </span> </h4>
          </div>
          <div class="col-12 col-md-6">
            <h4 class="ae-table-total"> <span class="total">Total Amount: <span class="total_amount"><span id="admin_take_payment_list_total_amount">0</span></span> </span> </h4>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



</div>




