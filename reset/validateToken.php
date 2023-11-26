<?php
session_start();
include "../config/config.php";
include "../config/settings.php";



if (isset($_GET['token'])) {

    $token = $_GET['token'];
    $sql = "SELECT email FROM token WHERE token=?";








    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        error_log("Error preparing statement: " . $conn->error);
        header('Location: errorPage.php');
        exit();
    }

    $bind = $stmt->bind_param("s", $token);
    if (!$bind) {
        error_log("Error binding parameters: " . $stmt->error);
        header('Location: errorPage.php');
        exit();
    }

    $exec = $stmt->execute();
    if (!$exec) {
        error_log("Error executing query: " . $stmt->error);
        header('Location: errorPage.php');
        exit();
    }

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $email = $row['email'];

        // Keep $email in session variable
        $_SESSION['email'] = $email;


        $_SESSION['token'] = $token;





        header('Location: page.php');
    } else {

        header('Location: expiredLink.php');
        exit;
    }

    $stmt->close();
} else {
    echo "No token provided.";
}
?>
