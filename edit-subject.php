<?php

require_once 'include/session.php';

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
        $menuName = htmlspecialchars($_POST['menu_name']);
        $position = htmlspecialchars($_POST['position']);
        $visible = htmlspecialchars($_POST['visible']);

        $updateSubjectsQuery = "UPDATE subjects SET menu_name = '{$menuName}', position = {$position}, visible = {$visible} WHERE id = {$subjectId}";
        $updateSubjectsQueryResult = mysqli_query($connection, $updateSubjectsQuery);

        if ($updateSubjectsQueryResult) {
            $message = "Subject Update Success";
        } else {
            $message = "Subject Update Failed";
            $message .= "<br />" . mysqli_error($connection);
        }
    } else {
        $message = "The form has " . count($errors) . " error/s in form";
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
        navigation($subjectId, 0, false);
        $subject = getSubjectById($subjectId);
        ?>
    </nav>

    <!-- add new subject area -->
    <section class="md:w-3/4">

        <h2 class="text-3xl">Edit Subject: <?php echo $subject["menu_name"] ?></h2>

        <form action="/cms/edit-subject.php?subject=<?php echo $subjectId ?>" method="POST" class="flex flex-col gap-2 mt-6">

            <?php
            if (isset($message)) {
                echo "<p class='mb-2 underline'>" . $message . "</p>";
            }
            if (!empty($errors)) {
                echo "Please review the following fields";
                echo "<ul>";
                foreach ($errors as $value) {
                    echo "<li>- {$value}</li>";
                }
                echo "</ul><br />";
            }
            ?>

            <label for="menu_name" class=" text-lg">
                Subject Name:
                <input class="border border-gray-300 ml-4 px-2" type="text" name="menu_name" id="menu_name" value="<?php echo $subject["menu_name"] ?>" required maxlength="30">
            </label>

            <label for="position" class=" text-lg">
                Position:
                <select class="border border-gray-300 ml-4" type="number" name="position" id="position" required>
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
                    } while ($i <= $numberOfSubjects);

                    ?>

                </select>
            </label>

            <label for="visible" class=" text-lg">
                Visible:
                <label class="ml-4" for="true">
                    <input type="radio" name="visible" id="true" value="1" <?php echo $subject["visible"] == 1 ? 'checked' : '' ?> required>
                    Yes
                </label>
                <label class="ml-4" for="false">
                    <input type="radio" name="visible" id="false" value="0" <?php echo $subject["visible"] == 1 ? '' : 'checked' ?> required>
                    No
                </label>
            </label>

            <br />

            <input value="Edit Subject" class="btn" name="submit" type="submit" />
            <a href="/cms/new-page.php?subject=<?php echo urlencode($subjectId) ?>" class="btn">Add Page</a>
            <a class="btn hover:!bg-red-500 border-red-500" href="/cms/delete-subject.php?subject=<?php echo urlencode($subjectId) ?>">Delete</a>

        </form>
        <br />
        <a class='hover:underline btn' href="/cms/content.php">Home</a>

    </section>



</main>

<?php include 'include/footer.php' ?>
<?php require_once 'include/close-connection.php' ?>