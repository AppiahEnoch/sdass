<div id="wrapper8" class="container justify-content-center align-items-center mt-2 d-none">
  <div class="container mt-2">
    <div class="row justify-content-center align-items-center">
      <div class="col-12 col-sm-10 col-md-8 col-lg-6">
        <form id="headteacher_upload_signature_form" class="custom-form" enctype="multipart/form-data">

          <!-- Image Upload Input -->
          <div class="mb-3">
            <label for="headteacher_upload_signature" class="form-label">Upload Signature</label>
            <input class="form-control" type="file" id="headteacher_upload_signature" name="headteacher_upload_signature" accept="image/*">
            <!-- Image preview -->
            <img id="headteacher_signature_preview" src="../devimage/default_signature.png" alt="Signature Preview" class="img-fluid mt-3" ">
          </div>

          <!-- Submit and Cancel buttons -->
          <div class="row">
            <div class="col-lg-6 mb-3">
              <button type="submit" class="btn btn-primary w-100">Submit</button>
            </div>
            <div class="col-lg-6 mb-3">
              <button id="cancel_image" type="button" class="btn btn-secondary w-100 ae-reset">Cancel</button>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
