<?php
session_start();
require_once './vendor/autoload.php';
include "./config/config.php";
include "./config/settings.php";
include "./AE/AE.php";


// first check if is set Post super_admin_login




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



if (isset($_POST['username']) && isset($_POST['password'])) {



      
  





    
    
    // Check if username exists in the database
    $stmt = $conn->prepare("SELECT * FROM registration WHERE username = ?");
    $stmt->bind_param("s", $_POST['username']);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    if ($result->num_rows > 0) {
        // Verify password
        if (password_verify($_POST['password'], $data['password'])) {
            $response["status"] = "success";
           
            // Set user details into session variables
            $_SESSION['user_id'] = $data['id'];
            $_SESSION['staff_id'] = $data['staffid'];
            $log_id= $data['staffid'];
            
            $_SESSION['mobile'] = $data['mobile'];
            $_SESSION['email'] = $data['email'];
            $_SESSION['firstname'] = $data['firstname'];
            $_SESSION['middlename'] = $data['middlename'];
            $_SESSION['lastname'] = $data['lastname'];
            $_SESSION['userClass'] = $data['userClass'];
            $_SESSION['user_type'] = $data['user_type'];
            $_SESSION['username'] = $data['username'];
            $_SESSION['profile_pic'] = $data['profile_pic'];
            $_SESSION['recdate'] = $data['recdate'];

            echo $_SESSION['user_type'];

            if (strtolower($_SESSION['user_type']) == "admin") {
                $_SESSION["admin_login"] = "yes";
            }
            

            if (\AE\AE::isEmpty($_SESSION['userClass'])) {
                $_SESSION['userClass_name']="not found";
                $_SESSION['userClass']="1";
            }
            else{
                $sql2="select class_name from school_class where id=".$_SESSION['userClass'];
                $result2 = $conn->query($sql2);

                if ($result2 !== null) {
                    $row2 = $result2->fetch_assoc();
                    $_SESSION['userClass_name']=$row2['class_name'];
                } else {
                    // handle error appropriately
                    $_SESSION['userClass_name']="not found";
                }
            }

            // close 
            $stmt->close();

            $ctr= $_SESSION['userClass'];
            $ctr=$ctr+1;


            $sql2="select class_name from school_class where id=".$ctr;
            $result2 = $conn->query($sql2);

            if ($result2 !== null) {
                $row2 = $result2->fetch_assoc();
                $_SESSION['promoted_class_name']=$row2['class_name'];
            } else {
                // handle error appropriately
                $_SESSION['promoted_class_name']="Completed";
            }



            try {
                $sql3 = "SELECT count(*) as total FROM student_current_class WHERE class_id=?";
                $stmt = $conn->prepare($sql3);
                if ($stmt === false) {
                    throw new Exception("Error preparing the SQL statement: " . $conn->error);
                }
            
                $stmt->bind_param("i", $_SESSION['userClass']);
            
                if (!$stmt->execute()) {
                    throw new Exception("Error executing the SQL statement: " . $stmt->error);
                }
            
                $result3 = $stmt->get_result();
                if ($result3->num_rows > 0) {
                    $row3 = $result3->fetch_assoc();
                    $_SESSION['total_student'] = $row3['total'];
                } else {
                    $_SESSION['total_student'] = 0;
                }
                $stmt->close();
            } catch (Exception $e) {
                die("An error occurred: " . $e->getMessage());
            }




            $sqlLog = "INSERT INTO log (user_id) VALUES (?) ON DUPLICATE KEY UPDATE recdate = CURRENT_TIMESTAMP";
            $stmtLog = $conn->prepare($sqlLog);
            $stmtLog->bind_param("i", $log_id);
            $stmtLog->execute();
            $stmtLog->close();




            $staff_id = $_SESSION['staff_id'];

            // Prepare the SQL query to check if the user is blocked
            $checkBlockStatusSql = "SELECT block_status FROM blocked_user WHERE user_id = ?";
            $checkBlockStmt = $conn->prepare($checkBlockStatusSql);
            
            if ($checkBlockStmt === false) {
                // Handle error appropriately
                exit;
            }
            
            $checkBlockStmt->bind_param("s", $staff_id);
            $checkBlockStmt->execute();
            $blockResult = $checkBlockStmt->get_result();
            $blockRow = $blockResult->fetch_assoc();
            
            if ($blockRow && $blockRow['block_status'] == 1) {
                // User is blocked, reset session
                session_unset(); // Unset $_SESSION variable for the run-time
                session_destroy(); // Destroy session data in storage
                // You may want to redirect the user or output a message here
               echo "blocked";
                exit;
            }
            
            $checkBlockStmt->close();
            

              
            
            

exit;

           
        } else {

         
        
            
        }
    } else {
        $response["message"] = "Username not found!";
    }
}





