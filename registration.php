

<div id="wrapper1" class="container justify-content-center align-items-center mt-2  d-none">
  <div class="row justify-content-center align-items-center">
    <div class="col-12 ">
      <form class="custom-form justify-content-center align-items-center" id="form1">

        <div class="mb-3 justify-content-center align-items-center">
          <div class="input-group mb-0">
            <span class="input-group-text">
              <i class="fas fa-key"></i>
            </span>
            <input  required type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile eg. 0549822202">
              
           

          </div>
          <div class="row d-none" id="mobileError"> Invalid Mobile</div>
      
        </div>
       

        <div class="mb-3 justify-content-center align-items-center">
          <div class="input-group">
            <span class="input-group-text">
            <i class="fa fa-envelope" aria-hidden="true"></i>
            </span>
            <input   required  type="email" class="form-control" id="email" name="email" placeholder="Email">
          </div>
        </div>


        <div class="mb-3 justify-content-center align-items-center">
          <div class="input-group">
            <span class="input-group-text">
            <i class="fa fa-address-book-o" aria-hidden="true"></i>
            </span>
            <input  required type="text" class="form-control" id="firstname" name="firstname" placeholder="First name">
          </div>
        </div>
        <div class="mb-3 justify-content-center align-items-center">
          <div class="input-group">
            <span class="input-group-text">
            <i class="fa fa-address-book-o" aria-hidden="true"></i>
            </span>
            <input  type="text" class="form-control" id="middlename" name="middlename" placeholder="Middle name(s)">
          </div>
        </div>

        <div class="mb-3 justify-content-center align-items-center">
          <div class="input-group">
            <span class="input-group-text">
            <i class="fa fa-address-book-o" aria-hidden="true"></i>
            </span>
            <input  required type="text" class="form-control" id="lastname" name="lastname" placeholder="Last name">
          </div>
        </div>

        <div id="userCalssWrapper" class="mb-3 justify-content-center align-items-center d-none">
    <div class="input-group">
        <span class="input-group-text">
            <i class="fas fa-list-ol"></i>
        </span>
        <select class="form-control" id="userClass" name="userClass">
            <option selected value="0">SELECT CLASS</option>

        </select>
    </div>
</div>


        <div class="mb-3 justify-content-center align-items-center">
          <div class="input-group">
            <span class="input-group-text">
              <i class="fas fa-user"></i>
            </span>
            <input  required type="text" class="form-control" id="username" name="username" placeholder="Username">
          </div>
        </div>

        <div class="mb-3 justify-content-center align-items-center">
          <div class="input-group">
            <span class="input-group-text">
              <i class="fas fa-lock"></i>
            </span>
            <input  required type="password" class="form-control" id="password" name="password" placeholder="Password">
            <span class="input-group-text">
              <i class="fas fa-eye" onclick="togglePasswordVisibility('password', this)"></i>
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
              <i class="fas fa-eye" onclick="togglePasswordVisibility('confirmPassword', this)"></i>
            </span>
          </div>
        </div>

     <div class="row">
      <div class="col-12 col-md-8 mb-3">
      <button type="submit" class="btn btn-primary w-100">Submit </button>
      </div>
      <div class="col-12 col-md-4">
      <button onclick="hide_registration_form()" type="button" class="btn btn-secondary w-100 ae-reset">Cancel</button>
      </div>
     </div>
      </form>
    </div>
  </div>
</div>

<script>
  function togglePasswordVisibility(id, iconElement) {
    var element = document.getElementById(id);
    if (element.type === "password") {
      element.type = "text";
      iconElement.classList.remove('fa-eye');
      iconElement.classList.add('fa-eye-slash');
    } else {
      element.type = "password";
      iconElement.classList.remove('fa-eye-slash');
      iconElement.classList.add('fa-eye');
    }
  }
</script>
