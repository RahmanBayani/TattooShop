<?php
require_once('function.php');

$rows = '';
if(isset($_SESSION['authorisation']) && $_SESSION['authorisation'] == 3){
  $rows =  DB::query('SELECT * FROM navbar');
  
}else{
  header('Location:index.php');
  $error = "You have no permission to Access."; 
}


$navbar = DB::query('SELECT * FROM navbar');
$access = DB::query('SELECT * FROM accessibility');


if(isset($_SESSION['authorisation']) && $_SESSION['authorisation'] == 3){
    $navbar = DB::query('SELECT * FROM navbar');
}elseif(isset($_SESSION['authorisation']) && $_SESSION['authorisation'] == 2){
    $navbar = DB::query('SELECT * FROM navbar WHERE authorisation=%i', $_SESSION['authorisation'] != 3 );
}else{
    $navbar = DB::query('SELECT * FROM navbar WHERE authorisation=%i', 1);
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['name']) && isset($_POST['href']) && isset($_POST['authorisation'])){
        DB::insert('navbar', array(
            'name' => $_POST['name'],
            'href' => $_POST['href'],
            'authorisation' => $_POST['authorisation']
        
          ));
          header('Location:admin.php');
    }
}






echo $twig->render('admin.html', array('navbar' => $navbar,
                                       'access' => $access,
                                       'rows' => $rows,
                                       'error' => $error));
?>