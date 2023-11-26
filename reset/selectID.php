<?php
session_start();
$email = $_SESSION['email'];

// Include the necessary files for the connection
include "../config/config.php";
include "../config/settings.php";

$query = "SELECT `id`, `mobile`, `email` FROM `registration` WHERE `email` = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);

// Execute the query
$stmt->execute();

// Get the result set
$result = $stmt->get_result();

// Fetch the result into an associative array
if ($row = $result->fetch_assoc()) {
    // You can now use $row to access the columns
    echo $row['id'];
  //  echo "Mobile: " . $row['mobile'];
  //  echo "Email: " . $row['email'];
} else {
    echo 0;
}

// Close the statement
$stmt->close();
?>
