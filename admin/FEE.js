var payer_full_name = null;
var global_admission_number = null;
var system_user= null;
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
       

        adminFetchPayment(payer_admission_number)
        global_admission_number = payer_admission_number;
        payer_full_name = fullName;
      

       // alert(payer_admission_number)
   
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
              // reset table   const tableBody = $("#admin_take_payment_list_wrapper .table tbody");
              const tableBody = $("#admin_take_payment_list_wrapper .table tbody");
              tableBody.empty();

              $("#payer").text("");

               
              aeLoading()
              adminFetchPayment(payer_admission_number)

              if(data=="0"){
                showToast("aeToastE", "Used receipt ID", "Receipt ID already Used!, use a different receipt ID", "20");
                return;
              }
         
                $('#feeForm')[0].reset();
                adminFetchPayment(payer_admission_number)
                showToast("aeToastS", "Transaction Successful", "Your payment details have been securely submitted and are currently being processed. A confirmation will be sent to your registered email shortly. We appreciate your promptness.", "20");

            },
            error: function (xhr, status, error) {
                showToast("aeToastE", "Error", error, "20");
                aeLoading()
            }
        });
    });
    
});





// Get column name based on index
function getColumnName(index) {
  const columns = ["amount", "payment_type", "description", "recdate"];
  return columns[index] || null;
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
            
              admission_number: admissionNumber  // Send the admission number
          },
          dataType: "text",
          success: function(data, status) {
              // Handle success
              console.log(data);

           //  alert(data);

             aeLoading()

              if(data==1){
                aeDownload("../report/Student_payment.pdf");
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







function adminFetchPayment(admission_number) {

  $.ajax({
    type: "post",
    cache: false,
    url: "FEE_F.php", // Your PHP endpoint
    data: { admission_number: admission_number },
    dataType: "json",
    success: function (response) {

      system_user = response.payments[0].system_user;
      //alert(response)
      if (response.status === 'success') {
        populatePaymentTable(response.payments);
      } else {
        showToast("aeToastE", "Error", response.message, "20");
      }
    },
    error: function (xhr, status, error) {
      showToast("aeToastE", "Error", "Failed to fetch data", "20");
    },
  });

}

function populatePaymentTable(payments) {
  const tableBody = $("#admin_take_payment_list_wrapper .table tbody");
  const totalRecordsSpan = $("#admin_take_payment_list_total_records");
  const totalAmountSpan = $("#admin_take_payment_list_total_amount");
  tableBody.empty();

  let totalAmount = 0;

  payments.forEach(payment => {
    totalAmount += parseFloat(payment.amount);

    tableBody.append(`
      <tr>
        <td>${payment.id}</td>
        <td>${payment.payment_type}</td>
        <td>${parseFloat(payment.amount).toFixed(2)}</td>
        <td class="ae-print-only">${payment.system_user})</td>
        <td><button class="btn btn-danger ae-delete-row" onclick="deletePayment(${payment.id})"><i class="fas fa-trash-alt"></i></button></td>
      </tr>
    `);
  });

  totalRecordsSpan.text(payments.length);
  totalAmountSpan.text(totalAmount.toFixed(2));
}



function deletePayment(id) {
  // Custom confirmation dialog
  showToastY(
    "aeToastY",
    "Confirm Deletion",
    "Are you sure you want to delete this payment?",
    "20",
    function() { // Yes callback
      // AJAX request to delete the payment
      $.ajax({
        type: "post",
        cache: false,
        url: "FEE_D.php",
        data: { id: id },
        dataType: "json",
        success: function (data, status) {
          const tableBody = $("#admin_take_payment_list_wrapper .table tbody");
          tableBody.empty();

          $("#payer").text("");
       
           
          if (data.status === 'success') {
          
            adminFetchPayment(global_admission_number); // Assuming `adminFetchPayment` is a function to refresh the list
            showToast("aeToastS", "Success", "Payment deleted successfully", "20");
          } else {
            showToast("aeToastE", "Error", "Failed to delete payment", "20");
          }
        },
        error: function (xhr, status, error) {
          showToast("aeToastE", "Error", "Failed to delete payment", "20");
        }
      });
    },
    function() { // No callback
      // Handle the "No" response
    }
  );
}


function printStudent_payment_receipt() {
  const payer = payer_full_name// Replace with the actual payer name
  const receiver = system_user // Replace with the actual receiver name
  const paymentDateTime = new Date().toLocaleString(); // Example, adjust as needed

  const printWindow = window.open('', '', 'height=600,width=800');
  printWindow.document.write(`
      <html>
          <head>
              <title>Payment Receipt</title>
              <style>
                  body {
                      font-family: Arial, sans-serif;
                      font-size: 12px; /* Reduced font size */
                      line-height: 1.2; /* Reduced line spacing */
                      text-align: center; /* Center align all text */
                  }
                  h2 { font-size: 16px; margin-bottom: 10px; }
                  .receipt-info { margin-bottom: 15px; }
                  table { width: 40%; margin-left: auto; margin-right: auto; border-collapse: collapse; }
                  th, td {
                      border: 1px solid black;
                      padding: 4px; /* Reduced padding */
                      text-align: left;
                      font-size: 12px; /* Reduced font size in table */
                  }
                  .total-row td {
                      color: black;
                      border: none;
                      font-weight: bold;
                  }
              </style>
          </head>
          <body>
                <h3 style="margin-bottom: 1px;">Dr. Yaw Ackah Memorial School</h3>
                <h4 style="margin-top: 1px;">Payment Receipt</h4>
              <div class="receipt-info">
                  <strong>Payer:</strong> ${payer}<br>
                  <strong>Receiver:</strong> ${receiver}<br>
                  <strong>Payment Date and Time:</strong> ${paymentDateTime}
              </div>
              <table class="table table-striped">
                  <thead><tr><th>ID</th><th>Type</th><th>Amount</th></tr></thead>
                  <tbody>
  `);

  // Add table rows here (use existing logic)
  $("#admin_take_payment_list_wrapper .table tbody tr").each(function() {
      const id = $(this).find("td:eq(0)").text();
      const type = $(this).find("td:eq(1)").text();
      const amount = $(this).find("td:eq(2)").text();
      printWindow.document.write(`<tr><td>${id}</td><td>${type}</td><td>${amount}</td></tr>`);
  });

  const totalRecords = $("#admin_take_payment_list_total_records").text();
  const totalAmount = $("#admin_take_payment_list_total_amount").text();
  printWindow.document.write(`
                      <tr class="total-row"><td colspan="2">Total Records:</td><td>${totalRecords}</td></tr>
                      <tr class="total-row"><td colspan="2">Total Amount:</td><td>${totalAmount}</td></tr>
                  </tbody>
              </table>
          </body>
      </html>
  `);
  printWindow.document.close();
  printWindow.focus(); // Required for some browsers to trigger print
  setTimeout(() => printWindow.print(), 1000); // Delay to allow the content to load
}




$(document).ready(function() {
  $("#admin-print-payment-receipt .ae-print").on("click", function() {
  //  alert("Hello");
    printStudent_payment_receipt();
  });
});