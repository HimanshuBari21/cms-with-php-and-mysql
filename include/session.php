<?php

session_start();

if (!isset($_SESSION['id'])) {
    header('location: /cms/login-user.php');
    exit();
}
