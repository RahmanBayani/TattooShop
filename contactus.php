<?php
require_once "function.php";

if(isset($_SESSION['authorisation']) && $_SESSION['authorisation'] == 3){
    $navbar = DB::query('SELECT * FROM navbar');
}elseif(isset($_SESSION['authorisation']) && $_SESSION['authorisation'] == 2){
    $navbar = DB::query('SELECT * FROM navbar WHERE authorisation=%i OR authorisation=%i', 2 , 1 );
}else{
    $navbar = DB::query('SELECT * FROM navbar WHERE authorisation=%i', 1);
}


    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['name']) && 
       isset($_POST['email']) && 
       isset($_POST['phone']) && 
       isset($_POST['subject']) && 
       isset($_POST['message'])){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $subject = $_POST['subject'];
        $message = $_POST['message'];
            
            DB::insert('contactus', array(
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'subject' => $subject,
                'message' => $message
              ));
              $error = "Your Message Sent Successfuly.";
            }




echo $twig->render("contactus.html", array('navbar' => $navbar,
                                            'error'=>$error));
?>