$username = $_POST['username'];
$password = $_POST['password'];

// TO UPPER CASE
$username = strtoupper($username);
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

$isStudent=false;
$result4 = $stmt4->get_result();
if ($result4->num_rows > 0) {
    $row4 = $result4->fetch_assoc();
    $full_name = $row4['first_name'] . " " . ($row4['middle_name'] ? $row4['middle_name'] . " " : "") . $row4['last_name'];
    $names = [$row4['first_name'], $row4['middle_name'], $row4['last_name'], $full_name];

    if (in_array($username, $names) && $password === $row4['admission_number']) {
        echo "student";
        $isStudent=true;
        $_SESSION['admission_number'] = $row4['admission_number'];
        $log_id= $row4['admission_number'];
        $_SESSION['index_number'] = $row4['admission_number'];
        // user_id
        $_SESSION['user_id'] = $row4['id'];
    
    }
}


if ($isStudent == false) {

    // CHECK IF password length is 12   if not preceed with 0 until it is 12;
    $password = str_pad($password, 12, "0", STR_PAD_LEFT);

   



    $sql5 = "SELECT * FROM ges_admission_list WHERE index_number = ?";
    $stmt5 = $conn->prepare($sql5);
    if ($stmt5 === false) {
        // handle error appropriately
        exit;
    }

    $stmt5->bind_param("s", $password);

    if (!$stmt5->execute()) {
        // handle error appropriately
        exit;
    }

    $result5 = $stmt5->get_result();
    if ($result5->num_rows > 0) {
        while ($row5 = $result5->fetch_assoc()) {
            // Split name into parts and check if any matches the username
            $nameParts = explode(' ', strtoupper($row5['name']));
            if (in_array($username, $nameParts)) {
                echo "ges_admission_list user";
                $_SESSION['index_number'] = $row5['index_number'];
                $_SESSION['full_name'] = $row5['name'];
                $_SESSION['aggregate'] = $row5['aggregate'];
                $_SESSION['programme'] = $row5['programme'];
                $_SESSION["boarding_status"] = $row5['status'];
                $isStudent=true;
                $_SESSION['admission_number'] = $row5['index_number'];
                $log_id= $row5['index_number'];
                // user_id
                $_SESSION['user_id'] = $row5['id'];
                break; // Exit the loop if a match is found
            }
        }
    }

   


}











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






$staff_id= $_SESSION['admission_number'];



// Prepare the SQL query to check if the user is blocked
$checkBlockStatusSql = "SELECT block_status FROM blocked_user WHERE user_id = ?";
$checkBlockStmt = $conn->prepare($checkBlockStatusSql);

if ($checkBlockStmt === false) {
    // Handle error appropriately
    exit;
}

$checkBlockStmt->bind_param("s", $staff_id);
$checkBlockStmt->execute();
$blockResult = $checkBlockStmt->get_result();
$blockRow = $blockResult->fetch_assoc();

if ($blockRow && $blockRow['block_status'] == 1) {
    // User is blocked, reset session
    session_unset(); // Unset $_SESSION variable for the run-time
    session_destroy(); // Destroy session data in storage
    // You may want to redirect the user or output a message here
   echo "blocked";
    exit;
}

$checkBlockStmt->close();



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


















?>
