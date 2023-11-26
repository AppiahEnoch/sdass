function fetchTeachers() {
  $.ajax({
      type: "post",
      cache: false,
      url: "TEACHERS_F.php",
      dataType: "json",
      success: function (data, status) {
          var container = $(".append_teacher_card");
          container.empty(); // Clear existing cards

          if (data && data.length > 0) {
              $.each(data, function (i, teacher) {
                  var card = $('<div class="col">').append(
                      $('<div class="card">').append(
                          $('<img>', {
                              src: teacher.profile_pic || "../devimage/logo.png",
                              class: "card-img-top rounded-circle mx-auto d-block mt-3",
                              alt: teacher.firstname + " " + teacher.lastname,
                              style: "width: 100px; height: 100px; object-fit: cover;"
                          }),
                          $('<div class="card-body text-center">').append(
                              $('<h5 class="card-title">').text(teacher.firstname + " " + teacher.middlename + " " + teacher.lastname),
                              $('<p class="card-text">').html("Staff ID: <span>" + teacher.staffid + "</span>"),
                              $('<p class="card-text">').html("Class Taught: <span>" + teacher.class_name + "</span>"),
                              $('<p class="card-text">').html("Number of Students: <span>" + teacher.student_count + "</span>"),
                              $('<p class="card-text">').html("Last Visit Date: <span>" + teacher.recdate + "</span>"),
                              $('<p class="card-text">').html("Student Report Status: <span>Pending</span>")
                          )
                      )
                  );
                  container.append(card);
              });
          } else {
              // Display message if no teachers are available
              var noTeacherCard = $('<div class="col">').append(
                  $('<div class="card">').append(
                      $('<div class="card-body text-center">').append(
                          $('<h5 class="card-title">').text("No Teacher Is Available"),
                          $('<p class="card-text">').text("Register new teacher and students. A teacher must have at least one student.")
                      )
                  )
              );
              container.append(noTeacherCard);
          }
      },
      error: function (xhr, status, error) {
          showToast("aeToastE", "Load Error", "Failed to load teacher data.", "20");
      },
  });
}

  
  $(document).ready(function(){
    fetchTeachers();


    $(document).on('click', '.append_teacher_card .card', function() {
      var staff_id = $(this).find('.card-text span').first().text();

     
    
      $.ajax({
        type: "post",
        cache: false,
        url: "TEACHER_LOGIN.php",
        data: { staff_id: staff_id },
        dataType: "text",
        success: function (response) {

          // IF RESPONSE INCLUDE not found return
          if(response.includes("not found")) {
           // showToast("aeToastE", "Error", "Teacher not found.", "20");
            return;
          }
          console.log(response);
        //  alert(response);
          showToastY(
            "aeToastY",
            "Visit Teacher Page",
            "Do you want to visit the selected teacher's page?",
            "20",
            function() { // Yes option
           //  openPage("../teacher/page.php")
          // replace the current window
          window.location.replace("../teacher/page.php");
            }, 
            function() { // No option
              // Handle the no option if needed
            }
          );
        },
        error: function (xhr, status, error) {
          showToast("aeToastE", "Error", "There was an error processing your request.", "20");
        }
      });
      
    });
    
    
  });
  