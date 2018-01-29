<?php include 'includes/dbconn.php';?>
<?php include 'includes/functions.php';?>


<?php
//This file (searchinput.php) holds the user search query sent from the form on gallery.php(the button name='searchinput');

if (isset($_GET['searchinput'])) {
   //TODO - make an if statement to check if search bar is empty and display enter terms message;

     //Assign variable to $_POST['searchinput']
     $searchInput = $_GET['searchinput']; //this holds the keyword(s) the user inputed to search
     // debugging print_r($_POST);
     //explode $searchInput by spaces to separate words and put them in an array ($searchTerms) to compare for a match in description field:
     $searchTerms = explode(" ", $searchInput);
    // debugging: print_r($searchTerms);

    //TODO Why doesn't selectNameDescriptionAnchor() from functions.php work?? can't refactor..

    // loop through $searchTerms to search for each in name/description fields and grabs anchor for echoing the matching image(s):
    foreach ($searchTerms as $i) {
       $query = "SELECT name, description, anchor FROM pics WHERE name LIKE '%$i%' OR description LIKE '%$i%' ";
       $result = mysqli_query($conn, $query);
     }
       //TODO return error message if $result is empty (may not be necessary or needs to be modified to return no results found message to user):
       if (!$result) {
         die("Database Query Failed!" . mysqli_error($conn));
       }

     //get the rows returned in an associative array and echo the anchor field from each row to display the image:
     while ($row = mysqli_fetch_assoc($result)) {
         $searchResult = $row['anchor'];
         echo $searchResult;
      }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Search Results</title>
    <link rel='stylesheet' href='gallerystyle.css' type='text/css' />
  </head>
      <body>
           <!--This page displays the search results which are echoed in the PHP code above -->
      </body>

</html>
