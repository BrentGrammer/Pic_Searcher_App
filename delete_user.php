<?php include 'includes/header.php'; ?>


<!-- THIS CODE RUNS WHEN THE USER HITS DELETE ACCOUNT BUTTON ON GALLERY.PHP -->

<?php

//TODO create a confirm delete message here!

if (isset($_POST['submit'])) {

  //TODO add confrim delete msg

    //Validate that a user is logged in before running delete process:
    if (isset($_SESSION['username'])) {
        //Get user_id value in $_SESSION to delete corr. row in users/pics table and corr. path in uploads folder:

        //Delete the row in users table based on the logged in user_id value in $_SESSION:
        $userToDelete = $_SESSION['user_id'];
        $sql  = "DELETE FROM users WHERE user_id = ? ;";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userToDelete]);
        //Checks if user has uploaded files and the directory exists:
        $delPath = "uploads/$userToDelete/";
        //Checks if the directory exists and then deletes it:
        if (file_exists($delPath)) {
            //Deletes the row in the pics table based on the stored path name (uploads/user_id):
            $userPath = "$delPath%";
            $sql = "DELETE FROM pics WHERE `path` LIKE ? ;";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$userPath]);

            //Uses glob() to gather user files into an array for deleting:
            $files = glob("$delPath*");
            //array_map() takes a function and an array.  The function is performed on each index key:
            array_map("unlink", $files);
            //Deletes the remaining empty user directory in uploads/ with rmdir()
            rmdir($delPath);
        }

        session_destroy();
        Echo "<h1>Your Account and Image Files Have Been Removed From the Server.  Thanks for using Pic Searcher App!</h1>";
        Echo "<a href='index.php'>BACK TO HOME PAGE</a>";
      }
}

?>
