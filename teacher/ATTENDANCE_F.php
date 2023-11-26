<?php
// fetchAttendanceData.php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

$class_id=$_SESSION['userClass'];
$sql = "SELECT sa.id, sa.admission_number, CONCAT(s.first_name, ' ', s.last_name) AS fullname, sa.mark, sa.max_mark
        FROM student_attendance sa
        INNER JOIN student s ON sa.admission_number = s.admission_number
        INNER JOIN student_current_class scc ON s.admission_number = scc.admission_number
        WHERE scc.class_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $class_id);
$stmt->execute();
$result = $stmt->get_result();

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}
echo json_encode($data);