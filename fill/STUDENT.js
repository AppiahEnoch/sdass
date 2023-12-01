$(document).ready(function() {
    $('#churches').on('change', function() {
        var selectedText = $(this).find('option:selected').text();
        $('#denomination').val(selectedText);
    });

    populateYears();
});

function populateYears() {
    var select = document.getElementById("beceyear");
    var currentYear = new Date().getFullYear();
    
    select.innerHTML = `<option value="none">Choose Year</option>`;
    
    for (var i = 0; i < 10; i++) {
      var year = currentYear - i;
      var option = document.createElement("option");
      option.value = year;
      option.text = year;
      select.appendChild(option);
    }
  }
  

  const select = document.getElementById("selectsick");
const sicknessDetails = document.getElementById("typeofsickness");

select.addEventListener("change", () => {
  if(select.value === "No") {
    sicknessDetails.classList.add("d-none");
    sicknessDetails.required = false;
  } else {
    sicknessDetails.classList.remove("d-none");
    sicknessDetails.required = true;
  }
});




function submitStudentInfo1() {
  $("#student_info_form1").submit(function (e) {
    e.preventDefault();

    var gender = $("#gender").val();
    var nhis = $("#nhis").val();
    var ghana = $("#ghana").val()
    var passport = $("#passport")[0].files[0];
    var resultslip = $("#resultslip")[0].files[0];


    // check if gender is selected
    if (gender === "none") {
      showToast("aeToastE", "Error", "Please select a gender", "20");
      return;
    }


    // Validate file inputs

   // alert(global_fetch)
if(global_fetch===false) {

  if (!isFileImage2("passport")) {
    // showToast("aeToastE", "Error", "Invalid passport picture format. ONLY JPG OR PNG ARE ALLOWED. SIZE MUST BE LESS THAN 1MB", "20");
    // return;
  }

  
  if (!isFilePDF2("resultslip")) {
    showToast("aeToastE", "Error", "Invalid results slip  format ONLY PDF ALLOWED!", "20");
    return;
  }

}




    var formData = new FormData();
    formData.append('gender', gender);
    formData.append('nhis', nhis);
    formData.append('ghana', ghana);
    formData.append('passport', passport);
    formData.append('resultslip', resultslip);

    $.ajax({
      type: "post",
      cache: false,
      url: "STUDENT1_INSERT.php",
      contentType: false,
      processData: false,
      data: formData,
      dataType: "json",
      success: function (data, status) {
        console.log(data);
        if (data.success) {

   
          showToastP(
            "aeToastP", 
            " CONTINUE... 40% DONE", 
            "CONTINUE TO FILL STUDENT INFORMATION", 
            "30",
            function() {
              showWrapper4(['wrapper4'], 'wrapper', 100);
            }
          );
          




        





        } else {
          showToast("aeToastE", "Error", "Failed to save student details", "20");
        }
      },
      error: function (xhr, status, error) {
        showToast("aeToastE", "Error", error, "20");
      },
    });
  });
}

$(document).ready(function() {
  submitStudentInfo1();




  $('#student1_back').on('click', function() {
    showWrapper4(['wrapper11'], 'wrapper', 100);
    //alert('back');
});
  $('#student2_back').on('click', function() {
    showWrapper4(['wrapper3'], 'wrapper', 100);
   
});

  $('#student3_back').on('click', function() {
    showWrapper4(['wrapper4'], 'wrapper', 100);
});


  $('#student4_back').on('click', function() {
    showWrapper4(['wrapper5'], 'wrapper', 100);
});

});





function submitStudentDetailForm2() {
  $("#student_detail_form2").submit(function (e) {
    e.preventDefault();

    var dob = $("#dob").val();
    var placeOfbirth = $("#placeOfbirth").val().toUpperCase();
    var hometown = $("#hometown").val().toUpperCase();
    var religion = $("#religion").val();
    var denomination = $("#denomination").val().toUpperCase();
    aeLoading();

    $.ajax({
      type: "post",
      cache: false,
      url: "STUDENT2_INSERT.php",
      data: {
        dob: dob,
        placeOfbirth: placeOfbirth,
        hometown: hometown,
        religion: religion,
        denomination: denomination
   
      },
      dataType: "json",
      success: function (data, status) {
        aeLoading();
        console.log(data);
        if (data.success) {
          showToastP(
            "aeToastP", 
            " CONTINUE... 50% DONE", 
            "CONTINUE TO FILL STUDENT INFORMATION", 
            "30",
            function() {
              showWrapper4(['wrapper5'], 'wrapper', 100);
            }
          );
          
       
        } else {
          showToast("aeToastE", "Error", "Failed to submit student details", "20");
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
  submitStudentDetailForm2();
});






function submitStudentDetailForm3() {
  $("#student_region_form").submit(function (e) {
    e.preventDefault();

    var region = $("#region").val();
    var lastschool = $("#lastschool").val().toUpperCase();
    var beceyear = $("#beceyear").val();
    aeLoading();

    $.ajax({
      type: "post",
      cache: false,
      url: "STUDENT3_INSERT.php",
      data: {
        region: region,
        last_school: lastschool,
        bece_year: beceyear
      },
      dataType: "json",
      success: function (data, status) {
        aeLoading();
        console.log(data);
        if (data.success) {
   

          showToastP(
            "aeToastP", 
            " CONTINUE... 60% DONE", 
            "CONTINUE TO FILL STUDENT INFORMATION", 
            "30",
            function() {
              showWrapper4(['wrapper6'], 'wrapper', 100);
            }
          );
          



   
        } else {
          showToast("aeToastE", "Error", "Failed to submit region details", "20");
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

  submitStudentDetailForm3()
});





function submitStudentDetailsForm4() {
  $("#student_details_form4").submit(function (e) {
    e.preventDefault();

    var selectsick = $("#selectsick").val();
    var typeofsickness = $("#typeofsickness").val().toUpperCase();

    if(aeEmpty(typeofsickness)) {
      typeofsickness = "";
    }

    // If 'Yes' is selected but no sickness description is provided
    if (selectsick === "Yes" && typeofsickness.trim() === "") {
      showToast("aeToastE", "Error", "Please describe the type of sickness", "20");
      return;
    }


    if (selectsick === "none") {
      showToast("aeToastE", "Error", "Please select an option", "20");
      return;
    }

    //alert(typeofsickness)
    aeLoading();

    $.ajax({
      type: "post",
      cache: false,
      url: "STUDENT4_INSERT.php",
      data: {
        selectsick: selectsick,
        typeofsickness: typeofsickness
      },
      dataType: "json",
      success: function (data, status) {
        aeLoading();
        console.log(data);
        if (data.success) {




          
          showToastP(
            "aeToastP", 
            " CONTINUE... 70% DONE", 
            "CONTINUE TO FILL FATHER'S INFORMATION.", 
            "30",
            function() {
              showWrapper4(['wrapper7'], 'wrapper', 100);
            }
          );



        } else {
          showToast("aeToastE", "Error", "Failed to submit sickness details", "20");
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

  submitStudentDetailsForm4();
});
