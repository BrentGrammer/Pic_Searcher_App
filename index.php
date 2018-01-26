<?php
//includes the database connection code to connect to the database:
include "includes/dbconn.php";
?>

<!DOCTYPE html>

<html>
<head>

</head>

<body>

<form action="upload.php" method="POST" enctype="multipart/form-data">
  STEP ONE: Choose your Image:
      <input type="file" name="userpic">
      <br/>
  STEP TWO: Enter a description that you can search for later:
      <input type="text" name="description" placeholder="Enter Description Here...">
      <br/>
      <button type="submit" name="submit">UPLOAD</button>

</form>

<a href="gallery.php">VIEW IMAGE GALLERY</a>

</body>

</html>
