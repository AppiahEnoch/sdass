<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../AE/AE.php";

use AE\AE;

//$admission_number = "C12023-1-42";
//$admission_number = "N22023-2-98";
$admission_number = $_POST['id'];

if (empty($admission_number)) {
    die("Please provide an admission number");
}

$sql = "SELECT student.*, parent.*, school_class.class_name, father.*, mother.*, 
        qualifications.name AS father_qualification_name, 
        mother_qualifications.name AS mother_qualification_name
        FROM student 
        INNER JOIN parent ON student.admission_number = parent.admission_number 
        LEFT JOIN school_class ON student.student_class = school_class.id
        LEFT JOIN father ON student.admission_number = father.admission_number
        LEFT JOIN mother ON student.admission_number = mother.admission_number
        LEFT JOIN qualifications ON father.father_education = qualifications.id
        LEFT JOIN qualifications AS mother_qualifications ON mother.mother_education = mother_qualifications.id
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
$pdf->SetAutoPageBreak(true, 10);  // Set automatic page break

// School Logo at the left
$pdf->Image('../devimage/logo.png', 10, 10, 33);

// School name in bold and larger font
$pdf->SetFont('Arial', 'B', 16);
$pdf->Ln(5);
$pdf->Cell(0, 10, $data2['app_name'], 0, 1, 'C');

// Resetting font size for address details
$pdf->SetFont('Arial', '', 12);

// Address centered
$pdf->Cell(0, 10, $data2['address'], 0, 1, 'C');
// REDUCE  LINE SPACING
$pdf->Ln(-5);
$pdf->Cell(0, 10, $data2['town'], 0, 1, 'C');
$pdf->Ln(-5);
$pdf->Cell(0, 10, $data2['region'], 0, 1, 'C');
$pdf->Ln(-5);
$pdf->Cell(0, 10, $data2['mobile'], 0, 1, 'C');
$pdf->Ln(-5);
$pdf->Cell(0, 10, $data2['mobile2'], 0, 1, 'C');
$pdf->Ln(-3);

// bold underline

$pdf->SetFont('Arial', 'BU', 12);
$pdf->Cell(0, 10, "ADMISSION FORM", 0, 1, 'C');

// Resetting font size for the rest of the content
$pdf->SetFont('Arial', '', 12);

// Add a line under the header

$pdf->Ln(-10);
$rectHeight = 5;
$rectWidth = $pdf->GetPageWidth() - 20;  // 20 for margins (10 each side)
 // You can adjust this based on your requirement
$rectX = 10;  // Starting from the left margin 

$rectY = $pdf->GetY() + 10;  // Position after the last item, with a bit of padding

// Drawing the rectangle with black background
$rec=80;
$pdf->SetFillColor($rec,$rec,$rec);


$pdf->Rect($rectX, $rectY, $rectWidth, $rectHeight, 'F');
$pdf->Ln(-5);
// Adding the white text
$pdf->SetTextColor(255, 255, 255);  // Setting text color to white
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetXY($rectX, $rectY);

$pdf->Cell($rectWidth, $rectHeight, "CHILD'S PERSONAL DETAILS", 0, 1, 'C');

$pdf->SetTextColor(0, 0, 0);  // Resetting text color to black for subsequent items

$imagePath=$data['student_passport_image_input']; 


if(\AE\AE::isEmpty($imagePath)) {
    $imagePath = '../devimage/placeholder.png';
}   



// Student Passport Image at the right
\AE\AE::image_orientation($imagePath);

$fixedWidth = 35; // For example, set this to your desired width
$fixedHeight = 35; // For example, set this to your desired height

$pdf->Image($imagePath, ($pdf->GetPageWidth() - $fixedWidth - 3), 10, $fixedWidth, $fixedHeight);

$pdf->Ln(1);



$labelWidth = 60;
$labelFontSize = 11;
$valueFontSize = 11;
$lineSpacing = 4;

$pdf->SetFont('Arial', 'B', $labelFontSize);
$pdf->Cell($labelWidth, $lineSpacing, "Child's Name:", 0, 0, 'L');
$pdf->SetFont('Arial', '', $valueFontSize);
$pdf->Cell(0, $lineSpacing, $data["first_name"]." ".$data["middle_name"]." ".$data["last_name"], 0, 1, 'L');

