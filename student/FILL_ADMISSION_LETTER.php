<?php
$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor('admissionletter.docx');
$admission_number = $_SESSION["index_number"];
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
    // Prepare and format data
    $recdate=\AE\AE::aeDate1($row['recdate']);
    $studentFullName = strtoupper($row['first_name'] . ' ' . ($row['middle_name'] ? $row['middle_name'] . ' ' : '') . $row['last_name']);
    $studentHouse = strtoupper($row['house']);
    $program = strtoupper($row['programme']);
    $status = strtoupper($row["boarding_status"]);

    // Use appropriate columns for guardian address and admission
    // Assuming guardianaddress and admission need to be fetched from relevant columns
    $guardianAddress = strtoupper($row['parent_house_address']);
    $admission = strtoupper($row['sdass_admission_number']);

    // Replace placeholders with actual data
    $templateProcessor->setValue('program', $program);
    $templateProcessor->setValue('status', $status);
    $templateProcessor->setValue('admission', $admission);
    $templateProcessor->setValue('recdate', $recdate);
    $templateProcessor->setValue('studentfullname', $studentFullName);
    $templateProcessor->setValue('guardianaddress', $guardianAddress);
    $templateProcessor->setValue('studentHouse', $studentHouse);

    // Save the document
    $docxFilePath = "../DOCX_LETTERS/" . $admission_number . ".docx";
    $templateProcessor->saveAs($docxFilePath);
}
