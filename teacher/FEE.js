$(document).ready(function() {
    //#fee_cancel
    $('#fee_cancel').click(function() {

        // reset form
        $('#feeForm')[0].reset();
       
    });

    $('#paymentType1').change(function() {

        if ($(this).val() === 'other Payment') {
            $('#otherPaymentDescriptionDiv').removeClass('d-none');
            $('#otherPaymentDescription').attr('required', true);
        } else {
            $('#otherPaymentDescriptionDiv').addClass('d-none');
            $('#otherPaymentDescription').removeAttr('required');
        }
    });
});

$(document).ready(function () {
    $("#fee_search").on("input", function () {
        const tableBody = $(".student_payment_table tbody");
        tableBody.empty();

        if ($(this).val().trim() !== "") {
            $("#payee-list").removeClass("d-none");
        } else {
            $("#payee-list").addClass("d-none");
        }
    });
});

var payer_admission_number = null;
$(document).ready(function () {
  

    $("#payee-suggestion").on("click", "li", function() {
        var textContent = $(this).text();
        var splitText = textContent.split(' - ');
        payer_admission_number = splitText[0];
        var fullName = splitText[1];

        fetchPayments(payer_admission_number)
  
    

   
        $("#payer").text(fullName);

        // hide suggestion box
        $("#payee-list").addClass("d-none");


    });
});




$(document).ready(function () {
  

    $("#feeForm").on("submit", function (e) {
        // Prevent the form from actually submitting
        e.preventDefault();
    
        if(aeEmpty(payer_admission_number)) {
            showToast("aeToastE", "Error", "Please select a Payer(Student).", "20");
            return;
        }
        
        var paymentType = $("#paymentType1").val();
        var otherPaymentDescription = $("#otherPaymentDescription").val();

        if(aeEmpty(otherPaymentDescription)) {
       
        }
        else{
          // convert to lowercase
          otherPaymentDescription = otherPaymentDescription.toLowerCase();
        }

        
        var student_payment_amount = parseFloat($("#student_payment_amount").val()); 

      //  alert(paymentType)
    
        // Validation checks
        if (paymentType === "0") {
            showToast("aeToastE", "Error", "Please select a payment type.", "20");
            return;
        }
        if (paymentType === "otherPayment" && !otherPaymentDescription) {
            showToast("aeToastE", "Error", "Please describe the other payment.", "20");
            return;
        }
        if (student_payment_amount <= 0) {
            showToast("aeToastE", "Error", "Payment amount should be greater than 0.", "20");
            return;
        }


        var receiptValue = $("#student_payment_receiptId").val();
        if (isNumeric(receiptValue) == false) {
          showToast("aeToastE", "Invalid Receipt ID", "INVALID RECEIPT ID.", "20");
          // clear input
          $("#student_payment_receiptId").val("");
          // set focus
          $("#student_payment_receiptId").focus();
          return;
        }


    
        if (receiptValue.length > 3 && receiptValue.length <= 4) {
        
        }
        else{
          showToast("aeToastE", "Invalid Receipt ID", "The value must be 4  characters long", "20");
          $("#student_payment_receiptId").val("");
          // set focus
          $("#student_payment_receiptId").focus();
          return;
        }











        aeLoading()

   // alert (paymentType)
    
        // Send the data as variables
        $.ajax({
            type: "post",
            cache: false,
            url: "FEE_INSERT.php",
            data: {
                admission_number: payer_admission_number,
                paymentType: paymentType,
                otherPaymentDescription: otherPaymentDescription,
                student_payment_amount: student_payment_amount,
                student_payment_receiptId: receiptValue
            },
            success: function (data, status) {
              aeLoading()

              if(data=="0"){
                showToast("aeToastE", "Used receipt ID", "Receipt ID already Used!, use a different receipt ID", "20");
                return;
              }
         
                $('#feeForm')[0].reset();
                fetchPayments(payer_admission_number)
                showToast("aeToastS", "Transaction Successful", "Your payment details have been securely submitted and are currently being processed. A confirmation will be sent to your registered email shortly. We appreciate your promptness.", "20");

            },
            error: function (xhr, status, error) {
                showToast("aeToastE", "Error", error, "20");
                aeLoading()
            }
        });
    });
    
});





