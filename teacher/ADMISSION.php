<div
  id="wrapper3"
  class="container justify-content-center align-items-center mt-5 d-none"
>
  <div class="row justify-content-center align-items-center">
    <div class="col-12 col-sm-10 col-md-8 col-lg-6">
      <form
        class="custom-form justify-content-center align-items-center"
        id="admissionForm"
      >
        <div class="row m-auto">
          <div
            id="admissionTitle"
            class="row align-items-center justify-content-center m-auto"
          >
            <div class="card">
              <h2 class="w-100 text-center">ADMISSION FORM</h2>
              <h6 class="w-100 text-center">
                ADMISSION NUMBER:
                <span id="currentAdmissionNumber">###########</span>
              </h6>
              <div class="row">
                <div class="col-6">
                  <i
                    id="admission_edit"
                    class="fa fa-search fa-2x"
                    aria-hidden="true"
                    ><span class="small">
                      <label for="admission_edit">Search</label>
                    </span></i
                  >
                </div>
                <div id="admission_print_card" class="col-6 justify-content-end text-end">
                  <div class="dropdown">
                    <button class="btn dropdown-toggle" type="button" id="admission_print" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="fa fa-print fa-2x" aria-hidden="true"></i>
                      <span class="small"><label for="admission_print">Print</label></span>
                    </button>
                    <ul id="admission_print_menu" class="dropdown-menu" aria-labelledby="admission_print">
                      <li><a id="print_admission_form" class="dropdown-item" href="#">Admission Form</a></li>
                      <li><a id="print_admission_letter" class="dropdown-item" href="#">Admission Letter</a></li>
                      <li><a id="print_admission_bill" class="dropdown-item" href="#">Student Bill</a></li>
                   
                    </ul>
                  </div>
                </div>
                
              </div>
            </div>
          </div>
        </div>
        <h3 class="text-center mb-4">Child's Details:</h3>
        <div
          id="studentPassportImageContainer"
          class="row mb-3 justify-content-center align-items-center"
        >
          <div class="card" style="width: 10em; height: 10em">
            <img
              src="../devimage/passport.png"
              class="card-img-top"
              alt="Student Passport Size Image"
              id="studentPassportImage"
              style="width: 100%; height: 100%; object-fit: contain"
              onclick="openFileChooser()"
            />

            <input
              type="file"
              id="studentPassportImageInput"
              class="d-none"
              accept="image/*"
            />

            <div class="card-body" style="padding: 0">
              <h5
                class="card-title m-0 p-0"
                id="studentCardTitle"
            
              >
                Passport Picture
              </h5>
            </div>
          </div>
        </div>

        <div
          id="admission_search"
          class="container-fluid search-container mt-2 d-none"
        >
          <div class="row justify-content-center align-items-center">
            <div class="col-auto w-100">
              <div class="search-box">
                <input
                id="admission_search_input"
                  type="search"
                  class="admission-search"
                  placeholder="Search by Name or Admission Number"
                />
                <i class="fas fa-search search-icon"></i>

                <div id="admission-list" class="card d-none">
                  <ul id="admission-suggestion" class="list-group">
                    <li class="list-group-item">An item</li>
                    <li class="list-group-item">A second item</li>
                    <li class="list-group-item">A third item</li>
                    <li class="list-group-item">A fourth item</li>
                    <li class="list-group-item">And a fifth one</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12 col-lg-6">
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <span class="input-group-text">
                  <i class="fas fa-child"></i> First name
                </span>
                <input
                required
                  
                  type="text"
                  class="form-control"
                  id="firstname"
                  name="firstname"
                  placeholder="Child's First Name"
                />
              </div>
            </div>
          </div>
          <div class="col-12 col-lg-6">
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <span class="input-group-text">
                  <i class="fas fa-child"></i>Middle Name(s)
                </span>
                <input
                  type="text"
                  class="form-control"
                  id="middlename"
                  name="middlename"
                  placeholder="Child's Middle Name(s)"
                />
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12 col-lg-6">
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <span class="input-group-text">
                  <i class="fas fa-child"></i> Last Name
                </span>
                <input
                required
                  type="text"
                  class="form-control"
                  id="lastname"
                  name="lastname"
                  placeholder="Child's Last Name"
                />
              </div>
            </div>
          </div>

       
          
          <div class="col-12 col-lg-6">
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <label for="dateOfBirth" class="input-group-text">
                  <i class="fas fa-birthday-cake"></i> Date of Birth
                </label>
                <input
                required
                  type="date"
                  class="form-control"
                  id="dateOfBirth"
                  name="dateOfBirth"
                />
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12 col-lg-6">
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <label for="ghana_card_number" class="input-group-text">
                  <i class="fas fa-id-card"></i> Ghana Card
                </label>
                <input
                  type="text"
                  class="form-control"
                  id="ghana_card_number"
                  name="ghana_card_number"
                  placeholder="Ghana Card"
                />
              </div>
            </div>
          </div>
          <div class="col-12 col-lg-6">
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <label for="ghana_card_image" class="input-group-text">
                  <i class="fas fa-image"></i> Ghana Card
                </label>
                <input
                  type="file"
                  class="form-control"
                  id="ghana_card_image"
                  name="ghana_card_image"
                />
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12 col-lg-6">
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <label for="birthCertificate" class="input-group-text">
                  <i class="fas fa-certificate"></i> BIRTH CERT.
                </label>
                <input
                  type="file"
                  class="form-control"
                  id="birthCertificate"
                  name="birthCertificate"
                />
              </div>
            </div>
          </div>
          <div class="col-12 col-lg-6">
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <label for="previous_school_report" class="input-group-text">
                  <i class="fas fa-file-alt"></i>Report
                </label>
                <input
                  type="file"
                  class="form-control"
                  id="previous_school_report"
                  name="previous_school_report"
                  multiple
                />
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12 col-lg-6">
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <label for="class_selection" class="input-group-text">
                  <i class="fas fa-school"></i> Class
                </label>
                <select
                  class="form-control"
                  id="class_selection"
                  name="class_selection"
                >
                  <option value="0">Select Class...</option>
                </select>
              </div>
            </div>
          </div>

          <div class="col-12 col-lg-6">
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <label for="dateOfAdmission" class="input-group-text">
                  <i class="fas fa-calendar-alt"></i> Date of Admission
                </label>
                <input
                  
                  type="date"
                  class="form-control"
                  id="dateOfAdmission"
                  name="dateOfAdmission"
                />
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12 col-lg-6">
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <label for="child_nationality" class="input-group-text">
                  <i class="fas fa-id-card"></i> Nationality
                </label>
                <input
                  type="text"
                  class="form-control"
                  id="child_nationality"
                  name="child_nationality"
                  value="Ghanaian"
                  placeholder="Nationality"
                />
              </div>
            </div>
          </div>

          <div class="col-12 col-lg-6">
            <div class="row">
              <div class="col-6">
                <div class="form-check form-switch">
                  <input class="form-check-input gender-switch" type="checkbox" role="switch" id="male_switch" name="gender" value="Male">
                  <label class="form-check-label" for="male_switch">Male</label>
                </div>
              </div>
              <div class="col-6">
                <div class="form-check form-switch">
                  <input class="form-check-input gender-switch" type="checkbox" role="switch" id="female_switch" name="gender" value="Female">
                  <label class="form-check-label" for="female_switch">Female</label>
                </div>
              </div>
            </div>
          </div>
          
        </div>

        <div class="col-12">
          <div class="mb-3 justify-content-center align-items-center">
            <div class="input-group">
              <label for="languagesSpoken" class="input-group-text">
                <i class="fas fa-language"></i> Languages Spoken
              </label>
              <textarea required class="form-control" id="language_spoken" name="language_spoken"> Asante Twi, Sefwi, English Language</textarea>
            </div>
          </div>
        </div>
        

        <div class="row">
          <div class="col-12">
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <label for="residentialAddress" class="input-group-text">
                  <i class="fas fa-home"></i> Residential Address
                </label>
                <input
                  type="text"
                  class="form-control"
                  id="residentialAddress"
                  name="residentialAddress"
                />
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <label class="input-group-text">
                  <i class="fas fa-question-circle"></i> This child has a health
                  problem?
                </label>
                <select
                  
                  class="form-control"
                  id="hasHealthProblem"
                  name="hasHealthProblem"
                >
                  <option value="">Select Option</option>
                  <option value="Yes">Yes</option>
                  <option value="No">No</option>
                </select>
              </div>
            </div>
          </div>
          <div class="col-12 d-none" id="healthProblemDetails">
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <label for="healthProblemTextArea" class="input-group-text">
                  <i class="fas fa-notes-medical"></i> Health Problem Details
                </label>
                <textarea
                  class="form-control"
                  id="healthProblemTextArea"
                  name="healthProblemTextArea"
                ></textarea>
              </div>
            </div>
          </div>
        </div>
        

        <div class="row">
          <div class="col-12">
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <label class="input-group-text">
                  <i class="fas fa-question-circle"></i> Child Has Special
                  Needs?
                </label>
                <select
                  
                  class="form-control"
                  id="hasSpecialNeeds"
                  name="hasSpecialNeeds"
                >
                  <option value="">Select Option</option>
                  <option value="Yes">Yes</option>
                  <option value="No">No</option>
                </select>
              </div>
            </div>
          </div>
          <div class="col-12 d-none" id="specialNeedsDetails">
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <label for="specialNeedsTextArea" class="input-group-text">
                  <i class="fas fa-wheelchair"></i> Special Needs Details
                </label>
                <textarea
                  class="form-control"
                  id="specialNeedsTextArea"
                  name="specialNeedsTextArea"
                ></textarea>
              </div>
            </div>
          </div>
        </div>

        <h3 class="text-center mb-4">Guardian Details:</h3>

        <div class="row">
          <div class="col-12 col-lg-6">
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <span class="input-group-text">
                  <i class="fas fa-user"></i>
                </span>
                <input
                required
                  type="text"
                  class="form-control"
                  id="parent_firstName"
                  name="parent_firstName"
                  placeholder="First Name"
                />
              </div>
            </div>
          </div>
          <div class="col-12 col-lg-6">
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <span class="input-group-text">
                  <i class="fas fa-user"></i>
                </span>
                <input
                  type="text"
                  class="form-control"
                  id="parent_middleName"
                  name="parent_middleName"
                  placeholder="Middle Name"
                />
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12 col-lg-6">
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <span class="input-group-text">
                  <i class="fas fa-user"></i>
                </span>
                <input
                required
                  type="text"
                  class="form-control"
                  id="parent_lastName"
                  name="parent_lastName"
                  placeholder="Last Name"
                />
              </div>
            </div>
          </div>
          <div class="col-12 col-lg-6">
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <span class="input-group-text">
                  <i class="fas fa-image"></i>Passport Picture
                </span>
                <input
                  
                  type="file"
                  class="form-control"
                  id="parent_passport_picture"
                  name="parent_passport_picture"
                  placeholder="Parent's Passport Picture"
                />
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12 col-lg-6">
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <span class="input-group-text">
                  <i class="fas fa-id-card"></i>
                </span>
                <input
                  type="text"
                  class="form-control"
                  id="parent_ghana_card_number"
                  name="parent_ghana_card_number"
                  placeholder="Ghana Card Number"
                />
              </div>
            </div>
          </div>
          <div class="col-12 col-lg-6">
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <span class="input-group-text">
                  <i class="fas fa-image"></i>Ghana Card
                </span>
                <input
                  type="file"
                  class="form-control"
                  id="parent_ghana_card_image"
                  name="paret_ghana_card_image"
                />
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12 col-lg-6">
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <span class="input-group-text">
                  <i class="fas fa-phone-alt"></i>
                </span>
                <input
                  required
                  type="text"
                  class="form-control"
                  id="parent_mobile"
                  name="parent_mobile"
                  placeholder="Mobile Number"
                />
              </div>
            </div>
          </div>
          <div class="col-12 col-lg-6">
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <span class="input-group-text">
                  <i class="fas fa-envelope"></i>
                </span>
                <input
                  type="email"
                  class="form-control"
                  id="parent_email"
                  name="parent_email"
                  placeholder="Email Address"
                />
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12- col-lg-6">
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <label for="parent_region" class="input-group-text">
                  <i class="fa fa-globe" aria-hidden="true"></i>
                </label>
                <select
                  
                  class="form-control"
                  id="parent_region"
                  name="parent_region"
                >
                  <option value="">Select Region</option>
                </select>
              </div>
            </div>
          </div>

          <div class="col-12 col-lg-6">
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <span class="input-group-text">
                  <i class="fas fa-map-marker-alt"></i>
                </span>
                <input
                  
                  type="text"
                  class="form-control"
                  id="parent_location"
                  name="parent_location"
                  placeholder="HomeTown"
                />
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12 col-lg-6">
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <span class="input-group-text">
                  <i class="fas fa-briefcase"></i>
                </span>
                <input
                  
                  type="text"
                  class="form-control"
                  id="parent_occupation"
                  name="parent_occupation"
                  placeholder="Occupation"
                />
              </div>
            </div>
          </div>
          <div class="col-12 col-lg-6">
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <span class="input-group-text">
                  <i class="fas fa-file-alt"></i>Proof of Residence
                </span>
                <input
                  type="file"
                  class="form-control"
                  id="parent_proof_of_residence"
                  name="parent_proof_of_residence"
                />
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <span class="input-group-text">
                  <i class="fas fa-home"></i>
                </span>
                <input
                  
                  type="text"
                  class="form-control"
                  id="parent_house_address"
                  name="parent_house_address"
                  placeholder="Residential Address"
                />
              </div>
            </div>
          </div>
        </div>

        

        <div class="col-12">
          <div class="mb-3 justify-content-center align-items-center">
            <div class="input-group">
              <label for="relationship_with_child" class="input-group-text">
                <i class="fas fa-users"></i> Relationship with Child
              </label>
              <input required type="text" class="form-control" id="relationship_with_child" name="relationship_with_child" />
            </div>
          </div>
        </div>
        

        <h3 class="text-center mb-4">Father's Details:</h3>

        <!-- Father's Full Name -->
        <!-- Father's First Name -->
        <div class="row">
          <div class="col-12 col-lg-6">
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <label for="father_first_name" class="input-group-text">
                  <i class="fas fa-user"></i> First Name
                </label>
                <input
                  type="text" 
                  required
                 class="form-control"
                  id="father_first_name"
                  name="father_first_name"
                />
              </div>
            </div>
          </div>

          <!-- Father's Middle Name -->

          <div class="col-12 col-lg-6">
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <label for="father_middle_name" class="input-group-text">
                  <i class="fas fa-user"></i> Middle Name
                </label>
                <input
                  type="text"
                  class="form-control"
                  id="father_middle_name"
                  name="father_middle_name"
                />
              </div>
            </div>
          </div>
        </div>

        <!-- Father's Last Name row -->

        <div class="row">
          <div class="col-12 col-lg-6">
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <label for="father_last_name" class="input-group-text">
                  <i class="fas fa-user"></i> Last Name
                </label>
                <input
                  type="text"  
                  required
                  class="form-control"
                  id="father_last_name"
                  name="father_last_name"
                />
              </div>
            </div>
          </div>

          <div class="col-12 col-lg-6">
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <label for="father_education" class="input-group-text">
                  <i class="fas fa-graduation-cap"></i> Edu. Qualification
                </label>
                <select
                  class="form-control"
                  id="father_education"
                  name="father_education"
                >
                  <option value="">Select Qualification</option>
                </select>
              </div>
            </div>
          </div>
        </div>

        <!-- Father's Occupation -->
        <div class="row">
          <div class="col-12 col-lg-6">
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <label for="father_occupation" class="input-group-text">
                  <i class="fas fa-briefcase"></i> Occupation
                </label>
                <input
                  type="text"
                  class="form-control"
                  id="father_occupation"
                  name="father_occupation"
                />
              </div>
            </div>
          </div>

          <div class="col-12 col-lg-6">
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <label for="father_mobile" class="input-group-text">
                  <i class="fas fa-phone"></i> Mobile
                </label>
                <input
                  type="tel"
                  class="form-control"
                  id="father_mobile"
                  name="father_mobile"
                />
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <label for="father_residential_address" class="input-group-text">
                  <i class="fas fa-home"></i> Residential Address
                </label>
                <input
                  type="text"
                  class="form-control"
                  id="father_residential_address"
                  name="father_residential_address"
                />
              </div>
            </div>
          </div>
        </div>


        <h3 class="text-center mb-4">Mother's Details:</h3>
        <div class="row">
          <div class="col-12 col-lg-6">
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <label for="mothers_first_name" class="input-group-text">
                  <i class="fas fa-user"></i> First Name
                </label>
                <input type="text" 
                required
                
                class="form-control" id="mothers_first_name" name="mothers_first_name" />
              </div>
            </div>
          </div>
        
          <div class="col-12 col-lg-6">
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <label for="mothers_middle_name" class="input-group-text">
                  <i class="fas fa-user"></i> Middle Name
                </label>
                <input type="text" class="form-control" id="mothers_middle_name" name="mothers_middle_name" />
              </div>
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-12 col-lg-6">
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <label for="mothers_last_name" class="input-group-text">
                  <i class="fas fa-user"></i> Last Name
                </label>
                <input type="text" 
                required
                class="form-control" id="mothers_last_name" name="mothers_last_name" />
              </div>
            </div>
          </div>
        
          <div class="col-12 col-lg-6">
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <label for="mothers_education" class="input-group-text">
                  <i class="fas fa-graduation-cap"></i> Edu. Qualification
                </label>
                <select class="form-control" id="mothers_education" name="mothers_education">
                  <option value="">Select Qualification</option>
                </select>
              </div>
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-12 col-lg-6">
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <label for="mothers_occupation" class="input-group-text">
                  <i class="fas fa-briefcase"></i> Occupation
                </label>
                <input type="text" class="form-control" id="mothers_occupation" name="mothers_occupation" />
              
              </div>
            </div>
          </div>
        
          <div class="col-12 col-lg-6">
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <label for="mothers_mobile" class="input-group-text">
                  <i class="fas fa-phone"></i> Mobile
                </label>
                <input type="tel" class="form-control" id="mothers_mobile" name="mothers_mobile" />
              </div>
            </div>
          </div>
        </div>
        
        <div class="row">
          <div class="col-12">
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <label for="mothers_residential_address" class="input-group-text">
                  <i class="fas fa-home"></i> Residential Address
                </label>
                <input type="text" class="form-control" id="mothers_residential_address" name="mothers_residential_address" />
              
              </div>
            </div>
          </div>
        </div>
        

        <div class="row">
          <div class="col-12">
            <div class="mb-3 justify-content-center align-items-center">
              <div class="input-group">
                <input
                required
                  type="checkbox"
                  class="form-check-input"
                  id="schoolRulesAgreement"
                  name="schoolRulesAgreement"
                />
                <label for="schoolRulesAgreement" class="form-check-label">
                  I, the undersigned, hereby acknowledge on behalf of the child
                  and myself that I have read, understood, and agree to abide by
                  the school's rules and regulations."
                </label>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-lg-6 mb-2">
            <button
              id="admissionFormSubmission"
              type="submit"
              class="btn btn-primary w-100"
            >
              Submit
            </button>
          </div>
          <div class="col-12 col-lg-3 mb-2">
            <button
              id="admissionFormCancel"
              type="button"
              class="btn btn-secondary w-100"
            >
              Cancel
            </button>
          </div>
          <div class="col-12 col-lg-3">
            <button
              id="admissionFormDelete"
              type="button"
              class="btn btn-danger w-100"
            >
              <i class="fas fa-trash-alt"></i> Delete
            </button>
          </div>
        </div>

      </form>
    </div>
  </div>
</div>
