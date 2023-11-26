function fetchSubjects() {
    $.ajax({
        type: "GET",
        cache: false,
        url: "SUBJECT_F.php",
        dataType: "json",
        success: function(data) {
            // Array of select IDs to be populated
            const selectIds = ["teaccher_select_subject"];

            selectIds.forEach(selectId => {
                const classSelection = $("#" + selectId);
                data.forEach(subject_list => {
                    classSelection.append(`<option value="${subject_list.id}">${subject_list.subject_name}</option>`);
                });
            });
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
}


$(document).ready(function() {

    fetchSubjects();
    // return
});



function fetch_assessment_type() {
    $.ajax({
        type: "GET",
        cache: false,
        url: "ASSESSMENT_TYPE_F.php",
        dataType: "json",
        success: function(data) {
            // Array of select IDs to be populated
            const selectIds = ["assessment_type"];

            selectIds.forEach(selectId => {
                const classSelection = $("#" + selectId);
                data.forEach(subject_list => {
                    classSelection.append(`<option value="${subject_list.id}">${subject_list.assessment_name}</option>`);
                });
            });
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });
}


$(document).ready(function() {
   // showToast("aeToastS", "Success", "The data has been uploaded successfully.", "20");

    fetch_assessment_type()
    // return
});




function uploadAssessmentData() {
    var formData = new FormData($("#teacher_submit_assessment_form")[0]);
    aeLoading()
    $.ajax({
      type: "post",
      cache: false,
      url: "AS1_INSERT.php",
      data: formData,
      dataType: "text",
      contentType: false,
      processData: false,
      success: function (data, status) {
        aeLoading()
        fetchAndDisplayAssessments()
        console.log(data);
   
          showToast("aeToastS", "Upload Successful", "The data has been uploaded successfully.", "20");
     
      },
      error: function (xhr, status, error) {
        aeLoading()
        console.error(error);
        showToast("aeToastE", "Error", "There was an error processing your request.", "20");
      },
    });
  }
  
  // Attach the function to the submit button
  $(document).ready(function () {
    $("#teacher_submit_assessment").on("click", function (e) {
      e.preventDefault();
      uploadAssessmentData();
    });
  });
  



  function fetchAndDisplayAssessments() {
    aeLoading()
 
    $.ajax({
      type: "post",
      cache: false,
      url: "AS1_F.php",
      dataType: "json",
      success: function (data, status) {
       
      
        let html = '';
        data.forEach(group => {
          const key = group.term_year + '_' + group.subject_name + '_' + group.class_name + '_' + group.assessment_name;
          html += '<div class="card teacher_class_assessment_list_card mb-3 ">';
          html += '<div class="card-header print_m3">' + group.term_year + ' '+ group.subject_name+' ' + group.assessment_name;
          html += '<i class="fa fa-trash float-right delete-assessment" data-key="'+ key +'"></i>';
          html += '</div>';
          html += '<div class="card-body">';
          html += '<table class="table table-bordered">';
          html += '<thead><tr><th scope="col">Student Fullname</th><th scope="col">Mark</th></tr></thead>';
          html += '<tbody>';
          group.students.forEach(student => {
            html += '<tr>';
            html += '<td>' + student.full_name + '</td>';
            html += '<td>' + student.mark + '</td>';
            html += '</tr>';
          });
          html += '</tbody></table></div></div>';
        });
        $('#teacher_class_assessment_list_form').html(html);
        aeLoading()
        
        // Attach delete event
        $('.delete-assessment').click(function() {
          const key = $(this).data('key');
          showToastY(
            "aeToastY", 
            "Confirm Deletion", 
            "Are you sure you want to delete this assessment?", 
            "20", 
            function() { deleteAssessment(key); }, 
            function() { }  // Empty function for the no option
          );
        });
      },
      error: function (xhr, status, error) {
        aeLoading()
        showToast("aeToastE","Error","There was an error fetching the assessments.","20");
      },
    });
  }
  
  function deleteAssessment(key) {
    aeLoading()
    const [term_year, subject_name, class_name, assessment_name] = key.split('_');
    $.ajax({
      type: "post",
      cache: false,
      url: "AS1_DEL.php",
      dataType: "json",
      data: {term_year, subject_name, class_name, assessment_name},
      success: function (data, status) {
        aeLoading()
        if (data.success) {
          showToast("aeToastS","Success","Successfully deleted the assessments.","20");
          fetchAndDisplayAssessments();  // Refresh the list
        } else {
          showToast("aeToastE","Error", data.message, "20");
        }
      },
      error: function (xhr, status, error) {
        aeLoading()
        showToast("aeToastE","Error","There was an error deleting the assessments.","20");
      },
    });
  }
  

// Call the function

$(document).ready(function() {
    fetchAndDisplayAssessments();
}
);


$(document).ready(function() {
  $("#teacher_search_input").on("keyup", function() {
      const value = $(this).val().toLowerCase();
      $(".teacher_class_assessment_list_card").filter(function() {
          $(this).toggle($(this).find(".card-header").text().toLowerCase().indexOf(value) > -1);
      });
  });
});



function print_teacher_uploaded_AssessmentCard() {
  let styles = `
      <style>
          body {
              font-family: Arial, sans-serif;
              .card-header {
                  background-color: #f2f2f2;
                  margin-top: 2cm;
              }
          }
          table {
              width: 100%;
              border-collapse: collapse;
          }
          th, td {
         
              border: 1px solid #ddd;
              padding: 8px;
              text-align: left;
          }
          th {
              background-color: #f2f2f2;
          }
          h1 {
              text-align: left;
          }


          }
      </style>
  `;

  let headingText = "SDA Senior High School Bekwai";

  let printContent = '';
  let cards = document.querySelectorAll('.teacher_class_assessment_list_card');

  cards.forEach(card => {
      // Check if the card is visible
      if (card.offsetParent !== null) {
          let classNameElement = card.querySelector('[id^="class_name_"]');
          let className = classNameElement ? classNameElement.innerText : 'Unknown Class';

          let headerText = `${className} bill for ${global_academic_term}`;
         
          printContent += card.innerHTML;
      }
  });

  let grandTotalCard = document.getElementById('class_bill_card_grand_total');
  if (grandTotalCard && grandTotalCard.offsetParent !== null) {
      printContent += grandTotalCard.outerHTML;
  }

  let printWindow = window.open('', '_blank');
  printWindow.document.write('<html><head><title>Print</title>');
  printWindow.document.write(styles);
  printWindow.document.write('</head><body>');

  printWindow.document.write(printContent);
  printWindow.document.write('</body></html>');
  printWindow.document.close();
  printWindow.print();
}








