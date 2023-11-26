var admission_number = "";
$(document).ready(function() {

    $('#teacher_print_student_report_cancel').click(function() {

        document.getElementById("teacher_print_student_report_form").reset();

    });




    $('#teacher_print_student_terminal').click(function() {
        //alert(1);

        if (aeEmpty(admission_number)) {
           // showToast("aeToastE", "ADMISSION NUMBER?", "Please select an admission number", "20");

                       aeLoading()

            $.ajax({
                type: "post",
                cache: false,
                url: "ASR1_TERMINAL_PRINT_ALL.php",
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








            return false;
        }
        $.ajax({
            type: "post",
            cache: false,
            url: "ASR1_TERMINAL_PRINT.php",
            data: {
                admission_number: admission_number,
      
            },

            
            dataType: "text",
            success: function (data, status) {
               // alert(data);
                admission_number=null;
                aeDownload(data)
                // Handle the success response here if needed
                showToast("aeToastS","Success","Operation was successful.","20");
            },
            error: function (xhr, status, error) {
                showToast("aeToastE","Error","There was an error processing the request.","20");
            },
        });
    });


  

});


$(document).ready(function () {
    $("#teacher_print_student_print_btn").click(function(e) {
        e.preventDefault();

        // Retrieve values from the form fields
        var searchTerm = $('#teacher_search_student_for_terminal_search').val().trim();
        var startDate = $('#teacher_print_student_start_date').val();
        var endDate = $('#teacher_print_student_end_date').val();
        var selectedClass = $('#teacher_print_student_class_list').val();
        var selectedTerm = $('#teacher_print_student_term_list').val();

        // Prepare data object based on the used filters
        var data = {};
        if (searchTerm) data.searchTerm = searchTerm;
        if (startDate) data.startDate = startDate;
        if (endDate) data.endDate = endDate;
        if (selectedClass) data.selectedClass = selectedClass;
        if (selectedTerm) data.selectedTerm = selectedTerm;

        // Make AJAX request to TRANSCRIPT.php with the data
        $.ajax({
            type: "POST",
            url: "TRANSCRIPT.php",
            data: data,
            dataType: "text", // or "text", "html", depending on the response you expect
            success: function(response) {

                //download 
                aeDownload(response);
                // alert
                showToast("aeToastS", "Success", "Download was successful.", "20");
                
              
            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error("Error occurred:", error);
            }
        });
    });

    // Implement any other button click events if necessary
    // ...
});



// document ready function
$(document).ready(function() {
    $("#teacher_search_student_for_terminal_search").on("keyup", function () {
       
        handleSearch(this, "#teacher_search_student_for_terminal_admission_suggestion", "#teacher_search_student_for_terminal_admission_list",);
        
    });





    $(document).on("click", "#teacher_search_student_for_terminal_admission_suggestion li", function() {
 
        $("#teacher_search_student_for_terminal_admission_list").addClass("d-none");
        
        var itemText = $(this).text();
        admission_number  = itemText.split(" - ")[0];
     
    
    
        $("#teacher_search_student_for_terminal_search").val(admission_number);
    
    })







});