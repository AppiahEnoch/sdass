<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../AE.php";
use AE\AE;

$term_year=  $_SESSION['current_term'];

$class_id = $_SESSION['userClass'];
$user_id = $_SESSION['user_id'];



$sql_ = "CALL InsertIntoAdmissionNumber()";
$result = $conn->query($sql_);

if ($result === TRUE) {
    // Your success code here
} else {
    // Your error-handling code here
}



if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Receiving student's details
$old_admission_number = $_POST['old_admission_number'];
$first_name = $_POST['firstname'];
$middle_name = $_POST['middlename'];
$last_name = $_POST['lastname'];
$date_of_birth = $_POST['dateOfBirth'];
$date_of_admission = $_POST['date_of_admission'];
$student_residential_address = $_POST['student_residential_address'];

$has_health_problem = $_POST['hasHealthProblem'];
$health_problem_details = $_POST['healthProblemDetails'];
$has_special_needs = $_POST['hasSpecialNeeds'];
$special_needs_details = $_POST['specialNeedsDetails'];
$child_nationality = $_POST['childNationality'];

$ghana_card_number = $_POST['ghana_card_number'];
$student_class = $_POST['student_class'];
$string_class = $_POST['stringClass'];

$gender = $_POST['gender'];
$language_spoken= $_POST['language_spoken'];






$father_first_name = $_POST['father_first_name'];
$father_middle_name = $_POST['father_middle_name'];
$father_last_name = $_POST['father_last_name'];
$father_education = $_POST['father_education'];
$father_occupation = $_POST['father_occupation'];
$father_mobile = $_POST['father_mobile'];
$father_residential_address = $_POST['father_residential_address'];



$mothers_first_name = $_POST['mothers_first_name'];
$mothers_middle_name = $_POST['mothers_middle_name'];
$mothers_last_name = $_POST['mothers_last_name'];
$mothers_education = $_POST['mothers_education'];
$mothers_occupation = $_POST['mothers_occupation'];
$mothers_mobile = $_POST['mothers_mobile'];
$mothers_residential_address = $_POST['mothers_residential_address'];





   // Get the current year and concatenate with student_class

   // $date_of_admission  
   $currentYear = date('Y', strtotime($date_of_admission));
$class_year_combination = $currentYear . $student_class;

// Check if this combination exists in the table
$sqlCheck = "SELECT class_count FROM admission_number WHERE available_class = ? AND year = ?";
$stmt = $conn->prepare($sqlCheck);
$stmt->bind_param("ss", $student_class, $currentYear);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

if ($result->num_rows > 0) {
    // If exists, increment the class_count
    $row = $result->fetch_assoc();
    $new_count = $row['class_count'] + 1;

    $sqlUpdate = "UPDATE admission_number SET class_count = ? WHERE available_class = ? AND year = ?";
    $stmt = $conn->prepare($sqlUpdate);
    $stmt->bind_param("iss", $new_count, $student_class, $currentYear);
    $stmt->execute();
    $stmt->close();
} else {
    // If doesn't exist, insert a new row with class_count = 1
    $initial_count = 1;
    $sqlInsert = "INSERT INTO admission_number (available_class, class_count, year) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sqlInsert);
    $stmt->bind_param("sis", $student_class, $initial_count, $currentYear);
    $stmt->execute();
    $stmt->close();
}


// First, fetch the class_count for the specific class and year
$sqlClassCount = "SELECT class_count FROM admission_number WHERE available_class = ? AND year = ?";
$stmt = $conn->prepare($sqlClassCount);
$stmt->bind_param("ss", $student_class, $currentYear);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

$row = $result->fetch_assoc();
$classSpecificCount = $row['class_count'];

// Now, fetch the total sum of class_count for the entire student number
$sqlTotalCount = "SELECT SUM(class_count) AS total_count FROM admission_number";
$resultTotal = $conn->query($sqlTotalCount);
$rowTotal = $resultTotal->fetch_assoc();
$totalStudents = $rowTotal['total_count'];

// Extract the first letter and the last character from the student_class
$firstCharacter = strtoupper(substr($string_class, 0, 1));
$lastCharacter = substr($string_class, -1);
$classCode = $firstCharacter . $lastCharacter;

