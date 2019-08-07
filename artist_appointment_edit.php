<?php
require_once('function.php');

$message = array();
$first_name = $last_name = $date_birth = $procedure = $appointment_date = $appointment_time = $tatto_artist = $email = $phone = $parent_name = $parent_phone = $parent_email = "";              
if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true && $_SESSION['authorisation'] == "2") {

    if(isset($_GET["id"]) && $_GET["id"] != "") {

        $appointmentID = $_GET["id"];

        $db_apppointments = DB::queryFirstRow("SELECT a.FirstName as 'FirstName', a.LastName as 'LastName', a.DateBirth as 'BirthDate', a.ParentID as 'ParentID', 
        a.AppointmentDate as 'AppointmentDate', a.Email as 'Email', a.PhoneNumber as 'PhoneNumber', p.ProcedureName as 'ProcedureName', p.ID as 'ProcedureID', 
        pa.Name as 'ParentName', pa.Phone as 'ParentPhone', pa.Email as 'ParentEmail', pa.ID as 'ParentID', 
        at.ID as 'AppointmentTimeID', at.AppointmentTime as 'AppointmentTime', u.ID as 'ArtistID', concat(u.FirstName, ' ', u.LastName) as 'ArtistName'  
        FROM appointments as a  
        INNER JOIN procedures as p ON (a.ProcedureID = p.ID)
        INNER JOIN appointment_times as at ON (a.AppointmentTimeID = at.ID)
        INNER JOIN parents as pa ON (a.ParentID = pa.ID)
        INNER JOIN users as u ON (a.ArtistID = u.ID) 
        WHERE a.ID = %i", $appointmentID);

        

        if ($db_apppointments == "") {

            header("Location: artist_appointment.php");

        } else {

            $first_name1 = $db_apppointments["FirstName"];
            $last_name1 = $db_apppointments["LastName"];
            $birth_date1 = $db_apppointments["BirthDate"];
            $appointment_date1 = $db_apppointments["AppointmentDate"];
            $appointment_timeID = $db_apppointments["AppointmentTimeID"];
            $appointment_time1 = $db_apppointments["AppointmentTime"];
            $procedureID = $db_apppointments["ProcedureID"];
            $artistID = $db_apppointments["ArtistID"];
            $phone1 = $db_apppointments["PhoneNumber"];
            $email1 = $db_apppointments["Email"];
            $parentID = $db_apppointments["ParentID"];
            $parent_name1 = $db_apppointments["ParentName"];
            $parent_phone1 = $db_apppointments["ParentPhone"];
            $parent_email1 = $db_apppointments["ParentEmail"];

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
                    !isset($_POST["phone"]))
                    
                     {
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

                     DB::update("appointments", $var, "ID=%i", $appointmentID);
                     header("Location: artist_appointment.php");
                }
            }
            }
        }

        
    
    } else {
    
    header("Location: index.php");

    }

} else {

 header("Location: index.php");
}

$db_artists = DB::query("SELECT * FROM users WHERE LoginTypeID = %i", 2);
$db_procedures = DB::query("SELECT * FROM procedures "); 
$db_times = DB::query("SELECT * FROM appointment_times");

echo $twig->render('artist_appointment_edit.html',
            array('first_name'=>$first_name1,
                  'last_name'=>$last_name1,
                  'birth_date'=>$birth_date1,
                  'appointment_date'=>$appointment_date1,
                  'appointment_timeID'=>$appointment_timeID,
                  'appointment_time'=>$appointment_time1,
                  'procedureID'=>$procedureID,
                  'artistID'=>$artistID,
                  'phone'=>$phone1,
                  'email'=>$email1,
                  'parent_ID'=>$parentID,
                  'parent_name'=>$parent_name1,
                  'parent_phone'=>$parent_phone1,
                  'parent_email'=>$parent_email1,
                  'procedures'=>$db_procedures,
                  'artists'=>$db_artists,
                  'times'=>$db_times,
                  'messages'=>$message));