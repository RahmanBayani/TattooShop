<?php

require_once "function.php";

if(isset($_GET["id"]) && $_GET["id"] != "") {

    $photoID = $_GET["id"];
    $db_photos = DB::queryFirstRow("SELECT Photo FROM users WHERE ID=%i", $photoID);

    if ($db_photos == "") {
        header("Location:index.php");
    } else {
        
        $row = $db_photos->fetch_assoc();
        header("Content-type: image/jpg");
        echo $row["Photo"];
        exit;
    }

} else {
    header("Location: index.php");
}

?>