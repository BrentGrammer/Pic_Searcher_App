<?php
//This function displays the image library in a gallery format and is called on index.php and gets necessary data from the database to insert into the echoed html information for the images;
//NOTE: Since the app uses PDO, the $pdo object from dbconn.php needs to be passed in each time a function on this page is called.
function displayImageGallery($pdo) {
    $sql = "SELECT id, `path`, description, unique_id FROM pics;";
    $stmt = $pdo->query($sql);

    while ($row = $stmt->fetch()) {
      $imgId = $row['id'];
      $path = $row['path'];
      $description = $row['description'];
      $unique_id = $row['unique_id'];

//Echoes the anchor html to display pic and change description form inside a <div> for styling:
      echo "<div class='imgContainer'>

              <div class=\"gallery\">
              <form action=\"?=deletedpic\" method=\"POST\">
                   <button type=\"submit\" name=\"submitDelete\" class=\"submitDelete\" value=\"$unique_id\"><i class=\"fa fa-window-close\" aria-hidden=\"true\"></i></button>
              </form>

                  <a href=\"$path\">
                  <img class=\"searchable\" src=\"$path\" alt=\"($description)\" width=\"300\" height=\"200\">
                  </a>
                  <div class=\"desc\">$description</div>
               </div>

                  <div class=\"updateDesc\">
                  <form action=\"updatepic.php\" method=\"POST\">
                            <button id=\"updateButton\" type=\"submit\" name=\"submit\" value=\"$imgId\">Change Description</button>
                        </form>
                    </div>
            </div>";
    }
}
//---------------------------------DELETE FUNCTION (used on index.php)------------------------------//

function deleteImg($pdo) {
  //CALLED WHEN USER PRESSES DELETE BUTTON ON AN IMG (index.php)//

    //This gets the unique name for the img to use for grabbing corr. path data from the db:
     $uniquePicName = $_POST['submitDelete'];
    //print_r($uniquePicName); //debugging
  //----------------------------DELETING THE FILE FROM /UPLOADS----------------------------------//
     //Gets the real path for the img file from the database for the file:
     $sqlPath = 'SELECT `path` FROM pics WHERE unique_id=?';
     $stmt = $pdo->prepare($sqlPath);
     $stmt->execute([$uniquePicName]);
     //Path field fetched in assoc array (default method set in dbconn.php)
     while($row = $stmt->fetch()) {
         $realPath = $row['path'];
         //Checks if the file exists and then deletes it from uploads folder:
         if (file_exists($realPath)) {
              unlink($realPath);
          } else {
              echo "File does not exist and could not be deleted!";
            }
      }
     //This executes the delete database entry query:
     $sql = 'DELETE FROM pics WHERE unique_id=?';
     $stmt = $pdo->prepare($sql);
     $stmt->execute([$uniquePicName]);
    //Checks if file was deleted:
     if (!$stmt) {
         die ("Error: Could not delete image!");
     } else {
         $successMsg = "Image Deleted!";
         echo $successMsg;
       }
}
//---------------------------------SEARCH IMAGES FUNCTION--------------------------------------------------//
//Called when the user hits the Search Images button from the form on index.php(the button name='searchinput');
function imgSearch($pdo) {
    //Calls the Delete Image function (from functions.php) if the user presses the delete button on the retrieved images:
    if (isset($_POST['submitDelete'])) {
            deleteImg($pdo);
    }
     //DISPLAYS SEARCH RESULTS IF SEARCH HAS BEEN INPUTTED:
    if (isset($_GET['searchinput'])) {
         //this holds the keyword(s) the user inputed to search:
         $searchInput = $_GET['searchinput'];
         //explode $searchInput by spaces to separate words and put them in an array ($searchTerms) to compare for a match in description field:
         $searchTerms = explode(" ", $searchInput);
         // loop through $searchTerms to search for each in name/description fields and grabs data for echoing the matching image(s):
         $searchArray = [];
         foreach ($searchTerms as $i) {
           $search = "%$i%";
           $sql = "SELECT id, name, `path`, description, unique_id FROM pics WHERE name LIKE ? OR description LIKE ? ";
           $stmt = $pdo->prepare($sql);
           $stmt->execute([$search, $search]);
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
                       $path = $row['path'];
                       $description = $row['description'];
                       $unique_id = $row['unique_id'];

                       echo "<div class='imgContainer'>

                               <div class=\"gallery\">
                                 <form action=\"?=deletedpic\" method=\"POST\">
                                      <button type=\"submit\" name=\"submitDelete\" class=\"submitDelete\" value=\"$unique_id\"><i class=\"fa fa-window-close\" aria-hidden=\"true\"></i></button>
                                 </form>

                                  <a href=\"$path\">
                                     <img class=\"searchable\" src=\"$path\" alt=\"($description)\" width=\"300\" height=\"200\">
                                  </a>
                                     <div class=\"desc\">$description</div>
                                 </div>

                                  <div class=\"updateDesc\">
                                     <form action=\"updatepic.php\" method=\"POST\">
                                         <button id=\"updateButton\" type=\"submit\" name=\"submit\" value=\"$imgId\">Change Description</button>
                                     </form>
                                  </div>
                             </div>";
                      }
                }
          }
     }
}
?>