// add admission number
$pdf->SetFont('Arial', 'B', $labelFontSize);
$pdf->Cell($labelWidth, $lineSpacing, "Admission Number:", 0, 0, 'L');
$pdf->SetFont('Arial', '', $valueFontSize); 
$pdf->Cell(0, $lineSpacing, $data["admission_number"], 0, 1, 'L');



$pdf->SetFont('Arial', 'B', $labelFontSize);
$pdf->Cell($labelWidth, $lineSpacing, "Date Of Birth:", 0, 0, 'L');
$pdf->SetFont('Arial', '', $valueFontSize);
$pdf->Cell(0, $lineSpacing, \AE\AE::aeDate1($data["date_of_birth"]), 0, 1, 'L');

$pdf->SetFont('Arial', 'B', $labelFontSize);
$pdf->Cell($labelWidth, $lineSpacing, "Gender:", 0, 0, 'L');
$pdf->SetFont('Arial', '', $valueFontSize);
$pdf->Cell(0, $lineSpacing, $data["gender"], 0, 1, 'L');

$pdf->SetFont('Arial', 'B', $labelFontSize);
$pdf->Cell($labelWidth, $lineSpacing, "Nationality:", 0, 0, 'L');
$pdf->SetFont('Arial', '', $valueFontSize);
$pdf->Cell(0, $lineSpacing, $data["child_nationality"], 0, 1, 'L');

$pdf->SetFont('Arial', 'B', $labelFontSize);
$pdf->Cell($labelWidth, $lineSpacing, "Class:", 0, 0, 'L');
$pdf->SetFont('Arial', '', $valueFontSize);
$pdf->Cell(0, $lineSpacing, $data["class_name"], 0, 1, 'L');

$pdf->SetFont('Arial', 'B', $labelFontSize);
$pdf->Cell($labelWidth, $lineSpacing, "Date of Admission:", 0, 0, 'L');
$pdf->SetFont('Arial', '', $valueFontSize);
$pdf->Cell(0, $lineSpacing, \AE\AE::aeDate0($data["date_of_admission"]), 0, 1, 'L');

$pdf->SetFont('Arial', 'B', $labelFontSize);
$pdf->Cell($labelWidth, $lineSpacing, "Ghana Card Number:", 0, 0, 'L');
$pdf->SetFont('Arial', '', $valueFontSize);
$pdf->Cell(0, $lineSpacing, $data["ghana_card_number"], 0, 1, 'L');

$pdf->SetFont('Arial', 'B', $labelFontSize);
$pdf->Cell($labelWidth, $lineSpacing, "Health Problems:", 0, 0, 'L');
$pdf->SetFont('Arial', '', $valueFontSize);
$pdf->Cell(0, $lineSpacing, ($data["has_health_problem"] ? 'Yes' : 'No'), 0, 1, 'L');

if($data["has_health_problem"]) {
    $pdf->SetFont('Arial', 'B', $labelFontSize);
    $pdf->Cell($labelWidth, $lineSpacing, "Health Problem Details:", 0, 0, 'L');
    $pdf->SetFont('Arial', '', $valueFontSize);
    $pdf->Cell(0, $lineSpacing, $data["health_problem_details"], 0, 1, 'L');
}

$pdf->SetFont('Arial', 'B', $labelFontSize);
$pdf->Cell($labelWidth, $lineSpacing, "Special Needs:", 0, 0, 'L');
$pdf->SetFont('Arial', '', $valueFontSize);
$pdf->Cell(0, $lineSpacing, ($data["has_special_needs"] ? 'Yes' : 'No'), 0, 1, 'L');

if($data["has_special_needs"]) {
    $pdf->SetFont('Arial', 'B', $labelFontSize);
    $pdf->Cell($labelWidth, $lineSpacing, "Special Needs Details:", 0, 0, 'L');
    $pdf->SetFont('Arial', '', $valueFontSize);
    $pdf->Cell(0, $lineSpacing, $data["special_needs_details"], 0, 1, 'L');
}




$pdf->Ln(-5);

$rectWidth = $pdf->GetPageWidth() - 20;  // 20 for margins (10 each side)
  // You can adjust this based on your requirement
$rectX = 10;  // Starting from the left margin 

$rectY = $pdf->GetY() + 10;  // Position after the last item, with a bit of padding

// Drawing the rectangle with black background
$pdf->SetFillColor($rec,$rec,$rec);
$pdf->Rect($rectX, $rectY, $rectWidth, $rectHeight, 'F');

