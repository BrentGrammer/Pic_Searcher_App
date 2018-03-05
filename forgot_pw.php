<?php include 'includes/header.php'; ?>
<?php require './vendor/autoload.php'; ?>
<?php use PHPMailer\PHPMailer\PHPMailer; ?>
<?php //require './classes/Config.php'; no longer neeeded with "autoload" in composer.json ?>


<?php


// Check if the user has clicked on forgot pw link on index.php:
// Also checks if the user is logged in (does not need to be on page then)
if(!isset($_GET['forgot']) || isset($_SESSION['username'])) {
   header('Location: index.php');
}

// Check if post is set from user clicking reset pw submit and assign user submitted email to variable:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['email'])) {

        $email = $_POST['email'];

      } else {
        echo "Please enter an email address.";
      }

    // (Sanitize and validate email here:
    $email = sanitize_string($email, true);

     // Check if user email exists in db:
     $sql = "SELECT username,user_email FROM users WHERE user_email = ?";
     $stmt = $pdo->prepare($sql);
     $result = $stmt->execute([$email]);

     if(!$result) {

        die('Query Failed!');
     }
     // assign var to username to put in email:
     while ($row = $stmt->fetch()) {
       $username = $row['username'];
     }
     // Check if num of rows returned in 0 (no match for email in db):
     // (Note: this is a method of the pdo $stmt object)
     $count = $stmt->rowcount();
     // set to check for error:
     $email_exists = false;
     // If email is found in db, then set $email_exists to true:
     if($count > 0) {
        $email_exists = true;
     }

     // If user_email is in db, then insert a randomized token string into token column and send the email:
     if ($email_exists == true) {

       // Set up a token to put into the db:
       $length = 50;
       // Create randomized token key to enter into the db:
       $token = bin2hex(openssl_random_pseudo_bytes($length));

       $sql = 'UPDATE users SET token=? WHERE user_email=?';
       $stmt = $pdo->prepare($sql);
       $result = $stmt->execute([$token,$email]);

       // For the demo, using PHP mail() builtin function instead of PHPMailer:

       // Strip \r\n and commas to prevent email header injection and spamming with multiple emails:
       $search = array('\r','\n',',');
       $email = str_replace($search,'',$email);

      $to      = $email; // $email has been sanitized and validated above with commas and \r\n stripped
      $subject = "Forgot Password Reset";
         
      // NOTE: For the online version, localhost/picBrowserDemo has to be changed to www.brentmarquez/PicBrowser:
      $message = '<h1>Here is the information to reset your Pic Browser password</h1>  (If you did not expect this email, then disregard it.)<br>
                  Click this link to reset your password: \r\n
                  <a href="http://localhost/PicBrowserDemo/reset_pw.php?email='.$email.'&token='.$token.' ">http://localhost/picsearcher/reset.php?email='.$email.'&token='.$token.'</a>
                  Your username is: ' .$username;

      // use wordwrap() if lines are longer than 70 characters
      $message = wordwrap($message,70);
      // This allows for HTML content:
      $headers = "MIME-Version: 1.0" . "\r\n";
      $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
      $headers .= "From: resetpassword@brentmarquez.com";


      mail($to, $subject, $message, $headers);




// ----------------------- PHP MAILER CODE --------------------------------- //
       //      // **** CONFIGURE PHPMAILER **** //
       //
       // // instantiate the PHPMailer class to access props and methods:
       // $mail = new PHPMailer;
       //
       //      //Server settings: these settings use the const defined in classes/Config.php:
       //      // NOTE: The email is currently sent to mailtrap.io demo inbox and not to the user:
       //         // In the demo version, mail()
       //
       //          $mail->Host = Config::SMTP_HOST;
       //          $mail->Username = Config::SMTP_USER;
       //          $mail->Port = Config::SMTP_PORT;
       //          $mail->Password = Config::SMTP_PASSWORD;
       //          $mail->SMTPSecure = 'tls';
       //          $mail->SMTPAuth = true;
       //          $mail->SMTPDebug = 0;  // set to 0 to hide debug process displayed on screen.
       //          $mail->isSMTP();
       //
       //          $mail->isHTML(true);                                  //set if you want to send html in email.
       //
       //          // Send the email:
       //         $mail->setFrom('brentonmarquez@gmail.com');
       //         $mail->addAddress($email);
       //
       //         $mail->Subject = 'Reset Password and Username Info';
       //
       //         // Send email that puts the token inserted into db into $_GET['token'] on reset_pw.php and user email into $_GET['email']:
       //         $mail->Body = '
       //                  <h1>Here is the information to reset your Pic Browser password</h1>  (If you did not expect this email, then disregard it.)<br>
       //                  Click this link to reset your password:
       //                  <a href="http://localhost/PicBrowserDemo/reset_pw.php?email='.$email.'&token='.$token.' ">http://localhost/picsearcher/reset.php?email='.$email.'&token='.$token.'</a>
       //                   Your username is: ' .$username;
       //         // Sends the email:
       //         $mail->send();

             // //Create a flag to display html msg in body:
             //  if ($mail->send()) {
             //
             //     $emailSent = true;
             //
             //  } else {
             //   echo "Message was not sent!";
             //    }

      } /* <-- if(email_exists) closing. */ //else if($email_exists == false) {
     //                                         $email_err = "User email not found.";
     //                                       } // (creates an error msg to display if email not in db.)

  } // If method=POST (user submitted) closing.

?>

<!-- If the flag for email being sent is set, display the html form markup. Used PHP short hand syntax to allow for cleaner html markup -->
<div class="container d-flex justify-content-center mt-5">
  <div class="row col-md-4">
    <div class="card">
      <div class="card-header text-center">
        <?php
          countdown_HTML();
        ?>

<?php if (!isset($emailSent)): ?>

         <h3>Forgot Password?</h3>
         <p>To receive a link to reset your password, enter email address:</p>
             <?php if(isset($email_err)) {
               echo $email_err; // echoes error msg if email not found in db.
             }
             ?>
      </div>
      <div class="card-body d-flex justify-content-center">
        <form action="" method="POST">
          <input type="email" class="form-control" name="email" size="30" placeholder="Enter Email Address" />
      </div>

          <button type="submit" name="submit" class="btn btn-primary">Reset Password</button>
          <a href="index.php" class="btn btn-danger">Back To Home Page</a>
        </form>
    </div>
  </div>
</div>

<?php else: ?>

      <h5>Please check your email for instructions on resetting your password.</h5>
     </div>
    </div>
   </div>
  </div>

<?php endIf; ?>

<?php include "includes/footer.php";?>
