<?php

class CheckInfos {

    public function isValidDate($date, $format = 'Y-m-d') {
        $d = DateTime::createFromFormat($format, $date);
        
        if (!$d || $d->format($format) !== $date) {
            return false;
        }
    
        $today = new DateTime();
        $age = $today->diff($d)->y;
    
        return $age >= 18;
    }

    public function isValidGender($gender, $value) {
        if ($gender === "genre" &&
            strtolower($value) !== "homme" &&
            strtolower($value) !== "femme" &&
            strtolower($value) !== "autre") {
            return false;
        }
        return true;
    }

  
    public function isValidEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function isValidPassword($password) {
        return strlen($password) >= 10;
    }
}
