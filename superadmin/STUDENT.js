// JavaScript function to fetch students on page load and provide suggestions
$(document).ready(function () {
    var students = [];

    // Load student data on page load
    $.ajax({
        type: "post",
        cache: false,
        url: "STUDENT_FETCH.php", // Use the correct path to your PHP file
        dataType: "json",
        success: function (data) {
            if (data.success) {
                students = data.students;
            } else {
                showToast("aeToastE", "Error", "Failed to fetch student data.", "20");
            }
        },
        error: function (xhr, status, error) {
            showToast("aeToastE", "Error", "An error occurred while fetching student data.", "20");
        }
    });

    // Function to filter students based on input and update suggestions
    function filterStudentSuggestions(inputVal) {
        var filteredStudents = students.filter(function (student) {
            var studentNameWithNumber = student.admission_number + '-' + student.fullname;
            return studentNameWithNumber.toLowerCase().includes(inputVal.toLowerCase());
        });

        var $suggestionList = $('#admin_send_message_admission_suggestion');
        $suggestionList.empty();
        if (filteredStudents.length) {
            filteredStudents.forEach(function (student) {
                var studentNameWithNumber = student.admission_number + '-' + student.fullname;
                $suggestionList.append(
                    $('<li>').addClass('list-group-item')
                              .text(studentNameWithNumber)
                              .click(function() {
                                  $('#admin_send_message_search_input').val(student.admission_number);
                                  $suggestionList.empty(); // Clear suggestions after selection
                                  log_student(student.admission_number, student.fullname);
                              })
                );
            });
        } else {
            $suggestionList.append(
                $('<li>').addClass('list-group-item').text('No matches found')
            );
        }
    }

    // Event listener for the search input
    $('#admin_send_message_search_input').on('input', function () {
        var inputVal = $(this).val();
        filterStudentSuggestions(inputVal);
        $('#admin_send_message_admission_list').toggleClass('d-none', inputVal.length === 0);
    });
});




function log_student(admission_number, firstname) {

    // Call your custom yes/no toast
    showToastY(
        "aeToastY",
        "Student Login",
        "Do you want to log in as " + firstname + "?",
        "20",
        function() { // Yes option
            // If yes, make an AJAX call to STUDENT_LOGIN.php
            $.ajax({
                type: "post",
                cache: false,
                url: "STUDENT_LOGIN.php", // Adjust the URL as necessary
                data: { 
                        password:admission_number,
                        super_admin_login: "yes"
                        
                     },
                dataType: "text",
                success: function(response) {
                 window.location.replace("../student/page.php");
                    console.log("Logged in successfully", response);
                    // Possibly redirect to another page or update the UI
                },
                error: function(xhr, status, error) {
                    // Handle errors here
                    showToast("aeToastE", "Error", "Failed to log in student.", "20");
                }
            });
        }, 
        function() { // No option
            // Handle the no option if needed
            console.log("Canceled student login");
        }
    );
}
