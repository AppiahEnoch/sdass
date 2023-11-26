$(document).ready(function() {
    $('#red_button_form2').submit(function(e) {
        e.preventDefault();

      //  alert(1)

        // Form field values
        var userId = $('#reset_user_userId').val().trim();
        var firstName = $('#firstName').val().trim().toUpperCase();
        var middleName = $('#middleName').val().trim().toUpperCase(); // Optional field
        var lastName = $('#lastName').val().trim().toUpperCase();
        var newPassword = $('#newPassword').val();
        var confirmNewPassword = $('#confirmNewPassword').val();
        var email = $('#email').val().trim();
        var phoneNumber = $('#phoneNumber').val().trim();
        var username= $('#username').val().trim();

        // Validate required fields
        if (!userId || !firstName || !lastName || !newPassword || !confirmNewPassword || !email || !phoneNumber || !username) {
            showToast("aeToastE", "Error", "All fields except Middle Name are required.", "20");
            return;
        }

        // Validate email
        var emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        if (!emailRegex.test(email)) {
            showToast("aeToastE", "Error", "Please enter a valid email address.", "20");
            return;
        }

        // Validate phone number (basic validation, adjust regex as needed for your format)
        var phoneRegex = /^[0-9]{10,15}$/;
        if (!phoneRegex.test(phoneNumber)) {
            showToast("aeToastE", "Error", "Please enter a valid phone number.", "20");
            return;
        }

        // Check if passwords match
        if (newPassword !== confirmNewPassword) {
            showToast("aeToastE", "Error", "Passwords do not match.", "20");
            return;
        }

        // Send AJAX request
        $.ajax({
            type: "post",
            url: "RESET_USER.php",
            data: {
                userId: userId,
                username: username,
                firstName: firstName,
                middleName: middleName,
                lastName: lastName,
                newPassword: newPassword,
                email: email,
                phoneNumber: phoneNumber
            },
            dataType: "text",
            success: function(response) {
                showToast("aeToastS", "Success", "User details reset successfully.", "20");
            },
            error: function(xhr, status, error) {
                showToast("aeToastE", "Error", "There was an error processing your request.", "20");
            }
        });
    });
});
