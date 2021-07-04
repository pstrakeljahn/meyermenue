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

    public static function sessionHelper(){

        if(session_status() === 2){
            session_destroy();
        };
        session_start();
    }
}
