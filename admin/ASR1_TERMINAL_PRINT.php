<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

require('../mc_table.php');

ob_end_clean();
$admission_number = $_POST['admission_number'];


$term = $_SESSION['current_term'];
$total_students=  $_SESSION['total_student'];

$student_image_url="../devimage/placeholder.png";

$db_image_url = null;

$promoted_to = $_SESSION['promoted_class_name'];


if (stripos($term, 'Third Term') !== false) {
    $promoted_to = $_SESSION['promoted_class_name'];
  } else {
    $promoted_to = null;
  }



$pdf = new PDF_MC_Table();
$pdf->AddPage();

$pdf->SetFont('Arial', '', 11);


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

    if(\AE\AE::isEmpty($db_image_url)) {
        $db_image_url = null;
    } 
    else{
        $student_image_url = $db_image_url;
    }  


    $gender = $row4['gender'];
    $class_name = $row4['class_name'];









    
if (empty($admission_number)) {
    die("Please provide an admission number");
}






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



$pdf->Image($student_image_url, $x, 10, 25);



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
$pdf->Cell(0, 10, 'No information found.', 0, 1);
}


$pdf->SetFont('Arial', '', 11);
// add line space
$pdf->Ln(5);



////








// Table Widths
$pdf->SetWidths(array(60, 20, 20, 20, 20, 20,30));

// Table Headers
$pdf->Row(array('Subject', 'Class Score (30%)', 'Exam Score (70%)', 'Total Score','GRADE', 'Position','REMARKS'));


function determineGrade($score) {
    if ($score >= 80 && $score <= 100) return 'A';
    if ($score >= 75 && $score <= 79) return 'B+';
    if ($score >= 70 && $score <= 74) return 'B';
    if ($score >= 65 && $score <= 69) return 'C+';
    if ($score >= 60 && $score <= 64) return 'C';
    if ($score >= 55 && $score <= 59) return 'D+';
    if ($score >= 50 && $score <= 54) return 'D';
    if ($score >= 0 && $score <= 49) return 'E';
    return 'N/A';
}


function determineRemarks($score) {
    if ($score >= 95) return 'Exceptional';
    if ($score >= 85) return 'Excellent';
    if ($score >= 75) return 'Very Good';
    if ($score >= 65) return 'Good';
    if ($score >= 55) return 'Credit';
    if ($score >= 50) return 'Pass';
    return 'Below Average';
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

$term_year = $_SESSION['current_term'];
$class_id =  $_SESSION['userClass'];

// SQL for subject ranking
$rank_sql = "SELECT 
                a.admission_number,
                s.subject_name,
                (SUM(CASE WHEN a.assessment_type_id != 5 THEN a.mark ELSE 0 END) / 
                SUM(CASE WHEN a.assessment_type_id != 5 THEN a.mark_out_of ELSE 0 END)) * 30 
                + SUM(CASE WHEN a.assessment_type_id = 5 THEN (a.mark / a.mark_out_of) * 70 ELSE 0 END) AS total_percentage
             FROM assessment a 
             JOIN subjects s ON a.subject_id = s.id
             WHERE a.class_id = ? AND a.term_year = ? 
             GROUP BY s.subject_name, a.admission_number
             ORDER BY s.subject_name, total_percentage DESC";

$rank_stmt = $conn->prepare($rank_sql);
$rank_stmt->bind_param("is", $class_id, $term_year);
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
          (SUM(CASE WHEN a.assessment_type_id != 5 THEN a.mark ELSE 0 END) / 
           SUM(CASE WHEN a.assessment_type_id != 5 THEN a.mark_out_of ELSE 0 END)) * 30 AS class_score_percentage,
          SUM(CASE WHEN a.assessment_type_id = 5 THEN (a.mark / a.mark_out_of) * 70 ELSE 0 END) AS exam_score_percentage,
          (SUM(CASE WHEN a.assessment_type_id != 5 THEN a.mark ELSE 0 END) / 
           SUM(CASE WHEN a.assessment_type_id != 5 THEN a.mark_out_of ELSE 0 END)) * 30 
          + SUM(CASE WHEN a.assessment_type_id = 5 THEN (a.mark / a.mark_out_of) * 70 ELSE 0 END) AS total_percentage
        FROM assessment a 
        JOIN subjects s ON a.subject_id = s.id
        WHERE a.admission_number = ? AND a.class_id = ? AND a.term_year = ? 
        GROUP BY s.subject_name, a.admission_number
        ORDER BY s.subject_name";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sis", $admission_number, $class_id, $term_year);
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
$overall_sql = "SELECT 
                   a.admission_number,
                   (
                       SUM(CASE WHEN a.assessment_type_id != 5 THEN a.mark ELSE 0 END) / 
                       SUM(CASE WHEN a.assessment_type_id != 5 THEN a.mark_out_of ELSE 0 END) * 30 
                   ) 
                   +
                   (
                       SUM(CASE WHEN a.assessment_type_id = 5 THEN a.mark ELSE 0 END) / 
                       SUM(CASE WHEN a.assessment_type_id = 5 THEN a.mark_out_of ELSE 0 END) * 70
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






while ($overall_row = $overall_result->fetch_assoc()) {
    $overallRanks[$overall_row['admission_number']] = $overall_rank++;
}

$student_overall_rank = $overallRanks[$admission_number] ?? "N/A";
$student_overall_rank = getOrdinalSuffix($student_overall_rank);

$pdf->Ln();
$pdf->Cell(0, 10, 'POSITION IN CLASS:  ' . $student_overall_rank, 0, 1);

// add attendace  and out of 100
$pdf->Ln(-3);

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
$row = $result->fetch_assoc();

$attendance = $row['total_mark'];
$total_attendance = $row['total_max_mark'];
$next_term_begins = 'some_date'; // Set this value accordingly


$sql_next_term = "SELECT next_term_Date FROM next_term_date";
$stmt_next_term = $conn->prepare($sql_next_term);
$stmt_next_term->execute();
$result_next_term = $stmt_next_term->get_result();
$row_next_term = $result_next_term->fetch_assoc();

$next_term_begins = $row_next_term['next_term_Date'];

$next_term_begins=\AE\AE::aeDate($next_term_begins);



$pdf->Cell(0, 10, 'ATTENDANCE: ' . $attendance . ' OUT OF '.$total_attendance.'          NEXT TERM BEGINS: ' . $next_term_begins, 0, 1);







$pdf->Ln(-3);
$pdf->Cell(0, 10, 'INTEREST: ' . $interest, 0, 1);
$pdf->Ln(-3);
$pdf->Cell(0, 10, 'ATTITUDE: ' . $attitude, 0, 1);
$pdf->Ln(-3);
$pdf->Cell(0, 10, "CLASS TEACHER'S REMARKS: " . $comment, 0, 1);
$pdf->Ln(-3);
$pdf->Cell(0, 10, "HEADTEACHER'S REMARKS: " . $head_teacher_comment, 0, 1);

// CLASS TEACHER'S SIGNATURE
$pdf->Ln(10);
$pdf->Cell(0, 10, "CLASS TEACHER'S SIGNATURE: ...............................................", 0, 1);



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






// output file
$pdf->Output('F', '../report/'. $full_name. '.pdf');
// echo the file path
echo '../report/'. $full_name . '.pdf';

$conn->close();
?>
