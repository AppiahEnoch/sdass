<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

require('../mc_table.php');

ob_end_clean();

$pdf = new PDF_MC_Table();
$pdf->AddPage();



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $searchTerm = isset($_POST['searchTerm']) ? $_POST['searchTerm'] : '';
    $startDate = isset($_POST['startDate']) ? $_POST['startDate'] : '';
    $endDate = isset($_POST['endDate']) ? $_POST['endDate'] : '';
    $selectedClass = isset($_POST['selectedClass']) ? $_POST['selectedClass'] : '';
    $selectedTerm = isset($_POST['selectedTerm']) ? $_POST['selectedTerm'] : '';

    // Construct the query dynamically
    $query = "SELECT admission_number, class_id, user_id, term_year FROM assessment WHERE 1=1";
    if (!empty($searchTerm)) {
        $query .= " AND admission_number LIKE '%".$conn->real_escape_string($searchTerm)."%'";
    }
    if (!empty($startDate)) {
        $query .= " AND recdate >= '".$conn->real_escape_string($startDate)."'";
    }
    if (!empty($endDate)) {
        $query .= " AND recdate <= '".$conn->real_escape_string($endDate)."'";
    }
    if (!empty($selectedClass)) {
        $query .= " AND class_id = '".$conn->real_escape_string($selectedClass)."'";
    }
    if (!empty($selectedTerm)) {
        $query .= " AND term_year = '".$conn->real_escape_string($selectedTerm)."'";
    }

    // Execute the query
    $result = $conn->query($query);
    if ($result) {
        $filter_data = array();
        $unique_data = array();
        while ($row = $result->fetch_assoc()) {
            if (!isset($unique_data[$row['admission_number']])) {
                $unique_data[$row['admission_number']] = $row;
            }
        }
        $filter_data = array_values($unique_data);
 
    } else {
        // Handle error
        echo json_encode(array('error' => 'Database query failed.'));
    }
} else {
    // Handle non-POST requests
    echo json_encode(array('error' => 'Invalid request.'));
}







































$examIdQuery = "SELECT id FROM assessment_type WHERE assessment_name = 'Examination' LIMIT 1";
$examIdResult = $conn->query($examIdQuery);

if ($examIdResult->num_rows > 0) {
    $row = $examIdResult->fetch_assoc();
    $examination_id = $row['id'];
    // set session 
       $_SESSION['examination_id'] = $examination_id;
} else {
    // Handle the case where the examination ID does not exist
    // This might involve setting a default value or throwing an error
}


$_SESSION['userClass']=5;

$class_id = $_SESSION['userClass'];
//$_SESSION['admission_number']="N12023-30-110";
//$_SESSION['admission_number']="C12023-1-1";
$admission_number = $_SESSION['admission_number'];

// // Fetch admission numbers based on class_id
// $sql_admission_numbers = "SELECT admission_number FROM student_current_class WHERE class_id = ?";
// $stmt_admission_numbers = $conn->prepare($sql_admission_numbers);
// $stmt_admission_numbers->bind_param("i", $class_id);
// $stmt_admission_numbers->execute();
// $result_admission_numbers = $stmt_admission_numbers->get_result();

// $admission_numbers_array = array();

// while ($row = $result_admission_numbers->fetch_assoc()) {
//     $admission_numbers_array[] = $row['admission_number'];
// }

function addWrappedCell($pdf, $prefix, $content) {
    $maxWidth = 180; // Set the maximum width according to your needs.
    $lineHeight = 10; // Set line height
    $text = $prefix . ' ' . $content;
    
    if ($pdf->GetStringWidth($text) > $maxWidth) {
        $words = explode(' ', $text);
        $line = '';
        
        foreach ($words as $word) {
            if ($pdf->GetStringWidth($line . ' ' . $word) < $maxWidth) {
                $line .= ' ' . $word;
            } else {
                $pdf->Cell(0, $lineHeight, trim($line), 0, 1);
                $line = $word;
            }
        }
        
        $pdf->Cell(0, $lineHeight, trim($line), 0, 1);
    } else {
        $pdf->Cell(0, $lineHeight, $text, 0, 1);
    }
}






