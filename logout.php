<?php

require_once 'include/session.php';

// clear the session array
$_SESSION = [];

// delete cookies
setcookie(session_name(), '', time());

// destroy session
session_destroy();

// redirect to lohin page with message
header('location: /cms/login-user.php?logout=1');

exit();
