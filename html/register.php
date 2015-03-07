<html>
<body>
<?php
    $pswd = password_hash($_POST["password"], PASSWORD_BCRYPT);
    $pswd_confirm = password_hash($_POST["password_confirm"], PASSWORD_BCRYPT);

    if ($pswd == $pswd_confirm) 
    {
        echo "Hello, {$_POST['first_name']} {$_POST['last_name']}. You have successfully created an account";
        // Store data in DB here
    }
    else
    {
        echo "Your password and confirmed password did not match.";
    }
?>
</body>
</html>
