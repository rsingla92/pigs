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
        $eventYear = get_post_default('eventYear', ' ');
        $eventMonth = get_post_default('eventMonth', '');
	
	$query = 'SELECT * FROM Event_atVenue E, venue V WHERE E.venueID = V.venueID AND V.cityName LIKE \'%'."$eventCity" .'%\' OR E.eventName LIKE \'%'.$eventName .'%\'';
        

	echo "Results for events named {$eventName} on the month of {$eventMonth}, {$eventYear} in the city of {$eventCity}:<br>";
	echo run_query($query);
	echo "Click <a href=\"customer.html\">here<//a> to go back to the main page.";
    }

    function find_open_sections()
    {
        if (isset($_POST['eventID']))
        {
            $eventID = $_POST['eventID'];
          
            echo "Open sections for event with ID {$eventID}:<br>";
	    $query = 'SELECT distinct sectionSectionType, E.venueID FROM event_AtVenue E, seatingSection_inVenue S WHERE E.eventID = '. $eventID .' AND E.venueID = S.venueID AND S.seatsAvailable > 0';
	     echo run_query($query);
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
           
            echo "Open seats for event with ID {$eventID}:<br>";
           
	    $query = 'SELECT distinct T.seat_row, T.seatNo FROM ticket_OwnsSeat_WithCustomer T, Event_atVenue E WHERE T.venueID = E.venueID AND E.eventID = '. $eventID;
	    echo run_query($query);
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
        echo "Purchased tickets for customer with username {$_SESSION['login_user']}:<br>";
        $username = $_SESSION['login_user'];
	$query = 'SELECT seat_row, seatNo FROM ticket_ownsSeat_WithCustomers T, customer C WHERE T.userID = C.userID AND C.username = '. $username ;
	echo run_query($query);
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

            // TODO: Write query to purchase tickets.
            $query = 'INSERT INTO ticket_ownsSeat_WithCustomer (ticketID, userID, isAvailable, sectionID, venueID, seat_row, seat_no) '
            $query .= 'VALUES (SEQ_TICKET.NEXTVAL,  
	    $query = 'UPDATE ticket_ownsSeat_WithCustomer T SET T.isAvailable = 0 ';
	    $query .= 'FROM ForAdmissionTo F WHERE F.eventID = ' . $eventID . ' AND ';
            $query .= 'T.ticketID = F.ticketID AND T.seat_row = '. $row .' AND T.seatNo = '. $seatNo .' T.sectionID = '. $seatSectionID;
            echo "Purchased ticket for event with ID {$eventID}. You are in section {$seatSectionID} with row {$row} and seat {$seatNo}.<br>";
	    echo run_query($query);
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
	    $numVenues = $_POST['numVenues'];
	    $query = 'SELECT V.name, VC.cnt FROM venue V, (SELECT V.venueID, COUNT(*) cnt FROM ticket_OwnsSeat_WithCustomer T, venue V GROUP BY V.venueID) VC WHERE ROWNUM <= '. $numVenues .' ORDER BY VC.cnt';   
	
            echo run_query($query);
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
            echo "List of {$_POST['numEvents']} most popular event(s):<br>";
	    $numEvents = $_POST['numEvents'];
 	    $query = 'SELECT EV.eventName, COUNT(*) FROM Event_atVenue EV, forAdmissionTo F, ticket_OwnsSeat_WithCustomer T WHERE F.eventID = EV.eventID AND T.isAvailable = 0 AND ROWNUM <= '. $numEvents .' GROUP BY EV.eventName';
	    echo run_query($query);
        }
        else
        {
            echo "Did not receive the number of events to return.<br>";
        }

        echo "Click <a href=\"customer.html\">here<//a> to go back to the main page.";
    }

    function delete_account()
    {
        echo "Deleted user {$_SESSION['login_user']}.<br>";
	$username = $_SESSION['login_user'];
        $query = 'DELETE FROM Organizer WHERE username = ' . $username;
        $result = run_query($query); 
 	
	unset($_SESSION['login_user']);
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
