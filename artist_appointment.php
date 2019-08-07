<?php
require_once('function.php');

if(isset($_SESSION['authorisation']) && $_SESSION['authorisation'] == 3){
    $navbar = DB::query('SELECT * FROM navbar');
}elseif(isset($_SESSION['authorisation']) && $_SESSION['authorisation'] == 2){
    $navbar = DB::query('SELECT * FROM navbar WHERE authorisation=%i', $_SESSION['authorisation'] != 3 );
}else{
    $navbar = DB::query('SELECT * FROM navbar WHERE authorisation=%i', 1);
}

if (isset($_SESSION["logged_in"]) && $_SESSION["logged_in"] == true && $_SESSION['authorisation'] == 2) {

    // first check if the month and the year is set in the get method (Request), if not define the month and the year as current month and year
    //if the month and year is set in the request method, then it will take those values to make the calendar
    if (!isset($_REQUEST["month"])) $_REQUEST["month"] = date("m");
    if (!isset($_REQUEST["year"])) $_REQUEST["year"] = date("Y");
    if (!isset($_REQUEST["day"])) $_REQUEST["day"] = date("d");


    //takes the values from year and month and set variables to calculate the previous and next year and month
    $prev_year = intval($_REQUEST["year"]);
    $next_year = intval($_REQUEST["year"]);
    $prev_month = intval($_REQUEST["month"])-1;
    $next_month = intval($_REQUEST["month"])+1;
 
    //this if condition determines the change of the months when they reach zero, they will go back to 12 and the year will be decreased by one
    if ($prev_month == 0 ) {
    $prev_month = 12;
    $prev_year = $prev_year - 1;
   
    }
    //similar situation when the months reach 13, the next month will be equal to 1 and it will be added 1 to the year value
    if ($next_month == 13 ) {
    $next_month = 1;
    $next_year = $prev_year + 1;
   
    }

    //here we convert the month number 1-12, to the name of the respective month, by creating a date object and then assigning to the value monthName to be displayed in the first row of the calendar table
    $dateObj   = DateTime::createFromFormat('!m', $prev_month+1);
    $monthName = $dateObj->format('F'); 

    $year = intval($_REQUEST["year"]);
    $month = intval($_REQUEST["month"]);
    $day = intval($_REQUEST["day"]);

    $today = $year."-". $month . "-" . $day;
    $date = new DateTime($today);

    $date->modify("first day of this month");
    $firstday = $date->format("Y-m-d");

    $date->modify("last day of this month");
    $lastday = $date->format("Y-m-d");

    
    $artistID = $_SESSION["ID"];

    $db_appointments = DB::query("SELECT concat(a.FirstName, ' ' ,a.LastName) as 'Name', a.ID as 'ID', a.DateBirth as 'BirthDate', a.ParentID as 'ParentID', 
    a.AppointmentDate as 'AppointmentDate', a.Email as 'Email', a.PhoneNumber as 'PhoneNumber', p.ProcedureName as 'ProcedureName', 
    pa.Name as 'ParentName', pa.Phone as 'ParentPhone', pa.Email as 'ParentEmail', a.Status as 'Status', 
    at.AppointmentTime as 'AppointmentTime' 
    FROM appointments as a  
    INNER JOIN procedures as p ON (a.ProcedureID = p.ID)
    INNER JOIN appointment_times as at ON (a.AppointmentTimeID = at.ID)
    INNER JOIN parents as pa ON (a.ParentID = pa.ID) 
    WHERE ArtistID = %i AND AppointmentDate BETWEEN %s AND %s", $artistID, $firstday, $lastday);

    
    if(isset($_GET["id"]) && $_GET["id"] != "") {
    
    $appointmentID = $_GET["id"];

    DB::query("UPDATE appointments SET Status = 1 WHERE ID=%i", $appointmentID);
    header("Location: artist_appointment.php");
    
    }


} else {

    header("Location: index.php");
}



echo $twig->render('artist_appointment.html',
            array('appointments'=>$db_appointments,
                  'prev_year'=>$prev_year,
                  'prev_month'=>$prev_month,
                  'next_year'=>$next_year,
                  'next_month'=>$next_month,
                  'day'=>$day,
                  'month_name'=>$monthName,
                  'year'=>$year,
                'navbar'=>$navbar));
?>