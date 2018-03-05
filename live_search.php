<?php ob_start(); //prevents header()/redirect errors ?>
<?php session_start(); //this allows access to logged in user data in $_SESSION ?>
<?php include "includes/dbconn.php"; // functions.php and header/footer not needed for querying ?>
<?php include "includes/functions.php"; ?>

<?php
// Note: keyup value(s) from user input in search bar on gallery.php is stored in $_POST['search_input']

// Get $_POST['search_input'] and sanitize:
if (isset($_POST['search_input'])) {
  //Assigns user primary id key to match with image path for displaying on gallery.php:
  $user = $_SESSION['user_id'];
   // (Note: the user entered search input passed into $_POST is a string)
   $searchInput = $_POST['search_input'];
   // Trim and Sanitize search input (this runs striptags/htmlentities and trim on searchInput):
   $searchInput = sanitize_string($searchInput, null, true);
   //limits search string length to 255 characters:
   if (strlen($searchInput) < 256) {
        // Separate the terms by spaces into an array ($searchTerms):
        $searchTerms = explode(" ",$searchInput);
        // loop through $searchTerms to search for each in name/description fields and grabs data for echoing the matching image(s):
        foreach ($searchTerms as $i) {
          $path = "uploads/$user%"; //$user defined as $_SESSION['user_id'] at top of function.
          $search = "%$i%";
          $sql = "SELECT id, name, `path`, description FROM pics WHERE `path` LIKE ? AND (name LIKE ? OR description LIKE ?); ";
          $stmt = $pdo->prepare($sql);
          $stmt->execute([$path, $search, $search]);
        }

        if (!$stmt) {
          die("Database Query Failed!");
        } else {
             //Test if a match was found by fetching $result as an array and testing if it is null:
             // Fet
             $imgMatches = $stmt->fetchAll(); //Note: fetchAll() needed to be used with the LIKE query. fetch() doesn't work.

             if ($imgMatches == NULL) {
                echo "<div class='container d-flex justify-content-center'><h2>No Match Found</h2></div>";
             } else {
                   foreach($imgMatches as $row) {
                      $imgId = $row['id']; //pulls id to pass into update description button.
                      $path = $row['path']; //gets the path user directory from uploads/
                      $description = $row['description'];
                      //$unique_id = $row['unique_id'];

                      echo  "<div class='wrapper col-sm-6 col-md-4 col-lg-3 mb-1 thumbnail'>

                                                <div class='img_div position-relative'>

                                                    <div class='chkbox_del_div position-absolute w-100 pull-right'>
                                                       <input type='checkbox' class='delete_chkbox pull-right' aria-label='Close' name='deletePics[]' value=\"$imgId\">
                                                    </div>

                                                    <a class='img_anchor h-100' href=\"$path\" target='_blank'>
                                                       <img src=\"$path\" alt=\"$description\" class='img-fluid w-100 h-100 rounded-top'>
                                                    </a>

                                                  </div>

                                                  <div class='caption divCaption'>
                                                      <button class='desc w-100 rounded-bottom' data-toggle='modal' data-target='#updatepic_$imgId' title='Click to Change' type='button'>
                                                         <p id='caption_$imgId' class='img_caption text-center'>$description</p>
                                                      </button>
                                                  </div>
                                               </div> <!--Wrapper closing div-->

                                               <!-- UPDATE DESCRIPTION MODAL POPUP -->

                                                <div class='modal fade' id='updatepic_$imgId' role='dialogue'>
                                                    <div class='modal-dialog'>

                                                      <div class='modal-content'>
                                                         <div class='modal-header'>
                                                             <h3 class='modal-title w-100 pl-1 pull-right'>Update Description</h3>
                                                             <button type='button' class='close d-inline-block pl-0 ml-0' data-dismiss='modal'>
                                                                <span ml-0 pl-0 aria-hidden='true'>&times;</span>
                                                              </button>

                                                          </div>

                                                          <div class='modal-body'>
                                                            <form class='form_upd_caption' action='updated_description.php' method='POST'>
                                                               <div class='form-group'>
                                                                 <textarea class='newCaption form-control' name='newDesc' maxlength='255'>$description</textarea>
                                                                 <button class='btn_upd_caption form-control btn btn-primary' type='submit' name='updateDesc' value=$imgId>UPDATE</button>
                                                               </div>
                                                             </form>
                                                          </div>

                                                           <div class='modal-footer'>
                                                             <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancel</button>
                                                           </div>
                                                       </div>

                                                     </div>
                                                  </div> <!--Modal closing div-->";
                                                  
          } // foreach closing.

       } // else closing (if match is found).

     } // else closing (if db query succeeded and didn't fail)

   } // if string length < 256 closing

} // if(isset($_POST['search_input'])) closing
?>
