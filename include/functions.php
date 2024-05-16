<?php

function getSubjects($isPublic = false)
{

    global $connection;

    $subjectQuery = 'SELECT * FROM subjects ';

    if ($isPublic) {
        $subjectQuery .= 'WHERE visible = 1 ';
    }

    $subjectQuery .= 'ORDER BY position ASC ';

    $subjects = mysqli_query($connection, $subjectQuery);

    return $subjects;
};

function getPagesBySubjectId($subId, $isPublic = false)
{

    global $connection;

    $pagesQuery = "SELECT * FROM pages WHERE subject_id = {$subId} ";

    if ($isPublic) {
        $pagesQuery .= "AND visible = 1 ";
    }

    $pagesQuery .= "ORDER BY position ASC LIMIT 10";

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

function staffNavigation($selSubjectId = 0, $selPageId = 0)
{
    // get list of subjects
    $subjects = getSubjects();

    echo "<ul class='text-xl font-semibold'>";

    if (empty(mysqli_fetch_row($subjects))) {
        echo "<li class='py-6'>No Subjects Found - Please Add from below</li>";
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
            echo "- <a title='Click to edit' class='hover:underline' href='/cms-with-php-and-mysql/edit-page.php/?page={$page['id']}'>{$page['menu_name']}</a>";
            echo "</li>";
        }

        echo "</ul>";
    }

    echo "<a href='/cms-with-php-and-mysql/new-subject.php'>+ Add new Subject</a>";

    echo "</ul>";
}

function publicNavigation($selSubjectId = 0, $selPageId = 0)
{
    $subjects = getSubjects(true);

    echo "<ul class='text-xl font-semibold'>";

    if (empty(mysqli_fetch_row($subjects))) {
        echo "<li class='py-6'>No Subjects Found - Please Add from below</li>";
    }

    foreach ($subjects as $subject) {
        if ($selSubjectId == $subject['id']) {
            $pages = getPagesBySubjectId($subject["id"], true);

            echo "<li class='!text-blue-600'><a title='Click to View' href='/cms-with-php-and-mysql/index.php/?subject={$subject['id']}&page=" . mysqli_fetch_assoc($pages)['id'] . "'>{$subject['menu_name']}</a></li>";

            // get list of pages as per subject id

            echo "<ul class='ml-4 mb-2 text-base font-normal'>";

            foreach ($pages as $page) {
                echo $selPageId == $page['id'] ? "<li class='text-blue-600'>" : "<li>";
                echo "- <a title='Click to View' class='hover:underline' href='/cms-with-php-and-mysql/index.php/?subject={$selSubjectId}&page={$page['id']}'>{$page['menu_name']}</a>";
                echo "</li>";
            }

            echo "</ul>";
        } else {
            $pages = getPagesBySubjectId($subject["id"], true);
            echo "<li><a href='/cms-with-php-and-mysql/index.php/?subject={$subject['id']}&page=" . mysqli_fetch_assoc($pages)['id'] . "'>{$subject['menu_name']}</a></li>";
        }
    }

    // echo "<a href='/cms-with-php-and-mysql/new-subject.php'>+ Add new Subject</a>";

    echo "</ul>";
}

// intermidiater functions
function navigation($selSubjectId = 0, $selPageId = 0, $isPublic = true)
{
    $isPublic ? publicNavigation($selSubjectId, $selPageId) : staffNavigation($selSubjectId, $selPageId);
}

function contentArea($selSubjectId, $selPageId)
{

    if (!empty($selPageId)) {

        $page = getPageById($selPageId);
        echo "<h1 class='text-4xl mb-4'>" . $page["menu_name"] . "</h1>";
        echo "<p>" . $page["content"] . "</p>";
    } else if (!empty($selSubjectId)) {
        $page = mysqli_fetch_assoc(getPagesBySubjectId($selSubjectId, true));
        contentArea($selSubjectId, $page['id']);
    } else {

        echo "Please select Subject or Page.";
    }
}
