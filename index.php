<?php

    $headTitle = "Home";

    require_once "include/functions.php";
    require_once "include/db-connection.php";

    $subjectId = $_GET["subject"] ?? "";
    $pageId = $_GET["page"] ?? "";

?>

<?php
    include 'include/header.php'
?>


<main class="container mx-auto py-12 md:flex">
    
    <!-- navigation -->
    <nav class="w-1/4">
        <?php
            navigation($subjectId, $pageId)
        ?>
    </nav>

    <!-- content area -->
    <section class="w-3/4">
        <?php
            contentArea($subjectId, $pageId)
        ?>
    </section>

</main>

<?php include 'include/footer.php' ?>
<?php require_once 'include/close-connection.php' ?>