<?php include 'includes/header.php'; ?>

<?php

// $_GET values in sent email link are set to: $_GET['token'] to the token in the db, and user_email into $_GET['email']:
$url_email = $_GET['email'];
$url_token = $_GET['token'];

// Used to check length of token to prevent user from entering 0 or a space in the URL to match a reset token value in the db:
$token_length = strlen($url_token);

if ($token_length < 49) {
   echo "Invalid Token.  Password cannot be reset.";
}

if (isset($_POST['submit']) && $token_length > 49) {

  // Error message alert if fields are empty:
  if (empty($_POST['password']) || empty($_POST['confirm_pw'])) {

       echo "<script> alert('Please fill out all fields.'); </script>";

  } else {
      // If fields not empty, start processing submitted data:
      if ($_POST['password'] === $_POST['confirm_pw']) {

           // hash the entered new password:
           $password = $_POST['password'];
           // hash the new password:
           $hashed_pw = password_hash($password, PASSWORD_BCRYPT, array('cost'=>12));

            // Get user row corresponding to the token in url from the sent email:
            $sql = "SELECT username, user_email FROM users WHERE token=?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$url_token]);

            while ($row = $stmt->fetch()) {
              $email    = $row['user_email'];
              $username = $row['username'];
            }

            // TODO: if no match found then redirect user to index.php

            // Set token column in db to empty and insert the new password:
            $sql = "UPDATE users SET token='', user_password=? WHERE user_email=?";
            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute([$hashed_pw, $email]);

            if (!$result) {
              die('There was an error.  Password was not reset.');
            } else {
                  $success_msg = 'Password was reset.  <a class="btn-link btn-success" href="index.php">Click Here to Login</a>';
              }

      } /*<-- if password = confirm_pw if statement closing.*/
        else {
           $pw_match_err = "Passwords do not match.";
        }

    } //<-- else (if) both fields are not empty closing.

} //<-- if isset($_POST['submit']) closing.

?>

<!-- RESET FORM -->

<div class="container d-flex justify-content-center mt-5">
  <div class="row col-md-4">
    <div class="card text-center">
      <div class="card-header text-center">
        <h3>Reset Password</h3>
      </div>
      <div class="card-body d-flex justify-content-center">
        <form action="" method="POST">
          <div>
            <label>Create New Password: </label><input type="password" class="form-control" name="password" minlength="5" maxlength="30" size="30" placeholder="Enter New Password" />
          </div>
          <div class="mt-3">
            <label>Confirm New Password: </label><input type="password" class="form-control" name="confirm_pw" minlength="5" maxlength="30" size="30" placeholder="Enter New Password Again" />
          </div>
      </div>
      <div class="card-footer">
         <button type="submit" name="submit" class="btn btn-primary w-100">Reset Password</button>
      </div>
      <div>
         <p><?php if(isset($success_msg)) {echo $success_msg;} ?></p>
         <p class="text-danger"><?php if(isset($pw_match_err)) {echo $pw_match_err;} ?></p>
      </div>
       </form>

   </div>
 </div>
</div>








<?php include "includes/footer.php";?>
