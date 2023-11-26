var old_admission_number = null;
var printID = null;

function setAdmissionDateToToday() {
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); // January is 0!
    var yyyy = today.getFullYear();
    
    today = yyyy + '-' + mm + '-' + dd;
    
    $("#dateOfAdmission").val(today);
  }
  
  // Call the function to set the date

  

$(document).ready(function() {
   // showToast("aeToastS", "Success", "Admission number selected", "20");
    setAdmissionDateToToday();
 
});




function toggleSearchVisibility() {
    $("#admission_search").toggleClass("d-none");
    $("#currentAdmissionNumber").html('');

    // reset form
    $("#admissionForm").trigger("reset");
    $(".download-link").remove();
    setAdmissionDateToToday();
}

$(document).ready(function() {

      
    $("#admission_edit").click(toggleSearchVisibility);
     old_admission_number = null;


     //admissionFormCancel
     $("#admissionFormCancel").click(function() {
        $("#admission_search").addClass("d-none");
        $("#admission-list").addClass("d-none");
        $("#admissionForm").trigger("reset");
        $(".download-link").remove();
        setAdmissionDateToToday();
  
     });
     


});



  


function toggleCardVisibility() {
    const searchBox = $(".admission-search");
    const card = $(".search-box .card");
  
    searchBox.on("keyup", function() {
        // remove a linkds
        $(".download-link").remove();
        updateImageView("studentPassportImage", "../devimage/passport.png");

      if ($(this).val().trim() === "") {
        card.addClass("d-none");
      } else {
        card.removeClass("d-none");
      }
    });
  }
  
  toggleCardVisibility();
  









  $(document).ready(function() {
    var formData = new FormData();


    $("#admissionForm").on("submit", function(e) {
        e.preventDefault();

        // Getting student's details
        var firstname = $("#firstname").val().toUpperCase();
        var middlename = $("#middlename").val().toUpperCase();
        var lastname = $("#lastname").val().toUpperCase();
        var dateOfBirth = $("#dateOfBirth").val();
        var date_of_admission= $("#dateOfAdmission").val();
        var student_class = $("#class_selection").val().toUpperCase();
        var stringClass= $("#class_selection option:selected").text().toUpperCase();
        var ghana_card_number = $("#ghana_card_number").val().toUpperCase();
        var student_residential_address= $("#residentialAddress").val().toUpperCase();
        var selectedGender = '';
        $(".gender-switch").each(function() {
          if ($(this).prop('checked')) {
            selectedGender = $(this).val();
            
          }
   
        });



        var gender = selectedGender;

        if(aeEmpty(gender)){
            showToast("aeToastE", "Error", "Please select gender", "20");
            return false;

        }
      // alert(gender)
        var language_spoken= $("#language_spoken").val().toUpperCase();
        
        
        var ghana_card_image = $("#ghana_card_image").prop('files')[0];
        var birthCertificate = $("#birthCertificate").prop('files')[0];
        var previous_school_report = $("#previous_school_report").prop('files')[0];
        var studentPassportImage = $("#studentPassportImageInput").prop('files')[0];

        var hasHealthProblem = $("#hasHealthProblem").val();
       var healthProblemDetails = $("#healthProblemTextArea").val();
       var hasSpecialNeeds = $("#hasSpecialNeeds").val();
       var specialNeedsDetails = $("#specialNeedsTextArea").val();
       var childNationality = $("#child_nationality").val().toUpperCase();

      


      if (student_class == "0") { 
      
    
       showToast("aeToastE", "Error", "Please select a class", "20");
        return false;
      }

     
 
      

        // Getting parent/guardian's details
        var parent_firstName = $("#parent_firstName").val().toUpperCase();
        var parent_middleName = $("#parent_middleName").val().toUpperCase();
        var parent_lastName = $("#parent_lastName").val().toUpperCase();
        var parent_passport_picture = $("#parent_passport_picture").prop('files')[0];
        var paret_ghana_card_number = $("#parent_ghana_card_number").val().toUpperCase();
        var paret_ghana_card_image = $("#parent_ghana_card_image").prop('files')[0];
        var parent_mobile = $("#parent_mobile").val().toUpperCase();
        var parent_email = $("#parent_email").val().toUpperCase();
        var parent_location = $("#parent_location").val().toUpperCase();
        var parent_region = $("#parent_region").val().toUpperCase();
        var parent_house_address = $("#parent_house_address").val().toUpperCase();
        var parent_occupation = $("#parent_occupation").val().toUpperCase();

        var relationship_with_child = $("#relationship_with_child").val().toUpperCase();
        var parent_proof_of_residence = $("#parent_proof_of_residence").prop('files')[0];






        var father_first_name = $("#father_first_name").val().toUpperCase();
        var father_middle_name = $("#father_middle_name").val().toUpperCase();
        var father_last_name = $("#father_last_name").val().toUpperCase();
        var father_education = $("#father_education").val().toUpperCase();
        var father_occupation = $("#father_occupation").val().toUpperCase();
        var father_mobile = $("#father_mobile").val();
        var father_residential_address = $("#father_residential_address").val().toUpperCase();

       // alert(father_first_name)

        formData.append("father_first_name", father_first_name);
        formData.append("father_middle_name", father_middle_name);
        formData.append("father_last_name", father_last_name);
        formData.append("father_education", father_education);
        formData.append("father_occupation", father_occupation);
        formData.append("father_mobile", father_mobile);
        formData.append("father_residential_address", father_residential_address);







        var mothers_first_name = $("#mothers_first_name").val().toUpperCase();
        var mothers_middle_name = $("#mothers_middle_name").val().toUpperCase();
        var mothers_last_name = $("#mothers_last_name").val().toUpperCase();
        var mothers_education = $("#mothers_education").val().toUpperCase();
        var mothers_occupation = $("#mothers_occupation").val().toUpperCase();
        var mothers_mobile = $("#mothers_mobile").val();
        var mothers_residential_address = $("#mothers_residential_address").val().toUpperCase();
        
        formData.append("mothers_first_name", mothers_first_name);
        formData.append("mothers_middle_name", mothers_middle_name);
        formData.append("mothers_last_name", mothers_last_name);
        formData.append("mothers_education", mothers_education);
        formData.append("mothers_occupation", mothers_occupation);
        formData.append("mothers_mobile", mothers_mobile);
        formData.append("mothers_residential_address", mothers_residential_address);
        






        

        // Create a FormData object to package the data
      

        formData.append("old_admission_number", old_admission_number);
        
        formData.append("firstname", firstname);
        formData.append("middlename", middlename);
        formData.append("lastname", lastname);
        formData.append("dateOfBirth", dateOfBirth);
        formData.append("date_of_admission", date_of_admission);
        formData.append("student_class", student_class);
        formData.append("student_residential_address", student_residential_address);
        formData.append("stringClass", stringClass);
        formData.append("ghana_card_number", ghana_card_number);
        formData.append("ghana_card_image", ghana_card_image);
        formData.append("gender",gender); 
        formData.append("language_spoken",language_spoken);
 
  
       // alert(stringClass)

        formData.append("hasHealthProblem", hasHealthProblem);
formData.append("healthProblemDetails", healthProblemDetails);
formData.append("hasSpecialNeeds", hasSpecialNeeds);
formData.append("specialNeedsDetails", specialNeedsDetails);
formData.append("childNationality", childNationality);


    
        
     
        formData.append("birthCertificate", birthCertificate);
        formData.append("previous_school_report", previous_school_report);
        formData.append("parent_firstName", parent_firstName);
        formData.append("parent_middleName", parent_middleName);
        formData.append("parent_lastName", parent_lastName);
        formData.append("parent_passport_picture", parent_passport_picture);
        formData.append("parent_ghana_card_number", paret_ghana_card_number);
        formData.append("parent_ghana_card_image", paret_ghana_card_image);
        formData.append("parent_mobile", parent_mobile);
        formData.append("relationship_with_child", relationship_with_child);

        formData.append("parent_region", parent_region);
        formData.append("parent_email", parent_email);
        formData.append("parent_location", parent_location);
        formData.append("parent_house_address", parent_house_address);
        formData.append("parent_occupation", parent_occupation);
        formData.append("parent_proof_of_residence", parent_proof_of_residence);
        formData.append("studentPassportImageInput", studentPassportImage);

 

      //  alert(paret_ghana_card_number)
       aeLoading()

        // AJAX to send the form data
        $.ajax({
            type: "post",
            cache: false,
            url: "admission_INSERT.php",
            dataType: "text",
            data: formData,
            contentType: false,
            processData: false,
            success: function(data, status) {
               // reloadPage();
               window.location.reload(true);

              //  alert(data)
            
              console.log(data);
              // trim data
                data = data.trim();
                printID = data;
                aeLoading()

             $("#currentAdmissionNumber").html(data);

            //showToastR("aeToastR", "Submission Successful","Submission made successfully", "20");
            },
            error: function(xhr, status, error) {
                showToast("aeToastE", "Error", "There was an error processing the request.", "20");
                console.error(error);
                aeLoading()
            }
        });
    });
});









  




