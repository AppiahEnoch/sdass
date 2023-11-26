<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../mc_table.php";




$finalFileName='../report/student_Payment_Report.pdf';

$pageTitle="STUDENT PAYMENT REPORT";

//$workerNameSanitized = $_POST["Duration"];


// CREATE A PDF HEADER
// SELECT app_name, location, email FROM app;

//$sql1 = "SELECT wfullname as name, wmobile as mobile, wemail as email FROM washer WHERE wfullname  = '$workerNameSanitized'";

$sql1 = "SELECT `app_name` AS School,`email`,`location`as Loc FROM `app` WHERE 1";





// SECOND QUERY YOU MAY FORM YOUR QUERY IN ANY WAY HERE I AM JUST GIVING AN EXAMPLE





// Initialize criteria for the SQL WHERE clause
$criteria = [];
$bindParams = [];
$bindTypes = '';

// Start Date
if (isset($_POST['startDate']) && $_POST['startDate']) {
    $criteria[] = "p.recdate >= ?";
    $bindParams[] = $_POST['startDate'];
    $bindTypes .= "s";
}

// End Date



    
if (isset($_POST['endDate']) && $_POST['endDate']) {
    $criteria[] = "p.recdate < DATE_ADD(?, INTERVAL 1 DAY)";
    $bindParams[] = $_POST['endDate'];
    $bindTypes .= "s";
}



// Payment Type
if (isset($_POST['paymentType']) && $_POST['paymentType'] !== "0") {
    $criteria[] = "p.payment_type = ?";
    $bindParams[] = $_POST['paymentType'];
    $bindTypes .= "s";
}

// Student Class
if (isset($_POST['studentClass']) && $_POST['studentClass'] !== "0") {
    $criteria[] = "s.student_class = ?";
    $bindParams[] = (int)$_POST['studentClass'];
    $bindTypes .= "i";
}

// Convert criteria array into SQL WHERE clause
$whereClause = implode(' AND ', $criteria);
if ($whereClause) {
    $whereClause = 'WHERE ' . $whereClause;
}

$duration = ", DATE_FORMAT(p.recdate, '%M, %Y') AS Duration";
if (isset($_POST['groupBy']) && $_POST['groupBy']) {
    $groupBy = $_POST['groupBy'];
    switch($groupBy) {
        case 'daily':
            $duration = ", DATE_FORMAT(p.recdate, '%W, %D %M, %Y') AS Duration";
            break;
        case 'weekly':
            $duration = ", CONCAT(DATE_FORMAT(p.recdate, '%M %Y'), ' WEEK ', FLOOR((DAY(p.recdate) - 1) / 7) + 1) AS Duration";

            break;
        case 'monthly':
            $duration = ", DATE_FORMAT(p.recdate, '%M, %Y') AS Duration";
            break;
        case 'yearly':
            $duration = ", DATE_FORMAT(p.recdate, '%Y') AS Duration";
            break;
    }
}

$sql2 = "
    SELECT 
        CONCAT(r.firstname, ' ', IFNULL(r.middlename, ''), ' ', r.lastname) AS `System User`,
        s.admission_number as ID,
        c.class_name AS `Class`,
        bi.item AS `Type`, 
        p.amount,
        DATE_FORMAT(p.recdate, '%D %b. %Y') AS `Date`
        $duration
    FROM student_payment p
    JOIN student s ON p.admission_number = s.admission_number
    JOIN school_class c ON s.student_class = c.id
    JOIN registration r ON p.userid = r.id
    JOIN bill_item bi ON p.payment_type = bi.id 
    $whereClause
    ORDER BY DATE(p.recdate), c.class_name, bi.item, p.recdate DESC
";














// MAKE THESE NULL IF YOU WILL NOT NEED THEM

$criteria1 = 'Duration';
$criteria2 = 'System User';


//$criteria1 =null;
//$criteria2 = null;


// SET COLUMN WIDTHS
$widths = [40, 30, 40,20,40,20];  

















$logo = "../devimage/logo.png"; // replace with the actual path to your company logo
$pdf = createReportHeading($conn, $sql1, $pageTitle, $logo);


// CREATE TABLES

// FOR PREPARED STATEMENTS
$records = fetchRecordsP($conn, $sql2, $bindParams, $bindTypes);

// NO PREPARED STATEMENT
//$records= fetchRecords($conn, $sql2);

  $isCreated=    generateReport($pdf,$conn, $records,$criteria1,$criteria2, $widths,$finalFileName);

  echo $isCreated;




function createReportHeading($conn, $sql, $reportTitle = 'Report', $logoPath = null) {
    $pdf = new PDF_MC_Table();
    $pdf->AddPage('P', 'A4');
  // Right aligned cell


    $pdf->SetFont('Arial', 'I', 8);
    //reduce line   space\
  

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // If logo is provided, add it to the top left
        if ($logoPath && file_exists($logoPath)) {
            $pdf->Image($logoPath, 5, 8, 25);
            $pdf->Ln(5);  // Adjusted for better spacing after the logo
        }

        $pdf->SetFont('Arial', 'B', 20);
        $pdf->Cell(0, 10, $reportTitle, 0, 1, 'C');

        // Loop through each column dynamically
        foreach ($user as $columnName => $columnValue) {
            $pdf->SetFont('Arial', '', 11);
            $pdf->Cell(0, 10, strtoupper($columnName) . ": " . strtoupper($columnValue), 0, 1, 'C');
            $pdf->Ln(-2);
        }

        $timestamp = date("l, jS F, Y , h:i a");
 // Adjust position for right alignment
        $pdf->Cell(120, 10, $timestamp, 0, 2, 'R');

        $pdf->Ln();
        $pdf->SetDrawColor(0, 0, 0); // Black color
        $pdf->Line(10, $pdf->GetY(), 290, $pdf->GetY());
        $pdf->Ln(5);
    }

    return $pdf; // Return the PDF object with the heading for further modifications or output
}













