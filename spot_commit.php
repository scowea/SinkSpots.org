<?php session_start(); 
###################################################################################################
## Written By: 	Scott M. Weaver
## Date: 		2008-01-02
## Notes:  
##
// These are the fields for a record in the mystery_spots fields:
// "spot_id"
// "mystery_spot_name" 
// "river" 
// "section" 
// "country"  
// "state"  
// "city"  
// "longitude"  
// "latitude"  
// "gauge_name"  
// "gauge_number" 
// "gauge_url"
// "ideal_min_flow" 
// "ideal_flow" 
// "ideal_max_flow" 
// "flow_type"
// "notes"
// "zoom_level"  		
###################################################################################################
 
###################################################################################################
## Written By: 	Scott M. Weaver
## Date: 		2008-01-02
## Notes:  
#######################################################################################################
$_SESSION['CURRENT_PAGE_FILENAME'] = 'about.php';
$_SESSION['NAV_BUTTON_TEXT'] = 'About';
include('header.php');
?>
<!-- Pagetitle -->
        <h1 class="pagetitle">Spot Maintenance...</h1>

        <!-- Content unit - One column -->
        <div class="column1-unit"> 

          
 
 
              <?php
	// if no user has logged in, dont them them add or edit or delete a mystery spot...
	if ($_SESSION['CURRENT_USER_NAME'] == "")
	{
		echo "You must be logged in to add or edit any mystery spots.<br>";
		echo "Please <a href=login.php?spot_id=" . $currently_selected_id . ">login</a>.<br><br>";
		die("<p align=center>[<a href=index.php?spot_id=" . $currently_selected_id . "><em>Cancel: Go Back</em></a>]</p>"); 
	}
    
	//...........................................................................
	// CLEAN AND VALIDATE THE USER INPUT...
	$mystery_spot_name = trim($_POST["mystery_spot_name"]);  
	$river = trim($_POST["river"]); 
	$country = trim($_POST["country"]); 
	$region = trim($_POST["region"]);
	$state = trim($_POST["state"]);  
	$city = trim($_POST["city"]); 
	
	// strip out any blanks between "-" sign and the numbers..and any blanks around it..
	$longitude = trim(str_replace(' ', '', $_POST["longitude"]));
	$latitude = trim(str_replace(' ', '',$_POST["latitude"])); 
	
	$gauge_name = trim($_POST["gauge_name"]);
	$gauge_number = trim(str_replace(' ', '',$_POST["gauge_number"])); 
	$gauge_url = trim($_POST["gauge_url"]);
	$prediction_url = trim($_POST["prediction_url"]);
	
	$ideal_min_flow = trim(str_replace('cfs', '', $_POST["ideal_min_flow"]));
	$ideal_flow = trim(str_replace('cfs', '', $_POST["ideal_flow"]));
	$ideal_max_flow = trim(str_replace('cfs', '', $_POST["ideal_max_flow"]));
	$ideal_min_flow = str_replace('ft', '', $ideal_min_flow);
	$ideal_flow = str_replace('ft', '', $ideal_flow);
	$ideal_max_flow = str_replace('ft', '', $ideal_max_flow);
	
	$flow_type = trim($_POST["flow_type"]);  
	$notes = trim($_POST["notes"]);
	$spot_quality = trim($_POST["spot_quality"]);
	//.......................................................................................
	
	// evaluate what are we doing with the spot... 
 	if ($_GET['action'] == "add")
	{
			// dont let the user add a blank name...cause if they do, we can never delete it cause there is no link to click on...
			if ($mystery_spot_name == "")
				$mystery_spot_name = "***BLANK***";
				
			// in isert this spot in the db
			db_insert_mystery_spot(
				$mystery_spot_name,  
				$river,  
				$country,
				$region, 
				$state,  
				$city,  
				$longitude,  
				$latitude,  
				$gauge_name,  
				$gauge_number, 
				$gauge_url,
				$prediction_url,
				$ideal_min_flow,
				$ideal_flow,
				$ideal_max_flow,
				$flow_type,  
				$notes,
				$spot_quality);
		
			// get the new spot id, so we can stick it in the "go home" link, so this new spot will 
			// be loaded onto the front page.....	
			$currently_selected_id = get_highest_unique_id_in_table("mystery_spots", "spot_id");
			
		//} // end else ...there are no dups..
	} // end if ($_GET['action'] == "add")
	else if ($_GET['action'] == "update")
	{ 
	 		// dont let the user add a blank name...cause if they do, we can never delete it cause there is no link to click on...
			if ($mystery_spot_name == "")
				$mystery_spot_name = "****BLANK***";
				
			// update the record
			db_update_mystery_spot(
				$currently_selected_id,
				$mystery_spot_name,  
				$river,  
				$country,
				$region, 
				$state,  
				$city,  
				$longitude,  
				$latitude,  
				$gauge_name,  
				$gauge_number, 
				$gauge_url,
				$prediction_url,
				$ideal_min_flow,
				$ideal_flow,
				$ideal_max_flow, 
				$flow_type,  
				$notes,
				$spot_quality);
			
	} // end if ($_GET['action'] != "update")
	else if ($_GET['action'] == "delete")
	{
		// make sure this is a valid user ..they could only really get here if they typed the url in with this action...
		if ($_SESSION['ADMIN_USER'] == "")
			die("Only the administrator is authorized to delete spots. Please request a delete and the administrator will be emailed");
	
		// delete it...
		db_delete_mystery_spot($currently_selected_id, $mystery_spot_name);
		
	} // else if ($_GET['action'] == "delete")
	else if ($_GET['action'] == "request_delete") 
	{
		echo "An email has been sent to the Administrator requesting the delete of this spot: <b>" . $_POST["mystery_spot_name"] . "</b>";
		$message = 'the user ' . $_SESSION['CURRENT_USER_NAME'] . ' just requested the delete of this spot id: ' . $currently_selected_id . ' and this spot name ' . $_POST["mystery_spot_name"];
		$subject = 'delete spot request';
		email_message($message, $subject);
	}
	else
		echo "Error: unknown action type of '" . $_GET['action'] ."' so nothing was done to the db.";
?>
              <hr>
              <?php 
echo "<p align=center>[<a href=index.php?spot_id=" . $currently_selected_id . "><em>Go Home</em></a>]</p>" ;
?>
     </div>
    <?php include 'footer.php'; ?>