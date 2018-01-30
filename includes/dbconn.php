<?php
//This code (connects to the database) is included in all php files requiring access to the database.

//database being connected to is 'picsearcherapp' and the name of the table is 'pics'.

//the server name is localhost when using xampp on computer, otherwise it is your website host (ip address)
$dbServername = "localhost"; //Insert the name of the server.
$dbUsername = "root"; //Insert the Database username.
$dbPassword = ""; //Insert the password for the Database.
$dbName = "picsearcherapp"; //Insert the name of the database to be connected to.

//variable set to connect to the database:
$conn = mysqli_connect($dbServername,$dbUsername,$dbPassword,$dbName);

//testing the connection:
if (!$conn) {
   die("Database Not Connected!" . mysqli_error($conn));
}
?>
