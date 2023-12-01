<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;


$userId=null;


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['userId'])) {
    $userId = $conn->real_escape_string($_POST['userId']);

   
}



deleteSpecificRecord("student_old_debt","admission_number", $userId);
deleteSpecificRecord("father","admission_number", $userId);
deleteSpecificRecord("mother","admission_number", $userId);
deleteSpecificRecord("parent","admission_number", $userId);
deleteSpecificRecord("student_current_class","admission_number", $userId);
deleteSpecificRecord("student_payment","admission_number", $userId);
deleteSpecificRecord("student_class","admission_number", $userId);

deleteSpecificRecord("assessment","admission_number", $userId);


deleteSpecificRecord("enrollment_code","index_number", $userId);
procedure("DeleteInvalidAdmissionNumbers");
deleteSpecificRecord("student","admission_number", $userId);
deleteSpecificRecord("registration","staffid", $userId);

echo 1;




function procedure($procedureName) {
    global $conn; // Ensure that $conn is accessible within the function

    // Prepare the SQL statement to call the stored procedure
    $sql = "CALL `$procedureName`();"; // No parameters
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        // Handle error appropriately
        throw new Exception("Prepare failed: " . $conn->error);
    }

    // Execute the statement
    if (!$stmt->execute()) {
        // Handle error appropriately
        throw new Exception("Execute failed: " . $stmt->error);
    }

    $stmt->close();
}


function deleteSpecificRecord($tableName, $columnName, $whereValue) {
    global $conn;

    // Prepare the SQL statement to delete the specific record
    $sql = "DELETE FROM `$tableName` WHERE `$columnName` = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        // Handle error appropriately
        throw new Exception("Prepare failed: " . $conn->error);
    }

    // Bind the where clause value parameter and execute the statement
    $stmt->bind_param("s", $whereValue); // 's' datatype for string, use 'i' for integers, 'd' for doubles, 'b' for blobs
    if (!$stmt->execute()) {
        // Handle error appropriately
        throw new Exception("Execute failed: " . $stmt->error);
    }

    $stmt->close();
}
