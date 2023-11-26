<div id="userDetailsModal" class="modal fade" tabindex="-1" aria-labelledby="userDetailsLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header d-none">
                <h5 class="modal-title" id="userDetailsLabel">User Details</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="row justify-content-center align-items-center">
                        <img id="userImage" src="default.jpg" alt="User Image" class="img-fluid">
                  

                         <input class="d-none"  type="file" id="profilePic"  accept="image/*">

                        </div>
                      
                    </div>
                    <div class="col-12">
                        <h6 id="userName">Username: [USERNAME]</h6>
                        <p id="staffId">Staff ID: [STAFFID]</p>
                        <p id="userEmail">Email: [EMAIL]</p>
                  
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button style="width:100%" id="btnClose" type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>







<div style="max-width:20rem;" id="datePickerModal" class="modal fade" id="datePickerModal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">LECTURES BEGIN FROM ? TO ?</h5>
          
            </div>
            <div class="modal-body">
                <form>
                    <div class="mb-3">
                        <label for="startDate" class="form-label">Start Date:</label>
                        <input type="date" class="form-control" id="startDate">
                    </div>
                    <div class="mb-3">
                        <label for="endDate" class="form-label">End Date:</label>
                        <input type="date" class="form-control" id="endDate">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                
                <button style="width:100%" id="btnDatePick" type="button" class="btn btn-primary">OK</button>
            </div>
        </div>
    </div>
</div>
