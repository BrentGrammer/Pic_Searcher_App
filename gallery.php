<?php include 'includes/header.php'; ?>

<?php notLoggedIn(); //From functions.php include: displays msg if user tries to access page and is not logged in.?>

<!-- GALLERY PAGE CONTENT-->
<a href="upload.php">UPLOAD IMAGES</a>

    <!-- NAV BAR -->
        <nav class="navbar navbar-toggleable-sm" role="navigation">
          <div class="container-fluid">
            <div class="row w-100">

                <div class="col-lg-9 col-md-8">
                  <p class="navbar-text d-1 text-muted"> <span class="navbar-brand h3">Welcome <?php echo $_SESSION['firstname'] ?>!</span> You can now upload images and view/search/edit your image collection.</p>
                </div>

               <!-- ACCOUNT DROPDOWN MENU ON RIGHT - LOGOUT AND DELETE ACCOUNT -->
                <div class="dropdown col-lg-3 col-md-4">
                    <!-- Welcome msg to user from $_SESSION variable (uses firstname) -->
                  <button class="btn dropdown-toggle btn-primary w-100" type="button" id="dropdown_btn" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">ACCOUNT OPTIONS
                  </button>

                    <div class="dropdown-menu w-100 text-center" aria-labelledby="dropdown_btn">
                        <!-- LOGOUT -->
                          <form class="dropdown-item w-100" action="includes/logout.php" method="POST">
                             <button id="btn_logout" class="btn btn-link" type="submit" name="logout" onClick="return confirm_action('Log out?');">LOG OUT</button>
                          </form>
                        <!-- DELETE ACCOUNT -->
                          <form class="dropdown-item w-100" action="delete_user.php" method="POST">
                            <button id="btn_del_account" class="btn btn-link text-danger" type="submit" name="submit" onClick="return confirm_action('Delete your Account?')">DELETE YOUR ACCOUNT</button>
                          </form>
                     </div>
                  </div>

            </div>
          </div>
        </nav>


            <!-- - - - - - -     IMAGE GALLERY SECTION - - - - - - - - - - -->

      <h1>Image Gallery</h1>
      <div class="container">
        <nav class="text-center">
            <div class="form-group text-center">

                <!-- SEARCH -->
                 <form action="?=searchresults" method="GET">
                    <div>
                      <!-- label for makes the magnifying glass clickable and execute a search -->
                      <label for="searchInput"><img src='img/search_icon.png' class='icon_search' aria-hidden='true'/></label>
                      <input class='form-control d-inline w-50' name='searchinput' type="text" placeholder="Enter Search Terms Here..." required />
                    </div>
                      <!--Displays a styled link to view full gallery if Search has been made -->
                      <?php if (isset($_GET['submit'])) {
                                    echo "<a href='gallery.php' class='buttonlink'>VIEW ALL</a>";
                                }
                      ?>
                      <button name='submit' type='submit' id="searchInput">SEARCH IMAGES</button>
                 </form>
              </div>


              <!--EDIT LIBRARY/DELETE SELECTED PICS FORM-->
                 <div class="edit library">
                    <button type="button" id="btn_edit_library" class="btn btn-primary">EDIT LIBRARY</button>

                    <form id="form_del_pics" action="?=deletedpic" method="POST">

                      <!-- TEST BUTTON debugging-->
                       <button id="testbtn">test</button>

                       <button id='btn_delete_pics' class="btn btn-danger form-control" type="submit" name="deletePics">DELETE SELECTED PICS</button>
                     </form>
                  </div>


            </nav>

            <!-- IMAGE GALLERY CONTAINER -->
                            <!--the div is given an id for JQuery to grab the checked delete chkbox selections-->
              <div id="delete-chkbox-wrapper" class="row">
               <?php
               //If user clicks on search button in search bar:
               if (isset($_GET['submit'])){
               imgSearch($pdo);
               }

               //------------------DISPLAYS CURRENT IMAGE LIBRARY FROM DATABASE----------------//
               //Image gallery does not display if a Search has been submitted (search uses GET method):
               if (!isset($_GET['submit'])){

                   //Calls function to delete the image if the delete button is pressed by user and $_POST-imgIds is not undefined:
                   if ( isset($_POST['deletePics']) && (isset($_POST['imgIds'])) ) {
                     deleteImg($pdo);
                   }

                   //Calls function to display the image library onto the page ($pdo object passed in):
                    displayImageGallery($pdo); //Echos anchor html w/delete icon and form for updating description from functions.php;
                   }

                 ?>
            </div>
          </div>

<?php include "includes/footer.php";?>
