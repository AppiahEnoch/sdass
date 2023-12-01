<?php
session_start();
require_once '../vendor/autoload.php';
include "../config/config.php";
include "../config/settings.php";
include "../config/AE.php";
use AE\AE;

// Function to truncate a specific table






if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['selection'])) {
    $selection = $conn->real_escape_string($_POST['selection']);




    // Process based on selection
    switch ($selection) {
        case 'all_students':
           
            deleteAll("parent");
            deleteAll("student_old_debt");
            deleteAll("father");
            deleteAll("mother");
            deleteAll("student_current_class");
            deleteAll("student_payment");
           
            deleteAll("student_class");
           
            deleteAll("admission_number");
            deleteAll("assessment");
            deleteAll("student");
            deleteAll("bill_item");
            deleteAll("enrollment_code");
            procedure("DeleteInvalidAdmissionNumbers");


            // resetRelatedTables($conn, "student", "ackah");
            // resetRelatedTables($conn, "admission_number", "ackah");
            // resetRelatedTables($conn, "assessment", "ackah");
            // resetRelatedTables($conn, "student_class", "ackah");

            
            // Replace 'students_table' with your actual table name
            break;
        case 'all_teaching_staff':
            deleteSpecificRecord("registration","user_type", "Teaching Staff");
            break;
        case 'all_nonteaching_staff':
            deleteSpecificRecord("registration","user_type", "Non-Teaching Staff");
            break;
        case 'all_admin':
            deleteSpecificRecord("registration","user_type", "Admin");
            break;
        case 'all_bill':
            deleteAll("bill_item");
            break;
        case 'empty_trash':
            $foldersToClear = [
                '../report',
          
              
            ];

            deleteAllFilesInFolders($foldersToClear);

            removeUnlinkedFiles("student", "student_passport_image_input", "../upload");
            removeUnlinkedFiles("registration", "profile_pic", "../userprofile");
            removeUnlinkedFiles("academic_calendar", "academic_calendar_url", "../academic_calendar");
            
            break;
        default:
            echo json_encode(['success' => false, 'message' => 'Invalid selection.']);
            exit;
    }

    echo json_encode(['success' => true, 'message' => 'Selected items have been deleted.']);
} else {
    // Invalid request
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}

// Close connection


function getRelatedTableNames($conn, $tableName, $databaseName) {
    $tables = [];
    $sql = "SELECT DISTINCT table_name 
            FROM information_schema.key_column_usage 
            WHERE (referenced_table_name = '$tableName' OR table_name = '$tableName') 
            AND table_schema = '$databaseName'";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $tables[] = $row['table_name'];
    }
    return $tables;
}

function getForeignKeyRelations($conn, $tableName, $databaseName) {
    $relations = [];
    $sql = "SELECT table_name, column_name, constraint_name, referenced_table_name, referenced_column_name 
            FROM information_schema.key_column_usage 
            WHERE (referenced_table_name = '$tableName' OR table_name = '$tableName') 
            AND table_schema = '$databaseName' AND referenced_table_name IS NOT NULL";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()) {
        $relations[] = $row;
    }
    return $relations;
}

function resetRelatedTables($conn, $tableName, $databaseName) {
    $conn->begin_transaction();

    try {
        // Get related tables
        $tables = getRelatedTableNames($conn, $tableName, $databaseName);

        // Get foreign key relations
        $relations = getForeignKeyRelations($conn, $tableName, $databaseName);

        // Drop foreign keys
        foreach ($relations as $rel) {
            $sql = "ALTER TABLE {$rel['table_name']} DROP FOREIGN KEY {$rel['constraint_name']}";
            $conn->query($sql);
        }

        // Truncate all related tables
        foreach ($tables as $table) {
            $conn->query("TRUNCATE TABLE $table");
        }

        // Re-add foreign keys
        foreach ($relations as $rel) {
            $sql = "ALTER TABLE {$rel['table_name']} ADD CONSTRAINT {$rel['constraint_name']} FOREIGN KEY ({$rel['column_name']}) REFERENCES {$rel['referenced_table_name']}({$rel['referenced_column_name']})";
            $conn->query($sql);
        }

        $conn->commit();
    } catch (Exception $e) {
        $conn->rollback();
        throw $e;
    }
}

// Example usage
resetRelatedTables($conn, 'your_table_name', 'your_database_name');





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







function deleteAllFilesInFolders($folders) {
    foreach ($folders as $folder) {
        // Check if the folder exists
        if (is_dir($folder)) {
            // Open the directory
            $dir = opendir($folder);

            // Loop through the files in the folder
            while (($file = readdir($dir)) !== false) {
                // Skip the . and .. directories
                if ($file != '.' && $file != '..') {
                    // Generate the absolute path to the file
                    $filePath = $folder . DIRECTORY_SEPARATOR . $file;
                    // Check if it's a file and not a directory
                    if (is_file($filePath)) {
                        // Delete the file
                        unlink($filePath);
                    }
                }
            }

            // Close the directory
            closedir($dir);
        } else {
            // Handle the case where the folder doesn't exist
            // You can output an error message or throw an exception
            echo "Folder does not exist: $folder\n";
        }
    }
}


function removeUnlinkedFiles($tableName, $columnName, $folderName) {
    global $conn;

    // Fetch all filenames from the specified table column
    $sql = "SELECT `$columnName` FROM `$tableName`";
    $result = $conn->query($sql);

    if (!$result) {
        // Handle error appropriately
        throw new Exception("Query failed: " . $conn->error);
    }

    // Store all filenames from the database in an array
    $dbFilenames = [];
    while ($row = $result->fetch_assoc()) {
        $dbFilenames[] = basename($row[$columnName]);
    }

    // Check if the folder exists
    if (is_dir($folderName)) {
        // Open the directory
        $dir = opendir($folderName);

        // Loop through the files in the folder
        while (($file = readdir($dir)) !== false) {
            // Skip the . and .. directories
            if ($file != '.' && $file != '..') {
                // Generate the absolute path to the file
                $filePath = $folderName . DIRECTORY_SEPARATOR . $file;

                // Check if it's a file and not a directory
                if (is_file($filePath)) {
                    // Check if the filename exists in the database
                    if (!in_array($file, $dbFilenames)) {
                        // The file is not linked in the database column, delete it
                        unlink($filePath);
                    }
                }
            }
        }

        // Close the directory
        closedir($dir);
    } else {
        // Handle the case where the folder doesn't exist
        echo "Folder does not exist: $folderName";
    }
}



function deleteAll($tableName) {
    global $conn;

    // Prepare the SQL statement to delete all records from the table
    $sql = "DELETE FROM `$tableName`";
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
