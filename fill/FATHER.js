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
              showWrapper4(['wrapper12'], 'wrapper', 100);
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
  

  $(document).ready(function() {
    $('#father_occupation_select').change(function() {
      var selectedValue = $(this).val();
      if (selectedValue === 'other') {
        $('#father_occupation_other').addClass('d-block').removeClass('d-none').attr('required', true);
      } else {
        $('#father_occupation_other').addClass('d-none').removeClass('d-block').removeAttr('required');
      }
    });
  });
  
  function updateFatherOccupation() {
    $("#father_occupation_form").submit(function (e) {
      e.preventDefault();
      var occupationSelected = $("#father_occupation_select").val();
      if (aeEmpty(occupationSelected)) {
        showToast("aeToastE", "Select Occupation?", "Please select an occupation.", "20");
        return;
      }
  
      var formData = $(this).serialize();
  
      $.ajax({
        type: "post",
        url: "FATHER2_INSERT.php", // Replace with the actual path to your PHP file
        data: formData,
        dataType: "json",
        success: function (response) {
          if (response.status === 'success') {
            showToastP(
              "aeToastP", 
              "CONTINUE... 85% DONE", 
              "CONTINUE TO FILL STUDENT INFORMATION", 
              "30",
              function() {
                showWrapper4(['wrapper8'], 'wrapper', 100);
              }
            );
          } else {
            showToast("aeToastE", "Error", response.message, "20");
          }
        },
        error: function (xhr, status, error) {
          showToast("aeToastE", "Error", "An error occurred: " + error, "20");
        },
      });
    });
  }
  
  $(document).ready(function() {
    updateFatherOccupation();
  
    $('#father_back2').on('click', function() {
      showWrapper4(['wrapper7'], 'wrapper', 100);
    });
  });
  