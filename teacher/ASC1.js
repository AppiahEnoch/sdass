// document ready
$(document).ready(function() {
  //get_remarks_template();
});

// get remarks template
function get_remarks_template() {
  $.ajax({
    url: 'ASC1_TEMPLATE.php',
    type: 'POST',
    dataType: 'text',
    success: function(data) {
     // alert(data);
      console.log(data);
      aeDownload('../Excel/teacher_remark.xlsx')
      showToast("aeToastS", "Successful", "DOWNLOADED SUCCESSFULLY.", "20");
    
    },
    error: function() {
      showToast("aeToastE", "Error", "Failed to download template.", "20");
      
    }
  });
}


$(document).ready(function() {
  $("#teacher_upload_student_remark_upload_remarks").on("change", function() {
      uploadRemarks();
  });
});

function uploadRemarks() {
  var formData = new FormData();
  formData.append("teacher_upload_student_remark_upload_remarks", $("#teacher_upload_student_remark_upload_remarks")[0].files[0]);
  
  $.ajax({
      type: "post",
      cache: false,
      url: "ASC1_UPLOAD.php",
      dataType: "text",
      data: formData,
      processData: false,
      contentType: false,
      success: function (data, status) {
       // alert(data);
        console.log(data);
          showToast("aeToastS", "Upload Success", "Remarks have been updated successfully!", "20");
      },
      error: function (xhr, status, error) {
          console.error(error);
          showToast("aeToastE", "Error", "There was an error updating the remarks. Please try again.", "20");
      }
  });
}




let changedInterests = [];
let changedAttitudes = [];
let changedRemarks = [];



function loadData() {
  aeLoading()
  $.ajax({
      type: "post",
      cache: false,
      url: "ASC1_F.php",
      dataType: "json",
      success: function (data, status) {
        aeLoading()
          // Helper function to create rows
          function createRow(student, property, trackFunction) {
              let truncatedName = student.fullName.length > 15 ? student.fullName.substring(0, 15) + '...' : student.fullName;
              let truncatedAdmissionNumber = student.admission_number.length > 15 ? student.admission_number.substring(0, 15) + '...' : student.admission_number;
              let row = $('<tr><td title="' + student.admission_number + '">' + truncatedAdmissionNumber + '</td><td title="' + student.fullName + '">' + truncatedName + '</td><td contenteditable="false">' + student[property] + '</td></tr>');
      
            return row;
          }

          // Interests
          if (data.interests) {
              $('#student_interest_table_body').empty();
              data.interests.forEach(function(student) {
                  let row = createRow(student, 'interest', trackInterest);
                  $('#student_interest_table_body').append(row);
              });

              // add keyup event for interests column 
              $('#student_interest_table_body td:nth-child(3)').keyup(function() {
                  let admission_number = $(this).parent().children().eq(0).text();
                  let newValue = $(this).text();
                  let originalValue = $(this).parent().children().eq(2).text();
                  trackInterest(admission_number, newValue, originalValue);
              });
          }

          // Attitudes
          if (data.attitudes) {
              $('#student_attitude_table_body').empty();
              data.attitudes.forEach(function(student) {
                  let row = createRow(student, 'attitude', trackAttitude);
                  $('#student_attitude_table_body').append(row);
              });

              // add keyup event for attitudes column
              $('#student_attitude_table_body td:nth-child(3)').keyup(function() {
                  let admission_number = $(this).parent().children().eq(0).text();
                  let newValue = $(this).text();
                  let originalValue = $(this).parent().children().eq(2).text();
                  trackAttitude(admission_number, newValue, originalValue);
              });
          }

          // Remarks
          if (data.remarks) {
              $('#student_remarks_table_body').empty();
              data.remarks.forEach(function(student) {
                  let row = createRow(student, 'remark', trackRemarks);
                  $('#student_remarks_table_body').append(row);
              });

              // add keyup event for remarks column
              $('#student_remarks_table_body td:nth-child(3)').keyup(function() {
                  let admission_number = $(this).parent().children().eq(0).text();
                  let newValue = $(this).text();
                  let originalValue = $(this).parent().children().eq(2).text();
                  trackRemarks(admission_number, newValue, originalValue);
              });
          }
      },
      error: function (xhr, status, error) {
          showToast("aeToastE", "Error", "Failed to load student data.", "20");
          aeLoading()
      }
  });
}






$(document).ready(function() {
  loadData();
});











function trackInterest(admission_number, newValue, originalValue) {
  const tableName = 'interest';
  // add values to array
  changedInterests.push({
      admission_number: admission_number,
      newValue: newValue,
      originalValue: originalValue,
      tableName: tableName
  });


//alert(admission_number+" "+newValue+" "+tableName);
}

function trackAttitude(admission_number, newValue, originalValue) {
  const tableName = 'attitude';
    // add values to array
    changedAttitudes.push({
      admission_number: admission_number,
      newValue: newValue,
      originalValue: originalValue,
      tableName: tableName
   

})
//alert(admission_number+" "+newValue+" "+tableName);
}

function trackRemarks(admission_number, newValue, originalValue) {
  const tableName = 'remarks';
    // add values to array
    changedRemarks.push({
      admission_number: admission_number,
      newValue: newValue,
      originalValue: originalValue,
      tableName: tableName

})
//alert(admission_number+" "+newValue+" "+tableName);
}





// Example of usage:
// trackChanges('A001', 'newInterestValue', 'oldInterestValue', changedInterests, 'interests');


function updateTables() {
  aeLoading()
  $.ajax({
      type: "post",
      cache: false,
      url: "ASC1_MU.php",
      data: {
          changedInterests: JSON.stringify(changedInterests),
          changedAttitudes: JSON.stringify(changedAttitudes),
          changedRemarks: JSON.stringify(changedRemarks)
      },
      dataType: "json",  // change data type to json as the PHP script sends a JSON response
      success: function (data, status) {
        aeLoading()
        console.log(data);
        //alert(data);
          if (data.success) {
              showToast("aeToastS", "Success", "Updated successfully!", "20");
          } else {
              showToast("aeToastE", "Error", data.error || "Failed to update!", "20");
          }
      },
      error: function (xhr, status, error) {
          showToast("aeToastE", "Error", "Failed to update. Please try again later.", "20");
          aeLoading()
      }
  });
}





$("#teacher_update_comments_manually,#teacher_update_comments_manually2").click(function() {
  updateTables();
});


$(document).ready(function() {
  $("#lb_save_interest_changes,#lb_save_interest_changes2").on('click', function() {
    updateTables();

  });
});
