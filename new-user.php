<?php

$headTitle = "User User";

require_once "include/functions.php";
require_once "include/db-connection.php";

$subjectId = $_GET["subject"] ?? "";
$pageId = $_GET["page"] ?? "";

if (isset($_POST['submit'])) {

    $username = htmlspecialchars($_POST["username"]);
    $password = $_POST["password"];

    if (!isset($username) || empty($username) || strlen($username) > 30) {

        $message = "User name is required and should  be less than 30 characters";
    } elseif (!isset($password) || empty($password) || strlen($password) > 16 || strlen($password) < 8) {

        $message = "User name is required and should be less than 16 characters and more than 16 characters";
    } else {

        $hashedPassword = sha1($password);

        $signupQuery = "INSERT INTO users (username, hashed_password) VALUES ('{$username}', '{$hashedPassword}')";

        $signupQueryResult = mysqli_query($connection, $signupQuery);

        if ($signupQueryResult) {
            $message = "<p>Sign up Success! Please <a class='underline' href='/cms/login-user.php'>Login</a><p>";
        } else {
            $message = "Sign up failed: " . mysqli_error($connection);
        }
    }
}

?>

<?php
include 'include/header.php'
?>

<main class="container mx-auto py-12 md:flex md:gap-0 px-2">

    <!-- navigation -->
    <nav class="md:w-1/4">

    </nav>

    <section class="md:w-3/4">
        <form action="/cms/new-user.php" method="post">
            <legend class="text-3xl font-bold">User Signup</legend>

            <?php echo isset($message) ? "<p class='my-2'>{$message}</p>" : "" ?>

            <br />
            <ul class="flex flex-col gap-4">

                <li>
                    <label for="username">Username: </label>
                    <input class="px-2 border border-gray-300" type="text" name="username" id="username" required maxlength="30" />
                </li>

                <li>
                    <label for="password">Password: </label>
                    <input class="px-2 border border-gray-300" type="password" name="password" id="password" required minlength="8" maxlength="16">
                </li>

                <li>
                    <input type="submit" value="Sign up" name="submit" class="btn">
                </li>
            </ul>
        </form>
        <br>
        <p>
            Already signup ?
            <a class="hover:underline" href="/cms/login.php">Login</a>
        </p>
    </section>

</main>

<?php include 'include/footer.php' ?>
<?php require_once 'include/close-connection.php' ?>