<?php
    include 'db.php';
    
    function handle_login()
    {
       $user = trim($_POST['user']);
       $pass = trim($_POST['password']);
       
        if (empty($user))
        {
            return false;
        }
        
        if (empty($pass))
        {
            return false;
        }

        echo "Attempting to login user: {$user}.<br>";

        $q = "SELECT * FROM Customer WHERE username = '%s' AND password = '%s'";
        $qe = sprintf($q, $user, $pass);

        $num_rows = num_rows_in_select($qe);

        if ($num_rows == 1)
        {
            session_start();
            $_SESSION['login_user'] = $user;
            $_SESSION['login_user_id'] = $userID; // TODO
            return 'customer';
        }
    
        $q = "SELECT * FROM Organizer WHERE username = '%s' AND password = '%s'";
        $qe = sprintf($q, $user, $pass);

        //echo get_html_table(run_query("SELECT * FROM Organizer")); // for debug only

        $num_rows = num_rows_in_select($qe);

        if ($num_rows == 1)
        {
            session_start();
            $_SESSION['login_user'] = $user;
            $_SESSION['login_user_id'] = $userID; // TODO
            return 'organizer';
        }
        
        return false;
    }

    if (handle_login() == 'customer')
    {
        header('Location: customer.html');
    }
    else if (handle_login() == 'organizer')
    {
        header('Location: organizer.html');
    }
    else
    {
        echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
        echo '<html xmlns="http://www.w3.org/1999/xhtml">';
        echo '<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">';
        echo '<title>PIGS Login</title>';
        echo '<link rel="stylesheet" type="text/css" href="view.css" media="all">';
        echo '<script type="text/javascript" src="view.js"></script>';
        echo '</head><body id="main_body" ><img id="top" src="top.png" alt=""><div id="form_container">';
        echo 'Invalid username and/or password.<br>.';
        echo "Click <a href=\"login.html\">here<//a> to try again.";
    }
?>
