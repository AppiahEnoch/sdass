// JavaScript function to fetch users on page load and provide suggestions
var audience=null;
 var staffId = null;








// 


function create_individual_teacher_card(messages) {
    $('.individual_teacher_messages').empty(); // Clear the existing cards
  
    $.each(messages, function (index, message) {
      var cardHtml = 
        '<div class="col-12 col-sm-6 col-md-4 ">' +
        '  <div class="card ae-message-card">' +
        '    <div class="card-header d-flex justify-content-between align-items-center">' +
        '      <h5 class="mb-0"><span class="text-primary"><i class="fa fa-comments" aria-hidden="true"></i></span> <span class="receiver_fullname">' + message.receiver_fullname + '</span></h5>' +
        '      <i class="d-none fas fa-trash-alt small"></i>' +
        '    </div>' +
        '    <div class="card-body">' +
        '      <h5 class="card-subtitle mb-2 message_title">' + message.message_title + '</h5>' +
        '      <p class="card-text message_body">' + message.message_body + '</p>' +
        '    </div>' +
        '    <div class="ae-card-footer">' + // Footer div added
        '      <p class="del_id d-none">' + message.id + '</p>' +
        '      <p class="db_tb d-none">' + message.tb + '</p>' +
        '      <p class="card-text sender_name">From: ' + message.sender_fullname + '</p>' +
        '      <p class="card-text sender_name">Date: ' + message.recdate + '</p>' +
        
        '    </div>' + // End of footer div
        '  </div>' +
        '</div>';
  
      $('.individual_teacher_messages').append(cardHtml); // Append the new card
    });
  }
  

function create_group_card(messages) {
    $('.all_group_messages').empty(); // Clear the existing cards

    $.each(messages, function (index, message) {
        var receiver_fullname = message.receiver_fullname.replace(/_/g, " ").toUpperCase();
        
        var cardHtml = 
            '<div class="col-12 col-sm-6 col-md-4">' +
            '  <div class="card ae-message-card">' +
            '    <div class="card-header d-flex justify-content-between align-items-center">' +
            '      <h5 class="mb-0"><span class="text-primary"><i class="fa fa-comments" aria-hidden="true"></i></span> <span class="receiver_fullname">' + receiver_fullname + '</span></h5>' +
            '      <i class="d-none fas fa-trash-alt small"></i>' +
            '    </div>' +
            '    <div class="card-body">' +
            '      <h5 class="card-subtitle mb-2 message_title">' + message.message_title + '</h5>' +
            '      <p class="card-text message_body">' + message.message_body + '</p>' +
            '    </div>' +
            '    <div class="ae-card-footer">' + // Added card-footer div
            '      <p class="del_id d-none">' + message.id + '</p>' +
            '      <p class="db_tb d-none">' + message.tb + '</p>' +
            '      <p class="card-text sender_name">From: ' + message.sender_fullname + '</p>' +
            '      <p class="card-text sender_name">Date: ' + message.recdate + '</p>' +
        
            '    </div>' + // End of card-footer div
            '  </div>' +
            '</div>';
    
        $('.all_group_messages').append(cardHtml);
    });
    
}
function create_individual_student_card(messages) {
    $('.individual_student_messages').empty(); // Clear the existing cards
  
    $.each(messages, function (index, message) {
      var cardHtml = 
        '<div class="col-12 col-sm-6 col-md-4">' +
        '  <div class="card ae-message-card">' +
        '    <div class="card-header d-flex justify-content-between align-items-center">' +
        '      <h5 class="mb-0"><span class="text-primary"><i class="fa fa-comments" aria-hidden="true"></i></span> <span class="receiver_fullname">' + message.receiver_fullname + '</span></h5>' +
        '      <i class="fas fa-trash-alt small"></i>' +
        '    </div>' +
        '    <div class="card-body">' +
        '      <h5 class="card-subtitle mb-2 message_title">' + message.message_title + '</h5>' +
        '      <p class="card-text message_body">' + message.message_body + '</p>' +
        '    </div>' +
        '    <div class="ae-card-footer">' + // Footer div added
        '      <p class="del_id d-none">' + message.id + '</p>' +
        '      <p class="db_tb d-none">' + message.tb + '</p>' +
        '      <p class="card-text sender_name">From: ' + message.sender_fullname + '</p>' +
        '      <p class="card-text sender_name">Date: ' + message.recdate + '</p>' +
        '    </div>' + // End of footer div
        '  </div>' +
        '</div>';
  
      $('.individual_student_messages').append(cardHtml); // Append the new card
    });
  }
  



$(document).ready(function () {
    
$.ajax({
    type: "post",
    cache: false,
    url: "MESSAGE_FETCH.php", // Use the correct path to your PHP file
    dataType: "json",
    success: function (response) {
        if (response.success) {
         
            create_individual_teacher_card(response.non_student_messages);
        //    create_individual_student_card(response.student_messages);
            create_group_card(response.group_messages);
        } else {
            showToast("aeToastE", "Error", "No messages found.", "20");
        }
    },
    error: function (xhr, status, error) {
        showToast("aeToastE", "Error", "An error occurred while fetching messages.", "20");
    }
});
    
    } );





    function deleteMessage(event) {
        var card = $(event.currentTarget).closest('.card');
        var id = card.find('.del_id').text();
        var tb = card.find('.db_tb').text();
      
        showToastY(
          "aeToastY",
          "Confirm Deletion",
          "Are you sure you want to delete this message?",
          "20",
          function() {
            // Add Ajax call or any other logic to delete the message
            $.ajax({
              type: "post",
              cache: false,
              url: "MESSAGE_DEL.php", // Your endpoint to handle deletion
              dataType: "json",
              data: {
                id: id,
                tb: tb
              },
              success: function (data, status) {
                if (status === 'success') {
                  card.remove(); // Remove the card from the DOM
                  showToast("aeToastS", "Deletion Successful", "The message has been deleted.", "20");
                }
              },
              error: function (xhr, status, error) {
                console.error(error);
                showToast("aeToastE", "Error", "There was a problem deleting the message.", "20");
              },
            });
          },
          function() {
            // Logic for cancellation
            showToast("aeToastE", "Cancelled", "Message deletion cancelled.", "20");
          }
        );
      }
      
      $(document).on('click', '.fa-trash-alt', deleteMessage);
      