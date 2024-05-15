<?php

$headTitle = "Edit Subject";

require_once "include/functions.php";
require_once "include/db-connection.php";

$subjectId = $_GET["subject"] ?? "";

if (isset($_POST['submit'])) {

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
        $menuName = $_POST['menu_name'];
        $position = $_POST['position'];
        $visible = $_POST['visible'];

        $updateSubjectsQuery = "UPDATE subjects SET menu_name = '{$menuName}', position = {$position}, visible = {$visible} WHERE id = {$subjectId}";
        $updateSubjectsQueryResult = mysqli_query($connection, $updateSubjectsQuery);

        if ($updateSubjectsQueryResult) {
            // success update0
        } else {
            // query failed
        }
    } else {
        // handle error here
    }
}

?>

<?php
include 'include/header.php'
?>


<main class="container mx-auto py-12 md:flex md:gap-0 gap-6 px-2">

    <!-- navigation -->
    <nav class="md:w-1/4">
        <?php
        navigation($subjectId);
        $subject = getSubjectById($subjectId);
        ?>
    </nav>

    <!-- add new subject area -->
    <section class="md:w-3/4">

        <h2 class="text-3xl">Edit Subject: <?php echo $subject["menu_name"] ?></h2>

        <form action="/cms-with-php-and-mysql/edit-subject.php?subject=<?php echo $subjectId ?>" method="POST" class="flex flex-col gap-2 mt-6">

            <label for="menu_name">
                Subject Name:
                <input class="border border-gray-300 ml-4 px-2" type="text" name="menu_name" id="menu_name" value="<?php echo $subject["menu_name"] ?>">
            </label>

            <label for="position">
                Position:
                <select class="border border-gray-300 ml-4" type="number" name="position" id="position">
                    <?php

                    $subjects = getSubjects();
                    $numberOfSubjects = mysqli_num_rows($subjects);

                    $i = 1;

                    do {
                        if ($subject["position"] == $i) {
                            echo "<option selected value='{$i}'>{$i}</option>";
                        } else {
                            echo "<option value='{$i}'>{$i}</option>";
                        }
                        $i++;
                    } while ($i <= $numberOfSubjects + 1);

                    ?>

                </select>
            </label>

            <label for="visible">
                Visible:
                <label class="ml-4" for="true">
                    <input type="radio" name="visible" id="true" value="1" <?php echo $subject["visible"] == 1 ? 'checked' : '' ?>>
                    Yes
                </label>
                <label class="ml-4" for="false">
                    <input type="radio" name="visible" id="false" value="0" <?php echo $subject["visible"] == 1 ? '' : 'checked' ?>>
                    No
                </label>
            </label>

            <input value="Edit Subject" name="submit" type="submit"></input>

        </form>

    </section>


    <a class='hover:underline' href="/cms-with-php-and-mysql/content.php">Home</a>
    <a class='hover:underline' href="/cms-with-php-and-mysql/new-subject.php">Add more subjects</a>

</main>

<?php include 'include/footer.php' ?>
<?php require_once 'include/close-connection.php' ?>