var studentsData = [];

$(document).ready(function () {
    loadStudentData();
    
$(".admission-search").on("keyup", function () {
        updateImageView("studentPassportImage", "../devimage/passport.png");
        $("#currentAdmissionNumber").html('');
        handleSearch(this, "#admission-suggestion", "#admission-list");

    });

    $("#fee_search").on("keyup", function () {
        handleSearch(this, "#payee-suggestion", "#payee-list",);
    });

    $("#teacher_search_student_for_terminal_search").on("keyup", function () {
        handleSearch(this, "#teacher_search_student_for_terminal_admission_suggestion", "#teacher_search_student_for_terminal_admission_list",);
        
    });
});

function handleSearch(inputElem, suggestionBoxSelector, listSelector) {
    var searchTerm = $(inputElem).val().toLowerCase();

    if (searchTerm.length > 0) {
        var suggestions = studentsData.filter(function (student) {
            return (
                student.admission_number.toLowerCase().includes(searchTerm) ||
                student.first_name.toLowerCase().includes(searchTerm) ||
                student.middle_name.toLowerCase().includes(searchTerm) ||
                student.last_name.toLowerCase().includes(searchTerm)
            );
        });

        renderSuggestions(suggestions, suggestionBoxSelector, listSelector);
    } else {
        $(listSelector).addClass("d-none");
    }
}



