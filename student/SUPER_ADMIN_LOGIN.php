<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../AE/AE.php";

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



 $_SESSION['staff_id']=$_SESSION['supper_admin_id'];

$staff_id=$_SESSION['staff_id'];

 
    // trim the staff_id
    $staff_id = trim($staff_id);
    
    // Retrieve user details based on staff_id
    $stmt = $conn->prepare("SELECT * FROM registration WHERE staffid = ?");
    $stmt->bind_param("s", $staff_id); // Assuming staffid is a string
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    if ($data) {
        // Set user details into session variables
        $_SESSION['user_id'] = $data['id'];
        $_SESSION['staff_id'] = $data['staffid'];
        $_SESSION['mobile'] = $data['mobile'];
        $_SESSION['email'] = $data['email'];
        $_SESSION['firstname'] = $data['firstname'];
        $_SESSION['middlename'] = $data['middlename'] ?? ''; // Use null coalescing operator for possible null values
        $_SESSION['lastname'] = $data['lastname'];
        $_SESSION['user_type'] = $data['user_type'];
        $_SESSION['userClass'] = $data['userClass'];
        $_SESSION['username'] = $data['username'];
        $_SESSION['profile_pic'] = $data['profile_pic'] ?? ''; // Use null coalescing operator for possible null values

        // Get the class name
        $class_name_query = "SELECT class_name FROM school_class WHERE id = ?";
        $class_stmt = $conn->prepare($class_name_query);
        $class_stmt->bind_param("i", $data['userClass']);
        $class_stmt->execute();
        $class_result = $class_stmt->get_result();
        $class_data = $class_result->fetch_assoc();

        $_SESSION['userClass_name'] = $class_data ? $class_data['class_name'] : "not found";

        $class_stmt->close();

        // Update the log for this user
        $log_sql = "INSERT INTO log (user_id, recdate) VALUES (?, CURRENT_TIMESTAMP) 
                    ON DUPLICATE KEY UPDATE recdate = CURRENT_TIMESTAMP";
        $log_stmt = $conn->prepare($log_sql);
        $log_stmt->bind_param("i", $data['id']); // Assuming the 'id' column is the integer identifier
        $log_stmt->execute();
        $log_stmt->close();

        // Output the user type
        echo $_SESSION['user_type'];
    } else {
        echo json_encode(["message" => "Staff ID not found!"]);
    }
    $stmt->close();





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




