<?php //includes the database connection code to connect to the database:
include "includes/dbconn.php"; ?>




<!-- Page Content -->

<div class="divRegister">
    <h1>REGISTER</h1>
       <form class="formRegister" action="registration.php" method="POST">
           CREATE USERNAME: <input type="text" name="username" placeholder="Enter desired username...">
           CREATE PASSWORD: <input type="password" name="password" placeholder="Enter desired password...">
       </form>
</div>
