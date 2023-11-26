<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

// Assume gender is set, for example, through a POST request
$gender = "FeMale"; // Or $_POST['gender'] if coming from a form

// Query to select the appropriate house
if ($gender === "Male") {
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
    if ($gender === "Male") {
        $updateQuery = "UPDATE student_house SET boys_number = boys_number + 1 WHERE id = $houseId";
    } else {
        $updateQuery = "UPDATE student_house SET girls_number = girls_number + 1 WHERE id = $houseId";
    }

    // Execute the update query
    if ($conn->query($updateQuery) === TRUE) {
        echo "Student assigned to house: " . $house['house_name'];
    } else {
        echo "Error updating record: " . $conn->error;
    }

} else {
    echo "No available house found for the selected gender.";
}


