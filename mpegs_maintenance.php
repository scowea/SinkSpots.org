<?php session_start(); 
###################################################################################################
## Written By: 	Scott M. Weaver
## Date: 		2008-01-02
## Notes: 
##
// These are the fields for a record in the `images` table:
// "image_id" 
// "spot_id"
// "image_filename"
// "image_comment"
// "user_name"		
###################################################################################################
$_SESSION['CURRENT_PAGE_FILENAME'] = 'media.php';
$_SESSION['NAV_BUTTON_TEXT'] = 'Media';
include('header.php');
?>
  
<?php 
// if no user has logged in, dont them them add or edit or delete a journal entry...
if ($_SESSION['CURRENT_USER_NAME'] == "")
{
	echo "You must be logged in to add, edit or delete any mpegs.<br>";
	echo "Please <a href=login.php?spot_id=" . $currently_selected_id . ">login</a>.<br><br>";
	die("<p align=center>[<a href=media.php?spot_id=" . $currently_selected_id . "><em>Cancel: Go Back</em></a>]</p>"); 
}

// if no spot is selected, dont let the user do anything....
if (($currently_selected_id == "none") || ($currently_selected_id == ""))
{
	echo "You must select a spot first before adding any mpegs...<br>";
	die("<p align=center>[<a href=media.php><em>Cancel: Go Back</em></a>]</p>"); 
}

// evaluate if this is a add, delete or a edit 
if ($_GET['action'] == 'add' )
{

?>
            <strong>Upload a mpg file of <?php echo $currently_selected_spot; ?></strong> 
            <table>
              <form action="mpegs_commit.php?action=add&spot_id=<?php echo $currently_selected_id; ?>" method="post" enctype="multipart/form-data">
                <tr> 
                  <td><label for="file"><b>Filename:</b></label></td>
                  <td><input type="file" name="file" id="file" /> </td>
                </tr>
                <tr> 
                  <td><b>Comment:</b></td>
                  <td><input type="text" size=60 name="mpeg_comment"/></td>
                </tr>
                <tr> 
                  <td><input type="submit" name="submit" value="Upload MPG" /></td>
                  <td></td>
                </tr>
              </form>
            </table>
            <?php
	
	
}
else if ($_GET['action'] == 'delete' )
{
	// select this spot and populate some vars...
	$row = get_image_record_from_id($_GET['image_id']);

	// make sure this is a valid user ..they could only really get here if they typed the url in with this action...
	if ($_SESSION['ADMIN_USER'] == "") // if this is not the admin...
		if ($_SESSION['CURRENT_USER_NAME'] != $row['user_name']) // and the current user is not the user that created the journal entry...
			die("Only the administrator and the user who created it are authorized to delete this image. Sorry....");
		
	// warn the user on last time before we delete it...
	// warn the user again...
	echo "You are about to delete this image from the database. Do you really want to do this???<br>";

	// we want the inputs on the form to be readonly....
	$read_only = " readonly=true "; 

	echo "
  		 <table border='1'>
		<form action=image_commit.php?spot_id=" . $currently_selected_id . "&image_id=" . $_GET['image_id'] . "&action=delete method=post>
  		  <input name=submit type=submit value='Delete Image' />"; 
?>
            <tr> 
              <td><strong>Image Filename:</strong></td>
              <td><input type="text" name="image_filename" <?php echo $read_only ?> value="<?php echo $row['image_filename'] ?>"/></td>
            </tr>
            <tr> 
              <td><strong>Comment:</strong></td>
              <td><input type="text" name="image_comment" <?php echo $read_only ?> value="<?php echo $row['image_comment'] ?>"/></td>
            </tr></form>
            
      </table>
      <?php			  

	
}
else if ($_GET['action'] == 'update' )
{
	// select this spot and populate some vars...
	$row = get_image_record_from_id($_GET['image_id']);

	// make sure this is a valid user ..they could only really get here if they typed the url in with this action...
	if ($_SESSION['ADMIN_USER'] == "") // if this is not the admin...
		if ($_SESSION['CURRENT_USER_NAME'] != $row['user_name']) // and the current user is not the user that created the journal entry...
			die("Only the administrator and the user who created it are authorized to edit this image. Sorry....");

	// we want the inputs on the form to be edittable, so leave this blank so this attribute is not included in the input tag
	$read_only = "";  

	echo "<table border='1'>
			<form action=image_commit.php?spot_id=" . $currently_selected_id . "&image_id=" . $_GET['image_id'] . "&action=update method=post>
  		  		<input name=submit type=submit value='Update Image' />"; 
?>
      <tr> 
        <td><strong>Image Filename:</strong></td>
        <td><input type="text" name="image_filename" <?php echo $read_only ?> value="<?php echo $row['image_filename'] ?>"/></td>
      </tr>
      <tr> 
        <td><strong>Comment:</strong></td>
        <td><input type="text" name="image_comment" <?php echo $read_only ?> value="<?php echo $row['image_comment'] ?>"/></td>
      </tr></form>
      </table> 
      <?php		  

}
else
	echo "Error: unknown action type of '" . $_GET['action'] ."' was sent to this page. This link you clicked to get here is broken.";
	
?>
      <?php 
echo "<p align=center>[<a href=media.php?spot_id=" . $currently_selected_id . "><em>Cancel: Go Back</em></a>]</p>"; 
?>
    </div>
    <!-- end class="stuff_on_the_right --></td>
    </tr> </table> <br class="clear" />
  </div>
  <!-- end id="body"-->
  <br class="clear" />
</div>
  <!-- end class="container"-->
  <br class="clear" />
  
<div id="footer"> 
  <div id="footHead"> 
    <div class="clear"></div>
  </div>
  <!-- end id="footHead"-->
  <div id="footBody"> 
    <div class="container"> <br>
    </div>
    <div class="clear"></div>
    <div id="copyright"><?php include 'footer.php'; ?>
    </div>
    <!-- id="copyright" -->
  </div>
  <!--- end class="footBody"-->
</div>
  <!--- end id="footer"-->
</div>
<!-- id="wrapper" -->
<img src="images/tab_over.gif" style="display: none; visibility:hidden; width:0; height:0; position:absolute; top: -100px; left: -200px;" alt="" />
</body>
</html>