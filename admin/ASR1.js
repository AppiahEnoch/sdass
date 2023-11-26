var admission_number = "";
$(document).ready(function() {

    $('#teacher_print_student_report_cancel').click(function() {

        document.getElementById("teacher_print_student_report_form").reset();

    });




    $('#teacher_print_student_terminal').click(function() {

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