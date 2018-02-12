<?php include 'includes/header.php'; ?>


<?php var_dump($_POST); ?>

<form class='form_upd_caption' action='test.php' method='POST'> <!--place back in action: updated_description.php -->
   <div class='form-group'>
     <textarea class='newCaption' class='form-control' name='newDesc'>36desc</textarea>
     <button class='btn_upd_caption'class='form-control' type='submit' name='updateDesc' value='36'>UPDATE</button>
   </div>
</form>


<div class='caption divCaption'>
    <button class='desc w-100 rounded-bottom' data-toggle='modal' data-target='#updatepic_$imgId' title='Click to Change' type='button'>
      <p class='caption' class='text-center'>$description</p>
    </button>
</div>



<form class='form_upd_caption' action='test.php' method='POST'> <!--place back in action: updated_description.php -->
   <div class='form-group'>
     <textarea class='newCaption' class='form-control' name='newDesc'>22desc</textarea>
     <button class='btn_upd_caption'class='form-control' type='submit' name='updateDesc' value=22>UPDATE</button>
   </div>
</form>


<div class='caption divCaption'>
    <button class='desc w-100 rounded-bottom' data-toggle='modal' data-target='#updatepic_$imgId' title='Click to Change' type='button'>
      <p id='caption_36' class='caption' class='text-center'>$description</p>
    </button>
</div>







<?php include "includes/footer.php";?>

<script>

$(document).ready(function() {

$("form").submit(function(e) {



  e.preventDefault();
  // console.log("e.target:");
  // console.log($(e.target));
  // console.log("this:");
  // console.log($(this).find('btn_upd_caption').val());
  //  // Print the value of the button that was clicked
  //  console.log("activeelement val:");
  //  console.log($(document.activeElement).val());

   var newCaption = $(this).find('.newCaption').val();
   var imgId = $(this).find('.btn_upd_caption').val();

   $.post('test.php', {
     newCaption: newCaption,
     imgIdNum: imgId
   });

   var captionId = "caption_" + imgId;

   // Get updated description from db and load it into the caption html on gallery.php:
    console.log($('#' + captionId));
  // console.log( $("#caption_" + imgId) );
    //display the submitted description in the caption area without reloading the page:

   });





 });


</script>
