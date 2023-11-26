<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

$response = ['status' => 'error', 'message' => 'An error occurred'];

try {
    $userId = $_SESSION['user_id'];
    $filesToUpload = ['timetableUpload', 'academicCalendarUpload'];
    $filePaths = ['timetable' => '', 'academicCalendar' => ''];
    $selectedClass = isset($_POST['admin_upload_class_timetable_select_class']) ? $_POST['admin_upload_class_timetable_select_class'] : NULL;

    if (\AE\AE::isEmpty($selectedClass)) {
        $selectedClass = 0;
    }

    foreach ($filesToUpload as $fileKey) {
        if (isset($_FILES[$fileKey]) && $_FILES[$fileKey]['error'] == UPLOAD_ERR_OK) {
            $file = $_FILES[$fileKey];
            if ($fileKey == 'timetableUpload') {
                $fileName = uniqid('tt_', true) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
                $path = '../timetable/' . $fileName;
                $filePaths['timetable'] = $path;
            } else {
                // Fixed name for academic calendar file
                $fileName = 'academic_calendar.' . pathinfo($file['name'], PATHINFO_EXTENSION);
                $path = '../academic_calendar/' . $fileName;
                $filePaths['academicCalendar'] = $path;
            }

            if (!move_uploaded_file($file['tmp_name'], $path)) {
                throw new Exception("Failed to move uploaded file.");
            }
        }
    }

    $conn->begin_transaction();

    // Handle timetable insert/update
    if ($selectedClass > 0 && !empty($filePaths['timetable'])) {
        $stmtTimetable = $conn->prepare("INSERT INTO timetable (class_id, timetable_url, user_id) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE timetable_url = VALUES(timetable_url)");
        $stmtTimetable->bind_param("isi", $selectedClass, $filePaths['timetable'], $userId);
        $stmtTimetable->execute();
        $stmtTimetable->close();
    }

    // Handle academic calendar insert/update
    if (!empty($filePaths['academicCalendar'])) {
        // FIRST CHECK IF at least one record exists then update it else insert new record
        $stmt = $conn->prepare("SELECT * FROM academic_calendar");
        $stmt->execute();
        $result = $stmt->get_result(); 
        if ($result->num_rows > 0) {
            $stmtAcademic = $conn->prepare("UPDATE academic_calendar SET academic_calendar_url = ?, user_id = ?");
            $stmtAcademic->bind_param("si", $filePaths['academicCalendar'], $userId);
            $stmtAcademic->execute();
            $stmtAcademic->close();
        } else {
            $stmtAcademic = $conn->prepare("INSERT INTO academic_calendar (academic_calendar_url, user_id) VALUES (?, ?)");
            $stmtAcademic->bind_param("si", $filePaths['academicCalendar'], $userId);
            $stmtAcademic->execute();
            $stmtAcademic->close();
        }
    }

    $conn->commit();
    $response['status'] = 'success';
    $response['message'] = 'Files uploaded successfully';
} catch (Exception $e) {
    $conn->rollback();
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
?>
