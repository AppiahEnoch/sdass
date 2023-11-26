$(document).ready(function() {
    fetchCards();
    $("#regCodeForm").on('submit', function(e) {
        e.preventDefault();
        
        let userMobile = $("#userMobile").val();
        let userType = $("#userType").val();
        // trim values




    // CHECK IF USER TYPE IS SELECTED
    if(userType == 0){
        showToast("aeToastE", "Invalid Input", "Please select user type!", "20");

        // SHOW THE LIST OPTIONS AS DROP
        $("#userType").focus();  // click


        return;
    }


        if(!validateGhanaMobile(userMobile)){
            // clear the mobile input
           // $("#userMobile").val("");
            $("#userMobile").focus();

        
            showToast("aeToastE", "Invalid Input", "Invalid mobile number!", "20");
            return;
          }





aeLoading();

        userMobile = $.trim(userMobile);
        userType = $.trim(userType);

        $.ajax({
            type: "POST",
            url: "regCode_INSERT.php",  //Replace with your PHP file name
            data: {
                userMobile: userMobile,
                userType: userType
            },
            dataType: "text",
            success: function(response) {
                aeLoading();
                fetchCards();
              //  alert(response);
                if(response == 1) {
                    showToast("aeToastS", "Success", "Data inserted successfully!", "20");
                } else {
                    showToast("aeToastE", "Error", "Failed to insert data!", "20");
                }
            },
            error: function(xhr, status, error) {
                showToast("aeToastE", "Error", error, "20");
                aeLoading();
            }
        });
    });
});









    function fetchCards() {
        $.ajax({
            type: "GET",
            url: "regCode_F.php",
            dataType: "json",
            success: function(data) {
                let cardsContent = '';
                data.forEach(item => {
                    cardsContent += `
                    <div class="col-12 col-md-6 col-lg-4">
                        <!-- Card 2 -->
                        <div class="card card2 mb-4 position-relative" id="card_${item.id}">
                            <!-- Delete Icon at the top right corner of Card 2 -->
                            <a href="#" class="position-absolute top-0 end-0 me-2 mt-2 delete-card" data-id="${item.id}">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                            <div class="card-body">
                                <!-- User Mobile -->
                                <div class="mb-3">
                                    <h5 class="usermobile">${item.userMobile}</h5>
                                </div>
                                <!-- User Type -->
                                <div class="mb-3">
                                    <h6 class="usertype">${item.userType}</h6>
                                </div>
                            </div>
                        </div>
                    </div>`;
                });
                $("#insertedCard .row").html(cardsContent);
            },
            error: function(xhr, status, error) {
                showToast("aeToastE", "Error", error, "20");
            }
        });
    }



















    // Event listener for delete icon click
    $(document).on('click', '.delete-card', function(event) {
        event.preventDefault();
        let cardId = $(this).data('id');
        
        // Show the yes/no toast alert
        showToastY(
            "aeToastY", 
            "Confirm Deletion", 
            "Are you sure you want to delete this record?", 
            "20", 
            function() {  // Function to execute on "yes"
                deleteCard(cardId);
            }, 
            function() {  // Function to execute on "no"
                // Do nothing on "no"
            }
        );
    });


function deleteCard(cardId) {
    $.ajax({
        type: "POST",
        url: "regCode_D.php",
        data: { id: cardId },
        dataType: "json",
        success: function(response) {
            if(response.status === "success") {
                showToast("aeToastS", "Success", "Record deleted successfully!", "20");
                $(`#card_${cardId}`).remove();
            } else {
                showToast("aeToastE", "Error", response.message, "20");
            }
        },
        error: function(xhr, status, error) {
            showToast("aeToastE", "Error", error, "20");
        }
    });
}