// Fetch payments based on admission number
function fetchPayments(admission_number) {

  $.ajax({
    type: "post",
    cache: false,
    url: "FEE_F.php",
    data: { admission_number: admission_number },
    dataType: "json",
    success: function (data, status) {
      console.log(data);

  
      handleFetchSuccess(data);
    },
    error: function (xhr, status, error) {
      alert(error);

      showToast("aeToastE", "Error", "Failed to fetch data", "20");
    },
  });
}

// Handle success response from fetching payments
function handleFetchSuccess(data) {
 

  if (data.status === 'success') {

    populate_student_Fee_payment_Table(data.payments);
   

  } else {
      showToast("aeToastE", "Error", data.message, "20");
  }
}

// Handle error from fetching payments


// Populate table with payment details

// Generate a payment row
function generatePaymentRow(payment) {
  return `
    <tr id="payment_row_${payment.id}" data-id="${payment.id}">
      <td contenteditable="true">${payment.amount}</td>
      <td contenteditable="true">${payment.payment_type}</td> 
      <td class='d-none' contenteditable="true">${payment.description}</td>
      <td contenteditable="false">${payment.recdate}</td>
      <td><button class="btn btn-danger btn-sm delete-row-btn" data-id="${payment.id}"> <i class="fa fa-trash" aria-hidden="true"></i></button></td>
    </tr>
  `;
}

// Dynamically attach event to the delete button on each row
$(document).on('click', '.delete-row-btn', function() {
  var id = $(this).data('id');
  
  // Confirm delete
  showToastY(
    "aeToastY",
    "Confirm Delete",
    "Are you sure you want to delete this payment?",
    "20",
    function() { // Function for YES option
      admin_deletePayment(id);
      $(`#payment_row_${id}`).remove(); // Remove row from DOM
    },
    function() { // Function for NO option
      // Do nothing
    }
  );
});

function admin_deletePayment(id) {
  $.ajax({
    type: "post",
    cache: false,
    url: "FEE_D.php",
    data: {id: id},
    dataType: "json",
    success: function (data, status) {
      
      if(data.status === 'success') {
        showToast("aeToastS","Success","Payment deleted successfully3","20");
      } else {
        showToast("aeToastE","Error","Failed to delete payment","20");
      }
    },
    error: function (xhr, status, error) {
      showToast("aeToastE","Error","Failed to delete payment","20");
    },
  });
}



// Generate total amount and records row
function generateTotalRow(totalAmount, records) {

  return `
      <tr>
          <td colspan="1"><strong>Total Amount:</strong></td>
          <td><strong>${totalAmount.toFixed(2)}</strong></td>
      </tr>
      <tr>
          <td colspan="1"><strong>Total Records:</strong></td>
          <td><strong>${records}</strong></td>
      </tr>`;
}

$(document).on("keyup", ".student_payment_table tbody td[contenteditable='true']", function() {
  const cellContent = $(this).text();
  const rowId = $(this).closest("tr").data("id");
  const columnName = getColumnName($(this).index());
  updateDatabase(rowId, columnName, cellContent);
});

// Get column name based on index
function getColumnName(index) {
  const columns = ["amount", "payment_type", "description", "recdate"];
  return columns[index] || null;
}


function updateDatabase(rowId, columnName, cellContent) {
  aeLoading()
    $.ajax({
        type: "post",
        cache: false,
        url: "FEE_UPDATE.php", // Your PHP file to handle the update
        data: {
            'id': rowId,
            'column': columnName,
            'value': cellContent
        },
        success: function (response) {
          aeLoading()
           // alert(response);
            // Handle success - maybe display a message or something
        },
        error: function (xhr, status, error) {
            // Handle error
            aeLoading()
            console.error(error);
        }
    });
}

  

$(document).ready(function() {
  setLastThreeMonths();
  $("#filterPrint,#filter-cancel").on("click", function() {
      $("#feeFilterCard").toggleClass("d-none");
  });


  // click event for fee_print_options
  $(".fee_print_options").on("click", function() {
    $("#feeFilterCard").addClass("d-none");
  });


});





