<?php
$headTitle = "Home";

require_once "include/functions.php";
require_once "include/db-connection.php";
?>

<?php
include 'include/header.php'
?>


<main class="container mx-auto py-12 flex">
    
    <nav class="w-1/3">

    <?php

    // list of subjects
    $subjectQuery = 'SELECT * FROM subjects 
    WHERE visible = 1
    ORDER BY position ASC LIMIT 10';
    
    // get list of subjects
    $subjects = getSubjects();
    
    echo "<ul class='text-xl'>";
    
    foreach ($subjects as $subject) {
        
        echo "<li class='mt-4'><a class='hover:underline' href='content.php/?subject={$subject['id']}'>{$subject['menu_name']}</a></li>";
        
        // get list of pages as per subject id
        $pages = getPagesBySubjectId($subject["id"]);
        
        echo "<ul class='ml-4 text-base'>";
        
        foreach ($pages as $page) {
            echo "<li>- <a class='hover:underline' href='content.php/?page={$page['id']}'>{$page['menu_name']}</a></li>";
        } 
        
        echo "</ul>";
    }

    echo "</ul>";

    ?>

    </nav>

    <section class="w-3/4">



    </section>

</main>

<?php include 'include/footer.php' ?>
<?php require_once('include/close-connection.php') ?>