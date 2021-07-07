<?php
include "api/apiHandler.php";

use ApiHandler\ApiHandlerClass;

session_start();


$api = new ApiHandlerClass();
if ($api->logout($_SESSION['token']))
{
    session_destroy();
    echo "<script> window.location.replace('./login.php') </script>";
}
?>