// Construct the admission number


$admission_number = $classCode . $currentYear . "-" . $classSpecificCount . "-" . $totalStudents;





$old_admission_is_null = AE::isEmpty($old_admission_number);
if (!$old_admission_is_null) {
    // If the old admission number is not null, then it's an update
    $is_update = true;
    $admission_number = $old_admission_number;
}
     



    // Receiving parent/guardian's details
    $parent_first_name = $_POST['parent_firstName'];
    $parent_middle_name = $_POST['parent_middleName'];
    $parent_last_name = $_POST['parent_lastName'];
    $parent_region = $_POST['parent_region'];
    $relationship_with_child = $_POST['relationship_with_child'];
    
    $parent_ghana_card_number = $_POST['parent_ghana_card_number'];
    
    $parent_mobile = $_POST['parent_mobile'];
    $parent_email = $_POST['parent_email'];
    $parent_location = $_POST['parent_location'];
    $parent_house_address = $_POST['parent_house_address'];
    $parent_occupation = $_POST['parent_occupation'];




// Save images using the provided functions and get their paths
$ghana_card_image_path = uploadImageWithUniqueName('ghana_card_image', $admission_number, "GhanaCardStudent", "../upload/");
$birth_certificate_path = uploadImageWithUniqueName('birthCertificate', $admission_number, "BirthCertificate", "../upload/");
$previous_school_report_path = uploadImageWithUniqueName('previous_school_report', $admission_number, "PreviousSchoolReport", "../upload/");
$student_passport_image_input_path = uploadImageWithUniqueName('studentPassportImageInput', $admission_number, "StudentPassport", "../upload/");


// echo $ghana_card_image_path . "<br>";
// echo $birth_certificate_path . "<br>";
// echo $previous_school_report_path . "<br>";
// echo $student_passport_image_input_path . "<br>";
// exit;


// Dynamic part for SQL update, only for non-empty file paths
$updateValues = [];
if (!AE::isEmpty($ghana_card_image_path)) {
    $updateValues[] = "ghana_card_image = VALUES(ghana_card_image)";
}

if (!AE::isEmpty($birth_certificate_path)) {
    $updateValues[] = "birth_certificate = VALUES(birth_certificate)";
}

if (!AE::isEmpty($previous_school_report_path)) {
    $updateValues[] = "previous_school_report = VALUES(previous_school_report)";
}

if (!AE::isEmpty($student_passport_image_input_path)) {
    $updateValues[] = "student_passport_image_input = VALUES(student_passport_image_input)";
}

$dynamicUpdateSql = !empty($updateValues) ? ", " . implode(", ", $updateValues) : "";





$sqlInsertStudent = "
INSERT INTO student 
(admission_number, first_name, middle_name, last_name, date_of_birth, ghana_card_number, ghana_card_image, birth_certificate,
 previous_school_report, student_class, student_passport_image_input, 
 date_of_admission, has_health_problem, health_problem_details, has_special_needs, special_needs_details, child_nationality, student_residential_address,gender,language_spoken) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ? ,?,?)
ON DUPLICATE KEY UPDATE 
first_name = VALUES(first_name),
middle_name = VALUES(middle_name),
last_name = VALUES(last_name),
date_of_birth = VALUES(date_of_birth),
ghana_card_number = VALUES(ghana_card_number),
student_class = VALUES(student_class),
date_of_admission = VALUES(date_of_admission),
has_health_problem = VALUES(has_health_problem),
health_problem_details = VALUES(health_problem_details),
has_special_needs = VALUES(has_special_needs),
special_needs_details = VALUES(special_needs_details),
child_nationality = VALUES(child_nationality),
student_residential_address = VALUES(student_residential_address),
gender= VALUES(gender), language_spoken= VALUES(language_spoken)

$dynamicUpdateSql
";

$stmt = $conn->prepare($sqlInsertStudent);
if ($stmt === false) {
    die("Error preparing the SQL statement: " . $conn->error);
}

$stmt->bind_param("ssssssssssssssssssss", $admission_number, $first_name, $middle_name, $last_name, $date_of_birth, $ghana_card_number, $ghana_card_image_path, $birth_certificate_path, $previous_school_report_path, $student_class, $student_passport_image_input_path, $date_of_admission, $has_health_problem, $health_problem_details, $has_special_needs, $special_needs_details, $child_nationality, $student_residential_address,$gender,$language_spoken);

