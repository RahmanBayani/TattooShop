<?php

require_once "function.php";


if(isset($_SESSION['authorisation']) && $_SESSION['authorisation'] == 3){
    $navbar = DB::query('SELECT * FROM navbar');
}elseif(isset($_SESSION['authorisation']) && $_SESSION['authorisation'] == 2){
    $navbar = DB::query('SELECT * FROM navbar WHERE authorisation=%i', $_SESSION['authorisation'] != 3 );
}else{
    $navbar = DB::query('SELECT * FROM navbar WHERE authorisation=%i', 1);
}



$db_artists = DB::query("SELECT * FROM users WHERE LoginTypeID=%i", 2);



echo $twig->render("artists.html", 
            array("artists"=>$db_artists,
                    'navbar'=>$navbar));

?>