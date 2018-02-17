<?php include 'includes/header.php'; ?>

<?php
//-----------THIS RUNS WHEN THE USER CLICKS TO UPDATE DESCRIPTION ON UPDATEPIC.PHP------------//
if (isset($_POST['newCaption'])) {
    //Checks if the user entered description is longer than 255 characters and displays error if so:
    if (strlen($_POST['newCaption']) > 255) {
        echo '<script>alert("Description entered is too long.  255 characters max allowed.")</script>';

    } else {
         $imgId = $_POST['imgIdNum'];   //from scripts.js JQuery AJAX function

         $newDesc = $_POST['newCaption'];    //this is the new user description entered in the textarea;

         // Sets description to default if user submits an empty string:
         if (strlen($newDesc) === 0) {
             $newDesc = "(No Caption)";
           }
         //Santizes user submitted description update entered on updatepic.php:
         $newDesc = trim($newDesc);
         //Encodes html tags just in case since it will be echoed in the html code throughout the site:
         $newDesc = htmlentities($newDesc, ENT_QUOTES);

         //This updates the database with the new description and description caption shown in gallery.php:
         $sql = "UPDATE pics SET description= ? WHERE id= ? ;";
         $stmt = $pdo->prepare($sql);
         $result = $stmt->execute([$newDesc, $imgId]);
         //check if description was updated:
         if (!$result) {
            die ("Query Failed - Image Description not updated!");
         } else {
             //sets the submitted decsription to SESSION to be able to echo it in the <div> on this page:
             $_SESSION['caption'] = $newDesc;
              //Echoes success message and option to return to gallery;
              //         echo "<h1>Image Description has been updated!</h1>
              // <br>";
              //header("Location: gallery.php?=descriptionUpdated");
           }
     }
}
?>

<!-- This is grabbed by Ajax/JQuery to echo the updated description onto gallery.php -->

<div id='newCaption'>
    <?php
        $newCaption = $_SESSION['caption'];
        echo $newCaption;
    ?>

</div>


<?php include "includes/footer.php";?>
