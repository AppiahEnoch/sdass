
var teacher_timetable_url = "";
var teacher_academic_calendar_url = "";

$(document).ready(function() {

  $.ajax({
    type: "POST",
    url: "TIMETABLE_FETCHT.php", // the PHP file that retrieves URLs

    dataType: "json",

    success: function(response) {
    //  alert(response);

    if((response.success==false) || (response.success=="false")){
       // showToast("aeToastE", "Error", "No academic calendar uploaded for this class.", "20");
        return;
        }

      if(aeEmpty(response.timetable_url)){
       // showToast("aeToastE", "Error", "No timetable uploaded for this class.", "20");
        return;
        }

     teacher_timetable_url = response.timetable_url;

      
   
     
    },
    error: function(xhr, status, error) {
      console.log(xhr);
        showToast("aeToastE", "Error", "Could not load timetable and academic calendar links.", "20");
    }
});

});






function teacher_download_timetable() {
  if(aeEmpty(teacher_timetable_url)){
     showToast("aeToastE", "NO TIMETABLE AVAILABLE", "No timetable uploaded for this class.", "20");
     return;
     }
  aeDownload(teacher_timetable_url);

}

function teacher_download_academic_calendar() {
  if(aeEmpty(teacher_academic_calendar_url)){
     showToast("aeToastE", "NO ACADEMIC CALENDAR AVAILABLE", "No academic calendar uploaded for this class.", "20");
     return;
     }



    aeDownload(teacher_academic_calendar_url);
  
}



function fetch_calendar () {
    $.ajax({
        type: "POST",
        url: "TIMETABLE_FETCH2T.php", // the PHP file that retrieves URLs
        dataType: "json",

        success: function(response) {
          //alert(response);

          if((response.success==false) || (response.success=="false")){
            // showToast("aeToastE", "Error", "No academic calendar uploaded for this class.", "20");
             return;
             }
        //  alert(response);
           console.log(response);
          teacher_academic_calendar_url= response.academic_calendar_url;
        },
        error: function(xhr, status, error) {
            console.log(xhr);
            showToast("aeToastE", "Error", "Could not load timetable and academic calendar links.", "20");
        }
    });
}

 $(document).ready(function() {
    fetch_calendar();
});






  
