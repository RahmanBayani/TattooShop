<?php

require_once "function.php";

if(isset($_SESSION['authorisation']) && $_SESSION['authorisation'] == 3){
    $navbar = DB::query('SELECT * FROM navbar');
}elseif(isset($_SESSION['authorisation']) && $_SESSION['authorisation'] == 2){
    $navbar = DB::query('SELECT * FROM navbar WHERE authorisation=%i', $_SESSION['authorisation'] != 3 );
}else{
    $navbar = DB::query('SELECT * FROM navbar WHERE authorisation=%i', 1);
}


if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true && $_SESSION['authorisation'] == 1){

//First thing is to check if the date and time coming from the calendar php are valid or if they were correctly sent

//If the variables data and time are not setted or empty, it will forward the user back to calendar
if(!isset($_GET["date"]) || !isset($_GET["time"]) ||
   empty($_GET["date"]) || empty($_GET["time"])) header("Location: calendar.php");

//check if the time entered in the GET time is valid time comparing to the data base
$time = false;
$db_times = DB::query("SELECT * FROM appointment_times");

foreach ($db_times as $row) {
    if ($row["AppointmentTime"] == $_GET["time"]) 
    $time = true;
}
//If the user try to change the time for a invalid time, it will send the user back to calendar
if($time == false) header("Location: calendar.php");



// assign empty variables and boolean values
$message = array();
$first_name = $last_name = $date_birth = $procedure = $appointment_date = $appointment_time = $tatto_artist = $email = $phone = $parent_name = $parent_phone = $parent_email = "";


$under_age = false;
$under_age_checked = false;

// check for the post method
if($_SERVER["REQUEST_METHOD"] == "POST") {
    // if the vairables are set, it will assign values to variables otherwise empty string
    $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : "";
    $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : "";
    $date_birth = isset($_POST['date_birth']) ? $_POST['date_birth'] : "";
    $procedure = isset($_POST['procedure']) ? $_POST['procedure'] : "";
    $appointment_date = isset($_POST['appointment_date']) ? $_POST['appointment_date'] : "";
    $appointment_time = isset($_POST['appointment_time']) ? $_POST['appointment_time'] : "";
    $tatto_artist = isset($_POST['tattoo_artist']) ? $_POST['tattoo_artist'] : "";
	$email = isset($_POST['email']) ? $_POST['email'] : "";
    $phone = isset($_POST["phone"])? $_POST["phone"] : "";
    $parent_name =  isset($_POST["parent_name"])? $_POST["parent_name"] : "";
    $parent_phone = isset($_POST["parent_phone"])? $_POST["parent_phone"] : "";
    $parent_email = isset($_POST["parent_email"])? $_POST["parent_email"] : "";

    
        // check if the fields in the form actually exist
    if (!isset($_POST["first_name"]) || 
        !isset($_POST["last_name"]) ||
        !isset($_POST["date_birth"]) ||
        !isset($_POST["procedure"]) ||
        !isset($_POST["appointment_date"]) ||
        !isset($_POST["appointment_time"]) ||
        !isset($_POST["tattoo_artist"]) ||
        !isset($_POST["email"]) ||
        !isset($_POST["phone"])) {
        //if one of the fields doesnt exist, it will give an error
        $message["field_missing"]="A field is missing, please try again!!";

    } else {
        // check if the fields are empty or not, if empty it will create an error message in an array call messages
        if(empty($_POST["first_name"])) $message["first_name"] = "Please add the first name";
        if(empty($_POST["last_name"])) $message["last_name"] = "Please add the last name";
        if(empty($_POST["date_birth"])) $message["date_birth"] = "Please add your date of birth";
        if(empty($_POST["procedure"])) $message["procedure"] = "Please choose a procedure";
        if(empty($_POST["appointment_date"])) $message["appointment_date"] = "You have to choose an appointment date";
        if(empty($_POST["appointment_time"])) $message["appointment_time"] = "You have to choose an appointment time";
        if(empty($_POST["tattoo_artist"])) $message["tattoo_artist"] = "You have to choose a tattoo artist";
        if(empty($_POST["email"])) $message["email"] = "You have to enter your email";
        if(empty($_POST["phone"]) || !is_numeric($_POST["phone"])) $message["phone"] = "Please enter a valid phone number";

        // converts the dates entered by the user to a format compatible with the database
        $date_birth = date("Y-m-j", strtotime($date_birth));
        $appointment_date = date("Y-m-j", strtotime($appointment_date));

        //query do determine if the appointment date and time already exists in the database
        $db_search = DB::queryFirstRow("SELECT * FROM appointments WHERE AppointmentDate = %s AND AppointmentTimeID = %i AND ArtistID = %i", $appointment_date, $appointment_time, $tatto_artist);
        // if the appointment already exists it will create an error message
        if ($db_search != "") $message["appointment_unique"] = "There is already an appointment schedule for this date and time";

        //determine the time difference (in years) between the DateBirth chose by the user and today
        $today = date("Y-m-j");
        $date_time_1 = new DateTime($today);
        $date_time_2 = new DateTime($date_birth);
        $interval = $date_time_1->diff($date_time_2);
        $interval = $interval->format("%y");

        //if the time interval is between 14 and 18 it will ask additional information from the user
        if ($interval >= 14 && $interval <= 18) {
            $message["under_age"] = "People between 14 and 18 years old, need to bring an adult to the appointment together";
            $under_age = true;
        //if the user is under 14, it will refuse the appoitment from the user
        } else if ($interval < 14) {
            $message["refuse"] = "You need to be at least 14 years old (only with parents consent) to get a tattoo or piercing.";
        }
        
        //after the user between 14 and 18 enters the additional information, it will check if it exists and is complete before procceed
        if ($under_age == true && isset($_POST["parent_name"])
            && isset($_POST["parent_phone"]) && isset($_POST["parent_email"])
            && !empty($_POST["parent_name"]) && !empty($_POST["parent_phone"])
            && !empty($_POST["parent_email"])) {
                
                $message["under_age"] = "";
                $under_age_checked = true;

            } else if ( $under_age ) {
                $message["parent_missing"] = "Parent information incomplete or missing.";
            } 
         
    }

    $emptyArray_test = array_filter($message); 
    //if no error message was created up to this point, it will start saving the appointment in the database
    if(empty($emptyArray_test)) {

        //since the appointment time comes from the GEt method...it is a string and not the ID that needs to be converted to integer ID number, to be inserted in the DB table
        switch ($appointment_time) {
            case "09:00:00" :
            $appointment_time = 1;
            break;
            case "11:00:00" :
            $appointment_time = 2;
            break;
            case "13:00:00" :
            $appointment_time = 3;
            break;
            case "15:00:00" :
            $appointment_time = 4;
            break;
            case "17:00:00" :
            $appointment_time = 5;
            break;

        }
       
        //assign the variables to a array to include in the DB
        $var = array("FirstName"=> $first_name,
                     "LastName"=> $last_name,
                     "DateBirth"=> $date_birth,
                     "ProcedureID"=>$procedure,
                     "AppointmentDate"=>$appointment_date,
                     "AppointmentTimeID"=>$appointment_time,
                     "ArtistID"=>$tatto_artist,
                     "Email"=>$email,
                     "PhoneNumber"=> $phone);

        DB::insertUpdate("appointments", $var);

        //this code retrives the id of the last information entered
        $appointment_ID = DB::insertId();

        // if the user is under aged (14 to 18) it will save the parent information in another table
        if ($under_age_checked) {

        $db_parents = DB::queryFirstRow("SELECT * FROM parents WHERE Name = %s AND Phone = %s AND Email = %s", $parent_name, $parent_phone, $parent_email);
        
        //this if statement determines if the parent already exist in the database. If does not exist it will inserted in the database, if does it will take the existing parent id and use in the new appointment
        if ($db_parents == "") {
        $var1 = array("Name"=>$parent_name,
                          "Phone"=>$parent_phone,
                          "Email"=>$parent_email);

        // first insert the additional data in the parent table    
        DB::insertUpdate("parents", $var1);
        
        //this code retrives the id of the last information entered
        $parent_ID = DB::insertId();

        } else {
            $parent_ID = $db_parents["ID"];

        }
            

        
        //query to update the table appointments and change the Parent ID from the default value 1, to the ID of the parent
        DB::query("UPDATE appointments SET ParentID = $parent_ID WHERE ID=%i", $appointment_ID);
        
        }

        //after all the steps...return to the index page
        header("Location: index.php");
        
    }
	
}

} else {
    $error = 'You need to log in to access.';
header('Location:index.php');
}
$db_artists = DB::query("SELECT * FROM users WHERE LoginTypeID = %i", 2);
$db_procedures = DB::query("SELECT * FROM procedures ");


echo $twig->render("appointment1.html",
            array("first_name"=>$_SESSION["first_name"],
                  "last_name"=>$_SESSION["last_name"],
                  "email"=>$_SESSION["email"],
                  "phone"=>$_SESSION["phonenumber"],
                  "birth_date"=>$_SESSION["birth_date"],
                  "artists"=>$db_artists,
                  "messages"=>$message,
                  "procedures"=>$db_procedures,
                  "appointment_date"=>$_GET["date"],
                  "time"=>$_GET["time"],
                  "under_age"=>$under_age,
                  "parent_name"=>$parent_name,
                  "parent_phone"=>$parent_phone,
                  "parent_email"=>$parent_email,
                  'navbar' => $navbar));

?>