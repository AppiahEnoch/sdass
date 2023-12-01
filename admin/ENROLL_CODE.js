
$(document).ready(function() {
    $("#update_completed_registration_list_form").submit(function (event) {
        event.preventDefault();

        if (!isFileExcel("update_completed_registration_list_file")) {
            showToast("aeToastE", "Invalid File", "Please select a valid Excel file.", "20");
            return;
        }

        var formData = new FormData(this);

        $.ajax({
            type: "post",
            url: "ENROLL_CODE_UPDDATE.php",
            data: formData,
            processData: false,
            contentType: false,
            success: function (response) {
                console.log("re:"+response);
                //reset form
                $("#update_completed_registration_list_form")[0].reset();
        
                
            },
            error: function () {
                showToast("aeToastE", "Upload Failed", "There was a problem uploading the file.", "20");
            }
        });
    });
});



$(document).ready(function() {
    $("#delete_registered_list_button").click(function() {
        showToastY(
            "aeToastY", 
            "Confirm Deletion", 
            "Are you sure you want to delete all records?", 
            "20", 
            function() { deleteAllRecords(); },
            function() { /* No action on cancel */ }
        );
    });

    function deleteAllRecords() {
        $.ajax({
            type: "post",
            url: "ENROLL_DEL.php", // Path to your PHP script
            dataType: "json",
            success: function (response) {
                if (response.status === "success") {
                    showToast("aeToastS", "Success", "All records have been deleted.", "20");
                } else {
                    showToast("aeToastE", "Error", response.message, "20");
                }
            },
            error: function () {
                showToast("aeToastE", "Error", "There was a problem processing your request.", "20");
            }
        });
    }
});




$(document).ready(function() {
    fetchTotalEnrolled();

    function fetchTotalEnrolled() {
        $.ajax({
            type: "GET",
            url: "ENROLL_FETCH.php", // Path to the PHP script
            dataType: "json",
            success: function(response) {
                console.log("Raw response:", response);  // Log raw response for debugging
            
                if (response.error) {
                   // console.error("Error: " + response.error);
               // alert("Error: " + response.error);
                } else {
             //  alert("Success: " + response);
                    $("#totalEnrolled_on_ges_list_online").text(response.enrollment_string);
                    // Similarly, update other elements as needed
                }
            },
            
            
            error: function(xhr, status, error) {
                console.error("An error occurred: " + error);
                // Handle AJAX error appropriately
            }
        });
    }
});




$(document).ready(function() {
    $("#ae_not_enrolled_download").click(function() {
       // alert("Download");
        $.ajax({
            type: "post",
            cache: false,
            url: "ENROLL_CODE_EXCEL.php",
            dataType: "text",
            success: function (data, status) {
                console.log(data);
                aeDownload("ENROLL.xlsx");
                // Process data
            },
            error: function (xhr, status, error) {
                console.error(error);
            },
        });
    });
});


$(document).ready(function() {
    $("#ae_enrolled_download").click(function() {
       // alert("Download");
        $.ajax({
            type: "post",
            cache: false,
            url: "ENROLL_CODE_EXCEL2.php",
            dataType: "text",
            success: function (data, status) {
                console.log(data);
                aeDownload("FULLY_ENROLLED.xlsx");
                // Process data
            },
            error: function (xhr, status, error) {
                console.error(error);
            },
        });
    });
});
