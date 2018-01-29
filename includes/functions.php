<?php
//DATABASE QUERY FUNCTIONS USED IN WEB APPLICATION:
include 'includes/dbconn.php';  //includes the database connection;

//----------------QUERY THE ANCHOR COLUMN---------------------//
function selectAnchor() {
    global $conn; //declares the $conn db connection variable as global since it is outside of function scope.
    $query = "SELECT anchor FROM pics";
    $result = mysqli_query($conn, $query);

//return error message if $result is empty:
    if (!$result) {
       die("Database Query Failed!" . mysqli_error($conn));
    }
}

//-----------QUERY ID AND ANCHOR COLUMN---------------------//
function selectIdAnchor() {
    global $conn; //declares the $conn db connection variable as global since it is outside of function scope.
    $query = "SELECT id, anchor FROM pics;";
    $result = mysqli_query($conn, $query);

//return error message if result is empty:
    if (!$result) {
       die("Database Query Failed!" . mysqli_error($conn));
    }
}

//----------QUERY THE Id, ANCHOR AND DESCRIPTION COLUMNS-----------------------//
function selectIdDescriptionAnchor() {
    global $conn; //declare the $conn db connection variable as global since it is outside of function scope.
    $query = "SELECT id, description, anchor FROM pics;";
    $result = mysqli_query($conn, $query);

//return error message if $result is empty:
    if (!$result) {
       die("Database Query Failed!" . mysqli_error($conn));
    }
}

//------------QUERY NAME, DESCRIPTION, ANCHOR (used in searchinput.php)--------------------//
function selectNameDescriptionAnchor() {
    global $conn; //declare the $conn db connection variable as global since it is outside of function scope.
    $query = "SELECT name, description, anchor FROM pics;";
    $result = mysqli_query($conn, $query);

//return error message if $result is empty:
    if (!$result) {
       die("Database Query Failed!" . mysqli_error($conn));
    }
}
//-----------------------------------------------------------//

//This function is called on gallery.php and gets necessary data from the database to echo the anchor information for the uploaded images;
function displayImageGallery() {
    global $conn; //declare the $conn db connection variable as global since it is outside of function scope.

    $query = "SELECT id, description, anchor FROM pics;";
    $result = mysqli_query($conn, $query);
//return error message if $result is empty:
    if (!$result) {
       die("Database Query Failed!" . mysqli_error($conn));
    }
//grabs anchor column (data originally inserted on upload.php in the $anchor variable) data and echoes it onto the gallery.php page (the html code that displays the image followed by a <br>);
  while ($row = mysqli_fetch_assoc($result)) {
    $imgAnchor = $row['anchor'];
    $imgId = $row['id'];

//Echoes the anchor html to display pic and change description form inside a <div> for styling:
    echo "<div class='imgContainer'>";
        echo $imgAnchor; //echoes the anchor html code stored in the database;

/*$imgAnchor echoes:
              <div class="gallery">
              <form action=deletepic.php method="POST">
                   <button type="submit" name="submit" class="deleteSubmit" value="$picNameNew"><i class="fa fa-window-close" aria-hidden="true"></i></button>
              </form>

                  <a href="$picDestination">
                  <img class="searchable" src="$picDestination" alt="$description" width="300" height="200">
                  </a>
                  <div class="desc">($description)</div>
               </div>
*/
//the following code echoes html for the Modify Description button.  It concatenates the corresponding id number of the
//image to the value property for storing in $_POST on updatepic.php - this can then be used to match the modification with the
//image id. this was included in the function to have access to the scope of $imgId;
        echo '
                  <div class="updateDesc">
                  <form action="updatepic.php" method="POST">
                            <button id="updateButton" type="submit" name="submit" value="' . $imgId . '"' . '>Change Description</button>
                        </form>
                    </div>
            </div>';
  }
}

//---------------------------------DELETE FUNCTION (used on gallery.php and searchresults.php)------------------------------//

function deleteImg() {
  //------------------------WHEN USER PRESSES DELETE BUTTON ON AN IMG (gallery.php and searchresult.php)-------------------//
             //------------CHECK IF DELETE BUTTON ISSET (ON THIS PAGE)----------------//
               global $conn;
              //This gets the unique name for the img to use for grabbing corr. path data from the db:
               $uniquePicName = $_POST['submitDelete'];
              //print_r($uniquePicName); //debugging

  //----------------------------DELETING THE FILE FROM /UPLOADS----------------------------------//
               //Gets the real path for the img file from the database for the file:
               $queryPath = "SELECT path FROM pics WHERE unique_id='$uniquePicName'";
               $picPath = mysqli_query($conn, $queryPath);
               //Gets the real path data into an array to convert it to a string:
               while ($row = mysqli_fetch_assoc($picPath)) {
                   $realPath = $row['path'];
                   //Checks if the file exists and then deletes it from uploads folder:
                   if (file_exists($realPath)) {
                        unlink($realPath);
                    } else {
                    echo "File does not exist and could not be deleted!";
                      }
                }
  //---------------------------------DELETING THE DATABASE ENTRY-----------------------------------//
               //This executes the delete database entry query and assigns it to $result:
               $queryDelete = "DELETE FROM pics WHERE unique_id='$uniquePicName'";
               $result = mysqli_query($conn, $queryDelete);

               if (!$result) {
                   die ("Error: Could not delete image!" . mysqli_error($conn));
               } else {
                   $successMsg = "Image Deleted!";
                   echo $successMsg;
                 }
}
