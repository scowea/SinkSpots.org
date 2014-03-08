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
$_SESSION['CURRENT_PAGE_FILENAME'] = 'whats_in.php';
$_SESSION['NAV_BUTTON_TEXT'] = 'Whats In';
include('header.php');
?>
 <!-- Pagetitle -->
        <h1 class="pagetitle">What's In Right Now!...</h1>

        <!-- Content unit - One column -->
        <div class="column1-unit"> 
 
<b>...right now, anywhere in America... </b><br>
<i>All the real time gage data comes from USGS which only covers the USA.</i><br><br>
<?php

	// if no user has logged in, dont them them add or edit or delete a journal entry...
//	if ($_SESSION['CURRENT_USER_NAME'] == "")
//	{
//		echo "You must be logged in to add, edit or delete any images.<br>";
//		echo "Please login: [<a href=login.php>login</a>]<br><br>";
//		die("<p align=center>[<a href=index.php?spot_id=" . $_GET["spot_id"] . "><em>Cancel: Go Back</em></a>]</p>"); 
//	}

 	// what is the spot name? this is ONLY used as a reference in the DB in this journal table..
	// if you want the spot name, get it from the mystery_spot table..
 	$mystery_spot_name = get_mystery_spot_name_from_id($_GET["spot_id"]);
	 
				
	$spot_data_array = build_list_of_spots_that_are_in();	
		
	include ('spots_datagrid.php');
		
		
?>
           
            </div>
            <?php include 'footer.php'; ?>
      