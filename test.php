<?php include 'includes/header.php'; ?>


<div class="container">
  <div class="row">
      <!-- UPLOAD -->
      <div class="d-flex justify-content-center justify-content-md-start col-md-3">
        <a class="btn btn-primary" href="upload.php">UPLOAD</a>
      </div>

      <!-- SEARCH BAR -->
      <div class="col-md-6 text-center">
        <form  class="" action="?=searchresults" method="GET">
           <!-- SEARCH ICON -->
           <label class="" for="searchInput"><img class="" src='img/search_icon.png' class='icon_search' aria-hidden='true'/></label>
           <!-- SEARCH TXT INPUT -->
           <input id='search_text_input' type="text" class='' name='searchinput' placeholder="Search Terms" required />
           <!-- SEARCH SUBMIT BTN -->
           <button class="btn btn-primary" type='submit' name='submit' id="searchInput">SEARCH</button>
         </form>
      </div>

       <!-- BACK TO GALLERY LINK IF SEARCH SUBMIT -->
       <div class="col-md-3">
         <?php if (isset($_GET['submit'])) {
                       echo "<a href='gallery.php' class='buttonlink'>BACK TO GALLERY</a>";
                   }
         ?>
       </div>
    </div> <!-- closing row div -->

    <!-- EDIT LIBRARY -->
    <div class="row justify-content-center">
      <button type="button" id="btn_edit_library" class="btn btn-secondary">EDIT LIBRARY</button>
    </div>

</div> <!-- container closing div -->





<!-- BACKUP -->
<div class="container">


         <!-- SEARCH BAR DIV -->

<nav class="nav">

      <a class="btn btn-primary" href="upload.php">UPLOAD</a>

      <form  class="" action="?=searchresults" method="GET">


             <!-- label for makes the magnifying glass clickable and execute a search -->

             <label class="" for="searchInput"><img class="" src='img/search_icon.png' class='icon_search' aria-hidden='true'/></label>
             <input id='search_text_input' type="text" class='' name='searchinput' placeholder="Search Terms" required />

             <button class="btn btn-primary" type='submit' name='submit' id="searchInput">SEARCH</button>


         <!--Displays a styled link to view full gallery if Search has been made -->
         <?php if (isset($_GET['submit'])) {
                       echo "<a href='gallery.php' class='buttonlink'>BACK TO GALLERY</a>";
                   }
         ?>

       </form>
</nav>

        <!--EDIT LIBRARY/DELETE SELECTED PICS FORM-->
        <div class="text-center w-100">
           <button type="button" id="btn_edit_library" class="btn btn-secondary">EDIT LIBRARY</button>
        </div>

   </div>


<?php include "includes/footer.php";?>
