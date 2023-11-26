<div
  id="wrapper9"
  class="container justify-content-center align-items-center mt-2 d-none"
>
  <div class="row justify-content-center align-items-center">
    <div class="col-12 col-sm-10 col-md-8 col-lg-6">
      <form
        class="custom-form justify-content-center align-items-center"
        id="teacher_submit_assessment_form"
        enctype="multipart/form-data"
      >
        <div class="mb-3 justify-content-center align-items-center">
          <label for="subject">Select Subject:</label>
          <div class="input-group">
            <span class="input-group-text">
              <i class="fas fa-flask"></i>
            </span>
            <select
              required
              class="form-control"
              id="teaccher_select_subject"
              name="teaccher_select_subject"
            >
              <option value="" disabled selected>Select Subject</option>
            </select>
          </div>
        </div>

        <div class="mb-3 justify-content-center align-items-center">
          <label for="assessmentType">Assessment Type:</label>
          <div class="input-group">
            <span class="input-group-text">
              <i class="fas fa-book"></i>
            </span>
            <select
              required
              class="form-control"
              id="assessment_type"
              name="assessment_type"
            >
              <option value="" disabled selected>Select Assessment Type</option>
            </select>
          </div>
        </div>

        <div class="mb-3 justify-content-center align-items-center">
          <label for="mark_out_of"
            >Assessment results was marked out of what?
          </label>
          <div class="input-group">
            <span class="input-group-text">
              <i class="fas fa-book"></i>
            </span>
            <input
              required
              type="number"
              class="form-control"
              id="mark_out_of"
              name="mark_out_of"
              placeholder="Enter Marked Out of eg. 5, 10, 20, 40, 60, 100"
            />
          </div>
        </div>

        <!-- Upload Excel File -->
        <div class="mb-3 justify-content-center align-items-center">
          <label for="excelFile">Upload Excel File:</label>
          <div class="input-group">
            <span class="input-group-text">
              <i class="fas fa-file-excel"></i>
            </span>
            <input
              required
              type="file"
              class="form-control"
              id="tearcher_file_for_assessment"
              name="tearcher_file_for_assessment"
              accept=".xls,.xlsx"
            />
          </div>
        </div>

        <div class="row">
          <div class="col-12 col-lg-8">
            <button
              id="teacher_submit_assessment"
              type="submit"
              class="btn btn-primary w-100 mb-2"
            >
              Submit
            </button>
          </div>
          <div class="col-12 col-lg-4">
            <button type="button" class="btn btn-secondary w-100 ae-reset">
              Cancel
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="row justify-content-center align-items-center mt-2">
    <div class="col-12 col-sm-10 col-md-8 col-lg-6">
      <div
        id="teacher_search_cards"
        class="container-fluid search-container mt-2"
      >
        <div class="row justify-content-center align-items-center">
          <div class="col-auto">
            <div class="search-box">
              <input
                id="teacher_search_input"
                type="text"
                class="search-input"
                placeholder="Search any thing"
              />
              <i class="fas fa-search search-icon"></i>
            </div>
            <div class="col-auto">
              <div class="form-check form-switch mt-2 mb-4">
                <input
                  class="form-check-input"
                  type="checkbox"
                  role="switch"
                  id="teacher_switch_term_assessment_list"
                  name="teacher_switch_term_assessment_list"
                />
                <label
                  class="form-check-label"
                  for="teacher_switch_term_assessment_list"
                  >this term</label
                >

                <i
                id="print_all_teacher_assessment_cards"
                onclick="print_teacher_uploaded_AssessmentCard() "
                class="fa fa-print fa-2x ms-5"
                aria-hidden="true"
              ></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <form
        class="custom-form justify-content-center align-items-center mt-5"
        id="teacher_class_assessment_list_form"
      >
        <div class="card teacher_class_assessment_list_card">
          <div class="card-header">Term/Year Assessment Name</div>
          <div class="card-body">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th scope="col">Student Fullname</th>
                  <th scope="col">Mark</th>
                </tr>
              </thead>
              <tbody id="assessmentListTableBody">
                <!-- Add student full name and mark rows here -->
              </tbody>
            </table>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
