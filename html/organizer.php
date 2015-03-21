<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Customer</title>
<link rel="stylesheet" type="text/css" href="view.css" media="all">
<script type="text/javascript" src="view.js"></script>

</head>
<body id="main_body" >
	
<img id="top" src="top.png" alt="">
<div id="form_container">

<?php
    include 'db.php';

    function get_post_default($k, $default)
    {
        if (isset($_POST[$k])) return $_POST[$k];
        return $default;
    }

    function all_set($vals)
    {
        foreach ($vals as $i) {
            if (!isset($_POST[$i])) return FALSE;
        }
    
        return TRUE;
    }

    function create_event()
    {
        $vals = array('venueID', 'name', 'basePrice', 'startTimeYear', 'startTimeMonth', 'startTimeDay',
                      'startTimeHour', 'startTimeMinute', 'startTimeSel', 'endTimeYear', 'endTimeMonth',
                      'endTimeDay', 'endTimeHour', 'endTimeMinute', 'endTimeSel', 'saleOpenTimeYear',
                      'saleOpenTimeMonth', 'saleOpenTimeDay', 'saleOpenTimeHour', 'saleOpenTimeMinute',
                      'saleOpenTimeSel');
        if (all_set($vals))
        {
           echo "Got venue with ID {$_POST['venueID']}, name {$_POST['name']}, and price {$_POST['basePrice']}.<br>";
           echo "Could not create a new event at this time. No SQL support yet!<br>";
        }
        else
        {
           echo "You did not supply the needed parameters to create an event.<br>";
        }
    }
   
    function create_venue()
    {
       $vals = array('name', 'address', 'city', 'province');
       
       if (all_set($vals))
       {
           echo "Got venue with name {$_POST['name']}, address {$_POST['address']}, city {$_POST['city']}, province {$_POST['province']}.<br>";
           echo "Could not create a new venue at this time. No SQL support yet!<br>";
       }
       else
       {
           echo "You did not supply the parameters needed to create a venue.<br>";
       }
    }
 
    function create_seating_section()
    {
        $vals = array('additionalPrice', 'seatsAvailable', 'userType', 'venueID');

        if (all_set($vals))
        {
            $price = $_POST['additionalPrice'];
            $seats = $_POST['seatsAvailable'];
            $userType = $_POST['userType'];
            $venue = $_POST['venueID'];
            echo "Got new seating section w/ price {$price}, seats {$seats}. user type {$userType} and venue {$venue}.<br>";
            $query = "INSERT INTO SeatingSection_inVenue (venueID, additionalPrice, seatsAvailable, sectionSectionType) VALUES {$venue}, {$price}, {$seats}, ${userType}";
            $result = run_query($query);
            echo $result;
        }
        else
        {
            echo "You did not supply the parameters needed to create a seating section.<br>";
        }
    }
  
    function create_seat()
    {
        $vals = array('row', 'seatNo', 'sectionID', 'venueID');
 
        if (all_set($vals))
        {
            $row = $_POST['row'];
            $seat = $_POST['seatNo'];
            $section = $_POST['sectionID'];
            $venue = $_POST['venueID'];
            echo "Row {$row}, seat {$seat}, section {$section}, venue {$venue}.<br>";
            echo "Could not create a seat at this time. No SQL support yet!<br>";
        }
        else
        {
            echo "You did not supply the parameters needed to create a seat.<br>";
        }
    }
 
    function delete_event()
    {
        if (isset($_POST['eventID']))
        {
            echo "Event ID: {$_POST['eventID']}.<br>";
            echo "Could not delete the event at this time.<br>";
        }
        else
        {
            echo "Invalid parameters.<br>";
        }
    }
 
    function delete_venue()
    {
        if (isset($_POST['venueID']))
        {
            echo "Venue ID: {$_POST['venueID']}.<br>";
            echo "Could not delete the venue at this time.<br>";
        }
        else
        {
            echo "Invalid parameters.<br>";
        }

    }
  
    function delete_seating_section()
    {
        if (isset($_POST['sectionID']))
        {
            echo "Section ID: {$_POST['sectionID']}.<br>";
            echo "Could not delete the section at this time.<br>";
        }
        else
        {
            echo "Invalid parameters.<br>";
        }

    }

    function delete_seat()
    {
        if (isset($_POST['row']) && isset($_POST['seatNo']))
        {
            echo "Row: {$_POST['row']}, Seat No: {$_POST['seatNo']}.<br>";
            echo "Could not delete the seat at this time.<br>";
        }
        else
        {
            echo "Invalid parameters.<br>";
        }

    }

    function start_ticket_sales()
    {
        if (isset($_POST['eventID']))
        {
            echo "Event ID: {$_POST['eventID']}.<br>";
            echo "Cannot start ticket sales at this time.<br>";
        }
        else
        {
            echo "Invalid parameters.<br>";
        }

    }
 
    function view_all_events()
    {
        echo "Cannot view all events at this time. No SQL support!<br>";
    }
  
    function view_all_venues()
    {
        echo "Cannot view all venues at this time. No SQL support!<br>";
    }

    function view_all_sections()
    {
        echo "Cannot view all sections at this time. No SQL support!<br>";
    }
  
    function view_all_seats()
    {
        echo "Cannot view all seats at this time. No SQL support!<br>";
    }
 
    function view_purchased_seats()
    {
        echo "Cannot view all purchased seats at this time. No SQL support!<br>";
    }

    function view_most_popular_venues()
    {
        if (isset($_POST['numVenues']))
        {
            echo "Num venues: {$_POST['numVenues']}.<br>";
            echo "Cannot view most popular venues at this time. No SQL support!<br>";
        }
        else
        {
            echo "Invalid parameters.<br>";
        }
    }

    function view_most_popular_events()
    {
        if (isset($_POST['numEvents']))
        {
            echo "Num Events: {$_POST['numEvents']}.<br>";
            echo "Cannot view the most popular events at this time. No SQL support!<br>";
        }
        else
        {
            echo "Invalid parameters.<br>";
        }
    }

    function delete_account()
    {
        echo "Cannot delete your account at this time. No SQL support!<br>";
    }

    $action_num = intval(get_post_default('action', '0'));
    if ($action_num >= 1 && $action_num <= 17)
    {
        echo "Action num: {$action_num}.<br>";
        switch ($action_num)
        {
            case 1:
                create_event();
                break;
            case 2:
                create_venue();
                break;
            case 3:
                create_seating_section();
                break;
            case 4:
                create_seat();
                break;
            case 5:
                delete_event();
                break;
            case 6:
                delete_venue();
                break;
            case 7:
                delete_seating_section();
                break;
            case 8:
                delete_seat();
                break;
            case 9:
                start_ticket_sales();
                break;
            case 10:
                view_all_events();
                break;
            case 11:
                view_all_venues();
                break;
            case 12:
                view_all_sections();
                break;
            case 13:
                view_all_seats();
                break;
            case 14:
                view_purchased_seats();
                break; 
            case 15:
                view_most_popular_venues();
                break;
            case 16:
                view_most_popular_events();
                break;
            case 17:
                delete_account();
                break;
            default:
                echo "Invalid operation.<br>";
                echo "Click <a href=\"Customer.html\">here<//a> to go back to the main page.";
                break;
        }
    }
    else
    {
         echo "Invalid operation.<br>";
         echo "Click <a href=\"Organizer.html\">here<//a> to go back to the main page.";
    }

?>

</body>
</html>
