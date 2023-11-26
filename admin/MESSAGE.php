<div
  id="wrapper17"
  class="container justify-content-center align-items-center mt-2 d-none"
>





  <div class="container mt-2">
    <div class="row justify-content-center align-items-center">
      <div class="col-12 col-sm-10 col-md-8 col-lg-6">
        <form id="admin_send_message_form" class="custom-form">

            <div class="card small-screen-card">
                <div class="card-title">
                    <h3 class="text-center text-primary ">Send Message</h3>
                </div>
                <div class="card-body">
                    <div
                    class="form-check form-switch mt-3 d-flex text-center justify-content-center"
                  >
                    <input
                      class="form-check-input"
                      type="checkbox"
                      role="switch"
                      id="admin_send_message_teacher_switch"
                    />
                    <label class="form-check-label" for="admin_send_message_teacher_switch"
                      ><span id="admin_send_message_teacher_switch_text" class="ms-1"
                        >Teacher</span
                      ></label
                    >
                  </div>
                
                  <div class="container-fluid search-container mt-2">
                    <div class="row justify-content-center align-items-center">
                      <div class="col-12 justify-content-center align-items-center">
                        <div class="search-box justify-content-center align-items-center">
                          <input
                            type="text"
                            class="small-screen"
                            id="admin_send_message_search_input"
                            name="admin_send_message_search_input"
                            placeholder="Search any thing"
                          />
                          <i class="fas fa-search search-icon"></i>
                
                          <div
                            id="admin_send_message_admission_list"
                            class="card ae-option d-none"
                          >
                            <ul id="admin_send_message_admission_suggestion" class="list-group">
                              <li class="list-group-item">An item</li>
                              <li class="list-group-item">A second item</li>
                              <li class="list-group-item">A third item</li>
                              <li class="list-group-item">A fourth item</li>
                              <li class="list-group-item">And a fifth one</li>
                            </ul>
                          </div>
                          <h5 class="text-start" id="selected_target_name"></h5>
                        </div>
                      </div>
                    </div>
                  </div>
                
                </div>

              
            </div>














            
          <div class="mb-3 mt-5">
            <label for="admin_send_message_target" class="form-label">Target Audience</label>
            <select class="form-select" id="admin_send_message_target" name="admin_send_message_target">
              <option selected disabled value="">Choose a target</option>
              <option value="all_teaching_staff">All Teaching Staff</option>
              <option value="all_nonteaching_staff">All Non-Teaching Staff</option>
              <option value="all_students">All Students</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="admin_send_message_title" class="form-label">Message Title</label>
            <input type="text" class="form-control" id="admin_send_message_title" name="admin_send_message_title" required>
          </div>
          <div class="mb-3">
            <label for="admin_send_message_body" class="form-label">Message Body</label>
            <textarea class="form-control" id="admin_send_message_body" name="admin_send_message_body" rows="3" required></textarea>
          </div>
          <!-- Submit and Cancel buttons -->
          <div class="row">
            <div class="col-lg-6 mb-3">
              <button type="submit" class="btn btn-primary w-100">
                Submit
              </button>
            </div>
            <div class="col-lg-6 mb-3">
              <button type="button" class="btn btn-secondary w-100 ae-reset">
                Cancel
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  





  <div class="container ae-group-card r1">
    <div class="row">
        <h6 class="text-center ae-title"> INDIVIDUAL TEACHER MESSAGES</h6>

        <div class="row  individual_teacher_messages mb-3 ">
          <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2">

            <div class="card ae-message-card">
            
              <div class="card-header d-flex justify-content-between align-items-center">
                
                <h5 class="mb-0"><span class="text-primary">     <i class="fa fa-comments" aria-hidden="true"></i></span> <span class="receiver_fullname">  Receiver full name </span>  </h5>
                <i class="fas fa-trash-alt small"></i>
              </div>
              <div class="card-body">
                <h5 class="card-subtitle mb-2 message_title">Message Title</h5>
                <p class="card-text message_body">Message body goes here...</p>
                <p  class="card-text sender_name">From: system Admin</p>
              </div>
             
            </div>
          </div>
          
        </div>
    </div>
  </div>



  <div class="container ae-group-card r2">
    <div class="row">

        <h6 class="text-center ae-title"> INDIVIDUAL STUDENT MESSAGES</h6>
        <div class="row  append_card individual_student_messages mb-3">
          <div  class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2">

            <div class="card ae-message-card">
            
              <div class="card-header d-flex justify-content-between align-items-center">
                
                <h5 class="mb-0"><span class="text-primary">     <i class="fa fa-comments" aria-hidden="true"></i></span>    Receiver Full Name</h5>
                <i class="fas fa-trash-alt small"></i>
              </div>
              <div class="card-body">
                <h5 class="card-subtitle mb-2 ">Message Title</h5>
                <p class="card-text">Message body goes here...</p>
              </div>
            </div>
          </div>
         
          
         
        </div>
     
    </div>
  </div>




  <div class="container ae-group-card r3">
    <div class="row">
        <h6 class="text-center ae-title"> ALL GROUP MESSAGES</h6>

        <div class="row  append_card all_group_messages mb-3">
          <div class="col-12 col-sm-6 col-md-4 col-lg-3 col-xl-2">

            <div class="card ae-message-card">
            
              <div class="card-header d-flex justify-content-between align-items-center">
                
                <h5 class="mb-0"><span class="text-primary">     <i class="fa fa-comments" aria-hidden="true"></i></span>    Receiver Full Name</h5>
                <i class="fas fa-trash-alt small"></i>
              </div>
              <div class="card-body">
                <h5 class="card-subtitle mb-2 ">Message Title</h5>
                <p class="card-text">Message body goes here...</p>
              </div>
            </div>
          </div>
          </div>
    
    </div>
  </div>





  

</div>
