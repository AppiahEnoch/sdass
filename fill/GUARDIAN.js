$(document).ready(function() {
    $('#guardian_info_form1').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission


        var title= $('#title_guardian_title_select').val()

        if (title == "none") {

            showToast("aeToastE", "Error", "Please select a title.", "20");

            return false;
        }




        // Collect form data
        var formData = {
          title: $('#title_guardian_title_select').val(),
          first_name: $('#fname_guardian_first_name_input').val().toUpperCase(),
          middle_name: $('#mname_guardian_middle_name_input').val().toUpperCase(),
          last_name: $('#lname_guardian_last_name_input').val().toUpperCase()
        };
        aeLoading()

        // AJAX request to your server endpoint
        $.ajax({
            type: "POST",
            url: "GUARDIAN1_INSERT.php", // Replace with the URL to your server-side script
            data: formData,
            dataType: "json",
            success: function(response) {
                console.log(response);
                aeLoading()

                if (response.success ===true) {




                  
          showToastP(
            "aeToastP", 
            "CONTINUE... 20% DONE", 
            "CONTINUE TO FILL GUARDIAN INFORMATION", 
            "30",
            function() {
              showWrapper4(['wrapper2'], 'wrapper', 100);
            }
          );
                
                



                } else {    
                    // Optionally trigger an error toast
                    showToast("aeToastE", "Error", "Failed to submit form.", "20");
                }


            },
            error: function(xhr, status, error) {
                // Handle any errors
                console.error(error);
                showToast("aeToastE", "Error", "Failed to submit form.", "20");
            }
        });
    });

    // Reset button functionality, if needed
    $('#guardian1_back').on('click', function() {

        window.location.href = "../index.php";

     
       
    
    });
    
    $('#guardian2_back').on('click', function() {

      
        showWrapper4(['wrapper1'], 'wrapper', 100);
     
       
    
    });
});



// GUARDIAN2 INSERT

function submitGuardianInfo2() {
    $("#guardian_info_form2").submit(function (e) {
      e.preventDefault();
  var location = $("#location").val().toUpperCase();
  var email = $("#email").val();
  var mobile = $("#mobile").val();
  var postaladdress = $("#postaladdress").val().toUpperCase();
  var digitaladdress = $("#digitaladdress").val().toUpperCase();

      aeLoading();
  
      $.ajax({
        type: "post",
        cache: false,
        url: "GUARDIAN2_INSERT.php",
        data: {
          location: location,
          email: email,
          mobile: mobile,
          postaladdress: postaladdress,
          digitaladdress: digitaladdress
        },
        dataType: "json",
        success: function (data, status) {
          aeLoading();
          if (data.success) {


            showToastP(
              "aeToastP", 
              " CONTINUE... 30% DONE", 
              "CONTINUE TO FILL STUDENT INFORMATION", 
              "30",
              function() {
                showWrapper4(['wrapper3'], 'wrapper', 100);
              }
            );



          } else {
            showToast("aeToastE", "Error", "Failed to save guardian details", "20");
            aeLoading();
          }
        },
        error: function (xhr, status, error) {
          showToast("aeToastE", "Error", error, "20");
          aeLoading();
        },
      });
    });
  }
  
  $(document).ready(function() {
    submitGuardianInfo2();
  });
  

