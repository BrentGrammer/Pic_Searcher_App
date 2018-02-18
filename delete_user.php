<?php include 'includes/header.php'; ?>
<?php notLoggedIn(); //From functions.php include: Checks if user is logged in and prevents access if not. ?>

<!-- THIS CODE RUNS WHEN THE USER HITS DELETE ACCOUNT BUTTON ON GALLERY.PHP -->

<?php

//TODO create a confirm delete message here!

if (isset($_POST['submit'])) {

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
       $success_msg = "<h2>Your Account and Image Files Have Been Deleted.</h2>
                      <h2>Thanks for using Pic Browser!</h2>
                      <a class='btn btn-primary' href='index.php'>BACK TO HOME PAGE</a>";
      }
}

?>

<div class="container">
  <div class="card">
    <div class="card-body text-center">
      <?php
         if(isset($success_msg)) {

           echo $success_msg;
         }
       ?>
    </div>
  </div>
</div>

<?php include "includes/footer.php";?>
