<?php include 'includes/header.php'; ?>

<!-- INDEX HOME PAGE CONTENT -->

        <div class="container text-center mx-auto">
            <?php
                 //checks if $_GET isset by header() function in logout.php to display logout msg:
                 if(isset($_GET['logout'])) {
                    echo "You have been logged out.";
                 }
            ?>
          <div class='row'>
            <h1 class="font-italic display-4 w-100">PIC <img class='d-inline img-responsive' src="img/magnifyred.png">BROWSER</h1>
          </div>


                <div>
                  <!-- displays error msg if username/password incorrect: -->
                  <?php
                    loginError();
                  ?>
                </div>

              <!-- LOGIN FORM -->
             <div class='row text-center'>
               <div class='container'>
                 <div class='card card-body bg-light d-inline-block'>
                  <form action="login.php" method="POST">
                    <div class='form-group'>
                      <label class='#'>USERNAME: </label>
                      <input class='#' name="username" type="text" placeholder="Enter username" value="<?php loginFill('username'); ?>"/>
                    </div>
                    <div class='form-group'>
                      <label class=''>PASSWORD: </label>
                      <input name="password" type="password" placeholder="Enter password"/>
                    </div>
                    <a href='forgotpw.php?forgot=<?php echo uniqid(true); ?>'>Forgot Password?</a>
                    <button class='btn btn-primary w-100 d-block mt-1' name="login" type="submit">Login</button>
                  </form>
                </div>
               </div>
             </div>


                  <div class='row'>
                            <!-- LINK TO REGISTRATION PAGE -->
                        <h3 class='d-block w-100'>NEW USER?</h3>
                        <h3 class='d-block w-100'><a href="registration.php">REGISTER HERE</a></h3>
                  </div>
          </div>


<?php include "includes/footer.php";?>
