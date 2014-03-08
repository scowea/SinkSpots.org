<?php session_start(); 
###################################################################################################
## Written By: 	Scott M. Weaver
## Date: 		2008-01-02
## Notes: 
##		
###################################################################################################
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html><head><title>Stream Weaver 3.0 - Beta</title></head>
<body>
<p><big><big><big> <span style="font-weight: bold;">Stream Weaver</span>... 
  </big></big></big> <em>a tool for aquatic exploration...</em></p>
<p></p>

<?php include 'includes/functions.php';  ?>

<hr>

<?php

    // evaluate what are we doing with the spot... 
	if ($_GET['action'] == "update")
	{ 		
		if (($_GET["spot_id"] == "") || ($_GET["spot_id"] == "none")) 
		{
			echo 'There is no mystery spot currently selected. You can only update the latitude and longitude of a selected spot... click the "Add Spot" button instead.';
		}
		else
		{
			// update the record
			db_update_lat_long(
				$_GET["spot_id"],
				$_POST["latitude"],
				$_POST["longitude"]);  	
		}
		
		// get the updated spot id, so we can stick it in the "go home" link at the bottom of this page
		// so this new spot will be loaded onto the front page when we go back there...	
		$spot_id = $_GET["spot_id"];	
		
	} // end if ($_GET['action'] != "update")
	else
		echo "Error: unknown action type of '" . $_GET['action'] ."' so nothing was done to the db.";
?>
<hr>

<?php 
echo "<p align=center>[<a href=explore.php?spot_id=" . $spot_id . "><em>Go Home</em></a>]</p>" ;
?>

<p>&nbsp;</p>

</body></html>