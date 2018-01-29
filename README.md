# PIC SEARCHER APP

**Note:** *This project is under construction.*

### Current version:
The purpose of this application is to create a searchable library of image files uploaded by the user. This is accomplished by the user uploading images on the home page to a library which is stored in a database managed with SQL/MySQL and accessed using PHP.  The user can then input search terms on the Gallery page (gallery.php), which will be queried to compare with full or partial matches (by word) in the database (under the description and name fields).  When a match is found, html code for the anchor contents of the image (also stored in the database to be echoed onto the Gallery page) will be retrieved and echoed onto a results page (currently searchinput.php).  Please see list of Tasks to complete for further development.

### *This was an earlier idea for an early version*:
~~The goal is to allow the user to enter a description which is inserted into the 'alt' attribute of the corresponding image file and then allow the user to search for pics using text that matches the description in some way.  An alternative method is incorporating FULLTEXT searching in the description column and matching user queries.

The way this was accomplished was by concatenating the html img tag code to the inputed description by the user and assigning it to a variable to be inserted into a column on the database (this is done in upload.php which runs after the use clicks the submit button on index.php).  This column data is then pulled from the database with PHP and echoed onto an image gallery page (gallery.php) where the alt attribute is filled in with the user description.)~~  

Languages Used: PHP, SQL, HTML

## Tasks/Goals to Complete:
- Add ability to change description on searchresults.php page
- Sanitize and validate user inputs on index.php and throughout searches; (') throws an error.
- Add no match found message if no matches are found for the image search on searchinput.php
- Fix styling on the gallery page to make the Change Description button show below the image.
- Remove alt attribute (no longer needed as description column is queried for searches)
- Security precautions against SQL injections and XSS.
- Style UI and forms
- Allow for multiple inputs on the index page
- Add update functionality so that if the user deletes an image then the corresponding image    file and entry in the database is removed.
- Refactoring and putting PHP/MySQL functions into a separate file
- Sanitize user search inputs in searchinput.php
- Figure out why selectNameDescriptionAnchor() doesn't work on searchinput.php when trying to refactor.
- Delete unecessary/unused query functions in functions.php
- Put gallery on the index page to combine it with the upload and description buttons.

## Completed Tasks:

- Working Delete Icon Buttons in the gallery and search results page.
- Added required attribute to file upload input to protect against empty db entries.
- Styled the Gallery page with Flexbox layout in CSS and Font Awesome icons from Bootstrap.
- Added search functionality where the description and name fields are queried with standard WHERE/LIKE statements in searchinput.php
- Added update description functionality the user can now update the description gallery.php and updatepic.php and it is updated in the database.
- Refactoring with some of the query code blocks into functions (put in functions.php) to clean up code format
- User description successfully inserted into alt attribute of image in the anchor column of 'pics' table on the database
- Created Button to view image gallery on gallery.php page
- Anchor column created in the database to store the anchor text to be echoed into the gallery page with each submission.  
- Database structure for storing image files, paths and descriptions is set up
- Connection to the database is completed
- Image files successfully upload to a specified directory (/uploads)
- The Database is updated successfully after user submits data

**Note:** *The structure of the database columns is: id,name,path,description,unique_id,anchor
The database name is 'picsearcherapp'.  The table name is 'pics'.*
