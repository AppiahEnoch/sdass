function fetchHouses() {
    var total_used = 0;
    $(document).ready(function () {

            $.ajax({
                    type: "GET", // or "POST" if that's what your PHP script expects
                    url: "HOUSE_FETCH.php",
                    dataType: "json",
                    success: function (data) {

                            $('.append-col').html('');
                            data.forEach(function(house) {
                                    let card = `<div class="col">
                                                                <div class="card">
                                                                    <div class="card-header house-name">
                                                                        ${house.house_name}
                                                                        <i class="bi bi-trash3-fill float-right delete-house ms-5 ae-delete-icon" data-house-id="${house.id}"></i>
                                                                        <i class="bi bi-floppy-fill float-right save-house ms-5 ae-save-icon" data-house-id="${house.id}">
                                                                        <span class="ae-save-text">save</span>
                                                                      </i>
                                                                      
                                                                    </div>
                                                                    <div class="card-body">
                                                                        <ul class="list-group list-group-flush">
                                                                            <li class="list-group-item d-none">Boys Capacity: ${house.id}</li>
                                                                            <li class="list-group-item">Boys Capacity: <input type="number" value="${house.capacity_boys}" class="editable-number"></li>
                                                                            <li class="list-group-item">Girls Capacity: <input type="number" value="${house.capacity_girls}" class="editable-number"></li>
                                                                            <li class="list-group-item">Total Capacity: ${house.capacity_boys + house.capacity_girls}</li>
                                                                            <li class="list-group-item">Boys assigned: ${house.boys_number}</li>
                                                                            <li class="list-group-item">Girls assigned: ${house.girls_number}</li>
                                                                            <li class="list-group-item">Total assigned: ${house.total_used}</li>
                                                                     
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </div>`;
                                    $('.append-col').append(card);
                            });

                            $('.append-col').on('click', '.delete-house', function() {
                                var houseId = $(this).data('house-id');
                                var $deleteButton = $(this); // Save reference to the delete button
                            
                                // Show confirmation toast
                                showToastY(
                                    "aeToastY", // Toast ID
                                    "Confirm Delete", // Title
                                    "Are you sure you want to delete this house?", // Message
                                    "20", // Position
                                    function() { // Yes Callback
                                        aeLoading();
                                        $.ajax({
                                            type: "POST",
                                            url: "HOUSE_DEL.php",
                                            data: {house_id: houseId},
                                            dataType: "text",
                                            success: function(response) {
                                                console.log(response);
                                                aeLoading();
                                                var data = JSON.parse(response);
                                                if (data == '1') {
                                                    // REMOVE COLUMN AND CARD USING THE SAVED BUTTON REFERENCE
                                                    $deleteButton.closest('.col').remove();
                                                    showToast("aeToastS", "Success", "House deleted successfully!", "20");
                                                } else {
                                                    showToast("aeToastE", "Error", "COULD NOT DELETE HOUSE", "20");
                                                    aeLoading();
                                                }
                                            },
                                            error: function(xhr, status, error) {
                                                showToast("aeToastE", "Error", 'An error occurred', "20");
                                                aeLoading();
                                            }
                                        });
                                    },
                                    function() { // No Callback
                                        // Optional: code to execute when 'No' is clicked
                                    }
                                );
                            });



                            
                // Save house event
                $('.append-col').on('click', '.save-house', function() {
                    var houseId = $(this).data('house-id');
                    var $saveButton = $(this); // Save reference to the save button
                    var boysCapacity = $saveButton.closest('.card').find('.editable-number').first().val();
                    var girlsCapacity = $saveButton.closest('.card').find('.editable-number').last().val();

                    // AJAX call to save the updated capacities
                    $.ajax({
                        type: "POST",
                        url: "HOUSE_SAVE.php", // URL to your save script
                        data: {
                            house_id: houseId,
                            capacity_boys: boysCapacity,
                            capacity_girls: girlsCapacity
                        },
                        dataType: "text",
                        success: function(response) {
                            // Handle the successful save
                            showToast("aeToastS", "Success", "House saved successfully!", "20");
                        },
                        error: function(xhr, status, error) {
                            // Handle errors
                            showToast("aeToastE", "Error", "Error saving house", "20");
                        }
                    });
                });
                            
                            
                    },
                    error: function (xhr, status, error) {
                            // Handle errors here
                    }
            });
    });
}


document.addEventListener('DOMContentLoaded', function() {
    fetchHouses();
});
