<div

  class="container justify-content-center align-items-center mt-2 mb-5"
>
  <div class="container mt-2">
    <div class="row justify-content-center align-items-center">
      <div class="col-12 col-sm-10 col-md-8 col-lg-6">
        <form id="customForm" class="custom-form">
          <div id="student_passport_wrapper" class="row">
            <img
              id="student_passport_url"
              src="../devimage/logo.png"
              alt="Student Passport"
              class="img-fluid"
            />
          </div>

          <!-- Card for Student Details -->
          <div class="card non-clickable">
            <div class="card-header">Student Details <a href="../fill/page.php"> <i class="fa fa-pencil-square-o fa-2x  ms-5 edit-icon" aria-hidden="true"><span class="small-text"> edit</span></i></a> </div>
            <div class="card-body">
              <ul
                id="student_basic_portal_details"
                class="list-group list-group-flush non-clickable"
              >
                <li class="list-group-item">
                  Admission Number: <span class="w-100  fw-bold text-success ms-2" id="admissionNumber"></span>
                </li>
                <li class="list-group-item">
                  House: <span class="w-100  fw-bold text-success ms-2" id="house"></span>
                </li>

                <li class="list-group-item">
                  BECE Index number: <span id="bece_index"></span>
                </li>

            
                <li class="list-group-item">
                  Full Name: <span id="fullname"></span>
                </li>
                <li class="list-group-item">
                  Programme: <span id="programme"></span>
                </li>

                <li class="list-group-item">
                  Class: <span id="studentClass"></span>
                </li>
                <li class="list-group-item">
                  Guardian's Full Name: <span id="guardianFullName"></span>
                </li>
                <li class="list-group-item">
                  Guardian's Mobile: <span id="guardianMobile"></span>
                </li>
                <li class="list-group-item">
                  Guardian's Email: <span id="guardianEmail"></span>
                </li>
                <li class="list-group-item">
                  Father's Full Name: <span id="fatherFullName"></span>
                </li>
                <li class="list-group-item">
                  Father's Mobile: <span id="fatherMobile"></span>
                </li>
                <li class="list-group-item">
                  Mother's Full Name: <span id="motherFullName"></span>
                </li>
                <li class="list-group-item">
                  Mother's Mobile: <span id="motherMobile"></span>
                </li>
              </ul>
            </div>
          </div>


          <div id="wrapper2" class="card">
  <div class="card-body text-center">
    <!-- Button with icon and text -->
    <button id="student_view_docs" type="button" class="btn btn-primary">
      <i class="bi bi-eye-slash-fill"></i> Click to View Documents
    </button>
  </div>
</div>


<div id="wrapper1" class="d-none">
  
          <div  class="card mt-3 justify-content-center align-items-center ae-hide">
            <div class="card-header d-doc">DOWNLOAD DOCUMENTS</div>
            <div class="card-body w-100">
  <div class="row justify-content-center">
    <div class="col-12 col-lg-6 mb-2 d-flex justify-content-center mb-3">
      <a onclick="print_form()" class="btn btn-primary text-center">
        <img class="download-image-icon" src="../devimage/pdf.png" alt="">
        <i class="fa fa-download"></i> Admission form
      </a>
    </div>
    <div class="col-12 col-lg-6 mb-2 d-flex justify-content-center">
      <a onclick="print_letter()" class="btn btn-primary text-center">
        <img class="download-image-icon" src="../devimage/pdf.png" alt="">
        <i class="fa fa-download"></i> Admission Letter
      </a>
    </div>
  </div>
</div>

          </div>

          
          <div class="card mt-3 justify-content-center align-items-center ">
         
            <div class="card-body w-100">
              <div class="row justify-content-center align-items-center">
                <div class="col-12 col-lg-6 mb-2  d-flex justify-content-center align-items-center">
                  <a onclick="print_terminal_report()" class="btn btn-primary">
                  <img class="download-image-icon" src="../devimage/pdf.png" alt="">
                  <i class="fa fa-download"></i>Prospectus
                    
                  </a>
                </div>
             
              </div>
            </div>
          </div>
</div>

          <div class="card mt-3 d-none">
            <div class="card-header">Student Report</div>
            <div class="card-body">
              <div class="row ">
                <div class="col-12 col-lg-6 mb-2">
                  <a onclick="print_terminal_report()" class="btn btn-primary">
                    <i class="fa fa-download"></i> Current report
                  </a>
                </div>
                <div class="col-12 col-lg-6">
                  <a onclick="print_transcript()" class="btn btn-primary">
                    <i class="fa fa-download"></i> All Reports
                  </a>
                </div>
              </div>
            </div>
          </div>

          <div class="card mt-3 d-none">
            <div class="card-header">Student Bill</div>
            <div class="card-body">
              <a onclick="print_bill()" class="btn btn-primary">
                <i class="fa fa-download"></i> Bill and payment history
              </a>
            </div>
          </div>


          <div class="card mt-3 d-none">
            <div class="card-header">Only Most Current Timetable & Academic Calender are available</div>
            <div class="card-body">
              <div class="row">
                <div class="col-12 col-lg-6 mb-2">
                  <a onclick="download_timetable()" class="btn btn-primary">
                    <i class="fa fa-download"></i> Timetable
                  </a>
                </div>
                <div class="col-12 col-lg-6">
                  <a onclick="download_academic_calendar()" class="btn btn-primary">
                    <i class="fa fa-download"></i>Academic calendar
                  </a>
                </div>
              </div>
            </div>
          </div>



          
        </form>
      </div>
    </div>
  </div>
</div>
