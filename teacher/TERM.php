<div id="wrapper6" class="container justify-content-center align-items-center mt-2 d-none">
  <div class="row justify-content-center align-items-center">
      <div class="col-12 col-sm-10 col-md-8 col-lg-6">
          <form class="custom-form justify-content-center align-items-center" id="add_academic_term_form">
              <h5 class="form_heading">UPDATE ACADEMIC TERM</h5>

              <div class="mb-3 justify-content-center align-items-center">
                  <div class="input-group">
                      <span class="input-group-text">
                          <i class="fas fa-calendar-alt"></i>
                      </span>
                      <select required class="form-control" id="academic_term" name="academic_term">
                          <option value="0">Select Term</option>
                          <option value="1">First Term</option>
                          <option value="2">Second Term</option>
                          <option value="3">Third Term</option>
                      </select>
                  </div>
              </div>

              <div class="mb-3 justify-content-center align-items-center">
                  <label for="reopening_date">Reopening Date:</label>
                  <div class="input-group">
                      <span class="input-group-text">
                          <i class="fas fa-calendar-alt"></i>
                      </span>
                      <input required type="date" class="form-control" id="reopening_date" name="reopening_date">
                  </div>
              </div>

              <div class="mb-3 justify-content-center align-items-center">
                  <label for="vacation_date">Vacation Date:</label>
                  <div class="input-group">
                      <span class="input-group-text">
                          <i class="fas fa-calendar-alt"></i>
                      </span>
                      <input required type="date" class="form-control" id="vacation_date" name="vacation_date">
                  </div>
              </div>

              <div class="row">
                  <div class="col-12 col-lg-4 mb-2">
                      <button type="submit" class="btn btn-primary w-100" id="submitButton">Submit</button>
                  </div>
                  <div class="col-12 col-lg-4 mb-2">
                      <button type="button" class="btn btn-success w-100" id="promoteStudentsButton">Promote Students</button>
                  </div>
                  <div class="col-12 col-lg-4">
                      <button type="button" class="btn btn-secondary w-100" id="term_cancel_Button">Cancel</button>
                  </div>
              </div> <!-- Closing the row div -->

          </form>

          <div id="add_academic_term_response" class="card table_wrapper">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Term</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Term 1</td>
                            <td><button type="button" class="btn btn-danger" id="delete_term_1">Delete</button></td>
                        </tr>
                        <!-- Additional rows can go here -->
                    </tbody>
                </table>
            </div>
        </div>

      </div>


  </div> <!-- Closing the main row div -->
</div> <!-- Closing the main container div -->
