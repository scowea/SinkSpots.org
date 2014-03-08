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
		echo "Please login: [<a href=login.php>login</a>]<br><br>";
		die("<p align=center>[<a href=index.php?spot_id=" . $_GET["spot_id"] . "><em>Cancel: Go Back</em></a>]</p>"); 
	}

 	// what is the spot name? this is ONLY used as a reference in the DB in this journal table..
	// if you want the spot name, get it from the mystery_spot table..
 	$mystery_spot_name = get_mystery_spot_name_from_id($_GET["spot_id"]);
	 
	if ($_GET['action'] == "add")
	{ 
		
		// create a new record....
		db_insert_image( 
			$_GET["spot_id"],  
			$_POST["image_comment"], 
			$_SESSION['CURRENT_USER_NAME']);
		
		// go back to the images page for this spot...
		echo "<p align=center>[<a href=images.php?spot_id=" . $currently_selected_id . "><em>Go Back To The Images</em></a>]</p>";
			
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
		db_delete_image($_GET["spot_id"], $_GET["image_id"]);
		
		// go back to the images page for this spot...
		echo "<p align=center>Success: it is deleted...<br><nobr>[<a href=images.php?spot_id=" . $currently_selected_id . "><em>See All Images</em></a>]</nobr></p>"; 	

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
			$_GET["spot_id"],  
			$_GET["image_id"],   
			$_POST["image_comment"], 
			$_SESSION['CURRENT_USER_NAME']);
			
		// go back to the details page...
		echo "<p align=center>[<a href=image_details.php?spot_id=" . $currently_selected_id . "&image_id=" . $_GET['image_id'] . "><em>See The Image</em></a>]</p>"; 	
		
	} // end else if ($_GET['action'] == "update")
	else
		echo "Error: unknown action type of '" . $_GET['action'] ."' so nothing was done to the db.";
			
		
?>
              <hr>
            </div>
             <?php include 'footer.php'; ?>
      