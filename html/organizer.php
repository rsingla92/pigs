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
//username = $_COOKIE['login_user'];
//a = "SELECT organizerID from Organizer WHERE username = '%s'";
//q = sprintf($a, $username);
//result = run_query($q);
//row = oci_fetch_assoc($result);
//organizerID = $row["ORGANIZERID"];
//cho "OrgID\n";
//cho $organizerID;
//cho "\n";
$organizerID = $_COOKIE['organizer_id'];
echo sprintf("\nOrg: %s\n", $organizerID);

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
        $vals = array('venueID', 'name', 'basePrice',
                      'startTime',
                      'endTime',
                      'saleOpenTime');
        if (all_set($vals))
        {
          echo "Got venue with ID {$_POST['venueID']}, name {$_POST['name']}, and price {$_POST['basePrice']}.<br>";
          $fmt = "INSERT INTO Event_atVenue VALUES (%s, SEQ_EVENT.NEXTVAL, '%s', %s, TO_TIMESTAMP('%s'), '%s', TO_TIMESTAMP('%s'), TO_TIMESTAMP('%s'), %s)";
          $q = sprintf($fmt, $_POST['venueID'], $_POST['name'], $_POST['basePrice'],
            $_POST['saleOpenTime'], 'Closed', $_POST['startTime'], $_POST['endTime'], $_COOKIE['organizer_id']);
          echo get_html_table($q);
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
           $q = "INSERT INTO Venue VALUES (SEQ_VENUE.NEXTVAL, '%s', '%s', '%s', '%s')";
           $qe = sprintf($q, $_POST['name'], $_POST['address'], $_POST['city'], $_POST['province']);
           echo get_html_table($qe);
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
            $query = 'INSERT INTO SeatingSection_inVenue (sectionID, venueID, additionalPrice, seatsAvailable, sectionSectionType) VALUES (SEQ_SECTION.NEXTVAL, '.$venue.',' . $price.','. $seats.','. $userType.')';
            $result = get_html_table($query);
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
            $fmt = "INSERT INTO Seat_inSection VALUES (%s, %s, %s, %s)";
            $q = sprintf($fmt, $section, $venue, $row, $seat);
            echo get_html_table($q);
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
          $fmt = "DELETE FROM Event_atVenue WHERE eventID = %s";
          $q = sprintf($fmt, $_POST['eventID']);
          echo get_html_table($q);
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
          $fmt = "DELETE FROM Venue WHERE venueID = %s";
          $q = sprintf($fmt, $_POST['venueID']);
          echo get_html_table($q);
        }
        else
        {
            echo "Invalid parameters.<br>";
        }
    }
  
    function delete_seating_section()
    {
      if (isset($_POST['venueID'], $_POST['sectionID']))
        {
          echo "Section ID: {$_POST['sectionID']}.<br>";
          $fmt = "DELETE FROM SeatingSection_inVenue WHERE sectionID = %s AND venueID = %s";
          $q = sprintf($fmt, $_POST['sectionID'], $_POST['venueID']);
          echo get_html_table($q);
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
          $fmt = "DELETE FROM Seat_inSection WHERE sectionID = %s AND venueID = %s AND seat_row = %s AND seatNo = %s";
          $q = sprintf($fmt, $_POST['sectionID'], $_POST['venueID'], $_POST['row'], $_POST['seatNo']);
          echo get_html_table($q);
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
          $fmt = "UPDATE Event_atVenue SET saleOpenDate = CURRENT_TIMESTAMP WHERE eventID = %s";
          $q = sprintf($fmt, $_POST['eventID']);
          echo get_html_table($q);
        }
        else
        {
            echo "Invalid parameters.<br>";
        }

    }
 
    function view_all_events()
    {
      echo get_html_table("SELECT * FROM Event_atVenue");
    }
  
    function view_all_venues()
    {
      echo get_html_table("SELECT * FROM Venue");
    }

    function view_all_sections()
    {
      echo get_html_table("SELECT * FROM SeatingSection_inVenue");
    }
  
    function view_all_seats()
    {
      echo get_html_table("SELECT * FROM Seat_inSection");
    }
 
    function view_purchased_seats()
    {
      echo get_html_table("SELECT * FROM Ticket_ownsSeat_WithCustomer");
    }

    function view_most_popular_venues()
    {
        if (isset($_POST['numVenues']))
        {
          echo "Num venues: {$_POST['numVenues']}.<br>";
          $fmt = "SELECT V.venueID, count(*) as events FROM Venue V, Event_atVenue E WHERE V.venueID = E.venueID AND ROWNUM <= %s GROUP BY V.venueID ORDER BY count(*)";
          $q = sprintf($fmt, $_POST['numVenues']);
          echo get_html_table($q);
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
          $fmt = "
            SELECT * FROM (
              SELECT E.eventID EventID, count(*) 
              FROM Event_atVenue E, ForAdmissionTo FAT, Ticket_ownsSeat_WithCustomer T 
              WHERE E.eventID = FAT.eventID 
              AND FAT.ticketID = T.ticketID 
              GROUP BY E.eventID
              ORDER BY count(*))
            WHERE ROWNUM <= %s";
          $q = sprintf($fmt, $_POST['numEvents']);
          echo get_html_table($q);

          echo '<br>my events<br>';
          $organizerID = $_COOKIE['organizer_id'];
          $fmt = "
            SELECT *
            FROM
              ((SELECT E.eventID eid, count(*) cnt
                FROM Event_atVenue E, ForAdmissionTo FAT, Ticket_ownsSeat_WithCustomer T 
                WHERE E.eventID = FAT.eventID 
                AND FAT.ticketID = T.ticketID 
                AND E.organizerID = %s
                GROUP BY E.eventID)
              UNION
                (SELECT E2.eventID eid, 0 cnt
                 FROM Event_atVenue E2
                 WHERE E2.eventID NOT IN (SELECT E3.eventID FROM Event_atVenue E3, ForAdmissionTo FAT2, Ticket_ownsSeat_WithCustomer T2
                                          WHERE E3.eventID = FAT2.eventID 
                                          AND FAT2.ticketID = T2.ticketID 
                                          AND E3.organizerID = %s)
                 AND E2.organizerID = %s)
              ORDER BY cnt)
            WHERE ROWNUM <= %s";
          $q = sprintf($fmt, $organizerID, $organizerID, $organizerID, $_POST['numEvents']);
          echo run_query($q);
          echo get_html_table($q);
        }
        else
        {
            echo "Invalid parameters.<br>";
        }
    }

    function delete_account()
    {
      // Don't know if this will work
      $fmt = "DELETE FROM Organizer WHERE username = %s";
      $q = sprintf($fmt, $_SESSION['login_user']);
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
