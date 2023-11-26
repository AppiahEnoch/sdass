<div id="wrapper3" class="container justify-content-center align-items-center mt-2 d-none">
  <h4 class="text-center form-title">Student Details</h4> <!-- Descriptive Header -->
  <div class="row justify-content-center align-items-center">
    <div class="col-12 col-sm-10 col-md-10 col-lg-10">
      <form id="student_info_form1">
        <!-- Select for Gender -->
        <div class="mb-3">
          <label for="gender" class="form-label">Gender</label>
          <select class="form-select" id="gender">
            <option value="none">Choose Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
        </div>

        <!-- Input for NHIS Card Number -->
        <div class="mb-3">
          <label for="nhis" class="form-label">NHIS Card Number</label>
          <input type="text" class="form-control" id="nhis" placeholder="NHIS CARD NUMBER">
        </div>

        <!-- Input for Ghana Card Number -->
        <div class="mb-3">
          <label for="ghana" class="form-label">Ghana Card Number</label>
          <input type="text" class="form-control" id="ghana" placeholder="GHANA CARD NUMBER">
        </div>

        <!-- Input for Passport Picture -->
        <div class="mb-3">
          <label for="passport" class="form-label">Upload Student Passport Picture</label>
          <input accept="image/*" type="file" class="form-control" id="passport">
        </div>

        <!-- Input for Results Slip -->
        <div class="mb-3">
          <label for="resultslip" class="form-label">Upload Student Results</label>
          <input accept="application/pdf" required type="file" class="form-control" id="resultslip">
        </div>

        <!-- Buttons -->
        <div class="mb-3 justify-content-center align-items-center">
          <div class="row">
            <div class="col-7">
               <button type="submit" class="btn btn-primary w-100">Next</button>
            </div>
            <div class="col-5">
              <button id="student1_back" type="button"  class="btn btn-secondary w-100">Back</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
