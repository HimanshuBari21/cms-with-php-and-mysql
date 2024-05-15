<?php

include 'constants.env.php';

// Create connection
$connection = mysqli_connect(SERVERNAME, USERNAME, PASSWORD, DBNAME);

// Check connection
if ($connection->connect_error) {
    echo "Connection failed: " . mysqli_error($connection);
};
