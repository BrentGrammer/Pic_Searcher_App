<?php include 'includes/header.php'; ?>

<!-- INDEX HOME PAGE CONTENT -->

  <div class="container text-center">
    <div class='container justify-content-center'>
      <div class="row">
        <h1 class="d-block w-100 font-italic display-4">PIC <img class='d-inline img-responsive' src="img/magnifyred.png" height="70" width="68">BROWSER</h1>
      </div>
      <div class="row justify-content-center">
        <p class="text-muted">Easily upload a searchable library of photos.</p>
      </div>
    </div>

    <!-- LOGIN FORM  -->
     <div class='container d-flex justify-content-center'>
       <div>
         <div class='card card-body bg-light d-inline-block'>
           <div>
             <!-- displays error msg if username/password incorrect: -->
             <?php
               loginError();
             ?>
           </div>
         <?php
              //checks if $_GET isset by header() function in logout.php to display logout msg:
              if(isset($_GET['logout'])) {
                 echo "You have been logged out.";
              }
         ?>
           <form action="login.php" method="POST">
             <div class='form-group'>
               <label>USERNAME: </label>
               <input class="form-control" name="username" type="text" placeholder="Enter username" />
             </div>
             <div class='form-group'>
                <label>PASSWORD: </label>
                <input class="form-control" name="password" type="password" placeholder="Enter password"/>
                <!-- FORGOT PASSWORD -->
                <div class="mt-1">
                  <a href='forgot_pw.php?forgot=<?php echo uniqid(true); ?>'>Forgot Password?</a>
                </div>
              </div>
              <button class='btn btn-primary w-100 d-block form-control' name="login" type="submit">Login</button>
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

  <p class="text-center fixed-bottom">Copyright <span>&copy;</span>2018 by Brent Marquez</p>


<?php include "includes/footer.php";?>
