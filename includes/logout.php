<?php ob_start(); ?>
<?php session_start(); //This is all you need in logout.php to grant access to $_SESSION to clear it. ?>

<!-- CODE RUNS WHEN USER HITS LOGOUT BUTTON ON GALLERY.PHP -->
<?php
//Clear the $_SESSION Variables by setting them to null (alternatively $_SESSION = array();).
$_SESSION['user_id'] = null;
$_SESSION['username'] = null;
$_SESSION['password'] = null;
$_SESSION['firstname'] = null;

//Destroys the session:
//session_destroy();
//Send the user to the index.php page:
header("Location: ../index.php?logout=success");

?>
