<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../AE/AE.php";





// first check if is set Post super_admin_login

if(isset($_POST["super_admin_login"])){
    $_SESSION['super_admin_login'] ="yes";
 $_SESSION['supper_admin_id'] =  $_SESSION['staff_id'];
}


$log_id=0;

$sql = "SELECT * FROM term order by  current_term desc,recdate desc limit 1";
$result = $conn->query($sql);

$terms = [];

$first_term = true;

if ($result->num_rows > 0) {
    while   ($row = $result->fetch_assoc()) {
        $terms[] = $row;
            $first_term = false;
            $_SESSION['current_term'] = $row['term_year'];

          
    }
}








$password = $_POST['password'];

// TO UPPER CASE
$password = strtoupper($password);

$sql4 = "SELECT * FROM student WHERE admission_number=?";
$stmt4 = $conn->prepare($sql4);
if ($stmt4 === false) {
    // handle error appropriately
    exit;
}

$stmt4->bind_param("s", $password);

if (!$stmt4->execute()) {
    // handle error appropriately
    exit;
}

$isStudent = false;
$result4 = $stmt4->get_result();
if ($result4->num_rows > 0) {
    $row4 = $result4->fetch_assoc();
    echo "student";
    $isStudent = true;
    $_SESSION['admission_number'] = $row4['admission_number'];
    $log_id = $row4['admission_number'];
    // user_id
    $_SESSION['user_id'] = $row4['id'];

    // You can add additional session variables or actions here if needed
    // ...

} else {
    echo "Login failed. Admission number not found.";
}
$stmt4->close();


if ($isStudent) {

    $sqlLog = "INSERT INTO log (user_id) VALUES (?) ON DUPLICATE KEY UPDATE recdate = CURRENT_TIMESTAMP";
    $stmtLog = $conn->prepare($sqlLog);
    $stmtLog->bind_param("i", $log_id);
    $stmtLog->execute();
    $stmtLog->close();

    $admission_number = $_SESSION['admission_number'];

    // get current class
    $sql5 = "SELECT * FROM student_current_class WHERE admission_number=?";
    $stmt5 = $conn->prepare($sql5);
    if ($stmt5 === false) {
        // handle error appropriately
        exit;
    }
$stmt5->bind_param("s", $admission_number);
$stmt5->execute();
$result5 = $stmt5->get_result();
if ($result5->num_rows > 0) {
    $row5 = $result5->fetch_assoc();
    $_SESSION['userClass'] = $row5['class_id'];
} else {
    $_SESSION['userClass'] = 1; // default to class 1



}


// get current class name
$sql6 = "SELECT * FROM school_class WHERE id=?";
$stmt6 = $conn->prepare($sql6);
if ($stmt6 === false) {
    // handle error appropriately
    exit;
}
$stmt6->bind_param("i", $_SESSION['userClass']);
$stmt6->execute();
$result6 = $stmt6->get_result();
if ($result6->num_rows > 0) {
    $row6 = $result6->fetch_assoc();
    $_SESSION['userClass_name'] = $row6['class_name'];
} else {
    $_SESSION['userClass_name'] = "Not Set"; // default to class 1
}
$stmt6->close();


}

// get total student
try {
    $sql7 = "SELECT count(*) as total FROM student_current_class WHERE class_id=?";
    $stmt7 = $conn->prepare($sql7);
    if ($stmt7 === false) {
        throw new Exception("Error preparing the SQL statement: " . $conn->error);
    }

    $stmt7->bind_param("i", $_SESSION['userClass']);

    if (!$stmt7->execute()) {
        throw new Exception("Error executing the SQL statement: " . $stmt7->error);
    }

    $result7 = $stmt7->get_result();
    if ($result7->num_rows > 0) {
        $row7 = $result7->fetch_assoc();
        $_SESSION['total_student'] = $row7['total'];
    } else {
        $_SESSION['total_student'] = 0;
    }
    $stmt7->close();
} catch (Exception $e) {
    die("An error occurred: " . $e->getMessage());
}


// get promoted class name
$ctr= $_SESSION['userClass'];
$ctr=$ctr+1;
$stmt6 = $conn->prepare('SELECT * FROM school_class WHERE id=?');
$stmt6->bind_param('i', $ctr);
$stmt6->execute();
$result6 = $stmt6->get_result();
if ($result6->num_rows > 0) {
    $row6 = $result6->fetch_assoc();
    $_SESSION['promoted_class_name'] = $row6['class_name'];
} else {
    $_SESSION['promoted_class_name'] = "Completed"; // default to class 1
}
$stmt6->close();


echo 1;

?>
