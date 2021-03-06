<?php include 'includes/header.php'; ?>
<?php notLoggedIn(); //From functions.php include: displays msg if user tries to access page and is not logged in.?>

<!-- GALLERY PAGE CONTENT-->

  <!-- NAV BAR -->
  <nav class="navbar navbar-toggleable-sm navbar-light border-bottom border-secondary" role="navigation">
    <div class="col-lg-9 col-md-8">
      <p class="navbar-text text-muted"> <span class="navbar-brand h3 d-inline-block">Welcome <?php echo $_SESSION['firstname'] ?>!</span> <span class="d-inline-block">You can now upload images and view/search/edit your image collection.</span></p>
    </div>

   <!-- ACCOUNT DROPDOWN MENU ON RIGHT - LOGOUT AND DELETE ACCOUNT -->
<!-- mb-3 h-100 d-inline-block -->
     <div class="dropdown pl-0 col-lg-3 col-md-4">
        <!-- w-100 btn-block -->
        <a class="btn btn-primary dropdown-toggle btn-block-s-only" href="#" id="dropdown_btn" data-toggle="dropdown"  aria-haspopup="true" aria-expanded="false">ACCOUNT OPTIONS
        </a>
        <!-- DROPDOWN MENU -->
        <!-- w-100 -->
        <div class="dropdown-menu" aria-labelledby="dropdown_btn">
           <!-- LOGOUT -->
           <form class="dropdown-item" action="includes/logout.php" method="POST">
             <!--  text-center -->
             <button id="btn_logout" class="btn btn-link" type="submit" name="logout" onClick="return confirm_action('Log out?');">LOG OUT</button>
           </form>
           <!-- DELETE ACCOUNT -->
           <form class="dropdown-item" action="delete_user.php" method="POST">
             <button id="btn_del_account" class="btn btn-link text-danger" type="submit" name="submit" onClick="return confirm_action('Delete your Account? (This will delete all photos/files and user information.)')">DELETE YOUR ACCOUNT</button>
           </form>
         </div>
      </div>
    </nav>

  <!-- - - - - - -     IMAGE GALLERY SECTION - - - - - - - - - - -->

  <div class="container mt-2">
    <div class="row">
        <!-- UPLOAD BUTTON --> <!-- mb-1 mx-md-auto pb-1 -->
        <div class="d-flex justify-content-center justify-content-md-start col-md-3">
          <a class="mb-md-auto mt-md-2 my-lg-auto btn btn-primary" href="upload.php">UPLOAD</a>
        </div>
        <!-- SEARCH BAR -->
        <div class="col-md-6 text-center">
          <form action="?=searchresults" method="GET">
            <div class="form-inline my-2 form-group justify-content-center">
              <!-- SEARCH TXT INPUT -->
              <input class="form-control" id='search_text_input' type="text" name='searchinput' size="35" placeholder="Search Images" />
             </div>
           </form>
        </div>

      </div> <!-- closing row div -->

      <!-- EDIT LIBRARY -->
      <div class="row d-flex justify-content-center">
        <button type="button" id="btn_edit_library" class="btn btn-secondary mb-1">EDIT LIBRARY</button>
      </div>
  </div> <!-- container closing div -->

  <!-- Select Pics and Delete (hidden until Edit Library clicked) -->
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


        //------------------DISPLAYS CURRENT IMAGE LIBRARY FROM DATABASE----------------//

           //Calls function to delete the image if the delete button is pressed by user and $_POST-imgIds is not undefined:
           if ( isset($_POST['deletePics']) && (isset($_POST['imgIds'])) ) {
             deleteImg($pdo);
           }
        ?>
        <!-- Wrapper div created to catch bubbling up of on submit event when description updated on a newly injected image
             to prevent error. -->
        <div class='container-fluid'>
          <div id="gallery_wrapper" class="row">     
            <?php  
            //Calls function to display the image library onto the page ($pdo object passed in):
               displayImageGallery($pdo); //Echos anchor html w/delete icon and form for updating description from      functions.php;
            ?>
          </div>
        </div>
      </div>

    </div>

<?php include "includes/footer.php";?>
