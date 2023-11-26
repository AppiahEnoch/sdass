var id = 0;

$(document).ready(function () {

  getID();


  $("#form1").on("submit", function (e) {
    e.preventDefault();
    reset();


  });
});

function reset() {
  // Collecting the input data from the form
  var username = $("#username").val();
  var password = $("#password").val();
  var confirmPassword = $("#confirmPassword").val();
 

  

  if (!passwordConfirm(password, confirmPassword)) {
    showToast(
      "aeToastE",
      "PASSWORD MISMATCH",
      "Confirm Password does not match with password",
      "20"
    );

    return;
  }



  // Sending the data to reset.php using AJAX



 
  $.ajax({
    type: "post",
    data: {
      username: username,
      password: password,
      id: id, // Including the index number in the request
    },
    cache: false,
    url: "reset.php", // Path to your PHP file
    dataType: "text",
    success: function (data, status) {
     // alert(data)

      showToastYN("aeToastYN", "SUCCESS!","YOUR USERNAME AND PASSWORD RESET IS SUCCESSFUL !", "20");
     

    },
    error: function (xhr, status, error) {
      // Handle any errors
      // alert(error);
    },
  });
}



function getID() {
  $.ajax({
    type: "post",
    data: {
      id: "none",
    },
    cache: false,
    url: "selectID.php",
    dataType: "text",
    success: function (data, status) {
      id = data;
      // trim id
      id = id.trim();

 


    },
    error: function (xhr, status, error) {
      // alert(error);
    },
  });
}








//  showToastYN("aeToastYN", "Confirm Delete All.", "Are you sure you want to delete all registration codes?", "20");
 



function handleYesClick() {

  openPage("../index.php")

}









//  

