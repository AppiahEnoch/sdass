<div id="wrapper15" class="container justify-content-center align-items-center mt-2 d-none">
  <div class="container mt-2">
    <div class="row justify-content-center align-items-center">
      <div class="col-12 col-sm-10 col-md-8 col-lg-6">
        <form id="uploadDocumentsForm" class="custom-form">
          <h5 class="text-primary">UPLOAD TIMETABLE AND ACADEMIC CALENDAR</h5>

          <!-- Upload timetable -->
          <div class="mb-3">
            <label for="timetableUpload" class="form-label">Upload Timetable (PDF, DOCX, Image)</label>
            <input class="form-control" type="file" id="timetableUpload" name="timetableUpload" accept=".pdf, .docx, image/*">
          </div>

          <div class="mb-3">
  <label for="admin_upload_class_timetable_select_class" class="form-label">Select Class</label>
  <select class="form-select" id="admin_upload_class_timetable_select_class" name="admin_upload_class_timetable_select_class">
    <option selected disabled>Choose Class...</option>
 
 
  </select>
</div>


          <!-- Upload academic calendar -->
          <div class="mb-3">
            <label for="academicCalendarUpload" class="form-label">Upload Academic Calendar (PDF, DOCX, Image)</label>
            <input class="form-control" type="file" id="academicCalendarUpload" name="academicCalendarUpload" accept=".pdf, .docx, image/*">
          </div>

          <!-- Submit and Cancel buttons -->
          <div class="row">
            <div class="col-lg-6 mb-3">
              <button id="submit_timetable" type="submit" class="btn btn-primary w-100">Submit</button>
            </div>
            <div class="col-lg-6 mb-3">
              <button type="button" class="btn btn-secondary w-100 ae-reset">Cancel</button>
            </div>
          </div>

        </form>


        <div class="container my-5 view">
  <div class="row">
    <div class="col-12">
      <div class="card border-0 shadow">
        <div class="card-body">
          <h5 class="card-title text-center">Downloadable Resources</h5>
          <hr>
          
          <div class="row row-cols-1 row-cols-sm-2 g-4">
            <div class="col">
              <div class="text-center">
                <a onclick="download_timetable()" id="download_timetable_link" class="btn btn-primary my-2">
                  <i class="fas fa-download"></i> Timetable
                </a>
                <p class="card-text">Current timetable</p>
                <div class="form-check form-switch mt-3 d-flex text-center justify-content-center">
                  <input class="form-check-input" type="checkbox" role="switch" id="timetableSwitchCheckDefault">
                  <label class="form-check-label" for="timetableSwitchCheckDefault"><span id="timetable_lock_text" class="ms-1">off</span></label>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="text-center">
                <a onclick="download_academic_calendar()" id="download_academic_calender_link" class="btn btn-primary my-2">
                  <i class="fas fa-download"></i> Academic Calendar
                </a>
                <p class="card-text">Current academic calendar</p>
                <div class="form-check form-switch mt-3 d-flex justify-content-center">
                  <input class="form-check-input" type="checkbox" role="switch" id="calendarSwitchCheckDefault">
                  <label class="form-check-label" for="calendarSwitchCheckDefault"><span id="calendar_lock_text" class="ms-1">off</span> </label>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>



        
      </div>
      
    </div>
  </div>
  
</div>



