<?php include 'includes/dbconn.php'; ?>
<?php include 'includes/functions.php'; ?>

<?php

//Checks the submit button from index.php to get the img id number;
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

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Update Description</title>
    <!--Font Awesome from Bootstrap CDN  -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel='stylesheet' href='main.css' type='text/css' />
  </head>
    <body>
      <h1>Update Image Description</h1>




       <form action="updated_description.php" method="POST">
            <!--description is echoed from querying the current img desc -->
            <textarea name="newDesc"><?php echo $currentDesc ?></textarea>
            <button type="submit" name="updateDesc" value="<?php echo $idNum ?>">UPDATE</button>
      </form>


      <a href="gallery.php" class="buttonlink">BACK TO GALLERY</a>
    </body>
</html>
