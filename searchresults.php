<?php include 'includes/dbconn.php';?>
<?php include 'includes/functions.php';?>


<?php
//This file (searchinput.php) holds the user search query sent from the form on gallery.php(the button name='searchinput');
//-------------------WHEN USER PRESSES DELETE BUTTON ON AN IMG----------------------//
  if (isset($_POST['submitDelete'])) {
    deleteImg();
  }

  //--------------------------DISPLAYS SEARCH RESULTS IF SEARCH HAS BEEN INPUTTED ON GALLERY.PHP---------------------------//
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

       if (!$result) {
         die("Database Query Failed!" . mysqli_error($conn));
       } else {
         //get the rows returned in an associative array and echo the anchor field from each row to display the image:
           while ($row = mysqli_fetch_assoc($result)) {
               $searchResult = $row['anchor'];
               echo $searchResult; //Echoes the anchor column data for the image from the database.
            }
          }
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Search Results</title>
    <link rel='stylesheet' href='gallerystyle.css' type='text/css' />

    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  </head>
      <body>
        <a href='gallery.php'>BACK TO GALLERY</a>
           <!--This page displays the search results which are echoed in the PHP code above -->
      </body>

</html>
