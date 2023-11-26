// create document ready fuction
$(document).ready(function () {

    $("#student_bill_addBillItemButton").click(function() {
       // const item = $("#student_bill_addBillItem").val().trim();

        // to uppercase
        const item = $("#student_bill_addBillItem").val().trim().toUpperCase();
      
        if (item === "") {
          showToast("aeToastE", "Missing Item", "Please enter a bill item.", "20");
          return;
        }
      
        $.ajax({
          type: "post",
          cache: false,
          url: "BILL_ITEM_INSERT.php",
          data: { student_bill_addBillItem: item },
          dataType: "text",
          success: function(data, status) {
           fetchBillItems();
           // alert(data);
            showToast("aeToastS", "Success", "Bill item added successfully.", "20");
            $("#student_bill_addBillItem").val("");
          },
          error: function(xhr, status, error) {
           // alert("gg:"+error);
            showToast("aeToastE", "Error", "Failed to add bill item.", "20");
          },
        });
      });
      

});
 



$(document).ready(function() {
    // Fetch bill items on page load
    fetchBillItems();

 
});


function fetchBillItems() {
    $.ajax({
        type: "GET",
        cache: false,
        url: "BILL_ITEM_F.php",
        dataType: "json",
        success: function(data) {
            // Array of select IDs to be populated
            const selectIds = ["student_bill_selectBillItem", "paymentType1", "paymentType"];

            selectIds.forEach(selectId => {
                const billItemSelect = $("#" + selectId);
                // not first option
                billItemSelect.find("option:not(:first)").remove();
                data.forEach(billItem => {
                    billItemSelect.append(`<option value="${billItem.id}">${billItem.item}</option>`);
                });
            });
        },
        error: function(xhr, status, error) {
            showToast("aeToastE", "Error", "Failed to fetch bill items.", "20");
        }
    });
}








// create document ready fuction
$(document).ready(function () {

// Event listener for delete icon
$("#delete_bill_item").click(function() {
    showToastY(
        "aeToastY", 
        "Confirm Delete", 
        "Are you sure you want to delete this bill item?", 
        "20", 
        deleteBillItem, 
        function() {
            // Do nothing for No option
        }
    );
});

// Function to delete bill item
function deleteBillItem() {
    const billItemId = $("#student_bill_selectBillItem").val(); // Assuming you have the bill item ID here

    if (billItemId =="0") {
        showToast("aeToastE", "Missing Item", "Please select a bill item.", "20");
        return;
    }

    //alert(billItemId);

    $.ajax({
        type: "post",
        cache: false,
        url: "BILL_ITEM_DELETE.php",  // Replace with your PHP script to delete bill item
        dataType: "json",
        data: { id: billItemId },
        success: function (data, status) {
          //  alert(data);
            if (data.status === "success") {
                // Remove the deleted bill item from the select dropdown
                $("#student_bill_selectBillItem option[value='" + billItemId + "']").remove();
                showToast("aeToastS", "Deleted", "Bill item deleted successfully.", "20");
            } else {
                showToast("aeToastE", "Error", "Failed to delete bill item.", "20");
            }
        },
        error: function (xhr, status, error) {
            showToast("aeToastE", "Error", "An error occurred while deleting.", "20");
        }
    });
}


});



// create document ready fuction
$(document).ready(function () {

$("#student_bill_cancel").click(function() {
   //student_bill_form reset  
    $("#student_bill_form")[0].reset();


      

});
});




