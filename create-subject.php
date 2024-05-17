<?php

$headTitle = "Create Subject";

require_once "include/functions.php";
require_once "include/db-connection.php";

?>

<?php
include 'include/header.php'
?>


<main class="container mx-auto py-12 md:flex md:gap-0 gap-6 px-2">

    <!-- navigation -->
    <nav class="md:w-1/4">
        <?php
        navigation(0, 0, false)
        ?>
    </nav>

    <div>
        <?php

        $errors = [];

        $requiredFields = ['menu_name', 'position', 'visible'];

        foreach ($requiredFields as $fieldName) {
            if (!isset($_POST["$fieldName"]) || (empty($_POST["$fieldName"]) && $_POST["$fieldName"] != 0)) {
                $errors[] = $fieldName;
            }
        }

        $maxLengthFields = array('menu_name' => 30);

        foreach ($maxLengthFields as $fieldName => $value) {
            if (strlen(($_POST[$fieldName])) > $value) {
                $errors[] = $fieldName;
            }
        }

        if (empty($errors)) {
            $menuName = htmlspecialchars($_POST['menu_name']);
            $position = htmlspecialchars($_POST['position']);
            $visible = htmlspecialchars($_POST['visible']);

            $createSubjectQuery = "INSERT INTO subjects (menu_name, position, visible) VALUES ('$menuName', $position, $visible)";

            $createSubjectQueryResult = mysqli_query($connection, $createSubjectQuery);

            if ($createSubjectQueryResult) {
                echo "<p class='my-4'>Subject Added</p>";
            } else {
                echo "<p class='my-4'>Falied: " . mysqli_error($connection) . "</p>";
            }
        } else {
            echo "You has error in the following fields, please go back and correct them.";
            echo "<br />Please review the following fields";
            echo "<ul>";
            foreach ($errors as $error) {
                echo "<li>- " . $error . "</li>";
            }
            echo "</ul>";
        }

        ?>
        <br>
        <?php
        if (!empty($errors)) {
            echo "<a class='hover:underline btn' href='javascript:history.go(-1)'>Go back</a>";
        }
        ?>
        <a class='hover:underline btn' href="/cms/content.php">Home</a>
        <a class='hover:underline btn' href="/cms/new-subject.php">Add more subjects</a>

    </div>

</main>

<?php include 'include/footer.php' ?>
<?php require_once 'include/close-connection.php' ?>