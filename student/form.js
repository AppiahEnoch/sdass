var global_super_admin=false;
var global_admin=false;

var global_form_path=null;
var global_letter_path=null;
var global_prospectus_path=null;

var isvalid=false;

$(document).ready(function() {
  
  $.ajax({
    type: "post",
    cache: false,
    url: "form_f.php",
    dataType: "json",
    success: function(data, status) {
      //alert(data);
    
      //alert(data.student.parent_first_name)
      if (data.student && data.student.admission_number) {
        $('#admissionNumber').text(data.student.sdass_admission_number);
        $('#house').text(data.student.house);
        $('#bece_index').text(data.student.admission_number);
        $('#programme').text(data.student.programme);
        updateImageView("student_passport_url", data.student.student_passport_image_input);

        $('#fullname').text(`${data.student.first_name} ${data.student.middle_name} ${data.student.last_name}`);
        $('#student_full_name').text(`${data.student.first_name} ${data.student.middle_name} ${data.student.last_name}`);
        data.current_class="Not Assigned";
        $('#studentClass').text(data.current_class);
        $('#guardianFullName').text(`${data.student.parent_first_name} ${data.student.parent_middle_name} ${data.student.parent_last_name}`);
        $('#guardianMobile').text(data.student.parent_mobile);
        $('#guardianEmail').text(data.student.parent_email);
        $('#fatherFullName').text(`${data.student.father_first_name} ${data.student.father_middle_name} ${data.student.father_last_name}`);
        $('#fatherMobile').text(data.student.father_mobile);
        $('#motherFullName').text(`${data.student.mother_first_name} ${data.student.mother_middle_name} ${data.student.mother_last_name}`);
        $('#motherMobile').text(data.student.mother_mobile);

       // alert(data.student.first_name);


       
       global_admin=data.admin_login;


        if(data.super_admin_login){
          global_super_admin=true;
          isvalid=true;
    
        }
        else{
          global_super_admin=false;
          isvalid=false;
        }



       if(isvalid===false){

        if(global_admin==="yes"){
          isvalid=true;
          I
       
        }
        else{
          isvalid=false;
        }

       }




      } else {
        showToast("aeToastE", "Error", "Failed to fetch student details.", "20");
      }

     
    },
    error: function(xhr, status, error) {
      console.error(error);
      showToast("aeToastE", "Error", "Something went wrong.", "20");
    }
  });


//click event for student_view_docs 
$("#student_view_docs").click(function() {

  run_scripts();


});


});



function run_scripts(){
  aeLoading();
  $.ajax({
    type: "post",
    cache: false,
    url: "RUN_SCRIPTS.php",
    dataType: "text",
    success: function(data, status) {
    
      global_form_path="../PDF_FORMS/FORM_"+data+".pdf";
      global_letter_path="../PDF_LETTERS/ADM_"+data+".pdf";

      aeLoading();

      showWrapper4(['wrapper1'], 'wrapper', 20);
    

    },
    error: function(xhr, status, error) {
      aeLoading();
      console.error(error);
      showToast("aeToastE", "Error", "Something went wrong.", "20");
    }
  });
}





  function print_form(){
    aeDownload(global_form_path);
    
   
  }

  function print_letter(){
    aeDownload(global_letter_path);
    

  }
  function print_prospectus(){
    

  }



  function print_bill(){
    
    aeLoading()

    $.ajax({
        type: "post",
        cache: false,
        url: "BILL_PRINT.php",
        data: {
            admission_number: "none",
  
        },

        
        dataType: "text",
        success: function (data, status) {
            aeLoading()
           // alert(data);
            admission_number=null;
            aeDownload(data)
            // Handle the success response here if needed
            showToast("aeToastS","Success","Operation was successful.","20");
        },
        error: function (xhr, status, error) {
            aeLoading()
            showToast("aeToastE","Error","There was an error processing the request.","20");
        },
    });
  }
  $(document).ready(function() {
    $("#app_logo").click(function() {
       // alert("clicked");

      // alert(global_super_admin);
      // alert(global_admin);

       if(isvalid===false){
      //  showToast("aeToastE","Error","You are not authorized to perform this operation.","20");
        return;
        }

        // AJAX call to run ./SUPER_ADMIN_LOGIN.php
        $.ajax({
            type: "POST", // or "GET", depending on your requirements
            url: "./SUPER_ADMIN_LOGIN.php",
            dataType: "text", // or "text", if the response is a simple text
            success: function(response) {
          //    alert(response);
                // Handle the response from the server here
                console.log("Success:", response);

           if(global_admin==="yes"){
            window.location.replace("../admin/page.php");
           }
           else{
            window.location.replace("../superadmin/page.php");
           }



            },
            error: function(xhr, status, error) {
                // Handle errors here
                console.error("Error occurred:", error);
            }
        });
    });
});
