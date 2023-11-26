

<div id="wrapper1" class="container justify-content-center align-items-center mt-2">
  <div class="row justify-content-center align-items-center">
    <div class="col-12 col-sm-10 col-md-8 col-lg-6">
      <form class="custom-form justify-content-center align-items-center" id="form1">

        <div class="mb-3 justify-content-center align-items-center">
          <div class="input-group ">
            <span class="input-group-text">
              <i class="fas fa-key"></i>
            </span>
            <input  required type="text" class="form-control" id="mobile" name="mobile" placeholder="Mobile eg. 0549822202">
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
            <input  required type="text" class="form-control" id="middlename" name="middlename" placeholder="Middle name(s)">
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

        <div class="mb-3 justify-content-center align-items-center">
    <div class="input-group">
        <span class="input-group-text">
            <i class="fas fa-list-ol"></i>
        </span>
        <select class="form-control" id="userClass" name="userClass">
            <option selected value="0">SELECT CLASS</option>
            <option value="NURSERY1">NURSERY 1</option>
            <option value="NURSERY2">NURSERY 2</option>
            <option value="KINDERGARTEN1">KINDERGARTEN 1</option>
            <option value="KINDERGARTEN2">KINDERGARTEN 2</option>
            <option value="BS1">BS 1</option>
            <option value="BS2">BS 2</option>
            <option value="BS3">BS 3</option>
            <option value="BS4">BS 4</option>
            <option value="BS5">BS 5</option>
            <option value="BS6">BS 6</option>
            <option value="JHS1">JHS 1</option>
            <option value="JHS2">JHS 2</option>
            <option value="JHS3">JHS 3</option>
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

        <button type="submit" class="btn btn-primary w-100">Submit </button>
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