function filterRecords() {
  // Gathering values from the form
  const startDate = $('#startDate').val();
  const endDate = $('#endDate').val();
  const paymentType = $('#paymentType').val();
  const studentClass = $('#class_selection2').val();
  const groupBy = $('#groupBySelect').val();

  // if groupby is 0 change to monthly

  if(validateDates() === false) return;



  // Building the data object to send
  let dataToSend = {};

  // Only add to the data object if the filter has been set
  if (startDate) dataToSend.startDate = startDate;
  if (endDate) dataToSend.endDate = endDate;
  if (paymentType && paymentType !== "0") dataToSend.paymentType = paymentType;
  if (studentClass && studentClass !== "0") dataToSend.studentClass = studentClass;
  if (groupBy && groupBy !== "0") dataToSend.groupBy = groupBy;

  //alert(JSON.stringify(dataToSend));

 // alert(endDate)
 // console.log(endDate);

  aeLoading()

  // Make AJAX request
  $.ajax({
      type: "post",
      cache: false,
      url: "FEE_PRINT.php",
      data: dataToSend,
      dataType: "text",
      success: function (data, status) {
      
   


   
       aeLoading()
  
        if(data==1){
          aeDownload("../report/student_Payment_Report.pdf");
        }
        else{
          showToast("aeToastE", "NO RECORDS", "No records found", "20");
        }
   


       // console.log(data);
     //  alert(data);
          if (data.status === 'success') {

            aeDownload(data, "Fee Report", "pdf")
        
              // Handle the response data as needed, e.g. render the report
              showToast("aeToastS", "Success", "Report fetched successfully.", "20");
          } else {
             // showToast("aeToastE", "Error", data, "20");
          }
      },
      error: function (xhr, status, error) {
          showToast("aeToastE", "Error", error, "20");

          aeLoading()
      },
  });
}

function setLastThreeMonths() {
  const today = new Date();
  const threeMonthsAgo = new Date(today);

  threeMonthsAgo.setMonth(threeMonthsAgo.getMonth() - 3);
  threeMonthsAgo.setDate(1); // set day to the first day of the month

  // Convert to YYYY-MM-DD format
  const endDateString = today.toISOString().split("T")[0];
  const startDateString = threeMonthsAgo.toISOString().split("T")[0];

  $("#startDate").val(startDateString);
  $("#endDate").val(endDateString);
}



function validateDates() {
  const startDate = new Date($("#startDate").val());
  const endDate = new Date($("#endDate").val());

  if (isNaN(startDate.getTime()) || isNaN(endDate.getTime())) {
    showToast("aeToastE", "Invalid Date", "Please make sure both dates are selected.", "20");
    return false;
  }

  if (startDate > endDate) {
    showToast("aeToastE", "Invalid Date Range", "Start date cannot be greater than end date.", "20");
    return false;
  }

  if (endDate > new Date()) {
    showToast("aeToastE", "Invalid End Date", "End date cannot be in the future.", "20");
    return false;
  }

  return true;
}




$(document).ready(function() {
  $("#student_fee .dropdown-item").click(function() {
      var selectedOption = $(this).text();
      
      // Using the global admission_number variable
      var admissionNumber = payer_admission_number; 

      //alert(admissionNumber)

      if(admissionNumber == null){
        showToast("aeToastE", "Error", "Please select a student.", "20");
        return false;
      }

      aeLoading()
      
      // Sending the selected option and admission_number to FEE_RECEIPT_STUDENT.php using AJAX
      $.ajax({
          type: "post",
          cache: false,
          url: "FEE_RECEIPT_STUDENT.php",
          data: {
              option: selectedOption,
              admission_number: admissionNumber  // Send the admission number
          },
          dataType: "text",
          success: function(data, status) {
              // Handle success
              console.log(data);

           //   alert(data);

             aeLoading()

              if(data==1){
                aeDownload("../report/student_Receipt.pdf");
              }
              else{
                showToast("aeToastE", "NO RECORDS", "No records found", "20");
              }

             // showToast("aeToastS", "Success", "Data sent successfully!", "20");
          },
          error: function(xhr, status, error) {
              console.error(error);
              showToast("aeToastE", "Error", "Failed to send data.", "20");
              aeLoading()
          }
      });
  });
});





function populate_student_Fee_payment_Table(payments) {
///  alert(223)
  
  const tableBody = $(".student_fee_payment_table tbody");
  tableBody.empty();

  let totalAmount = payments.reduce((acc, payment) => acc + parseFloat(payment.amount), 0);

  
  payments.forEach(payment => {
      tableBody.append(generatePaymentRow(payment));
  });

  tableBody.append(generateTotalRow(totalAmount, payments.length));
}