function determineGrade($score) {
    if ($score >= 90 && $score <= 100) return 'A+';
    if ($score >= 80 && $score < 90) return 'A';
    if ($score >= 70 && $score < 80) return 'B+';
    if ($score >= 60 && $score < 70) return 'B';
    if ($score >= 55 && $score < 60) return 'C+';
    if ($score >= 50 && $score < 55) return 'C';
    if ($score >= 40 && $score < 50) return 'D+';
    if ($score >= 35 && $score < 40) return 'E';
    if ($score >= 0 && $score < 35) return 'F';
    return 'N/A'; // Score outside 0-100 range
}








function determineRemarks($score) {
    if ($score >= 90) return 'HIGHEST';
    if ($score >= 80) return 'HIGHER';
    if ($score >= 70) return 'HIGH';
    if ($score >= 60) return 'HIGH AVERAGE';
    if ($score >= 55) return 'AVERAGE';
    if ($score >= 50) return 'LOW AVERAGE';
    if ($score >= 40) return 'LOW';
    if ($score >= 35) return 'LOWER';
    if ($score >= 0) return 'LOWEST';
    return 'N/A'; // Score outside 0-100 range
}


function getOrdinalSuffix($number) {
    if($number === null) {
        return "N/A";
    }
    
    if($number === "") {
        return "N/A";
    }
    
    if(!is_numeric($number)) {
        return $number;
    }
    
    if (!in_array(($number % 100), array(11,12,13))) {
        switch ($number % 10) {
            case 1:  return $number . 'st';
            case 2:  return $number . 'nd';
            case 3:  return $number . 'rd';
        }
    }
    return $number . 'th';
}







