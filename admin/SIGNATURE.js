$('#headteacher_upload_signature').change(function() {
    var input = this;
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      if(isFileImage("headteacher_upload_signature")){

        changeImageSRC("headteacher_upload_signature", "headteacher_signature_preview");




      }
  

    };




     
  });



  $("#cancel_image").click(function(){
    $("#headteacher_upload_signature").val("");
    $("#headteacher_signature_preview").attr("src", "../devimage/default_signature.png");
  
  } );





  $(document).ready(function () {
 


    // Function to handle the form submission
    function submitSignatureForm() {
        var formData = new FormData($('#headteacher_upload_signature_form')[0]); // Create FormData from form

        $.ajax({
            url: 'SIGNATURE_INSERT.php', // Replace with the path to your PHP file
            type: 'POST',
            data: formData,
            processData: false, // Tell jQuery not to process the data
            contentType: false, // Tell jQuery not to set contentType
            success: function(response) {
                console.log(response);
              //  alert(response);
                var data = JSON.parse(response);
                if (data.success) {
                    showToast("aeToastS", "Success", data.message, "20");
                } else {
                    showToast("aeToastE", "Error", data.message, "20");
                }
            },
            error: function(xhr, status, error) {
                console.log(xhr);
                showToast("aeToastE", "Error", "An error occurred while uploading the signature.", "20");
            }
        });
    }

  
    $('#headteacher_upload_signature_form').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission
        submitSignatureForm();
    });


});



// JAVASCRIPT FUNCTION TO USE THE DATA TO CREATE OR FILL COMPONENTS WITH VALUES.
$(document).ready(function(){
    $.ajax({
      type: "post",
      cache: false,
      url: "SIGNATURE_FETCH.php", // The PHP file that returns signature URL
      dataType: "json",
      success: function (data, status) {
       // alert(data);
        console.log(data);
        if(data.signature_url) {
          $("#headteacher_signature_preview").attr("src", data.signature_url);
        }
      },
      error: function (xhr, status, error) {
        showToast("aeToastE", "Load Error", "Failed to load signature.", "20");
      },
    });
  });
  