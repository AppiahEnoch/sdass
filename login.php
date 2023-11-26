


<div id="wrapper2" class="container justify-content-center align-items-center mt-2">

    <div class="row justify-content-center align-items-center">
        <div class="col-12 ">
            <form class="login-form justify-content-center align-items-center" id="login_form1">

                <h4 class="text-center mb-4 fw-bold text-success">LOGIN </h4>

                <!-- Username -->
                <div class="mb-3 justify-content-center align-items-center">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-user"></i>
                        </span>
                        <input required type="text" class="form-control" id="login_username" name="login_username" placeholder="Username">
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-3 justify-content-center align-items-center">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input required type="password" class="form-control" id="login_password" name="login_password" placeholder="Password">
                        <span class="input-group-text">
                            <i class="fas fa-eye-slash" onclick="togglePasswordVisibility('login_password', this)"></i>
                        </span>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-2">Login</button>
                <a onclick="showWrapper4(['wrapper3'], 'wrapper', 20);" href="#" class="text-decoration-none text-primary">Forgot password?</a>
            </form>
        </div>
    </div>
</div>





<!-- Script to toggle password visibility -->
<script>
function togglePasswordVisibility(passwordInputId, iconElement) {
  var passwordInput = document.getElementById(passwordInputId);

  // Check if the input type is password or text
  if (passwordInput.type === 'password') {
    // If password, change type to text and swap icon
    passwordInput.type = 'text';
    iconElement.classList.remove('fa-eye-slash');
    iconElement.classList.add('fa-eye');
  } else {
    // If text, change type to password and swap icon back
    passwordInput.type = 'password';
    iconElement.classList.remove('fa-eye');
    iconElement.classList.add('fa-eye-slash');
  }
}



</script>





