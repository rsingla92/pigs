<?php
function q($query_result, $login, $pass)
{
    $c=OCILogon($login, $pass, "ug");
}
?>
