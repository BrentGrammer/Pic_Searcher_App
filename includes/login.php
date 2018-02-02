<?php ob_start(); //protects against header() function errors. ?>
<?php include 'dbconn.php'; ?>
<?php session_start(); //starts session so user data can be assigned/accessed in $_SESSION superglobal. ?>

<?php

if(isset($_POST['login'])) {
    //Assign variables to the inputted data on the login form from index.php:
    $username = $_POST['username'];
    $password = $_POST['password'];
    //Pull data associated with $username from the database:
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    $userQuery = $stmt->execute([$username]);
    //Assigns cell data for the col to a variable:
    while ($row = $stmt->fetch()) {
        $db_user_id = $row['user_id'];
        $db_username = $row['username'];
        $db_user_password = $row['user_password'];
        $db_user_firstname= $row['user_firstname'];
    }
    //If username and password matches, assign session variables and go to gallery.php to display image library:
    if ($username === $db_username && $password === $db_user_password) {
          //assign $_SESSION variables to data from the user table in database for access in gallery.php and throughout site:
          $_SESSION['user_id'] = $db_user_id;
          $_SESSION['username'] = $db_username;
          $_SESSION['password'] = $db_user_password;
          $_SESSION['firstname'] = $db_user_firstname;
          //Sends user to the gallery.php page to view their library:
          header("Location: ../gallery.php");
    } else {
          header("Location: ../index.php?loggedin=false");  //goes back to index if either pw or username is not correct.
    }
}//<--closing brace for if(isset($_POST['login']) statement

?>
