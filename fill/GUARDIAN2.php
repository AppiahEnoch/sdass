<div id="wrapper2" class="container justify-content-center align-items-center mt-2 d-none">
  <h4 class="text-center form-title">Guardian Details</h4> <!-- Descriptive Header -->
  <div class="row justify-content-center align-items-center">
    <div class="col-12 col-sm-10 col-md-10 col-lg-10">
      <form id="guardian_info_form2">
        <!-- Input for Location -->
        <div class="mb-3">
          <label for="location" class="form-label">Guardian Location</label>
          <input required type="text" class="form-control" id="location" placeholder="Guardian location">
        </div>

        <!-- Input for Email -->
        <div class="mb-3">
          <label for="email" class="form-label">Guardian Email</label>
          <input  type="email" class="form-control" id="email" placeholder="Guardian email">
        </div>

        <!-- Input for Mobile -->
        <div class="mb-3">
          <label for="mobile" class="form-label">Guardian Mobile</label>
          <input required type="tel" class="form-control" id="mobile" placeholder="Guardian mobile">
        </div>

        <!-- Input for Postal Address -->
        <div class="mb-3">
          <label for="postaladdress" class="form-label">Postal Address</label>
          <input required type="text" class="form-control" id="postaladdress" placeholder="Postal address">
        </div>

        <!-- Input for Digital Address -->
        <div class="mb-3">
          <label for="digitaladdress" class="form-label">Digital Address</label>
          <input type="text" class="form-control" id="digitaladdress" placeholder="Digital address">
        </div>

        <!-- Buttons -->
        <div class="mb-3 justify-content-center align-items-center">
          <div class="row">
            <div class="col-7">
               <button type="submit" class="btn btn-primary w-100">Next</button>
            </div>
            <div class="col-5">
              <button id="guardian2_back"  type="button"  class="btn btn-secondary w-100">Back</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
