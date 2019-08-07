<?php

require_once "function.php";



if(isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == true){


// first check if the month and the year is set in the get method (Request), if not define the month and the year as current month and year
//if the month and year is set in the request method, then it will take those values to make the calendar
if (!isset($_REQUEST["month"])) $_REQUEST["month"] = date("n");
if (!isset($_REQUEST["year"])) $_REQUEST["year"] = date("Y");

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

//here we cast the value of the month and the year from a string to a integer, so it can be use in the mktime function later on
$month = intval($_REQUEST["month"]);
$year = intval($_REQUEST["year"]);


/* draw table */
//here we start drawing the table with the variable calendar, that will be concatenated till the end of the script
$calendar = '<table cellpadding="0" cellspacing="0" class="calendar">';

/* table headings */
//first row of the table includes the month name and the year. When you click in the anchor links it will assign to month the value of the previous and next month...to be used in the beginning of the script
$calendar.= '<tr class="calendar-row"><td colspan="7" class="calendar-month-year-head"><a href="'. $_SERVER["PHP_SELF"].'?month='. $prev_month . '&year='.$prev_year.'">&lt;&lt;</a>'.$monthName. " ". $year.'
<a href="'. $_SERVER["PHP_SELF"].'?month='. $next_month . '&year='.$next_year.'">&gt;&gt;</a></td></tr>';
$headings = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
$calendar.= '<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$headings).'</td></tr>';

/* days and weeks vars now ... */

$running_day = date('w',mktime(0,0,0,$month,1,$year));
$days_in_month = date('t',mktime(0,0,0,$month,1,$month));
$days_in_this_week = 1;
$day_counter = 0;
$dates_array = array();

/* row for week one */
$calendar.= '<tr class="calendar-row">';

/* print "blank" days until the first of the current week */
for($x = 0; $x < $running_day; $x++):
    $calendar.= '<td class="calendar-day-np"> </td>';
    $days_in_this_week++;
endfor;

/* keep going with days.... */
//in this step we start to assingn the days in the calendar and any possible scheduled appointment

for($list_day = 1; $list_day <= $days_in_month; $list_day++):
    $calendar.= '<td class="calendar-day">';
        /* add in the day number */
        $calendar.= '<div class="day-number">'.$list_day.'</div>';

        /** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! **/
        //first we query which are the design times of appointments from the database
        $db_times = DB::query("SELECT * FROM appointment_times");
        //here we recover the complete date, in the same format of the one present in the database to use as filter later one
        $date = $year . "-" . $month . "-" . $list_day;

        //here we create new variables for the day of today and the day of the calendar
        $today = date("Y-m-j");

        // we convert both the date of today and the current calendar variable from a string to time, so it can be use in a comparison later on
        $date_time= strtotime($date);
        $today_time= strtotime($today);

        //in this foreach we loop all the possible appointment times register in the database for each day of the calendar
        foreach($db_times as $row) {
        
        //for each day of the calendar and each time appointment, we make a query to obtain possible matching appointments for this date and time
        $db_appointments = DB::queryFirstRow("SELECT * FROM appointments WHERE AppointmentDate = %s AND AppointmentTimeID = %i", $date, $row["ID"]);
        
        //for each day we also check if the current logged user has a matching appointments for this date and time
        $db_client_appointments = DB::queryFirstRow("SELECT * FROM appointments WHERE AppointmentDate = %s AND AppointmentTimeID = %i 
                                            AND FirstName = %s AND LastName= %s", $date, $row["ID"], $_SESSION["first_name"], $_SESSION["last_name"]);
        
        //if there is a matchin appointment for the current logged user for this specific time and day, we do an additional query to determine with which artist the appointment has been booked
        if ($db_client_appointments != ""){
        $db_artist_appointment = DB::queryFirstRow("SELECT * FROM users WHERE ID=%i", $db_client_appointments["ArtistID"]);

        }
        //here we convert the current appointmente time to a time format that can be display and transfered to the get method
        $time = date('g:ia', strtotime($row["AppointmentTime"]));

        //these series of if statements will determine depending of the result of the above queries if there is an appointment schedule for this specific day and if this appointment is from the current logged user, if it is, it will give the option to delete the appointment
        // additionally we also compare the current date calendar with the current date, so we will no allow users to book appointments in days and times that have already passed
        if ($date_time >= $today_time && $db_appointments == "" && $db_client_appointments == "") {
        $calendar.= '<ul><li><a href="appointment.php?date='.$date.'&time='.$row["AppointmentTime"].'">'. $time . '</a></li></ul>';
        
        } else if ($date_time >= $today_time && $db_appointments != "" && $db_client_appointments == "") {
        $calendar.= '<ul><li><del style="color: red;">'. $time . '<del></li></ul>';

        } else if ($date_time >= $today_time && $db_appointments != "" && $db_client_appointments != ""){
        $calendar.= '<ul><li><strong style="color:blue">'. $time . '</strong> Your appointment with '. $db_artist_appointment["FirstName"]. " " . $db_artist_appointment["LastName"]. '<a href="delete.php?id='.$db_appointments["ID"] .'">&lt;&lt;Delete&gt;&gt;</a></li></ul>';

        } else if (($date_time < $today_time && $db_appointments == "" && $db_client_appointments == "") ||
                    ($date_time < $today_time && $db_appointments != "" && $db_client_appointments == "")) {
        $calendar.= '<ul><li><del>'. $time . '</del></li></ul>';  

        } else if ($date_time < $today_time && $db_appointments != "" && $db_client_appointments != "") {
            $calendar.= '<ul><li><del>'. $time . '</del> Your appointment with '. $db_artist_appointment["FirstName"]. " " . $db_artist_appointment["LastName"]. '</li></ul>'; 
        }
    }
    $calendar.= '</td>';
    if($running_day == 6):
        $calendar.= '</tr>';
        if(($day_counter+1) != $days_in_month):
            $calendar.= '<tr class="calendar-row">';
        endif;
        $running_day = -1;
        $days_in_this_week = 0;
    endif;
    $days_in_this_week++; $running_day++; $day_counter++;
endfor;

/* finish the rest of the days in the week */
if($days_in_this_week < 8):
    for($x = 1; $x <= (8 - $days_in_this_week); $x++):
        $calendar.= '<td class="calendar-day-np"> </td>';
    endfor;
endif;

/* final row */
$calendar.= '</tr>';

/* end the table */
$calendar.= '</table>';


}else{
    $error = 'You need to log in to access.';
    header('Location:index.php');
    
}

echo $twig->render("calendar.html",
            array("calendar"=>$calendar));



?>