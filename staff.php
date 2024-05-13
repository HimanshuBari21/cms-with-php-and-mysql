<?php
$headTitle = "Staff"
?>

<?php require_once("include/db-connection.php"); ?>

<!DOCTYPE html>
<html lang="en">
    
    <?php include "include/head.php"; ?>
    
<body>

    <?php
    include 'include/header.php'
    ?>


    <main class="container mx-auto py-12">
    
    <?php

    $result = mysqli_query($connection, 'SELECT * FROM subjects WHERE visible = 1 ORDER BY position ASC LIMIT 10');

    foreach ($result as $key => $value) {
        echo "<p>" . $value['menu_name'] . " - " . $value['position'] . "</p>";
    }

    ?>

    </main>

    <?php
    include 'include/footer.php'
    ?>

</body>

</html>

<?php require_once('include/close-connection.php') ?>