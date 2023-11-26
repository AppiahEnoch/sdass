$(document).ready(function () {
    $("#add_shs_house_form").submit(function (e) {
        e.preventDefault();

        // Collect form data
        var houseName = $("#house_name_input").val().trim().toUpperCase();
        var totalGirlsCapacity = $("#total_girls_capacity_input").val();
        var totalBoysCapacity = $("#total_boys_capacity_input").val();

        // Validate data
        if (!houseName) {
            showToast("aeToastE", "Validation Error", "House Name is required", "20");
            return;
        }
        if (totalGirlsCapacity < 0 || isNaN(totalGirlsCapacity)) {
            showToast("aeToastE", "Validation Error", "Invalid Total Girls Capacity", "20");
            return;
        }
        if (totalBoysCapacity < 0 || isNaN(totalBoysCapacity)) {
            showToast("aeToastE", "Validation Error", "Invalid Total Boys Capacity", "20");
            return;
        }


        // if both are 0 return
        if (totalGirlsCapacity == 0 && totalBoysCapacity == 0) {
            showToast("aeToastE", "Validation Error", "Total Capacity cannot be 0", "20");
            return;
        }

        // AJAX call to PHP script for inserting data
        $.ajax({
            url: "HOUSE_INSERT.php", // Replace with the path to your PHP script
            type: "POST",
            data: {
                house_name: houseName,
                capacity_girls: totalGirlsCapacity,
                capacity_boys: totalBoysCapacity
            },
            success: function (response) {
                // Handle response here
                
                fetchHouses();
                showToast("aeToastS", "Success", "Data submitted successfully", "20");

                
            },
            error: function (xhr, status, error) {
                // Handle error here
                showToast("aeToastE", "Error", "Failed to submit data", "20");
            }
        });
    });
});
