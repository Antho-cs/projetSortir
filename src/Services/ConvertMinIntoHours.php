<?php

namespace App\Services;

use Symfony\Component\Validator\Constraints\Date;

class ConvertMinIntoHours
{
    public function convertHourMin($duration, $format = '%02d:%02d')
    {
        if ($duration < 1) {
            return;
        }
        $hours = floor($duration / 60);
        $minutes = ($duration % 60);
        return sprintf($format, $hours, $minutes);
    }

}