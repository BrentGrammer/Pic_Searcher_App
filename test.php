<?php include 'includes/header.php'; ?>


<!-- UPLOAD PIC -->
<div class="container text-center">
  <div class="row d-flex justify-content-center">
   <div class="card">
    <div class="container">
     <div class="card-header">
       <h3>Upload Your Images: </h3>
     </div>
     <div class="card-body">
      <form action="upload.php" method="POST" enctype="multipart/form-data">
         <div class="form-group" id='form_upload_inputs'>
             <div>
               <input name='userpic[]' type='file' required>
               <!-- This is hidden to keep correct spacing when a new input is added -->
               <a style="visibility: hidden;" href='#' class='d-hidden rem_upload_input btn btn-link pull-right'>Remove</a>
             </div>
             <input class="form-control" name="description[]" type="text" size="35" placeholder="Enter Searchable Description Here...">
         </div>
         <div class="form-group">
            <button id="btn_add_upload" class="btn btn-link btn-primary form-group form-control"><i class="fa fa-plus"></i>Add Another Image</button>
            <button class='btn btn-primary form-control' name="submit" type="submit">UPLOAD IMAGES</button>
         </div>
      </form>
         <a class="btn btn-secondary" href="gallery.php" role="button">BACK TO GALLERY</a>
     </div>
    </div>
   </div>
  </div>
 </div>

<?php include "includes/footer.php";?>
