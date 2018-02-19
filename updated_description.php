<?php ob_start(); //prevents header() redirect errors ?>
<?php session_start(); //this allows access to logged in user data in $_SESSION ?>
<?php include "includes/dbconn.php"; ?>
<?php include "includes/functions.php";
// Note: including header was not used because it added the Pic Browser text to text of the page which interfered with the update description Ajax code in scripts.js
// if .html() was used instead of .text() in the JQuery code, this may not be an issue then.
?>

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
             // The echoed text is then pulled with Ajax in scripts.js and inserted into the caption on gallery.php (the JQuery code is under 'UPDATE DESCRIPTION/CAPTION MODAL' in scripts.js)
             $_SESSION['caption'] = $newDesc;
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
