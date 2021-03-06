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
echo sprintf("\nCurrent Organizer: %s\n", $organizerID);
echo "<br>";

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
	  // do not check the name of the venue.
	  if(!is_numeric($_POST['venueID']) || !is_numeric($_POST['basePrice'])
		|| !preg_match('/[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}/',$_POST['startTime'])
		|| !preg_match('/[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}/',$_POST['endTime']) 
		|| !preg_match('/[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}/',$_POST['saleOpenTime']))
	  {
		echo "Please check the types of your entries! An error may occur!<br>";
		return;
	  }

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
           $q = "INSERT INTO Venue VALUES (SEQ_VENUE.NEXTVAL, '%s', '%s', '%s', '%s', null)";
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
	
	    if(!is_numeric($price) || !is_numeric($seats) || !is_numeric($venue))
	    {
		echo "Please check the types of your entries! An error may occur!<br>";
		return;
            }

            echo "Got new seating section w/ price {$price}, seats {$seats}. user type {$userType} and venue {$venue}.<br>";
            $query = 'INSERT INTO SeatingSection_inVenue (sectionID, venueID, additionalPrice, seatsAvailable, seatingSectionType) VALUES (SEQ_SECTION.NEXTVAL, '.$venue.',' . $price.','. $seats.','. $userType.')';
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

	    if( !is_numeric($row) || !is_numeric($seat) || !is_numeric($section) || !is_numeric($venue))
	    {
	    	echo "Please check the types of your entries! An error may occur!<br>";
		return;		
            } 
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

	  if( !is_numeric($_POST['eventID']) )
	  {
	  	echo "Please check the types of your entries! An error may occur!<br>";
		return;		
	  }
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
          if( !is_numeric($_POST['venueID']) )
	  {
	  	echo "Please check the types of your entries! An error may occur!<br>";
		return;		
	  }
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
          if( !is_numeric($_POST['venueID']) || !is_numeric($_POST['sectionID']) )
          {
            echo "Please check the types of your entries! An error may occur!<br>";
            return;		
          }

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
	  if( !is_numeric($_POST['row']) || !is_numeric($_POST['seatNo']) )
	  {
	  	echo "Please check the types of your entries! An error may occur!<br>";
		return;		
	  }
          
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

	  if(!is_numeric($_POST['eventID']))
	  {
	   	echo "Please check the types of your entries! An error may occur!<br>";
		return;		
	  }
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
      echo get_html_table("SELECT * FROM Ticket_ownsSeat_WithCustomer NATURAL JOIN ForAdmissionTo");
    }

    function view_most_popular_venues()
    {
        if (isset($_POST['numVenues']))
        {
          echo "Num venues: {$_POST['numVenues']}.<br>";

   	  if(!is_numeric($_POST['numVenues']))
	  {
	     echo "Please check the types of your entries! An error may occur!<br>";
	     return;		
	  }

          $fmt = "SELECT V.venueID, count(*) as events 
            FROM Venue V, Event_atVenue E 
            WHERE V.venueID = E.venueID 
              AND ROWNUM <= %s 
            GROUP BY V.venueID 
            ORDER BY count(*)";
          $q = sprintf($fmt, $_POST['numVenues']);
          echo get_html_table($q);

          // Now doing that huge query
          // Average events per venue, then the max or min of them
          // Max Average Seats sold per venue
          $mm = strtolower($_POST['minmax']);
          if ($mm != 'min' and $mm != 'max') {
            echo 'Need min or max only, got ' . $mm;
            return;
          }
          echo 'For each venue, there is an average number of seats sold for events at that venue. Select the max or min of these averages.';
          $fmt = "
            WITH eventTicketsSold
            AS
            (SELECT eid, cnt
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
                 )
            ),
            averageVenueSales
            AS
            (
              SELECT V.venueID venueID, avg(ETS.cnt) average
              FROM eventTicketsSold ETS, Event_atVenue E, Venue V
              WHERE ETS.eid = E.eventID
                AND E.venueID = V.venueID
                GROUP BY V.venueID
             )
            SELECT AVS.venueID, AVS.average as Average_Tickets_Sold
            FROM averageVenueSales AVS
            WHERE AVS.average = (SELECT %s(average)
                                 FROM averageVenueSales)";
          $q = sprintf($fmt, $_POST['minmax']);
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
              ORDER BY cnt DESC)
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
      $fmt = "DELETE FROM Organizer WHERE organizerID = %s";
      $q = sprintf($fmt, $_COOKIE['organizer_id']);
      echo run_query($q);
    }

    function refreshTicketsToEvent()
    {
        if (isset($_POST['eventID']))
        {
            // First store current sequence ticket ID
            $q = "SELECT SEQ_TICKET.NEXTVAL from Ticket_ownsSeat_WithCustomer";
            $startTIDArr = oci_fetch_array(run_query($q));
            //echo $startTIDArr;

            foreach ($startTIDArr as $item) {
                $startTID = ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;");
            }

            // opted to NOT delete tickets first, and will assume user is smart and does not have any tickets already created
            // when they use this function.
    /*        // Second delete all tickets associated with this event
            $fmt = "DELETE FROM Ticket_ownsSeat_WithCustomer T, ForAdmissionTo FAT 
                    WHERE FAT.eventID = %s AND T.ticketID = FAT.ticketID";
            $q = sprintf($fmt, $_POST['eventID']);
            run_query($q); */ 
            
            // Third create new tickets for a venue
            $q =   "INSERT INTO Ticket_ownsSeat_WithCustomer
                    SELECT SEQ_TICKET.NEXTVAL, NULL, 't', SIS.sectionID, SIS.venueID, SIS.seat_row, SIS.seatNo
                    FROM SeatingSection_inVenue SSIV, Seat_inSection SIS, Venue V                
                    WHERE V.venueID = SSIV.venueID AND SSIV.venueID = SIS.venueID AND SSIV.sectionID = SIS.sectionID";
            run_query($q);

            // Finally, repopulate ForAdmissionTo

            $fmt = "INSERT INTO ForAdmissionTo
                    SELECT %s, ticketID 
                    FROM Ticket_ownsSeat_WithCustomer
                    WHERE ticketID >= $startTID";
            $q = sprintf($fmt, $_POST['eventID']);
            run_query($q);

            echo "Refreshed tickets successfully for eventID: {_POST['eventID']}"; 
            echo "Click <a href=\"customer.html\">here<//a> to go back to the main page.";
        }
        else
        {
            echo "Invalid parameters.<br>";
        }
    }

    function changeBasePrice()
    {
        if (isset($_POST['eventID']) && isset($_POST['basePrice']))
        {
          echo "Event ID: {$_POST['eventID']}. New base price: {$_POST['basePrice']}<br>";
          $fmt = "UPDATE Event_atVenue SET basePrice = %s WHERE eventID = %s";
          $q = sprintf($fmt, $_POST['basePrice'], $_POST['eventID']);
          get_html_table($q);
          echo "Click <a href=\"customer.html\">here<//a> to go back to the main page.";
        }
        else
        {
            echo "Invalid parameters.<br>";
        }
    }

    function find_superfans()
    {
      echo "Fans";
      $fmt = "
        WITH
        customerEvents
        AS
        (SELECT DISTINCT C.userID, E.eventID
        FROM Customer C, Event_atVenue E, ForAdmissionTo FAT, Ticket_ownsSeat_WithCustomer T
        WHERE E.eventID = FAT.eventID
          AND FAT.ticketID = T.ticketID
          AND T.userID = C.userID
        )
        SELECT CE.userID
        FROM customerEvents CE
        WHERE CE.eventID IN (SELECT eventID eventID
                             FROM Event_atVenue
                             WHERE eventName = '%s')
        GROUP BY CE.userID
        HAVING count(*) = (SELECT count(*)
                           FROM Event_atVenue 
                           WHERE eventName = '%s')
        ";
      $q = sprintf($fmt, $_POST['eventName'], $_POST['eventName']);
      echo get_html_table($q);
    }

    $action_num = intval(get_post_default('action', '0'));
    if ($action_num >= 1 && $action_num <= 20)
    {
        //echo "Action num: {$action_num}.<br>";
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
            case 18:
                refreshTicketsToEvent();
                break;
            case 19:
                changeBasePrice();
            case 20:
                find_superfans();
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
         echo "Click <a href=\"Organizer.html\">here<//a> to go back to the main page.";
    }

?>

</body>
</html>
