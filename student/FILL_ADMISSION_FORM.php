<?php
use PhpOffice\PhpWord\TemplateProcessor;


$admission_number = $_SESSION['index_number'] ?? '';

// Load the Word Template
$templateProcessor = new TemplateProcessor('admissionForm.docx');

// Fetch the student data from the database
$query = "
    SELECT s.*, 
           f.father_first_name, f.father_middle_name, f.father_last_name, f.father_mobile, 
           m.mother_first_name, m.mother_middle_name, m.mother_last_name, m.mother_mobile, 
           p.parent_first_name, p.parent_middle_name, p.parent_last_name, p.parent_email, 
           p.parent_house_address, p.parent_mobile, p.parent_digital_address,
        p.relationship_with_child
    FROM student s
    LEFT JOIN father f ON s.admission_number = f.admission_number
    LEFT JOIN mother m ON s.admission_number = m.admission_number
    LEFT JOIN parent p ON s.admission_number = p.admission_number
    WHERE s.admission_number = ?";

$stmt = $conn->prepare($query);
$stmt->bind_param("s", $admission_number);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    // Format the date of birth
    $dob = new DateTime($row['date_of_birth']);
 
    $formatted_date=\AE\AE::aeDate1($row['date_of_birth']);

 



    // Calculate age
    $today = new DateTime();
    $age = $today->diff($dob)->y;

    if($age==0){
        $age = "#";
    }

    // Replace placeholders with actual data
    $fullName = strtoupper($row['first_name'] . ' ' . $row['middle_name'] . ' ' . $row['last_name']);
    $templateProcessor->setValue('studfname', strtoupper($fullName));
    $templateProcessor->setValue('admission',  strtoupper($row['sdass_admission_number']));
    $templateProcessor->setValue('sex',  strtoupper($row['gender']));
    $templateProcessor->setValue('dob',  strtoupper($formatted_date));
    $templateProcessor->setValue('age',  strtoupper($age));
    $templateProcessor->setValue('pob', strtoupper($row['home_town']));
    $templateProcessor->setValue('hometown', strtoupper($row['home_town']));
    $templateProcessor->setValue('region', strtoupper($row['region']));
    $templateProcessor->setValue('religion', strtoupper($row['religion']));
    $templateProcessor->setValue('denom', strtoupper($row['denomination']));
    $templateProcessor->setValue('lastschool', strtoupper($row['last_school']));
    $templateProcessor->setValue('beceindex', strtoupper($row['admission_number']));
    $templateProcessor->setValue('beceyear', strtoupper($row['bece_year']));
    $templateProcessor->setValue('aggr', strtoupper($row['aggregate1']));
    $templateProcessor->setValue('sick', strtoupper($row['has_health_problem']));
    $templateProcessor->setValue('sickdesc', strtoupper($row['health_problem_details']));

    $fname = $row['father_first_name'] . ' ' . $row['father_middle_name'] . ' ' . $row['father_last_name'];
    $mname = $row['mother_first_name'] . ' ' . $row['mother_middle_name'] . ' ' . $row['mother_last_name'];
    $gname = $row['parent_first_name'] . ' ' . $row['parent_middle_name'] . ' ' . $row['parent_last_name'];

    $templateProcessor->setValue('fname', strtoupper($fname));
    $templateProcessor->setValue('fcontact', strtoupper($row['father_mobile']));
    $templateProcessor->setValue('mname', strtoupper($mname));
    $templateProcessor->setValue('mcontact', strtoupper($row['mother_mobile']));
    $templateProcessor->setValue('gname', strtoupper($gname));
    $templateProcessor->setValue('gcontact', strtoupper($row['parent_mobile']));
    $templateProcessor->setValue('gemail', ($row['parent_email']));
    $templateProcessor->setValue('postal', strtoupper($row['parent_house_address']));
    $templateProcessor->setValue('digitaladdress', strtoupper($row['parent_digital_address']));


    $templateProcessor->setValue('status',strtoupper($row['boarding_status']));
    $templateProcessor->setValue('house', strtoupper($row['house']));
    $templateProcessor->setValue('program', strtoupper($row['programme']));
    $templateProcessor->setValue('studclass', "Not Assigned");
    $templateProcessor->setValue('studfullname', strtoupper($row['first_name'] . ' ' . $row['last_name']));
    $recdate=\AE\AE::aeDate1($row['recdate']);
    $templateProcessor->setValue('recdate', $recdate);
}

$docxFilePath = '../DOCX_FORMS/' . $admission_number . '.docx';
$templateProcessor->saveAs($docxFilePath);

