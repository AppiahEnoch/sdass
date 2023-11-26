<div id="wrapper10" class="container justify-content-center align-items-center mt-2 d-none">




  <div class="container mt-2">
  <div class="row justify-content-center align-items-center">
    <div class="col-12 col-sm-10 col-md-8 col-lg-6">
      <form id="teacher_print_student_report_form" class="custom-form">
      <div class="row justify-content-center align-items-center">
  <div class="col-auto w-100">
    <div class="search-box">
      <input
      id="teacher_search_student_for_terminal_search"
        type="search"
        class="terminal-search search-input mb-2"
        placeholder="Search by Name or Admission Number"
      />
      <i id="teacher_search_student_for_terminal_search_icon" class="fas fa-search search-icon "></i>
      <div id="teacher_search_student_for_terminal_admission_list" class="card d-none">
        <ul id="teacher_search_student_for_terminal_admission_suggestion" class="list-group">
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

        <div class="card">
          <div class="card-header" id="teacher_print_student_card_header">
            Student Report
          </div>

          
          <div class="card-body" id="teacher_print_student_card_body">

            <!-- Date Range -->
            <div class="mb-3" id="teacher_print_student_date_range">
              <label for="teacher_print_student_start_date">Start Date:</label>
              <input type="date" id="teacher_print_student_start_date" name="teacher_print_student_start_date" class="form-control">
            </div>
            <div class="mb-3" id="teacher_print_student_date_range_end">
              <label for="teacher_print_student_end_date">End Date:</label>
              <input type="date" id="teacher_print_student_end_date" name="teacher_print_student_end_date" class="form-control">
            </div>

            <!-- Class List -->
            <div class="mb-3" id="teacher_print_student_class_div">
              <label for="teacher_print_student_class_list">Select Class:</label>
              <select id="teacher_print_student_class_list" name="teacher_print_student_class_list" class="form-control">
                <option value="" disabled selected>Select Class</option>
                <!-- Add classes here -->
              </select>
            </div>

            <!-- Term List -->
            <div class="mb-3" id="teacher_print_student_term_div">
              <label for="teacher_print_student_term_list">Select Term:</label>
              <select id="teacher_print_student_term_list" name="teacher_print_student_term_list" class="form-control">
                <option value="" disabled selected>Select Term</option>
                <!-- Add terms here -->
              </select>
            </div>

    
            <div class="row">
  <div class="col-12 col-sm-4">
    <button type="button" id="teacher_print_student_print_btn" class="btn btn-primary w-100">Print</button>
  </div>
  <div class="col-12 col-sm-4 mt-2 mt-sm-0">
    <button type="button" id="teacher_print_student_terminal" class="btn btn-secondary w-100">Only this term</button>
  </div>
  <div class="col-12 col-sm-4 mt-2 mt-sm-0">
    <button type="button" id="teacher_print_student_report_cancel" class="btn btn-secondary w-100">Cancel</button>
  </div>
</div>

        
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

  </div>





