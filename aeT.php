

<div id="aeToastR" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="toast-header">
      <i class="fa fa-question-circle"></i>
      <strong>Notification</strong>
      <small>success</small>

  </div>
  <div class="toast-body">
      <p id="toastMessage"></p>
      <div class="text-center">
          <button type="button" class="btn btn-primary btn-sm">OK <i class="fa fa-check-circle"></i></button>
      </div>
  </div>
</div>

<div id="aeToastP" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="toast-header">
  <i class="bi bi-check-circle-fill me-1"></i>
      <strong>Notification</strong>
      <small>success</small>

  </div>
  <div class="toast-body">
      <p id="toastMessage"></p>
      <div class="text-center">
          <button type="button" class="btn btn-primary btn-sm btn-success bg-success">OK <i class="fa fa-check-circle"></i></button>
      </div>
  </div>
</div>







<div id="aeToastE" class="toast m-0 p-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header W-100 m-0">
        <i class="fa fa-exclamation-triangle"></i>
        <strong>Error!</strong>
        <small>SDASS</small>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
        <!-- Content for the body of the error toast goes here -->
    </div>
</div>

<div id="aeToastS" class="toast toast m-0 p-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
        <i class="bi bi-check-circle-fill"></i>
        <strong>Success!</strong>
        <small>Success!</small>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
        <!-- Content for the body of the success toast goes here -->
    </div>
</div>

<div id="aeToastY" class="toast toast m-0 p-0" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="toast-header">
      <i class="fa fa-question-circle"></i>
      <strong>Confirm Delete Action!</strong>
      <small>Confirm!</small>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
  <div class="toast-body">
      <p id="toastMessage"></p>
      <div class="row row-cols-2">
          <div class="col text-end">
              <button type="button" class="btn btn-success btn-sm">Yes <i class="fa fa-thumbs-up"></i></button>
          </div>
          <div class="col">
              <button type="button" class="btn btn-danger btn-sm">No <i class="fa fa-thumbs-down"></i></button>
          </div>
      </div>
  </div>
</div>





<!-- BEGIN MY ALERTS -->
      <div id="alert1" class="alert alert-success  d-none alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill"></i> Item Uploaded Successfully!
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
<!-- END MY ALERTS -->


<!-- BEGIN MY SPIN-->
 <i id="spin1" class="fas fa-spinner fa-spin d-none "></i>
<!-- END MY SPIN -->


<div id="spinner-container" class="spinner-container text-center d-none">
      <div class="spinner-border" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
      <p class="loading-text">Processing ...</p>
    </div>

    



    
<div id="aeToastYN" class="toast toast m-0 p-0" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="toast-header bg-danger text-white">

      <i style="color: white;" class="fa fa-question-circle m-1" aria-hidden="true"></i>
      <strong class="me-auto">Confirm Delete Action!</strong>
      <small>Confirm!</small>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
  <div class="toast-body">
      <p id="toastMessage"></p>
<div class="row row-cols-2 ">
  <div class="col text-end">
    <button type="button" class="btn btn-success btn-sm me-2" onclick="handleYesClick()">Yes   <i class="fa fa-thumbs-up" aria-hidden="true"></i></button>
  
  </div>
  <div class="col">
    <button type="button" class="btn btn-danger btn-sm" onclick="handleNoClick()">No <i class="fa fa-thumbs-down" aria-hidden="true"></i> </button>
  </div>
 
</div>
  </div>
</div>


<div id="aeToastYN1" class="toast toast m-0 p-0" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="toast-header bg-danger text-white">

      <i style="color: white;" class="fa fa-question-circle m-1" aria-hidden="true"></i>
      <strong class="me-auto">Confirm Delete Action!</strong>
      <small>Confirm!</small>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
  <div class="toast-body">
      <p id="toastMessage"></p>
<div class="row row-cols-2 ">
  <div class="col text-end">
    <button type="button" class="btn btn-success btn-sm me-2" onclick="handleYesClick1()">Yes   <i class="fa fa-thumbs-up" aria-hidden="true"></i></button>
  
  </div>
  <div class="col">
    <button type="button" class="btn btn-danger btn-sm" onclick="handleNoClick()">No <i class="fa fa-thumbs-down" aria-hidden="true"></i> </button>
  </div>
 
</div>
  </div>
</div>


