<?php

//--------------------------DISPLAYS GALLERY-----------------------------//

//This function displays the image library in a gallery format and is called on gallery.php and gets necessary data from the database to insert into the echoed html information for the images;
//NOTE: Since the app uses PDO, the $pdo object from dbconn.php needs to be passed in each time a function on this page is called.
function displayImageGallery($pdo) {
    
    //Assigns the primary id key of logged in user from users table to match with the path in pics table:
    $user = $_SESSION['user_id']; //($_SESSION value is accessible from login.php include on gallery.php where this func is called)
    //Queries the pics table to pull the user's images data based on the path (the path is named after the primary id key of the user in the users table):
    $sql = "SELECT id, `path`, description FROM pics WHERE `path` LIKE 'uploads/$user%' ;";
    $stmt = $pdo->query($sql);

    while ($row = $stmt->fetch()) {
      $imgId = $row['id'];
      $path = $row['path'];
      $description = $row['description'];

// Echoes the html to display img, change description form and popup modal:

      echo   "<div class='wrapper col-sm-6 col-md-4 col-lg-3 mb-1 thumbnail'>

                                <div class='img_div position-relative'>

                                    <div class='chkbox_del_div position-absolute w-100 pull-right'>
                                       <input type='checkbox' class='delete_chkbox pull-right' aria-label='Close' name='deletePics[]' value=\"$imgId\">
                                    </div>

                                    <a class='img_anchor h-100' href=\"$path\" target='_blank' rel='noopener'>
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
    }
}
//---------------------------------DELETE FUNCTION (used on gallery.php)------------------------------//
//CALLED WHEN USER PRESSES DELETE BUTTON ON AN IMG (gallery.php): Note: the button html is inside the displayImageGallery() on this page (functions.php):

function deleteImg($pdo) {
     // Submitted imgId(matching with unique key in db) values collected from checked boxes on gallery.php (they are string values in an array):
     $imgIds = $_POST['imgIds'];

      // DELETING THE FILE FROM /UPLOADS Loop through the imgIds in $_POST - remove from db and delete file:
      for ($i=0; $i < count($imgIds); $i++) {

         $picId = $imgIds[$i];

         //Gets the real path for the img file from the database for the file:
         $sqlPath = 'SELECT `path` FROM pics WHERE id = ?';
         $stmt = $pdo->prepare($sqlPath);
         $stmt->execute([$picId]);
         //Path field fetched in assoc array (default method set in dbconn.php)
         while ($row = $stmt->fetch()) {
             $realPath = $row['path'];
             //Checks if the file exists and then deletes it from uploads folder:
             if (file_exists($realPath)) {
                  unlink($realPath);
              } else {
                  echo "File does not exist and could not be deleted!";
                }
          }
         //This executes the delete database entry query:
         $sql = 'DELETE FROM pics WHERE id=?';
         $stmt = $pdo->prepare($sql);
         $stmt->execute([$picId]);
        //Checks if file was deleted:
         if (!$stmt) {
             die ("Error: Could not delete image!");
         }
                          // debugging: need to unset $_post???
     } // <--for loop closing.

}// <--deleteImg() function closing.


//------------------------FILL OUT FORM FIELDS WITH USER VALUES ON REGISTRATION.PHP---------------------------//

//used if there is an error to automatically keep the legal fields filled so user can just modify the field(s) with errors.
//$fieldName corresponds to the input name:

function formFill ($fieldName) {
    //if user has submitted on registration.php, data is saved in $_POST:
    //Note: In the if-isset() conditional, you have to specify that the input field index is set in $_POST with [$fieldName] in the isset() condition,
    //or function will run and throw undefined index key variables even if $_POST is empty (empty still results in $_POST being set):
    if (isset($_POST[$fieldName])) {
      //$_POST is an array of user submitted data -- assigned to $formField;
       $formFields = $_POST;
       //Extra Sanitization of the values in $_POST (already done in registration, may not be necessary?):
       foreach ($formFields as $value) {
           htmlspecialchars($value);
       }
       //echoes the user submitted data back into the correspondinding field in the form:
       echo $formFields[$fieldName];
    }
}

//-------------------USED IN THE LOGIN FORM ON INDEX.PHP IF ENTERED PASSWORD IS INCORRECT:-----------------//

function loginFill($fieldName) {

    if (isset($_SESSION[$fieldName])) {

        $formFields = $_SESSION;

        //sanitize user submitted username (just in case-may not be necessary):
        foreach ($formFields as $value) {

            htmlspecialchars($value);
        }
        //echo the correct username into the login form field:
        echo $formFields[$fieldName];
     }
}

//--------------------NOT LOGGED IN MSG-----------------------//
//this runs if the user tries to access a page and is not logged in:

function notLoggedIn() {

    if (!$_SESSION['username']) {

      echo "<h2 class='text-danger'>Cannot access page: You are not logged in!</h2> <br>"; //(if not logged in)
      echo "<h3>Try logging in or registering.</h3> <br>";
      exit("<h1><a href='index.php'>Click Here to Login or Register</a></h1>");

    }
}

//----------LOGIN ERROR MESSAGE ON INDEX.PHP IF SUBMITTED USERNAME OR PASSWORD NOT FOUND------------//

function loginError() {

        //a flag of a space ' ' is set to $_SESSION username in login.php to indicate that user submitted username does not match any in the db:
        if ( (isset($_SESSION['username'])) && ($_SESSION['username'] === ' ') ) {
             echo "<p class='text-danger'>Username does not exist! Please enter existing username or Register.</p>";
        } else if (isset($_SESSION['username'])) {
          //if username is found in db, but password does not verify on login.php then $_SESSION username is still saved (and is not a ' '):
          echo "<p class='text-danger'>Password does not match.</p>";
          }
}

//-----------------------------Sanitize function-----------------------------//

//uses optional parameters to indicate if the string being passed is an email or the method to be used is htmlentities instead of htmlspecialchars():

//To use: sanitize_string(string); this does htmlspecialchars/strip_tags/trims on string.
//        sanitize_string(string, true); This runs email validation/sanitization filters on string.
//        sanitize_string(string, null, true); This runs htmlentities with trim on string.

function sanitize_string($str, $str_is_email = null, $htmlentities = null) {


    if ($str_is_email !== null) {
        $str     = strip_tags(trim($str));
        $str     = filter_var($str, FILTER_SANITIZE_EMAIL);
        $str     = filter_var($str, FILTER_VALIDATE_EMAIL);

       } else if ($htmlentities !== null) {

            $str = htmlentities(trim($str), ENT_QUOTES);

          } else {
               $str = htmlspecialchars(strip_tags(trim($str)));
            }

                 return $str; //return the sanitized string.

                    }

?>
