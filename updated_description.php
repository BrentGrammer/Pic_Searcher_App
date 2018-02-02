<?php include 'includes/dbconn.php' ?>
<?php include 'includes/functions.php' ?>
<?php
//-----------THIS RUNS WHEN THE USER CLICKS TO UPDATE DESCRIPTION ON UPDATEPIC.PHP------------//
if (isset($_POST['updateDesc'])) {

   $imgId = $_POST['updateDesc'];   //this is the passed in value held in $idNum from the first isset if statement from updatepic.php.;
   $newDesc = $_POST['newDesc'];    //this is the new user description entered in the textarea;
   //This updates the database with the new description and description caption shown in gallery.php:
   $sql = "UPDATE pics SET description= ? WHERE id= ? ;";
   $stmt = $pdo->prepare($sql);
   $result = $stmt->execute([$newDesc, $imgId]);
   //check if description was updated:
   if (!$result) {
      die ("Query Failed - Image Description not updated!");
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
       <a href='gallery.php' class='buttonlink'>BACK TO GALLERY</a>
   </body>
 </html>