function PRINT_REPORT ($conn,$pdf,$term, $report_term_count,$totalUniqueTerms) {
    $pdf->SetFont('Arial', '', 11);

$admission_number=$_SESSION['admission_number'];




    
//$term = $_SESSION['current_term'];

$total_students=  $_SESSION['total_student'];

$student_image_url="../devimage/placeholder.png";

$db_image_url = null;

$promoted_to = $_SESSION['promoted_class_name'];


if (stripos($term, 'Third Term') !== false) {
    $promoted_to = $_SESSION['promoted_class_name'];
  } else {
    $promoted_to = null;
  }

    
    
    $sql4 = "SELECT s.*, sc.class_name 
             FROM student AS s 
             JOIN student_current_class AS scc ON s.admission_number = scc.admission_number
             JOIN school_class AS sc ON scc.class_id = sc.id
             WHERE s.admission_number = '$admission_number'";
    
    $result4 = $conn->query($sql4);
    $row4 = $result4->fetch_assoc();
    
    if ($result4->num_rows > 0) {
        $full_name = $row4['first_name'] . ' ' . $row4['middle_name'] . ' ' . $row4['last_name'];
        // ADMISSION NUMBER
        $admission_number = $row4['admission_number'];
        $db_image_url = $row4['student_passport_image_input'];



     
        if(file_exists($db_image_url)) {
            $student_image_url = $db_image_url;
        } 
        else{
            $db_image_url = null;
        }

       

    
        if(\AE\AE::isEmpty($db_image_url)) {
            $db_image_url = null;
        } 
        else{

   
            image_orientation($db_image_url);
            $student_image_url = $db_image_url;
        }  
    
    
        $gender = $row4['gender'];
        $class_name =  $_SESSION['promoted_class_name'];





    
        $sql = "SELECT COUNT(DISTINCT admission_number) AS total_studentscount 
        FROM assessment 
        WHERE class_id = ? AND term_year = ?";
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    // Handle error appropriately
    echo "Error preparing statement: " . $conn->error;
    exit;
}

// Bind parameters to avoid SQL injection
$stmt->bind_param("is", $_SESSION['userClass'], $_SESSION['term_year']);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$total_studentscount = $row['total_studentscount'];

$stmt->close();

    
    
    
    
    
    $total_students = $total_studentscount;
    
    
    
        
    if (empty($admission_number)) {
        die("Please provide an admission number");
    }
    
    
    
    
    
    
    if($report_term_count==1) {
        $sql2 = "SELECT * FROM app";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->execute();
        $data2 = $stmt2->get_result()->fetch_assoc();
        $stmt2->close();
        
        $marginRight = 10; // Margin from the right side of the page.
        $pageWidth = 210;  // Width of an A4 paper in mm.
        $imageWidth = 33;  // Width of the image.
        
        // Calculate x-coordinate to position the image at the right corner
        $x = $pageWidth - $imageWidth - $marginRight;
        
        
        if (!\AE\AE::isEmpty($student_image_url)) {
            $pdf->Image($student_image_url, $x, 10, 25);
        }
        
        
        
        // School Logo at the left
        $pdf->Image('../devimage/logo.png', 10, 10, 26);
        
        
        // School name in bold and larger font
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Ln(5);
        $pdf->Cell(0, 10, $data2['app_name'], 0, 1, 'C');
        
        // Resetting font size for address details
        $pdf->SetFont('Arial', '', 12);
        
        // Address centered
        $pdf->Cell(0, 10, $data2['address'], 0, 1, 'C');
        // REDUCE  LINE SPACING
        $pdf->Ln(-5);
        $pdf->Cell(0, 10, $data2['town'], 0, 1, 'C');
        $pdf->Ln(-5);
        $pdf->Cell(0, 10, $data2['region'], 0, 1, 'C');
        $pdf->Ln(-5);
        $pdf->Cell(0, 10, $data2['mobile'], 0, 1, 'C');
        $pdf->Ln(-5);
        $pdf->Cell(0, 10, $data2['mobile2'], 0, 1, 'C');
        $pdf->Ln(5);
        
        $pdf->SetFont('Arial', 'B', 11);
        // set heading as TERMINAL REPORT
        $pdf->Cell(0, 10, 'TERMINAL REPORT', 0, 1, 'C');
        // horizontal line
        
        
        
        $pdf->SetFont('Arial', '', 10);
            
        ///$pdf->Ln(-3);
        
        
        $pdf->Cell(0, 10, 'ID: ' . $admission_number, 0, 1);
        $pdf->Ln(-3);
        
          
        $pdf->Cell(0, 10, 'Name: ' . $full_name, 0, 1);
        
        $pdf->Ln(-3);
        
        
        $pdf->SetFont('Arial', '', 11);
        
        $pdf->Cell(0, 10, 'Term: '.$term.'     Sex: ' . $gender."        Class: ".$class_name.'      Number on roll: ' . $total_students, 0, 1);
        $pdf->SetFont('Arial', '', 11);
        
        
        if($promoted_to !== null) {
            $pdf->Cell(0, 10, 'Promoted to: ' . $promoted_to, 0, 1);
        }
        
        
        
        } else {


         if($total_students>0){
            $pdf->SetFont('Arial', '', 11);
        
            $pdf->Cell(0, 10, 'Term: '.$term.'     Sex: ' . $gender."        Class: ".$class_name.'      Number on roll: ' . $total_students, 0, 1);
            $pdf->SetFont('Arial', '', 11);
            
            
            if($promoted_to !== null) {
                $pdf->Cell(0, 10, 'Promoted to: ' . $promoted_to, 0, 1);
            }
         }
        }
        
        
        $pdf->SetFont('Arial', '', 11);
        // add line space
        
    }
    
    
    
    ////
    
    
    if($total_students> 0){
        $pdf->Ln(5);
       // Table Widths
       $pdf->SetWidths(array(60, 16, 16, 16, 16, 16,33));
    
       // Table Headers
       $pdf->Row(array('Subject', 'Class Score (30%)', 'Exam Score (70%)', 'Total Score','Grade', 'Position','Remarks'));
       
    }
    

    
    
    
    
    
 
    
 ///////
    {
        

    
    $term_year = $_SESSION['term_year'];
    $class_id =  $_SESSION['userClass'];
    
    $examination_id=$_SESSION['examination_id'];
    
    if ($examination_id !== null) {
        $rank_sql = "SELECT 
        a.admission_number,
        s.subject_name,
        (SUM(CASE WHEN a.assessment_type_id != {$examination_id} THEN a.mark ELSE 0 END) /
        SUM(CASE WHEN a.assessment_type_id != {$examination_id} THEN a.mark_out_of ELSE 0 END)) * 30 +
        SUM(CASE WHEN a.assessment_type_id = {$examination_id} THEN (a.mark / a.mark_out_of) * 70 ELSE 0 END) AS total_percentage
     FROM assessment a
     JOIN subjects s ON a.subject_id = s.id
     WHERE a.class_id = '{$class_id}' AND a.term_year = '{$term_year}'
     GROUP BY s.subject_name, a.admission_number
     ORDER BY s.subject_name, total_percentage DESC";
     
    } else {
        // Handle the case where the examination ID could not be determined
    }
    $rank_stmt = $conn->prepare($rank_sql);

    $rank_stmt->execute();
    $rank_result = $rank_stmt->get_result();
    
    $subjectRanks = [];
    while ($row = $rank_result->fetch_assoc()) {
        $subjectRanks[$row['subject_name']][] = [
            'admission_number' => $row['admission_number'],
            'total_percentage' => $row['total_percentage']
        ];
    }
    
    foreach ($subjectRanks as $subject => $students) {
        usort($students, function ($a, $b) {
            return $b['total_percentage'] <=> $a['total_percentage'];
        });
        $rank = 1;
        foreach ($students as $index => $student) {
            $subjectRanks[$subject][$index]['rank'] = $rank++;
        }
    }
    
    $sql = "SELECT 
    a.admission_number,
    s.subject_name,
    (SUM(CASE WHEN a.assessment_type_id != {$examination_id} THEN a.mark ELSE 0 END) / 
     SUM(CASE WHEN a.assessment_type_id != {$examination_id} THEN a.mark_out_of ELSE 0 END)) * 30 AS class_score_percentage,
    SUM(CASE WHEN a.assessment_type_id = {$examination_id} THEN (a.mark / a.mark_out_of) * 70 ELSE 0 END) AS exam_score_percentage,
    (SUM(CASE WHEN a.assessment_type_id != {$examination_id} THEN a.mark ELSE 0 END) / 
     SUM(CASE WHEN a.assessment_type_id != {$examination_id} THEN a.mark_out_of ELSE 0 END)) * 30 
    + SUM(CASE WHEN a.assessment_type_id = {$examination_id} THEN (a.mark / a.mark_out_of) * 70 ELSE 0 END) AS total_percentage
  FROM assessment a 
  JOIN subjects s ON a.subject_id = s.id
  WHERE a.admission_number = '{$admission_number}' AND a.class_id = '{$class_id}' AND a.term_year = '{$term_year}' 
  GROUP BY s.subject_name, a.admission_number
  ORDER BY s.subject_name";

$result = $conn->query($sql);
// stmt
$stmt = $conn->prepare($sql);

    $stmt->execute();
    $result = $stmt->get_result();
    
    while ($row = $result->fetch_assoc()) {
        $subject = $row['subject_name'];
        $total_percentage = $row['total_percentage'];
        $grade = determineGrade($total_percentage); 
        $remarks = determineRemarks($total_percentage);
    
        $rank = "N/A";
        foreach ($subjectRanks[$subject] as $student) {
            if ($student['admission_number'] === $admission_number) {
                $rank = $student['rank'];
                break;
            }
        }
        $pdf->Row(array(
       
            $row['subject_name'],
            number_format($row['class_score_percentage'], 2),
            number_format($row['exam_score_percentage'], 2),
            number_format($row['total_percentage'], 2),
            $grade,
            $rank=getOrdinalSuffix($rank),
          
            $remarks
        ));
    }
    
    
    // Adjusted SQL query to fix the 'Invalid use of group function'
  // Adjusted SQL query to fix the 'Invalid use of group function'
  $overall_sql = "SELECT 
  a.admission_number,
  (
      SUM(CASE WHEN a.assessment_type_id != {$examination_id} THEN a.mark ELSE 0 END) / 
      SUM(CASE WHEN a.assessment_type_id != {$examination_id} THEN a.mark_out_of ELSE 0 END) * 30 
  ) 
  +
  (
      SUM(CASE WHEN a.assessment_type_id = {$examination_id} THEN a.mark ELSE 0 END) / 
      SUM(CASE WHEN a.assessment_type_id = {$examination_id} THEN a.mark_out_of ELSE 0 END) * 70
  ) AS overall_total_score
FROM assessment a 
WHERE a.class_id = ? AND a.term_year = ? 
GROUP BY a.admission_number
ORDER BY overall_total_score DESC";

$overall_stmt = $conn->prepare($overall_sql);

if ($overall_stmt === false) {
exit();
}

$overall_stmt->bind_param("is", $class_id, $term_year);
$overall_stmt->execute();
$overall_result = $overall_stmt->get_result();

$overallRanks = [];
$overall_rank = 1;
    

    }
    
    
    
    
    
    while ($overall_row = $overall_result->fetch_assoc()) {
        $overallRanks[$overall_row['admission_number']] = $overall_rank++;
    }
    
    $student_overall_rank = $overallRanks[$admission_number] ?? "N/A";
    $student_overall_rank = getOrdinalSuffix($student_overall_rank);
    
  if($total_students>0){
    $pdf->Ln(-2);
    $pdf->Cell(0, 10, 'POSITION IN CLASS:  ' . $student_overall_rank, 0, 1);
  }


    
    // add attendace  and out of 100
    $pdf->Ln(20);
    
    $attendance=76;
    $total_attendance=90;
    
    $next_term_begins=".............";
    
    
    $attitude="";
    $interest="";
    $head_teacher_comment = "";
    
    $sql = "
    SELECT 
        current_interest.interest as interest_description,
        current_attitude.attitude as attitude_description,
        current_comment.comment_description,
        COALESCE(ht_comment.comment_description, 'More room for improvement') as headteacher_comment
    FROM 
        current_interest
    JOIN current_attitude ON current_interest.admission_number = current_attitude.admission_number
    JOIN current_comment ON current_interest.admission_number = current_comment.admission_number
    LEFT JOIN current_headteacher_comment as ht_comment ON current_interest.admission_number = ht_comment.admission_number AND current_interest.term_year = ht_comment.term_year
    WHERE 
        current_interest.admission_number = ?;
    ";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $admission_number);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $interest = $row['interest_description'];
        $attitude = $row['attitude_description'];
        $comment = $row['comment_description'];
        $head_teacher_comment = $row['headteacher_comment'];
    } else {
        $interest = "N/A";
        $attitude = "N/A";
        $comment = "N/A";
    
    
    
    
    }

    $sql = "SELECT mark AS total_mark, max_mark AS total_max_mark FROM student_attendance WHERE admission_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $admission_number);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $attendance = $row['total_mark'];
        $total_attendance = $row['total_max_mark'];
    } else {
        // Handle the case when there are no records found
        $attendance = 0; // or null, depending on how you want to handle no records
        $total_attendance = 0; // or null
    }
    
    $next_term_begins = 'some_date'; // Set this value accordingly
    
    
    $sql_next_term = "SELECT next_term_Date FROM next_term_date";
    $stmt_next_term = $conn->prepare($sql_next_term);
    $stmt_next_term->execute();
    $result_next_term = $stmt_next_term->get_result();
    $row_next_term = $result_next_term->fetch_assoc();
    
    $next_term_begins = $row_next_term['next_term_Date'];
    
    $next_term_begins=\AE\AE::aeDate($next_term_begins);
    
    
 

  
 if($report_term_count==$totalUniqueTerms) {

   
    $pdf->Cell(0, 10, 'ATTENDANCE: ' . $attendance . ' OUT OF ' . $total_attendance, 0, 1);
    $pdf->Ln(-3);
    // Output "Next Term Begins" on a new line
    $pdf->Cell(0, 10, 'NEXT TERM BEGINS: ' . $next_term_begins, 0, 1);
    
    
    
    
    
    

    
    $pdf->Ln(-3);
    addWrappedCell($pdf, 'INTEREST:', $interest);
    $pdf->Ln(-3);
    addWrappedCell($pdf, 'ATTITUDE:', $attitude);
    $pdf->Ln(-3);
    addWrappedCell($pdf, "CLASS TEACHER'S REMARKS:", $comment);
    $pdf->Ln(-3);
    addWrappedCell($pdf, "HEADTEACHER'S REMARKS:", $head_teacher_comment);
    
    
    // CLASS TEACHER'S SIGNATURE
    $pdf->Ln(-10);


    // Fetch the most recent signature URL from the database
   $sql = "SELECT signature_url FROM signature ORDER BY id DESC LIMIT 1";
   $signature_url = '../devimage/default_signature.png'; // Default signature
   
   if ($stmt = $conn->prepare($sql)) {
       $stmt->execute();
       $result = $stmt->get_result();
       if ($row = $result->fetch_assoc()) {
           $signature_url = $row['signature_url'];
       }
       $stmt->close();
   }
   
   // Assuming $pdf is an instance of an FPDF object and has been properly set up
   $pdf->Ln(10);
   $pdf->Cell(0, 10, "Headteacher's signature", 0, 1);
   $pdf->Ln(-5);
   if ($signature_url != '../devimage/default_signature.png') {
    // if file exist
    if(file_exists($signature_url)) {
        $pdf->Image($signature_url, $pdf->GetX(), $pdf->GetY(), 40); // 40 is an example width of the image
    } 
 

   }
   $pdf->Ln(4); // Line break after the signature image
   $pdf->Cell(0, 10, "...........................................................", 0, 1);
  
 }

    
    $pdf->Ln(-3);
    
    $file_to_delete = '../report/'. $full_name . '.pdf';
    
    if (file_exists($file_to_delete)) {
        if (unlink($file_to_delete)) {
            // File deleted successfully
        } else {
            // Failed to delete file
        }
    } else {
        // File does not exist
    }

    // add page


    
    return $pdf;
    
    
}









