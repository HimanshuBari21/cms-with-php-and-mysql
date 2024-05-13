<?php
$headTitle = "Content";

require_once "include/functions.php";
require_once "include/db-connection.php";

$subjectId = $_GET["subject"] ?? "";
$pageId = $_GET["page"] ?? "";

?>

<?php
include 'include/header.php'
?>


<main class="container mx-auto py-12 md:flex">
    
    <nav class="w-1/4">

    <?php
    
    // get list of subjects
    $subjects = getSubjects();
    
    echo "<ul class='text-xl font-semibold'>";
    
    foreach ($subjects as $subject) {
        
        echo $subjectId == $subject['id'] ? "<li class='text-blue-600'>" : "<li>";
        echo "<a class='hover:underline' href='/cms-with-php-and-mysql/content.php/?subject={$subject['id']}'>{$subject['menu_name']}</a>";
        echo "</li>";
        
        // get list of pages as per subject id
        $pages = getPagesBySubjectId($subject["id"]);
        
        echo "<ul class='ml-4 mb-4 text-base font-normal'>";
        
        foreach ($pages as $page) {
            echo $pageId == $page['id'] ? "<li class='text-blue-600'>" : "<li>";
            echo "- <a class='hover:underline' href='/cms-with-php-and-mysql/content.php/?page={$page['id']}'>{$page['menu_name']}</a>";
            echo "</li>";
        } 
        
        echo "</ul>";
    }

    echo "</ul>";

    ?>

    </nav>

    <section class="w-3/4">

    <!-- content area -->

    <h2 class="text-4xl">Content Area</h2>

    <?php


    if(!empty($subjectId)){

        $subject = getSubjectById($subjectId);

        echo "<h1>" . $subject["menu_name"] . "</h1>";
        // echo "<p>".$["id"]."</p>"
        
    }
    else if(!empty($pageId)){
        
        $page = getPageById($pageId);
        
        echo "<h1>" . $page["menu_name"] . "</h1>";
        echo "<p>" . $page["content"] . "</p>";
        
    
    }
    else{

        echo "Hey!";

    }

    ?>

    </section>

</main>

<?php include 'include/footer.php' ?>
<?php require_once('include/close-connection.php') ?>