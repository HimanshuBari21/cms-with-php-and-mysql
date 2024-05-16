<?php

$headTitle = "New Page";

require_once "include/functions.php";
require_once "include/db-connection.php";

$subjectId = $_GET["subject"] ?? "";

if (isset($_POST['submit'])) {

    $errors = [];

    $requiredFields = ['menu_name', 'position', 'visible', 'content'];

    foreach ($requiredFields as $fieldName) {
        if (!isset($_POST["$fieldName"]) || (empty($_POST["$fieldName"]) && $_POST["$fieldName"] != 0)) {
            $errors[] = $fieldName;
        }
    }

    $maxLengthFields = array('menu_name' => 30, 'content' => 500);

    foreach ($maxLengthFields as $fieldName => $value) {
        if (strlen(($_POST[$fieldName])) > $value) {
            $errors[] = $fieldName;
        }
    }

    if (empty($errors)) {
        $menuName = htmlspecialchars($_POST['menu_name']);
        $position = htmlspecialchars($_POST['position']);
        $visible = htmlspecialchars($_POST['visible']);
        $content = htmlspecialchars($_POST['content']);

        $createPageQuery = "INSERT INTO pages (menu_name, subject_id, position, visible, content) VALUES ('{$menuName}', $subjectId, $position, $visible, '{$content}')";

        $createPageQueryResult = mysqli_query($connection, $createPageQuery);

        if ($createPageQueryResult) {
            $message = "Page Added Successfully";
        } else {
            $message = "Page Adding Failed";
            $message .= "<br />" . mysqli_error($connection);
        }
    } else {
        $message = "The form has " . count($errors) . " error/s in form";
    }
}
?>

<?php
include 'include/header.php';

?>

<main class="container mx-auto py-12 md:flex md:gap-0 gap-6 px-2">

    <!-- navigation -->
    <nav class="md:w-1/4">
        <?php
        navigation($subjectId, 0, false);
        ?>
    </nav>

    <!-- add new subject area -->
    <section class="md:w-3/4">

        <h2 class="text-3xl">New Page</h2>
        <p>For Subejct id: <?php echo $subjectId ?></p>

        <form action="/cms-with-php-and-mysql/new-page.php?subject=<?php echo $subjectId ?>" method="POST" class="flex flex-col gap-2 mt-6">

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
                Page Name:
                <input class="border border-gray-300 ml-4 px-2" type="text" name="menu_name" id="menu_name" required maxlength="30">
            </label>

            <label for="position" class=" text-lg">
                Position:
                <select class="border border-gray-300 ml-4" type="number" name="position" id="position" required>
                    <?php

                    $pages = getPagesBySubjectId($subjectId);
                    $numberOfPages = mysqli_num_rows($pages);

                    $i = 1;

                    do {
                        echo "<option value='{$i}'>{$i}</option>";
                        $i++;
                    } while ($i <= $numberOfPages);

                    ?>

                </select>
            </label>

            <label for="visible" class=" text-lg">
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

            <label for="content" class=" text-lg">
                Content:
                <br>
                <textarea class="border border-gray-300 w-full px-2" rows="5" type="text" name="content" id="content" required maxlength="500"></textarea>
            </label>

            <br />

            <input value="Add Page" class="btn" name="submit" type="submit" />

        </form>
        <br />
        <a class='hover:underline btn' href="/cms-with-php-and-mysql/content.php">Home</a>

    </section>
</main>

<!-- <?php echo $subjectId ?> -->

<?php include 'include/footer.php' ?>
<?php require_once 'include/close-connection.php' ?>