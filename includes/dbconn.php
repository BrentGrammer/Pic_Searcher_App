<?php
//This code (connects to the database) is included in all php files requiring access to the database.
//Using PDO Extension.
//database being connected to is 'picsearcherapp' and the name of the table is 'pics'.

//the server name is localhost when using xampp on computer, otherwise it is your website host (ip address)
$host = "localhost"; //Insert the name of the server.
$user = "root"; //Insert the Database username.
$password = ""; //Insert the password for the Database.
$dbName = "pic_browser_app"; //Insert the name of the database to be connected to.
$charset = 'utf8mb4'; //Define charset - use utf8mb4 over utf8.

$dsn = "mysql:host=$host;dbname=$dbName;charset=$charset";
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,      //sets default fetch mode to fetch_assoc;
    PDO::ATTR_EMULATE_PREPARES   => false,                 //Allows for use of Limit and turns off Emulation mode;
];

$pdo = new PDO($dsn, $user, $password, $opt);

//Uncomment the following to test the connection:
// try{
//     $pdo = new PDO($dsn, $user, $password, $opt);
//     die(json_encode(array('outcome' => true)));
// }
// catch(PDOException $ex){
//     die(json_encode(array('outcome' => false, 'message' => 'Unable to connect')));
// }
?>
