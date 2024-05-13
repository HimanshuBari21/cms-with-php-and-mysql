<?php 

function getSubjects() {

    global $connection;

    $subjectQuery = 'SELECT * FROM subjects 
    WHERE visible = 1
    ORDER BY position ASC LIMIT 10';
    
    $subjects = mysqli_query($connection, $subjectQuery);

    return $subjects;

};

function getPagesBySubjectId($subId) {

    global $connection;
   
     $pagesQuery = "SELECT * FROM pages 
     WHERE visible = 1 
     AND subject_id = {$subId}
     ORDER BY position 
     ASC LIMIT 10";

     $pages = mysqli_query($connection, $pagesQuery);

     return $pages;

};

function getSubjectById($id) {

    global $connection;

    $subjectQuery = "SELECT * 
    FROM subjects 
    WHERE id = {$id}";
    $subject = mysqli_query($connection, $subjectQuery);

    return mysqli_fetch_assoc($subject);

}

function getPageById($id) {

    global $connection;

    $pageQuery = "SELECT * 
    FROM pages 
    WHERE id = {$id}";
    $page = mysqli_query($connection, $pageQuery);

    return mysqli_fetch_assoc($page);

}


?>