<?php include 'includes/dbconn.php' ?>
<?php include 'includes/functions.php' ?>


<?php  //-----------THIS RUNS WHEN THE USER CLICKS TO UPDATE DESCRIPTION ON UPDATEPIC.PHP------------//
if (isset($_POST['updateDesc'])) {

   global $conn;

   $imgId = $_POST['updateDesc'];   //this is the passed in value held in $idNum from the first isset if statement;

   $newDesc = $_POST['newDesc'];    //this is the new user description entered in the textarea;


  //Updates the database with the new description and description caption shown in gallery.php:

           $query2 = "UPDATE pics SET description='$newDesc' WHERE id=$imgId;";
           $query = "UPDATE pics
                       SET anchor = CONCAT
                       (SUBSTR(anchor, 1, LOCATE('\"desc\">', anchor)+6),
                       '($newDesc',
                       SUBSTR(anchor, LOCATE('\)<', anchor))
                       ) WHERE id=$imgId;";

           /*$query2 .= " UPDATE pics
                       SET anchor = CONCAT
                       (SUBSTR(anchor, 1, LOCATE('\"desc\">', anchor)+6),
                       '$newDesc<',
                       SUBSTR(anchor, LOCATE('/div><', anchor))
                       ) WHERE id=$imgId;";



*/

   $result = mysqli_query($conn, $query);
   print_r($result); //debugging
   echo "<br>";
   $result2 = mysqli_query($conn,$query2);
   print_r($result2); //debugging

   echo "<br>";


   //echo "<br>"; //debugging

   //check if description was updated:
   if (!$result || !$result2) {

      die ("Query Failed - Image Description not updated!" . mysqli_error($conn));
     print_r($result);
     print_r($imgId);
   } else {
           //Echoes success message and option to return to gallery;
        echo "<h1>Image Description has been updated!</h1>
        <br>

        <a href='gallery.php'>BACK TO GALLERY</a>";
     }
 }

 ?>
