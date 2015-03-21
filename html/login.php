<?php
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

        $hash_pass = sha1($pass); 
        // TODO: Check if in DB, else return false.

        echo "Attempting to login user: {$user}.<br>";

//        $q = "SELECT count(*) FROM Customer WHERE username = '%s' AND password = '%s' GROUP_BY userID";
//        $qe = sprintf($q, $user, $hash_passd);

        $qe = "SELECT userID FROM customer";
        echo $qe;
        echo run_query($qe);

        session_start();
        $_SESSION['login_user'] = $user;
        return true;
    }

    if (handle_login())
    {
        // TODO: Base page on user type
        //header('Location: customer.html');
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