function renderSuggestions(suggestions, suggestionBoxSelector, listSelector) {
    var list = $(suggestionBoxSelector);
    list.empty();

    if (suggestions.length === 0) {
        list.append("<li class='list-group-item'>No matches found</li>");
    } else {
        suggestions.forEach(function (student) {
            list.append(
                "<li class='list-group-item'>" +
                student.admission_number + " - " +
                student.first_name + " " +
                student.middle_name + " " +
                student.last_name +
                "</li>"
            );
        });
    }

    $(listSelector).removeClass("d-none");
}

function loadStudentData() {
    function fetchStudentData() {
        $.ajax({
            type: "post",
            cache: false,
            url: "ADMISSION_INIT.php",
            dataType: "json",
            success: function (data, status) {
                if (data && data.length > 0) {
                    studentsData = data;
                } else {
                    showToast("aeToastE", "Error", "Failed to fetch student data", "20");
                }
            },
            error: function (xhr, status, error) {
              //  showToast("aeToastE", "Error", error, "20");
            },
        });
    }

    fetchStudentData();
}





$(document).ready(function() {
    
    // Fetch class names on page load
    fetchClasses();
    fetchQualifications();
    fetchRegions();

    function fetchClasses() {
        $.ajax({
            type: "GET",
            cache: false,
            url: "CLASS_F.php",
            dataType: "json",
            success: function(data) {
                // Array of select IDs to be populated
                const selectIds = ["class_selection", "class_selection2","student_bill_studentClass",
                "teacher_print_student_class_list","admin_admission_list_filter_class",
                "admin_upload_class_timetable_select_class"];

                selectIds.forEach(selectId => {
                    const classSelection = $("#" + selectId);
                    data.forEach(classInfo => {
                        classSelection.append(`<option value="${classInfo.id}">${classInfo.class_name}</option>`);
                    });
                });
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }

});
    function fetchQualifications() {
        $.ajax({
            type: "GET",
            cache: false,
            url: "QUALIFICATIONS_F.php",
            dataType: "json",
            success: function(data) {
                const selectIds = ["mothers_education", "father_education"];
              
                


                selectIds.forEach(selectId => {
                    const qualificationSelection = $("#" + selectId);
                    data.forEach(qualificationInfo => {
                        qualificationSelection.append(`<option value="${qualificationInfo.id}">${qualificationInfo.name}</option>`);
                    });
                });
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }



    function fetchRegions() {
        $.ajax({
            type: "GET",
            cache: false,
            url: "REGIONS_F.php",
            dataType: "json",
            success: function(data) {
                const regionSelection = ["parent_region"];
                regionSelection.forEach(selectId => {
                    const selectElement = $("#" + selectId);
                    data.forEach(region => {
                        selectElement.append(`<option value="${region.id}">${region.name}</option>`);
                    });
                });
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    }



    









function openFileChooser() {
    document.getElementById('studentPassportImageInput').click();



  }

  // change event  for  studentPassportImageInput
    $("#studentPassportImageInput").change(function() {
       
        var isImage=false;

        isImage=  isFileImage2("studentPassportImageInput");
       // alert(isImage)
          if(isImage==false){
             // reset the input
                $("#studentPassportImageInput").val("");
                return
          }

          changeImageSRC("studentPassportImageInput","studentPassportImage")
            

          
    });


    $(document).ready(function () {
        $('#hasHealthProblem').change(function () {
            if ($(this).val() === 'Yes') {
                $('#healthProblemDetails').removeClass('d-none');
                $('#healthProblemTextArea').attr('required', true);
            } else {
                $('#healthProblemDetails').addClass('d-none');
                $('#healthProblemTextArea').attr('required', false);
                $('#healthProblemTextArea').val('');
            }
        });
    });

    $(document).ready(function () {
     
        $('#hasSpecialNeeds').change(function () {
            if ($(this).val() === 'Yes') {
                $('#specialNeedsDetails').removeClass('d-none');
                $('#specialNeedsTextArea').attr('required', true);
            } else {
                $('#specialNeedsDetails').addClass('d-none');
                $('#specialNeedsTextArea').attr('required', false);
                $('#specialNeedsTextArea').val('');
            }
        });
    });
    
    

    // document rady






      
      

  
      











    $(document).ready(function () {
       //ae_fill_form('admissionForm');
    });


    $(document).ready(function(){
        $('.gender-switch').on('change', function() {
          $('.gender-switch').not(this).prop('checked', false);
        });
      });
      





      // Attach click event to the delete button
$('#admissionFormDelete').click(function() {
    const old_admission_number1 = old_admission_number // Replace with the actual value

    if(aeEmpty(old_admission_number1)) {
      showToast("aeToastE", "Error", "Please select a student Record before you can delete", "20");
      return false;
    }
  
    // Confirm delete
    showToastY(
      "aeToastY",
      "Confirm Delete",
      "Are you sure you want to delete this student record?",
      "20",
      function() { // Function for YES option
        deleteStudent(old_admission_number1);
      },
      function() { // Function for NO option
        // Do nothing
      }
    );
  });
  
  function deleteStudent(admission_number) {
    $.ajax({
      type: "post",
      cache: false,
      url: "ADMISSION_D.php",
      data: { admission_number: admission_number },
      dataType: "json",
      success: function (data, status) {
        // reset form
        $("#admissionForm").trigger("reset");
        $("currentAdmissionNumber").html("");
        setAdmissionDateToToday();
        if(data.status === 'success') {
          showToast("aeToastS", "Success", "Student record deleted successfully", "20");
        } else {
          showToast("aeToastE", "Error", "Failed to delete student record", "20");
        }
      },
      error: function (xhr, status, error) {
        showToast("aeToastE", "Error", "Failed to delete student record", "20");
      },
    });
  }
  