if (!$stmt->execute()) {
    die("Error executing the SQL statement: " . $stmt->error);
}
$stmt->close();
    






// Save images using the provided functions and get their paths
$parent_passport_picture_path = uploadImageWithUniqueName('parent_passport_picture', $admission_number, "PassPort", "../upload/");
$parent_ghana_card_image_path = uploadImageWithUniqueName('parent_ghana_card_image', $admission_number, "GhanaCardGuardian", "../upload/");
$parent_proof_of_residence_path = uploadImageWithUniqueName('parent_proof_of_residence', $admission_number, "ProofOfResidence", "../upload/");

$updateParentValues = [];

if (!AE::isEmpty($parent_passport_picture_path)) {
    $updateParentValues[] = "parent_passport_picture = VALUES(parent_passport_picture)";
}

if (!AE::isEmpty($parent_ghana_card_image_path)) {
    $updateParentValues[] = "parent_ghana_card_image = VALUES(parent_ghana_card_image)";
}

if (!AE::isEmpty($parent_proof_of_residence_path)) {
    $updateParentValues[] = "parent_proof_of_residence = VALUES(parent_proof_of_residence)";
}

$dynamicUpdateParentSql = !empty($updateParentValues) ? ", " . implode(", ", $updateParentValues) : "";

$sql_parent = "
    INSERT INTO parent 
    (admission_number, parent_first_name, parent_middle_name, parent_last_name, parent_passport_picture, parent_ghana_card_number, parent_ghana_card_image, parent_mobile, parent_email, parent_location, parent_house_address, parent_occupation, parent_proof_of_residence, parent_region, relationship_with_child)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ON DUPLICATE KEY UPDATE 
        parent_first_name = VALUES(parent_first_name),
        parent_middle_name = VALUES(parent_middle_name),
        parent_last_name = VALUES(parent_last_name),
        parent_mobile = VALUES(parent_mobile),
        parent_email = VALUES(parent_email),
        parent_location = VALUES(parent_location),
        parent_house_address = VALUES(parent_house_address),
        parent_occupation = VALUES(parent_occupation),
        parent_region = VALUES(parent_region),
        relationship_with_child = VALUES(relationship_with_child)
        $dynamicUpdateParentSql
";

$stmt_parent = $conn->prepare($sql_parent);
$stmt_parent->bind_param("sssssssssssssss", $admission_number, $parent_first_name, $parent_middle_name, $parent_last_name, $parent_passport_picture_path, $parent_ghana_card_number, $parent_ghana_card_image_path, $parent_mobile, $parent_email, $parent_location, $parent_house_address, $parent_occupation, $parent_proof_of_residence_path, $parent_region, $relationship_with_child);

// Execute the statement
if (!$stmt_parent->execute()) {
    die("Error executing the SQL statement: " . $stmt_parent->error);
}
$stmt_parent->close();





    $sql = "INSERT INTO `father` (
        `admission_number`,
        `father_first_name`,
        `father_middle_name`,
        `father_last_name`,
        `father_education`,  
        `father_occupation`,
        `father_mobile`,
        `father_residential_address`
      ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
      ON DUPLICATE KEY UPDATE
        `father_first_name` = VALUES(`father_first_name`),
        `father_middle_name` = VALUES(`father_middle_name`),
        `father_last_name` = VALUES(`father_last_name`),
        `father_education` = VALUES(`father_education`),
        `father_occupation` = VALUES(`father_occupation`),
        `father_mobile` = VALUES(`father_mobile`),
        `father_residential_address` = VALUES(`father_residential_address`)";
      
      $stmt = $conn->prepare($sql);
      $stmt->bind_param(
        "ssssssss",
        $admission_number,
        $father_first_name,
        $father_middle_name,
        $father_last_name,
        $father_education,
        $father_occupation,
        $father_mobile,
        $father_residential_address
      );
      
        if (!$stmt->execute()) {
            die("Error executing the SQL statement: " . $stmt->error);
        }
        $stmt->close();













        $sql = "INSERT INTO `mother` (
            `admission_number`,
            `mother_first_name`,
            `mother_middle_name`,
            `mother_last_name`,
            `mother_education`,
            `mother_occupation`,
            `mother_mobile`,
            `mother_residential_address`
          ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
          ON DUPLICATE KEY UPDATE
            `mother_first_name` = VALUES(`mother_first_name`),
            `mother_middle_name` = VALUES(`mother_middle_name`),
            `mother_last_name` = VALUES(`mother_last_name`),
            `mother_education` = VALUES(`mother_education`),
            `mother_occupation` = VALUES(`mother_occupation`),
            `mother_mobile` = VALUES(`mother_mobile`),
            `mother_residential_address` = VALUES(`mother_residential_address`)";
          
          $stmt = $conn->prepare($sql);
          $stmt->bind_param(
            "ssssssss",
            $admission_number,
            $mothers_first_name,
            $mothers_middle_name,
            $mothers_last_name,
            $mothers_education,
            $mothers_occupation,
            $mothers_mobile,
            $mothers_residential_address
          );
          
            if (!$stmt->execute()) {
                die("Error executing the SQL statement: " . $stmt->error);
            }
            $stmt->close();
          






}
else{
    
    echo "error";
}


