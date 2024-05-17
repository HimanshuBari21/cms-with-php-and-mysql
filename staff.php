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

    </nav>

    <section class="md:w-3/4">
        <legend class="font-bold text-3xl">Welcome to Staff Area</legend>
        <br>
        <ul class="ml-2">
            <li> - <a class="hover:underline" href="/cms-with-php-and-mysql/content.php">Manage Content</a></li>
            <li> - <a class="hover:underline" href="/cms-with-php-and-mysql/content.php">Add Staff User</a></li>
            <li> - <a class="hover:underline" href="/cms-with-php-and-mysql/content.php">Logout</a></li>
        </ul>
    </section>

</main>

<?php include 'include/footer.php' ?>
<?php require_once 'include/close-connection.php' ?>