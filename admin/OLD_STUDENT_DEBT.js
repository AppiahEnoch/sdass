$(document).ready(function () {
    var globalStudentId = "";
    // Set date to current date
    var currentDate = new Date().toISOString().substr(0, 10);
    $('#payment_date_input').val(currentDate);

    var users = [];

    // Load data on page load
    $.ajax({
        type: "post",
        cache: false,
        url: "STUDENT_FETCH.php", // Use the correct path to your PHP file
        dataType: "json", // Change data type to json
        success: function (data) {
            if (data.success) {
                users = data.students; // Use 'students' to match PHP output
            } else {
                showToast("aeToastE", "Error", "Failed to fetch data.", "20");
            }
        },
        error: function (xhr, status, error) {
            showToast("aeToastE", "Error", "An error occurred while fetching data.", "20");
        }
    });

    // Function to filter data based on input
// Function to filter data based on input
// Function to filter data based on input
function filterDataSuggestions(inputVal) {
    if (!Array.isArray(users)) { return; } // Guard clause to check if users is an array

    var filteredUsers = users.filter(function (user) {
        return user.fullname.toLowerCase().includes(inputVal.toLowerCase()) ||
               user.admission_number.toString().includes(inputVal);
    });

    $('#students_old_debt_payment_suggestion').empty();
    if (filteredUsers.length) {
        filteredUsers.forEach(function (user) {
            var listItemText = user.admission_number + '-' + user.fullname; // Concatenate admission number with fullname
            $('#students_old_debt_payment_suggestion').append(
                $('<li>')
                  .addClass('list-group-item')
                  .text(listItemText)
                  .data('admission-number', user.admission_number) // Store admission number in data attribute
            );
        });
    } else {
        $('#students_old_debt_payment_suggestion').append(
            $('<li>').addClass('list-group-item').text('No matches found')
        );
    }
}

// Event listener for click on suggestion items
$('#students_old_debt_payment_suggestion').on('click', 'li', function() {
    // hide suggestions
    $('#students_old_debt_payment_list').addClass('d-none');
    var admissionNumber = $(this).data('admission-number');
    var fullname = $(this).text().split('-').slice(3).join('-'); // Extract fullname from the text

    // Use admissionNumber and fullname as needed
    console.log('Selected Admission Number:', admissionNumber);
    console.log('Selected Full Name:', fullname);
    $("#selected_student_name").text(fullname);
    $("#student_id_input").val(admissionNumber);

    // Optionally, you can do something with the selected values here
});

// Rest of your existing code...


    // Event listener for the search input
    $('#students_old_debt_payment_search_input').on('input', function () {
     
        var inputVal = $(this).val();
      
        filterDataSuggestions(inputVal);
        $('#students_old_debt_payment_list').toggleClass('d-none', inputVal.length === 0);
    });
});




    $(document).ready(function () {
        loadStudentDebts("");
        var users = [];

        // Load data on page load
        $.ajax({
            type: "post",
            cache: false,
            url: "STUDENT_FETCH.php",
            dataType: "json",
            success: function (data) {
                if (data.success) {
                    users = data.students;
                } else {
                    showToast("aeToastE", "Error", "Failed to fetch data.", "20");
                }
            },
            error: function (xhr, status, error) {
                showToast("aeToastE", "Error", "An error occurred while fetching data.", "20");
            }
        });

        // Function to filter data based on input
        function filterDataSuggestions(inputVal) {
            if (!Array.isArray(users)) {
                return;
            }

            var filteredUsers = users.filter(function (user) {
                return (
                    user.fullname.toLowerCase().includes(inputVal.toLowerCase()) ||
                    user.admission_number.toString().includes(inputVal)
                );
            });

            var suggestionList = $('#students_old_debt_payment_suggestion');
            suggestionList.empty();

            if (filteredUsers.length) {
                filteredUsers.forEach(function (user) {
                    var listItemText = user.admission_number + '-' + user.fullname;
                    suggestionList.append(
                        $('<li>')
                            .addClass('list-group-item')
                            .text(listItemText)
                            .data('admission-number', user.admission_number)
                    );
                });
            } else {
                suggestionList.append(
                    $('<li>').addClass('list-group-item').text('No matches found')
                );
            }
        }

        // Event listener for click on suggestion items
        $('#students_old_debt_payment_suggestion').on('click', 'li', function () {
            // clear table
            $('#admin_add_student_old_debt_wrapper .table tbody').empty();
            $('#students_old_debt_payment_list').addClass('d-none');
            var admissionNumber = $(this).data('admission-number');
            var fullname = $(this).text().split('-').slice(3).join('-');
            loadStudentDebts(admissionNumber)
            globalStudentId = admissionNumber;

            $("#selected_student_name").text(fullname);
            $("#student_id_input").val(admissionNumber);
        });

        // Event listener for the search input
        $('#students_old_debt_payment_search_input').on('input', function () {
            var inputVal = $(this).val();
            filterDataSuggestions(inputVal);
            $('#students_old_debt_payment_list').toggleClass('d-none', inputVal.length === 0);
        });

        // Event listener for form submission
        $('#student_debt_payment_form').submit(function (e) {
            e.preventDefault();

            var studentId = $('#student_id_input').val();
            var debtAmount = $('#debt_amount_input').val();
            var paymentDate = $('#payment_date_input').val();
          var debt_description_input = $('#debt_description_input').val();
        //  alert(debt_description_input);

            // Validate form data
            if (aeEmpty(studentId)) {

                showToast("aeToastE", "Error", "Please select a student.", "20");
                return;
            }

            if (debtAmount < 1) {
                showToast("aeToastE", "Error", "Amount must be greater than zero.", "20");
                return;
            }

            $.ajax({
                type: "POST",
                url: "OLD_STUDENT_DEBT_INSERT.php",
                data: {
                    admission_number: studentId,
                    amount: debtAmount,
                    debt_date: paymentDate,
                    description: debt_description_input,
                },
                dataType: "json",
                success: function (response) {
             
                    // reset form
                    $('#student_debt_payment_form')[0].reset();

                    loadStudentDebts('');
                    $("#selected_student_name").text("");

              
             
                    if (response.success) {
                        showToast("aeToastS", "Success", "Student Old Debt recorded successfully.", "20");
                    } else {
                        showToast("aeToastE", "Error", response.message, "20");
                    }
                },
                error: function () {
                    showToast("aeToastE", "Error", "An error occurred while submitting the form.", "20");
                }
            });
        });
    });








