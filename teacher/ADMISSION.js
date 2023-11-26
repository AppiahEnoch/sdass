var old_admission_number = null;
var printID = null;


  
  // Call the function to set the date

  






  

















  




var studentsData = [];

$(document).ready(function () {
    loadStudentData();
    

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







    













    
    

    // document rady






      
      

  
      










      






  

  