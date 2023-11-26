function submitFathersDetailForm() {
    $("#fathers_detail_form").submit(function (e) {
      e.preventDefault();
  
      var fatherFirstName = $("#father1").val().toUpperCase();
      var fatherMiddleName = $("#father2").val().toUpperCase();
      var fatherLastName = $("#father3").val().toUpperCase();
      var fatherMobile = $("#father4").val().toUpperCase();

      aeLoading();  
      $.ajax({
        type: "post",
        cache: false,
        url: "FATHER_INSERT.php",
        data: {
          fatherFirstName: fatherFirstName,
          fatherMiddleName: fatherMiddleName,
          fatherLastName: fatherLastName,
          fatherMobile: fatherMobile
        },
        dataType: "json",
        success: function (data, status) {
          aeLoading();
          if (data.success) {

            
          showToastP(
            "aeToastP", 
            "CONTINUE... 80% DONE", 
            "CONTINUE TO FILL MOTHER's INFORMATION", 
            "30",
            function() {
              showWrapper4(['wrapper8'], 'wrapper', 100);
            }
          );





          } else {
            showToast("aeToastE", "Error", "Failed to submit father's details", "20");
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
    submitFathersDetailForm();



    $('#father_back').on('click', function() {
      showWrapper4(['wrapper6'], 'wrapper', 100);
  });
  
  });
  