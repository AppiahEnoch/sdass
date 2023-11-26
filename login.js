$(document).ready(function() {

    // Login Form Submission
    $("#login_form1").on('submit', function(event) {
        event.preventDefault();

        // Get login data
        let loginData = {
            username: $("#login_username").val(),
            password: $("#login_password").val()
        };

        aeLoading();
        $.ajax({
            type: "POST",
            url: "login_VALIDATE.php",
            data: loginData,
            dataType: "text",
            success: function(response) {
            

              console.log(response);
              aeLoading();  // Assuming this function shows a loading indicator

             // alert(response);
             
              if (response.toLowerCase().includes("blocked")) {
                showToast("aeToastE", "BLOCKED", "YOUR ACCOUNT HAS BEEN BLOCKED. CONTACT ADMINISTRATOR", "20");
                return;
              
            }
              
          


                

                  if(response== "Teaching Staff"){
                  showToast("aeToastS", "TEACHER", "LOGIN SUCCESSFUL", "20");
                  window.location.href = "teacher/page.php";
                  }else if(response== "Non-teaching Staff"){
                    window.location.href = "non-teaching/page.php";
                    }else if(response== "Admin"){
                    window.location.href = "admin/page.php";
                    }
                    else if(response== "Super Admin"){
                        window.location.href = "superadmin/page.php";
                    }
                    else if(response== "student"){
                        window.location.href = "student/page.php";
                    }
                    else if(response== "ges_admission_list user"){
                        window.location.href = "fill/page.php";
                    }


                    else{

                        showToast("aeToastE", "INVALID LOGIN", 'LOGIN USERNAME OR PASSWORD IS NOT CORRECT TRY AGAIN!', "20");
                    }


                
                
                   
               
            },
            error: function(xhr, status, error) {
                showToast("aeToastE", "Error", error, "20");
                aeLoading();
            }
        });
    });
});




$("#reset_form1").on('submit', function(event) {
// get the email value
event.preventDefault();
let email = $("#reset_email").val();
forgotPassword(email);

})





function forgotPassword(email) {
  aeLoading();
    $.ajax({
      type: "post",
      data: {
        email: email,
      },
      cache: false,
      url: "token.php",
      dataType: "text",
      success: function (data, status) {
      //  alert(data);
      aeLoading();
        // reset the form
        $("#reset_form1")[0].reset();

        if (data == "1") {
          showToast("aeToastS", "SUCCESS", "Check your email for reset link", "20");
        } else  {
          showToast("aeToastE", "EMAIL DOES NOT EXIST", "EMAIL DOES NOT EXIST. YOU MUST REGISTER BEFORE YOU CAN RESET YOUR PASSWORD", "20");
        } 
    
      },
      error: function (xhr, status, error) {
        aeLoading();

      }
    });
  }
  

