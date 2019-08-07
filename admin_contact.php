<?php
require_once('function.php');
if(isset($_SESSION['authorisation']) && $_SESSION['authorisation'] == 3){
    $navbar = DB::query('SELECT * FROM navbar');
}elseif(isset($_SESSION['authorisation']) && $_SESSION['authorisation'] == 2){
    $navbar = DB::query('SELECT * FROM navbar WHERE authorisation=%i', $_SESSION['authorisation'] != 3 );
}else{
    $navbar = DB::query('SELECT * FROM navbar WHERE authorisation=%i', 1);
}


if(isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true && $_SESSION['authorisation'] == 3) {

    $db_contactus = DB::query("SELECT * FROM contactus");

    if(isset($_GET["id"]) && $_GET["id"] != "") {
    
        $appointmentID = $_GET["id"];
    
        DB::query("UPDATE contactus SET status = 1 WHERE ID=%i", $appointmentID);
        header("Location: admin_contact.php");
        
        } 
    

} else {

    header("Location: index.php");
}



echo $twig->render('admin_contact.html',
            array("contactus"=>$db_contactus,
                    'navbar'=>$navbar));
?>