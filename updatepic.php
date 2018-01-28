<?php include 'includes/dbconn.php'; ?>
<?php include 'includes/functions.php'; ?>

<?php

//Checks the submit button from gallery.php to get the img id number;
if (isset($_POST['submit'])) {
//following code assigns the id# of the image being modified from the submit value from gallery.php to a variable;
   $imgId = $_POST['submit'];
   $idNum = $imgId;  //fixed a bug where $imgId was being reassigned an empty value from $_POST['submit'] when the updateDesc button was set;

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

//WHEN USER PRESSES UPDATE BUTTON AFTER ENTERING NEW DESCRIPTION:
 if (isset($_POST['updateDesc'])) {

    $imgId = $_POST['updateDesc'];   //this is the passed in value held in $idNum from the first isset if statement;
    $newDesc = $_POST['newDesc'];    //this is the new user description entered in the textarea;
    //$insert = htmlspecialchars("'</div></div>'"); //used because php was not carrying over the div tags to the query(?);

   //Updates the database with the new description and description caption shown in gallery.php:

            $query2 = "UPDATE pics SET description='$newDesc' WHERE id=$imgId;";
/*       Try to figure out what went wrong in the blocked out code...check the $insert-remember to uncomment it above
            $query2 .= " UPDATE pics
                         SET anchor = CONCAT(
                         SUBSTR(anchor, 1, LOCATE(";

            $query2 .= "'" . '"' . 'desc' . '"' . '>' . "'" . ", anchor)+6)," . "'$newDesc',
                       SUBSTR(anchor, LOCATE($insert";


            $query2 .=  ", anchor))
                       )
                       WHERE id=$imgId;";

            //reassign $currDesc to the updated description:
                       $query3 = "SELECT description FROM pics WHERE id='$imgId';";
                       $result3 = mysqli_query($conn, $query3);

                    //this assigns the current description in the database to $currentDesc for echoing onto the update page in textarea;
                       if ($result3) {
                           while ($row = mysqli_fetch_row($result3)){
                              $currentDesc = $row[0];  //fetch functions needed to get the data converted to a string (you can't just assign $currentDesc to $result);
                         }
                       }
*/
    $result2 = mysqli_query($conn, $query2);
    print_r($result2); //debugging
    echo "<br>"; //debugging

    //check if description was updated:
    if (!$result2) {

       die ("Query Failed - Image Description not updated!");
      print_r($result2);
    } else {
          header("Location: updated_description.php");  //Changes header to Confirmation page (updated_description.php);

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

    <form action="" method="POST">
          <!--description is echoed from querying the current img desc -->
          <textarea name="newDesc"><?php echo "$currentDesc";?></textarea>
          <button type="submit" name="updateDesc" value="<?php echo $idNum ?>">UPDATE</button>
    </form>

  </body>
</html>