// Adding the white text
$pdf->SetTextColor(255, 255, 255);  // Setting text color to white
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetXY($rectX, $rectY);
$pdf->Cell($rectWidth, $rectHeight, "GUARDIAN'S DETAILS", 0, 1, 'C');

$pdf->SetTextColor(0, 0, 0); 

// reset font size
$pdf->SetFont('Arial', '', 12);



$pdf->SetFont('Arial', 'B', $labelFontSize);
$pdf->Cell($labelWidth, $lineSpacing, "Guardian:", 0, 0, 'L');
$pdf->SetFont('Arial', '', $valueFontSize);
$pdf->Cell(0, $lineSpacing, $data["parent_first_name"]." ".$data["parent_middle_name"]." ".$data["parent_last_name"], 0, 1, 'L');

$pdf->SetFont('Arial', 'B', $labelFontSize);
$pdf->Cell($labelWidth, $lineSpacing, "Guardian Mobile:", 0, 0, 'L');
$pdf->SetFont('Arial', '', $valueFontSize);
$pdf->Cell(0, $lineSpacing, $data["parent_mobile"], 0, 1, 'L');



$pdf->SetFont('Arial', 'B', $labelFontSize);
$pdf->Cell($labelWidth, $lineSpacing, "Guardian Email:", 0, 0, 'L');
$pdf->SetFont('Arial', '', $valueFontSize);
$pdf->Cell(0, $lineSpacing, $data["parent_email"], 0, 1, 'L');



$pdf->SetFont('Arial', 'B', $labelFontSize);
$pdf->Cell($labelWidth, $lineSpacing, "Location:", 0, 0, 'L');
$pdf->SetFont('Arial', '', $valueFontSize);
$pdf->Cell(0, $lineSpacing, $data["parent_location"], 0, 1, 'L');

$pdf->SetFont('Arial', 'B', $labelFontSize);
$pdf->Cell($labelWidth, $lineSpacing, "Residential Address:", 0, 0, 'L');
$pdf->SetFont('Arial', '', $valueFontSize);
$pdf->Cell(0, $lineSpacing, $data["parent_house_address"], 0, 1, 'L');

$pdf->SetFont('Arial', 'B', $labelFontSize);
$pdf->Cell($labelWidth, $lineSpacing, "Occupation:", 0, 0, 'L');
$pdf->SetFont('Arial', '', $valueFontSize);
$pdf->Cell(0, $lineSpacing, $data["parent_occupation"], 0, 1, 'L');

$pdf->SetFont('Arial', 'B', $labelFontSize);
$pdf->Cell($labelWidth, $lineSpacing, "Relationship with Child:", 0, 0, 'L');
$pdf->SetFont('Arial', '', $valueFontSize);
$pdf->Cell(0, $lineSpacing, $data["relationship_with_child"], 0, 1, 'L');



$rectWidth = $pdf->GetPageWidth() - 20;  // 20 for margins (10 each side)
// You can adjust this based on your requirement
$rectX = 10;  // Starting from the left margin 

$rectY = $pdf->GetY() + 10;  // Position after the last item, with a bit of padding

// Drawing the rectangle with black background
$pdf->SetFillColor($rec,$rec,$rec);
$pdf->Rect($rectX, $rectY, $rectWidth, $rectHeight, 'F');

// Adding the white text
$pdf->SetTextColor(255, 255, 255);  // Setting text color to white
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetXY($rectX, $rectY);
$pdf->Cell($rectWidth, $rectHeight, "FAHTERS'S DETAILS", 0, 1, 'C');

$pdf->SetTextColor(0, 0, 0); 

// reset font size
$pdf->SetFont('Arial', '', 12);


$fatherFullName = $data["father_first_name"]." ".$data["father_middle_name"]." ".$data["father_last_name"];

$pdf->SetFont('Arial', 'B', $labelFontSize);
$pdf->Cell($labelWidth, $lineSpacing, "Name:", 0, 0, 'L');
$pdf->SetFont('Arial', '', $valueFontSize);
$pdf->Cell(0, $lineSpacing, $fatherFullName, 0, 1, 'L');

$pdf->SetFont('Arial', 'B', $labelFontSize);
$pdf->Cell($labelWidth, $lineSpacing, "Edu. Qualification", 0, 0, 'L');
$pdf->SetFont('Arial', '', $valueFontSize);
$pdf->Cell(0, $lineSpacing, $data["father_qualification_name"], 0, 1, 'L');

