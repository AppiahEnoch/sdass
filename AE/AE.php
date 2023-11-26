<?php
namespace AE;

class AE {
    
    public static function isEmpty($value) {
        // Check for actual null or empty string
        if ($value === null || $value === '') {
            return true;
        }

        // Check for string representation of "null" (case-insensitive)
        if (strtolower($value) === 'null') {
            return true;
        }

        // Use default empty() function for all other checks
        return empty($value);
    }





    public static function aeDate($timestamp = null) {
        if ($timestamp) {
            $date = new \DateTime($timestamp);
        } else {
            $date = new \DateTime();
        }
        return $date->format('l, jS F, Y g:i a');
    } 

    public static function aeDate0($timestamp = null) {
        if ($timestamp) {
            $date = new \DateTime($timestamp);
        } else {
            $date = new \DateTime();
        }
        return $date->format('l, jS F, Y');
    }
    

    public static function aeDate1($timestamp = null) {
        if ($timestamp) {
            $date = new \DateTime($timestamp);
        } else {
            $date = new \DateTime();
        }
        return $date->format('jS F, Y');
    }


    public static function aeDate2($timestamp = null) {
        if ($timestamp) {
            $date = new \DateTime($timestamp);
        } else {
            $date = new \DateTime();
        }
        return $date->format('jS M. Y');
    }


    
    public static function image_orientation1($filePath) {
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
    
    
    
    
}
