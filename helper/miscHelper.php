<?php

namespace MiscHelper;

use DateTime;

class MiscHelperClass
{
    const ALLOWED_DAYS = [1,2,4];

    public function getStartAndEndDate($week, $year, $modify = false, $days = null) {
        $dto = new DateTime();
        $dto->setISODate($year, $week);
        if($modify){
            $addDays = 0 + $days-1;
            $dto->modify('+'.$addDays.' days');
            return $dto->format('Y-m-d');
        } else {
            $ret['start'] = $dto->format('d.m.Y');
            $dto->modify('+6 days');
            $ret['end'] = $dto->format('d.m.Y');
        }
        return $ret;
    }

    public static function translate($i){
        switch ($i) {
            case 1:
            case 'Monday':
                return "Montag";
            case 2:
            case 'Tuesday':
                return "Dienstag";
            case 3:
            case 'Wednesday':
                return "Mittwoch";
            case 4:
            case 'Thursday':
                return "Donnerstag";
            case 5:
            case 'Friday':
                return "Freitag";
            case 6:
            case 'Saturday':
                return "Samstag";
            case 7:
            case 'Sunday':
                return "Sonntag";
        }
    }
}
