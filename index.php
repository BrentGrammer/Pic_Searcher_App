<?php //includes the database connection code to connect to the database:
include "includes/dbconn.php"; ?>
<?php include "includes/functions.php"; ?>

<!DOCTYPE html>

<html>
    <head>
        <!--Font Awesome from Bootstrap CDN  -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link rel='stylesheet' href='main.css' type='text/css' />

    </head>

    <body>
      
      <?php
           //checks if $_GET isset by header() function in logout.php to display logout msg:
           if(isset($_GET['logout'])) {
              echo "You have been logged out.";
           }
      ?>

      <!-- LOGIN FORM -->
      <div class="divLogin">
          <h4>LOGIN</h4>
          <form class="loginform" action="includes/login.php" method="POST">
              USERNAME:<input name="username" type="text" placeholder="Enter username"/>
              PASSWORD:<input name="password" type="password" placeholder="Enter password"/>
              <button name="login" type="submit">Login</button>
          </form>
      </div>

      <!-- UPLOAD PIC -->
    <!-- <div class = "divUploadForm">
        <form action="upload.php" method="POST" enctype="multipart/form-data">
             UPLOAD IMAGE:
                <input name="userpic" type="file" required>
                <br/>
              Enter Searchable Description:
                <input name="description" type="text"  placeholder="Enter Description Here...">
                <br/>
                <button name="submit" type="submit">UPLOAD</button>
         </form>
    </div> -->


    </body>
</html>
