$(document).ready(function() {
    $('#update_ges_list_form').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission
     

if(isFileExcel   ("student_list_excel_file"))  {
}
else{
    return;

}

aeLoading();

        var formData = new FormData(this);

        // Check if the file input is not empty
        if ($('#student_list_excel_file').val() !== '') {
            
            // AJAX call to your server endpoint to handle the file upload
            $.ajax({
                url: 'GES_ADMISSION_LIST_INSERT.php', // Replace with your server endpoint
                type: 'POST',
                data: formData,
                processData: false, // Important for sending FormData
                contentType: false, // Important for sending FormData
                success: function(response) {
                    window.location.reload();

                

                    // Handle the response from the server
                    console.log(response);
                    aeLoading();

                    showToast("aeToastS", "Success", "File uploaded successfully", "20");
                },
                error: function(xhr, status, error) {
                    // Handle any errors
                    console.error(error);
                    showToast("aeToastE", "Error", "Failed to upload file", "20");
                }
            });
        } else {
            // Alert if the file input is empty
            showToast("aeToastE", "Error", "Please select a file to upload", "20");
        }
    });

    // Reset functionality
    $('.ae-reset').on('click', function() {
        $('#update_ges_list_form')[0].reset();
    });
});




// FETCH GES LIST
$(document).ready(function () {
    var gesList = [];

    // Load GES list data on page load
    $.ajax({
        type: "post",
        cache: false,
        url: "GES_ADMISSION_LIST_FETCH.php", // Use the correct path to your PHP file
        dataType: "json",
        success: function (data) {
            if (data.success) {

           
                gesList = data.gesList; // Assuming the data contains a 'gesList' array

                     //total_ges_records
                     $("#total_ges_records").text(gesList.length);
            } else {
                showToast("aeToastE", "Error", "Failed to fetch GES list.", "20");
            }
        },
        error: function (xhr, status, error) {
            showToast("aeToastE", "Error", "An error occurred while fetching GES list.", "20");
        }
    });

    // Function to filter GES list based on input
    function filterGesList(inputVal) {
        var filteredList = gesList.filter(function (item) {
            return item.name.toLowerCase().includes(inputVal.toLowerCase()) || 
                   item.index_number.toLowerCase().includes(inputVal.toLowerCase());
        });

        updateGesListTable(filteredList);
    }

    // Update GES list table
    function updateGesListTable(list) {
        var tableBody = $("#ges_list_table tbody");
        tableBody.empty();

        if (list.length) {
            list.forEach(function (item) {
                var nameCell = `<td>${item.name}</td>`;
                if (item.has_enrolled =='1') {
                    nameCell = `<td><i class="fas fa-check-circle"></i> ${item.name}</td>`;
                }

                tableBody.append(`
                    <tr>
                        <td>${item.index_number}</td>
                        ${nameCell}
                        <td>${item.status}</td>
                        <td class='d-none'>${item.has_enrolled}</td>
                    </tr>
                `);
            });
        } else {
            tableBody.append('<tr><td colspan="3">No matches found</td></tr>');
        }
    }

    // Event listener for the search button
    $('#search_button').on('click', function () {
        var inputVal = $('#search_input').val();
        filterGesList(inputVal);
    });




    $('#delete_ges_list_button').on('click', function() {
        // Custom yes/no alert
        showToastY(
            "aeToastY",
            "Confirm Deletion",
            "Are you sure you want to delete all admission numbers? This action cannot be undone.",
            "20",
            function() { // Yes callback
                $.ajax({
                    type: "POST",
                    url: "GES_ADMISSION_LIST_DEL.php", // The URL to your PHP script
                    dataType: "json",
                    success: function(response) {
                     
                        // clear table and reset counts
                        gesList = [];
                        updateGesListTable(gesList);
                        $("#totalLoaded span").text(0);
                        $("#totalEnrolled span").text(0);
                        $("#totalNotEnrolled span").text(0);
                        $("#totalMatches span").text(0);


                     
                  
                        if(response.success) {
                            showToast("aeToastS", "Success", response.message, "20");
                    
                        } else {
                            //showToast("aeToastE", "Error", response.message, "20");
                        }
                    },
                    error: function(xhr, status, error) {
                        showToast("aeToastE", "Error", "An error occurred while deleting records.", "20");
                    }
                });
            },
            function() { // No callback
                // Handle the no option if needed
            }
        );
    });


    
});