function fetchRecordsP($conn, $sql, $bindParams = [], $bindTypes = '') {
    //echo  $sql;
   // exit;
    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    // If there are bind parameters, bind them to the statement
    if ($bindTypes && !empty($bindParams)) {
        $bindParamsRef = [];
        foreach ($bindParams as $key => $value) {
            $bindParamsRef[$key] = &$bindParams[$key];
        }
        call_user_func_array([$stmt, 'bind_param'], array_merge([$bindTypes], $bindParamsRef));
    

    

    }

    // Execute the statement
    if (!$stmt->execute()) {
  
        die("Error executing statement: " . $stmt->error);
        
    }


    // Get the result
    $result = $stmt->get_result();
    if (!$result) {
        die("Error executing query: " . $stmt->error);
    }

    // Fetch all results into an associative array
    $records = $result->fetch_all(MYSQLI_ASSOC);

    // Close the statement
    $stmt->close();

    return $records;
}


function fetchRecords($conn, $sql) {
    // Ensure workerName and workerDays are properly sanitized


    $result = $conn->query($sql);

    if (!$result) {
        die("Error executing query: " . $conn->error);
    }

    return $result->fetch_all(MYSQLI_ASSOC);
}





function generateReport($pdf, $conn, $records, $groupByColumn1 = null, $groupByColumn2 = null, $columnWidths = [], $finalFileName = null) {
    $isCreated = 0;
    $pdf->SetFont('Arial', 'B', 10);

    if (is_null($records) || !is_array($records) || empty($records)) {
        return;
    }

    $groupedRecords = [];
    foreach ($records as $record) {
        $groupValue1 = $groupByColumn1 ? $record[$groupByColumn1] : '';
        $groupValue2 = $groupByColumn2 ? $record[$groupByColumn2] : '';

        $compositeKey = "{$groupValue1}_{$groupValue2}";

        if (!isset($groupedRecords[$compositeKey])) {
            $groupedRecords[$compositeKey] = [];
        }
        $groupedRecords[$compositeKey][] = $record;
    }

    $grandTotals = [];
    $defaultWidth = 40;

    foreach ($groupedRecords as $compositeKey => $groupRecords) {
        $pdf->SetFont('Arial', 'B', 12);
        list($groupValue1, $groupValue2) = explode('_', $compositeKey);

        if ($groupByColumn1) $pdf->Cell(0, 6, strtoupper($groupByColumn1) . ": " . $groupValue1, 0, 1, 'L');
        if ($groupByColumn2) $pdf->Cell(0, 6, strtoupper($groupByColumn2) . ": " . $groupValue2, 0, 1, 'L');

        $pdf->Ln(4);

        // Remove columns used for grouping
        foreach ($groupRecords as $key => $record) {
            if ($groupByColumn1) unset($groupRecords[$key][$groupByColumn1]);
            if ($groupByColumn2) unset($groupRecords[$key][$groupByColumn2]);
        }
        
        $columns = array_keys($groupRecords[0]);
        $pdf->SetFont('Arial', 'B', 10);

        $widths = [];
        foreach ($columns as $index => $column) {
            $widths[] = isset($columnWidths[$index]) ? $columnWidths[$index] : $defaultWidth;
        }
        $pdf->SetWidths($widths);

        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Row($columns);

        $pdf->SetFont('Arial', '', 10);
        $totals = [];
        foreach ($groupRecords as $record) {
            $rowValues = [];
            foreach ($columns as $column) {
                $value = $record[$column];
                $rowValues[] = $value;

                if (is_numeric($value)) {
                    if (!isset($totals[$column])) $totals[$column] = 0;
                    $totals[$column] += $value;

                    if (!isset($grandTotals[$column])) $grandTotals[$column] = 0;
                    $grandTotals[$column] += $value;
                } else {
                    if (!isset($totals[$column])) $totals[$column] = 0;
                    $totals[$column] += 1;

                    if (!isset($grandTotals[$column])) $grandTotals[$column] = 0;
                    $grandTotals[$column] += 1;
                }
            }
            $pdf->Row($rowValues);
        }

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->SetTextColor(255, 0, 0);
        $pdf->Row(array_values($totals));
        $pdf->Ln(10);
        $pdf->SetTextColor(0, 0, 0);

        $isCreated = 1;
    }

    $pdf->SetFont('Arial', 'B', 12);
    $pdf->SetTextColor(255, 0, 0);
    $pdf->Row(['GRAND TOTAL'] + array_values($grandTotals));
    $pdf->SetTextColor(0, 0, 0);

    $pdf->SetFont('Arial', '', 8);
    $pdf->Ln(-2);
    $pdf->Cell(150, 10, 'Powered By AECleanCodes', 0, 2, 'R'); 
    $pdf->Ln(-5);
    $pdf->Cell(150, 10, '0549822202', 0, 2, 'R'); 
    // ouput
//    $pdf->Output();

    $pdf->Output('F', $finalFileName);

    if ($conn && $conn instanceof mysqli) {
        $conn->close();
    }

    return $isCreated;
}


























?>






















