$pdf->SetFont('Arial', 'B', $labelFontSize);
$pdf->Cell($labelWidth, $lineSpacing, "Occupation:", 0, 0, 'L');
$pdf->SetFont('Arial', '', $valueFontSize);
$pdf->Cell(0, $lineSpacing, $data["father_occupation"], 0, 1, 'L');

$pdf->SetFont('Arial', 'B', $labelFontSize);
$pdf->Cell($labelWidth, $lineSpacing, "Mobile:", 0, 0, 'L');
$pdf->SetFont('Arial', '', $valueFontSize);
$pdf->Cell(0, $lineSpacing, $data["father_mobile"], 0, 1, 'L');

$pdf->SetFont('Arial', 'B', $labelFontSize);
$pdf->Cell($labelWidth, $lineSpacing, "Residential Address:", 0, 0, 'L');
$pdf->SetFont('Arial', '', $valueFontSize);
$pdf->Cell(0, $lineSpacing, $data["father_residential_address"], 0, 1, 'L');






$rectWidth = $pdf->GetPageWidth() - 20;  // 20 for margins (10 each side)
// You can adjust this based on your requirement
$rectX = 10;  // Starting from the left margin 

$rectY = $pdf->GetY() + 10;  // Position after the last item, with a bit of padding

// Drawing the rectangle with black background
$pdf->SetFillColor($rec,$rec,$rec);
$pdf->Rect($rectX, $rectY, $rectWidth, $rectHeight, 'F');

// Adding the white text
$pdf->SetTextColor(255, 255, 255);  // Setting text color to white
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetXY($rectX, $rectY);
$pdf->Cell($rectWidth, $rectHeight, "MOTHER'S DETAILS", 0, 1, 'C');

$pdf->SetTextColor(0, 0, 0); 

// reset font size
$pdf->SetFont('Arial', '', 12);





$mother_FullName = $data["mother_first_name"]." ".$data["mother_middle_name"]." ".$data["mother_last_name"];

$pdf->SetFont('Arial', 'B', $labelFontSize);
$pdf->Cell($labelWidth, $lineSpacing, "Name:", 0, 0, 'L');
$pdf->SetFont('Arial', '', $valueFontSize);
$pdf->Cell(0, $lineSpacing, $mother_FullName, 0, 1, 'L');

$pdf->SetFont('Arial', 'B', $labelFontSize);
$pdf->Cell($labelWidth, $lineSpacing, "Edu.Qualification:", 0, 0, 'L');
$pdf->SetFont('Arial', '', $valueFontSize);
$pdf->Cell(0, $lineSpacing, $data["mother_qualification_name"], 0, 1, 'L');

$pdf->SetFont('Arial', 'B', $labelFontSize);
$pdf->Cell($labelWidth, $lineSpacing, "Occupation:", 0, 0, 'L');
$pdf->SetFont('Arial', '', $valueFontSize);
$pdf->Cell(0, $lineSpacing, $data["mother_occupation"], 0, 1, 'L');

$pdf->SetFont('Arial', 'B', $labelFontSize);
$pdf->Cell($labelWidth, $lineSpacing, "Mobile:", 0, 0, 'L');
$pdf->SetFont('Arial', '', $valueFontSize);
$pdf->Cell(0, $lineSpacing, $data["mother_mobile"], 0, 1, 'L');

$pdf->SetFont('Arial', 'B', $labelFontSize);
$pdf->Cell($labelWidth, $lineSpacing, "Residential Address:", 0, 0, 'L');
$pdf->SetFont('Arial', '', $valueFontSize);
$pdf->Cell(0, $lineSpacing, $data["mother_residential_address"], 0, 1, 'L');


$pdf->Ln(5);
$pdf->SetFont('Arial', '', 12);



$pdf->Cell(0, $lineSpacing,"I, the undersigned, hereby acknowledge on behalf of the child and", 0, 1, 'L');
$pdf->Cell(0, $lineSpacing,"myself that I have read, understood, and agree to abide by the school's rules and regulations.", 0, 1, 'L');
// signature line ...
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(0, 10, "Guardian signature..........                                    Headteacher signature...........", 0, 1, 'L');





$pdf->Ln(2);
$pdf->SetFont('Arial', 'I', 8);
$pdf->Cell(0, 10, "Date printed: ".\AE\AE::aeDate0()." ", 0, 1, 'C');

$pdf->Output('F', '../report/admission_form.pdf');
// output
$pdf->Output();
?>
