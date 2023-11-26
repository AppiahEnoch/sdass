<div id="wrapper1" class="container justify-content-center align-items-center mt-2">
  <div class="row justify-content-center align-items-center">
    <div class="col-12 col-sm-10 col-md-8 col-lg-6">
    <form class="custom-form justify-content-center align-items-center" id="form1">
      <img class="logo" id="small_logo" src="../devimage/logo.png" alt="school logo">
  <span class="reset-text">DR.YAW ACKAH MEMORIAL SCHOOL <span class="psw"> PASSWORD RESET</span></span>

  <div class="my-3 justify-content-center align-items-center">
    <div class="input-group">
      <span class="input-group-text">
        <i class="fas fa-user"></i>
      </span>
      <input required type="text" class="form-control" id="username" name="username" placeholder="New Username">
    </div>
  </div>

  <div class="mb-3 justify-content-center align-items-center">
    <div class="input-group">
      <span class="input-group-text">
        <i class="fas fa-lock"></i>
      </span>
      <input required type="password" class="form-control" id="password" name="password" placeholder="Password">
      <span class="input-group-text">
        <i class="fas fa-eye-slash" onclick="togglePasswordVisibility('password', this)"></i> <!-- Changed to eye-slash -->
      </span>
    </div>
  </div>

  <div class="mb-3 justify-content-center align-items-center">
    <div class="input-group">
      <span class="input-group-text">
        <i class="fas fa-lock"></i>
      </span>
      <input required type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password">
      <span class="input-group-text">
        <i class="fas fa-eye-slash" onclick="togglePasswordVisibility('confirmPassword', this)"></i> <!-- Changed to eye-slash -->
      </span>
    </div>
  </div>

<div class="row">
  <div class="col-6">
  <button type="submit" class="btn btn-primary w-100">Reset</button>
  </div>
  <div class="col-6">
  <a  href="../index.php" type="button"  class="btn btn-secondary w-100">Go Back</a>
  </div>
</div>
</form>

    </div>
  </div>
</div>





<div id="aeToastYN" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
  <div class="toast-header bg-success text-white">

      <i style="color: white;" class="fa fa-check-circle m-1" aria-hidden="true"></i>
      <strong class="me-auto">SUCCESSFULL RESET!</strong>
      <small>Success!</small>
      <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
  </div>
  <div class="toast-body">
      <p id="toastMessage"></p>
<div class="row">

<div class="col m-2">
<button type="button" class="btn btn-success btn-sm mx-2 w-100" onclick="handleYesClick()">Return   <i class="fa fa-thumbs-up" aria-hidden="true"></i></button>
  
</div>
 
</div>
  </div>
</div>


<script>
function togglePasswordVisibility(id, iconElement) {
  var element = document.getElementById(id);
  if (element.type === "password") {
    element.type = "text";
    iconElement.classList.remove('fa-eye-slash'); // Reversed these two lines
    iconElement.classList.add('fa-eye');          // Reversed these two lines
  } else {
    element.type = "password";
    iconElement.classList.remove('fa-eye');       // Reversed these two lines
    iconElement.classList.add('fa-eye-slash');    // Reversed these two lines
  }
}

</script>
