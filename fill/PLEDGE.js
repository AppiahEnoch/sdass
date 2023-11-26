function submitPledgeForm() {
    $("#pledge_form").submit(function (e) {
      e.preventDefault();

      aeLoading();
  
      $.ajax({
        type: "post",
        cache: false,
        url: "PLEDGE_INSERT.php",
        data: { acceptance: "accepted" },
        dataType: "text",
        success: function (data, status) {
          console.log(data);


          data=JSON.parse(data);
          console.log(data);
        aeLoading();
         
          if (data.success) {
  
            showToastP(
              "aeToastP", 
              " 100% DONE", 
              "Thank you for completing the form with diligence. Please be reminded that your admission is conditional until all required documents are downloaded,  and submitted to the school's administration. Failure to comply with these requirements may invalidate your admission. Your prompt action is necessary to finalize your admission process.", 
              "30",
              function() {
                window.location.href = "../student/page.php";
              }
            );
            
              
          
          
          } else {


           // console.log(data.message);
         

            // check if message contains no house then redirect to house page
            if (data.message.includes("No house available")) {
              showToast("aeToastE", "House Available!","NO HOUSE IS AVAILABLE CONTACT ADMINISTRATOR", "20");
              return;
            }

            // check if message contains no admission number
            if (data.message.includes("No admission number available")) {
              showToast("aeToastE", "No admission number available", "NO ADMISSION NUMBER AVAILABLE CONTACT ADMINISTRATOR", "20");
              return;
            }

            showToast("aeToastE", "Error3", data.message, "20");



          }
        },
        error: function (xhr, status, error) {
          aeLoading();
          showToast("aeToastE", "Error", error, "20");
      
        },
      });
    });
  
    $("#notchecked").click(function() {
      showToast("aeToastE", "Attention", "You must accept the pledge to proceed", "20");
    });
  }
  
  $(document).ready(function() {
    submitPledgeForm();
  });
  