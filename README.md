# PIC BROWSER APP
![Application Pic](https://github.com/BrentGrammer/Pic_Searcher_App/blob/master/img/apppic.JPG)


### Please Try the Working Online Demo Here: [https://brentmarquez.com/PicBrowser/index.php](https://brentmarquez.com/PicBrowser/index.php)

### Current version:
The purpose of this application is to create a quickly and easily searchable library of image files uploaded by the user.

See the Pic Browser App wiki for pictures and explanation of how to use the app.

The user uploads images on the home page to a library which is stored in a database.  The user can then input search terms on the Gallery page, which will be queried to compare with full or partial matches in the database (a comparison is made to the description and name fields).  When a match is found, the image results are displayed instantly via AJAX on the gallery page.  Please see list of Tasks to complete for further development.


Built using: PHP, SQL, Javascript/JQuery

## Tasks/Goals to Complete:

- Add a progress bar that shows while photos are uploading.

- Bug: PHPMailer sending duplicate emails from reset password submit on forgot_pw.php - the issue is with reloading the page
when $emailSent is set and the message to check email is loaded-this refreshes the page and runs the script to send the email again.  Possible fix with AJAX/JQuery?

- Make popup modal for uploading images

- Change size of thumbnail for mobile screens (xs/s settings or use css media queries)

- Add pagination for image gallery page (limit results to maybe 25-50pics per page)

- Prevent multiple submissions of same pic file? to protect against overloading database.  Limit number of pics for each user (check the number of rows in the pics table with an if statement on upload.php before proceeding with upload process)

- Allow user to return to updatepic.php if description is too long (values are lost currently when returning to page), so they can update the description quickly without have to go back to gallery.php.  Poss. Solution - assign a 'SESSION' variable

- Add function to hide and show description on the gallery page (maybe create a settings page).

- Add album functionality

- Refactor the procedure to get user data based on username and assign session variables into a function for use in registration.php and login.php

- Message to user on login.php and registration.php of what legal characters user can use for username/name (because striptags() and htmlspecialchars() are used etc.)

- Add compatibility for older browsers using methods from: https://www.w3schools.com/html/html5_browsers.asp

- Remove remaining debugging code

- Update var keywords in js code to be let or const (to avoid potential hoisting problems)


## Completed Tasks:

- Live Search functionality is now added to gallery.php.  User can type in terms in the search bar and the matching
results instantly display on the page.
- Fixed bug when updating caption on gallery.php with AJAX (function occurs when processing is complete and updates everytime correctly now by using a callback in .post())
- Added forgot password and reset password feature using PHPMailer with Composer
- Added a wiki with photos of the app and description of functionality.
- Gallery page menu items now incorporate flexbox and are responsive.
- User can now select delete pic checkbox easier by clicking anywhere in the image in EDIT LIBRARY MODE.
- Added Select All checkbox for deleting pics on Edit Library button click.
- User can now update descriptions/captions dynamically (AJAX/JQuery used on popup modal)
- User can now select images to delete with checkboxes.
- Fixed bug - delete checkbox position in top right of img now stays constant in all screen sizes.
- Username/Password Incorrect(login.php and index.php) and Username Taken(registration.php) errors now display if the user submits invalid login or registration data.
- Fields now stay filled in on error on Registration Form (registration.php)
- User is now redirected to gallery.php and logged in automatically after registering.
- Confirm messages now are prompted to user to Delete Account/Delete Pic/Log out.
- User submitted data on the searchImg() from functions.php, upload.php, updatepic.php/updated_description.php, login.php and registration.php is now sanitized before being used in the Database (htmlentities() is used and string limits are set).
- Registration form and system is functional (registration.php); Usernames and Emails are checked in the database to prevent duplicate entries.
- User password secured on registration.php by using password_hash() with BLOWFISH Hash format.
- Update description and search functionality are now linked to the logged in user path to prevent user pulling up other user pics from the database.
- Added functioning user login form and system
- User table created to store user info
- Converted mysqli connection and queries to PDO.  All queries handling user input now use prepared statements to prevent SQL injection and allow for apostrophes in user description input.
- Delete icon buttons appear on the images on mouse hover
- Added functionality for description updates on search results
- Refactoring of major functions in the app - (search, delete, gallery display functions).
- Consolidated image gallery with the index page.
- Configured Search functionality to display results dynamically on the index page instead of on a separate search page.
- Working Delete Icon Buttons in the gallery and search results page.
- Added required attribute to file upload input to protect against empty db entries.
- Styled the Gallery page with Flexbox layout in CSS and Font Awesome icons from Bootstrap.
- Added update description functionality the user can now update the description gallery.php and updatepic.php and it is updated in the database.
- Refactoring with some of the query code blocks into functions (put in functions.php) to clean up code format
- User description successfully inserted into alt attribute of image in the anchor column of 'pics' table on the database
- Created Button to view image gallery on gallery.php page
- Anchor column created in the database to store the anchor text to be echoed into the gallery page with each submission.  
- Database structure for storing image files, paths and descriptions is set up
- Connection to the database is completed
- Image files successfully upload to a specified directory (/uploads)
- The Database is updated successfully after user submits data

**Note:** *The structure of the database columns is: id,name,path,description,unique_id
The database name is 'picsearcherapp'.  The table name is 'pics'.
users table structure is user_id, username, user_password, user_firstname, user_lastname, user_email, user_role.*
