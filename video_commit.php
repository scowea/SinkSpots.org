<?php session_start(); 
###################################################################################################
## Written By: 	Scott M. Weaver
## Date: 		2008-01-02
## Notes:  
##
// These are the fields for a record in the `exploration_data` table:
// "spot_id" 
// "journal_id"
// "user_name"
// "explore_date"  
// "explore_flow"  
// "quality"  
// "explore_notes"  
// "high_water_event"  		
###################################################################################################
$_SESSION['CURRENT_PAGE_FILENAME'] = 'index.php';
$_SESSION['NAV_BUTTON_TEXT'] = 'Journal';
include('header.php');
?>

 <!-- Pagetitle -->
        <h1 class="pagetitle">Video Maintenance...</h1>

        <!-- Content unit - One column -->
        <div class="column1-unit"> 
              <?php

	// if no user has logged in, dont them them add or edit or delete a journal entry...
	if ($_SESSION['CURRENT_USER_NAME'] == "")
	{
		echo "You must be logged in to add a video.<br>";
		echo "Please <a href=login.php?spot_id=" . $currently_selected_id . ">login</a>.<br><br>";
		die("<p align=center>[<a href=media.php?spot_id=" . $currently_selected_id . "><em>Cancel: Go Back To Videos</em></a>]</p>"); 
	}

    // evaluate what are we doing with the video... 
	if ($_GET['action'] == "add_video")
	{ 		
		if (($currently_selected_id == "") || ($currently_selected_id == "none")) 
		{
			echo "There is no mystery spot currently selected. You can only add a video for a selected spot...sorry.";
		}
		else
		{
			// add the record
			db_add_video(
				$currently_selected_id, // spot id
				$user_name, // user who is logged in
				$_POST["video_url"],
				$_POST["video_comment"]);  	
		}
				
	} // end if ($_GET['action'] != "add_video")
	else if ($_GET['action'] == "update")
	{
	
		// make sure this is a valid user ..they could only really get here if they typed the url in with this action...
		if ($_SESSION['ADMIN_USER'] == "") // if this is not the admin...
			if ($_SESSION['CURRENT_USER_NAME'] != $_POST['user_name']) // and the current user is not the user that created the journal entry...
				die("Only the administrator and the user who created it are authorized to update this video. Sorry....");

		//  update the record
		db_update_video(
			$currently_selected_id, // spot id
			$_GET['video_id'], // video id
			$user_name, // user who is logged in
			$_POST["video_url"],
			$_POST["video_comment"]);  
	
	}
	else if ($_GET['action'] == "delete")
	{
	
		// make sure this is a valid user ..they could only really get here if they typed the url in with this action...
		if ($_SESSION['ADMIN_USER'] == "") // if this is not the admin...
			if ($_SESSION['CURRENT_USER_NAME'] != $_POST['user_name'] ) // and the current user is not the user that created the journal entry...
				die("Only the administrator and the user who created it are authorized to delete this video. Sorry....");

		//  delete the record
		db_delete_video(
			$currently_selected_id, // spot id
			$_GET['video_id']); // video id
	}
	else
		echo "Error: unknown action type of '" . $_GET['action'] ."' so nothing was done to the db.";
?>
              <hr>
              <?php 
	echo "<p align=center>[<a href=media.php?spot_id=" . $currently_selected_id . "><em>Go Back To The Videos</em></a>]</p>" ;
?>
            </div>
            
        <?php include 'footer.php'; ?>
       