<div id="wrapper2" class="container mt-5 d-none">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <!-- Image and Caption -->
            <div class="text-center mb-4">
                <img src="../icon/1.png" alt="User Image" class="rounded-circle" style="width:50px;">
                <h5 class="mt-2">Register New User</h5>
            </div>
            
            <!-- Form -->
            <form id="regCodeForm">
                <div class="mb-3">
                    <label for="userMobile" class="form-label">User Mobile</label>
                    <input required type="tel" class="form-control" id="userMobile" placeholder="Enter mobile number">
                </div>

                <div class="mb-3">
                    <label for="userType" class="form-label">Select User Type</label>
                    <select required class="form-select" id="userType">
                        <option value="0"selected>Choose...</option>
                        <option value="Teaching Staff">Teaching Staff</option>
                        <option value="Non-teaching Staff">Non-teaching Staff</option>
                        <option value="Admin">Admin</option>
                        <option value="Super Admin">Super Admin</option>
                    </select>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button type="submit" class="btn btn-primary me-md-2">Submit</button>
                    <button onclick="showWrapper4(['wrapper1'], 'wrapper', 20);" type="button" class="btn btn-outline-secondary">Go Back</button>
                </div>
            </form>
        </div>
    </div>


    <div id="insertedCard" class="container mt-5">
  <!-- Card 1 -->
  <div class="card" id="card1">
    <div class="card-body">
      <!-- Grid Layout -->
      <div class="row">
        <div class="col-12 col-md-6 col-lg-4">
          <!-- Card 2 -->
          <div class="card mb-4 position-relative" id="card2">
            <!-- Delete Icon at the top right corner of Card 2 -->
            <a href="#" class="position-absolute top-0 end-0 me-2 mt-2">
                <i class="fas fa-trash-alt"></i>
            </a>
            <div class="card-body">
              <!-- User Mobile -->
              <div class="mb-3">
                <h5 class="usermobile">0549822202</h5>
              </div>
              <!-- User Type -->
              <div class="mb-3">
                <h6 class="usertype">Teaching Staff</h6>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>



