var global_user_type = null;
var global_academic_term = null;
$(document).ready(function() {
   // return
    $.ajax({
        type: "GET",
        url: "profile_F.php",
        dataType: "json",
        success: function(response) {
            if(response.status === "success") {
              var current_term= response.current_term;
              var total_student= response.total_student;

                $("#p_email").text(response.data.email);
                $("#staffID").text(response.data.staffid);
                $("#student_bill_academicYear").text(response.current_term);
             
                $("#class_name").text(response.current_class_name);
                $("#term_name").text(response.current_term);
                $("#student_count").text(response.total_student);

               

                var current_class= response.current_class_name;
                global_academic_term = response.current_term;

                var user_type= response.data.user_type;
                global_user_type = user_type;


           
             //   current_class="Kindergateen 2"
          
                $("#class_list_current_class").text(current_class);

                
              //  user_type="teacher";
             
              





        

                //alert(response.current_term)
                $("#userFullName").text(response.data.firstname + ' ' + response.data.middlename + ' ' + response.data.lastname);
                verifyImagePath(response.data.profile_pic);
            } else {
                showToast("aeToastE", "Error", response.message, "20");
            }
        },
        error: function(xhr, status, error) {
            showToast("aeToastE", "Error", error, "20");
        }
    });
});


  

  

function verifyImagePath(imgPath) {


        updateImageView("userImage",imgPath);
        updateImageView("userProfilePic",imgPath);


}





//... (The rest of your JavaScript code)





























$(document).ready(function() {
   // return
    
    // Trigger file input when image is clicked
    $("#userImage").click(function() {
        $("#profilePic").trigger('click');
    });

    // Listen for file input change
    $("#profilePic").change(function(e) {
        let file = e.target.files[0];

        if(isFileImage2("profilePic")){
        }
        else{
          file = null;
          return;
        }


        if(file) {
            let formData = new FormData();
            formData.append("profilePic", file);

            $.ajax({
                type: "POST",
                url: "profile_UPDATE.php",
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(response) {
                    //alert(response);
                    if(response.status === "success") {
                        showToast("aeToastS", "Success", response.message, "20");
                        $("#userImage").attr("src", response.newImagePath);
                        $("#userProfilePic").attr("src", response.newImagePath);
                    } else {
                        showToast("aeToastE", "Error", response.message, "20");
                    }
                },
                error: function(xhr, status, error) {
                    showToast("aeToastE", "Error", error, "20");
                }
            });
        }
    });
});



