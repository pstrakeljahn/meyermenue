<?php

include "api/apiHandler.php";

use ApiHandler\ApiHandlerClass;

class Test {
    function test(){
        $request =  ApiHandlerClass::get('additives/');
        return $request;
    }
}

$test = new Test();
echo $test->test();