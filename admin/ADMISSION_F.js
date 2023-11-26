$(document).on("click", "#admission-suggestion li", function() {
 


updateImageView("studentPassportImage", "../devimage/passport.png");
  
   
    $("#admission-list").addClass("d-none");
    
    var itemText = $(this).text();
    var admissionNumber = itemText.split(" - ")[0];
    old_admission_number = admissionNumber;
    printID = admissionNumber;
    $(".download-link").remove();

    // set admission number to search box
    $("#admission_search_input").val(admissionNumber);


aeLoading()

    $.ajax({
        type: "post",
        url: "ADMISSION_F.php",
        data: {admission_number: admissionNumber},
        dataType: "json",
        success: function(data) {
          aeLoading()
            $("#currentAdmissionNumber").html(data.admission_number);
            $("#firstname").val(data.first_name);
            $("#middlename").val(data.middle_name);
            $("#lastname").val(data.last_name);
            $("#dateOfBirth").val(data.date_of_birth);
            $("#dateOfAdmission").val(data.date_of_admission);
            $("#class_selection").val(data.student_class);
            // Assuming data.string_class contains the text of the selected option
            $("#class_selection option:selected").text(data.string_class);
            $("#ghana_card_number").val(data.ghana_card_number);

         //   #residentialAddress
            $("#residentialAddress").val(data.student_residential_address);
            // Resetting file inputs by clearing the value attribute, assuming no file data to repopulate
            $("#ghana_card_image").val('');
            $("#birthCertificate").val('');
            $("#previous_school_report").val('');
            $("#studentPassportImageInput").val('');
            $("#hasHealthProblem").val(data.has_health_problem);
            $("#healthProblemTextArea").val(data.health_problem_details);
            $("#hasSpecialNeeds").val(data.has_special_needs);
            $("#specialNeedsTextArea").val(data.special_needs_details);
            $("#child_nationality").val(data.child_nationality);
            var classSelection = data.student_class.toLowerCase();
            $("#class_selection").val(classSelection).trigger('change');

            $("#language_spoken").val(data.language_spoken);
            var gender = data.gender
            if(gender === "Male") {
              $("#male_switch").prop('checked', true);
            } else if(gender === "Female") {
              $("#female_switch").prop('checked', true);
            }
            


            $("#healthProblemTextArea").text(data.health_problem_details);
            $("#specialNeedsTextArea").text(data.special_needs_details);


            if(data.has_health_problem === 'Yes') {
                $("#healthProblemDetails").removeClass('d-none');
            } else {
                $("#healthProblemDetails").addClass('d-none');
            }
        
            if(data.has_special_needs === 'Yes') {
                $("#specialNeedsDetails").removeClass('d-none');
            } else {
                $("#specialNeedsDetails").addClass('d-none');
            }
    
         
   
            $("#parent_firstName").val(data.parent_first_name);
            $("#parent_middleName").val(data.parent_middle_name);
            $("#parent_lastName").val(data.parent_last_name);
            // Resetting file inputs by clearing the value attribute, assuming no file data to repopulate
            $("#parent_passport_picture").val(''); 
            $("#parent_ghana_card_number").val(data.parent_ghana_card_number);
            // Resetting file inputs by clearing the value attribute, assuming no file data to repopulate
            $("#parent_ghana_card_image").val(''); 
            $("#parent_mobile").val(data.parent_mobile);
            $("#parent_email").val(data.parent_email);
            $("#parent_location").val(data.parent_location);
            $("#parent_house_address").val(data.parent_house_address);
            $("#parent_occupation").val(data.parent_occupation);
            // Resetting file inputs by clearing the value attribute, assuming no file data to repopulate
            
            $("#parent_region").val(data.parent_region).trigger('change');



            $("#father_first_name").val(data.father_first_name);
            $("#father_middle_name").val(data.father_middle_name);
            $("#father_last_name").val(data.father_last_name);
            $("#father_education").val(data.father_education);
            $("#father_occupation").val(data.father_occupation);
            $("#father_mobile").val(data.father_mobile);
            $("#father_residential_address").val(data.father_residential_address);
            $("#relationship_with_child").val(data.relationship_with_child);



            $("#mothers_first_name").val(data.mother_first_name);
            $("#mothers_middle_name").val(data.mother_middle_name);
            $("#mothers_last_name").val(data.mother_last_name);
            $("#mothers_education").val(data.mother_education);
            $("#mothers_occupation").val(data.mother_occupation);
            $("#mothers_mobile").val(data.mother_mobile);
            $("#mothers_residential_address").val(data.mother_residential_address);



addDownloadLink("#ghana_card_image", "Download Ghana Card Image", data.ghana_card_image);
addDownloadLink("#birthCertificate", "Download Birth Certificate", data.birth_certificate);
addDownloadLink("#previous_school_report", "Download Previous School Report", data.previous_school_report);


addDownloadLink("#parent_proof_of_residence", "Download Proof of Residence", data.parent_proof_of_residence);
addDownloadLink("#parent_ghana_card_image", "Download Ghana Card Image", data.parent_ghana_card_image);
addDownloadLink("#parent_passport_picture", "Download Parent Passport", data.parent_passport_picture);

updateImageView("studentPassportImage", data.student_passport_image_input);

        },
        error: function(error) {
            console.error("Error fetching data: ", error);
            aeLoading()
        }
    });
    
});

