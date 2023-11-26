// JavaScript part
$(document).ready(function () {
    $("#add_academic_term_form").submit(function (e) {
      e.preventDefault();
      var academic_term = $("#academic_term").val();
      var reopening_date = $("#reopening_date").val();
      var vacation_date = $("#vacation_date").val();

     // alert(academic_term + " " + reopening_date + " " + vacation_date);
  
      $.ajax({
        type: "post",
        cache: false,
        url: "TERM_insert.php",
        dataType: "json",
        data: {
          academic_term: academic_term,
          reopening_date: reopening_date,
          vacation_date: vacation_date
        },
        success: function (data, status) {
    

            // reset form
            $("#add_academic_term_form")[0].reset();
            loadTerms();
          if (data.status === "success") {
            showToast("aeToastS", "Success", "Data inserted successfully", "20");
          } else {
            showToast("aeToastE", "Invalid Date", "Failed to insert data.", "20");
          }
        },
        error: function (xhr, status, error) {
          showToast("aeToastE", "Error", error, "20");
        },
      });
    });
  });
  

  function loadTerms() {
    $.ajax({
      type: "post",
      cache: false,
      url: "TERM_f.php",
      dataType: "json",
      success: function (data, status) {
        let tableRows = '';
        data.forEach((term, index) => {
          tableRows += `<tr>
            <td>${index === 0 ? '<i class="fas fa-check"></i> ' : ''}${term.term_year}</td>
            <td><button type="button" class="btn btn-danger btn-sm" id="delete_term_${term.id}">Delete</button></td>
          </tr>`;
        });
        $("#add_academic_term_response table tbody").html(tableRows);
      },
      error: function (xhr, status, error) {
        showToast("aeToastE", "Load Error", "Failed to load terms", "20");
      },
    });
  }
  
  
  
  $(document).ready(function() {
    loadTerms();
  });
  


  function deleteTerm(id) {
    $.ajax({
      type: "post",
      cache: false,
      url: "TERM_Del.php",
      data: {id: id},
      dataType: "json",
      success: function (data, status) {
        if (data.status === 'success') {
          showToast("aeToastS", "Delete Success", "Term deleted successfully", "20");
          loadTerms(); // Reload terms after deletion
        } else {
          showToast("aeToastE", "Delete Failed", "Failed to delete term", "20");
        }
      },
      error: function (xhr, status, error) {
        showToast("aeToastE", "Delete Error", "Failed to delete term", "20");
      },
    });
  }
  
  // Delete button click event listener
  $(document).on("click", "button[id^='delete_term_']", function() {
    const id = $(this).attr("id").split("_").pop();
    showToastY(
      "aeToastY",
      "Confirm Delete",
      "Are you sure you want to delete this term?",
      "20",
      function () { deleteTerm(id); },
      function () {}
    );
  });
  

  function fetchAcademicTerms() {
    $.ajax({
      type: "GET",
      cache: false,
      url: "TERM_f.php",
      dataType: "json",
      success: function(data) {
        // Array of select IDs to be populated
        const selectIds = ["academic_terms_dropdown", "teacher_print_student_term_list", "admin_admission_list_filter_term"];
  
        selectIds.forEach(selectId => {
          const academicTermSelect = $("#" + selectId);
          academicTermSelect.find("option:not(:first)").remove();
          data.forEach(term => {
            academicTermSelect.append(`<option value="${term.id}">${term.term_year}</option>`);
          });
        });


      },
      error: function(xhr, status, error) {
        showToast("aeToastE", "Error", "Failed to fetch academic terms.", "20");
      }
    });
  }
  
  // document ready function

  //<button type="button" class="btn btn-secondary w-100" id="term_cancel_Button">Cancel</button>
  // create on click  event for cancel button
  $(document).ready(function() {

    $("#term_cancel_Button").on("click", function() {
    $("#add_academic_term_form")[0].reset();
    });
  });







  $("#promoteStudentsButton").on("click", function() {
    showToastY(
      "aeToastY", 
      "Promote Students", 
      "Are you sure you want to promote the students?", 
      "20", 
      functionForYesOption, 
      functionForNoOption
    );
  });
  
  function functionForYesOption() {
    $.ajax({
      type: "post",
      cache: false,
      url: "TERM_p.php",
      dataType: "text",
      success: function(data, status) {
       if(data=="0"){
        showToast("aeToastE", "Error! UPDATE TERM!", "TERM IS NOT UPDATED!. PLEASE SET NEW TERM AND TRY AGAIN.", "20");
        return;

       }
        showToast("aeToastS", "Success", "Students promoted successfully.", "20");
        
      },
      error: function(xhr, status, error) {
        showToast("aeToastE", "Error", "An error occurred while promoting the students.", "20");
        console.error(error);
      }
    });
  }
  
  function functionForNoOption() {
    // Handle the No option here, if needed
  }
  