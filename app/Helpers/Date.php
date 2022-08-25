<?php
namespace App\Helpers;

use DateTime;
use DateTimeZone;

class Date extends DateTime
{

    public function getDateNow(): string
    {
        $this->setTimezone(new DateTimeZone('Europe/Paris'));

        // Returns the current date in DateTime SQL format
        return $this->format('Y-m-d H:i:s');
    }

}
