
<div id="feeFilterCard" class="container justify-content-center align-items-center d-none">
<div class="filter-card justify-content-center align-items-center">
    <h6>Filter Student Payments and Print</h6>

    <!-- Date From -->
    <div class="mb-3">
        <label for="startDate" class="form-label">Date From:</label>
        <div class="input-group">
            <span class="input-group-text">
                <i class="fas fa-calendar-alt"></i>
            </span>
            <input name="startDate"   type="date" class="form-control" id="startDate">
        </div>
    </div>

    <!-- Date To -->
    <div class="mb-3">
        <label for="endDate" class="form-label">Date To:</label>
        <div class="input-group">
            <span class="input-group-text">
                <i class="fas fa-calendar-alt"></i>
            </span>
            <input name="endDate" type="date" class="form-control" id="endDate">
        </div>
    </div>

    <!-- Payment Type -->
    <div class="mb-3">
        <label for="paymentType" class="form-label">Payment Type</label>
        <div class="input-group">
            <span class="input-group-text">
                <i class="fas fa-money-check-alt"></i>
            </span>
            <select class="form-control" id="paymentType">
                <option value="">-- All Types --</option>
                <option value="school fees">School Fees</option>
                <option value="other Payment">Other Payment</option>
            </select>
        </div>
    </div>

    <!-- Student Class -->
    <div class="mb-3">
        <label for="studentClass" class="form-label">Student Class</label>
        <div class="input-group">
            <span class="input-group-text">
                <i class="fas fa-school"></i>
            </span>
            <select class="form-control" id="class_selection2">
                <option value="0">Select Class...</option>
            
            </select>
        </div>
    </div>

    <div class="mb-3">
    <label for="groupBySelect" class="form-label">Group By</label>
    <div class="input-group">
        <span class="input-group-text">
            <i class="fas fa-calendar-alt"></i>
        </span>
        <select class="form-control" id="groupBySelect" name="groupBySelect">
            <option value="monthly">Select...</option>
            <option value="daily">Daily</option>
            <option value="weekly">Weekly</option>
            <option value="monthly">Monthly</option>
            <option value="yearly">Yearly</option>
        </select>
    </div>
</div>



    <div class="mb-3">
     <div class="row">
        <div class="col-12 col-lg-6 mb-2">
        <button onclick="filterRecords()" type="button" class="btn btn-primary w-100">Print</button>
   
        </div>
        <div class="col-12 col-lg-6">

        <button id="filter-cancel" class="btn btn-secondary w-100">Cancel</button>
        </div>
     </div>
    </div>
</div>
</div>