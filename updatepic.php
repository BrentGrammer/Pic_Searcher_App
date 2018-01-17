<?php include 'includes/dbconn.php'; ?>
<?php include 'includes/functions.php'; ?>
<?php //selectIdDescriptionAnchor(); //note: $result is not available being inside the function! from functions.php-queries the id,anchor,description columns;?>

<?php
//This if statement checks the submit button from gallery.php to get the img id number;
if (isset($_POST['submit'])) {
//following code assigns the id# of the image being modified from the submit value from gallery.php;
   $imgId = $_POST['submit'];
   $idNum = $imgId;  //this was done to fix a bug where $imgId was being reassigned an empty value from $_POST['submit'] when the updateDesc button was set;
   print_r($_POST);  //debugging
   echo "<br>"; //debugging
   print_r($idNum);  //debugging
   echo "<br>";     //debugging
   print_r($imgId);  //debugging
   echo "<br>";    //debugging
  //then this grabs the current description for the id to input into the textarea for editing;
   $query = "SELECT description FROM pics WHERE id='$imgId';";
   $result = mysqli_query($conn, $query);

   print_r($query);  //debugging
   echo "<br>";      //debugging
   print_r($result); //debugging
   echo "<br>";      //debugging

   if ($result) {
       while ($row = mysqli_fetch_row($result)){
          $currentDesc = $row[0];  //you need to use fetch functions to get the data converted to a string!  (you can't just assign $currentDesc to $result);
     }
   }
 }

//this if statement checks if the user clicked the update description button on this page(update.php) after entering a new description;
 if (isset($_POST['updateDesc'])) {

    $imgId = $_POST['updateDesc'];   //this is the passed in value held in $idNum from the first isset if statement;
    $newDesc = $_POST['newDesc']; //this is the new user description entered in the textarea;
print_r($imgId);
echo "<br>";
    print_r($_POST);  //debugging
    echo "<br>"; //debugging
    print_r($imgId);  //debugging
    echo "<br>";  //debugging
    print_r($newDesc);  //debugging
    echo "<br>";  //debugging
    $query2 = "UPDATE pics SET description='$newDesc' WHERE id='$imgId';";
    print_r($query2);  //debugging
    echo "<br>";  //debugging
    $result2 = mysqli_query($conn, $query2);
    print_r($result2);
    echo "<br>";
    //check if description was updated:
    if (!$result2) {
      die ("Query Failed - Image Description not updated!");
    } else {
          header("Location: updated_description.php");

      }
  }
?>

<!-- Note: the id number of the image being modified is stored in $_POST['submit']; -->

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Update Description</title>
  </head>
  <body>
    <h1>Update Image Description</h1>

    <form action="updatepic.php" method="POST">
          <!--description is echoed from querying the current img desc -->

          <textarea name="newDesc"><?php echo "$currentDesc"; ?></textarea>
          <button type="submit" name="updateDesc" value="<?php echo $idNum ?>">UPDATE</button>
    </form>

  </body>
</html>
