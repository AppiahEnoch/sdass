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
}
