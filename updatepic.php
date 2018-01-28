<?php include 'includes/dbconn.php'; ?>
<?php include 'includes/functions.php'; ?>

<?php

//Checks the submit button from gallery.php to get the img id number;
if (isset($_POST['submit'])) {
//following code assigns the id# of the image being modified from the submit value from gallery.php to a variable;
   $imgId = $_POST['submit'];
   $idNum = $imgId;  //fixed a bug where $imgId was being reassigned an empty value from $_POST['submit'] when the updateDesc button was set;
   //print_r($idNum); //debugging
  //then this grabs the current description for the id to input into the textarea for editing;
   $query = "SELECT description FROM pics WHERE id='$imgId';";
   $result = mysqli_query($conn, $query);

//this assigns the current description in the database to $currentDesc for echoing onto the update page in textarea;
   if ($result) {
       while ($row = mysqli_fetch_row($result)){
          $currentDesc = $row[0];  //fetch functions needed to get the data converted to a string (you can't just assign $currentDesc to $result);
     }
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

    <form action="updated_description.php" method="POST">
          <!--description is echoed from querying the current img desc -->
          <textarea name="newDesc"><?php echo "$currentDesc";?></textarea>
          <button type="submit" name="updateDesc" value="<?php echo $idNum ?>">UPDATE</button>
    </form>

  </body>
</html>
