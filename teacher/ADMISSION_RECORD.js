$(document).ready(function () {
  fetchAdmissionRecords();
  $("#admin_admission_list_filter_cancel").on("click", function () {
      $("#admin_admission_list_filter_form")[0].reset();
      fetchAdmissionRecords();
  });

  // Listen to change on filter fields
  $('#admin_admission_list_filter_fromDate, #admin_admission_list_filter_toDate, #admin_admission_list_filter_term, #admin_admission_list_filter_class').change(fetchAdmissionRecords);
});

function fetchAdmissionRecords() {
  var fromDate = $('#admin_admission_list_filter_fromDate').val();
  var toDate = $('#admin_admission_list_filter_toDate').val();
  var term = $('#admin_admission_list_filter_term option:selected').text();
  var classValue = $('#admin_admission_list_filter_class').val();
  

  var data = {};
  if (fromDate) data['fromDate'] = fromDate;
  if (toDate) data['toDate'] = toDate;
  if (term && term !== 'Select Term') data['term'] = term;
  if (classValue && classValue !== 'Select Class') data['class'] = classValue;

  // Log the values
  $.each(data, function (key, value) {
      console.log(key + ' = ' + value);
  });

  $.ajax({
      type: "post",
      url: "ADMISSION_RECORD_FETCH.php",
      data: data,
      dataType: "json",
      success: function (response) {
          if (response.status === 'success') {
              var tableBody = $('#admission_list_filter_table tbody');
              tableBody.empty(); // Clear existing rows
              // get the total size of records 
                var totalSize = response.records.length;

                $("#admin_admission_list_filter_total_record").text(totalSize);
                
          

              
              response.records.forEach(function (record) {
                  tableBody.append(
                      `<tr>
                          <td>${record.admission_number}</td>
                          <td>${record.full_name}</td>
                          <td>${record.date_of_admission}</td>
                      </tr>`
                  );
              });
          } else {
              showToast("aeToastE", "Error", "No records found", "20");
          }
      },
      error: function (xhr, status, error) {
          showToast("aeToastE", "Error", "An error occurred", "20");
      }
  });
}



 function download_admission_link() {
   // alert("hello");
 
        $.ajax({
            type: "post",
            cache: false,
            url: "ADMISSION_LIST_EXCEL.php",
            dataType: "text",
            success: function (data, status) {
                console.log(data);

                showToast("aeToastS", "Success", "Downloaded", "20");

                aeDownload(data)
                return false;
      
            },
            error: function (xhr, status, error) {
                showToast("aeToastE", "Error", error, "20");
            },
        });
    

}

$(document).ready(function() {
    $('#admission_list_download_1').click(function(event) {
        event.preventDefault();
        download_admission_link();
    });
});


function print_admission_list_window(cardId) {
    let cardElement = document.getElementById(cardId);
    if (cardElement) {
        // Text to add at the top
        let headerText = "Admission List";

        let styles = `
            <style>
                body {
                    font-family: Arial, sans-serif;
                }
                .card {
                    border: 1px solid #ddd;
                    border-radius: 4px;
                    padding: 16px;
                    margin-bottom: 20px;
                }
                .card-body {
                    margin-bottom: 20px;
                }
                table {
                    width: 100%;
                    border-collapse: collapse;
                    margin-bottom: 20px;
                }
                th, td {
                    border: 1px solid #ddd;
                    padding: 8px;
                    text-align: left;
                }
                th {
                    background-color: #f2f2f2;
                }
                .btn-secondary {
                    background-color: #6c757d;
                    color: white;
                    text-decoration: none;
                    padding: 10px 15px;
                    border: none;
                    border-radius: 4px;
                    cursor: pointer;
                }
            </style>
        `;

        let printWindow = window.open('', '_blank');
        printWindow.document.write('<html><head><title>Print</title>');
        printWindow.document.write(styles);
        printWindow.document.write('</head><body>');
        printWindow.document.write('<h1>' + headerText + '</h1>');
        printWindow.document.write(cardElement.outerHTML);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        setTimeout(() => {  // This ensures the print dialog opens after the content is fully loaded
            printWindow.print();
            printWindow.onfocus = function () { setTimeout(function () { printWindow.close(); }, 500); }
        }, 500);
    } else {
        showToast("aeToastE", "Error", "Card not found: " + cardId, "20");
    }
}
