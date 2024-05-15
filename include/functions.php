<?php

function getSubjects()
{

    global $connection;

    $subjectQuery = 'SELECT * FROM subjects 
    ORDER BY position ASC';

    $subjects = mysqli_query($connection, $subjectQuery);

    return $subjects;
};

function getPagesBySubjectId($subId)
{

    global $connection;

    $pagesQuery = "SELECT * FROM pages 
     WHERE visible = 1 
     AND subject_id = {$subId}
     ORDER BY position 
     ASC LIMIT 10";

    $pages = mysqli_query($connection, $pagesQuery);

    return $pages;
};

function getSubjectById($id)
{

    global $connection;

    $subjectQuery = "SELECT * FROM subjects WHERE id = {$id}";
    $subject = mysqli_query($connection, $subjectQuery);

    return mysqli_fetch_assoc($subject);
}

function getPageById($id)
{

    global $connection;

    $pageQuery = "SELECT * 
    FROM pages 
    WHERE id = {$id}";
    $page = mysqli_query($connection, $pageQuery);

    return mysqli_fetch_assoc($page);
}

function navigation($selSubjectId = 0, $selPageId = 0)
{
    // get list of subjects
    $subjects = getSubjects();

    echo "<ul class='text-xl font-semibold'>";

    if (empty(mysqli_fetch_row($subjects))) {
        echo "<li class='py-6'>No Subjects</li>";
    }

    foreach ($subjects as $subject) {

        echo $selSubjectId == $subject['id'] ? "<li class='text-blue-600'>" : "<li>";
        echo "<a title='Click to edit' class='hover:underline' href='/cms-with-php-and-mysql/edit-subject.php/?subject={$subject['id']}'>{$subject['menu_name']}</a>";
        echo "</li>";

        // get list of pages as per subject id
        $pages = getPagesBySubjectId($subject["id"]);

        echo "<ul class='ml-4 mb-4 text-base font-normal'>";

        foreach ($pages as $page) {
            echo $selPageId == $page['id'] ? "<li class='text-blue-600'>" : "<li>";
            echo "- <a title='Click to edit' class='hover:underline' href='/cms-with-php-and-mysql/content.php/?page={$page['id']}'>{$page['menu_name']}</a>";
            echo "</li>";
        }

        echo "</ul>";
    }

    echo "<a href='/cms-with-php-and-mysql/new-subject.php'>+ Add new Subject</a>";

    echo "</ul>";
}

function contentArea($selSubjectId, $selPageId)
{

    if (!empty($selSubjectId)) {

        $subject = getSubjectById($selSubjectId);

        echo "<h1 class='text-4xl mb-4'>" . $subject["menu_name"] . "</h1>";
    } else if (!empty($selPageId)) {

        $page = getPageById($selPageId);

        echo "<h1 class='text-4xl mb-4'>" . $page["menu_name"] . "</h1>";
        echo "<p>" . $page["content"] . "</p>";
    } else {

        echo "Please select Subject or Page.";
    }
}
