<?php

require_once "include/db-connection.php";
require_once "include/functions.php";

$pageId = $_GET["page"] ?? "";

if (intval($_GET['page']) == 0) {
    header("location: /cms/content.php");
    exit();
}

$deletePageQuery = "DELETE FROM pages WHERE id = {$pageId} LIMIT 1";
$deletePageQueryResult = mysqli_query($connection, $deletePageQuery);

if ($page = getPageById($pageId)) {
    if ($deletePageQueryResult) {
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
