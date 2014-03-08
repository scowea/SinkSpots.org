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
		echo "Please login: [<a href=login.php>login</a>]<br><br>";
		die("<p align=center>[<a href=media.php?spot_id=" . $_GET["spot_id"] . "><em>Cancel: Go Back</em></a>]</p>"); 
	}

 	// what is the spot name? this is ONLY used as a reference in the DB in this journal table..
	// if you want the spot name, get it from the mystery_spot table..
 	$mystery_spot_name = get_mystery_spot_name_from_id($_GET["spot_id"]);
	 
	if ($_GET['action'] == "add")
	{ 
		
		// create a new record....
		db_insert_mpeg( 
			$_GET["spot_id"],  
			$_POST["mpeg_comment"], 
			$_SESSION['CURRENT_USER_NAME']);
		
		// go back to the images page for this spot...
		echo "<p align=center>[<a href=media.php?spot_id=" . $currently_selected_id . "><em>Go Back To The Videos</em></a>]</p>";
			
	} // end if ($_GET['action'] == "add")
	else if ($_GET['action'] == "delete")
	{
		// get the journal entry record before we delete it, to grab the username from the record....
		$row = get_image_record_from_id($_GET["image_id"]);	
		
		// make sure this is a valid user ..they could only really get here if they typed the url in with this action...
		if ($_SESSION['ADMIN_USER'] == "") // if this is not the admin...
			if ($_SESSION['CURRENT_USER_NAME'] != $row['user_name']) // and the current user is not the user that created the journal entry...
				die("Only the administrator and the user who created it are authorized to delete this image. Sorry....");

		// kill it...
		db_delete_image($_GET["image_id"]);
		
		// go back to the images page for this spot...
		echo "<p align=center>[<a href=images.php?spot_id=" . $currently_selected_id . "><em>Go Home</em></a>]</p>"; 	

	} // end else if ($_GET['action'] == "delete")
	else if ($_GET['action'] == "update")
	{
		// get the journal entry record before we delete it, to grab the username from the record....
		$row = get_image_record_from_id($_GET["image_id"]);	
		
		// make sure this is a valid user ..they could only really get here if they typed the url in with this action...
		if ($_SESSION['ADMIN_USER'] == "") // if this is not the admin...
			if ($_SESSION['CURRENT_USER_NAME'] != $row['user_name']) // and the current user is not the user that created the journal entry...
				die("Only the administrator and the user who created it are authorized to edit this image. Sorry....");
		
		// update it...
		db_update_image(
			$_GET["image_id"], 
			$_POST["image_filename"],  
			$_POST["image_comment"], 
			$_SESSION['CURRENT_USER_NAME']);
			
		// go back to the details page...
		echo "<p align=center>[<a href=image_details.php?spot_id=" . $currently_selected_id . "&image_id=" . $_GET['image_id'] . "><em>Go Home</em></a>]</p>"; 	
		
	} // end else if ($_GET['action'] == "update")
	else
		echo "Error: unknown action type of '" . $_GET['action'] ."' so nothing was done to the db.";
			
		
?>
              <hr>
            </div>
            <!-- end class="stuff_on_the_right -->
          </td>
        </tr>
      </table>
      <br class="clear" />
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