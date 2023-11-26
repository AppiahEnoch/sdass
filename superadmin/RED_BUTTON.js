$(document).ready(function() {
    
    // Function to enable/disable the delete button
    function updateDeleteButtonState() {
        var selection = $('#deleteSelection').val();
        var isConfirmed = $('#deleteConfirmation').is(':checked');
        $('#deleteButton').prop('disabled', selection === "Choose..." || !isConfirmed);
    }

    // Update the state of the delete button on selection or confirmation change
    $('#deleteSelection, #deleteConfirmation').change(updateDeleteButtonState);

    // Function to handle the form submission
    $('#red_button_form').submit(function(event) {
        event.preventDefault(); // Prevent the default form submission

        // Show custom yes/no toast
        showToastY(
            "aeToastY",
            "Confirm Deletion",
            "Are you sure you want to delete the selected item?",
            "20",
            function() { // Function to call if yes is selected
                // Perform AJAX request for deletion

                aeLoading();
                $.ajax({
                    type: "post",
                    url: "RED_BUTTON_DEL.php",
                    data: { selection: $('#deleteSelection').val() },
                    dataType: "text",
                    success: function(response) {
                        aeLoading();
                      //  alert(response);
                        // Handle success
                        console.log(response);
                        showToast("aeToastS", "Success", "Deletion successful.", "20");
                    },
                    error: function(xhr, status, error) {
                        // Handle error
                        showToast("aeToastE", "Error", "Deletion failed.", "20");
                    }
                });
            }, 
            function() {} // Function to call if no is selected
        );
    });
});

