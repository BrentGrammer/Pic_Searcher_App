PIC SEARCHER APP

Note: this project is still in the beginning stages.

The purpose of this application is to create a searchable library of image files uploaded by the user.  The goal is to allow the user to enter a description which will be inserted into the 'alt' attribute of the corresponding image file.  Search functionality will allow the user to search for a pic using descriptive text which will match, in part or in full, the description inputed by the user upon the original upload.  

Languages Used: PHP, SQL, HTML

Tasks to Complete:

- Make a column in the database to store the anchor text to be echoed into the gallery page with each submission
- Create a search function using switch statements to search the Database
- Style UI and forms
- Style the gallery with CSS
- Allow for multiple inputs on the index page
- Add update functionality so that if the user deletes an image then the corresponding image    file and entry in the database is removed.
- Refactoring and putting PHP/MySQL functions into a separate file

Completed Tasks:

- Database structure for storing image files, paths and descriptions is set up
- Connection to the database is completed
- Image files successfully upload to a specified directory (/uploads)
- The Database is updated successfully after user submits data
