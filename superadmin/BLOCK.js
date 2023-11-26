


$(document).ready(function () {
    var users = [];
  

    // Load user data on page load
    $.ajax({
        type: "post",
        cache: false,
        url: "BLOCK_FETCH.php", // Use the correct path to your PHP file
        dataType: "json",
        success: function (data) {
            console.log(data);

            if (data.success) {
                users = data.users;
            } else {
                showToast("aeToastE", "Error", "Failed to fetch user data.", "20");
            }
        },
        error: function (xhr, status, error) {
            showToast("aeToastE", "Error", "An error occurred while fetching user data.", "20");
        }
    });

    // Function to filter users based on input and update suggestions
    function filterStudentSuggestions(inputVal) {
        var filteredStudents = users.filter(function (user) {
            var studentNameWithNumber = user.user_id + '-' + user.fullname+ '-' + user.user_type;
            return studentNameWithNumber.toLowerCase().includes(inputVal.toLowerCase());
        });

        var $suggestionList = $('#super_admin_block_search_admission_suggestion');
        $suggestionList.empty();
        if (filteredStudents.length) {
            filteredStudents.forEach(function (user) {
                var studentDisplayText = user.user_id + ' - ' + user.fullname + ' (' + user.user_type + ')';
                $suggestionList.append(
                    $('<li>').addClass('list-group-item')
                              .text(studentDisplayText)
                              .data('userDetails', user) // Store all user details in the jQuery data object
                              .click(function() {
                                  var selectedUser = $(this).data('userDetails');
                                //  $('#super_admin_block_search_input').val(selectedUser.user_id + '-' + selectedUser.fullname + '-' + selectedUser.user_type);
                                  $suggestionList.empty(); // Clear suggestions after selection
                                  // place only the staffid in this input field  #reset_user_userId
                                    $('#reset_user_userId').val(selectedUser.user_id);
                                    // set readonly
                                    $('#reset_user_userId').attr('readonly', true);


                               
                                  fetchBlockStatus(selectedUser.user_id, selectedUser.user_type,selectedUser.fullname,  selectedUser.profile_pic,  selectedUser.mobile, selectedUser.email);
                              })
                );
            });
        } else {
            $suggestionList.append(
                $('<li>').addClass('list-group-item').text('No matches found')
            );
        }
    }

    // Event listener for the search input
    $('#super_admin_block_search_input').on('input', function () {
        $('#block_user_card').addClass('d-none');
        var inputVal = $(this).val();
        filterStudentSuggestions(inputVal);
        $('#super_admin_block_search_admission_list').toggleClass('d-none', inputVal.length === 0);
    });
});
function processSelectedUser(userId, fullName, userType, profilePic, mobile, email) {
    $('#block_user_card').removeClass('d-none');

    var profileImageSrc = profilePic ? profilePic : "../devimage/logo.png";
    $('#image_src_for_block').attr('src', profileImageSrc).attr('alt', 'User Profile Picture');

    // Split fullName into first, middle, and last names
    var names = fullName.split(' ');
    var firstName = names[0];
    var lastName = names.length > 1 ? names[names.length - 1] : '';
    var middleName = names.slice(1, -1).join(' ');

    // Update input fields
    $('#firstName').val(firstName);
    $('#middleName').val(middleName);
    $('#lastName').val(lastName);


    // Update text content of the respective spans
    $('#block_user_full_name').text(fullName);
    $('#userId').text(userId);
    $('#userType').text(userType);


    $('#phoneNumber').val(mobile);
    $('#email').val(email);






}


function sendBlockRequest() {
    aeLoading()

    var userId = $('#userId').text();
    var userType = $('#userType').text();

    $.ajax({
        type: "post",
        cache: false,
        url: "BLOCK_USER.php",
        data: { userId: userId, userType: userType },
        dataType: "text",
        success: function (response) {
            aeLoading()

 
        }
    });
}


$('#blockUserSwitch').change(function() {
    sendBlockRequest();

});



function fetchBlockStatus(staffId, userType,fullName, profilePic, mobile, email) {
    $.ajax({
        type: "post",
        url: "BLOCK_STATUS.php", // Path to your PHP script
        data: { user_id: staffId, user_type: userType },
        dataType: "json",
        success: function(response) {
            console.log(response);

            processSelectedUser(staffId, fullName, userType, profilePic, mobile, email);
            if (response.success) {
                // Update the switch based on block status
                $('#blockUserSwitch').prop('checked', response.block_status === 1);
            } else {
                $('#blockUserSwitch').prop('checked', false);
                
            }
        },
        error: function(xhr, status, error) {
            showToast("aeToastE", "Error", "An error occurred while fetching block status.", "20");
        }
    });
}

// Example usage

