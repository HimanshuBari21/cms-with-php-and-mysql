<?php

session_start();

if (isset($_SESSION['id'])) {
    header("location: /cms/staff.php");
    exit();
}

$headTitle = "Login User";

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

        $namak = '$#7ub5';
        $hashedPassword = sha1($password . $namak);

        $signinQuery = "SELECT * FROM users WHERE username = '{$username}' AND hashed_password = '{$hashedPassword}'";

        $signinQueryResult = mysqli_query($connection, $signinQuery);

        if ($signinQueryResult->num_rows == 1) {

            $foundUser = mysqli_fetch_assoc($signinQueryResult);

            $_SESSION['id'] = $foundUser['id'];
            $_SESSION['username'] = $foundUser['username'];

            header("location: /cms/staff.php");
            exit();
        } else {
            $message = "Bad Credentials! Please check capslock and numlock" . mysqli_error($connection);
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
        <ul>
            <li><a class="hover:underline" href="/cms/index.php">Return to Public Page</a></li>
        </ul>
    </nav>

    <section class="md:w-3/4">
        <form action="/cms/login-user.php" method="post">
            <legend class="text-3xl font-bold">User Sign in</legend>

            <?php echo isset($message) ? "<p class='my-2'>{$message}</p>" : "" ?>
            <?php echo isset($_GET['logout']) ? "<p class='my-2'>Log out Successfully</p>" : "" ?>

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
                    <input type="submit" value="Sign in" name="submit" class="btn">
                </li>
            </ul>
        </form>
        <br>
        <p>
            Don't have Account?
            <a class="hover:underline" href="/cms/new-user.php">Sign up</a>
        </p>
    </section>

</main>

<?php include 'include/footer.php' ?>
<?php require_once 'include/close-connection.php' ?>