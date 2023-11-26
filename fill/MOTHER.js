function submitMothersDetailForm() {
    $("#mothers_detail_form").submit(function (e) {
      e.preventDefault();
  var motherFirstName = $("#mother1").val().toUpperCase();
  var motherMiddleName = $("#mother2").val().toUpperCase();
  var motherLastName = $("#mother3").val().toUpperCase();
  var motherMobile = $("#mother4").val().toUpperCase();
      aeLoading();
  
      $.ajax({
        type: "post",
        cache: false,
        url: "MOTHER_INSERT.php",
        data: {
          motherFirstName: motherFirstName,
          motherMiddleName: motherMiddleName,
          motherLastName: motherLastName,
          motherMobile: motherMobile
        },
        dataType: "json",
        success: function (data, status) {
          aeLoading();
          if (data.success) {


            showToastP(
              "aeToastP", 
              " CONTINUE... 90% DONE", 
              "CONTINUE... TO ACCEPT PLEDGE", 
              "30",
              function() {
                showWrapper4(['wrapper9'], 'wrapper', 100);
              }
            );




          } else {
            showToast("aeToastE", "Error", "Failed to submit mother's details", "20");
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
    submitMothersDetailForm();


    
  $('#mother_back').on('click', function() {
    showWrapper4(['wrapper7'], 'wrapper', 100);
    //alert('back');
});
  });
  