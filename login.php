<?php include 'includes/header.php'; ?>

<?php

if(isset($_POST['login'])) {
    //Assign variables to the inputted data on the login form from index.php:
    $username = $_POST['username'];
    $password = $_POST['password'];
    //sanitizes the username submitted:
    $username = sanitize_string($username); //from functions.php: runs striptags/trim/htmlspecialchars.

    // $username  = strip_tags(trim($username)); //debugging not needed with sanitize_string() above
    // $username  = htmlspecialchars($username);

    //Pull data associated with $username from the database:
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    $userQuery = $stmt->execute([$username]);
    //Assigns user cell data for the column to a variable:
    while ($row = $stmt->fetch()) {
        $db_user_id = $row['user_id'];
        $db_username = $row['username'];
        $db_user_password = $row['user_password'];
        $db_user_firstname= $row['user_firstname'];
    }

    //Uses password_verify() to compare non-hashed user password to the hashed pw in the db:
    if (password_verify($password, $db_user_password)) {
          //Assigns $_SESSION variables to data from the user table in db for access in gallery.php and throughout site if password matches the database value:
          $_SESSION['user_id']   = $db_user_id;
          $_SESSION['username']  = $db_username;
          $_SESSION['password']  = $db_user_password;
          $_SESSION['firstname'] = $db_user_firstname;

          //Sends user to the gallery.php page to view their library:
          header("Location: gallery.php");
    } else {
         //If username is in db, but password incorrect, assign username to $_SESSION to fill in login form on index.php:
         if (!empty($db_username)) {
            $_SESSION['username'] = $db_username;
            $_SESSION['password'] = null;

         } else {
        //If no username match in db, then a space is used as a flag for loginError() in functions.php to echo an error msg on index.php:
           $_SESSION['username'] = ' ';
           }

          //User directed back to index.php if either pw or username is not correct.
          header("Location: index.php?loggedin=false");
      }
}//<--closing brace for if(isset($_POST['login']) statement

?>
