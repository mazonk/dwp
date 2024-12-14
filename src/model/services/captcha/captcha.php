<?php
        include_once "session_config.php";
        include_once ("./phptextClass.php");  
        
        $phptextObj = new phptextClass();       
        /*phptext function to genrate image with text*/
        $phptextObj->phpcaptcha('#162453','#fff',120,40,10,25);      
 ?>