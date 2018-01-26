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
//grabs anchor column data and echoes it onto the gallery.php page (the html code that displays the image followed by a <br>);
  while ($row = mysqli_fetch_assoc($result)) {
    $imgAnchor = $row['anchor'];
    $imgId = $row['id'];

    echo $imgAnchor; //echoes the anchor html code stored in the database;
    

//the following code echoes html for the Modify Description button.  It concatenates the corresponding id number of the
//image to the value property for storing in $_POST on updatepic.php - this can then be used to match the modification with the
//image id. this was included in the function to have access to the scope of $imgId;
    echo '<form action="updatepic.php" method="POST">
              <button type="submit" name="submit" value="' . $imgId . '"' . '>Change Description</button>
          </form>';


  }
}
