<?php
require_once "function.php";

if(isset($_SESSION['authorisation']) && $_SESSION['authorisation'] == 3){
    $navbar = DB::query('SELECT * FROM navbar');
}elseif(isset($_SESSION['authorisation']) && $_SESSION['authorisation'] == 2){
    $navbar = DB::query('SELECT * FROM navbar WHERE authorisation=%i OR authorisation=%i', 2 , 1 );
}else{
    $navbar = DB::query('SELECT * FROM navbar WHERE authorisation=%i', 1);
}

if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){
    header("Location:index.php");
}else{
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['email']) && isset($_POST['password'])){
        $email = $_POST['email'];
        $pw = md5($_POST['password']);
        $table = $_POST['table'];
        $row = DB::queryFirstRow("SELECT * FROM $table WHERE email =%s", $email);
        if(empty($row)){
            $error = "User does not exist!";
        }else{
            if($row['Password'] == $pw){
                $_SESSION['logged_in'] = true;
                $_SESSION['name'] = $row['FirstName'] . " " . $row['LastName'];
                $_SESSION['authorisation'] = $row[LoginTypeID];
                $_SESSION["email"] = $row["Email"];
                $_SESSION["phonenumber"] = $row["PhoneNumber"];
                $_SESSION["birth_date"] = $row["BirthDate"];
                $_SESSION["first_name"] = $row["FirstName"];
                $_SESSION["last_name"] = $row["LastName"];
                $_SESSION["ID"] = $row["ID"];








                header("Location:index.php");
            }else{
                $error = "User exist! wrong password !";
            }
        }
    }
}

}


echo $twig->render("index.html", array('navbar' => $navbar,
                                       'error'=>$error));

?>