function addDownloadLink(element, text, path) {
    if(aeEmpty(path)) {
        return;
    }

    var link = $("<a>").attr({
        "href": path,
        "target": "_blank"
    }).text(text).addClass("download-link");
    $(element).after(link);
}





$("#admission_print").click (function(){
    if (aeEmpty(printID)) {
      // close dropdown menu
      $('#admission_print').dropdown('hide');
        showToast("aeToastE", "ADMISSION NUMBER?", "Please select an admission number", "20");
        return false;
    }
});

$("#print_admission_form").click (function(){
  
  printAdmissionForm(printID);
});

$("#print_admission_bill").click (function(){
  
  printAdmissionBill(printID);
});

$("#print_admission_letter").click (function(){

  printAdmissionLetter(printID);
});



function printAdmissionLetter(printID) {
    $.ajax({
      type: "post",
      data: {
        id: printID,
      },
      cache: false,
      url: "ADMISSION_LETTER.php",
      dataType: "text",
      success: function (data, status) {
        aeDownload("../report/admission_letter.pdf");
      },
      error: function (xhr, status, error) {
     alert(error);
      },
    });
  }
function printAdmissionForm(printID) {
    $.ajax({
      type: "post",
      data: {
        id: printID,
      },
      cache: false,
      url: "ADMISSION_FORM.php",
      dataType: "text",
      success: function (data, status) {
        aeDownload("../report/admission_form.pdf");
      },
      error: function (xhr, status, error) {
     alert(error);
      },
    });
  }


  function printAdmissionBill(printID) {
    $.ajax({
      type: "post",
      data: {
        id: printID,
      },
      cache: false,
      url: "student_bill_print.php",
      dataType: "text",
      success: function (data, status) {
       // alert(data);
        aeDownload("../report/Student_Bills.pdf");
      },
      error: function (xhr, status, error) {
     alert(error);
      },
    });
  }



  $(document).ready(function () {

  
    $('#residentialAddress').on('input', function () {
      let value = $(this).val();
      if (old_admission_number !== null) {
        return;
      }
      $('#mothers_residential_address, #father_residential_address, #parent_house_address').val(value);
    });
  
    $('#parent_mobile').on('input', function () {
      let value = $(this).val();
      if (old_admission_number !== null) {
        return;
      }
      $('#father_mobile, #mothers_mobile').val(value);
    });
  
    $('#parent_occupation').on('input', function () {
      let value = $(this).val();
      if (old_admission_number !== null) {
        return;
      }
      $('#father_occupation, #mothers_occupation').val(value);
    });
  });
  