function loadStudentDebts(studentId) {
    $.ajax({
        type: "post",
        cache: false,
        url: "OLD_STUDENT_DEBT_FETCH.php",
        data: { id: studentId },
        dataType: "json",
        success: function (data, status) {
           // alert(data);
            var tbody = $("#admin_add_student_old_debt_wrapper .table tbody");
            tbody.empty(); // Clear existing rows
            var totalRecords = 0;
            var totalAmount = 0;
            $.each(data, function (i, debt) {
                var row = $("<tr>").append(
                    $("<td>").text(debt.admission_number),
                    $("<td>").text(debt.amount),
                    $("<td class='ae-print-only'>").text(debt.system_user),
                    $("<td>").append(
                        $("<button>", {
                            class: "btn btn-danger",
                            html: '<i class="fa fa-trash"></i>',
                            click: function () { deleteUser(debt.id); }
                        })
                    )
                );
                tbody.append(row);
                totalRecords++;
                totalAmount += parseFloat(debt.amount);
            });

           // alert(totalAmount);
            $("#total_records").text(totalRecords);
            $("#total_amount").text(totalAmount.toFixed(2));
        },
        error: function (xhr, status, error) {
            showToast("aeToastE", "Load Error", "Failed to load student debts.", "20");
        },
    });
}

function deleteUser(debtId) {
    // Show custom yes/no toast
    showToastY(
        "aeToastY",
        "Confirm Deletion",
        "Are you sure you want to delete this debt record?",
        "20",
        function() { // Yes option
            $.ajax({
                type: "post",
                url: "OLD_STUDENT_DEBT_DEL.php", // Path to your PHP script
                data: { id: debtId },
                dataType: "json",
                success: function(response) {
                    if (response.success) {
                        showToast("aeToastS", "Success", "Debt record deleted successfully.", "20");
                        // Refresh the debts list
                        var studentId = $('#student_id_input').val();
                        loadStudentDebts(studentId);
                    } else {
                        showToast("aeToastE", "Error", "Failed to delete debt record.", "20");
                    }
                },
                error: function(xhr, status, error) {
                    showToast("aeToastE", "Error", "An error occurred while deleting the debt record.", "20");
                }
            });
        },
        function() { // No option
            // Optionally handle the no option if needed
        }
    );
}



//  id="print_old_debt"
function printStudentDebts() {
    const printWindow = window.open("", "", "height=600,width=800");
    printWindow.document.write(`
        <html>
            <head>
                <title>DEBTORS ARREARS ENTRY</title>
                <style>
                    table {
                        width: 100%;
                        border-collapse: collapse;
                    }
                    th, td {
                        border: 1px solid black;
                        padding: 5px;
                        text-align: left;
                    }
                    .total-row td {
                        color: black;
                        font-weight: bold;
                        border: none; /* No border for total row cells */
                    }
                    .ae-print-only {
                        display: table-cell;
                    }
                </style>
            </head>
            <body>
                <h2 style="text-align:center;">DEBTORS ARREARS ENTRY</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Amount</th>
                            <th class="ae-print-only">System User</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${$("#admin_add_student_old_debt_wrapper .table tbody tr").map(function() {
                            const id = $(this).find("td:eq(0)").text();
                            const amount = parseFloat($(this).find("td:eq(1)").text());
                            const systemUser = $(this).find("td.ae-print-only").text();
                            return `<tr><td>${id}</td><td>${amount.toFixed(2)}</td><td class="ae-print-only">${systemUser}</td></tr>`;
                        }).get().join("")}
                        <tr class="total-row">
                            <td colspan="2">Total Records:</td>
                            <td>${$("#admin_add_student_old_debt_wrapper .table tbody tr").length}</td>
                        </tr>
                        <tr class="total-row">
                            <td colspan="2">Total Amount:</td>
                            <td>${$("#admin_add_student_old_debt_wrapper .table tbody tr").map(function() {
                                return parseFloat($(this).find("td:eq(1)").text());
                            }).get().reduce((total, amount) => total + amount, 0).toFixed(2)}</td>
                        </tr>
                    </tbody>
                </table>
            </body>
        </html>
    `);
    printWindow.document.close();
    printWindow.focus(); // For some browsers
    setTimeout(function() { printWindow.print(); }, 1000); // Delay for loading content
}



// Add onclick event to print button
$("#print_old_debt").on("click", function() {
    printStudentDebts();
});

  
