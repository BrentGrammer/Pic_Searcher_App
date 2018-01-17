<?php include 'includes/dbconn.php'; //($conn is connection var to db) ?>
<?php include 'includes/functions.php'; ?>
<?php //selectIdDescriptionAnchor(); //queries the id, description and anchor columns in database table from functions.php; ?>

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
   displayImageGallery(); //from functions.php -echos anchor column and includes form for updating description;
     ?>

    </div>

  </body>

</html>
