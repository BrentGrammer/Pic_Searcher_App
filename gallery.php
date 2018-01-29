<?php include 'includes/dbconn.php'; //($conn is connection var to db) ?>
<?php include 'includes/functions.php'; ?>
<?php //selectIdDescriptionAnchor(); //queries the id, description and anchor columns in database table from functions.php; ?>

<!--User is directed to this page when they click "VIEW GALLERY" on index.php-->
<!DOCTYPE html>
<html>

  <head>

      <meta charset="utf-8">
      <title>Pic Gallery</title>

      <link rel='stylesheet' href='gallerystyle.css' type='text/css' />

      <!--Font Awesome from Bootstrap CDN  -->
      <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

  </head>

  <body>

      <h1>Image Gallery</h1>

      <div id="searchBar">
        <!-- SEARCH BAR Note: GET method is better for searches in case user wants to copy URL to save the search-->
         <form action="searchinput.php" method="GET">
              <i class="fa fa-search" aria-hidden="true"></i>
              <input type="text" name='searchinput' placeholder="Enter Search Terms Here...">
              <button type='submit' name='submit'>SEARCH IMAGES</button>
         </form>
      </div>

      <div id="newUpload">
          <a href="index.php">UPLOAD ANOTHER IMAGE</a>
      </div>

      <div id="galleryWrapper">
           <?php
           /*echoes:
            <div class='imgContainer'>
                 <div class="gallery">
                     <a href="$picDestination">
                         <img class="searchable" src="$picDestination" alt="$description" width="300" height="200">
                     </a>
                     <div class="desc">
                        ($description)
                     </div>
                 </div>
                 <div class="updateDesc">
                     <form action="updatepic.php" method="POST">
                        <button id="updateButton" type="submit" name="submit" value="' . $imgId . '"' . '>Change Description</button>
                        </form>
                 </div>
        </div>;
            */

           displayImageGallery(); //Echos anchor column and form for updating description from functions.php;
          ?>
      </div>

  </body>

</html>
