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
    function get_post_default($k, $default)
    {
        if (isset($_POST[$k])) return $_POST[$k];
        return $default;
    }

    function create_event()
    {
    }
   
    function create_venue()
    {
    }
 
    function create_seating_section()
    {
    }
  
    function create_seat()
    {
    }
 
    function delete_event()
    {
    }
 
    function delete_venue()
    {
    }
  
    function delete_seating_section()
    {
    ]

    function delete_seat()
    {
    }

    function start_ticket_sales()
    {
    }
 
    function view_all_events()
    {
    }
  
    function view_all_venues()
    {
    }

    function view_all_sections()
    {
    }
  
    function view_all_seats()
    {
    }
 
    function view_purchased_seats()
    {
    }

    function view_most_popular_venues()
    {
    }

    function view_most_popular_events()
    {
    }

    function delete_account()
    {
    }

    $action_num = intval(get_post_default('action', '0'));
    if ($action_num >= 1 && $action_num <= 8)
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
         echo "Click <a href=\"Customer.html\">here<//a> to go back to the main page.";
    }

?>

</body>
</html>
