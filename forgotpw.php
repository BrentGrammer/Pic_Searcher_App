<?php include 'includes/header.php'; ?>
<?php require './vendor/autoload.php'; ?>
<?php use PHPMailer\PHPMailer\PHPMailer; ?>
<?php require './classes/Config.php'; ?>


<?php


// Check if GET and GET['forgot'] from Forgot Password link on index.php is set - if not, then send user back to index:

//this is not secure - user can enter anything into forgot to set get and value - work on this:
if( (!$_SERVER['REQUEST_METHOD'] == 'GET') && (!isset($_GET['forgot'])) ) {

  header('Location: index.php');
}

// Check if post is set and assign user submitted email to variable:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if(isset($_POST['email'])) {

        $email = $_POST['email'];
        var_dump($email);

      } else {
        echo "Please enter an email address.";
      }


    // TODO: (Sanitize and validate email here)

     // Set up a token to put into the db:
     $length = 50;
     // Create randomized token key to enter into the db:
     $token = bin2hex(openssl_random_pseudo_bytes($length));

     // Check if user email exists in db:
     $sql = "SELECT user_email FROM users WHERE user_email = ?";
     $stmt = $pdo->prepare($sql);
     $result = $stmt->execute([$email]);

     if(!$result) {

        die('Query Failed!');
     }

     // Check if num of rows returned in 0 (no match for email in db):
     // (Note: this is a method of the pdo $stmt object)
     $count = $stmt->rowcount();
     // set to check for error:
     $email_exists = false;

     if($count > 0) {
        $email_exists = true;
     }

     if ($email_exists == true) {
       // If email exists, set the $token to insert into the db token column:
       $sql = 'UPDATE users SET token=? WHERE user_email=?';
       $stmt = $pdo->prepare($sql);
       $result = $stmt->execute([$token,$email]);
     }


     // **** CONFIGURE PHPMAILER **** //

// instantiate the PHPMailer class to access props and methods:
$mail = new PHPMailer;

try {
     //Server settings
         $mail->SMTPDebug = 2;                                 // Enable verbose debug output
         $mail->isSMTP();                                      // Set mailer to use SMTP
         $mail->Host = Config::SMTP_HOST;  // Specify main and backup SMTP servers
         $mail->SMTPAuth = true;                               // Enable SMTP authentication
         $mail->Username = Config::SMTP_USER;                 // SMTP username
         $mail->Password = Config::SMTP_PASSWORD;                           // SMTP password
         $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
         $mail->Port = Config::SMTP_PORT;

         $mail->isHTML(true);                                  //set if you want to send html in email.

         // Send the email:
        $mail->setFrom('brentonmarquez@gmail.com');
        $mail->addAddress($email);

        $mail->Subject = 'Reset Password';
        $mail->Body = 'This is a message to reset your password';

        // Sends the email:
        $mail->send();

        echo 'Message has been sent';

} catch(Exception $e) {
    echo 'Message could not be sent. Mailer Error: ', $mail->ErrorInfo;
}





  } // If method=POST (user submitted) closing.




?>

<form action="" method="POST">
  ENTER EMAIL: <input type="email" name="email" />
  <button type="submit" name="submit" class="btn btn-primary">SUBMIT</button>
</form>






<?php include "includes/footer.php";?>