// create document ready fuction
$(document).ready(function () {
        // Event listener for form submission
        $("#student_bill_form").on("submit", function(e) {
            e.preventDefault();
            
            let studentClass = $("#student_bill_studentClass").val();
            let billItem = $("#student_bill_selectBillItem").val();

            if(aeEmpty(studentClass)) {
                showToast("aeToastE", "Missing Class", "Please select a class.", "20");
                return;
            }


            if(aeEmpty(billItem)) {
             showToast("aeToastE", "Missing Item", "Please select a bill item.", "20");
                return;
            }

            let billAmount = $("#student_bill_billAmount").val();

      
            $.ajax({
                type: "POST",
                cache: false,
                url: "STUDENT_BILL_INSERT.php",
                data: {
                    student_class_id: studentClass,
                    item_id: billItem,
                    bill_amount: billAmount
                },
                dataType: "json",
                success: function(data, status) {

                    create_Class_Bill_Cards("");
                   // alert(data);
                    if (data.status === 'success') {
                        showToast("aeToastS", "Success", "Bill added successfully", "20");
                    } else {
                        showToast("aeToastE", "Error", data.message, "20");
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });
    
});


function populateClassBillCards(data) {
    if (!Array.isArray(data.records)) {
        console.error("Data records are not an array.");
        return;
    }

    let cardContent = '';
    let grandTotal = 0;
    
    let groupedData = {};
    
    // Group by class name
    data.records.forEach(record => {
        if (!groupedData[record.class_name]) {
            groupedData[record.class_name] = [];
        }
        groupedData[record.class_name].push(record);
    });

    Object.keys(groupedData).forEach((className, classIndex) => {
        let billItemsContent = '';
        let classTotal = 0;

        groupedData[className].forEach(record => {
            let amount = parseFloat(record.bill_amount);
            classTotal += amount;
            grandTotal += amount;

            billItemsContent += `<tr id="bill_item_row_${record.id}">
                <td>${record.bill_item}</td>
                <td>${amount.toFixed(2)}</td>
                <td><i class="fas fa-trash del-icon" onclick="deleteBillItem(${record.id})"></i></td>
            </tr>`;
        });

        // After iterating through all records for this class, add the total for the class
        billItemsContent += `<tr class="class_bill_Class_total-row"><td>Total</td><td>${classTotal.toFixed(2)}</td><td></td></tr>`;
        
        cardContent += `<div class="card class_bill_card mb-5" id="card_class_bill_${classIndex}">
            <div class="card-header">
                <h5>Class: <span id="class_name_${classIndex}">${className}</span> <i class="fas fa-print float-right ms-5 class_bill_print_icon" onclick="printCard('card_class_bill_${classIndex}')"></i></h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Bill Item</th>
                            <th scope="col">Amount</th>
                            <th scope="col">Del</th>
                        </tr>
                    </thead>
                    <tbody id="list_of_bill_items_${classIndex}">
                        ${billItemsContent}
                    </tbody>
                </table>
            </div>
        </div>`;
    });

    cardContent += `<div class="card" id="class_bill_card_grand_total">
        <div class="card-header">
            <h5>Grand Total</h5>
        </div>
        <div class="card-body">
            <p id="grand_total_amount">${grandTotal.toFixed(2)}</p>
        </div>
    </div>`;

    $("#class_bills").html(cardContent);
}

function deleteBillItem(id) {
    showToastY(
        "aeToastY",
        "Confirm Deletion",
        "Are you sure you want to delete this bill item?",
        "20",
        function() {
            $.ajax({
                type: "POST",
                cache: false,
                url: "STUDENT_BILL_DEL.php",
                dataType: "json",
                data: { id: id },
                success: function(data, status) {
                    if (data.success) {
                        $(`#bill_item_row_${id}`).remove();
                        showToast("aeToastS", "Success", data.message, "20");
                    } else {
                        showToast("aeToastE", "Error", "Failed to delete bill item.", "20");
                    }
                },
                error: function(xhr, status, error) {
                    showToast("aeToastE", "Error", "An error occurred while deleting the bill item.", "20");
                },
            });
        },
        function() {
            showToast("aeToastE", "Cancelled", "Bill item deletion cancelled.", "20");
        }
    );
}











function create_Class_Bill_Cards(selectedTermId) {
    $.ajax({
        type: "post",
        data: { term: selectedTermId },
        cache: false,
        url: "STUDENT_BILL_F.php",
        dataType: "json",
        success: function (data, status) {
          //  alert(data);
            if (data && data.status === "success") {
                populateClassBillCards(data);
            } else {
                console.error("No data received or status not successful.");
            }
        },
        error: function (xhr, status, error) {
            console.error(error);
        }
    });
}


  
  $(document).ready(function () {
    create_Class_Bill_Cards("");
    $("#academic_terms_dropdown").change(function() {
      const selectedTerm = $("#academic_terms_dropdown option:selected").text();
      global_academic_term = selectedTerm;
      create_Class_Bill_Cards(selectedTerm);
    });
  });
  
  
  $(document).ready(function () {
    // fetchAcademicTerms(); // Uncomment this if you have this function implemented elsewhere.
  
    $("#academic_terms_dropdown").change(function() {
      const selectedTerm = $("#academic_terms_dropdown option:selected").text();
      create_Class_Bill_Cards(selectedTerm);
    });
  });
  
  

  


  $(document).ready(function () {
    fetchAcademicTerms();


    $("#academic_terms_dropdown").change(function() {

        // Get selected option
        var selectedOption = $(this).find("option:selected");
        
        // Get text of selected option
        var selectedTerm = selectedOption.text();
      
        // Pass selected term to function
        create_Class_Bill_Cards(selectedTerm);
      
      });
  });
  

  function printCard(cardId) {
    let cardElement = document.getElementById(cardId);
    if (cardElement) {
        let classNameElement = cardElement.querySelector('[id^="class_name_"]');
        let className = classNameElement ? classNameElement.innerText : 'Unknown Class';

        // Text to add at the top
        


        let headerText = `${className} bill for ${global_academic_term}`;

        let styles = `
            <style>
                body {
                    font-family: Arial, sans-serif;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                }
                th, td {
                    border: 1px solid #ddd;
                    padding: 8px;
                }
                th {
                    background-color: #f2f2f2;
                }
                h1 {
                    text-align: center;
                }
            </style>
        `;

        let headingText = "SDA Senior High School Bekwai"

        let printWindow = window.open('', '_blank');
        printWindow.document.write('<html><head><title>Print</title>');
        printWindow.document.write(styles);
        printWindow.document.write('</head><body>');
        printWindow.document.write('<h3>' + headingText  + '</h3>');
        printWindow.document.write('<h3>' + headerText + '</h3>');
        printWindow.document.write(cardElement.innerHTML);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    } else {
        console.error("Card not found:", cardId);
    }
}


function printAllCards() {
    let styles = `
        <style>
            body {
                font-family: Arial, sans-serif;
            }
            table {
                width: 100%;
                border-collapse: collapse;
            }
            th, td {
                border: 1px solid #ddd;
                padding: 8px;
            }
            th {
                background-color: #f2f2f2;
            }
            h1 {
                text-align: center;
            }
        </style>
    `;

    let headingText = "SDA Senior High School Bekwai";

    let printContent = '';
    let cards = document.querySelectorAll('.class_bill_card');

    cards.forEach(card => {
        let classNameElement = card.querySelector('[id^="class_name_"]');
        let className = classNameElement ? classNameElement.innerText : 'Unknown Class';

        let headerText = `${className} bill for ${global_academic_term}`;
        printContent += '<h3>' + headerText + '</h3>';
        printContent += card.innerHTML;
    });

    let grandTotalCard = document.getElementById('class_bill_card_grand_total');
    if (grandTotalCard) {
        printContent += grandTotalCard.outerHTML;
    }

    let printWindow = window.open('', '_blank');
    printWindow.document.write('<html><head><title>Print</title>');
    printWindow.document.write(styles);
    printWindow.document.write('</head><body>');
    printWindow.document.write('<h3>' + headingText  + '</h3>');
    printWindow.document.write(printContent);
    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.print();
}

