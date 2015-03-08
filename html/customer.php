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

    function find_event()
    {
        $eventCity = get_post_default('eventCity', ''); 
        $eventName = get_post_default('eventName', '');
        $eventYear = get_post_default('eventYear', '');
        $eventMonth = get_post_default('eventMonth', '');

        // TODO: Query based on input.
        echo "Results for events named {$eventName} on the month of {$eventMonth}, {$eventYear} in the city of {$eventCity}:<br>";
        echo "Nothing so far! Haven't added queries!<br>";
        echo "Click <a href=\"Customer.html\">here<//a> to go back to the main page.";
    }

    $action_num = intval(get_post_default('action', '0'));
    if ($action_num >= 1 && $action_num <= 8)
    {
        echo "Action num: {$action_num}<br>";
        switch ($action_num)
        {
            case 1:
                find_event();
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
