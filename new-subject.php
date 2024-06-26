<?php

require_once 'include/session.php';

$headTitle = "New Subject";

require_once "include/functions.php";
require_once "include/db-connection.php";

$subjectId = $_GET["subject"] ?? "";
$pageId = $_GET["page"] ?? "";

?>

<?php
include 'include/header.php'
?>


<main class="container mx-auto py-12 md:flex md:gap-0 gap-6 px-2">

    <!-- navigation -->
    <nav class="md:w-1/4">
        <?php
        navigation($subjectId, $pageId, false)
        ?>
    </nav>

    <!-- add new subject area -->
    <section class="md:w-3/4">

        <h2 class="text-3xl">Create a new subject</h2>

        <form action="/cms/create-subject.php" method="post" class="flex flex-col gap-2 mt-6">

            <label for="menu_name">
                Subject Name:
                <input class="border border-gray-300 ml-4" type="text" name="menu_name" id="menu_name" required maxlength="30">
            </label>

            <label for="position">
                Position:
                <select class="border border-gray-300 ml-4" type="number" name="position" id="position" required>
                    <?php

                    $subjects = getSubjects();
                    $numberOfSubjects = mysqli_num_rows($subjects);

                    $i = 1;

                    do {
                        echo "<option value='{$i}'>{$i}</option>";
                        $i++;
                    } while ($i <= $numberOfSubjects + 1);

                    ?>

                </select>
            </label>

            <label for="visible">
                Visible:
                <label class="ml-4" for="true">
                    <input type="radio" name="visible" id="true" value="1" required>
                    Yes
                </label>
                <label class="ml-4" for="false">
                    <input type="radio" name="visible" id="false" value="0" required>
                    No
                </label>
            </label>

            <input type="submit" class="btn" value="Add Subject" />

        </form>

    </section>

</main>

<?php include 'include/footer.php' ?>
<?php require_once 'include/close-connection.php' ?>