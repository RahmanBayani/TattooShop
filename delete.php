<?php

require_once "function.php";

//simple delete script that is called when the logged user clicks on the delete button 
//just to be sure we check if the user is logged and if the get variable id, which holds the id of the appointment to be deleted, is also setted
//in case this condition fails, it will foward the user back to the login page

if ($_SESSION["logged_in"] == true && isset($_GET["id"])) {

    DB::query("DELETE FROM appointments WHERE ID=%i", $_GET["id"]);
    header("Location: calendar.php");

} else {

    header ("Location: login.php");
}




?>