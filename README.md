PIC SEARCHER APP

Note: this project is under construction.

The purpose of this application is to create a searchable library of image files uploaded by the user.  The goal is to allow the user to enter a description which is inserted into the 'alt' attribute of the corresponding image file and then allow the user to search for pics using text that matches the description in some way.  

The way this was accomplished was by concatenating the html img tag code to the inputed description by the user and assigning it to a variable to be inserted into a column on the database (this is done in upload.php which runs after the use clicks the submit button on index.php).  This column data is then pulled from the database with PHP and echoed onto an image gallery page (gallery.php) where the alt attribute is filled in with the user description.

Search functionality will allow the user to search for a pic using descriptive text which will match, in part or in full, the description inputed by the user upon the original upload.  

Languages Used: PHP, SQL, HTML

Tasks to Complete:
- Add functionality to update the anchor alt attribute to the new user updated descriptions
- Create a search function using switch statements to search the 'description' column of the database table
- Style UI and forms
- Style the gallery with CSS-create and add external style sheet
- Allow for multiple inputs on the index page
- Add update functionality so that if the user deletes an image then the corresponding image    file and entry in the database is removed.
- Refactoring and putting PHP/MySQL functions into a separate file

Completed Tasks:
- Added update description functionality the user can now update the description gallery.php and updatepic.php and it is updated in the database.
- Refactoring with some of the query code blocks into functions (put in functions.php) to clean up code format
- User description successfully inserted into alt attribute of image in the anchor column of 'pics' table on the database
- Created Button to view image gallery on gallery.php page
- Anchor column created in the database to store the anchor text to be echoed into the gallery page with each submission.  
- Database structure for storing image files, paths and descriptions is set up
- Connection to the database is completed
- Image files successfully upload to a specified directory (/uploads)
- The Database is updated successfully after user submits data
