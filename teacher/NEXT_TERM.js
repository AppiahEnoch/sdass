$(document).ready(function() {
    $("#next_term_customForm").submit(function(event) {
      event.preventDefault();
      const formData = {
        nextTermBeginsDate: $("#nextTermBeginsDate").val(),
        user_id: 1 // Replace with the actual user ID
      };
  
      aeLoading();
      $.ajax({
        type: "post",
        cache: false,
        url: "NEXT_TERM_INSERT.php",
        data: formData,
        dataType: "json",
        success: function(data, status) {
            aeLoading();
            fetchNextTermDate()
          if (data.success) {
            showToast("aeToastS", "Success", "Next term date has been set.", "20");
          } else {
            showToast("aeToastE", "Error", "Failed to set next term date.", "20");
          }
        },
        error: function(xhr, status, error) {
            aeLoading();
          console.error(error);
          showToast("aeToastE", "Error", "Something went wrong.", "20");
        },
      });
    });
  });
  


  // Fetch and set next_term_date
  function fetchNextTermDate() {
    aeLoading();
    $.ajax({
      type: "post",
      cache: false,
      url: "NEXT_TERM_F.php",
      dataType: "json",
      success: function (data, status) {
        aeLoading();
        $("#next_term_date").text(` ${data.next_term_date}`);
      },
      error: function (xhr, status, error) {
        aeLoading();
        showToast("aeToastE", "Error", "Failed to fetch next term date.", "20");
      },
    });
  }
  
  
  $(document).ready(function () {

    fetchNextTermDate();

    $("#set_next_term_cancel").click(function () {  
      $("#next_term_customForm")[0].reset();
    });
  });
  
