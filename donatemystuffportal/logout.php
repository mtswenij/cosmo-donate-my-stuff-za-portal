<?php

session_start();

// Unset all of the session variables.
$_SESSION = array();

//Finally, destroy the session.
session_destroy();

echo "<p>Logout Successful <a href=login.php>Click Here</a> to login</p>";
die();

?>