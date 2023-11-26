<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

if (isset($_FILES['tearcher_file_for_assessment']) && isset($_POST['teaccher_select_subject']) && isset($_POST['assessment_type']) && isset($_POST['mark_out_of'])) {
    
    echo 1;
    $subjectId = $_POST['teaccher_select_subject'];
    $assessmentTypeId = $_POST['assessment_type'];
    $markOutOf = $_POST['mark_out_of'];
    $userId = $_SESSION['user_id'];
    $classId = $_SESSION['userClass'];
    $termYear = $_SESSION['current_term'];
    
    $file = $_FILES['tearcher_file_for_assessment']['tmp_name'];
    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
    $worksheet = $spreadsheet->getActiveSheet();
    $rows = $worksheet->toArray();

    array_shift($rows);

    $conn->begin_transaction();

    try {
        $stmt = $conn->prepare("INSERT INTO assessment (admission_number, subject_id, user_id, class_id, term_year, mark, mark_out_of, assessment_type_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE mark=?, mark_out_of=?");
        
        foreach ($rows as $row) {
            $admissionNumber = trim($row[1]);
            
            if (AE::isEmpty($admissionNumber)) {
                throw new Exception("Invalid admission number detected.");
            }

            $mark = isset($row[5]) && is_numeric($row[5]) ? floatval($row[5]) : 0;

            if($mark < 0) {
                $mark = 0;
            } elseif($mark > $markOutOf) {
                $mark = $markOutOf;
            }

            $stmt->bind_param('siiissddii', $admissionNumber, $subjectId, $userId, $classId, $termYear, $mark, $markOutOf, $assessmentTypeId, $mark, $markOutOf);

            $stmt->execute();
        }

        $stmt->close();
        $conn->commit();
        echo json_encode(['success' => true]);

    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
}
?>
