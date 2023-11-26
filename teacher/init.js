var global_user_type = null;
var global_academic_term = null;
var super_admin_logged_in = false;

var global_admin_login=false;
$(document).ready(function () {
  // return
  $.ajax({
    type: "GET",
    url: "profile_F.php",
    dataType: "json",
    success: function (response) {
      if (response.status === "success") {

        if (response.super_admin_login === "yes") {
          super_admin_logged_in = true;
        }
        else{
          super_admin_logged_in = false;
      

       
        }
     

       // alert(super_admin_logged_in);



        var current_term = response.current_term;
        var total_student = response.total_student;

        $("#p_email").text(response.data.email);
        $("#staffID").text(response.data.staffid);
        $("#student_bill_academicYear").text(response.current_term);

        $("#class_name").text(response.current_class_name);
        $("#term_name").text(response.current_term);
        $("#student_count").text(response.total_student);

        var current_class = response.current_class_name;
        global_academic_term = response.current_term;

        var user_type = response.data.user_type;
        global_user_type = user_type;
        global_admin_login=response.admin_login;
      //  alert("Admin:"+global_admin_login);

        //   current_class="Kindergateen 2"

        $("#class_list_current_class").text(current_class);

        //  user_type="teacher";

        //alert(response.current_term)
        $("#userFullName").text(
          response.data.firstname +
            " " +
            response.data.middlename +
            " " +
            response.data.lastname
        );
        verifyImagePath(response.data.profile_pic);
      } else {
        showToast("aeToastE", "Error", response.message, "20");
      }
    },
    error: function (xhr, status, error) {
      showToast("aeToastE", "Error", error, "20");
    },
  });


    // JavaScript: Check user type on button click


});

function verifyImagePath(imgPath) {
  updateImageView("userImage", imgPath);
  updateImageView("userProfilePic", imgPath);
}

//... (The rest of your JavaScript code)

$(document).ready(function () {
  // return

  // Trigger file input when image is clicked
  $("#userImage").click(function () {
    $("#profilePic").trigger("click");
  });

  // Listen for file input change
  $("#profilePic").change(function (e) {
    let file = e.target.files[0];

    if (isFileImage2("profilePic")) {
    } else {
      file = null;
      return;
    }

    if (file) {
      let formData = new FormData();
      formData.append("profilePic", file);

      $.ajax({
        type: "POST",
        url: "profile_UPDATE.php",
        data: formData,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function (response) {
          //alert(response);
          if (response.status === "success") {
            showToast("aeToastS", "Success", response.message, "20");
            $("#userImage").attr("src", response.newImagePath);
            $("#userProfilePic").attr("src", response.newImagePath);
          } else {
            showToast("aeToastE", "Error", response.message, "20");
          }
        },
        error: function (xhr, status, error) {
          showToast("aeToastE", "Error", error, "20");
        },
      });
    }
  });
});



$(document).ready(function() {
  $("#app_logo").click(function() {
    var isValid=true;

  //  alert("super:"+super_admin_logged_in);

    if (super_admin_logged_in === false) {
      isValid=false;


    }
    else{
      isValid=true;
    }

    if(isValid===false){

      if (aeEmpty(global_admin_login)){

        isValid=false;
      }
      else{
        isValid=true;
      }
  
    }

    


    if(isValid===false){
      showToast("aeToastE", "Error", "You are not authorized to perform this action.", "20");
      return;
    }



    var staff_id = $("#staff_id").val(); // Make sure to have an input with ID 'staff_id' to get the value from

    $.ajax({
      type: "POST",
      cache: false,
      url: "SUPER_ADMIN_LOGIN.php",
      data: { id: staff_id },
      dataType: "text",
      success: function(response) {
        console.log(response);
        showToastY(
          "aeToastY",
          "Visit Teacher Page",
          "Are you sure you want to leave this page?",
          "20",
          function() { // Yes option

            if(global_admin_login==="yes"){
              window.location.replace("../admin/page.php");
            }
            else{
              window.location.replace("../superadmin/page.php");

            }
         
          },
          function() { // No option
            // No option callback
          }
        );
      },
      error: function(xhr, status, error) {
        showToast("aeToastE", "Error", "There was an error processing your request.", "20");
      }
    });
  });
});
