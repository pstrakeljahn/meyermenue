<?php

namespace LoginHelper;
include "api/apiHandler.php";

use ApiHandler\ApiHandlerClass;


class UserHelperClass
{
    public static function getUser($id, $pin){
        if(is_numeric($id) && is_numeric($pin)){
            $payload = [
                'customerId' => $id,
                'pinCode' => $pin
            ];
            self::sessionHelper();
            $api = new ApiHandlerClass();
            $response = json_decode($api->login($payload), true);

            if($response['code'] === "400"){
                return false;
            }


            $_SESSION['UserData'] = $response;

            return true;


        }
        return false;
    }

    public static function getMenuByWeekAndYear(){
        $api = new ApiHandlerClass();

        $weeks = self::getWeeksOfMonth();
        foreach($weeks as $week => $irrelevant){
            if(!$_SESSION['menu'][$week]){
                $_SESSION['menu'][$week] = $api->getfood(date('Y'), $week, $_SESSION['token']);
            }
        }

        unset($_SESSION['order']);
        foreach($_SESSION['menu'] as $week => $menu){
            $menuDecode = json_decode($menu, true);
            foreach($menuDecode as $singleMenu){
                if($singleMenu['amount'] > 0){
                    $_SESSION['order'][$week][] = $singleMenu;
                }
            }
        }

    }

    public static function getWeeksOfMonth()
    {
        $currentYear = date('Y');
        $currentMonth = date('m');
    
        //Substitue year and month
        $time = strtotime("$currentYear-$currentMonth-01");  
        //Got the first week number
        $firstWeek = date("W", $time);
    
        if ($currentMonth == 12)
            $currentYear++;
        else
            $currentMonth++;
    
        $time = strtotime("$currentYear-$currentMonth-01") - 86400;
        $lastWeek = date("W", $time);
    
        $weekArr = array();
    
        $j = 1;
        for ($i = $firstWeek; $i <= $lastWeek; $i++) {
            $weekArr[$i] = 'week ' . $j;
            $j++;
        }
        return $weekArr;
    }

    public static function sessionHelper(){

        if(session_status() === 2){
            session_destroy();
        };
        session_start();
    }
}
