<?php include 'includes/header.php'; ?>

<?php notLoggedIn(); //From functions.php include: displays msg if user tries to access page and is not logged in.?>

<!-- GALLERY PAGE CONTENT-->


    <!-- NAV BAR -->

        <nav class="navbar navbar-toggleable-sm" role="navigation">
           <div class="container-fluid">
            <div class="row w-100">

                <div class="col-lg-9 col-md-8">
                  <p class="navbar-text d-1 text-muted pt-0"> <span class="navbar-brand h3 d-inline-block">Welcome <?php echo $_SESSION['firstname'] ?>!</span> <span class="d-inline-block">You can now upload images and view/search/edit your image collection.</span></p>
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



      <div class="container">

               <!-- SEARCH BAR DIV -->


               <a class="btn btn-primary col-md-3 d-inline-block" href="upload.php">UPLOAD</a>

            <form  class="d-inline-block col-md-9 text-md-left pl-0" action="?=searchresults" method="GET">


                   <!-- label for makes the magnifying glass clickable and execute a search -->
                   <label class="col-md-1" for="searchInput"><img class="" src='img/search_icon.png' class='d-inline-block icon_search' aria-hidden='true'/></label>
                   <input id='search_text_input' type="text" class='form-control d-inline-block col-10 col-md-8' name='searchinput' placeholder="Search Terms" required />

                   <button class="btn btn-primary col-md-3 d-inline-block" type='submit' name='submit' id="searchInput">SEARCH</button>


               <!--Displays a styled link to view full gallery if Search has been made -->
               <?php if (isset($_GET['submit'])) {
                             echo "<a href='gallery.php' class='buttonlink'>BACK TO GALLERY</a>";
                         }
               ?>

             </form>


              <!--EDIT LIBRARY/DELETE SELECTED PICS FORM-->
              <div class="text-center w-100">
                 <button type="button" id="btn_edit_library" class="btn btn-secondary">EDIT LIBRARY</button>
              </div>



         </div>

      <div class="container">
         <div class='row mb-2'>

            <form id="form_del_pics" class='d-inline-block w-100 row' action="?=deletedpic" method="POST">

              <div class='container'>
                <div class='row'>
                   <div class="col-md-4 flex-last align-middle ml-3">
                       <label for='chkbox_select_all' id="select_all_label" class='aling-middle pt-2 w-100'><input id='chkbox_select_all' class='align-middle' type='checkbox' /> SELECT ALL</label>
                   </div>

                   <div class="col-md-4 flex-first ml-3">
                     <button id='btn_delete_pics' class="btn btn-danger form-control w-100" type="submit" name="deletePics">DELETE SELECTED</button>
                   </div>
                </div>
              </div>

            </form>

         </div>

            <!-- IMAGE GALLERY ROW DIV (still inside top container) -->


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
