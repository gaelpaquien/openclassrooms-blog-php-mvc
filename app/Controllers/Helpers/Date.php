<?php 
namespace App\Controllers\Helpers;

use DateTime;
use DateTimeZone;

class Date {

    public function getDateNow()
    {
        $date = new DateTime();
        $date->setTimezone(new DateTimeZone('Europe/Paris'));

        // Returns the current date in DateTime SQL format
        return $date->format('Y-m-d H:i:s');
    }
    
}