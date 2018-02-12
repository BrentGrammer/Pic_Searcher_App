<?php include 'includes/header.php'; ?>

<?php
var_dump($_SESSION); //debugging
//Checks the submit button from gallery.php (from update desc form echoed by displayImageGallery() from functions.php) to get the img id number;
if (isset($_POST['submit'])) {


//following code assigns the id# of the image being modified from the submit value from gallery.php to a variable;
   $imgId = $_POST['submit'];
   $idNum = $imgId;  //fixed a bug where $imgId was being reassigned an empty value from $_POST['submit'] when the updateDesc button was set;
   //print_r($idNum); //debugging
  //then this grabs the current description for the id to input into the textarea for editing;
   $sql = "SELECT description FROM pics WHERE id=? ;";
   $stmt = $pdo->prepare($sql);
   $result = $stmt->execute([$imgId]);
//this assigns the current description in the database to $currentDesc for echoing onto the update page in textarea;
   if ($result) {
       while ($row = $stmt->fetch(PDO::FETCH_NUM)){
          $currentDesc = $row[0];  //fetch functions needed to get the data converted to a string (you can't just assign $currentDesc to $result);
     }
   }
 }


?>

<!-- Note: the id number of the image being modified is stored in $_POST['submit']; -->

<!--Update Pic Page content NOT NEEDED WITH MODAL POPUP ON INDEX?-->
      <h1>Update Image Description</h1>

       <form action="updated_description.php" method="POST">
            <!--description is echoed from querying the current img desc -->
            <textarea name="newDesc"><?php echo $currentDesc ?></textarea>
            <button type="submit" name="updateDesc" value="<?php echo $idNum ?>">UPDATE</button>
      </form>


      <a href="gallery.php" class="buttonlink">BACK TO GALLERY</a>

<?php include "includes/footer.php";?>
