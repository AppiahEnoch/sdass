$(document).ready(function() {
    $("#teacher_cancel_attendance_submission").on('click', function() {
        $("#teacher_upload_student_attendance_form")[0].reset(); // Reset form
    });

});




$(document).ready(function() {
    $("#teacher_upload_student_attendance_form").on("submit", function(e) {
      e.preventDefault();


      let maxAttendanceValue = $("#teacher_upload_student_attendance_max_value").val();
        
      if (!maxAttendanceValue || maxAttendanceValue <= 1 || maxAttendanceValue >= 1000) {
          showToast("aeToastE", "Error", "Max Attendance Value must be greater than 1 and less than 1000.", "20");
          return false; // Stop the form submission
      }
  
      let formData = new FormData(this);
      
      $.ajax({
        type: "post",
        cache: false,
        url: "ATTENDANCE_INSERT.php",
        dataType: "json",
        data: formData,
        processData: false,
        contentType: false,
        success: function(data, status) {

            // #teacher_upload_student_attendance_form reset
            $("#teacher_upload_student_attendance_form")[0].reset(); // Reset form

            console.log(data);
            alert(data);
          if (data.success) {
            showToast("aeToastS", "Success", "Attendance data uploaded successfully.", "20");
          } else {
            showToast("aeToastE", "Error", data.message, "20");
          }
        },
        error: function(xhr, status, error) {
          console.error(error);
          showToast("aeToastE", "Error", "Something went wrong.", "20");
        },
      });
    });
  });
  


  let attendanceData = [];

  function fetchAttendanceData() {
    aeLoading()
    $.ajax({
      type: "post",
      cache: false,
      url: "ATTENDANCE_F.php",
      dataType: "json",
      success: function (data, status) {
        aeLoading()
        let tableContent = "";
        $.each(data, function (index, row) {
          tableContent += `<tr>
            <td id="admission_number_${index}" class="admission_number">${row.admission_number}</td>
            <td id="fullname_${index}">${row.fullname}</td>
            <td class="editable" id="mark_${index}" contenteditable="true">${row.mark}</td>
            <td class="editable" id="max_mark_${index}" contenteditable="true">${row.max_mark}</td>
          </tr>`;
          attendanceData.push({
            admission_number: row.admission_number,
            mark: row.mark,
            max_mark: row.max_mark
          });
        });
        $("#class_student_attendance_list tbody").html(tableContent);
      },
      error: function (xhr, status, error) {
        showToast("aeToastE", "Error", "Data fetch failed.", "20");
        aeLoading()
      },
    });
  }
  
  function updateAttendanceData() {
    let updatedData = [];
    for(let i = 0; i < attendanceData.length; i++) {
      updatedData.push({
        admission_number: $(`#admission_number_${i}`).text(),
        mark: $(`#mark_${i}`).text(),
        max_mark: $(`#max_mark_${i}`).text()
      });
    }
    
    $.ajax({
      type: "post",
      cache: false,
      url: "ATTENDANCE_UPDATE.php",
      dataType: "json",
      data: {updatedData},
      success: function (data, status) {
       // alert(data);
       fetchAttendanceData();
        console.log(data);
        showToast("aeToastS", "Success", "Data updated successfully.", "20");
      },
      error: function (xhr, status, error) {
        showToast("aeToastE", "Error", "Data update failed.", "20");
      },
    });
  }
  
  
  $(document).ready(function () {
    fetchAttendanceData();
  });
  

  $(document).ready(function () {
    $("#teacher_save_attendance_changes").click(function () {
      updateAttendanceData();
    });
  });
  