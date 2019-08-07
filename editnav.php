<?php
require_once "function.php";

//simple delete script that is called when the logged user clicks on the delete button 
//just to be sure we check if the user is logged and if the get variable id, which holds the id of the appointment to be deleted, is also setted
//in case this condition fails, it will foward the user back to the login page


if(isset($_SESSION['authorisation']) && $_SESSION['authorisation'] == 3){
    $navbar = DB::query('SELECT * FROM navbar');
    $access = DB::query('SELECT * FROM accessibility');
}elseif(isset($_SESSION['authorisation']) && $_SESSION['authorisation'] == 2){
    $navbar = DB::query('SELECT * FROM navbar WHERE authorisation=%i', $_SESSION['authorisation'] != 3 );
}else{
    $navbar = DB::query('SELECT * FROM navbar WHERE authorisation=%i', 1);
}

if ($_SESSION["logged_in"] == true && isset($_GET["id"]) && $_SESSION['authorisation'] == 3) {
    $row = DB::queryFirstRow("SELECT * FROM navbar WHERE ID=%i", $_GET["id"]);

} else {
    header ("Location: index.php");
}



if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['name']) && 
       isset($_POST['href']) && 
       isset($_POST['authorisation']) && 
       isset($_GET['id'])){
        $name = $_POST['name'];
        $href = $_POST['href'];
        $authorisation = $_POST['authorisation'];
        $id = $_GET['id'];
        $row = DB::update('navbar', array(
            'name' => $name,
            'href' => $href, 
            'authorisation' => $authorisation
            ), "id=%i", $id);
            header ("Location: admin.php");
        }else{
            $error = "Please fill out all items.";
        }
    }




echo $twig->render("editnav.html", array('navbar' => $navbar,
                                       'error'=>$error,
                                        'row'=> $row,
                                        'access'=>$access));
?>