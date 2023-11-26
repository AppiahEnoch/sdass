$(document).ready(function() {
  
    $.ajax({
      type: "post",
      cache: false,
      url: "footer_F.php",
      dataType: "json",
      success: function(data, status) {
        if (data.success) {
          $(".custom-footer #email").text(data.email);
          $(".custom-footer #mobile").text(data.mobile);
          $(".custom-footer #location").text(data.location);
        } else {
          showToast("aeToastE", "Error", "Failed to fetch footer information.", "20");
        }
      },
      error: function(xhr, status, error) {
        console.error(error);
        showToast("aeToastE", "Error", "Something went wrong.", "20");
      },
    });
  });
  