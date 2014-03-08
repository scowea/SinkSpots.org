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
$_SESSION['CURRENT_PAGE_FILENAME'] = 'images.php';
$_SESSION['NAV_BUTTON_TEXT'] = 'Images';
include('header.php');
?>
  <!-- Pagetitle -->
        <h1 class="pagetitle">Image Maintenance...</h1>

        <!-- Content unit - One column -->
        <div class="column1-unit" 
<?php 
// if no user has logged in, dont them them add or edit or delete a journal entry...
if ($_SESSION['CURRENT_USER_NAME'] == "")
{
	echo "You must be logged in to add, edit or delete any images.<br>";
	echo "Please <a href=login.php?spot_id=" . $currently_selected_id . ">login</a>.<br><br>";
	die("<p align=center>[<a href=images.php?spot_id=" . $currently_selected_id . "><em>Cancel: Go Back</em></a>]</p>"); 
}

// if no spot is selected, dont let the user do anything....
if (($currently_selected_id == "none") || ($currently_selected_id == ""))
{
	echo "You must select a spot first before adding any images...<br>";
	die("<p align=center>[<a href=images.php><em>Cancel: Go Back</em></a>]</p>"); 
}

// evaluate if this is a add, delete or a edit 
if ($_GET['action'] == 'add' )
{

?>
            <strong>Upload a Image of <?php echo $currently_selected_spot; ?></strong> 
            <table>
              <form action="image_commit.php?action=add&spot_id=<?php echo $currently_selected_id; ?>" method="post" enctype="multipart/form-data">
                <tr> 
                  <td><label for="file"><b>Filename:</b></label></td>
                  <td><input type="file" name="file" id="file" /> </td>
                </tr>
                <tr> 
                  <td><b>Comment:</b></td>
                  <td><input type="text" size=60 name="image_comment"/></td>
                </tr>
                <tr> 
                  <td><input type="submit" name="submit" value="Upload Image" /></td>
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
			die("Only the administrator and the user who created it (". $row['user_name'].") are authorized to delete this image. Sorry.... your name is " . $_SESSION['CURRENT_USER_NAME'] . " and neither of the two.<br><br><nobr>[<a href=images.php?spot_id=" . $currently_selected_id . "><em><br>See All Images</em></a>]</nobr>");
		
	// warn the user on last time before we delete it...
	// warn the user again...
	echo "You are about to delete this image from the database. Do you really want to do this???<br>";

	// we want the inputs on the form to be readonly....
	$read_only = " readonly=true "; 

	echo "
  		 <table>
		<form action=image_commit.php?spot_id=" . $currently_selected_id . "&image_id=" . $_GET['image_id'] . "&action=delete method=post>
  		  <input name=submit type=submit value='Delete Image' />"; 
?>
      <tr> 
        <td><strong>Comment:</strong></td>
        <td><input type="text" size=60 name="image_comment" <?php echo $read_only ?> value="<?php echo $row['image_comment'] ?>"/></td>
      </tr>
	 <tr> 
     
	    <td><strong>Image:</strong></td>
        <td><img src="../images/<?php echo $row['spot_id']; ?>/<?php echo $row['image_filename'] ?> "  border="0" />
      </tr>
     </form>
            
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
			die("Only the administrator and the user who created it (". $row['user_name'].") are authorized to delete this image. Sorry.... your name is " . $_SESSION['CURRENT_USER_NAME'] . " and neither of the two.<br><br><nobr>[<a href=images.php?spot_id=" . $currently_selected_id . "><em><br>See All Images</em></a>]</nobr>");

	// we want the inputs on the form to be edittable, so leave this blank so this attribute is not included in the input tag
	$read_only = "";  

	echo "<table>
			<form action=image_commit.php?spot_id=" . $currently_selected_id . "&image_id=" . $_GET['image_id'] . "&action=update method=post>
  		  		<input name=submit type=submit value='Update Image' />"; 
?>
      <tr> 
        <td><strong>Comment:</strong></td>
        <td><input type="text" size=60 name="image_comment" <?php echo $read_only ?> value="<?php echo $row['image_comment'] ?>"/></td>
      </tr>
	  <tr> 
        <td><strong>Image:</strong></td>
        <td><img src="../images/<?php echo $row['spot_id']; ?>/<?php echo $row['image_filename'] ?> " width=75% height=75% border="0" />
      </tr>
     </form>
      </table> 
      <?php		  

}
else
	echo "Error: unknown action type of '" . $_GET['action'] ."' was sent to this page. This link you clicked to get here is broken.";
	
?>
      <?php 
echo "<p align=center>[<a href=images.php?spot_id=" . $currently_selected_id . "><em>Cancel: Go Back</em></a>]</p>"; 
?>
    </div>
    <?php include 'footer.php'; ?>
    