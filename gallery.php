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

                <div class="dropdown col-lg-3 col-md-4 h-100 d-inline-block">
                    <!-- Welcome msg to user from $_SESSION variable (uses firstname) -->


                    <button class="btn btn-primary btn-block dropdown-toggle w-100" type="button" id="dropdown_btn" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">ACCOUNT OPTIONS
                    </button>


                    <div class="dropdown-menu w-100" aria-labelledby="dropdown_btn">
                        <!-- LOGOUT -->
                          <form class="dropdown-item" action="includes/logout.php" method="POST">
                             <button id="btn_logout" class="btn btn-link text-center" type="submit" name="logout" onClick="return confirm_action('Log out?');">LOG OUT</button>
                          </form>
                        <!-- DELETE ACCOUNT -->
                          <form class="dropdown-item" action="delete_user.php" method="POST">
                            <button id="btn_del_account" class="btn btn-link text-danger text-center" type="submit" name="submit" onClick="return confirm_action('Delete your Account? (This will delete all photos/files and user information.)')">DELETE YOUR ACCOUNT</button>
                          </form>
                     </div>

                  </div>


            </div>
          </div>
        </nav>


            <!-- - - - - - -     IMAGE GALLERY SECTION - - - - - - - - - - -->

      <h1>Image Gallery</h1>

      <div class="container">
        <div class="row">
          <nav class='navbar-nav w-100'>
            <div class="col-md-8 d-block">
                <!-- SEARCH -->
                 <form action="?=searchresults" method="GET">
                    <div class='form-group'>
                          <button class='pull-right' name='submit' type='submit' id="searchInput">SEARCH IMAGES</button>
                            <input class='form-control d-inline w-50 pull-right' name='searchinput' type="text" placeholder="Enter Search Terms Here..." required />
                        <!-- label for makes the magnifying glass clickable and execute a search -->
                        <label for="searchInput" class='pull-right'><img src='img/search_icon.png' class='icon_search' aria-hidden='true'/></label>

                    </div>
                    <!--Displays a styled link to view full gallery if Search has been made -->
                    <?php if (isset($_GET['submit'])) {
                                  echo "<a href='gallery.php' class='buttonlink'>BACK TO GALLERY</a>";
                              }
                    ?>

                  </form>
             </div>
              <!--EDIT LIBRARY/DELETE SELECTED PICS FORM-->
             <div class='col-md-4 d-inline-block'>
                 <button type="button" id="btn_edit_library" class="btn btn-primary pull-right">EDIT LIBRARY</button>
             </div>
           </nav>
         </div>

         <div class='row mb-1'>

            <form id="form_del_pics" class='d-inline-block w-100 row' action="?=deletedpic" method="POST">

              <div class='container'>
                <div class='row'>
                   <div class="col-md-4 flex-last">
                       <label for='chkbox_select_all' id="select_all_label" class='w-100'><input id='chkbox_select_all' class='align-middle' type='checkbox' /> SELECT ALL</label>
                   </div>

                   <div class="col-md-4 flex-first">
                     <button id='btn_delete_pics' class="btn btn-danger form-control w-100" type="submit" name="deletePics">DELETE SELECTED</button>
                   </div>
                </div>
              </div>

            </form>

         </div>

            <!-- IMAGE GALLERY CONTAINER -->
                            <!--the div is given an id for JQuery to grab the checked delete chkbox selections-->
         <div id="delete-chkbox-wrapper" class="row text-center">
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
