$(document).ready(function() {
    $('#update_admission_number_form').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission
     

if(isFileExcel   ("admission_number_list_excel_file"))  {
}
else{
    return;

}

aeLoading();

        var formData = new FormData(this);

        // Check if the file input is not empty
        if ($('#admission_number_list_excel_file').val() !== '') {
            
            // AJAX call to your server endpoint to handle the file upload
            $.ajax({
                url: 'ADMISSION_NUMBER.INSERT.php', // Replace with your server endpoint
                type: 'POST',
                data: formData,
                processData: false, // Important for sending FormData
                contentType: false, // Important for sending FormData
                success: function(response) {
                    admission_list_populate()
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
        $('#update_admission_number_form')[0].reset();
    });







  






    


    function updateAdmissionNumbersTable(list) {
        var tableBody = $("#admission_numbers_table tbody");
        tableBody.empty();
    
        var totalUsed = 0;
        var totalUnused = 0;
        var totalLoaded = list.length; // Total loaded is the length of the list
    
        list.forEach(function (item) {
            var isUsedIcon = item.is_used == 1 ? '<i class="fas fa-times-circle text-danger"></i>' : '<i class="fas fa-check-circle"></i>';
    
            if (item.is_used == 1) {
                totalUsed++; // Increment total used if is_used is 1
            } else {
                totalUnused++; // Increment total unused if is_used is 0
            }
    
            var row = `
                <tr>
                    <td>${item.admission_number}</td>
                    <td>${isUsedIcon}</td>
                </tr>
            `;
            tableBody.append(row);
        });
    
        // Update the counts in the HTML
        $("#totalUsed span").text(totalUsed);
        $("#totalUnused span").text(totalUnused);
        $("#totalLoaded span").text(totalLoaded);
    }
    


    $('#delete_admission_number_button').on('click', function() {
        // Custom yes/no alert
        showToastY(
            "aeToastY",
            "Confirm Deletion",
            "Are you sure you want to delete all admission numbers? This action cannot be undone.",
            "20",
            function() { // Yes callback
                $.ajax({
                    type: "POST",
                    url: "ADMISSION_NUMBER_DEL.php", // The URL to your PHP script
                    dataType: "json",
                    success: function(response) {
                       window.location.reload();
                  
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









    function admission_list_populate(){
        var admission_number_list = [];
    
    // Load GES list data on page load
    $.ajax({
       type: "post",
       cache: false,
       url: "ADMISSION_NUMBER_F.php", // Replace with your PHP file path
       dataType: "json",
       success: function (data) {
        console.log(data)
           if (data.success) {
               admission_number_list = data.admission_number_list; // Assuming the data contains a 'admission_number_list' array
               updateAdmissionNumbersTable(admission_number_list);
           } else {
              // showToast("aeToastE", "Error", "Failed to fetch Admission list.", "20");
           }
       },
       error: function (xhr, status, error) {
           showToast("aeToastE", "Error", "An error occurred while fetching Admission list.", "20");
       }
    });
    }


    admission_list_populate()









});






