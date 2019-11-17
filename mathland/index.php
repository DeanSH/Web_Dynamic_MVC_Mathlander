<?php
    // Starts support for using Sessions to pass and load variables
    session_start();
    // This script goes to a specified controller
    if ( isset($_REQUEST["ctr"]) ){
        $ControllerName = $_REQUEST["ctr"];
        require_once ("Controller//".$ControllerName.".php");
    }
    else
        // Default controller
        require_once "Controller//NavController.php";
?>