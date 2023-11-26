// JavaScript function to fetch users on page load and provide suggestions
var audience=null;
 var staffId = null;

$(document).ready(function () {

    // admin_send_message_form submit handler
    $('#admin_send_message_form').submit(function (e) {
        e.preventDefault();
        var message = $('#admin_send_message_body').val();
        var messageTitle = $('#admin_send_message_title').val();
        var audience = $('#admin_send_message_target').val();

        if(aeEmpty(message) || aeEmpty(messageTitle)){
            alert(messageTitle)
            alert(message);
            showToast("aeToastE", "Error", "Please fill all fields.", "20");
            return;
        }

        if(audience === null && staffId === null){
            showToast("aeToastE", "Error", "Please select an audience.", "20");
            return;
        }


        if(aeEmpty(audience)){
            insert_individual_message(message, messageTitle, staffId)
        }
        else{
            insert_group_message(message, messageTitle, audience)

        }


    });




















    var users = [];

    // Load user data on page load
    $.ajax({
        type: "post",
        cache: false,
        url: "TEACHER_FETCH.php", // Use the correct path to your PHP file
        dataType: "json",
        success: function (data) {
            if (data.success) {
                users = data.users;
            } else {
                showToast("aeToastE", "Error", "Failed to fetch data.", "20");
            }
        },
        error: function (xhr, status, error) {
            showToast("aeToastE", "Error", "An error occurred while fetching data.", "20");
        }
    });

    // Function to filter users based on input and switch state
    function filterUserSuggestions(inputVal) {
        var isTeacherSwitchOn = $('#admin_send_message_teacher_switch').is(':checked');
        var filteredUsers = users.filter(function (user) {
            var nameMatch = user.fullname.toLowerCase().includes(inputVal.toLowerCase());
            var idMatch = user.user_id.toLowerCase().includes(inputVal.toLowerCase());
            if (isTeacherSwitchOn) {
                return (nameMatch || idMatch) && user.user_type !== 'student';
            } else {
                return (nameMatch || idMatch) && user.user_type === 'student';
            }
        });
    
        $('#admin_send_message_admission_suggestion').empty();
        if (filteredUsers.length) {
            filteredUsers.forEach(function (user) {
                var displayName = user.user_id + '_' + user.fullname.toUpperCase();
                $('#admin_send_message_admission_suggestion').append(
                    $('<li>').addClass('list-group-item').data('user-id', user.user_id).text(displayName)
                );
            });
        } else {
            $('#admin_send_message_admission_suggestion').append(
                $('<li>').addClass('list-group-item').text('No matches found')
            );
        }
    }
    

    // Event listener for the search input
    $('#admin_send_message_search_input').on('input', function () {
        $('#selected_target_name').text('');
        var inputVal = $(this).val();
        filterUserSuggestions(inputVal);
        $('#admin_send_message_admission_list').toggleClass('d-none', inputVal.length === 0);
    });

    // Event listener for the teacher switch
    $('#admin_send_message_teacher_switch').change(function () {
        $('#selected_target_name').text('');
        $('#admin_send_message_search_input').trigger('input');
    });

    $(document).on('click', '#admin_send_message_admission_suggestion .list-group-item', function () {
         staffId = $(this).data('user-id'); // Corrected data attribute
      // get the full name only user.fullname.toUpperCase()
      var staffName = $(this).text().split('_')[1];

      //    <h5 class="text-center" id="selected_target_name"> </h5>
        $('#selected_target_name').text("TO: "+ staffName);
        audience = null;
        
   

       
        showToast( "aeToastS", "User Selected", staffId, "20"); // Using custom toast for alert
        $('#admin_send_message_search_input').val(staffId);
        $('#admin_send_message_admission_list').addClass('d-none');
    });
    


    $('#admin_send_message_target').change(function() {
        var audience = $(this).val();
        staffId = null;
        $('#selected_target_name').text('');
        $('#admin_send_message_search_input').val('');
      
        // Add the code to handle the selection
        showToast("aeToastS", "Audience Selected", "You have selected " + audience, "20");
      });
      
    





});




function insert_individual_message(message, messageTitle, staffId) {

    $.ajax({
        type: "post",
        cache: false,
        url: "MESSAGE_IND_INSERT.php", // Use the correct path to your PHP file
        data: {
            message: message,
            messageTitle: messageTitle,
            staffId: staffId
        },
        dataType: "json",
        success: function (data) {
           // alert(data);
            console.log(data);
            if (data.success) {
                showToast("aeToastS", "Success", "Message sent successfully.", "20");
                $('#admin_send_message_form').trigger('reset');
        
            } else {
                showToast("aeToastE", "Error", "Failed to send message.", "20");
            }
        },
        error: function (xhr, status, error) {
            showToast("aeToastE", "Error", "An error occurred while sending message.", "20");
        }
    });
}


function insert_group_message(message,messageTitle, audience){
    
        $.ajax({
            type: "post",
            cache: false,
            url: "MESSAGE_GROUP_INSERT.php", // Use the correct path to your PHP file
            data: {
                message: message,
                messageTitle: messageTitle,
                audience: audience
            },
            dataType: "json",
            success: function (data) {
                if (data.success) {
                    showToast("aeToastS", "Success", "Message sent successfully.", "20");
                    $('#admin_send_message_form').trigger('reset');
               
                } else {
                    showToast("aeToastE", "Error", "Failed to send message.", "20");
                }
            },
            error: function (xhr, status, error) {
                showToast("aeToastE", "Error", "An error occurred while sending message.", "20");
            }
        });

}




// 


function create_individual_teacher_card(messages) {
    $('.individual_teacher_messages').empty(); // Clear the existing cards
  
    $.each(messages, function (index, message) {
      var cardHtml = 
        '<div class="col-12 col-sm-6 col-md-4 mb-2">' +
        '  <div class="card ae-message-card">' +
        '    <div class="card-header d-flex justify-content-between align-items-center">' +
        '      <h5 class="mb-0"><span class="text-primary"><i class="fa fa-comments" aria-hidden="true"></i></span> <span class="receiver_fullname">' + message.receiver_fullname + '</span></h5>' +
        '      <i class=" fas fa-trash-alt small"></i>' +
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
            '<div class="col-12 col-sm-6 col-md-4 mb-2">' +
            '  <div class="card ae-message-card">' +
            '    <div class="card-header d-flex justify-content-between align-items-center">' +
            '      <h5 class="mb-0"><span class="text-primary"><i class="fa fa-comments" aria-hidden="true"></i></span> <span class="receiver_fullname">' + receiver_fullname + '</span></h5>' +
            '      <i class="fas fa-trash-alt small"></i>' +
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
        '<div class="col-12 col-sm-6 col-md-4 mb-2">' +
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
        '      <p class="db_tb d-none m-1">' + message.tb + '</p>' +
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
            create_individual_student_card(response.student_messages);
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
      
      $(document).on('click', '.ae-message-card .fa-trash-alt', deleteMessage);
      