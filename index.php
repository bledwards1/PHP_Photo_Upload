<?php
/*
 License: MIT
 Date: 1-25-16
 Brad Edwards
 This file displays and allows you to upload images
*/
?>

<!DOCTYPE html>
<html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
  <title>Upload Image</title>
<style type="text/css">
@import url("https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css");
</style>

<?php if($_SERVER['REQUEST_METHOD'] == 'GET') { ?>
<form method="post" action="<?php echo $_SERVER['SCRIPT_NAME'] ?>" enctype="multipart/form-data">
      <div class="col-sm-6 col-md-4">
<div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Upload Image...</h3>
          </div>
            <div class="panel-body">
                      <div class="row">
                  					<div  class="form-group col-sm-5">
        </div>
        </div>
              Select image to upload:
              <input class="btn btn-default" type="file" name="fileToUpload" id="fileToUpload">
              <br/>
              <input class="btn btn-default" type="submit" value="Upload Image" name="submit">         
            </div>
        </div>
  </div>
  
<!-- Adding in the area to show thumbanils of the files that have been uploaded so far -->
  <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Photos Uploaded</h3>
          </div>
            <div class="panel-body">
              <?php
                  class ImageFilter extends FilterIterator {
                        public function accept() {
                          return preg_match('@\.(gif|jpe?g|png)$@i',$this->current());
                        }
                      }  
                  foreach (new ImageFilter(new DirectoryIterator('/home/cabox/workspace/object_oriented/uploads'))as $img) {
                    print "<img src='uploads/".htmlentities($img)."'/>";
                  }
              ?>
          </div>
          
    </div>    
  </div>

  
</form>
<?php 
 } else {
  $uploadOk = 1;  
  if (isset($_FILES['fileToUpload']) &&
      ($_FILES['fileToUpload']['error'] == UPLOAD_ERR_OK)) {
      $newPath = '/home/cabox/workspace/object_oriented/uploads/' . basename($_FILES['fileToUpload']['name']);
      $imageFileType = pathinfo($newPath,PATHINFO_EXTENSION);
      // Check if file already exists
      if (file_exists($newPath)) {
          echo "Sorry, file already exists.";
          $uploadOk = 0;
      }   
      // Check file size
      if ($_FILES["fileToUpload"]["size"] > 500000) {
          echo "Sorry, your file is too large.";
          $uploadOk = 0;
      }
      // Allow certain file formats
      if($imageFileType != "PNG" && $imageFileType != "GIF" && $imageFileType != "JPEG" && $imageFileType != "JPG" && $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
          echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
          $uploadOk = 0;
      }
     // *** End of checks ***
    
      if ($uploadOk == 1) {
        move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $newPath);
        print "Success! The photo was uploaded";
      } else {
        print "<br/>Photo not uploaded.";
      }
    }
    else {
      print "<br/>No valid file uploaded.";
  }
 }
?>
