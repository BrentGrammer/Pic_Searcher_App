<?php include "includes/login.php"; //Enables access to $_SESSION user variables and data after user logs in.
//Note: login.php also includes the connection to the db on dbconn.php ?>
<?php ob_start(); //prevents header() errors ?>
<?php
//this includes the code that sets the variables for connecting to the database from dbh.inc.php in the includes folder
//include 'includes/dbconn.php'; not needed with login included?>
<?php //Checks if user is logged in and prevents access if not:
      if (!$_SESSION['username']) {
          echo "You are not logged in!"; //(if not logged in)
      }
?>


<?php

//the following code runs when the user hits the 'UPLOAD' submit button on gallery.php
//All of the code is inserting user submitted data into the db for pulling to search and display:
if (isset($_POST['submit'])) {
    //Assign a var to the primary user id key from $_SESSION to use as the pic path directory:
    $owner = $_SESSION['user_id'];

    //Assign variables to each piece of data in the submitted file and form arrays ($_POST and $_FILES):
    //text description input:
    $description = $_POST['description'];
    //Checks if the user did not enter a description and replaces empty string with default text:
    if ($description === "") {
      $description = "No Caption";
    }
    //variable assigned to file array (the image uploaded) in superglobal $_FILES:
    $userpic = $_FILES['userpic']; //'userpic' is the name of the file/img input in gallery.php
    //print_r($userpic); //<--used to display info in file array and check variable

    //assigning variables to each element in the $_FILES['userpic'] array:
    $picName = $userpic['name'];
    $picTmpName = $userpic['tmp_name'];
    $picSize = $userpic['size'];
    $picError = $userpic['error'];
    $picType = $userpic['type'];
    //separate the extension to convert it to lower case using explode();
    $picExt = explode('.', $picName);
    //grab the extension using end() to get last part of fileExt (the extension) and convert to lowercase using strtolower()
    $picActualExt = strtolower(end($picExt));
    //list filetypes to allow and put them in an array
    $allowed = array('jpg', 'jpeg', 'png');

//--------FOLLOWING CODE MOVES THE SUBMITTED IMAGES TO UPLOADS DIRECTORY ON THE SERVER:--------//

//check if converted file extension ($picActualExt) is in $allowed array
    if (in_array($picActualExt, $allowed)) {
      //make sure file error = 0 in the superglobal ($picError is the corr. variable):
       if ($picError === 0) {
         //then check file size in bytes:
          if ($picSize < 2000000) {
            //assign filename a unique name with uniqid function and true parameter - means true time in milliseconds-always unique
             $picNameNew = uniqid('',true).".".$picActualExt;

            //Check if the user directory exists to store image, and if not, create it:
              if (!is_dir('uploads/' . $owner)) {
                      mkdir('uploads/' . $owner);
              }
             //specify the path to store the image in and concatenate the $picNameNew(unique pic name) to it
             $picDestination = 'uploads/'  . $owner . '/' . $picNameNew;
             //Selects submitted img file from tmp location and moves it to $picDestination above with move_uploaded_file():
             move_uploaded_file($picTmpName, $picDestination);

          } else {
                echo "<h2>Your file is too big.</2>";  //if $picSize exceeds 1000000
                echo "<a href='gallery.php' class='buttonlink'>BACK TO GALLERY</a>";
                exit(); //Stops rest of script from running.
            }
        } else {
              echo "There was an error uploading."; //if $picError is not === 0
              echo "<a href='gallery.php' class='buttonlink'>BACK TO GALLERY</a>";
              exit();
          }
    } else {
          echo "You cannot upload files of this type."; //if picActualExt is not in $allowed
          echo "<a href='gallery.php' class='buttonlink'>BACK TO GALLERY</a>";
          exit(); //Stops script.
      }

//----------------END OF MOVING IMG FILES TO UPLOADS----------------------//

//---------FOLLOWING CODE INSERTS THE IMAGE AND DESCRIPTION DATA INTO THE DATABASE-----//

//$query to hold the query to insert the data into the table 'pics' is created and assigned (database connection is established by including 'includes/dbconn.php' at the top of this file)
//variables: $picName=the original name of the image uploaded, $picDestination=the folder location and name of where the image was moved to(uploads folder)
//$description=the text description the user put in the input on gallery.php, $picNameNew=the unique id generated to prevent overwriting.

    $sql = "INSERT INTO pics(name,`path`,description,unique_id) ";
    //values to be inserted into db columns are represented by the variables $(query is concatenated to follow best practices and for future editing ease):
    $sql .= "VALUES (?,?,?,?);";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([$picName,$picDestination,$description,$picNameNew]);

    //tests if the query went through:
    if ($result) {
        header('Location: gallery.php?imageupload=success');  //goes back to gallery page and updates url.
    } else {
      die ("Database failed to update!");
    }
} //<----closing curly brace for the original if isset statement.

//---------------------END OF DATABASE INSERTION OF USER DATA----------------//

?>
