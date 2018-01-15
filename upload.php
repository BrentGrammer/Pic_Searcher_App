<?php
    //this includes the code that sets the variables for connecting to the database from dbh.inc.php in the includes folder
    include 'includes/dbconn.php';

//the following code runs when the user hits the 'UPLOAD' submit button on index.php:
    if (isset($_POST['submit'])) {
          //assign variables to each piece of data in the submitted file and form array

            //text description input:
            $description = $_POST['description']; //make a text input with this name
            //variable assigned to file array (the image uploaded) in superglobal $_FILES:
            $userpic = $_FILES['userpic']; //'userpic' is the name of the file/img input in index.php
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
                      if ($picSize < 1000000) {
                        //assign filename a unique name with uniqid function and true parameter - means true time in milliseconds-always unique
                         $picNameNew = uniqid('',true).".".$picActualExt;
                         //point to the destination to put the file starting from host root and concatenate the $picNameNew to it
                         $picDestination = 'uploads/'.$picNameNew;
                         //select the current file destination and move it to the destination made above with move_uploaded_file()
                         move_uploaded_file($picTmpName, $picDestination);
                         //go back to the index page and modify the url for succussful upload with header()
                         //header("Location: index.php?uploadsuccess");
                      } else {
                        echo "Your file is too big.";  //if $picSize exceeds 1000000
                        }
                   } else {
                     echo "There was an error uploading."; //if $picError is not === 0
                   }
                } else {
                      echo "You cannot upload files of this type."; //if picActualExt is not in $allowed
                  }
//----------------END OF MOVING IMG FILES TO UPLOADS----------------------//

//---------FOLLOWING CODE INSERTS THE IMAGE AND DESCRIPTION DATA INTO THE DATABASE-----//

//$query to hold the query to insert the data into the table 'pics' is created and assigned (database connection is established by including 'includes/dbconn.php' at the top of this file)
//variables: $picName=the original name of the image uploaded, $picDestination=the folder location and name of where the image was moved to(uploads folder)
//$description=the text description the user put in the input on index.php, $picNameNew=the unique id generated to prevent overwriting.

$query = "INSERT INTO pics(name,path,description,unique_id) ";
//values to be inserted into db columns are represented by the variables $(concatenate the query to follow best practices):
$query .= "VALUES ('$picName','$picDestination','$description','$picNameNew');";

//executes the query:
    $result = mysqli_query($conn,$query);
//tests if the query went through:
    if ($result) {
        echo "Database Updated!";
    } else {
      die ("Database failed to update!");
    }

} //closing curly brace for the original if isset statement.
?>
