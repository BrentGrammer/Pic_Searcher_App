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
            <!-- LOGIN FORM -->


                <div>
                  <!-- displays error msg if username/password incorrect: -->
                  <?php
                    loginError();
                  ?>
                </div>
               <div class='row text-center'>
                <form class="form-group" action="login.php" method="POST">
                  <div>
                    <label class='d-block w-100'>USERNAME: </label> <input class='d-inline-block w-100' name="username" type="text" placeholder="Enter username" value="<?php loginFill('username'); ?>"/>
                    <label class='d-block w-100'>PASSWORD: </label> <input class='d-inline-block w-100' name="password" type="password" placeholder="Enter password"/>

                    <button class='btn btn-primary d-inline-block mt-1 w-100' name="login" type="submit">Login</button>
                  </div>
                </form>
              </div>


                  <div class='row'>
                            <!-- LINK TO REGISTRATION PAGE -->
                        <h3 class='d-block w-100'>NEW USER?</h3>
                        <h3 class='d-block w-100'><a href="registration.php">REGISTER HERE</a></h3>
                  </div>
          </div>


<?php include "includes/footer.php";?>
