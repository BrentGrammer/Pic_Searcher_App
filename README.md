# PIC SEARCHER APP

**Note:** *This project is well under way to completion.  Most functionality is complete; the focus is now on styling and UI improvements*

### Current version:
The purpose of this application is to create a searchable library of image files uploaded by the user. This is accomplished by the user uploading images on the home page to a library which is stored in a database managed with SQL/MySQL and accessed using PHP.  The user can then input search terms on the Gallery page (loacted on index.php), which will be queried to compare with full or partial matches (by word) in the database (under the description and name fields).  When a match is found, html code for the anchor contents of the image (also stored in the database to be echoed onto the Gallery page) will be retrieved and echoed onto the page (index.php - the results are shown after hiding the image library).  Please see list of Tasks to complete for further development.

Languages Used: PHP, SQL, HTML

## Tasks/Goals to Complete:
- Sanitize and validate user inputs on index.php and user searches; (') throws an error.
- Add no match found message if no matches are found for the image search on searchinput.php
- Security precautions against SQL injections and XSS.
- Style UI and forms
- Allow for multiple inputs in the index page?

## Completed Tasks:

- Delete icon buttons appear on the images on mouse hover
- Added functionality for description updates on search results
- Refactoring of major functions in the app - (search, delete, gallery display functions).
- Consolidated image gallery with the index page.
- Configured Search functionality to display results dynamically on the index page instead of on a separate search page.
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
