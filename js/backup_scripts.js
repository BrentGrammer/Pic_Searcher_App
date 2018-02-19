// JS/JQuery Functions:

// --------------- CONFIRM ALERT (delete/login etc. msg alerts) --------- //

function confirm_action(msg) {

          return confirm(msg);
      }


// -- JQuery functions -- //

$(document).ready(function() {

// ---------------UPDATE DESCRIPTION/CAPTION MODAL-------------------- //

//when form is submitted, default action is stopped, and submitted input values are collected:
$('.form_upd_caption').submit(function(e) {
      e.preventDefault();

      // Grabs user submitted description and imgId value in the submit button to put into $_POST on updated_description.php:
      // ($(this) = the form element that is the parent of the submit button (.form_upd_caption):
      var newCaption = $(this).find('.newCaption').val();
      var imgId      = $(this).find('.btn_upd_caption').val(); //(the unique id for img is in the value of the button)

      // Sends submitted data to $_POST['newCaption', 'imgIdNum'] to be processed on updated_description.php and sent to db:
      $.post('updated_description.php', {
        newCaption: newCaption,
        imgIdNum:   imgId
        });

       var captionId = "#caption_" + imgId;


       function get_new_caption(){
       // Get updated description from db and load it into the caption html on gallery.php:
        $(captionId).load('updated_description.php #newCaption');
       }

        // concat the id with imgId to grab the modal window to close it:
        var modal_Id = '#updatepic_' + imgId;
        // Use .modal('hide') to close the modal after the submit:
        $(modal_Id).modal('hide');

                 });



// ---------------------EDIT LIBRARY BUTTON----------------------- //

$('#btn_edit_library').click(function() {

      $(this).toggleClass('btn-secondary btn-danger'); // changes from blue to red if clicked
      $('.delete_chkbox, #select_all_label').toggle();  // shows/hides the check boxes on click.
      $('#btn_delete_pics').toggle();  //SHOW/HIDE THE DELETE BUTTON

      //When edit library button clicked, all checkboxes(incl. select all) are unchecked:
      $('#delete-chkbox-wrapper input:checkbox, #chkbox_select_all').prop('checked',false);


      // Changes edit button text to Cancel if cicked and back again on click:
      if ($(this).text() == "EDIT LIBRARY") {
        $(this).text("CANCEL");
      } else {
           $(this).text("EDIT LIBRARY"); // Changes back to 'EDIT LIBRARY'
        }



  });


  //If the EDIT button is labeled CANCEL when <anchor> clicked, disable img link anchor, and instead select checkbox:

          $('a.img_anchor').click(function(e) {

              const edit_btn_txt = $('#btn_edit_library').text();

              if (edit_btn_txt == "CANCEL") {

              e.preventDefault();

              const x = $(this).prevAll(".chkbox_del_div");
              const matching_chkbox = $(x).children(".delete_chkbox");

              $(matching_chkbox).prop("checked", !$(matching_chkbox).prop("checked"));
           }

          });


// ------------------DELETE SELECTED PICS------------------------- //

// wrapper (containing the delete checkboxes) id is 'delete-chkbox-wrapper'
// delete button on gallery page has id = 'btn_delete_pics'.

// Explanation: the values of each of the checkboxes containes the unique imgId num in the db.  All of the values of the
// checked boxes in the wrapper div are gathered and put into a hidden input on the delete pics form on gallery.php to
// be submitted to $_POST['imgIds'] on the gallery.php page and are processed by deleteImg() from functions.php which is
// called on gallery.php if $_POST['imgIds'] is set from clicking on the delete pics button (#btn_delete_pics) in the edit library forms
// from gallery.php.

// IIFE used (was used to access no longer existing array variable, but no longer needed?)
$(function() {
     // (Delete Pics button (#btn_delete_pics) in gallery shown after edit library button is clicked):
     $("#btn_delete_pics").click(function() {

      // When delete button pressed, this grabs and loops through the checked boxes from the Div wrapper id containing them on gallery.php:
               $('#delete-chkbox-wrapper input:checked').each(function() {
                    // the value of the checkbox holds the unique $imgId from insertion to the db:
                    var picId = $(this).val();

                    var formInsert = "<input type='hidden' name='imgIds[]' value='" + picId + "'>" //quotes necessary with variable picId in value?
                    // Append formInsert for each selection with the imgId value which will be submitted:
                    $('#form_del_pics').append(formInsert);

                                    });

                          });

                });// <--IIFE closing



// ------------------SELECT ALL CHECKBOXES-------------------------- //

$('#chkbox_select_all').change(function(e) {
  console.log(e);
  console.log($(this).prop('checked'));

  var selectAll = $(this).prop('checked');

    // When select all box changes, set the checked prop value of all checkboxes in wrapper to the checked prop value of the select all checkbox:
    $('#delete-chkbox-wrapper .delete_chkbox').prop('checked', selectAll);

});






// --------------------------Adds a new input for the user to upload additional images when upload another img button clicked on upload.php:

$('#btn_add_upload').click(function() {

    var formInsert =  "<div class='form-group'> \
                        <div class='row'> \
                         <input class='d-inline' name='userpic[]' type='file' required> \
                         <a href='#' class='d-inline rem_upload_input btn btn-link pull-right'>Remove</a> \
                         </div> \
                         <input class='form-control' name='description[]' type='text' size='35' placeholder='Enter Searchable Description Here...'> \
                      </div>";

    $('#form_upload_inputs').append(formInsert);

    // Option to remove Added Upload input div:
    $('.rem_upload_input').click(function() {

          let added_input = $(this).closest("div.form-group");

          $(added_input).remove();

          });

                  });


//------------- closing for $(document).ready method at the beginning of file -----------//

}); //<---closing document.ready
