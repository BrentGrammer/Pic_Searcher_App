<?php



//--------------------------DISPLAY GALLERY-----------------------------//

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

//Echoes the anchor html to display pic and change description form inside a <div> for styling:
      echo "<div class='wrapper col-sm-6 col-md-4 col-lg-3 mb-1 ml-0 mr-0 pl-0 pr-0 thumbnail'>

                 <div class='img_div position-relative'>

                     <div class='deletePic_btn position-absolute w-100 pull-right'>
                        <form action=\"?=deletedpic\" method=\"POST\">
                           <button type=\"submit\" name=\"submitDelete\" class='close' aria-label='Close' onClick=\"return confirm('Delete Pic?');\" value=\"$imgId\">
                              <span aria-hidden='true'>&times;</span>
                           </button>
                        </form>
                     </div>


                      <a href=\"$path\" target='_blank'>
                        <img src=\"$path\" alt=\"($description)\" class='img-fluid w-100 h-100 rounded-top'>
                      </a>


                  </div>

                  <div class='caption divCaption'>

                      <button class='desc w-100 rounded-bottom' data-toggle='modal' data-target='#updatepic_$imgId' title='Click to Change' type='button'>
                        <p class='text-center'>$description</p>
                      </button>

                   </div>
          </div>

                 <!-- UPDATE DESCRIPTION MODAL POPUP -->
                   <div class='modal fade' id='updatepic_$imgId'>
                        <div class='modal-dialog' role='document'>
                          <div class='modal-content'>
                            <div class='modal-header'>
                              <h3 class='modal-title'>Update Description</h3>
                              <button type='button' class='close' data-dismiss='modal'>
                                <span aria-hidden='true'>&times;</span>
                              </button>
                            </div>
                            <div class='modal-body'>
                              <form action='updated_description.php' method='POST'>
                                 <div class='form-group'>
                                   <textarea class='form-control' name='newDesc'>$description</textarea>
                                   <button class='form-control' type='submit' name='updateDesc' value=$imgId>UPDATE</button>
                                 </div>
                              </form>
                            </div>
                            <div class='modal-footer'>
                              <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancel</button>
                            </div>
                          </div>
                          </div>
                        </div>";
    }
}
//---------------------------------DELETE FUNCTION (used on gallery.php)------------------------------//
//CALLED WHEN USER PRESSES DELETE BUTTON ON AN IMG (gallery.php): Note: the button html is inside the displayImageGallery() on this page (functions.php):
function deleteImg($pdo) {
     //Assigns user primary id key to match with image path:
     $user = $_SESSION['user_id']; //($_SESSION value is accessed from the login.php include on gallery.php where this func is called)

     $imgId = $_POST['submitDelete'];

  //----------------------------DELETING THE FILE FROM /UPLOADS----------------------------------//
     //Gets the real path for the img file from the database for the file:
     $sqlPath = 'SELECT `path` FROM pics WHERE id=?';
     $stmt = $pdo->prepare($sqlPath);
     $stmt->execute([$imgId]);
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
     $stmt->execute([$imgId]);
    //Checks if file was deleted:
     if (!$stmt) {
         die ("Error: Could not delete image!");
     }
}
//---------------------------------SEARCH IMAGES FUNCTION--------------------------------------------------//
//Called when the user hits the Search Images button from the form on gallery.php(the button name='searchinput');
function imgSearch($pdo) {
  //Assigns user primary id key to match with image path:
  $user = $_SESSION['user_id']; //($_SESSION value is accessed from the login.php include on gallery.php where this func is called)
    //Calls the Delete Image function (from functions.php) if the user presses the delete button on the retrieved images:
    if (isset($_POST['submitDelete'])) {
            deleteImg($pdo);
    }
     //DISPLAYS SEARCH RESULTS IF SEARCH HAS BEEN INPUTTED:
    if (isset($_GET['searchinput'])) {

         //this holds the keyword(s) the user inputed to search:
         $searchInput = $_GET['searchinput'];
         //Sanitizes the user submitted search string:
         htmlentities(trim($searchInput));
         //limits search string length to 255 characters:
         if (strlen($searchInput) < 256) {
             //Explodes $searchInput by spaces to separate words and put them in an array ($searchTerms) to compare for a match in description field:
             $searchTerms = explode(" ", $searchInput);
             // loop through $searchTerms to search for each in name/description fields and grabs data for echoing the matching image(s):
             $searchArray = [];
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
                  $imgMatches = $stmt->fetchAll(); //Note: fetchAll() needed to be used with the LIKE query. fetch() doesn't work.

                  if ($imgMatches == NULL) {
                     echo "<h2>No Match Found</h2>.";
                  } else {
                        foreach($imgMatches as $row){
                           $imgId = $row['id']; //pulls id to pass into update description button.
                           $path = $row['path']; //gets the path user directory from uploads/
                           $description = $row['description'];
                           //$unique_id = $row['unique_id'];

                           echo "<div class='wrapper col-sm-6 col-md-4 col-lg-3 mb-1 ml-0 mr-0 pl-0 pr-0 thumbnail'>

                                      <div class='img_div position-relative'>

                                          <div class='deletePic_btn position-absolute w-100 pull-right'>
                                             <form action=\"?=deletedpic\" method=\"POST\">
                                                <button type=\"submit\" name=\"submitDelete\" class='close' aria-label='Close' onClick=\"return confirm('Delete Pic?');\" value=\"$imgId\">
                                                   <span aria-hidden='true'>&times;</span>
                                                </button>
                                             </form>
                                          </div>


                                           <a href=\"$path\" target='_blank'>
                                             <img src=\"$path\" alt=\"($description)\" class='img-fluid w-100 h-100 rounded-top'>
                                           </a>


                                       </div>

                                       <div class='caption divCaption'>

                                           <button class='desc w-100 rounded-bottom' data-toggle='modal' data-target='#updatepic_$imgId' title='Click to Change' type='button'>
                                             <p class='text-center'>$description</p>
                                           </button>

                                        </div>
                               </div>

                                      <!-- UPDATE DESCRIPTION MODAL POPUP -->
                                        <div class='modal fade' id='updatepic_$imgId'>
                                             <div class='modal-dialog' role='document'>
                                               <div class='modal-content'>
                                                 <div class='modal-header'>
                                                   <h3 class='modal-title'>Update Description</h3>
                                                   <button type='button' class='close' data-dismiss='modal'>
                                                     <span aria-hidden='true'>&times;</span>
                                                   </button>
                                                 </div>
                                                 <div class='modal-body'>
                                                   <form action='updated_description.php' method='POST'>
                                                      <div class='form-group'>
                                                        <textarea class='form-control' name='newDesc'>$description</textarea>
                                                        <button class='form-control btn btn-primary' type='submit' name='updateDesc' value=$imgId>UPDATE</button>
                                                      </div>
                                                   </form>
                                                 </div>
                                                 <div class='modal-footer'>
                                                   <button type='button' class='btn btn-primary' data-dismiss='modal'>Cancel</button>
                                                 </div>
                                               </div>
                                               </div>
                                             </div>";
                          }
                    }
               }
          } else {
                  Echo "<script>alert('Search string is too long! Enter a shorter search string (255 characters max).')</script>";
            }
      } //<--if(isset($_GET[])) statement closing.
} //<--imgSearch() closing.

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
             echo "Username does not exist! Please enter existing username or Register.";
        } else if (isset($_SESSION['username'])) {
          //if username is found in db, but password does not verify on login.php then $_SESSION username is still saved (and is not a ' '):
          echo "Password does not match.";
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

// upload
// registration
// login
// img search in functions.php
//
//
// $username  = strip_tags(trim($username));
// $firstname = strip_tags(trim($firstname));
// $lastname  = strip_tags(trim($lastname));
// //Prevents user entering html code that displays on the form:
// $username  = htmlspecialchars($username);
// $firstname = htmlspecialchars($firstname);
// $lastname  = htmlspecialchars($lastname);
// //trims and sanitizes email and validates with filter_var():
// $email     = strip_tags(trim($email));
// $email     = filter_var($email, FILTER_SANITIZE_EMAIL);
// $email     = filter_var($email, FILTER_VALIDATE_EMAIL);
//
// $picName     = htmlentities(trim($picName), ENT_QUOTES); //encode single/dbl quotes as well
// $description = htmlentities(trim($description), ENT_QUOTES);
//
// $newDesc = trim($newDesc);
// //Encodes html tags just in case since it will be echoed in the html code throughout the site:
// $newDesc = htmlentities($newDesc, ENT_QUOTES);





?>
