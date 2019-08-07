<?php
require_once "function.php";
$navbar = DB::query('SELECT * FROM navbar');

if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){
    header("Location:index.php");
}else{
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['firstname']) && 
       isset($_POST['lastname']) && 
       isset($_POST['email']) && 
       isset($_POST['phonenumber']) && 
       isset($_POST['password']) &&
       isset($_POST['dateBirth']) &&  $_POST['dateBirth'] != ''){
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $phonenumber = $_POST['phonenumber'];
        $pw = md5($_POST['password']);
        $BirthDate = $_POST['dateBirth'];
        $row = DB::queryFirstRow("SELECT * FROM clients WHERE email =%s", $email);
        if(empty($row)){
            
            DB::insert('clients', array(
                'FirstName' => $firstname,
                'LastName' => $lastname,
                'Email' => $email,
                'PhoneNumber' => $phonenumber,
                'Password' => $pw,
                'LoginTypeID' => 1,
                'BirthDate'=> $BirthDate
              ));

              $_SESSION['logged_in'] = true;
              $_SESSION['name'] = $row['FirstName'] . " " . $row['LastName'];
              $_SESSION['authorisation'] = $row['LoginTypeID'];
              $_SESSION["email"] = $row["Email"];
              $_SESSION["phonenumber"] = $row["PhoneNumber"];
              $_SESSION["birth_date"] = $row["BirthDate"];
              $_SESSION["first_name"] = $row["FirstName"];
              $_SESSION["last_name"] = $row["LastName"];

              header("Location:index.php");
              $error = "You are Signed up and loged in.";

        }else{
            $error = "This email is already exist !";     
        }
     }else{
        $error = "Please fill out all required field ."; 
     }
  }

}


echo $twig->render("index.html", array('navbar' => $navbar,
                                       'error'=>$error));