foreach ($filter_data as $row) {
    $term_year = $row['term_year'];
    $class_id = $row['class_id'];
    $user_id = $row['user_id'];
    $admission_number = $row['admission_number'];

    // Set values in session variables
    $_SESSION['term_year'] = $term_year;
    $_SESSION['class_id'] = $class_id;
    $_SESSION['user_id'] = $user_id;
    $_SESSION['admission_number'] = $admission_number;

    // Check if both class_id and admission_number do not exist in the student_current_class table
    $sql = "SELECT COUNT(*) AS count FROM student_current_class WHERE class_id = ? AND admission_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $class_id, $admission_number);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $count = $row['count'];

    if ($count == 0) {
        continue;
 
    } else {
    
    }
    




    {
        $admission_number = $_SESSION['admission_number'];
    
    // Corrected SQL query (removed the trailing comma)
    $sql = "SELECT term_year, class_id, user_id
            FROM assessment 
            WHERE admission_number = ?";
    
    // Prepare the SQL statement to avoid SQL injection
    $stmt = $conn->prepare($sql);
    
    if ($stmt === false) {
        // Handle error appropriately
        echo "Error preparing statement: " . $conn->error;
        exit;
    }
    
    // Bind the parameters
    $stmt->bind_param("s", $admission_number);
    
    // Execute the query
    $stmt->execute();
    
    // Get the result set
    $result = $stmt->get_result();
    
    $studentData = [];
    
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            $studentData[] = $row;
        }
    } else {
        echo "0 results";
    }
    
    $stmt->close();
    
    // Additional code...
    
    
    
    
    
    
    $uniqueTerms = [];
    
    // First, collect all unique terms
    foreach ($studentData as $row) {
        $term = $row['term_year'];
        $class_id = $row['class_id'];
    
    
        if (\AE\AE::isEmpty($term)) {
            $term = $_SESSION['current_term'];
        }
    
        if (!in_array($term, $uniqueTerms)) {
            $uniqueTerms[] = $term;
        }
    }
    
    $totalUniqueTerms = count($uniqueTerms);
    
    //echo "uterms:". $totalUniqueTerms;
    
    $report_term_count = 0;
    
    // Now iterate over the data and process it
    foreach ($studentData as $row) {
     
        $schoolClassId = $row['class_id'];
        $term = $row['term_year'];
    
        $_SESSION['userClass']=$schoolClassId;
    
        if (\AE\AE::isEmpty($term)) {
            $term = $_SESSION['current_term'];
        }
    
        // Skip if the term has already been processed
        if (!in_array($term, $uniqueTerms)) {
            continue;
        }
    
    
        $_SESSION['userClass'] = $schoolClassId;
        $_SESSION['term_year'] = $term;
        $_SESSION['user_id'] = $row['user_id'];
    
    
        $_SESSION['total_student']=null;
     // Query to count the total students in the class for the term
     $totalStudentQuery = "SELECT COUNT(DISTINCT admission_number) AS total_students
     FROM assessment
     WHERE class_id = ? AND term_year = ?";
    
    if ($stmt = $conn->prepare($totalStudentQuery)) {
    $stmt->bind_param("is", $schoolClassId, $term);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $_SESSION['total_student'] = $row['total_students'];
    } else {
    $_SESSION['total_student'] = 0;
    }
    
    $stmt->close();
    }
    
    
    
    // Additional code...
    
    $uniqueTerms = [];
    
    // First, collect all unique terms
    foreach ($studentData as $row) {
        $term = $row['term_year'];
        $class_id = $row['class_id'];
    
        if (\AE\AE::isEmpty($term)) {
            $term = $_SESSION['current_term'];
        }
    
        if (!in_array($term, $uniqueTerms)) {
            $uniqueTerms[] = $term;
        }
    }
    
    $totalUniqueTerms = count($uniqueTerms);
    
    $report_term_count = 0;
    
    // Now iterate over the data and process it
    foreach ($studentData as $row) {
        $schoolClassId = $row['class_id'];
        $term = $row['term_year'];
    
        $_SESSION['userClass'] = $schoolClassId;
    
        if (\AE\AE::isEmpty($term)) {
            $term = $_SESSION['current_term'];
        }
    
        // Skip if the term has already been processed
        if (!in_array($term, $uniqueTerms)) {
            continue;
        }
    
    
        $user_promoted_class= $_SESSION['userClass'];
    
    
        $_SESSION['term_year'] = $term;
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['total_student'] = null;
    
      
    
        if (stripos($term, 'Third Term') !== false) {
          $user_promoted_class++;
          $_SESSION['promoted_to'] = $user_promoted_class;
          }
    
        // Get the class name from the school_class table using the userClass session variable
        $classNameQuery = "SELECT class_name FROM school_class WHERE id = ?";
        $stmt1 = $conn->prepare($classNameQuery);
        
        if ($stmt1 === false) {
            // Handle error appropriately
            echo "Error preparing statement: " . $conn->error;
            exit;
        }
        
        $stmt1->bind_param("i", $user_promoted_class); // Assuming $user_promoted_class is already defined and holds the class ID
        $stmt1->execute();
        $result1 = $stmt1->get_result();
        
        if ($result1->num_rows > 0) {
            $row1 = $result1->fetch_assoc();
            $className1 = $row1['class_name'];
            $_SESSION['promoted_class_name'] = $className1;
        } else {
            $_SESSION['promoted_class_name'] = ''; // Set to empty string if class name not found
        }
        
        $stmt1->close();
        
    
      
    
        // Query to count the total students in the class for the term
        $totalStudentQuery = "SELECT COUNT(DISTINCT admission_number) AS total_students
            FROM assessment
            WHERE class_id = ? AND term_year = ?";
    
        if ($stmt = $conn->prepare($totalStudentQuery)) {
            $stmt->bind_param("is", $schoolClassId, $term);
            $stmt->execute();
            $result = $stmt->get_result();
    
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $_SESSION['total_student'] = $row['total_students'];
            } else {
                $_SESSION['total_student'] = 0;
            }
    
            $stmt->close();
        }
    
        $report_term_count++;
    
        PRINT_REPORT($conn, $pdf, $term, $report_term_count, $totalUniqueTerms);
    
        // Remove the term from the array of unique terms
        if (($key = array_search($term, $uniqueTerms)) !== false) {
            unset($uniqueTerms[$key]);
        }
    }
      
    
    
    
    
    
    
    }
    }
}


