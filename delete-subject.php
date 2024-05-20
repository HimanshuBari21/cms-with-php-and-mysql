<?php

require_once 'include/session.php';

require_once "include/db-connection.php";
require_once "include/functions.php";

$subjectId = $_GET["subject"] ?? "";

if (intval($_GET['subject']) == 0) {
    header("location: /cms/content.php");
    exit();
}

$deleteSujectQuery = "DELETE FROM subjects WHERE id = {$subjectId} LIMIT 1";
$deleteSujectQueryResult = mysqli_query($connection, $deleteSujectQuery);

if ($subject = getSubjectById($subjectId)) {
    if ($deleteSujectQueryResult) {
        echo "Record Deleted";
        header("location: /cms/content.php");
        exit();
    } else {
        // deletion failed
        echo "An error occured: <br />" . mysqli_error($connection);
        echo "<a href='/cms-withphp-and-mysql/content.php'>Go to Home</a>";
    }
} else {
    // subject didn't exist
    header("location: /cms/content.php");
    exit();
}

require_once 'include/close-connection.php';
