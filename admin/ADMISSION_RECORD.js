

$(document).ready(function () {
    // Fetch data from PHP script
    $.ajax({
        type: "post",
        url: "init_admission_filter.php",
        dataType: "json",
        success: function (data) {
            console.log(data);
           // alert(data);

            if (data) {
     

                populateSelectOptions('#admission_filter_denomination', data.denominations);
                populateSelectOptions('#admission_filter_house', data.houses);
                populateSelectOptions('#admission_filter_programme', data.programmes);
                populateSelectOptions('#admission_filter_religion', data.religions);
                populateSelectOptions('#admission_filter_status', data.boarding_statuses);
            }
        },
        error: function (xhr, status, error) {
            console.error("An error occurred while fetching data: " + error);
        }
    });
});

function populateSelectOptions(selectId, options) {
    let select = $(selectId);
   

    options.forEach(function (option) {
        select.append($('<option>', { 
            value: option,
            text : option 
        }));
    });
}













function fetchAdmissionRecords() {
    var tableBody = $('#admission_list_filter_table tbody');
    tableBody.empty(); // Clear existing rows

    $('#admin_admission_list_filter_total_record').text('0');
    var filters = {};
    if ($('#admission_filter_fromDate').val()) {
      filters.fromDate = $('#admission_filter_fromDate').val();
    }
    if ($('#admission_filter_toDate').val()) {
      filters.toDate = $('#admission_filter_toDate').val();
    }
    if ($('#admission_filter_status').val()) {
      filters.status = $('#admission_filter_status').val();
    }
    if ($('#admission_filter_programme').val()) {
      filters.programme = $('#admission_filter_programme').val();
    }
    if ($('#admission_filter_gender').val()) {
      filters.gender = $('#admission_filter_gender').val();
    }
    if ($('#admission_filter_house').val()) {
      filters.house = $('#admission_filter_house').val();
    }
    if ($('#admission_filter_religion').val()) {
      filters.religion = $('#admission_filter_religion').val();
    }
    if ($('#admission_filter_healthIssue').val()) {
      filters.healthIssue = $('#admission_filter_healthIssue').val();
    }
    if ($('#admission_filter_denomination').val()) {
      filters.denomination = $('#admission_filter_denomination').val();
    }

    console.log(filters);
  
  
    $.ajax({
      type: "post",
      cache: false,
      url: "ADMISSION_RECORD_FETCH.php",
      dataType: "json",
      data: filters,
      success: function (data, status) {
        populateAdmissionListTable(data);

        console.log(data);
        // Process the fetched data
      },
      error: function (xhr, status, error) {
        console.error(error);
      }
    });
  }
  $('#admission_filter_submit').click(function(e) {
    e.preventDefault();
    fetchAdmissionRecords();
  });
  
  $('#admission_filter_reset').click(function() {
    $('#admission_list_filter_table tbody').empty();
  });
  



  function populateAdmissionListTable(data) {
    $('#admin_admission_list_filter_total_record').text(data.length);
    var tableBody = $('#admission_list_filter_table tbody');
    tableBody.empty(); // Clear existing rows
  
    data.forEach(function (student) {
      var fullName = student.first_name + ' ' + (student.middle_name ? student.middle_name + ' ' : '') + student.last_name;
      var imageUrl = student.student_passport_image_input ?   student.student_passport_image_input : '../devimage/placeholder.png';
      
      var row = `<tr>
                  <td>${student.sdass_admission_number}</td>
                  <td>${fullName}</td>
                  <td><img src="${imageUrl}" alt="Image" style="width: 50px; height: 50px;"></td>
                 </tr>`;
      tableBody.append(row);
    });
  }



  
  $(document).ready(function() {
    var filters = {};
   
  
    $('#admission_filter_indexNumber').keyup(function() {
        $('#admin_admission_list_filter_total_record').text('0');
        $('#admission_list_filter_table tbody').empty();
      var indexNumber = $(this).val();
      if (indexNumber) {
        filters.admission_number = indexNumber;
        searchByIndexNumber(filters);
      } else {
        $('#admission_list_filter_table tbody').empty();
      }
    });
});
    function searchByIndexNumber(filters) {
      $.ajax({
        type: "post",
        cache: false,
        url: "ADMISSION_RECORD_FETCH.php",
        dataType: "json",
        data: filters,
        success: function (data, status) {

       
          populateAdmissionListTable(data);
        },
        error: function (xhr, status, error) {
          console.error(error);
        }
      });
    }













//ae_image_download  click event
$('#modal_download_button').click(function(event) {
    event.preventDefault();
    sendSelectedCheckboxes() 
  //  aeModal2("excelColumnModal");
    
});



//ae_image_download  click event
$('#ae_image_download').click(function(event) {
    event.preventDefault();

    // check if records exist 
    //  <P> Total Records:      <span id="admin_admission_list_filter_total_record">0</span> 
    var total_records = $('#admin_admission_list_filter_total_record').text();
    if(aeEmpty(total_records)){
        showToast("aeToastE", "No Record!", "No Record Found", "20");
        return false;
    }

    aeModal2("excelColumnModal");
    
});



function getSelectedCheckboxes() {
    var selectedCheckboxes = [];
    $(".ae-check-box .form-check-input:checked").each(function() {
      selectedCheckboxes.push($(this).val());
    });
    return selectedCheckboxes.filter(function(value) {
      return value !== undefined && value !== null && value !== '';
    });

  
  }



  function sendSelectedCheckboxes() {
    var selectedCheckboxes = getSelectedCheckboxes();
    $.ajax({
      type: "post",
      cache: false,
      url: "ADMISSION_FILTER.php",
      dataType: "text",
      data: { checkboxes: selectedCheckboxes },
      success: function (data, status) {
       // alert(data);
        aeDownload("admission_list.xlsx");
        showToast("aeToastS", "Success", "Checkboxes data received.", "20");
      },
      error: function (xhr, status, error) {
        showToast("aeToastE", "Error", "Failed to send checkboxes data.", "20");
      },
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