$stmt = $conn->prepare("CALL InsertRandomAttitudeAndInterest(?, ?, ?, ?)");
// Bind the parameters
$stmt->bind_param('sisi', $admission_number, $user_id, $term_year, $class_id);
// Execute the procedure
if($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => $stmt->error]);
}
$stmt->close();



echo "term: ".$class_id;

$stmt = $conn->prepare("CALL InsertRandomComment(?, ?, ?, ?)");
    
// Bind the parameters
$stmt->bind_param('sisi', $admission_number, $user_id, $term_year, $class_id);

// Execute the procedure
if($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => $stmt->error]);
}

$stmt->close();

$stmt = $conn->prepare("CALL InsertRandomHEADComment(?, ?)");
    
// Bind the parameters
$stmt->bind_param('ss', $admission_number,$term_year);

// Execute the procedure
if($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => $stmt->error]);
}

$stmt->close();







// Get current term  
$term = $_SESSION['current_term'];
// SQL to select current student term
$sql = "SELECT term FROM student WHERE admission_number = ?";
// Prepare statement
$stmt = $conn->prepare($sql); 
// Bind admission number 
$stmt->bind_param('s', $admission_number);
// Execute query
$stmt->execute(); 
// Get result 
$result = $stmt->get_result();
// Fetch term
$db_term = $result->fetch_object()->term;
// Check if null
if($db_term === null) {
  // Term is null, so update
  $sql = "UPDATE student SET term = ? WHERE admission_number = ?";
  // Prepare update statement
  $update_stmt = $conn->prepare($sql);
  // Bind term and admission number
  $update_stmt->bind_param('ss', $term, $admission_number);
  // Execute update
  $update_stmt->execute();
  if($update_stmt->affected_rows > 0) {
    echo "Term updated successfully";  
  }
  $update_stmt->close();
} else {
  echo "Term already set, not updating";
}

// Close statements
$stmt->close();









  





















function uploadImageWithUniqueName($input_name, $ID, $file_group, $target_dir = "../material_image/") {

    if(isset($_FILES[$input_name]) && is_uploaded_file($_FILES[$input_name]['tmp_name']) && $_FILES[$input_name]['error'] == 0) {
        
        // Use $admission_number and $file_group to create a unique name
        $unique_name = $file_group . '_' . $ID;
        
        // Get the extension of the file
        $file_extension = pathinfo($_FILES[$input_name]["name"], PATHINFO_EXTENSION);
    
        // Create a new filename with the unique name
        $new_filename = $unique_name . '.' . $file_extension;
    
        // Full path to the new file
        $new_file_path = $target_dir . $new_filename;
    
        // Move the uploaded file to the new location
        if (move_uploaded_file($_FILES[$input_name]["tmp_name"], $new_file_path)) {
            // Return the relative path
            return $new_file_path;
        }
    }

    return "";
}



function generateCode($length = 30) {
    $characters = '123456789abcdefghjkmnpqrstuvwxy_zABCDEFGHIJKLMNPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}