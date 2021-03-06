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

    function find_event()
    {
        $eventCity = get_post_default('eventCity', ' '); 
        $eventName = get_post_default('eventName', ' ');

        $query = "SELECT E.eventID, E.venueID, E.eventName, E.basePrice, V.name, V.cityName, E.startTime 
                  FROM Event_atVenue E, venue V 
                  WHERE E.venueID = V.venueID AND 
                  (V.cityName LIKE '{$eventCity}' 
                   OR E.eventName LIKE '{$eventName}')";

	echo "Results for events:<br>";
	echo get_html_table($query);
	echo "Click <a href=\"customer.html\">here<//a> to go back to the main page.";
    }

    function find_open_sections()
    {
        if (isset($_POST['eventID']))
        {
            $eventID = $_POST['eventID'];
          
            echo "Open sections for event with ID {$eventID}:<br>";

	    if(!is_numeric($eventID))
	    {
	   	echo "Please check the types of your entries. An error may occur!<br>";
	    	return;
	
	    }
	    $query = 'SELECT distinct seatingSectionType, E.venueID FROM event_AtVenue E, seatingSection_inVenue S WHERE E.eventID = '. $eventID .' AND E.venueID = S.venueID AND S.seatsAvailable > 0';
	     echo get_html_table($query);
	 }
        else
        {
            echo "Did not receive an eventID with request.<br>";
        }

        echo "Click <a href=\"customer.html\">here<//a> to go back to the main page.";
    }

    function find_open_seats()
    {
        if (isset($_POST['eventID']))
        {
            $eventID = $_POST['eventID'];
 
	    if(!is_numeric($eventID))
	    {
	   	echo "Please check the types of your entries. An error may occur!<br>";
	    	return;
	
	    }          
            echo "Open seats for event with ID {$eventID}:<br>";
            $query = "SELECT S.seat_row, S.seatNo FROM seat_inSection S, Event_atVenue E WHERE S.venueID = E.venueID AND E.eventID = {$eventID}";
	    $query .= " MINUS ";
	    $query .= "SELECT T.seat_row, T.seatNo FROM ticket_ownsSeat_WithCustomer T, event_atVenue E, ForAdmissionTo F WHERE T.isAvailable = 'F' AND F.eventID = E.eventID AND T.ticketID = F.ticketID AND E.eventID = {$eventID}";
 
	    echo get_html_table($query);
        }
        else
        {
            echo "Did not receive an eventID with request.<br>";
        }

        echo "Click <a href=\"customer.html\">here<//a> to go back to the main page.";
    }

    function view_purchased_tickets()
    {
        // TODO: Query to find purchased tickets
        echo "Purchased tickets for customer with username {$_COOKIE['login_user']}:<br>";
        $username = $_COOKIE['login_user'];
	$query = "SELECT seat_row, seatNo FROM ticket_ownsSeat_WithCustomer T, customer C WHERE T.userID = C.userID AND C.username = '{$username}'";
	echo get_html_table($query);
        echo "Click <a href=\"customer.html\">here<//a> to go back to the main page.";
    }

    function purchase_ticket()
    {
        if (isset($_POST['eventID']) && isset($_POST['seatSectionID']) && isset($_POST['row'])
              && isset($_POST['seatNo']))
        {
            $eventID = $_POST['eventID'];
            $seatSectionID = $_POST['seatSectionID'];
            $row = $_POST['row'];
            $seatNo = $_POST['seatNo'];
            $userID = $_COOKIE['user_id'];

	    if(!is_numeric($eventID) || !is_numeric($seatSectionID) || !is_numeric($row) || !is_numeric($seatNo))
	    {
	   	echo "Please check the types of your entries. An error may occur!<br>";
	    	return;
	    } 


            // TODO: Write query to purchase tickets.
            $query = 'INSERT INTO ticket_ownsSeat_WithCustomer (ticketID, userID, isAvailable, sectionID, venueID, seat_row, seatNo) ';
            $query .= 'SELECT SEQ_TICKET.NEXTVAL, ' . $userID . ', \'F\', ' . $seatSectionID . ', E.venueID, ' . $row . ', ' . $seatNo . ' ';
            $query .= 'FROM Event_atVenue E ';
            $query .= 'WHERE E.eventID = ' . $eventID . ' AND NOT EXISTS (';
            $query .= 'SELECT * FROM ticket_ownsSeat_WithCustomer T ';
            $query .= 'WHERE T.venueID = E.venueID AND T.sectionID = ' . $seatSectionID . ' AND T.seat_row = ' . $row . ' ';
            $query .= 'AND T.seatNo = ' . $seatNo . ' AND T.isAvailable = \'F\')';

            echo "Purchased ticket for event with ID {$eventID}. You are in section {$seatSectionID} with row {$row} and seat {$seatNo}.<br>";
	    echo get_html_table($query);
    }
        else
        {
            echo "Did not receive the expected input for purchasing tickets.<br>";
        }

        echo "Click <a href=\"customer.html\">here<//a> to go back to the main page.";
    }

    function most_popular_venues()
    {
        if (isset($_POST['numVenues']))
        {
            echo "List of {$_POST['numVenues']} most popular venue(s):<br>";
	
	    if(!is_numeric($_POST['numVenues']))
	    {
	   	echo "Please check the types of your entries. An error may occur!<br>";
	    	return;
	    } 

	    $numVenues = $_POST['numVenues'];
	    $query = "SELECT V1.name, VC.cnt 
                      FROM venue V1, (SELECT T.venueID, COUNT(*) cnt 
                                      FROM ticket_OwnsSeat_WithCustomer T
                                      GROUP BY T.venueID) VC 
                      WHERE V1.venueID = VC.venueID AND ROWNUM <= {$numVenues}
                      ORDER BY VC.cnt DESC";   
	
            echo get_html_table($query);
        }
        else
        {
            echo "Did not receive the number of venues to return.<br>";
        }

        echo "Click <a href=\"customer.html\">here<//a> to go back to the main page.";
    }

    function most_popular_events()
    {
        if (isset($_POST['numEvents']))
        {
          echo "Num Events: {$_POST['numEvents']}.<br>";

            if(!is_numeric($_POST['numEvents']))
            {
               echo "Please check the types of your entries! An error may occur!<br>";
               return;		
            }

          $fmt = "
            SELECT *
            FROM
              ((SELECT E.eventID eid, count(*) cnt
                FROM Event_atVenue E, ForAdmissionTo FAT, Ticket_ownsSeat_WithCustomer T 
                WHERE E.eventID = FAT.eventID 
                AND FAT.ticketID = T.ticketID 
                GROUP BY E.eventID)
              UNION
                (SELECT E2.eventID eid, 0 cnt
                 FROM Event_atVenue E2
                 WHERE E2.eventID NOT IN (SELECT E3.eventID FROM Event_atVenue E3, ForAdmissionTo FAT2, Ticket_ownsSeat_WithCustomer T2
                                          WHERE E3.eventID = FAT2.eventID 
                                          AND FAT2.ticketID = T2.ticketID)
                 )
              ORDER BY cnt DESC)
            WHERE ROWNUM <= %s";
          $q = sprintf($fmt, $_POST['numEvents']);
          echo get_html_table($q);
        }
        else
        {
            echo "Did not receive the number of events to return.<br>";
        }

        echo "Click <a href=\"customer.html\">here<//a> to go back to the main page.";
    }

    function delete_account()
    {
        echo "Deleted user {$_COOKIE['login_user']}.<br>";
	$username = $_COOKIE['login_user'];
        $query = "DELETE FROM Organizer WHERE username = '" . $username . "'";
        $result = get_html_table($query); 
 	
	unset($_COOKIE['login_user']);
        session_destroy();
    }

    $action_num = intval(get_post_default('action', '0'));
    if ($action_num >= 1 && $action_num <= 8)
    {
        echo "Action num: {$action_num}.<br>";
        switch ($action_num)
        {
            case 1:
                find_event();
                break;
            case 2:
                find_open_sections();
                break;
            case 3:
                find_open_seats();
                break;
            case 4:
                view_purchased_tickets();
                break;
            case 5:
                purchase_ticket();
                break;
            case 6:
                most_popular_venues();
                break;
            case 7:
                most_popular_events();
                break;
            case 8:
                delete_account();
                break;
            default:
                echo "Invalid operation.<br>";
                echo "Click <a href=\"customer.html\">here<//a> to go back to the main page.";
                break;
        }
    }
    else
    {
         echo "Invalid operation.<br>";
         echo "Click <a href=\"customer.html\">here<//a> to go back to the main page.";
    }
?>

</body>
</html>
