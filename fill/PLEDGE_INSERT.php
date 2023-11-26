<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;








$student_bece_number = $_SESSION['index_number'] ?? '';



$value_from_db = null;


// CREATE TABLE `student` (
//     `id` int(11) NOT NULL,
//     `sdass_admission_number` varchar(255) DEFAULT NULL,

$gender=null;
$student_house=null;
    

// Check if sdass_admission_number is already set for this student
$sql = "SELECT * FROM student WHERE admission_number = '$student_bece_number'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $value_from_db = $row['sdass_admission_number'];
    $value_from_db2 = $row['house'];
    $gender = $row['gender'];

    if (\AE\AE::isEmpty($value_from_db) || \AE\AE::isEmpty($value_from_db2)) {
        // Your code logic here
    } else {
        echo json_encode(['success' => true, 'message' => 'admitted already']);
        exit;
    }
}









// Query to select the appropriate house
if (strcasecmp($gender, "Male") === 0) {
    $query = "SELECT * FROM student_house WHERE boys_number < capacity_boys ORDER BY total_used ASC, recdate ASC LIMIT 1";
} else {
    $query = "SELECT * FROM student_house WHERE girls_number < capacity_girls ORDER BY total_used ASC, recdate ASC LIMIT 1";
}

$result = $conn->query($query);
if ($result->num_rows > 0) {
    // Fetch the appropriate house
    $house = $result->fetch_assoc();
    $houseId = $house['id'];

    // Increment boys_number or girls_number based on gender
    if (strcasecmp($gender, "Male") === 0) {
        $updateQuery = "UPDATE student_house SET boys_number = boys_number + 1 WHERE id = $houseId";
    } else {
        $updateQuery = "UPDATE student_house SET girls_number = girls_number + 1 WHERE id = $houseId";
    }

    // Execute the update query
    if ($conn->query($updateQuery) === TRUE) {
      $student_house= $house['house_name'];
    } else {
        echo "Error updating record: " . $conn->error;
    }

} else {
    // JSON SUCCESS FALSE
    echo json_encode(['success' => false, 'message' => 'No house available']);

    exit;
}



















$school_admission_number = null;
$row_id= null;

// Add your logic to establish a database connection to $conn
// Assuming $conn is your database connection variable from the included files

$sql = "SELECT *, CAST(SUBSTRING(admission_number, 3) AS UNSIGNED) as numeric_part 
        FROM `sdass_admission_number` where is_used = 0
        ORDER BY `is_used` ASC, SUBSTRING(admission_number, 1, 2), numeric_part ASC limit 1";
$result = $conn->query($sql);

$admissionList = [];

if ($result->num_rows > 0) {
    // fetch data of each row
    while($row = $result->fetch_assoc()) {
        $admissionList[] = $row;
        $school_admission_number = $row['admission_number'];
        $row_id = $row['id'];


    }
   // echo json_encode(['success' => true, 'admission_number_list' => $admissionList]);
} else {
    echo json_encode(['success' => false, 'message' => 'No admission number available']);
    exit;
}




//update isuded to 1   and index_number to student_bece_number
$sql = "UPDATE sdass_admission_number SET is_used = 1, index_number = '$student_bece_number' WHERE id = '$row_id'";
if ($conn->query($sql) === TRUE) {
  //  echo "Record updated successfully";
} else {
    ///echo "Error updating record: " . $conn->error;
}



// Update student table with admission number and house
$sql = "UPDATE student SET sdass_admission_number = '$school_admission_number', house = '$student_house' WHERE admission_number = '$student_bece_number'";
if ($conn->query($sql) === TRUE) {
    // echo "Record updated successfully";
} else {
    // echo "Error updating record: " . $conn->error;
}


















// Assuming admission_number is in the session or posted from another form
$admissionNumber = $_SESSION['index_number'] ?? '';

// Update the 'accepted_pledge' column to 1 for the specific student
$sqlUpdatePledge = "UPDATE student SET accepted_pledge = 1 WHERE admission_number = ?";
$stmtUpdatePledge = $conn->prepare($sqlUpdatePledge);

if ($stmtUpdatePledge === false) {
    echo json_encode(['success' => false, 'message' => 'Failed to prepare statement for updating pledge acceptance: ' . $conn->error]);
    $conn->close();
    exit;
}

$stmtUpdatePledge->bind_param("s", $admissionNumber);

if ($stmtUpdatePledge->execute()) {
    echo json_encode(['success' => true, 'message' => 'Pledge accepted successfully']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to accept the pledge: ' . $stmtUpdatePledge->error]);
}

$stmtUpdatePledge->close();
$conn->close();
?>
