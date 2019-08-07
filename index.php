<?php
require_once('function.php');

if(isset($_SESSION['authorisation']) && $_SESSION['authorisation'] == 3){
    $navbar = DB::query('SELECT * FROM navbar');
}elseif(isset($_SESSION['authorisation']) && $_SESSION['authorisation'] == 2){
    $navbar = DB::query('SELECT * FROM navbar WHERE authorisation=%i OR authorisation=%i', 2 , 1 );
}else{
    $navbar = DB::query('SELECT * FROM navbar WHERE authorisation=%i', 1);
}









echo $twig->render('index.html', array('navbar' => $navbar,
                                       'error' => $error));
?>