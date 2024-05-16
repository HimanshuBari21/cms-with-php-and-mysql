<?php

$headTitle = "Staff";

require_once "include/functions.php";
require_once "include/db-connection.php";

$subjectId = $_GET["subject"] ?? "";
$pageId = $_GET["page"] ?? "";

?>

<?php
include 'include/header.php'
?>


<main class="container mx-auto py-12 px-2 md:flex">

    <!-- navigation -->
    <nav class="md:w-1/4">
        <?php
        navigation($subjectId, $pageId, false)
        ?>
    </nav>

</main>

<?php include 'include/footer.php' ?>
<?php require_once 'include/close-connection.php' ?>