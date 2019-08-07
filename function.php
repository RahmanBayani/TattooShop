<?php
//main configuration file

//Check - Session
session_start();





//include composer loader
require_once('vendor/autoload.php');


//Twig - setup template files location
$loader = new Twig_Loader_Filesystem('templates');
$twig = new Twig_Environment($loader);






//check user logged in
$logged_in = false;
if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){
    $logged_in = true;
    $twig->addGlobal('user_name', $_SESSION['name']);
}
$twig->addGlobal('logged_in', $logged_in);


//MeekroDB - database connection and variables
DB::$user = 'root';
DB::$password = 'root';
DB::$dbName = 'tattoo';

$error = '';



