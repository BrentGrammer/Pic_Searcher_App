<?php ob_start(); //allows for header function ?>
<?php include "includes/login.php"; //Enables access to $_SESSION user variables and data after user logs in. ?>
<?php include "includes/functions.php"; ?>
<?php //Sends user to index.php if login username has not been set from login.php:
      if (!$_SESSION['username']) {
          header ("Location: index.php"); //(if not logged in)
      } else {var_dump($_SESSION);} //<----debugging
?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Image Gallery</title>

    <!--Font Awesome from Bootstrap CDN  -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel='stylesheet' href='main.css' type='text/css' />

  </head>
  <body>

    <!-- UPLOAD PIC -->
  <div class = "divUploadForm">
      <form action="upload.php" method="POST" enctype="multipart/form-data">
           UPLOAD IMAGE:
              <input name="userpic" type="file" required>
              <br/>
            Enter Searchable Description:
              <input name="description" type="text"  placeholder="Enter Description Here...">
              <br/>
              <button name="submit" type="submit">UPLOAD</button>
       </form>
  </div>

      <!-- Welcome msg to user from $_SESSION variable -->
      <?php echo "Welcome " . $_SESSION['username']; ?>
      <!-- LOGOUT sends to index.php and sets a value in $_GET ['logout'] in $_GET superglobal to display logout msg on index.php ifset -->
      <form action="includes/logout.php" method="POST">
        <button type="submit" name="logout">LOG OUT</button>
      </form>


        <h1>Image Gallery</h1>


        <div id="searchBar">
          <!-- SEARCH BAR Note: GET method is better for searches in case user wants to copy URL to save the search-->
           <form action="?=searchresults" method="GET">
                <!-- label for makes the magnifying glass clickable and execute a search -->
                <label for="searchInput"><i  class="fa fa-search" aria-hidden="true"></i></label>
                <input name='searchinput' type="text" placeholder="Enter Search Terms Here..." required />
                <!--Displays a styled link to view full gallery if Search has been made -->
                <?php if (isset($_GET['submit'])) {
                              echo "<a href='gallery.php' class='buttonlink'>VIEW ALL</a>";
                          }
                ?>
                <button name='submit' type='submit' id="searchInput">SEARCH IMAGES</button>
           </form>
        </div>

        <div id="galleryWrapper">
             <?php
             //If user clicks on search button in search bar:
             if (isset($_GET['submit'])){
             imgSearch($pdo);
             }

             //------------------DISPLAYS CURRENT IMAGE LIBRARY FROM DATABASE----------------//
             //Image gallery does not display if a Search has been submitted:
             if (!isset($_GET['submit'])){

                 //Calls function to delete the image if the delete button is pressed by user:
                 if (isset($_POST['submitDelete'])) {
                   deleteImg($pdo);
                 }
                 //Calls function to display the image library onto the page ($pdo object passed in):
                  displayImageGallery($pdo); //Echos anchor html w/delete icon and form for updating description from functions.php;
                 }
              /*displayImageGallery() echoes the following onto the page:
                  <div class='imgContainer'>
                       <div class="gallery">
                           <form action="?=deletedpic" method="POST">
                                <button type="submit" name="submitDelete" class="submitDelete" value="$picNameNew"><i class="fa fa-window-close" aria-hidden="true"></i></button>
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
