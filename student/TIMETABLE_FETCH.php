<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

// CREATE TABLE resource_lock (
//     id INT AUTO_INCREMENT PRIMARY KEY,
//     resource_id VARCHAR(255) UNIQUE,
//     lock_status INT DEFAULT 0 CHECK (lock_status IN (0, 1)),
//     recdate TIMESTAMP DEFAULT CURRENT_TIMESTAMP
//   );


$sql = "SELECT * FROM resource_lock WHERE resource_id = 'timetable' AND lock_status = 0 ORDER BY recdate DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Resource is locked
    echo json_encode(["success" => false, "message" => "Resource is locked"]);
    exit;
} else {
    // Resource is not locked
    //echo json_encode(["success" => true, "message" => "Resource is not locked"]);
}



  
















$class_id = $_SESSION['userClass'] ?? '';



$response = [
    'timetable_url' => '',
    'academic_calendar_url' => ''
];

if ($class_id) {
    $stmt = $conn->prepare("SELECT timetable_url FROM timetable WHERE class_id = ?");
    $stmt->bind_param("s", $class_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $response['timetable_url'] = $row['timetable_url'];
    }

    $stmt->close();
}

echo json_encode($response);
?>
