<?php include 'includes/dbconn.php' ?>
<?php include 'includes/functions.php' ?>
<?php
//-----------THIS RUNS WHEN THE USER CLICKS TO UPDATE DESCRIPTION ON UPDATEPIC.PHP------------//
if (isset($_POST['updateDesc'])) {

   global $conn;

   $imgId = $_POST['updateDesc'];   //this is the passed in value held in $idNum from the first isset if statement;
   $newDesc = $_POST['newDesc'];    //this is the new user description entered in the textarea;
   //This updates the database with the new description and description caption shown in gallery.php:

   $query = "UPDATE pics
               SET anchor = CONCAT
               (SUBSTR(anchor, 1, LOCATE('\"desc\">', anchor)+6),
               '($newDesc',
               SUBSTR(anchor, LOCATE('\)<', anchor))
               ) WHERE id=$imgId;";
   $query2 = "UPDATE pics SET description='$newDesc' WHERE id=$imgId;";

   $result = mysqli_query($conn, $query);
   $result2 = mysqli_query($conn,$query2);

   //check if description was updated:
   if (!$result || !$result2) {

      die ("Query Failed - Image Description not updated!" . mysqli_error($conn));
     print_r($result); //for debugging
     print_r($imgId);  //for debugging
   } else {
        //Echoes success message and option to return to gallery;
        echo "<h1>Image Description has been updated!</h1>
        <br>";
     }
 }
?>

 <!DOCTYPE html>
 <html>
   <head>
     <meta charset="utf-8">
     <title>Description Update</title>
     <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
     <link rel='stylesheet' href='main.css' type='text/css' />
   </head>
   <body>
       <a href='index.php' class='buttonlink'>BACK TO GALLERY</a>
   </body>
 </html>
