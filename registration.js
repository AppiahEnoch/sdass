
var teacher_must_select_class = false;
var invalidMobile=false;
$(document).ready(function() {

    // Event listener to check if mobile is filled out when user focuses out of the mobile input
// Event listener to check if mobile is filled out when user focuses out of the mobile input
$("#mobile").blur(function() {
    let invalidMobile = false;

    if ($(this).val().trim() === "") {
        $("#mobileError").removeClass("d-none"); // Show mobile error
        $(this).focus();
        invalidMobile = true;
    } else {
        $("#mobileError").addClass("d-none"); // Hide mobile error
    }

    let mobile = $("#mobile").val().trim();

    if (!validateGhanaMobile(mobile)) {
        // clear the mobile input
        $("#mobile").val("");
        $("#mobile").focus();
        $("#mobileError").removeClass("d-none"); // Show mobile error
        invalidMobile = true;
        return;
    } else {
        $("#mobileError").addClass("d-none"); // Hide mobile error
    }

    if (!invalidMobile) {
        checkMobileExist(mobile);
    }
});

// Event listener to prevent focusing on other fields if mobile is not filled out
$("#form1 input, #form1 select").not("#mobile").focus(function() {
    if ($("#mobile").val().trim() === "") {
        $("#mobile").focus();
        $("#mobileError").removeClass("d-none"); // Show mobile error
    } else {
        $("#mobileError").addClass("d-none"); // Hide mobile error
    }
});





    $("#form1").on('submit', function(event) {
        event.preventDefault(); // Prevent form from submitting the default way

        // Collect form data
        let formData = {
            mobile: $("#mobile").val(),
            email: $("#email").val(),
            firstname: $("#firstname").val(),
            middlename: $("#middlename").val(),
            lastname: $("#lastname").val(),

            // convert all names to upper
            firstname: $("#firstname").val().toUpperCase(),
            // che  ck if middlename is empty
            middlename: $("#middlename").val() === "" ? "" : $("#middlename").val().toUpperCase(),

            lastname: $("#lastname").val().toUpperCase(),

            userClass: $("#userClass").val(),
            username: $("#username").val(),
            password: $("#password").val(),
            confirmPassword: $("#confirmPassword").val()
        };

        // Validation
        if (formData.password !== formData.confirmPassword) {
            showToast("aeToastE", "Error", "Passwords do not match!", "20");
            return;
        }

    
// password must be at least 8 characters 
        if (formData.password.length < 8) {
            showToast("aeToastE", "Error", "Password must be at least 8 characters!", "20");
            return;
        }


        if(teacher_must_select_class){

               // Check if user selected a valid option
    if ($("#userClass").val() === "0") {
        console.log(userClass);
        showToast("aeToastE", "Error", "Please select a valid class!", "20");
        return;
    }


        }

       
   
 

        aeLoading();

        $.ajax({
            type: "POST",
            url: "registration_INSERT.php",
            data: formData,
            dataType: "json",
            success: function(response) {
                aeLoading();
                if (response.status === "success") {
                    showToast("aeToastS", "Success", "Registration successful!", "20");
                    $("#form1")[0].reset();  // Reset the form
                } else {
                    // clear mobile
                
                    
                    showToast("aeToastE", "Error", response.message, "20");
                }
            },
            error: function(xhr, status, error) {
                showToast("aeToastE", "Error", error, "20");
                aeLoading();
            }
        });
    });
});





function checkMobileExist(mobile) {
    $.ajax({
        type: "post",
        data: {
            mobile: mobile,
        },
        cache: false,
        url: "registration_checkMobileExist.php",
        dataType: "json",
        success: function(data, status) {
            if (data.userType) {
                let userType = data.userType;
                showToast("aeToastS", "Success", userType, "20");

                if (userType !="Teaching Staff") {
                    teacher_must_select_class=false;
                
               // add d-none class to the userClass input
                    $("#userCalssWrapper").addClass("d-none");
                    // remove required attribute from the userClass input
                    $("#userClass").removeAttr("required");
                
                }
                else{
                    teacher_must_select_class=true;
                    // remove d-none class to the userClass input
                    $("#userCalssWrapper").removeClass("d-none");
                    // add required attribute to the userClass input
                    $("#userClass").attr("required", "required");}
            } else {
               
                $("#mobile").val("");
                $("#mobileError").removeClass("d-none"); 
            }
        },
        error: function(xhr, status, error) {
            showToast("aeToastE", "Error", error, "20");
        }
    });
}







function fetchClasses() {
    $.ajax({
        type: "GET",
        cache: false,
        url: "CLASS_F.php",
        dataType: "json",
        success: function(data) {
            // Array of select IDs to be populated
            const selectIds = ["userClass"];

            selectIds.forEach(selectId => {
                const classSelection = $("#" + selectId);
                data.forEach(classInfo => {
                    classSelection.append(`<option value="${classInfo.id}">${classInfo.class_name}</option>`);
                });
            });
        },
        error: function(xhr, status, error) {
            console.error(error);
        }
    });

}


    $(document).ready(function() {
        fetchClasses()
    
    });


    // hide wrapper1 add class d-none
    // show wrapper2 remove class d-none
    // remove required attribute from the userClass input

    function hide_registration_form(){
        $("#wrapper1").addClass("d-none");
    }
