<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

// Query to get messages sent to students
$admission_number = $conn->real_escape_string($_SESSION['admission_number']);
$studentMessagesQuery = "
  SELECT 
    im.title, im.id, im.message, im.recdate, 
    CONCAT(s.firstname, ' ', s.lastname) AS sender_fullname,
    CONCAT(st.first_name, ' ', st.last_name) AS receiver_fullname
  FROM individual_message im
  JOIN student st ON im.receiver_id = st.admission_number
  JOIN registration s ON im.user_id = s.id
  WHERE st.admission_number = '$admission_number'
";








  


$studentResult = $conn->query($studentMessagesQuery);



$studentMessages = [];



if ($studentResult->num_rows > 0) {
    while ($row = $studentResult->fetch_assoc()) {
      $recdate= \AE\AE::aeDate2( $row["recdate"]);
      
        $studentMessages[] = [
          'recdate'           => $recdate,
            'id'                => $row['id'], //added by me
            'tb'                => 'individual_message',
            'receiver_fullname' => $row['receiver_fullname'],
            'sender_fullname'   => $row['sender_fullname'],
            'message_title'     => $row['title'],
            'message_body'      => $row['message']
        ];
    }
}








$allowed_group_id = 'all_students';

$groupMessagesQuery = "
  SELECT 
    gm.title, gm.id, gm.message, gm.recdate,
    gm.group_id AS receiver_fullname, 
    CONCAT(s.firstname, ' ', s.lastname) AS sender_fullname
  FROM group_message gm
  JOIN registration s ON gm.user_id = s.id
  WHERE gm.group_id = '$allowed_group_id'
";


$groupResult = $conn->query($groupMessagesQuery);
$groupMessages = [];
if ($groupResult->num_rows > 0) {
    while ($row = $groupResult->fetch_assoc()) { 
      $recdate= \AE\AE::aeDate2( $row["recdate"]);
        $groupMessages[] = [
          'recdate'           => $recdate,
            'id'                => $row['id'],
            'tb'                => 'group_message',
          
            'receiver_fullname' => $row['receiver_fullname'],
            'sender_fullname'   => $row['sender_fullname'],
            'message_title'     => $row['title'],
            'message_body'      => $row['message']
        ];
    } 
}

$response = [
    'success' => true, 
    'student_messages' => $studentMessages,
    'group_messages'=> $groupMessages

 
    
];

     
 echo json_encode($response);



