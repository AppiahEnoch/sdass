<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../AE/AE.php";

use AE\AE;

//$admission_number = "C12023-1-42";

$admission_number = $_POST['id'];
if (empty($admission_number)) {
    die("Please provide an admission number");
}

$sql = "SELECT student.*, parent.*, school_class.class_name FROM student 
        INNER JOIN parent ON student.admission_number = parent.admission_number 
        LEFT JOIN school_class ON student.student_class = school_class.id
        WHERE student.admission_number = ?";


$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $admission_number);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();



$sql2 = "SELECT * FROM app";
$stmt2 = $conn->prepare($sql2);
$stmt2->execute();
$data2 = $stmt2->get_result()->fetch_assoc();
$stmt2->close();

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetAutoPageBreak(true, 10);  // Set automatic page break

// Logo centered at the top
$pdf->Image('../devimage/logo.png', ($pdf->GetPageWidth() - 33) / 2, 10, 33);
$pdf->Ln(30);  // Adequate padding below the logo

$pdf->Cell(0, 10, $data2['app_name'], 0, 1, 'C');
$pdf->Ln(1);  // Add some space below the school name

// Setting font for the contact details
$pdf->SetFont('Arial', '', 10);
// line spacing
$pdf->Ln(-5); 


// Align the Contact Details to the right
$pdf->Cell(0, 10,$data2['address'], 0, 1, 'C');
$pdf->Ln(-5); 

$pdf->Cell(0, 10, $data2['town'], 0, 1, 'C');
$pdf->Ln(-5);
$pdf->Cell(0, 10, $data2['location'], 0, 1, 'C');
$pdf->Ln(-5);  
$pdf->Cell(0, 10, 'Mobile: '.$data2['mobile'], 0, 1, 'C');
$school_contact=$data2['mobile'];
$pdf->Ln(-5);
$pdf->Cell(0, 10, ' '.$data2['mobile2'], 0, 1, 'C');
$pdf->Ln(-5); 
$pdf->Cell(0, 10, 'Email: '.$data2['email'], 0, 1, 'C');
$school_email=$data2['email'];
$pdf->Ln(-5); 
$pdf->Cell(0, 10, 'Website: '.$data2['website'], 0, 1, 'C');
$pdf->Ln(-1); 
// Date, also aligned to the right
$pdf->SetFont('Arial', 'I', 10);  // Italicized font for the date
$pdf->Ln(-1); 
$pdf->Cell(0, 10, \AE\AE::aeDate(), 0, 1, 'C');
$pdf->Ln(5);  // Some space below the date




// Blue separator line
$pdf->SetDrawColor(0, 0, 255);
$pdf->Line(10, $pdf->GetY(), $pdf->GetPageWidth() - 10, $pdf->GetY());
$pdf->Ln(10);  // Space below the separator line

// Addressing the parent
$pdf->Cell(0, 10, 'Dear ' . $data['parent_first_name'] . ' ' . $data['parent_middle_name'] . ' ' . $data['parent_last_name'] . ',', 0, 1, 'L');
$pdf->Ln(5);

$pdf->SetFont('Arial', 'BU', 12);
$pdf->Cell(0, 10, 'RE: ADMISSION OF ' . $data['first_name'] . ' ' . $data['middle_name'] . ' ' . $data['last_name'], 0, 1, 'C');
$pdf->Ln(10);

$pdf->SetFont('Arial', '', 10);
$recdate=$result = \AE\AE::aeDate($data['recdate']);

$pdf->MultiCell(0, 10, "We're thrilled to welcome " . $data['first_name'] . ' ' . $data['last_name'] . " to the SDA Senior High School Bekwai today (" . $recdate . "). Here are the admission details: Admission Number: " . $data['admission_number'] . " and Class: " . $data['class_name'] . ". We have attached essential information on fees and our academic calendar. Please take a moment to go through them. Should you have any questions, don't hesitate to reach out at " . $school_contact . " or " . $school_email . ". Thank you for entrusting us with " . $data['first_name'] . "'s education. We can't wait to embark on this academic journey together!", 0);

$pdf->Ln(20);

$pdf->Cell(0, 10, 'Accept my congratulations', 0, 1, 'L');
$pdf->Ln(2);


$sql="select * from authority where role='headteacher'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();
// get the title and role
$name=$data['name'];
$title=$data['title'];
$stmt->close();





$pdf->Cell(0, 10, '______________________________', 0, 1, 'L');
$pdf->SetFont('Arial', 'B', 10);
$pdf->Cell(0, 10, $name.' ('.$title.')', 0, 1, 'L');
$pdf->Ln(-3);
$pdf->Cell(0, 10, '(HEADTEACHER)', 0, 1, 'L');

$pdf->Output('F', '../report/admission_letter.pdf'); //  Save to file

//$pdf->Output(); //  Send to browser

echo json_encode(['success' => 'Admission letter generated successfully.']);
// close connection
$conn->close();

?>







