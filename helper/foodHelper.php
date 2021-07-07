<?php

namespace FoodHelper;

use DateTime;

class FoodHelperClass
{
    public static function getFoodByWeek($week){
        if(isset($_SESSION['order'][$week])){
            $arrFoodWeek = [];
            foreach($_SESSION['order'][$week] as $week => $item){
                $data = [];
                $datetime = DateTime::createFromFormat('Y-m-d', $item['date']);
                $date = $datetime->format('l');
                $data['date'] = self::translate($date);
                $data['title'] = $item['title'];
                $description = substr($item['description'], 0, strpos($item['description'], "{"));
                $data['description'] = $description;
                $data['menuimage'] = $item['menuimage'];
                $data['menuID'] = $item['planpos'];
                $arrFoodWeek[] = $data;
            }

            return $arrFoodWeek;
        }

        return [];
    }

    public static function translate($i){
        switch ($i) {
            case 'Monday':
                return "Montag";
            case 'Tuesday':
                return "Dienstag";
            case 'Wednesday':
                return "Mittwoch";
            case 'Thursday':
                return "Donnerstag";
            case 'Friday':
                return "Freitag";
            case 'Saturday':
                return "Samstag";
            case 'Sunday':
                return "Sonntag";
        }
    }
}
