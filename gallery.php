<?php
include 'includes/dbconn.php'; //($conn is connection var to db)
?>
<?php
//query to the database to grab anchor column data:
$query = "SELECT anchor FROM pics";
$result = mysqli_query($conn, $query);

//return error message if $result is empty:
if (!$result) {
  die("Database Query Failed!" . mysqli_error());
}
?>

<!--User is directed to this page when they click "VIEW GALLERY" on index.php-->

<!DOCTYPE html>
<html>

  <head>
    <meta charset="utf-8">
    <title>Pic Gallery</title>
  </head>

  <body>

    <p>This is the gallery page!</p>

    <div>


    <?php
   //This code echoes the anchor column data containing html code for the image onto the page;
    while ($row = mysqli_fetch_assoc($result)) {
      //insert the html image data from anchor column into the body followed by a break;
      $imgAnchor = $row['anchor'];

      echo $imgAnchor . '<br>';
    }
    ?>

    </div>

  </body>

</html>