// foreach ($admission_numbers_array as $admission_number) {
//     PRINT_REPORT($conn,$pdf,$admission_number);
//     $pdf->AddPage();
// }



//$pdf->Output();


$admission_number=$_SESSION['admission_number'];
 $pdf->Output('F', '../report/reports.pdf');
 echo '../report/reports.pdf';
 
$conn->close();



















function image_orientation($filePath) {
    $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
    if (@is_readable($filePath)) {
        if ($extension == 'jpg' || $extension == 'jpeg') {
            if (function_exists('exif_read_data')) {
                $exif = @exif_read_data($filePath);
                if ($exif !== false && isset($exif['Orientation'])) {
                    $imageResource = @imagecreatefromjpeg($filePath);
                    if ($imageResource !== false) {
                        switch ($exif['Orientation']) {
                            case 3:
                                $imageResource = imagerotate($imageResource, 180, 0);
                                break;
                            case 6:
                                $imageResource = imagerotate($imageResource, -90, 0);
                                break;
                            case 8:
                                $imageResource = imagerotate($imageResource, 90, 0);
                                break;
                        }
                        @imagejpeg($imageResource, $filePath, 90);
                    }
                }
            }
        }
        
        
elseif ($extension == 'png') {
$imageResource = @imagecreatefrompng($filePath);
if ($imageResource !== false) {
    
    // Create a new true color image with the same size
    $newImage = imagecreatetruecolor(imagesx($imageResource), imagesy($imageResource));
    
    // Allocate the alpha channel and set blend mode
    imagealphablending($newImage, false);
    imagesavealpha($newImage, true);
    $transparent = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
    
    // Fill the new image with transparent background
    imagefilledrectangle($newImage, 0, 0, imagesx($imageResource), imagesy($imageResource), $transparent);
    
    // Copy the image data from the original to the new image
    imagecopyresampled($newImage, $imageResource, 0, 0, 0, 0, imagesx($imageResource), imagesy($imageResource), imagesx($imageResource), imagesy($imageResource));
    
    // Save the new image
    @imagepng($newImage, $filePath, 9);
}
}


    }
}

