<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../AE/AE.php";

require('../mc_table.php');

ob_end_clean();

$logoPath="../devimage/logo.png";
$reportTitle="Student Bill Report";
$sql1 = "SELECT `app_name` AS School,`email`,`location`as Loc FROM `app`";

$pdf= createReportHeading($conn, $sql1, $reportTitle, $logoPath);

function createReportHeading($conn, $sql1, $reportTitle = 'Report', $logoPath = null) {
    $pdf = new PDF_MC_Table();
    $pdf->AddPage('P', 'A4');
  // Right aligned cell


    //reduce line   space\
  

    $stmt = $conn->prepare($sql1);
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

//$_SESSION['admission_number']="C12023-1-1";

//$admission_number= $_POST['admission_number'];
$admission_number= $_SESSION['admission_number'];
//$admission_number= "N12023-30-110";

// Fetch all students
$sql = "SELECT * FROM student where admission_number='$admission_number'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$students = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();

$start_term_date=null;

foreach ($students as $student) {
    $admission_number = $student['admission_number'];
    // concat student name
    $student_name= $student['first_name'] ." ".$student["middle_name"]. " " . $student['last_name'];
   // $date_of_admission =$student['recdate'];
   $admitted_term = $student['term'];
   $sql = "SELECT * FROM term WHERE term_year = ?";
   $stmt = $conn->prepare($sql);
   $stmt->bind_param("s", $admitted_term);
   $stmt->execute();
   $term = $stmt->get_result()->fetch_assoc();
   
   if ($term) {
       $start_term_date = $term['recdate'];
   } else {
       $start_term_date = null; // or some default value
   }
   


   $pdf->SetFont('Arial', 'B', 14);
   // write start date
  //  $pdf->Cell(0, 6, "Start Date:xxxxxxxxxxxxxxxxxxxxxxxxx start_term_date " . $start_term_date, 0, 1, 'L');
 

    $pdf->SetTextColor(0, 0, 0);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(0, 6, "Admission Number: " . $admission_number, 0, 1, 'L');
    $pdf->Cell(0, 6, "Name: " . $student_name, 0, 1, 'L');
    $pdf->SetTextColor(0, 0, 0);
    $pdf->Ln();
    $pdf->Ln();

  

    $sql = "SELECT term, recdate, student_class_id FROM class_bill WHERE student_class_id = ? GROUP BY term";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $student['student_class']);
    $stmt->execute();
    $terms = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();

    $grandTotal = 0;  // Grand total for all terms
    $grandPaymentTotal=0;

    $iterations=0;

    foreach ($terms as $term) {

        $current_term =$term['term'];




        $term_date=$term['recdate'];

        // compare   $start_term_date with term_date
        if(\AE\AE::isEmpty($start_term_date)){ 
        }
        else{
            if($start_term_date>$term_date){
               continue;
            }
        }

        $student_class="";
        $student_class_id = $term['student_class_id'];
        $sql = "SELECT class_name FROM school_class WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $student_class_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        
        if ($result) {
            $student_class = $result['class_name'];
        } else {
            $student_class = null; // or some default value
        }
        
        $stmt->close();
        




        
        
        
        
        





     





      




        $pdf->SetFont('Arial', 'B', 11);
        $pdf->Cell(0, 10, "Term: " . $term['term'], 0, 1, 'L');
        $pdf->Ln(-5);
        $pdf->Cell(0, 10, "Class: " . $student_class, 0, 1, 'L');

     $term_start_date = $term['recdate'];

        // Check if term start date is more than 30 days before admission
 
    
        $pdf->SetFont('Arial', '', 10);
        $pdf->SetWidths(array(40, 40));
    
        // Table headers for Bills
        $pdf->Row(array('Bill item', 'Amount'));
        
        $sql = "SELECT * FROM class_bill WHERE student_class_id = ? AND term = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $student['student_class'], $term['term']);
        $stmt->execute();
        $bills = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        
        $subTotal = 0;  // Sub total for each term

        $term_total=0;
    
        // Calculate and display the bill items
        foreach ($bills as $bill) {
            $itemName = "N/A";
            
            $sql = "SELECT * FROM bill_item WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $bill['item_id']);
            $stmt->execute();
            $bill_item = $stmt->get_result()->fetch_assoc();
            $stmt->close();

            if ($bill_item) {
                $itemName = $bill_item['item'];
            }

            $subTotal += $bill['bill_amount'];
            $term_total+=$bill['bill_amount'];
            $pdf->Row(array($itemName, $bill['bill_amount']));
        }

        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(40, 10, "Subtotal for Term:", 1, 0, 'R');
        $pdf->Cell(40, 10, number_format($subTotal, 2), 1, 1, 'C');

        $grandTotal += $subTotal;
        $pdf->Ln(-2);  // Add space between bill and payment tables

        // Retrieve older debt records for the student
        $oldDebts = [];
        $sqlDebt = "SELECT * FROM student_old_debt WHERE admission_number = ?";
        $stmtDebt = $conn->prepare($sqlDebt);
        $stmtDebt->bind_param("s", $admission_number); // Assuming $studentAdmissionNumber holds the student's admission number
        $stmtDebt->execute();
        $resultDebt = $stmtDebt->get_result();
        while ($row = $resultDebt->fetch_assoc()) {
            $oldDebts[] = $row;
        }
        $stmtDebt->close();

        // Adding older debts to the PDF
        if($iterations===0){

            if (!empty($oldDebts)) {
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->Cell(0, 10, "Older Debt Records", 0, 1, 'L');
                $pdf->Ln(-2); 
                $pdf->SetFont('Arial', '', 10);
    
                // Headers for the older debts table
              //  $pdf->Cell(30, 10, "Date", 1, 0, 'C');
                $pdf->Cell(40, 10, "item", 1, 0, 'C');
                $pdf->Cell(40, 10, "Amount", 1, 1, 'C');
    
                foreach ($oldDebts as $debt) {
                  //  $pdf->Cell(30, 10, $debt['debt_date'], 1, 0, 'C');
                    $pdf->Cell(40, 10, $debt["description"], 1, 0, 'C'); // Placeholder for debt description
                    $pdf->Cell(40, 10, number_format($debt['amount'], 2), 1, 1, 'C');
                    $grandTotal += $debt['amount'];
                    $term_total+=$debt['amount'];
                }

            }

            // increment iterations 
            $iterations++;

            

        }

        $pdf->Ln(2); 
        
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 10, "Total", 0, 1, 'L');
        $pdf->Ln(-2); 
        $pdf->SetFont('Arial', '', 10);

        // Display the term total
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(40, 10, "Term bill Total:", 1, 0, 'R');
        $pdf->Cell(40, 10, number_format($term_total, 2), 1, 1, 'C');



        // Display the grand total
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(40, 10, "grand Total bill:", 1, 0, 'R');
        $pdf->Cell(40, 10, number_format($grandTotal, 2), 1, 1, 'C');


        $pdf->Ln(2); 





        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(0, 10, "Payments", 0, 1, 'L');
        $pdf->Ln(-2); 
        $pdf->SetFont('Arial', '', 10);

    
        // Table headers for Payments

    


        $sql = "SELECT * FROM student_payment WHERE admission_number = ? AND term_year = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $student['admission_number'], $current_term);
        $stmt->execute();
        $payments = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
    
        $paymentSubTotal = 0;  // Sub total for payments in each term
    
        foreach ($payments as $payment) {
            $paymentItemName = "N/A";
            
            $sql = "SELECT * FROM bill_item WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $payment['payment_type']);
            $stmt->execute();
            $payment_item = $stmt->get_result()->fetch_assoc();
            $stmt->close();
    
            if($payment_item) {
                $paymentItemName = $payment_item['item'];
            }
    
            $paymentSubTotal += $payment['amount'];
            $pdf->Row(array($paymentItemName, $payment['amount']));
        }
        

   
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(40, 10, "Payment Sub.", 1, 0, 'R');
        $pdf->Cell(40, 10, number_format($paymentSubTotal, 2), 1, 1, 'C');

    $hasDebt=false;
    $subTotal=$term_total;


      

        if($paymentSubTotal<$subTotal){
            $hasDebt=true;
            $pdf->SetFont('Arial', 'B', 12);
            // red color
            $pdf->SetTextColor(255, 0, 0);
            $pdf->Cell(40, 10, "Debt:", 1, 0, 'R');
            $pdf->Cell(40, 10, $subTotal-$paymentSubTotal, 1, 1, 'C');
        }
        else{
            $pdf->SetFont('Arial', 'B', 12);
            // green color
            $pdf->SetTextColor(0, 0, 255);
            $pdf->Cell(40, 10, "Change:", 1, 0, 'R');
            $pdf->Cell(40, 10, $paymentSubTotal-$subTotal, 1, 1, 'C');
        }
        $pdf->SetFont('', 'B', 10);
        $pdf->SetTextColor(0, 0, 0);
    
        $grandPaymentTotal += $paymentSubTotal;
        $pdf->Ln();  // Add space after each term
    }
    
    // After the loop, display grand total for payments
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(40, 12, "Grand Payment:", 1, 0, 'R');
    $pdf->Cell(40, 12, number_format($grandPaymentTotal,2), 1, 1, 'C');
    

    // Add Grand Total
    $pdf->Ln();
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(40, 10, "Grand Total:", 1, 0, 'R');
    $pdf->Cell(40, 10, number_format($grandTotal,2), 1, 1, 'C');

    $isOverallDebt=false;
    if($grandPaymentTotal<$grandTotal){
        $isOverallDebt=true;
        $pdf->SetFont('Arial', 'B', 14);
        // red color
        $pdf->SetTextColor(255, 0, 0);
        $pdf->Cell(40, 10, "Overall Debt:", 1, 0, 'R');
        $pdf->Cell(40, 10,number_format(($grandTotal-$grandPaymentTotal),2), 1, 1, 'C');
    }
    else{
        $pdf->SetFont('Arial', 'B', 14);
        // green color
        $pdf->SetTextColor(0, 255, 0);
        $pdf->Cell(40, 10, "Overall Change:", 1, 0, 'R');
        $pdf->Cell(40, 10, $grandPaymentTotal-$grandTotal, 1, 1, 'C');
    }
    $pdf->SetFont('', 'B', 12);
    $pdf->SetTextColor(0, 0, 0);

    $pdf->Ln();
}

//$pdf->Output();
 $pdf->Output('F', '../report/Student_payment.pdf');

 echo 1;

$conn->close();
?>
