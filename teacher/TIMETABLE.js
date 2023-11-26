$("#uploadDocumentsForm").on("submit", function(e) {
    e.preventDefault();
    var formData = new FormData(this);

    // Check if timetable is uploaded and if class selection is made
    var timetableUploaded = $('#timetableUpload').get(0).files.length > 0;
    var classSelected = $("#admin_upload_class_timetable_select_class").val();

    // If timetable is uploaded but no class is selected, show an error toast
    if (timetableUploaded && !classSelected) {
        showToast("aeToastE", "Select Class", "Please select a class for the timetable.", "20");
        return; // Stop the form submission
    }

    $.ajax({
        type: "POST",
        url: "TIMETABLE_INSERT.php",
        data: formData,
        contentType: false,
        processData: false,
        cache: false,
        success: function(response) {
            showToast("aeToastS", "Successful", "file uploaded successfully", "20");
        },
        error: function(xhr, status, error) {
            showToast("aeToastE", "Error", "An error occurred during the upload.", "20");
        }
    });
});




var timetable_url = "";
var academic_calendar_url = "";










function download_timetable() {
    var classSelected = $("#admin_upload_class_timetable_select_class").val();
    if(aeEmpty(classSelected)){
        showToast("aeToastE", "Error", "Please select a class.", "20");
        return;
    }



    $.ajax({
        type: "POST",
        url: "TIMETABLE_FETCH.php", // the PHP file that retrieves URLs
        data: {
            class_id: classSelected
        },
        dataType: "json",

        success: function(response) {

          //  alert(response);

          if(aeEmpty(response.timetable_url)){
            showToast("aeToastE", "Error", "No timetable uploaded for this class.", "20");
            return;
            }

            timetable_url = response.timetable_url;
    
            aeDownload(timetable_url);
       
         
        },
        error: function(xhr, status, error) {
            showToast("aeToastE", "Error", "Could not load timetable and academic calendar links.", "20");
        }
    });
    

}

function download_academic_calendar() {
    aeDownload(academic_calendar_url);
  
}



function fetch_calendar () {
    $.ajax({
        type: "POST",
        url: "TIMETABLE_FETCH2.php", // the PHP file that retrieves URLs
        dataType: "json",

        success: function(response) {
        //  alert(response);
           console.log(response);
          academic_calendar_url = response.academic_calendar_url;
        },
        error: function(xhr, status, error) {
            console.log(xhr);
            showToast("aeToastE", "Error", "Could not load timetable and academic calendar links.", "20");
        }
    });
}

 $(document).ready(function() {
    fetch_calendar();
});





$(document).ready(function() {
    $('#timetableSwitchCheckDefault, #calendarSwitchCheckDefault').on('change', function() {
      var resourceId = this.id === 'timetableSwitchCheckDefault' ? 'timetable' : 'academic_calendar';
      var lockStatus = this.checked ? 1 : 0; // checked means 'on' (1), not checked means 'off' (0)
      var lockTextId = resourceId === 'timetable' ? '#timetable_lock_text' : '#calendar_lock_text';
  
      $(lockTextId).text(this.checked ? "on" : "off");

    
  
      $.ajax({
        type: "post",
        cache: false,
        url: "TIMETABLE_LOCK.php",
        data: { resource_id: resourceId, lock_status: lockStatus },
        dataType: "json",
        success: function(data, status) {
          if(data.success) {
            showToast("aeToastS", "Update Status", "Lock status updated", "20");
          } else {
            showToast("aeToastE", "Update Error", "Failed to update lock status", "20");
          }
        },
        error: function(xhr, status, error) {
          showToast("aeToastE", "AJAX Error", "Error in AJAX call", "20");
        },
      });
    });


  });
  

  $(document).ready(function() {
    // Fetch the status for both resources
    $.ajax({
      type: "post",
      url: "TIMETABLE_LOCK_FETCH.php",
      dataType: "json",
      success: function(response) {
        if(response.timetable === 1) {
          $("#timetableSwitchCheckDefault").prop('checked', true);
          $("#timetable_lock_text").text('on');
        } else {
          $("#timetableSwitchCheckDefault").prop('checked', false);
          $("#timetable_lock_text").text('off');
        }
  
        if(response.academic_calendar === 1) {
          $("#calendarSwitchCheckDefault").prop('checked', true);
          $("#calendar_lock_text").text('on');
        } else {
          $("#calendarSwitchCheckDefault").prop('checked', false);
          $("#calendar_lock_text").text('off');
        }
      },
      error: function(xhr, status, error) {
        showToast("aeToastE", "Error", "Unable to fetch status.", "20");
      }
    });
  });
  