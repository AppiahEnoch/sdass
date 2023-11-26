<?php


$foldersToClear = [
    '../upload',

  
];

deleteAllFilesInFolders($foldersToClear);




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
