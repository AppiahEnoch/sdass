<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../mc_table.php";




$finalFileName='../report/student_Receipt.pdf';

$pageTitle="STUDENT PAYMENT RECEIPT";

//$workerNameSanitized = $_POST["Duration"];


// CREATE A PDF HEADER
// SELECT app_name, location, email FROM app;

//$sql1 = "SELECT wfullname as name, wmobile as mobile, wemail as email FROM washer WHERE wfullname  = '$workerNameSanitized'";

$sql1 = "SELECT `app_name` AS School,`email`,`location`as Loc FROM `app` WHERE 1";





// SECOND QUERY YOU MAY FORM YOUR QUERY IN ANY WAY HERE I AM JUST GIVING AN EXAMPLE



$admissionNumber = $_POST['admission_number'];
$option = $_POST['option'];


$sql2 = "
    SELECT 
        bi.item AS `Payment Type`,
     
        sp.amount AS Amount,
        DATE_FORMAT(sp.recdate, '%D %b. %Y') AS `Date`,
        CONCAT(r.firstname, ' ', COALESCE(r.middlename, ''), ' ', r.lastname) AS `System User`
    FROM student_payment sp
    LEFT JOIN bill_item bi ON sp.payment_type = bi.id
    LEFT JOIN student st ON sp.admission_number = st.admission_number
    LEFT JOIN parent pt ON sp.admission_number = pt.admission_number
    LEFT JOIN registration r ON sp.userid = r.id
    WHERE sp.admission_number = ?
    ORDER BY sp.recdate DESC
";



$sql2b = "
    SELECT 
        bi.item AS `Payment Type`,  -- Changed from sp.payment_type to bi.item
        sp.amount AS Amount,
        DATE_FORMAT(sp.recdate, '%D %b. %Y') AS `Date`,
        CONCAT(r.firstname, ' ', COALESCE(r.middlename, ''), ' ', r.lastname) AS `System User`
    FROM student_payment sp
    LEFT JOIN student st ON sp.admission_number = st.admission_number
    LEFT JOIN parent pt ON sp.admission_number = pt.admission_number
    LEFT JOIN registration r ON sp.userid = r.id
    LEFT JOIN bill_item bi ON sp.payment_type = bi.id   -- Added this line for the JOIN
    WHERE sp.admission_number = ? AND sp.recdate >= DATE_SUB(NOW(), INTERVAL 12 HOUR)
    ORDER BY sp.recdate DESC
";




if($option == 'Print Receipt'){
    $sql2 = $sql2b;
}




// Set up binding parameters
$bindParams = [$admissionNumber];
$bindTypes = 's';






//echo $sql2;
//exit;





// MAKE THESE NULL IF YOU WILL NOT NEED THEM

$criteria1 = 'Duration';
$criteria2 = 'System User';


$criteria1 =null;
$criteria2 = null;


// SET COLUMN WIDTHS
$widths = [40, 40, 40];  










$sql3 = "
    SELECT 
        s.admission_number AS `admission number`,
        CONCAT(s.first_name, ' ', IFNULL(s.middle_name, ''), ' ', s.last_name) AS `Name`,
        sc.class_name AS `Class`,
        CONCAT(p.parent_first_name, ' ', IFNULL(p.parent_middle_name, ''), ' ', p.parent_last_name) AS guardian,
        p.parent_mobile AS Mobile
    FROM student s
    LEFT JOIN parent p ON s.admission_number = p.admission_number
    LEFT JOIN school_class sc ON s.student_class = sc.id
    WHERE s.admission_number = ?
";





$logo = "../devimage/logo.png"; // replace with the actual path to your company logo
$pdf = createReportHeading($conn, $sql1, $pageTitle, $logo);
$pdf1 = createReportHeading2($pdf, $conn, $sql3, $admissionNumber) ;

$pdf=$pdf1;

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


    //reduce line   space\
  

    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // If logo is provided, add it to the top left
        if ($logoPath && file_exists($logoPath)) {
            $pdf->Image($logoPath, 5, 8, 20);
            $pdf->Ln(5);  // Adjusted for better spacing after the logo
        }

        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, $reportTitle, 0, 1, 'C');

        // Loop through each column dynamically
        foreach ($user as $columnName => $columnValue) {
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(0, 10, strtoupper($columnName) . ": " . strtoupper($columnValue), 0, 1, 'C');
            $pdf->Ln(-2);
        }

        
    $timestamp = date("l, jS F, Y , h:i a");
    // bold font 
    $pdf->SetFont('Arial', 'I', 10);
 
    $pdf->Cell(130, 10, $timestamp, 0, 2, 'R');

        $pdf->Ln();
        $pdf->SetDrawColor(0, 0, 0); // Black color
        $pdf->SetLineWidth(0.8);
        $pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
        $pdf->Ln(5);
        $pdf->SetLineWidth(0.2); 
    }


 

    return $pdf; // Return the PDF object with the heading for further modifications or output
}


function createReportHeading2($pdf, $conn, $sql, $admissionNumber) {
    // Set font for the PDF
    $pdf->SetFont('Arial', 'I', 8);

    // Prepare the SQL statement
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Failed to prepare statement: " . $conn->error);
    }

    // Bind the admission number parameter
    if (!$stmt->bind_param("s", $admissionNumber)) {
        die("Failed to bind parameters: " . $stmt->error);
    }

    // Execute the SQL statement
    if (!$stmt->execute()) {
        die("Execution failed: " . $stmt->error);
    }

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $pdf->SetFont('Arial', 'B', 13);  // Set font for the heading
        $pdf->Cell(0, 5, "STUDENT DETAILS", 0, 1, 'L');  // Centered heading with reduced cell height
        $pdf->Ln(0.5);  // Minimal space after the heading
    
        while ($row = $result->fetch_assoc()) {
            // Display each record as "column name: value"
            foreach ($row as $columnName => $columnValue) {
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(0, 5, strtoupper($columnName) . ": " . strtoupper($columnValue), 0, 1, 'L');  // Text centered with further reduced cell height
            }
            $pdf->Ln(0.5);  // Minimal space between rows
        }
    
        // Draw a line at the end for visual separation
      //  $pdf->SetDrawColor(0, 0, 0); // Set color to black
      //  $pdf->Line(10, $pdf->GetY(), 200, $pdf->GetY());
        $pdf->Ln(2);  // Slightly reduced padding after the line
    }
    

    $stmt->close();  // Close the prepared statement

    return $pdf;  // Return the modified PDF object
}




















function fetchRecordsP($conn, $sql, $bindParams = [], $bindTypes = '') {
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
    $stmt->execute();

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
    $pdf->Cell(250, 10, 'Powered By AECleanCodes', 0, 2, 'R'); 
    $pdf->Ln(-5);
    $pdf->Cell(250, 10, '0549822202', 0, 2, 'R'); 

    $pdf->Output('F', $finalFileName);

    if ($conn && $conn instanceof mysqli) {
        $conn->close();
    }

    return $isCreated;
}


























?>






















































