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
        <h1 class="pagetitle">Exploration Journal...</h1>

        <!-- Content unit - One column -->
        <div class="column1-unit"> 
<?php

	// if no user has logged in, dont them them add or edit or delete a journal entry...
	if ($_SESSION['CURRENT_USER_NAME'] == "")
	{
		echo "You must be logged in to add, edit or delete any journal entries.<br>";
		echo "Please login: [<a href=login.php>login</a>]<br><br>";
		die("<p align=center>[<a href=index.php?spot_id=" . $_GET["spot_id"] . "><em>Cancel: Go Back</em></a>]</p>"); 
	}

 	// what is the spot name? this is ONLY used as a reference in the DB in this journal table..
	// if you want the spot name, get it from the mystery_spot table..
 	$mystery_spot_name = get_mystery_spot_name_from_id($_GET["spot_id"]);
	
	// evaluate this boolean.....
	if ($_POST["high_water_event"] == "on")
	{
		// A value of zero is considered false. Non-zero values are considered true:
		$flood = 1;
	} 
	else
	{ 
		$flood = 0;
	}
	 
	if ($_GET['action'] == "add")
	{ 
		// create a new record....
		db_insert_journal_entry( 
			$_GET["spot_id"],  
			$mystery_spot_name,
			$_SESSION['CURRENT_USER_NAME'],
			$_POST["explore_date"],  
			$_POST["explore_flow"], 
			$_POST["quality"],  
			$_POST["explore_notes"],  
			$flood);
	} // end if ($_GET['action'] == "add")
	else if ($_GET['action'] == "delete")
	{
		// get the journal entry record before we delete it, to grab the username from the record....
		$row = get_journal_entry_record_from_id($_GET["journal_id"]);	
		
		// make sure this is a valid user ..they could only really get here if they typed the url in with this action...
		if ($_SESSION['ADMIN_USER'] == "") // if this is not the admin...
			if ($_SESSION['CURRENT_USER_NAME'] != $row['user_name']) // and the current user is not the user that created the journal entry...
				die("Only the administrator and the user who created it are authorized to delete this journal entry. Sorry....");

		// kill it...
		db_delete_journal_entry($_GET["journal_id"]);
		
	} // end else if ($_GET['action'] == "delete")
	else if ($_GET['action'] == "request_delete") 
	{
		echo "An email has been sent to the Administrator requesting the delete of the journal entry.";
		$message = 'the user ' . $_SESSION['CURRENT_USER_NAME'] . '\n' . 
			' just requested the delete of a journal entry with this spot id: ' . $_GET["spot_id"] . '\n' .
			' spot name: ' . $mystery_spot_name . '\n' .
			' journal id: ' . $_GET["journal_id"] . '\n' .
			' explore date: ' . $_POST["explore_date"] .  '\n' .
			' explore flow: ' . $_POST["explore_flow"] .  '\n' .
			' quality: ' . $_POST["quality"] .   '\n' .
			' notes: ' . $_POST["explore_notes"];

		$subject = 'delete journal request';
		email_message($message, $subject);
	}
	else if ($_GET['action'] == "update")
	{
		// get the journal entry record before we delete it, to grab the username from the record....
		$row = get_journal_entry_record_from_id($_GET["journal_id"]);	
		
		// make sure this is a valid user ..they could only really get here if they typed the url in with this action...
		if ($_SESSION['ADMIN_USER'] == "") // if this is not the admin...
			if ($_SESSION['CURRENT_USER_NAME'] != $row['user_name']) // and the current user is not the user that created the journal entry...
				die("Only the administrator and the user who created it are authorized to edit this journal entry. Sorry....");
		
		// update it...
		db_update_journal_entry(
		$_GET["journal_id"], 
		$_GET["spot_id"],  
		$mystery_spot_name,
		$_SESSION['CURRENT_USER_NAME'],
		$_POST["explore_date"],  
		$_POST["explore_flow"], 
		$_POST["quality"],  
		$_POST["explore_notes"],  
		$flood);
		
	} // end else if ($_GET['action'] == "update")
	else
		echo "Error: unknown action type of '" . $_GET['action'] ."' so nothing was done to the db.";
			
		
?>
              <hr>
              <?php 
echo "<p align=center>[<a href=index.php?spot_id=" . $currently_selected_id . "><em>Go Home</em></a>]</p>"; 
?>
        </div>
   <?php include 'footer.php'; ?>