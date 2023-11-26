function loadUserDetails() {
    // Get details from the DOM
    const staffID = document.getElementById("staffID").textContent.trim();
    const userFullName = document.getElementById("userFullName").textContent.trim();
    const userProfilePicSrc = document.getElementById("userProfilePic").src;
    const p_email = document.getElementById("p_email").textContent.trim();

    // Get elements in the modal
    const userNameElement = document.getElementById("userName");
    const staffIdElement = document.getElementById("staffId");
    const userEmailElement = document.getElementById("userEmail");
    const userImageElement = document.getElementById("userImage");

    const userNameBriefElement = document.getElementById("userNameBrief");
    const staffIdBriefElement = document.getElementById("staffIdBrief");
    const userEmailBriefElement = document.getElementById("userEmailBrief");

    // Populate modal elements
    userNameElement.textContent = `Username: ${userFullName}`;
    staffIdElement.textContent = `Staff ID: ${staffID}`;
    userEmailElement.textContent = `Email:`+p_email;  // Replace with actual email
    userImageElement.src = userProfilePicSrc;

}

// Attach the function to the modal show event
$('#userDetailsModal').on('shown.bs.modal', function () {
    loadUserDetails();
});
;



$(document).ready(function () {

    // click event for theis id userProfilePic
    $('#userProfilePic').click(function () {
        $('#userDetailsModal').modal('show');
    });

});


function searchFunction() {
    const inputValue = $(".search-input").val().toLowerCase();
  
    $(".activity-card").hide().filter(function() {
      return $(this).find(".card-text").text().toLowerCase().indexOf(inputValue) > -1;
    }).show();
  }
  
  $(document).ready(function() {
    $(".search-input").on("keyup", function() {
      searchFunction();
    });
  });
  

  $(document).ready(function() {
    $('#selectAll').change(function() {
      var isChecked = $(this).is(':checked');
      $('.ae-check-box input[type="checkbox"]').each(function() {
        $(this).prop('checked', isChecked);
      });
    });
  });
  