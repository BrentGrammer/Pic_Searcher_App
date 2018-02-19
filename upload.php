<?php include 'includes/header.php'; ?>
<?php notLoggedIn(); //From includes/functions.php: Checks if user is logged in and prevents access if not. ?>

<?php

// the following code runs when the user hits the 'UPLOAD' submit button on gallery.php

if (isset($_POST['submit'])) { //debugging set this back to submit when done testing

    // 'userpic' is the name of the file/img <input> in gallery.php
    $userpic = $_FILES['userpic'];
    // Assign a var to the primary user id key from $_SESSION to use as the pathname to move the img file to:
    $owner = $_SESSION['user_id'];
    // Assign variables to each piece of data in the submitted file and form arrays ($_POST and $_FILES):
    // text description input:

    // Note: $_FILES['userpic'] will always have 5 keys.  Count the number of items in ['name'] instead to get the number of
    // Iterate through and validate/insert the submitted upload image files and description inputs:
    // Assign variable to count() inside the parameter for better performance before running the for loop:
    for ($i = 0, $c = count($userpic['name']); $i < $c; $i++) {

      $description = $_POST['description'][$i];
      //Assigning variables to each element in the $_FILES['userpic'] array:
      $picName = $userpic['name'][$i];
      $picTmpName = $userpic['tmp_name'][$i];
      $picSize = $userpic['size'][$i];
      $picError = $userpic['error'][$i];
      $picType = $userpic['type'][$i];

      // Verifies if the file is an image file - this is a more secure PHP function to use.
      if(!exif_imagetype($picTmpName)) {
         die('The image file is invalid.  Upload a valid image file.  Note: file size limit is 20MB.');
      }

      //sanitize pic file name for echoing in error messages if errors:
      $picName     = htmlentities(trim($picName), ENT_QUOTES); //encode single/dbl quotes as well

        // TODO: allow the user to stay on upload page to correct the description:
        // Limits the length of the entered description to 255 characters:
        if (strlen($description) > 255) {
            die ("Description entered is too long.  255 characters max allowed. <br>
                   <a href='gallery.php'>GO BACK TO GALLERY PAGE</a>");
        }

        //Checks if the user did not enter a description and replaces empty string with default text:
        if ($description === "") {
          $description = "(No Caption)";
        }

        //limits the length of the image file name to 255 characters and stops script if img filename too large;
        if (strlen($picName) > 255) {
            die ("Image file name is too long.  Shorten the Image filename. <br>
                   <a href='gallery.php'>GO BACK TO GALLERY PAGE</a>");
        }

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
              if ($picSize < 5000000) {
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
                    echo "<h2>Your file($picName) is too big. Max size allowed is 20MB.</h2>";  //if $picSize exceeds 2000000
                    echo "<a href='gallery.php' class='buttonlink'>BACK TO GALLERY</a>";
                    exit(); //Stops rest of script from running.
                }
             } else {
                  echo "There was an error uploading the file: $picName."; //if $picError is not === 0
                  echo "<a href='gallery.php' class='buttonlink'>BACK TO GALLERY</a>";
                  var_dump($picError); //debugging
                  exit();
              }
         } else {
              echo "You cannot upload files of this type ($picName). Only .jpeg, .jpg, .png allowed."; //if picActualExt is not in $allowed
              echo "<a href='gallery.php' class='buttonlink'>BACK TO GALLERY</a>";
              exit(); //Stops script.
           }

    //----------------END OF MOVING IMG FILES TO UPLOADS----------------------//

    //---------FOLLOWING CODE INSERTS THE IMAGE AND DESCRIPTION DATA INTO THE DATABASE-----//

/*
*  Variable reference:
*    $picName        = the original name of the image uploaded
*    $picDestination = the folder location and name of where the image was moved to(uploads folder).
*    $description    = the text description the user put in the input on gallery.php, $picNameNew=the unique id generated to prevent
*                      overwriting.
*/
    // Sanitizes original image filename and user entered description before insertion into db:
        $picName     = htmlentities(trim($picName), ENT_QUOTES); //encode single/dbl quotes as well
        $description = htmlentities(trim($description), ENT_QUOTES);

        $sql = "INSERT INTO pics(name,`path`,description,unique_id) ";
        //values to be inserted into db columns are represented by the variables $(query is concatenated to follow best practices and for future editing ease):
        $sql .= "VALUES (?,?,?,?);";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([$picName,$picDestination,$description,$picNameNew]);

        //tests if the query went through:
        if (!$result) {
          die ("Database failed to update!");
        }

      } // <--(for loop iterating through submitted files/inputs closing)

  // Redirect user to gallery.php and display success in URL:
  header('Location: gallery.php?imageupload=success');

} /*<----closing curly brace for the original if isset statement.*/

//---------------------END OF DATABASE INSERTION OF USER DATA----------------//

?>

<!-- UPLOAD PIC FORM -->
<div class="container text-center">
  <div class="row d-flex justify-content-center">
   <div class="card">
    <div class="container">
     <div class="card-header">
       <h3>Upload Your Images: </h3>
     </div>
     <div class="card-body">
      <form action="upload.php" method="POST" enctype="multipart/form-data">
         <div class="form-group" id='form_upload_inputs'>
             <div>
               <input name='userpic[]' type='file' required>
               <!-- This is hidden to keep correct spacing when a new input is added -->
               <a style="visibility: hidden;" href='#' class='d-hidden rem_upload_input btn btn-link pull-right'>Remove</a>
             </div>
             <input class="form-control" name="description[]" type="text" size="35" placeholder="Enter Searchable Description Here...">
         </div>
         <div class="form-group">
            <button id="btn_add_upload" class="btn btn-link btn-primary form-group form-control"><i class="fa fa-plus"></i>Add Another Image</button>
            <button class='btn btn-primary form-control' name="submit" type="submit">UPLOAD IMAGES</button>
         </div>
      </form>
         <a class="btn btn-secondary" href="gallery.php" role="button">BACK TO GALLERY</a>
     </div>
    </div>
   </div>
  </div>
 </div>

<?php include 'includes/footer.php'; ?>
