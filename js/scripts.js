
// Confirm delete/login etc. msg alerts:

function confirm_action(msg) {

          return confirm(msg);
      }


// -- JQuery functions -- //
$(document).ready(function() {

//---------------UPDATE DESCRIPTION/CAPTION MODAL--------------------//
//when form is submitted, default action is stopped, and submitted input values are collected:
$('.form_upd_caption').submit(function(e) {
      e.preventDefault();

      // Grabs submitted values and imgId to process and insert into db on updated_description.php:
      // ($(this) = the form element that is the parent of the submit button (.form_upd_caption):
      var newCaption = $(this).find('.newCaption').val();
      var imgId      = $(this).find('.btn_upd_caption').val(); //(the unique id for img is in the value of the button)

      // Sends submitted data to $_POST['newCaption', 'imgIdNum'] to be processed on updated_description.php and sent to db:
      $.post('updated_description.php', {
        newCaption: newCaption,
        imgIdNum:   imgId
        });

       var captionId = "#caption_" + imgId;

       // Get updated description from db and load it into the caption html on gallery.php:
        $(captionId).load('updated_description.php #newCaption');

        // concat the id with imgId to grab the modal window to close it:
        var modal_Id = '#updatepic_' + imgId;
        // Use .modal('hide') to close the modal after the submit:
        $(modal_Id).modal('hide');

                 });



//---------------------EDIT LIBRARY BUTTON-----------------------//

$('#btn_edit_library').click(function() {

      $(this).toggleClass('btn-primary btn-danger'); // changes from blue to red if clicked
      $('.delete_chkbox').toggle();  // shows/hides the check boxes on click.
      //$('#btn_delete_pics').toggle();  SHOW/HIDE THE DELETE BUTTON

      //When edit library button clicked, all checkboxes are unchecked:
      $('#delete-chkbox-wrapper input:checkbox').prop('checked',false);

      // Changes edit button text to Cancel if cicked and back again on click:
      if ($(this).text() == "EDIT LIBRARY") {
        $(this).text("CANCEL");
      } else {
          $(this).text("EDIT LIBRARY");
        };

  });




//------------------DELETE SELECTED PICS-------------------------//

// wrapper (containing the delete checkboxes) id is 'delete-chkbox-wrapper'
// delete button on gallery page has id = 'btn_delete_pics'.

// IIFE used (was used to access array variable, but no longer needed?)
$(function() {

// Create an array to hold the imgId values of the selected checkboxes:

     // (Delete Pics button (#btn_delete_pics) in gallery shown after edit library button is clicked):
     $("#btn_delete_pics").click(function() {

      // When delete button pressed, this grabs and loops through the checked boxes from the Div wrapper id containing them on gallery.php:
               $('#delete-chkbox-wrapper input:checked').each(function() {
                    // the value of the checkbox holds the unique $imgId from insertion to the db:
                    var picId = $(this).val();

                    var formInsert = "<input type='hidden' name='imgIds[]' value='" + picId + "'>"
                    // Append formInsert for each selection with the imgId value which will be submitted:
                    $('#form_del_pics').append(formInsert);

                                    });

               });// <--Delete button click event closing

});// <--IIFE closing


// Adds a new input for the user to upload additional images when upload another img button clicked on upload.php:
$('#btn_add_upload').click(function() {

    var formInsert =  "<div> \
                         <input name='userpic[]' type='file' required> \
                         <label>Enter Description (searchable): </label> \
                         <input name='description[]' type='text'  placeholder='Enter Description Here...'> \
                      </div>";

    $('#form_upload_inputs').append(formInsert);


                  });


});//<---closing for $(document).ready method at the beginning of file.
