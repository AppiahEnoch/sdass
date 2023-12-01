$(document).ready(function() {
    $('#enroll_code_back').on('click', function() {
   
        window.location.href = "../index.php";
    });





    $("#school_placement_form").on("submit", function(event) {
        event.preventDefault();
        
        var enrollmentCode = $("#enrollment_code_input").val().toUpperCase();
        if (!enrollmentCode) {
            showToast("aeToastE", "Error", "Please enter your enrollment code.", "20");
            return;
        }

        // check if lenght is not 6
        if (enrollmentCode.length != 6) {
            showToast("aeToastE", "INVALID CODE", "Please enter a valid enrollment code.", "20");
            return;
        }
    
        $.ajax({
            type: "post",
            cache: false,
            url: "STUDENT_CODE_INSERT.php", // Adjust the URL as per your routing
            data: { enrollment_code_input: enrollmentCode },
            dataType: "json",
            success: function (response, status) {
                console.log(response);
                if (response.success) {
                    showToastP(
                        "aeToastP", 
                        " CONTINUE... 10% DONE", 
                        "CONTINUE TO FILL STUDENT INFORMATION", 
                        "30",
                        function() {
                          showWrapper4(['wrapper1'], 'wrapper', 100);
                        }
                      );
                } else {
                    showToast("aeToastE", "Error", response.message, "20");
                }
            },
            error: function (xhr, status, error) {
                showToast("aeToastE", "Error", "An error occurred. Please try again.", "20");
            },
        });
    });
    
});


$(document).ready(function() {
    $.ajax({
        type: "post",
        cache: false,
        url: "STUDENT_CODE_FETCH.php", // URL of the PHP script that retrieves the enrollment code
        dataType: "json",
        success: function (data, status) {
            if (data.code) {
                $("#enrollment_code_input").val(data.code);
            } else {
                // SET TO EMPTY
                $("#enrollment_code_input").val("");
               // showToast("aeToastE", "Error", "No enrollment code found.", "20");
            }
        },
        error: function (xhr, status, error) {
            showToast("aeToastE", "Error", "An error occurred while fetching the enrollment code.", "20");
        },
    });
});
