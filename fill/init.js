var parentDetails = [];
var studentDetails = [];
var fatherDetails = [];
var motherDetails = [];
var nextStep = "";
var global_fetch = false;

function fetchStudentDetails() {
    $.ajax({
        type: "post",
        cache: false,
        url: "STUDENT_FETCH.php", // Replace with the path to your PHP file
        dataType: "json",
        success: function (data, status) {
            if (data.parent) {
                parentDetails = data.parent;
            }

            if (data.student) {
                studentDetails = data.student;
            }

            if (data.father) {
                fatherDetails = data.father;
            }

            if (data.mother) {
                motherDetails = data.mother;
            }

            if (data.next_step) {
                nextStep = data.next_step;
            }

            fillParentFormWithData();
            fillParentForm2WithData()
            fillStudentForm1WithData();
            fillFathersDetailFormWithData()
            fillMothersDetailFormWithData()

            // For debugging, you might want to remove or replace this with proper handling
            console.log("Parent Details: ", parentDetails);
            console.log("Student Details: ", studentDetails);
            console.log("Father Details: ", fatherDetails);
            console.log("Mother Details: ", motherDetails);
            console.log("Next Step: ", nextStep);


           
        },
        error: function (xhr, status, error) {
            console.error(error);
        },
    });
}

$(document).ready(function () {
   fetchStudentDetails();
});

  


function fillParentFormWithData() {
    if (parentDetails.length === 0) {
        console.log("Parent details are empty");
        return;
    }

    $('#title_guardian_title_select').val(parentDetails.title);
    $('#fname_guardian_first_name_input').val(parentDetails.parent_first_name);
    $('#mname_guardian_middle_name_input').val(parentDetails.parent_middle_name);
    $('#lname_guardian_last_name_input').val(parentDetails.parent_last_name);
}


function fillParentForm2WithData() {
    if (!parentDetails || Object.keys(parentDetails).length === 0) {
        console.log("Parent details are empty");
        return;
    }

    $('#location').val(parentDetails.parent_location);
    $('#email').val(parentDetails.parent_email);
    $('#mobile').val(parentDetails.parent_mobile);
    $('#postaladdress').val(parentDetails.parent_house_address);
    $('#digitaladdress').val(parentDetails.parent_digital_address);
    $('#title_guardian_title_select').val(parentDetails.title);
    //alert(parentDetails.title);

}


function fillStudentForm1WithData() {
    if (!studentDetails || studentDetails.length === 0) {
        console.log("Student details are empty");
        global_fetch = false;
        return;
    }

    $('#gender').val(studentDetails.gender);
    $('#nhis').val(studentDetails.nhis_number); // Assuming NHIS card number is a column in your student table
    $('#ghana').val(studentDetails.ghana_card_number);
    $('#resultslip').removeAttr('required');
    global_fetch = true;



    
    $('#dob').val(studentDetails.date_of_birth);
    $('#placeOfbirth').val(studentDetails.student_residential_address);
    $('#hometown').val(studentDetails.home_town);
    $('#religion').val(studentDetails.religion);
    $('#denomination').val(studentDetails.denomination);

    $('#region').val(studentDetails.region); // Assuming 'region' is the name of the column in your student table
    $('#lastschool').val(studentDetails.last_school);
    $('#beceyear').val(studentDetails.bece_year);
    $('#selectsick').val(studentDetails.has_health_problem);
    $('#selectsick').val(studentDetails.has_health_problem);
    $('#typeofsickness').val(studentDetails.health_problem_details);

    
  const select = document.getElementById("selectsick");
  const sicknessDetails = document.getElementById("typeofsickness");

  if(select.value === "No") {
    sicknessDetails.classList.add("d-none");
    sicknessDetails.required = false;
  } else {
    sicknessDetails.classList.remove("d-none");
    sicknessDetails.required = true;
  }

    


}

function fillFathersDetailFormWithData() {
    if (!fatherDetails || Object.keys(fatherDetails).length === 0) {
        console.log("Father details are empty");
        return;
    }

    $('#father1').val(fatherDetails.father_first_name);
    $('#father2').val(fatherDetails.father_middle_name);
    $('#father3').val(fatherDetails.father_last_name);
    $('#father4').val(fatherDetails.father_mobile);
}


function fillMothersDetailFormWithData() {
    if (!motherDetails || Object.keys(motherDetails).length === 0) {
        console.log("Mother details are empty");
        return;
    }

    $('#mother1').val(motherDetails.mother_first_name);
    $('#mother2').val(motherDetails.mother_middle_name);
    $('#mother3').val(motherDetails.mother_last_name);
    $('#mother4').val(motherDetails.mother_mobile);
}




$(document).ready(function() {
  
    $.ajax({
        type: "GET",
        url: "PLEDGE_FETCH.php",
        dataType: "json",
        success: function(response) {
            console.log(response);
            if (response.success) {
                $("#stuname").text(response.fullname);
            } else {
                console.log("Student information not found.");
            }
        },
        error: function(error) {
            console.log("Error fetching student information: ", error);
        }
    });
});
