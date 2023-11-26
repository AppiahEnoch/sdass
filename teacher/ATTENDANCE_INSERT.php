<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

if (isset($_FILES['teacher_upload_student_attendance_excel_file']) && isset($_POST['teacher_upload_student_attendance_max_value'])) {
    
    $maxAttendance = $_POST['teacher_upload_student_attendance_max_value'];
    
    $file = $_FILES['teacher_upload_student_attendance_excel_file']['tmp_name'];
    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file);
    $worksheet = $spreadsheet->getActiveSheet();
    $rows = $worksheet->toArray();

    array_shift($rows);

    $conn->begin_transaction();

    try {
        $stmt = $conn->prepare("INSERT INTO student_attendance (admission_number, mark, max_mark) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE mark=?, max_mark=?");

        foreach ($rows as $row) {
            $admissionNumber = trim($row[1]);

            if (AE::isEmpty($admissionNumber)) {
                throw new Exception("Invalid admission number detected.");
            }

            $mark = isset($row[5]) && is_numeric($row[5]) ? intval($row[5]) : 0;

            if($mark < 0) {
                $mark = 0;
            } elseif($mark > $maxAttendance) {
                $mark = $maxAttendance;
            }

            $stmt->bind_param('siiii', $admissionNumber, $mark, $maxAttendance, $mark, $maxAttendance);

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
