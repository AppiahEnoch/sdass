let studentData = []; // Store student data here to prevent hitting database again

function fetchStudentsInClass() {
  $.ajax({
    type: "post",
    cache: false,
    url: "CLASS_LIST_F.php", 
    dataType: "json",
    success: function (data, status) {
      studentData = data; // Store the data for later use
      populateTable(data);
    },
    error: function (xhr, status, error) {
      showToast("aeToastE","Fetch Error", "Could not fetch the student list.", "20");
    },
  });
}

function populateTable(data) {
  $("#class_list_table tbody").empty();
  
  data.forEach(function(student) {
    let fullName = student.first_name + " " + (student.middle_name ? student.middle_name + " " : "") + student.last_name;
    let imgPath = student.student_passport_image_input;
    
    $("#class_list_table tbody").append(
      `<tr>
        <td>${fullName}</td>
        <td><img src="${imgPath}" alt="${fullName}" width="50"></td>
      </tr>`
    );
  });
}

function searchStudent() {
  let query = $("#class_search_input").val().toLowerCase();
  let filteredData = studentData.filter(function(student) {
    let firstName = student.first_name.toLowerCase();
    let middleName = student.middle_name ? student.middle_name.toLowerCase() : "";
    let lastName = student.last_name.toLowerCase();
    
    return firstName.includes(query) || middleName.includes(query) || lastName.includes(query);
  });
  
  populateTable(filteredData);
}


$(document).ready(function () {
  fetchStudentsInClass();
  
  $("#class_search_input").on("input", searchStudent);
});

  

function downloadClassList() {
    $.ajax({
      type: "post",
      cache: false,
      url: "CLASS_LIST_DOWNL.php",
      dataType: "text",
      success: function (data, status) {
        if (data=="1") {
          // Trigger download
        aeDownload('../Excel/class_list.xlsx');
          showToast("aeToastS", "Download Success", "The class list has been successfully downloaded.", "20");
        } else {
          showToast("aeToastE", "Download Error", "Could not download the class list.", "20");
        }
      },
      error: function (xhr, status, error) {
        showToast("aeToastE", "Download Error", "Could not download the class list.", "20");
      },
    });
  }
  
  // Attach the function to the click event of the download icon
  $("#download_class_list").on("click", function() {
    //alert("Download clicked");
    downloadClassList();
  });
  