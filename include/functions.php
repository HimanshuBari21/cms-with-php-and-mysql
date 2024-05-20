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
        echo "<a title='Click to edit' class='hover:underline' href='/cms/edit-subject.php/?subject={$subject['id']}'>{$subject['menu_name']}</a>";
        echo "</li>";

        // get list of pages as per subject id
        $pages = getPagesBySubjectId($subject["id"]);

        echo "<ul class='ml-4 mb-4 text-base font-normal'>";

        foreach ($pages as $page) {
            echo $selPageId == $page['id'] ? "<li class='text-blue-600'>" : "<li>";
            echo "- <a title='Click to edit' class='hover:underline' href='/cms/edit-page.php/?page={$page['id']}'>{$page['menu_name']}</a>";
            echo "</li>";
        }

        echo "</ul>";
    }

    echo "<a class='hover:underline' href='/cms/new-subject.php'>+ Add new Subject</a><br />";
    echo "<a class='hover:underline' href='/cms/logout.php'> * Log out</a>";

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
            $firstPageId = mysqli_fetch_assoc($pages)['id'] ?? [];

            $subjectLink = "<li class='!text-blue-600'><a title='Click to View' href='/cms/index.php/?subject={$subject['id']}";

            if (!empty($firstPageId)) {
                $subjectLink .= "&page=$firstPageId";
            }

            $subjectLink .= "'>{$subject['menu_name']}</a></li>";

            echo $subjectLink;

            // get list of pages as per subject id

            echo "<ul class='ml-4 mb-2 text-base font-normal'>";

            foreach ($pages as $page) {
                echo $selPageId == $page['id'] ? "<li class='text-blue-600'>" : "<li>";
                echo "- <a title='Click to View' class='hover:underline' href='/cms/index.php/?subject={$selSubjectId}&page={$page['id']}'>{$page['menu_name']}</a>";
                echo "</li>";
            }

            echo "</ul>";
        } else {
            $pages = getPagesBySubjectId($subject["id"], true);
            $firstPageId = mysqli_fetch_assoc($pages)['id'] ?? [];

            $subjectLink = "<li><a title='Click to View' href='/cms/index.php/?subject={$subject['id']}";

            if (!empty($firstPageId)) {
                $subjectLink .= "&page=$firstPageId";
            }

            $subjectLink .= "'>{$subject['menu_name']}</a></li>";

            echo $subjectLink;
        }
    }

    // echo "<a href='/cms/new-subject.php'>+ Add new Subject</a>";

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
        if (empty($page['id'])) {
            echo "<h1 class='text-4xl mb-4'>No Pages Added for this Subject</h1>";
        } else {
            contentArea($selSubjectId, 1);
        }
    } else {

        echo "Please select Subject or Page.";
    }
}
