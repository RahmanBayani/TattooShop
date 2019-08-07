<?php
require_once "function.php";

session_start(); //whenever we want to work on $_SESSION we have to use this code

$_SESSION = array(); //because $_SESSION is a kind of array - to delete the sessions values
session_destroy(); //to destroy the session

header('Location: index.php');

?>