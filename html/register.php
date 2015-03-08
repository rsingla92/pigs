<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>PIGS Login</title>
<link rel="stylesheet" type="text/css" href="view.css" media="all">
<script type="text/javascript" src="view.js"></script>

</head>
<body id="main_body" >
    <img id="top" src="top.png" alt="">
    <div id="form_container">
	
<?php
    // Validate data 
    $email = $_POST["email"];
    $user = $_POST["user"];
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $user_type = $_POST["userType"];
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        echo "Invalid email supplied.<br>";
        echo "Click <a href=\"CreateAccount.html\">here<//a> to try again.";
    }
    else if ($user === '' || $first_name === '' || $last_name === '' || ($user_type <> 1 && $user_type <> 2))
    {
        echo "Invalid input to the registration form.<br>";
        echo "Click <a href=\"CreateAccount.html\">here<//a> to try again.";
    }
    else
    {
        $pswd = sha1($_POST["password"]);
        $pswd_confirm = sha1($_POST["password_confirm"]);

        if (strcmp($pswd, $pswd_confirm) !== 0) 
        {
            echo "Your password and confirmed password did not match.<br>";
            echo "Click <a href=\"CreateAccount.html\">here<//a> to try again.";
        }
        else
        {
            echo "Hello, {$first_name} {$last_name}. You have successfully created an account.<br>";
            echo "Click <a href=\"loginForm.html\">here<//a> to login.";
            // Store data in DB here
        }
    }
?>
</body>
</html>
