<?php //includes the database connection code to connect to the database:
include "includes/dbconn.php"; ?>
<?php include "includes/functions.php"; ?>

<!DOCTYPE html>

<html>
    <head>
        <!--Font Awesome from Bootstrap CDN  -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link rel='stylesheet' href='main.css' type='text/css' />

    </head>

    <body>

            <form action="upload.php" method="POST" enctype="multipart/form-data">
               UPLOAD IMAGE:
                  <input type="file" name="userpic" required>
                  <br/>
                Enter Searchable Description:
                  <input type="text" name="description" placeholder="Enter Description Here...">
                  <br/>
                  <button type="submit" name="submit">UPLOAD</button>

            </form>

            <h1>Image Gallery</h1>

            <div id="searchBar">
              <!-- SEARCH BAR Note: GET method is better for searches in case user wants to copy URL to save the search-->
               <form action="?=searchresults" method="GET">
                    <label for="searchInput"><i  class="fa fa-search" aria-hidden="true"></i></label>
                    <input type="text" name='searchinput' placeholder="Enter Search Terms Here..." required />
                    <!--Displays a styled link to view full gallery if Search has been made -->
                    <?php if (isset($_GET['submit'])) {
                                  echo "<a href='index.php' class='buttonlink'>BACK TO GALLERY</a>";
                          } ?>
                    <button type='submit' name='submit' id="searchInput">SEARCH IMAGES</button>
               </form>
            </div>

            <div id="galleryWrapper">
                 <?php

                 if (isset($_GET['submit'])){
                 imgSearch();
                 }

                 //------------------DISPLAYS CURRENT IMAGE LIBRARY FROM DATABASE----------------//
                 //Image gallery does not display if a Search has been submitted:
                 if (!isset($_GET['submit'])){

      //-------------------WHEN USER PRESSES DELETE BUTTON ON AN IMG----------------------//
                     if (isset($_POST['submitDelete'])) {
                       deleteImg();
                     }

                      displayImageGallery(); //Echos anchor column w/delete icon and form for updating description from functions.php;
                     }
                     /*displayImageGallery() echoes:
                      <div class='imgContainer'>
                           <div class="gallery">

                           <form action="?=deletedpic" method="POST">
                                <button type="submit" name="submit" class="deleteSubmit" value="$picNameNew"><i class="fa fa-window-close" aria-hidden="true"></i></button>
                           </form>

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
                ?>
            </div>
    </body>
</html>
