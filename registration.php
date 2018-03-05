<?php include 'includes/header.php'; ?>

<?php
//Table 'users' structure is: user_id, username, user_password, user_firstname, user_lastname, user_email, user_role, randSalt.
if (isset($_POST['submit'])) {
  //Assigns variables to user submitted registration data:
  $username  = $_POST['username'];
  $firstname = $_POST['firstname'];
  $lastname  = $_POST['lastname'];
  $password  = $_POST['password'];
  $email     = $_POST['email'];

//BACK END SANITIZATION AND VALIDATION FOR USER SUBMITTED REGISTRATION DATA:

  //Sanitizes user data (except password) to eliminate whitespace at either end and remove html/php tags:
  //$username  = strip_tags(trim($username));
  $username  =  sanitize_string($username);
  $firstname =  sanitize_string($firstname);
  $lastname  =  sanitize_string($lastname);
  $email     =  sanitize_string($email, true); //this runs the built-in php email filters which validate and sanitize emails.

//This reassigns the sanitized user input to $_POST for keeping it filled out in the form fields if one field has an error:
  $_POST['username']  = $username;
  $_POST['firstname'] = $firstname;
  $_POST['lastname']  = $lastname;
  $_POST['password']  = $password;
  $_POST['email']     = $email;

    //This double-checks if the $_POST data is empty (HTML5 required attribute tags are also in the form):
    if ( !empty($username) && !empty($firstname) && !empty($lastname) && !empty($password) && !empty($email) ) {

        //Checks if username or user email is taken and prevents registration if they are in the db already:
        //Grabs username and email fields:
        $stmt = $pdo->query("SELECT username, user_email FROM users");
        //Creates an array to store usernames and emails to check for matches:
        $dbUsers = array();
        //Assembles username and email data into the array:
        while ($row = $stmt->fetch()) {
            $dbUsers[] = $row;
        }

        //Separates results in 'username' and 'user_email' indexes to into separate arrays for checking:
        $dbUsernames = array_column($dbUsers, 'username');
        $dbEmails = array_column($dbUsers, 'user_email');

                //Checks each array of user inputted registration data against db data for username/email match:
                if ( in_array($username, $dbUsernames) ) {
                    //Assigns message to echo if username match found:
                    $usernameErr = "<p class='text-danger'>REGISTRATION FAILED: Username taken.  Please enter a unique username.</p>";
                    $usernameTaken = 1; //Sets a flag is username matched.
                } else {
                      $usernameTaken = 0;
                  }

                if ( in_array($email, $dbEmails) ) {
                    //Assigns message to echo if email match found:
                    $emailErr = "<p class='text-danger'>REGISTRATION FAILED: Email already registered.  Please enter a different Email.</p>";
                    $emailTaken = 1;  //Sets a flag if email is matched.

                } else {
                      $emailTaken = 0;
                  }

        //If no match for username or email was found in the db, then code proceeds with registering the new user:
        if (!$usernameTaken && !$emailTaken) {
            //Prepare and encrypt for db insertion:

           //Alternative simpler method using the password_hash() function and Blowfish algorithm passed in:
           $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12) );
           //(If this method is used, then the $salt and crypt() function is not needed) //debugging

            $sql = "INSERT INTO users (username, user_password, user_firstname, user_lastname, user_email) ";
            $sql .= "VALUES (:username, :password, :firstname, :lastname, :email);";
            $stmt = $pdo->prepare($sql);
            $insertNewUser = $stmt->execute(['username'=>$username,'password'=>$password,'firstname'=>$firstname,'lastname'=>$lastname,'email'=>$email]);

               //error msg if Query fails:
               if (!$insertNewUser) {
                   die("Query Failed!");
                   $message = "Registration Failed!";
               } else {
                //If registration data was inserted into the DB:
                //pull the inserted data from the DB and assign it to $_SESSION variables to send the user logged in to the gallery page:
                     $sql = "SELECT * FROM users WHERE username = ?";
                     $stmt = $pdo->prepare($sql);
                     $userQuery = $stmt->execute([$username]); //($username should be the sanitized version from the registration form now)
                     //Assigns user data from db to $_SESSION for use on gallery.php redirect:
                     while ($row = $stmt->fetch()) {
                         $db_user_id = $row['user_id'];
                         $db_username = $row['username'];
                         $db_user_password = $row['user_password'];
                         $db_user_firstname= $row['user_firstname'];
                     }
                     //Assign session values to log the user in and send to the gallery page:
                     $_SESSION['user_id'] = $db_user_id;
                     $_SESSION['username'] = $db_username;
                     $_SESSION['password'] = $db_user_password;
                     $_SESSION['firstname'] = $db_user_firstname;

                     unset($_POST); //This clears the user input from $_POST if the registration completes to the DB; Done just in case for security of the info (necessary?)

                     header("Location: gallery.php");
               }
     }//<---if (!$usernameTaken && !$emailTaken) closing.
   } else { //if fields are empty:
           echo "<script>alert('Please fill out all fields!')</script>";
     }
} //<--if(isset($_POST['submit'])) closing (first if statement).

?>

<!-- Registration Page Content -->
      <div class="container">
        <div class="row d-flex justify-content-center">
          <h2>REGISTER</h2>                 
        </div>
        <!-- username or email taken msg displays if duplicate found in db: -->
        <div class="text-center">
                       
             <?php if (isset($usernameErr)) {
                echo $usernameErr;
              }
              if (isset($emailErr)) {
                echo $emailErr;
              }
             ?>
        </div>
        <!-- Register Form -->
        <div class="row d-flex justify-content-center">
          <form class="form-group" action="registration.php" method="POST">
            <div class="form-group">
              <label class='d-inline-block w-100'>Create Username: </label> <input class="form-control" type="text" name="username" maxlength="30" size="25" placeholder="Enter desired username..." value="<?php formFill('username'); ?>" required>
            </div>
            <div class="form-group">
              <label class='d-inline-block w-100'>First Name: </label> <input class="form-control" type="text" name="firstname" maxlength="30" size="25" placeholder="Enter Firstname..." value="<?php formFill('firstname'); ?>" required>
            </div>
            <div class="form-group">
              <label class='d-inline-block w-100'>Last Name: </label> <input class="form-control" type="text" name="lastname" maxlength="50" size="25" placeholder="Enter Lastname..." value="<?php formFill('lastname'); ?>" required>
            </div>
            <div class="form-group">
              <label class='d-inline-block w-100'>Create Password: </label> <input class="form-control" type="password" name="password" minlength="5" size="25" maxlength="30" placeholder="Enter desired password..." value="<?php formFill('password'); ?>" required>
            </div>
            <div class="form-group">
              <label class='d-inline-block w-100'>Email: </label> <input class="form-control" type="email" name="email" size="25" maxlength="50" placeholder="Enter your Email Address..." value="<?php formFill('email'); ?>" required>
            </div>
            <button class="btn btn-primary form-control" type="submit" name="submit">REGISTER</button>
        </div>

        <div class="row d-flex justify-content-center">
           <!-- optional link back to home login page (index.php): -->
           <a class="btn btn-danger" href='index.php'>GO BACK TO THE HOME PAGE</a>
        </div>
          <?php
             //Registration Error Message displays if db insertion fails:
              if (isset($message)) {
                  echo $message;
                  //displays link to login page ($message is set only after the registration process runs):
                  echo "<a href='index.php'>GO BACK TO THE HOME PAGE</a>";
                }
          ?>
      </form>
  </div>

<?php include "includes/footer.php";?>
