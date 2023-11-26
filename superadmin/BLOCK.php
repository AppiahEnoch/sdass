<div id="wrapper5" class="container-fluid search-container mt-2 d-none">
  <div class="row justify-content-center align-items-center mb-3">
    <div class="col-auto">
      <div class="card">
        <div class="card-body text-center">
          <img
            src="../icon/34.png"
            class="rounded-circle"
            alt="Student Passport"
            style="width: 100px; height: 100px"
          />
          <h5 class="card-title mt-3">Search by Name or ID</h5>
        </div>
      </div>

      <div class="search-box mt-3">
        <input
          type="text"
          class="search-input"
          id="super_admin_block_search_input"
          name="super_admin_block_search_input"
          placeholder="Search by name or admission number"
        />
        <i class="fas fa-search search-icon"></i>

        <div
          id="super_admin_block_search_admission_list"
          class="card ae-search-option d-none"
        >
          <ul
            id="super_admin_block_search_admission_suggestion"
            class="list-group"
          >
            <li class="list-group-item">An item</li>
            <li class="list-group-item">A second item</li>
            <li class="list-group-item">A third item</li>
            <li class="list-group-item">A fourth item</li>
            <li class="list-group-item">And a fifth one</li>
          </ul>
        </div>
      </div>


<div id="block_user_card" class="row d-none">
    <div  class="container mt-3">
        <div class="form-check form-switch">
               <input class="form-check-input" type="checkbox" role="switch" id="blockUserSwitch">
               <label class="form-check-label" for="blockUserSwitch">Block User</label>
             </div>
           </div>
     <div class="row justify-content-center">
       <div class="col-12">
         <div class="card text-center">
           <div class="d-flex justify-content-between align-items-center px-3 pt-3">
             <img id="image_src_for_block" src="../devimage/logo.png" class="rounded-circle" style="width: 100px; height: 100px; object-fit: cover;" alt="User Profile Picture">
    
           <div class="card-body">
             <h5 class="card-title"><span id="block_user_full_name">fullName</span></h5>
             <p class="card-text">User ID:<span id="userId">userId</span></p>
             <p class="card-subtitle mb-2 text-muted">User Type: <span id="userType">userType</span></p>
           </div>
         </div>
       </div>
     </div>
   </div>
   
</div>








      
    </div>
  </div>

  <div class="container my-4 ae-form">
  <div class="row justify-content-center">
    <div class="col-12 col-md-12 col-lg-5">
      <form id="red_button_form2">
        <div class="card">
          <div class="card-header">
          <i class="fa fa-unlock-alt fa-2x" aria-hidden="true"></i>  Reset User Details
          </div>
          <div class="card-body">

            <!-- User ID Input -->
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <span class="input-group-text">
                  <i class="fas fa-user"></i>
                </span>
                <input readonly required type="text" class="form-control" id="reset_user_userId" name="userId" placeholder="Enter User ID">
              </div>
            </div>

            <!-- First Name Input -->
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <span class="input-group-text">
                  <i class="fas fa-user"></i>
                </span>
                <input required type="text" class="form-control" id="firstName" name="firstName" placeholder="First Name">
              </div>
            </div>

            <!-- Middle Name Input -->
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <span class="input-group-text">
                  <i class="fas fa-user"></i>
                </span>
                <input type="text" class="form-control" id="middleName" name="middleName" placeholder="Middle Name">
              </div>
            </div>

            <!-- Last Name Input -->
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <span class="input-group-text">
                  <i class="fas fa-user"></i>
                </span>
                <input required type="text" class="form-control" id="lastName" name="lastName" placeholder="Last Name">
              </div>
            </div>

            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <span class="input-group-text">
                  <i class="fas fa-user"></i>
                </span>
                <input required type="text" class="form-control" id="username" name="username" placeholder="username">
              </div>
            </div>

            <!-- New Password Input -->
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <span class="input-group-text">
                  <i class="fas fa-lock"></i>
                </span>
                <input required type="password" class="form-control" id="newPassword" name="newPassword" placeholder="Enter New Password">
              </div>
            </div>

            <!-- Confirm New Password Input -->
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <span class="input-group-text">
                  <i class="fas fa-lock"></i>
                </span>
                <input required type="password" class="form-control" id="confirmNewPassword" name="confirmNewPassword" placeholder="Confirm New Password">
              </div>
            </div>

            <!-- Email Input -->
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <span class="input-group-text">
                  <i class="fas fa-envelope"></i>
                </span>
                <input required type="email" class="form-control" id="email" name="email" placeholder="Enter Email Address">
              </div>
            </div>

            <!-- Phone Number Input -->
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <span class="input-group-text">
                  <i class="fas fa-phone"></i>
                </span>
                <input required type="tel" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="Enter Phone Number">
              </div>
            </div>

            <!-- Submit and Cancel buttons -->
            <div class="row">
              <div class="col-lg-6 mb-3">
                <button type="submit" class="btn btn-primary w-100">Reset</button>
              </div>
              <div class="col-lg-6 mb-3">
                <button type="button" class="btn btn-secondary w-100 ae-reset">Cancel</button>
              </div>
            </div>

          </div>
        </div>
      </form>
    </div>
  </div>
</div>

</div>
