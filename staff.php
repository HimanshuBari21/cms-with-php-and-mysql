<?php

require_once 'include/session.php';

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
        <ul>
            <li><a class="hover:underline" href="/cms/index.php">Return to Public Page</a></li>
        </ul>
    </nav>

    <section class="md:w-3/4">
        <legend class="font-bold text-3xl">Welcome to Staff Area, <span class="text-blue-500"><?php echo $_SESSION['username'] ?></span></legend>
        <br>
        <ul class="ml-2">
            <li> - <a class="hover:underline" href="/cms/content.php">Manage Content</a></li>
            <li> - <a class="hover:underline" href="/cms/new-user.php">Add Staff User</a></li>
            <li> - <a class="hover:underline" href="/cms/logout.php">Logout</a></li>
        </ul>
    </section>

</main>

<?php include 'include/footer.php' ?>
<?php require_once 'include/close-connection.php' ?>