<?php 
###################################################################################################
## Written By: 	Scott M. Weaver
## Date: 		2008-01-02
## Notes:  		The following piece of code "include 'includes/functions.php';" must be at the top 
## 				of any pages in order to use any of these functions....
###################################################################################################

//ini_set('error_reporting', 0);
//error_reporting(0);
error_reporting('E_ALL & ~E_DEPRECATED & ~ E_NOTICE');
//error_reporting(1);
ini_set('date.timezone', 'America/Los_Angeles');

$_SESSION['db_name'] = 'sinkspots';
$_SESSION['db_user'] = 'sinkspots';
$_SESSION['db_pass'] = 'slink2Sink!';

// SINCE THIS FUNCTION IS INCLUDED IN EVERY PAGE, WE CAN PUT THE CONNECTION CODE HERE...
db_connect();

//#########################################################################################################
// MISC FUNCTIONS
//#########################################################################################################


function display_icon()
{
	echo "<img src=images/wave.gif width=170 height=150 />";
}

//*********************************************************************************************************
function return_true_false_from_boolean($boolean_value)
{
	if ($boolean_value == 0)
	{
		// A value of zero is considered false. Non-zero values are considered true:
		return "FALSE";
	} 
	else
	{ 
		return "TRUE";
	}
} // end function return_true_false_from_boolean($boolean_value)



//*******************************************************************************************************
// CONNECT TO THE DB
function db_connect()
{

	// connect to localhost Mysql with user / pw
	$con = mysql_connect('sinkspots.db.10211257.hostedresource.com', $_SESSION['db_user'], $_SESSION['db_pass']); 
	
	// did it work?
	if (!$con)
	{
		// no.. error out
		die('Could not Connect to the db: ' . mysql_error());
	}
	
	// success...so select the db..
	mysql_select_db($_SESSION['db_name'], $con); //database
	
	return $con;
} // end function db_connect()

//********************************************************************************************
// DISCONNECT FROM THE DB
// NEVER USE THIS FUNCTION.... PHP AUTOMATTICALLY DISCONNECTS WHEN THE SCRIPT ENDS..
function db_disconnect($con)
{
	// close the connection.
	mysql_close($con);	
} // end function db_disconnect($con)

//*******************************************************************************************************
// if you need just one field from a table, pass in the unique_id of the record, and the table and field
function get_field_from_table(
	$this_field /*field name we want to know*/, 
	$this_table /*table name*/, 
	$this_id /*unique key */,
	$this_unique_field /*field of the unique key in this table*/)
{
	 
	// prevent sql injection.... 
	$this_field = strip_invalid_chars($this_field);
	$this_table = strip_invalid_chars($this_table);
	$this_id = strip_invalid_chars($this_id);
	$this_unique_field = strip_invalid_chars($this_unique_field);
	 
	 
   	// build the query...
	$sql="SELECT * FROM `" . $this_table . "` WHERE `" . $this_unique_field . "` = '" . $this_id . "'";

	// execute it....
	$result = mysql_query($sql);
	if (!$result) // did we get it?
  	{                                                                            
		// handle sql error....
		handle_sql_error("get_field_from_table...", $sql);		
  	}

	//  grab the row... 
	$row = mysql_fetch_array($result, MYSQL_ASSOC); 

	// grab the data out of the row.. 			  
	$this_value = $row[$this_field];   
	
  	// return the row.... assuming we found it....
	return $this_value;
} // end function get_field_from_table(...)

//********************************************************************************************
//You can format Date  by using the below function
//This function will be helpful for formatting the date after obtaining the date from MYSQL , or if you need to display the user a formatted date...
function FormatMyDate($rawdate, $format)
{
	//$rawdate - The Date which should be formatted...
	//$format - The format string....refer the Date function for format String
	
	// create a new DateTime object out of the raw date that just came in
   	$dateTime = new DateTime($rawdate);
	
	// use the date_format func to formate it to what ever you want....mm-dd-yyyy might be nice
    $formatted_date=date_format($dateTime, $format );
	//$formatted_date=date($dateTime, $format );
	// return this formated date to display to the user..
   	return $formatted_date;
}
//************************************************************************************************

function ValidateMyDate($rawMonth, $rawDay, $rawYear)
{
	
	$isDateGood = checkdate($rawMonth, $rawDay, $rawYear);
	return $isDateGood;
	// CODE SNIPPET:		
	//	bool checkdate  ( int $month  , int $day  , int $year  )
	//Checks the validity of the date formed by the arguments. 
	//A date is considered valid if each parameter is properly defined. 
}

//******************************************************************************************************
function email_message($message, $subject)
{
	// this code writes a email..
	$to = "dont_get_trashed@yahoo.com";  // who are we emailing?
	$from = "admin@streamweaver.com";	// who is it from? this will be in the body of the email...
	$headers = "From: $from";
	mail($to,$subject,$message,$headers);
} // end function email_message($message, $subject)
//*************************************************************************************************
function strip_invalid_chars($in_string)
{
	// create array of invalid chars..
	$invalid_chars = array('"',"'");
	
	// strip out this chars that will make a insert or update statement barf....
	$in_string = str_replace($invalid_chars, "", $in_string);
	
	// escape bad stuff...
	$in_string = mysql_real_escape_string($in_string);
	
	// return the valid string so we can stick in in the database...
	return $in_string;
} // end function strip_invalid_chars($in_string)

//***********************************************************************************************************************

function input_contains_invalid_chars($strInput)
{
	// initialize the return var....
	$return_value = false;
	
	// create array of invalid chars..
	$invalid_char1 = '"'; // double quote..
	$invalid_char2 = "'"; // single quote..

	// is this char in the string?
	$pos1 = strpos($strInput, $invalid_char1);

	// Note our use of ===.  Simply == would not work as expected
	// because if the position of '"' was the 0th (first) character.	
	if ($pos1 === false)
	{
    	// the $invalid_char1 was not found....sweet....
		
		// is this other char in the string?
		$pos2 = strpos($strInput, $invalid_char2);
		
		if ($pos2 === false)
		{
			// the $invalid_char1 was not found....sweet....
		}
		else
			// there is this invalid char in the string...
			$return_value =  true; //!!!!!!!!!!!!!!!!!!!!!!!!!
		
	}
	else
		// there is this invalid char in the string...shit..
		$return_value =  true; //!!!!!!!!!!!!!!!!!!!!!!!!
		
	// if we found any of the invalid chars, we are returning true...otherwise false which was initially set in the beginning..
	return $return_value;
		
} // end function input_contains_invalid_chars($strInput)

//*(************************************************************************************************************************
function handle_sql_error($function, $sql)
{
	// create the error message...
	$message = "Error in " . $function . "<br>";
	$message = $message . "sql statement: " . $sql . "<br>";
	$message = $message . "sql error: " . mysql_error(); 
	
	if ($_SESSION['CURRENT_USER_NAME'] == 'weaver')
		die($message);
	
	// send email to admin with this message....
	email_message($message, "sql error");
		
	// ...error out..
  	die('There was an error, sorry. An email has been sent to the Administrator with the details.');
} // end function handle_sql_error($function, $sql)

//***************************************************************************************************************************
function refresh_flow_cache()
{
	// build list of all the gauges in the db...
	$gauge_list = get_list_of_all_gauges(); 
	
	// build the url to request the realtime data for those gauges...
	$url = "http://waterdata.usgs.gov/nwis/current?multiple_site_no=" . $gauge_list . "&result_md=1&parameter_cd=00065,00060,00011,00010,63680,00400&format=rdb";
		
	// this is every gauge in the USA:
	//$url = "http://waterdata.usgs.gov/nwis/current?index_pmcode_DATETIME=1&index_pmcode_00060=2&format=rdb";
		
	// grab the response from usgs that is raw text...
	$page = file_get_contents($url);
	
	// save this data in the session var.... we will only call this function if the user expliciety does this, or if 30mins has gone by..
	$_SESSION["FLOW_CACHE"] = $page; 
	
	// timestamp this...
	//$dateTime = new DateTime(); // if the $last_time was never assigned, then this will just return the current time
   	//$last_time = date_format( localtime(), "m-d-Y g:i:s A" );
	$_SESSION["CACHE_LAST_UPDATED"] = "Last Refreshed: " . date("m-d-Y g:i:s A T"); // this returns MST ..hu? server time?
		
} // end function refresh_flow_cache()

//*******************************************************************************************************8

function write_to_log($table_affected, $field_affected, $spot_id, $sql_statement, $action_taken, $old_value, $new_value, $error_status)
{		 
 	// what time is it?
	$time_stamp = date("Y-m-d G:i:s");
	
	// what user is currently logged in?
	$user_name = $_SESSION['CURRENT_USER_NAME'];
	
	// the old and new values we passed in, were a record(s) from the db... ie an array...so pull the contents back out to put them in the db..
	
	if ($table_affected == 'mystery_spots')
	{
		$old_value = get_array_values($old_value);	
		$new_value = get_array_values($new_value);
	}
	else
	{
		$old_value = strip_invalid_chars($old_value);	
		$new_value = strip_invalid_chars($new_value);
	}
	
	// strip all invalid chars, to prevent the insert statement from puking...
	$time_stamp = strip_invalid_chars($time_stamp); 
	$table_affected = strip_invalid_chars($table_affected);
	$sql_statement = strip_invalid_chars($sql_statement);
	$action_taken = strip_invalid_chars($action_taken);
	$old_value = strip_invalid_chars($old_value);
	$new_value = strip_invalid_chars($new_value);
	$user_name = strip_invalid_chars($user_name);
	$error_status = strip_invalid_chars($error_status);
	
	$field_affected = strip_invalid_chars($field_affected);
	$spot_id = strip_invalid_chars($spot_id);
	
	// build the sql insert statement...
	$sql="INSERT INTO log (
		time_stamp,
		table_affected, 
		sql_statement,
		action_taken, 
		old_value, 
		new_value, 
		user_name,
		error_status,
		spot_id,
		field_affected)
	VALUES (
		'$time_stamp', 
		'$table_affected', 
		'$sql_statement', 
		'$action_taken', 
		'$old_value', 
		'$new_value', 
		'$user_name',
		'$error_status',
		'$spot_id',
		'$field_affected')";
		
	// execute it.... did it work?
	if (!mysql_query($sql))
  	{
		handle_sql_error("write_log_file", $sql);
  	}	

} // end function write_to_log($table_affected, $sql_statement, $action_taken, $old_value, $new_value, $error_status)

//************************************************************************************************************************************************************

function get_array_values($array)
{
	// initialize the return value...
	$strContents = "";
	
	// get all the values out of this array and stick it in a string...
	foreach ($array as $key => $value) 
   		$strContents = $strContents . $key . " -> " . $value . "|";
	
	// if this is not a row in the db.... ie an array, and actually it is a result set, then the string above will be empty... so..
	// pull the rows out of the result set... In reality, these will be journal entries for a spot_id...
	if ($strContents == "")
	{
		// roll through all the rows..
		while ($row = mysql_fetch_array($array, MYSQL_ASSOC)) 
		{
			// for each row..(array).. pull the contents out and put it in a string...
			foreach ($row as $key => $value) 
   				$strContents = $strContents . $key . " -> " . $value . "|";
				
			// heres a delimiter between rows in this result set....	
			$strContents = $strContents . "#|#";
			
		}// end while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 
	
	} // end if ($strContents == "")
	
	// return the string of row contents...
	return $strContents;
}

//#########################################################################################################
// MYSTERY SPOTS
//#########################################################################################################

// These are the fields for a record in the mystery_spots table:
// 01. "spot_id"  ...auto-incremented
// 02. "mystery_spot_name" 
// 03. "river"  
// 04. "region"  
// 05. "state"  
// 06. "city"  
// 07. "longitude"  
// 08. "latitude"  
// 09. "gauge_name"  
// 10. "gauge_number" 
// 11. "gauge_url"
// 12. "ideal_min_flow" 
// 13. "ideal_flow" 
// 14. "ideal_max_flow" 
// 15. "flow_type"
// 16. "notes"  
function db_insert_mystery_spot(
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
	$spot_quality )
{
	//make sure there are no invalid chars...  ...namely a single and double quotes...which will make the sql statement barf...
	$mystery_spot_name = strip_invalid_chars($mystery_spot_name);
	$river = strip_invalid_chars($river);
	$country = strip_invalid_chars($country);
	$region = strip_invalid_chars($region);
	$state = strip_invalid_chars($state);
	$city = strip_invalid_chars($city);
	$longitude = strip_invalid_chars($longitude); 
	$latitude = strip_invalid_chars($latitude);
	$gauge_name = strip_invalid_chars($gauge_name);
	$gauge_number = strip_invalid_chars($gauge_number);
	$gauge_url = strip_invalid_chars($gauge_url);
	$prediction_url = strip_invalid_chars($prediction_url);	
	
	$ideal_min_flow = strip_invalid_chars($ideal_min_flow);
	$ideal_flow = strip_invalid_chars($ideal_flow);
	$ideal_max_flow = strip_invalid_chars($ideal_max_flow);
	
	$flow_type = strip_invalid_chars($flow_type);
	$notes = strip_invalid_chars($notes);
	$spot_quality = strip_invalid_chars($spot_quality); 
	
	// build the sql insert statement...
	$sql="INSERT INTO mystery_spots (
		mystery_spot_name, 
		river, 
		country,
		region, 
		state, 
		city, 
		longitude, 
		latitude, 
		gauge_name, 
		gauge_number, 
		gauge_url,
		prediction_url, 
		ideal_min_flow, 
		ideal_flow, 
		ideal_max_flow, 
		flow_type,
		notes,
		spot_quality)
	VALUES (
		'$mystery_spot_name', 
		'$river', 
		'$country', 
		'$region',
		'$state', 
		'$city', 
		'$longitude', 
		'$latitude', 
		'$gauge_name', 
		'$gauge_number', 
		'$gauge_url',
		'$prediction_url', 
		'$ideal_min_flow', 
		'$ideal_flow', 
		'$ideal_max_flow', 
		'$flow_type', 
		'$notes',
		'$spot_quality')";

	// execute it.... did it work?
	if (!mysql_query($sql))
  	{
		// anytime a user touches the db, write it to a log file....
		write_to_log( "mystery_spots"/*$table_affected*/, "all"/*field_ffected*/, "0"/*spot_id*/, $sql/*$sql_stement*/, "added"/*$action*/, "n/a"/*$old_value*/, "n/a"/*$new_value*/, "ERROR"/*$error_status*/);
		handle_sql_error("db_insert_mystery_spot", $sql);
  	}
	// it worked...echo out a success message to the user..
	echo "Success: '<strong>" . $mystery_spot_name . "</strong>' has been added to the db.";
	
	$spot_id = get_highest_unique_id_in_table("mystery_spots", "spot_id");
	
	// anytime a user touches the db, write it to a log file....
	write_to_log( "mystery_spots"/*$table*/, "all"/*field_ffected*/, $spot_id/*spot_id*/, $sql/*$sql_stement*/, "added"/*$action*/, "n/a"/*$old_value*/, "n/a"/*$new_value*/, "OK"/*$error_status*/);
	
} // end function db_insert_mystery_spot()

//*******************************************************************************************************
// UPDATE A MYSTERY SPOT RECORD IN THE DB
// These are the fields for a record in the mystery_spots table:
// 01. "spot_id"
// 02. "mystery_spot_name" 
// 03. "river"  
// 04. "region"  
// 05. "state"  
// 06. "city"  
// 07. "longitude"  
// 08. "latitude"  
// 09. "gauge_name"  
// 10. "gauge_number" 
// 11. "gauge_url"
// 12. "ideal_min_flow" 
// 13. "ideal_flow" 
// 14. "ideal_max_flow" 
// 15. "flow_type"
// 16. "notes"   

function db_update_mystery_spot(
	$spot_id,
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
	$spot_quality )
{
	//make sure there are no invalid chars...  ...namely a single and double quotes...which will make the sql statement barf...
	$mystery_spot_name = strip_invalid_chars($mystery_spot_name);
	$river = strip_invalid_chars($river);
	$country = strip_invalid_chars($country);
	$region = strip_invalid_chars($region);
	$state = strip_invalid_chars($state);
	$city = strip_invalid_chars($city);
	$longitude = strip_invalid_chars($longitude); 
	$latitude = strip_invalid_chars($latitude);
	$gauge_name = strip_invalid_chars($gauge_name);
	$gauge_number = strip_invalid_chars($gauge_number);
	$gauge_url = strip_invalid_chars($gauge_url);
	$prediction_url = strip_invalid_chars($prediction_url);
	$ideal_min_flow = strip_invalid_chars($ideal_min_flow);
	$ideal_flow = strip_invalid_chars($ideal_flow);
	$ideal_max_flow = strip_invalid_chars($ideal_max_flow);
	$flow_type = strip_invalid_chars($flow_type);
	$notes = strip_invalid_chars($notes);
	$spot_quality = strip_invalid_chars($spot_quality);
	
	// build the sql insert statement...
	$sql="UPDATE mystery_spots 
	SET 
		mystery_spot_name = '" . $mystery_spot_name . "',
		river = '" . $river . "',
		country = '" . $country . "',
		region = '" .  $region . "',
		state = '" . $state . "', 
		city = '" . $city . "', 
		longitude = '" . $longitude . "', 
		latitude = '" . $latitude . "', 
		gauge_name = '" . $gauge_name . "', 
		gauge_number = '" . $gauge_number . "', 
		gauge_url = '" . $gauge_url . "', 
		prediction_url = '" . $prediction_url . "', 
		ideal_min_flow = '" . $ideal_min_flow . "', 
		ideal_flow = '" . $ideal_flow . "', 
		ideal_max_flow = '" . $ideal_max_flow . "', 
		flow_type = '" . $flow_type . "',
		notes = '" . $notes . "',
		spot_quality = '" . $spot_quality . "'
	WHERE 
		spot_id = '" . $spot_id . "'";

	// get the old value for this spot...for the log file...
	$old_value = get_mystery_spots_record_from_id($spot_id);

	// execute it.... did it work?
	if (!mysql_query($sql))
  	{
		// anytime a user touches the db, write it to a log file....
		write_to_log( "mystery_spots"/*$table*/, "all"/*field_ffected*/, $spot_id/*spot_id*/,$sql/*$sql_statement*/, "updated"/*$action*/, $old_value/*$old_value*/, "n/a"/*$new_value*/, "ERROR"/*$error_status*/);
		handle_sql_error("db_update_mystery_spot", $sql);
  	}
	
	// it worked...echo out a success message to the user..
	echo "Success: '<strong>" . $mystery_spot_name . "</strong>' has been updated in the db.";

	// get the new values for this spot....for the log file
	$new_value = get_mystery_spots_record_from_id($spot_id);
	
	// anytime a user touches the db, write it to a log file....
	write_to_log( "mystery_spots"/*$table*/, "all"/*field_ffected*/, $spot_id/*spot_id*/, $sql/*$sql_statement*/, "updated"/*$action*/, $old_value/*$old_value*/, $new_value/*$new_value*/, "OK"/*$error_status*/);
} // end function db_update_mystery_spot()

//***********************************************************************************************************************************
function db_update_zoom_level(
	$spot_id,
	$zoom_level)
{
	//make sure there are no invalid chars...  ...namely a single and double quotes...which will make the sql statement barf...
	$zoom_level = strip_invalid_chars($zoom_level);
	
	// build the sql insert statement...
	$sql="UPDATE mystery_spots 
	SET 		
		zoom_level = '" . $zoom_level . "'
	WHERE 
		spot_id = '" . $spot_id . "'";

	// get old values of row for the log file...
	$old_value = get_mystery_spots_record_from_id($spot_id);

	// execute it.... did it work?
	if (!mysql_query($sql))
  	{
		// anytime a user touches the db, write it to a log file....
		write_to_log( "mystery_spots"/*$table*/, "all"/*field_ffected*/, $spot_id/*spot_id*/, $sql/*$sql_statement*/, "updated"/*$action*/, $old_value/*$old_value*/, "n/a"/*$new_value*/, "ERROR"/*$error_status*/);
		handle_sql_error("db_update_zoom_level", $sql);
  	}
	
	// get new values for this row....for the log file...
	$new_value = get_mystery_spots_record_from_id($spot_id);
	
	// what is the mystery_spot_name of this id? we are going to display it below...
	$mystery_spot_name = get_mystery_spot_name_from_id($spot_id);
	
	// it worked...echo out a success message to the user..
	echo "Success: '<strong>" . $mystery_spot_name . "</strong>' has been updated in the db with the initial zoom level of " . $zoom_level . ".";
	
	// anytime a user touches the db, write it to a log file....
	write_to_log( "mystery_spots"/*$table*/,  "zoom level"/*field_ffected*/, $spot_id/*spot_id*/, $sql/*$sql_statement*/, "updated"/*$action*/, $old_value/*$old_value*/, $new_value/*$new_value*/, "OK"/*$error_status*/);
	
} // end function db_update_zoom_level()

//*************************************************************************************************************************************
function db_update_lat_long(
	$spot_id,
	$latitude,
	$longitude)
{
/*
	//make sure there are no invalid chars...  ...namely a single and double quotes...which will make the sql statement barf...
	$latitude = strip_invalid_chars($latitude);
	$longitude = strip_invalid_chars($longitude);
	
	// build the sql insert statement...
	$sql="UPDATE mystery_spots 
	SET 
		latitude = '" . $latitude . "',		
		longitude = '" . $longitude . "'
	WHERE 
		spot_id = '" . $spot_id . "'";

	// execute it.... did it work?
	if (!mysql_query($sql))
  	{
		handle_sql_error("db_update_lat_long", $sql);
  	}
	
	// what is the mystery_spot_name of this id? we are going to display it below...
	$mystery_spot_name = get_mystery_spot_name_from_id($spot_id);
	
	// it worked...echo out a success message to the user..
	echo "Success: '<strong>" . $mystery_spot_name . "</strong>' has been updated in the db with the latitude of " . $latitude . " and the longitude of " . $longitude . ".";
*/	
} // end function db_update_lat_long()

//*******************************************************************************************************
// this function deletes a record from the mystery_spots table with the corresponding name
function db_delete_mystery_spot($spot_id, $this_name)
{	
	// prevent sql injection
	$spot_id = strip_invalid_chars($spot_id);
	$this_name = strip_invalid_chars($this_name);
	
	// get old values for this row....for the log file...
	$old_value = get_all_journal_entries_from_spot_id($spot_id);
	
	// 1. delete all the journal entries for this spot.
	$sql_journal_entries="DELETE FROM exploration_data WHERE spot_id = '" . $spot_id . "'";
	
	// execute it.... did it work?
	if (!mysql_query($sql_journal_entries))
  	{             
		// anytime a user touches the db, write it to a log file....
		write_to_log( "journal_entries"/*$table*/, "all"/*field_ffected*/, $spot_id/*spot_id*/, $sql_journal_entries/*$sql_statement*/, "deleted all"/*$action*/, $old_value/*$old_value*/, "n/a"/*$new_value*/, "ERROR"/*$error_status*/);                                                               
		handle_sql_error("db_delete_mystery_spot...if (!mysql_query($sql_journal_entries))", $sql_journal_entries);
  	}
				
	// anytime a user touches the db, write it to a log file....
	write_to_log( "journal_entries"/*$table*/, "all"/*field_ffected*/, $spot_id/*spot_id*/, $sql_journal_entries/*$sql_statement*/, "deleted all"/*$action*/, $old_value/*$old_value*/, "n/a"/*$new_value*/, "OK"/*$error_status*/);
	
	// 2. delete the spot...
	// build the sql statement to delete this spot...
	$sql_spot="DELETE FROM mystery_spots WHERE spot_id = '" . $spot_id . "'";

	// get old values for this row....for the log file...
	$old_value = get_mystery_spots_record_from_id($spot_id);

	// execute it.... did it work?
	if (!mysql_query($sql_spot))
  	{
		// anytime a user touches the db, write it to a log file....
		write_to_log( "mystery_spots"/*$table*/, "all"/*field_ffected*/, $spot_id/*spot_id*/,$sql_spot/*$sql_statement*/, "deleted"/*$action*/, $old_value/*$old_value*/, "n/a"/*$new_value*/, "ERROR"/*$error_status*/);
		handle_sql_error("db_delete_mystery_spot...if (!mysql_query($sql_spot))", $sql_spot);
  	}
	
	// it worked...echo out a success message to the user..
	echo "Success: '<strong>" . $this_name . "</strong>' has been deleted from the db.";
	
	// anytime a user touches the db, write it to a log file....
	write_to_log( "mystery_spots"/*$table*/, "all"/*field_ffected*/, $spot_id/*spot_id*/, $sql_spot/*$sql_statement*/, "deleted"/*$action*/, $old_value/*$old_value*/, "n/a"/*$new_value*/, "OK"/*$error_status*/);	
	
} // end function db_delete_mystery_spot()

//******************************************************************************************************
// what is the name of this spot id? the name is not unique...
function get_mystery_spot_name_from_id($spot_id)
{
	// prevent sql injection...
	$spot_id = strip_invalid_chars($spot_id);
	
	//select this mystery spots...
	$sql = "SELECT * FROM `mystery_spots` WHERE spot_id = '" . $spot_id . "'";

	// execute it.... did it work?
	$result = mysql_query($sql);
	if (!$result)
  	{                                                                       
		// handle sql error....
		handle_sql_error("get_mystery_spot_name_from_id($spot_id)", $sql);		
  	}

	// get this row for this spot....
	$row = mysql_fetch_array($result, MYSQL_ASSOC); 

	// get the name field from the row..
	$mystery_spot_name = $row['mystery_spot_name'];   	

	// return the spot name...
	return $mystery_spot_name;
	
} // end get_currently_selected_spot()

//******************************************************************************************************
function get_spot_id_from_url($id)
{
	// if no spot is selected, then just return "none"
	if ($id == "")
	{
		return "none";
	}
	else
	{
		return $id;
	}
} // end function get_spot_id_from_url($id)

//********************************************************************************************************
// this functions returns an array of the data for the record with this id..
function get_mystery_spots_record_from_id($spot_id)	  
{	
	// prevent sql injection...
	$spot_id = strip_invalid_chars($spot_id);
	
	//build this sql statement
	$sql = "SELECT * FROM `mystery_spots` WHERE `spot_id` = '" . $spot_id . "'";
	
	// execute it....
	$result = mysql_query($sql);
	if (!$result) // did we get it?
  	{                                                                            
		// handle sql error....
		handle_sql_error("get_mystery_spots_record_from_id($spot_id)", $sql);		
  	}

	// grab the row...... 
	$row = mysql_fetch_array($result, MYSQL_ASSOC); 
	
	// return the row.... assuming we found it....
	return $row;
} // end function get_mystery_spots_record_from_id($spot_id)

//***********************************************************************************************
function get_num_spots()
{
	// get all the videos...
	$result = mysql_query("SELECT * FROM `mystery_spots` ");
	
	while($record = mysql_fetch_array($result, MYSQL_ASSOC))
		$count = $count + 1;
		
	return $count;
	
}

//***********************************************************************************************************************************
function get_all_coordinates()
{
	// initialize the return value...
	$strCoordinates = "";
	
    //select all mystery spot...
	$sql = "SELECT * FROM `mystery_spots` ORDER BY `mystery_spot_name`";
	 	
	// execute it....
	$result = mysql_query($sql);
	if (!$result) // did we get it?
  	{                                                                            
		// handle sql error....
		handle_sql_error("selecting all spots to add markers..", $sql);		
  	}
	
	// roll through the rest of the record set and build the gauge list...
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 
	{
		// grab the gauge from the db.....
		$latitude = trim(strip_invalid_chars($row['latitude']));
		$longitude = trim(strip_invalid_chars($row['longitude']));
		$mysterySpotName = trim(strip_invalid_chars($row['mystery_spot_name']));
	
		$country = trim(strip_invalid_chars($row['country']));
		$state = trim(strip_invalid_chars($row['state']));
		$city = trim(strip_invalid_chars($row['city']));
		$river = trim(strip_invalid_chars($row['river']));
		$spot_id = trim(strip_invalid_chars($row['spot_id']));

		// is it defined?
		if (($latitude != "") && ($longitude != ""))
		{
		 	// build the return string that we will parse later, in javascript...
			$strCoordinates = $strCoordinates . $longitude . "," . 
				$latitude 			. "," . 
				$mysterySpotName 	. "," . 
				$country 			. "," . 
				$state 				. "," . 
				$city 				. "," . 
				$river 				. "," . 
				$spot_id  .";";	
		}
		
	} // while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 
	
	return $strCoordinates;
	
} // end get_all_coordinates()

//****************************************************************************************************************************
function get_current_flow($gauge_number, $flow_type)
{
	// grab the usgs current data...
	$page = $_SESSION["FLOW_CACHE"];
	
	// split the page string into lines...with the end line as the delimiter..
	$lines = preg_split("/\n/", $page); // the forward slashes are the excape characters...  split it by the endline char...

	// initialize the counter...
	$i = 0; 
	
	// roll through the lines and find this gauge....
	while ($i < count($lines))
	{
		// split this line into words...
		$words = preg_split("/\t/", $lines[$i]); // the forward slashes are the excape characters...  split it by the tab char..
	
		/* HERE ARE THE VALUES OF EACH WORD IN THE LINE:
		//// every gauge has two lines...one for cfs and one for ft...
		echo "word1:" . $words[0] . "<br>"; // USGS
		echo "word2:" . $words[1] . "<br>"; // GAUGE NUMBER...
		echo "word3:" . $words[2] . "<br>";  // Data Descriptor Number
		echo "word4:" . $words[3] . "<br>";  // Parameter Code ....parameter_cd: 00065=ft 00060=cfs
		echo "word5:" . $words[4] . "<br>"; // DATE
		echo "word6:" . $words[5] . "<br>"; // CURRENT FLOW
		*/
		
		// check if we found the gauge we are looking for....
		if ($words[1] == $gauge_number)
		{
			// every gauge has two lines...one for cfs and one for ft...
			// find out what line we are on....
			if (($flow_type == "cfs") && ($words[3] == "00060"))// this is the cfs line
			{
				$current_flow = $words[6]; // get the current flow
				$last_time = $words[4] . $words[5] ; // get the date it was last updated....
				//$i = count($lines); // this will essencially exit the loop...	
			}
			else if (($flow_type == "ft") && ($words[3] == "00065"))// this is the ft line
			{
				$current_flow = $words[6]; // get the current flow
				$last_time = $words[4] . $words[5] ; // get the date it was last updated....
				//$i = count($lines); // this will essencially exit the loop...	
			}
			
			

				
			// temp celcius	
			if ($words[3] == "00010")
				$water_temp_C = $words[6];
			
			// temp fahrenheit
			if ($words[3] == "00011")
				$water_temp_F = $words[6];
				
			// Tuberdity
			if ($words[3] == "63680")
				$water_tuberdity = $words[6];
				
			// PH
			if ($words[3] == "00400")
				$water_ph = $words[6];
				
				
			//$i = count($lines); // this will essencially exit the loop...	
			
		} // if ($words[1] == $gauge_number)

		// increment the counter...
		$i = $i + 1;

	} // end while ($i < count($lines))
		
	// format the $last_time... date("Y-m-d h:i:s A");
	$dateTime = new DateTime($last_time); // if the $last_time was never assigned, then this will just return the current time
   	$last_time = date_format( $dateTime, "m-d-Y g:i:s A" );
	
	// return the current flow, and the time this gauge was updated by usgs...
	$gauge_info = array($current_flow, $last_time, $water_temp_C, $water_temp_F, $water_tuberdity, $water_ph);
	return $gauge_info;
	
} // end function get_current_flow($gauge_number)

//****************************************************************************************************************************8

function get_list_of_all_gauges()
{ 
	//select this mystery spot...
	$sql = "SELECT * FROM `mystery_spots`";
	 	
	// execute it....
	$result = mysql_query($sql);
	if (!$result) // did we get it?
  	{                                                                            
		// handle sql error....
		handle_sql_error("get_list_of_all_gauges()", $sql);		
  	}

	// initialize the return var...
	$gauge_list = "";

	// get the first row...
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	if ($row)
	{
		// there is at least one row... 
		// grab the gauge from the db.....
		$this_gauge = $row['gauge_number'];
		
		// is it defined in the db? 
		// and is it a number?  ctype_digit() returns true if the string contains all numbers... it must be a usgs gauge number or the request to usgs will fail.
		if (($this_gauge != "") && (ctype_digit($this_gauge) == true)) 
		{
			// yes...add it to the string.....ie. start the list...
			$gauge_list = $this_gauge;
		} // end if ($this_gauge != "")
	
	} // end if ($row)

	// roll through the rest of the record set and build the gauge list...
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 
	{
		// grab the gauge from the db.....
		$this_gauge = $row['gauge_number'];
		
		// is it defined in the db? 
		// and is it a number?  ctype_digit() returns true if the string contains all numbers... it must be a usgs gauge number or the request to usgs will fail.
		if (($this_gauge != "") && (ctype_digit($this_gauge) == true)) 
		{
			// yes...add it to the string...
			$gauge_list = $gauge_list . "," . $this_gauge;
		}
		
	} // while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 
  
	// return the comma delimited gauge list...
	return $gauge_list;
} // end function get_list_of_all_gauges()

//************************************************************************************************************
function is_this_spot_in($currently_selected_id, $current_flow)
{
	// get the min and max values from the db, for this spot...
	$min = get_field_from_table('ideal_min_flow' /*field name*/, 'mystery_spots' /*table name*/, $currently_selected_id /*unique id*/, "spot_id" /* name of unique id field in table*/);
	$max = get_field_from_table('ideal_max_flow' /*field name*/, 'mystery_spots' /*table name*/, $currently_selected_id /*unique id*/, "spot_id" /* name of unique id field in table*/);
	
	// evaluate the current flow against what the user has defined in the db as the min and max values
	
	// first lets do the logic if they are both defined....
	if (($min != "") && ($max != ""))
	{ 
		if (($current_flow >= $min) && ($current_flow <= $max))
			$return_value = "YES";
		else
			$return_value = "NO";
	}
	// check to see if the is a max, but no min...
	else if (($min == "") && ($max != ""))
	{
		if ($current_flow <= $max) // if its less than the max, then its IN!
			$return_value = "YES";
		else
			$return_value = "NO";
	}	
	// check to see if the is a min, but no max...
	else if (($min != "") && ($max == ""))
	{
		if ($current_flow >= $min) // if its greater than the min, then its IN!
			$return_value = "YES";
		else
			$return_value = "NO";
	}
	else // both are undefined...
		$return_value = "MAYBE";
			
	return $return_value;
} // end function is_this_spot_in($currently_selected_id, $current_flow)

//*****************************************************************************************************************
function get_color_for_spot($gauge_number, $spot_id, $flow_type)
{
	// get the color for this spot..we will color the link if this spot is "in"
	// get the current flow from usgs...
	$gauge_data = get_current_flow($gauge_number, $flow_type);

	// did we find the gauge?
	if ($gauge_data[0] == "") 
	{
		// no gauge found..... #0000FF is blue
		$color = "#0000FF"; // blue
	}
	else
	{	
		// is this spot in? ..color the text accordingly..
		if (is_this_spot_in($spot_id, $gauge_data[0]) == "YES") // color it green!
		{
			// #00FF00 is light green
			// #00CC00 is med green
			// #009900 is dark green
			$color = "#009900";
		}
		else if (is_this_spot_in($spot_id, $gauge_data[0]) == "NO")// color it red...
		{
			// ..#FF0000 is red
			$color = "#FF0000";			
		}
		else // "MAYBE"
			// no min or max defined........ #0000FF is blue
			$color = "#0000FF"; // blue
		
	}
	
	// return the color...
	return $color;
		
} // end function get_color_for_spot($gauge_number, $spot_id, $flow_type)



//#########################################################################################################
// JOURNAL ENTRIES...
//#########################################################################################################
// INSERT A JOURNAL ENTRY RECORD INTO THE DB
// These are the fields for a record in the `exploration_data` table:
// 01. "journal_id" ...auto incremented
// 02. "spot_id" ...linked to the [mystery_spots] table
// 02. "mystery_spot_name" 
// 03. "explore_date"  
// 04. "explore_flow"  
// 05. "quality"  
// 06. "explore_notes"  
// 07. "high_water_event"  
function db_insert_journal_entry( 
	$spot_id,
	$mystery_spot_name,
	$user_name,
	$explore_date,  
	$explore_flow, 
	$quality,  
	$explore_notes,  
	$high_water_event)
{

	// prevent sql injection...
	//make sure there are no invalid chars...  ...namely a single and double quotes...which will make the sql statement barf...
	$spot_id = strip_invalid_chars($spot_id);
	$mystery_spot_name = strip_invalid_chars($mystery_spot_name);
	$user_name = strip_invalid_chars($user_name);
	$explore_date = strip_invalid_chars($explore_date);
	$explore_flow = strip_invalid_chars($explore_flow);
	$quality = strip_invalid_chars($quality);
	$explore_notes = strip_invalid_chars($explore_notes);  
	$high_water_event = strip_invalid_chars($high_water_event);

	
	// build the sql insert statement...
	$sql="INSERT INTO exploration_data (
		spot_id,
		mystery_spot_name,
		user_name,
		explore_date, 
		explore_flow, 
		quality,  
		explore_notes,  
		high_water_event)
	VALUES (
		'$spot_id',
		'$mystery_spot_name',
		'$user_name',
		'$explore_date', 
		'$explore_flow', 
		'$quality', 
		'$explore_notes', 
		'$high_water_event')";

	// excute it...did it work?
	if (!mysql_query($sql))
  	{
		// anytime a user touches the db, write it to a log file....
		write_to_log( "journal_entries"/*$table*/, "all"/*field_ffected*/, $spot_id/*spot_id*/, $sql/*$sql_statement*/, "added"/*$action*/, "n/a"/*$old_value*/, "n/a"/*$new_value*/, "ERROR"/*$error_status*/);
		handle_sql_error("db_insert_journal_entry...if (!mysql_query($sql))", $sql);
  	}
	
	// display a success message to the user..
	echo "Success: A journal entry for '<strong>" . $mystery_spot_name . "</strong>' has been added to the db.";
	
	// anytime a user touches the db, write it to a log file....
	write_to_log( "journal_entries"/*$table*/, "all"/*field_ffected*/, $spot_id/*spot_id*/, $sql/*$sql_statement*/, "added"/*$action*/, "n/a"/*$old_value*/, "n/a"/*$new_value*/, "OK"/*$error_status*/);

} // end function db_insert_journal_entry()

//*********************************************************************************************************
// UPDATE A JOURNAL ENTRY RECORD IN THE DB
// These are the fields for a record in the `exploration_data` table:
// 01. "unique_id" ...auto incremented
// 02. "mystery_spot_name" 
// 03. "explore_date"  
// 04. "explore_flow"  
// 05. "quality"  
// 06. "explore_notes"  
// 07. "high_water_event"  
function db_update_journal_entry(
	$journal_id, 
	$spot_id,
	$mystery_spot_name,
	$user_name,
	$explore_date,  
	$explore_flow, 
	$quality,  
	$explore_notes,  
	$high_water_event)
{

	//make sure there are no invalid chars...  ...namely a single and double quotes...which will make the sql statement barf...
	$journal_id = strip_invalid_chars($journal_id);
	$spot_id = strip_invalid_chars($spot_id);
	$mystery_spot_name = strip_invalid_chars($mystery_spot_name);
	$user_name = strip_invalid_chars($user_name);
	$explore_date = strip_invalid_chars($explore_date);
	$explore_flow = strip_invalid_chars($explore_flow);
	$quality = strip_invalid_chars($quality);
	$explore_notes = strip_invalid_chars($explore_notes);  
	$high_water_event = strip_invalid_chars($high_water_event);
	
	// build the sql update statement...
	$sql="UPDATE exploration_data 
	SET
		mystery_spot_name = '" . $mystery_spot_name . "',
		user_name = '" . $user_name . "',
		explore_date = '" . $explore_date . "', 
		explore_flow = '" . $explore_flow . "', 
		quality = '" . $quality . "',  
		explore_notes = '" . $explore_notes . "',  
		high_water_event = '" . $high_water_event . "'
	WHERE 
		journal_id = '" . $journal_id . "'";
		
	// get the old value of the journal entry record... for the log file...
	$old_value = get_journal_entry_record_from_id($journal_id);
		
	// excute it...did it work?
	if (!mysql_query($sql))
  	{
		// anytime a user touches the db, write it to a log file....
		write_to_log( "journal_entries"/*$table*/, "all"/*field_ffected*/, $spot_id/*spot_id*/, $sql/*$sql_statement*/, "updated"/*$action*/, $old_value/*$old_value*/, "n/a"/*$new_value*/, "ERROR"/*$error_status*/);
		handle_sql_error("db_update_journal_entry...if (!mysql_query($sql))", $sql);
  	}
		
	// display a success message to the user..
	echo "Success: A journal entry for '<strong>" . $mystery_spot_name . "</strong>' has been updated in the db.";

	// get the old value of the journal entry record... for the log file...
	$new_value = get_journal_entry_record_from_id($journal_id);

	// anytime a user touches the db, write it to a log file....
	write_to_log( "journal_entries"/*$table*/, "all"/*field_ffected*/, $spot_id/*spot_id*/, $sql/*$sql_statement*/, "updated"/*$action*/, $old_value/*$old_value*/, $new_value/*$new_value*/, "OK"/*$error_status*/);

} // end function db_insert_journal_entry()

//**********************************************************************************************************
// this function deletes a record from the exploration table with the corresponding unique_id
function db_delete_journal_entry($journal_id)
{
	// protect from sql injection
	$journal_id = strip_invalid_chars($journal_id);
	
	// get the old value of the journal entry record... for the log file...
	$old_value = get_journal_entry_record_from_id($journal_id);

	// delete this journal entry 
	$sql_journal_entry="DELETE FROM exploration_data WHERE journal_id = '" . $journal_id . "'";
	
	// execute it.... did it work?
	if (!mysql_query($sql_journal_entry))
  	{                                                                            
		// anytime a user touches the db, write it to a log file....
		write_to_log( "journal_entries"/*$table*/, "all"/*field_ffected*/, $_GET['spot_id']/*spot_id*/, $sql_journal_entry/*$sql_statement*/, "deleted"/*$action*/, $old_value/*$old_value*/, "n/a"/*$new_value*/, "ERROR"/*$error_status*/);
		handle_sql_error("db_delete_journal_entry...if (!mysql_query($sql_journal_entry))", $sql_journal_entry);
  	}
		
	// it worked...echo out a success message to the user..
	echo "Success: the journal entry has been deleted from the db.";

	// anytime a user touches the db, write it to a log file....
	write_to_log( "journal_entries"/*$table*/, "all"/*field_ffected*/, $_GET['spot_id']/*spot_id*/, $sql_journal_entry/*$sql_statement*/, "deleted"/*$action*/, $old_value/*$old_value*/, "n/a"/*$new_value*/, "OK"/*$error_status*/);

} // end function db_delete_journal_entry()

//#########################################################################################################
// GATHERINGS...
//#########################################################################################################
// INSERT A GATHERING RECORD INTO THE DB
// These are the fields for a record in the `gatherings` table:
// "gathering_id" ...auto incremented
// "start_date" 
// "end_date" 
// "gathering_name"  
// "gathering_info"  
// "gathering_url"    
function db_insert_gathering( 
	$start_date,
	$end_date,
	$gathering_name,  
	$gathering_info, 
	$gathering_url,
	$spot_id_1, 
	$spot_id_2,
	$spot_id_3,
	$spot_id_4,
	$spot_id_5
	)
{

	//make sure there are no invalid chars...  ...namely a single and double quotes...which will make the sql statement barf...
	$start_date = strip_invalid_chars($start_date);
	$end_date = strip_invalid_chars($end_date);
	$gathering_name = strip_invalid_chars($gathering_name); 
	$gathering_info = strip_invalid_chars($gathering_info);
	$gathering_url = strip_invalid_chars($gathering_url);
	$spot_id = $_GET['spot_id'];
	$spot_id = strip_invalid_chars($spot_id);
	
	// build the sql insert statement...
	$sql="INSERT INTO gatherings (
		start_date,
		end_date,
		gathering_name,  
		gathering_info, 
		gathering_url,
		spot_id_1, 
		spot_id_2,
		spot_id_3,
		spot_id_4,
		spot_id_5
				)
	VALUES (
		'$start_date',
		'$end_date',
		'$gathering_name',  
		'$gathering_info', 
		'$gathering_url', 
		'$spot_id_1', 
		'$spot_id_2',
		'$spot_id_3',
		'$spot_id_4',
		'$spot_id_5'		
				)";

	// excute it...did it work?
	if (!mysql_query($sql))
  	{
		// anytime a user touches the db, write it to a log file....
		write_to_log( "gatherings"/*$table*/, "all"/*field_ffected*/, $spot_id/*spot_id*/, $sql/*$sql_statement*/, "added"/*$action*/, "n/a"/*$old_value*/, "n/a"/*$new_value*/, "ERROR"/*$error_status*/);
		handle_sql_error("db_insert_gathering...if (!mysql_query($sql))", $sql);
  	}
	
	// display a success message to the user..
	echo "Success: This gathering has been added to the db.";
	
	// anytime a user touches the db, write it to a log file....
	write_to_log( "gathering"/*$table*/,"all"/*field_ffected*/, $spot_id/*spot_id*/,  $sql/*$sql_statement*/, "added"/*$action*/, "n/a"/*$old_value*/, "n/a"/*$new_value*/, "OK"/*$error_status*/);

} // end function db_insert_gathering()

//*********************************************************************************************************
// UPDATE A GATHERING RECORD IN THE DB
// These are the fields for a record in the `gatherings` table:
// "gathering_id" ...auto incremented
// "start_date" 
// "end_date" 
// "gathering_name"  
// "gathering_info"  
// "gathering_url"    
function db_update_gathering(
	$gathering_id, 
	$start_date,
	$end_date,
	$gathering_name,  
	$gathering_info, 
	$gathering_url,
	$spot_id_1, 
	$spot_id_2,
	$spot_id_3,
	$spot_id_4,
	$spot_id_5	
	)
{
	//make sure there are no invalid chars...  ...namely a single and double quotes...which will make the sql statement barf...
	$gathering_id = strip_invalid_chars($gathering_id);
	$start_date = strip_invalid_chars($start_date);
	$end_date = strip_invalid_chars($end_date);
	$gathering_name = strip_invalid_chars($gathering_name); 
	$gathering_info = strip_invalid_chars($gathering_info);
	$gathering_url = strip_invalid_chars($gathering_url);
				
	// build the sql update statement...
	$sql="UPDATE gatherings 
	SET
		start_date = '" . $start_date . "',
		end_date = '" . $end_date . "',
		gathering_name = '" . $gathering_name . "', 
		gathering_info = '" . $gathering_info . "', 
		gathering_url = '" . $gathering_url . "',
		spot_id_1 = '" . $spot_id_1 . "', 
		spot_id_2 = '" . $spot_id_2 . "',
		spot_id_3 = '" . $spot_id_3 . "',
		spot_id_4 = '" . $spot_id_4 . "',
		spot_id_5 = '" . $spot_id_5 . "'						
	WHERE 
		gathering_id = '" . $gathering_id . "'";
		
	// get the old value of the journal entry record... for the log file...
	$old_value = get_gathering_record_from_id($gathering_id);
		
	// excute it...did it work?
	if (!mysql_query($sql))
  	{
		// anytime a user touches the db, write it to a log file....
		write_to_log( "gatherings"/*$table*/, "all"/*field_ffected*/, $spot_id/*spot_id*/, $sql/*$sql_statement*/, "updated"/*$action*/, $old_value/*$old_value*/, "n/a"/*$new_value*/, "ERROR"/*$error_status*/);
		handle_sql_error("db_update_gathering...if (!mysql_query($sql))", $sql);
  	}
		
	// display a success message to the user..
	echo "Success: This Gathering has been updated in the db.";

	// get the old value of the journal entry record... for the log file...
	$new_value = get_gathering_record_from_id($gathering_id);

	// anytime a user touches the db, write it to a log file....
	write_to_log( "gatherings"/*$table*/, "all"/*field_ffected*/, $spot_id/*spot_id*/, $sql/*$sql_statement*/, "updated"/*$action*/, $old_value/*$old_value*/, $new_value/*$new_value*/, "OK"/*$error_status*/);

} // end function db_insert_journal_entry()

//**********************************************************************************************************
// this function deletes a record from the exploration table with the corresponding unique_id
function db_delete_gathering($gathering_id)
{
	// prevent from sql injection
	$gathering_id = strip_invalid_chars($gathering_id);
	
	// get the old value of the journal entry record... for the log file...
	$old_value = get_gathering_record_from_id($gathering_id);

	// delete this journal entry 
	$sql="DELETE FROM gatherings WHERE gathering_id = '" . $gathering_id . "'";
	
	// execute it.... did it work?
	if (!mysql_query($sql))
  	{                                                                            
		// anytime a user touches the db, write it to a log file....
		write_to_log( "gatherings"/*$table*/, "all"/*field_ffected*/, $spot_id/*spot_id*/, $sql/*$sql_statement*/, "deleted"/*$action*/, $old_value/*$old_value*/, "n/a"/*$new_value*/, "ERROR"/*$error_status*/);
		handle_sql_error("db_delete_gathering...if (!mysql_query($sql))", $sql);
  	}
		
	// it worked...echo out a success message to the user..
	echo "Success: the gathering has been deleted from the db.";

	// anytime a user touches the db, write it to a log file....
	write_to_log( "gatherings"/*$table*/, "all"/*field_ffected*/, $spot_id/*spot_id*/, $sql/*$sql_statement*/, "deleted"/*$action*/, $old_value/*$old_value*/, "n/a"/*$new_value*/, "OK"/*$error_status*/);

} // end function db_delete_journal_entry()

//#########################################################################################################
// VIDEOS...
//#########################################################################################################

function db_add_video(
	$spot_id, // spot id
	$user_name, // user who is logged in
	$video_url,
	$video_comment)
{

	//make sure there are no invalid chars...  ...namely a single and double quotes...which will make the sql statement barf...
	$spot_id = strip_invalid_chars($spot_id);
	$user_name = strip_invalid_chars($user_name);
	$video_url = strip_invalid_chars($video_url);
	$video_comment = strip_invalid_chars($video_comment);
	
	// todays date:
	$date_added = date("Y-m-d");
	
	// build the sql insert statement...
	$sql="INSERT INTO videos (
		spot_id,
		user_name,
		video_url, 
		video_comment,
		date_added
		)
	VALUES (
		'$spot_id',
		'$user_name',
		'$video_url',
		'$video_comment',
		'$date_added'
	)";

	// excute it...did it work?
	if (!mysql_query($sql))
  	{
		// anytime a user touches the db, write it to a log file....
		write_to_log( "videos"/*$table*/, "all"/*field_ffected*/, $spot_id/*spot_id*/, $sql/*$sql_statement*/, "added"/*$action*/, "n/a"/*$old_value*/, "n/a"/*$new_value*/, "ERROR"/*$error_status*/);
		handle_sql_error("db_add_video...if (!mysql_query($sql))", $sql);
  	}
	
	// display a success message to the user..
	$mystery_spot_name = get_mystery_spot_name_from_id($spot_id);
	echo "Success: Your video of '<strong>" . $mystery_spot_name . "</strong>' has been added to the db.";

	// anytime a user touches the db, write it to a log file....
	write_to_log( "videos"/*$table*/, "all"/*field_ffected*/, $spot_id/*spot_id*/, $sql/*$sql_statement*/, "added"/*$action*/, "n/a"/*$old_value*/, "n/a"/*$new_value*/, "OK"/*$error_status*/);
		
} // end function db_add_video

//*********************************************************************************************************
// example of call:
//		db_update_video(
//			$currently_selected_id, // spot id
//			$_GET['video_id'], // video id
//			$user_name, // user who is logged in
//			$_POST["video_url"],
//			$_POST["video_comment"]);  
function db_update_video(
	$spot_id, 
	$video_id,
	$user_name,
	$video_url,  
	$video_comment)
{
	//make sure there are no invalid chars...  ...namely a single and double quotes...which will make the sql statement barf...
	$spot_id = strip_invalid_chars($spot_id);
	$video_id = strip_invalid_chars($video_id);
	$user_name = strip_invalid_chars($user_name);
	$video_url = strip_invalid_chars($video_url);
	$video_comment = strip_invalid_chars($video_comment);
					
					
	// replace the <object> tag with the one we want..				
					
					
	// build the sql update statement...
	$sql="UPDATE videos 
	SET		 
		video_url = '" . $video_url . "', 
		video_comment = '" . $video_comment . "'
	WHERE 
		video_id = '" . $video_id . "'";
		
	// get the old value of the journal entry record... for the log file...
	$old_value = get_video_record_from_id($video_id);
		
	// excute it...did it work?
	if (!mysql_query($sql))
  	{
		// anytime a user touches the db, write it to a log file....
		write_to_log( "videos"/*$table*/,"all"/*field_ffected*/, $spot_id/*spot_id*/,  $sql/*$sql_statement*/, "updated"/*$action*/, $old_value/*$old_value*/, "n/a"/*$new_value*/, "ERROR"/*$error_status*/);
		handle_sql_error("db_update_videos...", $sql);
  	}
		
	// display a success message to the user..
	echo "Success: The video has been updated in the db.";

	// get the old value of the journal entry record... for the log file...
	$new_value = get_video_record_from_id($video_id);

	// anytime a user touches the db, write it to a log file....
	write_to_log( "videos"/*$table*/, "all"/*field_ffected*/, $spot_id/*spot_id*/, $sql/*$sql_statement*/, "updated"/*$action*/, $old_value/*$old_value*/, $new_value/*$new_value*/, "OK"/*$error_status*/);

} // end function db_insert_journal_entry()

//*********************************************************************************************
// this function deletes a record from the video table with the corresponding unique_id
//  example of call:
//		db_delete_video(
//			$currently_selected_id, // spot id
//			$_GET['video_id']); // video id
function db_delete_video($spot_id, $video_id)
{
	// prevent from sql injection
	$spot_id = strip_invalid_chars($spot_id);
	$video_id = strip_invalid_chars($video_id);
	
	// get the old value of the journal entry record... for the log file...
	$old_value = get_video_record_from_id($video_id);

	// delete this journal entry 
	$sql="DELETE FROM videos WHERE video_id = '" . $video_id . "'";
	
	// execute it.... did it work?
	if (!mysql_query($sql))
  	{                                                                            
		// anytime a user touches the db, write it to a log file....
		write_to_log( "videos"/*$table*/, "all"/*field_ffected*/, $spot_id/*spot_id*/, $sql/*$sql_statement*/, "deleted"/*$action*/, $old_value/*$old_value*/, "n/a"/*$new_value*/, "ERROR"/*$error_status*/);
		handle_sql_error("db_delete_video...", $sql);
  	}
		
	// it worked...echo out a success message to the user..
	echo "Success: the video has been deleted from the db.";

	// anytime a user touches the db, write it to a log file....
	write_to_log( "videos"/*$table*/, "all"/*field_ffected*/, $spot_id/*spot_id*/, $sql/*$sql_statement*/, "deleted"/*$action*/, $old_value/*$old_value*/, "n/a"/*$new_value*/, "OK"/*$error_status*/);

} // end function db_delete_journal_entry()

//#########################################################################################################
// LINKS...
//#########################################################################################################

function db_add_link(
	$user_name,
	$link_url,
	$link_label)
{

	//make sure there are no invalid chars...  ...namely a single and double quotes...which will make the sql statement barf...
	$user_name = strip_invalid_chars($user_name);
	$link_url = strip_invalid_chars($link_url);
	$link_label = strip_invalid_chars($link_label);
	
	// todays date:
	$date_added = date("Y-m-d");
	
	// build the sql insert statement...
	$sql="INSERT INTO links (
		link_url, 
		link_label,
		user_name,
		date_added
		)
	VALUES (
		'$link_url',
		'$link_label',
		'$user_name',
		'$date_added'
	)";

	// excute it...did it work?
	if (!mysql_query($sql))
  	{
		// anytime a user touches the db, write it to a log file....
		write_to_log( "links"/*$table*/, "all"/*field_ffected*/, $spot_id/*spot_id*/, $sql/*$sql_statement*/, "added"/*$action*/, $link_label/*$old_value*/, $link_url/*$new_value*/, "ERROR"/*$error_status*/);
		handle_sql_error("db_add_link..", $sql);
  	}
	
	// display a success message to the user..
	//$mystery_spot_name = get_mystery_spot_name_from_id($spot_id);
	echo "Success: Your link has been added to the db.";

	// anytime a user touches the db, write it to a log file....
	write_to_log( "links"/*$table*/, "all"/*field_ffected*/, $spot_id/*spot_id*/, $sql/*$sql_statement*/, "added"/*$action*/, $link_label/*$old_value*/, $link_url/*$new_value*/, "OK"/*$error_status*/);
		
} // end function db_add_video

//*********************************************************************************************************
// example of call:
//		db_update_video(
//			$currently_selected_id, // spot id
//			$_GET['video_id'], // video id
//			$user_name, // user who is logged in
//			$_POST["video_url"],
//			$_POST["video_comment"]);  
function db_update_link(
	$spot_id, 
	$video_id,
	$user_name,
	$video_url,  
	$video_comment)
{
	//make sure there are no invalid chars...  ...namely a single and double quotes...which will make the sql statement barf...
	$spot_id = strip_invalid_chars($spot_id);
	$video_id = strip_invalid_chars($video_id);
	$user_name = strip_invalid_chars($user_name);
	$video_url = strip_invalid_chars($video_url);
	$video_comment = strip_invalid_chars($video_comment);
					
	// build the sql update statement...
	$sql="UPDATE videos 
	SET		 
		video_url = '" . $video_url . "', 
		video_comment = '" . $video_comment . "'
	WHERE 
		video_id = '" . $video_id . "'";
		
	// get the old value of the journal entry record... for the log file...
	$old_value = get_video_record_from_id($video_id);
		
	// excute it...did it work?
	if (!mysql_query($sql))
  	{
		// anytime a user touches the db, write it to a log file....
		write_to_log( "videos"/*$table*/,"all"/*field_ffected*/, $spot_id/*spot_id*/,  $sql/*$sql_statement*/, "updated"/*$action*/, $old_value/*$old_value*/, "n/a"/*$new_value*/, "ERROR"/*$error_status*/);
		handle_sql_error("db_update_videos...", $sql);
  	}
		
	// display a success message to the user..
	echo "Success: The video has been updated in the db.";

	// get the old value of the journal entry record... for the log file...
	$new_value = get_video_record_from_id($video_id);

	// anytime a user touches the db, write it to a log file....
	write_to_log( "videos"/*$table*/, "all"/*field_ffected*/, $spot_id/*spot_id*/, $sql/*$sql_statement*/, "updated"/*$action*/, $old_value/*$old_value*/, $new_value/*$new_value*/, "OK"/*$error_status*/);

} // end function db_insert_journal_entry()

//*********************************************************************************************
// this function deletes a record from the video table with the corresponding unique_id
//  example of call:
//		db_delete_video(
//			$currently_selected_id, // spot id
//			$_GET['video_id']); // video id
function db_delete_link($spot_id, $video_id)
{
	// protect from sql injection
	$spot_id = strip_invalid_chars($spot_id);
	$video_id = strip_invalid_chars($video_id);
	
	// get the old value of the journal entry record... for the log file...
	$old_value = get_video_record_from_id($video_id);

	// delete this journal entry 
	$sql="DELETE FROM videos WHERE video_id = '" . $video_id . "'";
	
	// execute it.... did it work?
	if (!mysql_query($sql))
  	{                                                                            
		// anytime a user touches the db, write it to a log file....
		write_to_log( "videos"/*$table*/, "all"/*field_ffected*/, $spot_id/*spot_id*/, $sql/*$sql_statement*/, "deleted"/*$action*/, $old_value/*$old_value*/, "n/a"/*$new_value*/, "ERROR"/*$error_status*/);
		handle_sql_error("db_delete_video...", $sql);
  	}
		
	// it worked...echo out a success message to the user..
	echo "Success: the video has been deleted from the db.";

	// anytime a user touches the db, write it to a log file....
	write_to_log( "videos"/*$table*/, "all"/*field_ffected*/, $spot_id/*spot_id*/, $sql/*$sql_statement*/, "deleted"/*$action*/, $old_value/*$old_value*/, "n/a"/*$new_value*/, "OK"/*$error_status*/);

} // end function db_delete_journal_entry()

//#########################################################################################################
// IMAGES
//#########################################################################################################
/* Example of call to function:
db_insert_image( 
			$_GET["spot_id"],  
			$_POST["image_comment"], 
			$_SESSION['CURRENT_USER_NAME']);
*/
function db_insert_image(
	$spot_id, // spot id
	$image_comment,
	$user_name) // user who is logged in
{

	//make sure there are no invalid chars...  ...namely a single and double quotes...which will make the sql statement barf...
	$spot_id = strip_invalid_chars($spot_id);
	$user_name = strip_invalid_chars($user_name);
	$image_filename = $_FILES["file"]["name"];
	$image_comment = strip_invalid_chars($image_comment);
	
	$mystery_spot_name = get_mystery_spot_name_from_id($spot_id);
	
	// todays date:
	$date_added = date("Y-m-d H:i:s");	

	// build the sql insert statement...
	$sql="INSERT INTO images (
		spot_id,
		user_name,
		image_filename, 
		image_comment,
		date_added
		)
	VALUES (
		'$spot_id',
		'$user_name',
		'$image_filename',
		'$image_comment',
		'$date_added'
	)";
	
	// echo out the sql while im debugging...
	//echo "sql: " . $sql . "<BR><BR>";

	// echo out the filetype...
	$file_type = trim(strtolower($_FILES["file"]["type"])); 
	//echo "Type: " . $file_type . "<br />";
	
	//...............................................
	//NOW ..upload the image..
	// make sure the file is in the proper format...
	if (($file_type != "image/gif") && ($file_type != "image/jpeg") && ($file_type != "image/pjpeg"))
		echo "Invalid file type of $file_type";
	else if ($_FILES["file"]["size"] > 10000000)
		echo "The filesize is " . $_FILES["file"]["size"] . " and it must be under 10000000";
	else
	{
		// was there an error uploading the file?
  		if ($_FILES["file"]["error"] > 0)
    		echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
  		else
    	{
			// echo out to the user what just happened...
    		// echo "Type: " . $_FILES["file"]["type"] . "<br />";
    		//echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
    		//echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br /><br>";
			
			// build path to file
			$filepath = "images/" . $spot_id . "/";
			
			// if this filename already exists in the spot we are going to move it to... then...
    		if (file_exists($filepath . $_FILES["file"]["name"]))
			{
				echo "Upload Failed: " . $_FILES["file"]["name"] . "<br />";
				echo $_FILES["file"]["name"] . " already exists. " . "<br />"; // tell the user its already there..
    		}		
			else
      		{
			
				// make the directory structure if it doesnt already exist..ie its a new spot..no images yet...
				$mkdir_value = mkdir($filepath);
				$mkdir_value = mkdir($filepath . 'thumbs/');
				
				// you have to chmod the dir to 777 ..make it full read/write/execute			
				chmod($filepath, 0777);
				chmod($filepath . 'thumbs/', 0777);
				
				if ($mkdir_value == true)
					echo "Sweet: A folder was created for " . $mystery_spot_name . " to store the images on the server.<br>" ;
				else
					echo "Sweet: " . $mystery_spot_name . " already has a folder at " . $filepath .  " to store the images on the server.<BR>" ;
				
				echo "Successfully Uploaded: " . $_FILES["file"]["name"] . "<br />";
					
				// move the file from the temp space, over to where we want it...
				// the file in the tmp space gets deleted whtn the script ends...
      			move_uploaded_file($_FILES["file"]["tmp_name"], $filepath . $_FILES["file"]["name"]);
      		
				// you have to chmod the file to 777 as well as make sure the destination dir is chmod777			
				chmod($filepath . $_FILES["file"]["name"],0777);
				
				
				// call createThumb function and pass to it as parameters the path
				// to the directory that contains images, the path to the directory
				// in which thumbnails will be placed and the thumbnail's width.
				// We are assuming that the path will be a relative path working
				// both in the filesystem, and through the web for links
				createThumb($filepath,$filepath . 'thumbs/',$_FILES["file"]["name"],500);
				
				// confirm where it is....
      			// echo "Stored in: " . $filepath . $_FILES["file"]["name"];
				
      		} // end else
    	} // end else
  	} // end if...blah blah blah blah...	

	//echo $filepath;
	//..............................................................................................	
	
	// excute it...did it work?

	if (!mysql_query($sql))
  	{
		echo "<br><br>";
	
		// anytime a user touches the db, write it to a log file....
		write_to_log( "images"/*$table*/, "all"/*field_ffected*/, $spot_id/*spot_id*/, $sql/*$sql_statement*/, "added"/*$action*/, "n/a"/*$old_value*/, "n/a"/*$new_value*/, "ERROR"/*$error_status*/);
		handle_sql_error("db_insert_image", $sql);
  	}
	else	
	{
		// display a success message to the user..
		
		echo "<br><br>Success: Your image of '<strong>" . $mystery_spot_name . "</strong>' has been added to the db.";

		// anytime a user touches the db, write it to a log file....
		write_to_log( "images"/*$table*/, "all"/*field_ffected*/, $spot_id/*spot_id*/, $sql/*$sql_statement*/, "added"/*$action*/, "n/a"/*$old_value*/, "n/a"/*$new_value*/, "OK"/*$error_status*/);
	}	
} // end function db_add_video

function createThumb( $pathToImages, $pathToThumbs, $filename, $thumbWidth )
{
	echo '<br>pathtoimage: ' . $pathToImages;
	echo '<br>pathtothumb: ' . $pathToThumbs;
	echo '<br>filename: ' .	$filename;
	echo '<br>thumbWidth:'.$thumbWidth;
		
    // parse path for the extension
    $info = pathinfo($pathToImages . $filename);
    
    echo '<br> <pre>' . print_r($info, true) . '</pre>';
    
    echo '<br>ext: ' . $info['extension'];
    // continue only if this is a JPEG image
    if ( strtolower($info['extension']) == 'jpg' )
    {
      echo "<br>Creating thumbnail for " . $pathToImages . $filename ;
	
      // load image and get image size
      $img = imagecreatefromjpeg( "{$pathToImages}{$filename}" );
      
      $width = imagesx( $img );
      $height = imagesy( $img );

      // calculate thumbnail size
      $new_width = $thumbWidth;
      $new_height = floor( $height * ( $thumbWidth / $width ) );

      // create a new temporary image
      $tmp_img = imagecreatetruecolor( $new_width, $new_height );

      // copy and resize old image into new image
      imagecopyresized( $tmp_img, $img, 0, 0, 0, 0, $new_width, $new_height, $width, $height );

      // save thumbnail into a file
      imagejpeg( $tmp_img, "{$pathToThumbs}{$filename}" );

      chmod($pathToThumbs . $filename,0777);
      echo "Success!<br />";
    }
    

}

function datafix_create_thumbs_for_all_images()
{
	
	// build the sql statement...
	$sql = "SELECT * FROM `images` ORDER BY `spot_id` ASC";
	
	// execute it.... did it work?
	$result = mysql_query($sql);
	 
	if (!$result)
	{                                                                          
		write_to_log( "users"/*$table*/, $sql/*$sql_statement*/, "build_image_list"/*$action*/, "n/a"/*$old_value*/, "n/a"/*$new_value*/, "ERROR"/*$error_status*/);
		// handle sql error....
		handle_sql_error("build_image_list", $sql);		
	}
	else
	{
		$num=mysql_numrows($result); // num is the total number of rows (images) for this spot...
	 
	}
	
	echo '<h1>count!'.$num . "</h1>";
		
	while($row = mysql_fetch_array($result, MYSQL_ASSOC))
	{
			
		$spot_id = $row['spot_id'];
		$filename = $row['image_filename'];
			
		// build path to file
		$filepath = "images/" . $spot_id . "/";
		chmod($filepath, 0777);
		
		// make the directory structure if it doesnt already exist..ie its a new spot..no images yet...	
		$mkdir_value = mkdir($filepath . 'thumbs/');
				
		// you have to chmod the dir to 777 ..make it full read/write/execute			
		chmod($filepath . 'thumbs/', 0777);
			
		// call createThumb function and pass to it as parameters the path
		// to the directory that contains images, the path to the directory
		// in which thumbnails will be placed and the thumbnail's width.
		// We are assuming that the path will be a relative path working
		// both in the filesystem, and through the web for links
		//createThumb($filepath,$filepath . 'thumbs/',$filename,500);		
      	//createThumb($filepath,$filepath . 'thumbs/',$filename,200);		
      	
      	//........................
      	// delete the thumbs!!!!!!11
      	$delete_success = unlink($filepath . 'thumbs/'. $filename);
      	if (!$delete_success)
      		echo "didnt delete" . $filepath . 'thumbs/'. $filename. '<BR>';
      	else
      		echo "SUCCESS: deleted" . $filepath . 'thumbs/'. $filename . '<BR>';
      	
      	createThumb($filepath,$filepath . 'thumbs/',$filename,200);	
      	
  	} // end if...blah blah blah blah...	
	
}

//*********************************************************************************************************
// example of call:
//		db_update_video(
//			$currently_selected_id, // spot id
//			$_GET['video_id'], // video id
//			$user_name, // user who is logged in
//			$_POST["video_url"],
//			$_POST["video_comment"]);  
function db_update_image( 
	$spot_id,
	$image_id,
	$image_comment,
	$user_name)
{

 	//make sure there are no invalid chars...  ...namely a single and double quotes...which will make the sql statement barf...
	$image_id = strip_invalid_chars($image_id);
	$user_name = strip_invalid_chars($user_name);
	$image_comment = strip_invalid_chars($image_comment);
	 
	// build the sql update statement...
	$sql="UPDATE images 
	SET		 	
		image_comment = '" . $image_comment . "'	
	WHERE 
		image_id = '" . $image_id . "'";
		
	// get the old value of the journal entry record... for the log file...
	$old_value = get_image_record_from_id($image_id);
		
	// excute it...did it work?
	if (!mysql_query($sql))
  	{
		// anytime a user touches the db, write it to a log file....
		write_to_log( "images"/*$table*/, "all"/*field_ffected*/, $spot_id/*spot_id*/, $sql/*$sql_statement*/, "updated"/*$action*/, $old_value/*$old_value*/, "n/a"/*$new_value*/, "ERROR"/*$error_status*/);
		handle_sql_error("db_update_images", $sql);
  	}
		
	// display a success message to the user..
	echo "Success: The image has been updated in the db.";

	// get the old value of the journal entry record... for the log file...
	$new_value = get_image_record_from_id($image_id);

	// anytime a user touches the db, write it to a log file....
	write_to_log( "images"/*$table*/, "all"/*field_ffected*/, $spot_id/*spot_id*/, $sql/*$sql_statement*/, "updated"/*$action*/, $old_value/*$old_value*/, $new_value/*$new_value*/, "OK"/*$error_status*/);

} // end function db_insert_journal_entry()

//*********************************************************************************************
// this function deletes a record from the video table with the corresponding unique_id
//  example of call:
//		db_delete_video(
//			$currently_selected_id, // spot id
//			$_GET['video_id']); // video id
function db_delete_image($spot_id, $image_id)
{
	// protect from sql injection
	$image_id = strip_invalid_chars($image_id);
	
	//echo "inside db_delete_image<br>image_id = " . $image_id . " <br>spot_id=" . $spot_id . "<br>";
	// get the old value of the journal entry record... for the log file...
	$old_value = get_image_record_from_id($image_id);

	// delete this journal entry 
	$sql="DELETE FROM images WHERE image_id = '" . $image_id . "'";
	
	// execute it.... did it work?
	if (!mysql_query($sql))
  	{                                                                            
		// anytime a user touches the db, write it to a log file....
		write_to_log( "images"/*$table*/, "all"/*field_ffected*/, $spot_id/*spot_id*/,$sql/*$sql_statement*/, "deleted"/*$action*/, $old_value/*$old_value*/, "n/a"/*$new_value*/, "ERROR"/*$error_status*/);
		handle_sql_error("db_delete_video...", $sql);
  	}
		
	// it worked...echo out a success message to the user..
	echo "Success: the image has been deleted from the db.";

	// anytime a user touches the db, write it to a log file....
	write_to_log( "images"/*$table*/, "all"/*field_ffected*/, $spot_id/*spot_id*/, $sql/*$sql_statement*/, "deleted"/*$action*/, $old_value/*$old_value*/, "n/a"/*$new_value*/, "OK"/*$error_status*/);

} // end function db_delete_journal_entry()

//#########################################################################################################
// IMAGES
//#########################################################################################################
/* Example of call to function:
db_insert_image( 
			$_GET["spot_id"],  
			$_POST["image_comment"], 
			$_SESSION['CURRENT_USER_NAME']);
*/
function db_insert_mpegs(
	$spot_id, // spot id
	$video_comment,
	$user_name) // user who is logged in
{

	//make sure there are no invalid chars...  ...namely a single and double quotes...which will make the sql statement barf...
	$spot_id = strip_invalid_chars($spot_id);
	$user_name = strip_invalid_chars($user_name);
	$video_filename = $_FILES["file"]["name"];
	$video_comment = strip_invalid_chars($video_comment);
	
	$mystery_spot_name = get_mystery_spot_name_from_id($spot_id);
	
	// todays date:
	$date_added = date("Y-m-d H:i:s");	

	// build the sql insert statement...
	$sql="INSERT INTO mpegs (
		spot_id,
		user_name,
		video_filename, 
		video_comment,
		date_added
		)
	VALUES (
		'$spot_id',
		'$user_name',
		'$video_filename',
		'$video_comment',
		'$date_added'
	)";
	
	// echo out the sql while im debugging...
	echo "sql: " . $sql . "<BR><BR>";

	// echo out the filetype...
	$file_type = trim(strtolower($_FILES["file"]["type"])); 
	echo "Type: " . $file_type . "<br />";
	
	//...............................................
	//NOW ..upload the image..
	// make sure the file is in the proper format...
	if (($file_type != "video/mpeg")) //&& ($file_type != "image/jpeg") && ($file_type != "image/pjpeg"))
		echo "Invalid file type of $file_type. It must be a mpeg or mpg, im sorry...";
	else if ($_FILES["file"]["size"] > 10000000)
		echo "The filesize is " . $_FILES["file"]["size"] . " and it must be under 10000000";
	else
	{
		// was there an error uploading the file?
  		if ($_FILES["file"]["error"] > 0)
    		echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
  		else
    	{
			// echo out to the user what just happened...
    //		echo "Type: " . $_FILES["file"]["type"] . "<br />";
    		echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
    		echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br /><br>";
			
			// build path to file
			$filepath = "mpegs/" . $spot_id . "/";
			
			// if this filename already exists in the spot we are going to move it to... then...
    		if (file_exists($filepath . $_FILES["file"]["name"]))
			{
				echo "Upload Failed: " . $_FILES["file"]["name"] . "<br />";
				echo $_FILES["file"]["name"] . " already exists. " . "<br />"; // tell the user its already there..
    		}		
			else
      		{
			
				// make the directory structure if it doesnt already exist..ie its a new spot..no images yet...
				$mkdir_value = mkdir($filepath);
				
				// you have to chmod the dir to 777 ..make it full read/write/execute			
				chmod($filepath, 0777);
				
				if ($mkdir_value == true)
					echo "A folder was created for " . $mystery_spot_name . " to store the mpegs on the server.<br>" ;
				else
					echo $mystery_spot_name . " already has a folder at " . $filepath .  " to store the mpegs on the server.<BR>" ;
				
				echo "Successfully Uploaded: " . $_FILES["file"]["name"] . "<br />";
					
				// move the file from the temp space, over to where we want it...
				// the file in the tmp space gets deleted whtn the script ends...
      			move_uploaded_file($_FILES["file"]["tmp_name"], $filepath . $_FILES["file"]["name"]);
      		
				// you have to chmod the file to 777 as well as make sure the destination dir is chmod777			
				chmod($filepath . $_FILES["file"]["name"],0777);
				
				// confirm where it is....
      			echo "Stored in: " . $filepath . $_FILES["file"]["name"];
				
      		} // end else
    	} // end else
  	} // end if...blah blah blah blah...	

	//echo $filepath;
	//..............................................................................................	
	
	// excute it...did it work?

	if (!mysql_query($sql))
  	{
		echo "<br><br>";
	
		// anytime a user touches the db, write it to a log file....
		write_to_log( "mpegs"/*$table*/, "all"/*field_ffected*/, $spot_id/*spot_id*/, $sql/*$sql_statement*/, "added"/*$action*/, "n/a"/*$old_value*/, "n/a"/*$new_value*/, "ERROR"/*$error_status*/);
		handle_sql_error("db_insert_mpeg", $sql);
  	}
	else	
	{
		// display a success message to the user..
		
		echo "<br><br>Success: Your mpeg of '<strong>" . $mystery_spot_name . "</strong>' has been added to the db.";

		// anytime a user touches the db, write it to a log file....
		write_to_log( "mpegs"/*$table*/, "all"/*field_ffected*/, $spot_id/*spot_id*/, $sql/*$sql_statement*/, "added"/*$action*/, "n/a"/*$old_value*/, "n/a"/*$new_value*/, "OK"/*$error_status*/);
	}	
} // end function db_add_video

//*********************************************************************************************************
// example of call:
//		db_update_video(
//			$currently_selected_id, // spot id
//			$_GET['video_id'], // video id
//			$user_name, // user who is logged in
//			$_POST["video_url"],
//			$_POST["video_comment"]);  
function db_update_mpegs(
	$spot_id, 
	$image_id,
	$user_name,
	$image_filename,
	$image_comment,  
	$date_added)
{

 	//make sure there are no invalid chars...  ...namely a single and double quotes...which will make the sql statement barf...
	$spot_id = strip_invalid_chars($spot_id);
	$image_id = strip_invalid_chars($spot_id);
	$user_name = strip_invalid_chars($spot_id);
	$image_filename = strip_invalid_chars($spot_id);
	$image_comment = strip_invalid_chars($spot_id);
	$date_added = strip_invalid_chars($spot_id);
	 
	// build the sql update statement...
	$sql="UPDATE images 
	SET		 
		spot_id = '" . $spot_id . "', 
		user_name = '" . $user_name . "',
		image_filename	= '" . $image_filename . "',
		image_comment = '" . $image_comment . "',	
		date_added = '" . $date_added . "'
	WHERE 
		image_id = '" . $image_id . "'";
		
	// get the old value of the journal entry record... for the log file...
	$old_value = get_image_record_from_id($image_id);
		
	// excute it...did it work?
	if (!mysql_query($sql))
  	{
		// anytime a user touches the db, write it to a log file....
		write_to_log( "images"/*$table*/, "all"/*field_ffected*/, $spot_id/*spot_id*/, $sql/*$sql_statement*/, "updated"/*$action*/, $old_value/*$old_value*/, "n/a"/*$new_value*/, "ERROR"/*$error_status*/);
		handle_sql_error("db_update_images", $sql);
  	}
		
	// display a success message to the user..
	echo "Success: The image has been updated in the db.";

	// get the old value of the journal entry record... for the log file...
	$new_value = get_image_record_from_id($image_id);

	// anytime a user touches the db, write it to a log file....
	write_to_log( "images"/*$table*/, "all"/*field_ffected*/, $spot_id/*spot_id*/, $sql/*$sql_statement*/, "updated"/*$action*/, $old_value/*$old_value*/, $new_value/*$new_value*/, "OK"/*$error_status*/);

} // end function db_insert_journal_entry()

//*********************************************************************************************
// this function deletes a record from the video table with the corresponding unique_id
//  example of call:
//		db_delete_video(
//			$currently_selected_id, // spot id
//			$_GET['video_id']); // video id
function db_delete_mpegs($spot_id, $image_id)
{
	// protect from sql injection
	$image_id = strip_invalid_chars($image_id);
	
	// get the old value of the journal entry record... for the log file...
	$old_value = get_image_record_from_id($image_id);

	// delete this journal entry 
	$sql="DELETE FROM images WHERE image_id = '" . $image_id . "'";
	
	// execute it.... did it work?
	if (!mysql_query($sql))
  	{                                                                            
		// anytime a user touches the db, write it to a log file....
		write_to_log( "images"/*$table*/, "all"/*field_ffected*/, $spot_id/*spot_id*/,$sql/*$sql_statement*/, "deleted"/*$action*/, $old_value/*$old_value*/, "n/a"/*$new_value*/, "ERROR"/*$error_status*/);
		handle_sql_error("db_delete_video...", $sql);
  	}
		
	// it worked...echo out a success message to the user..
	echo "Success: the image has been deleted from the db.";

	// anytime a user touches the db, write it to a log file....
	write_to_log( "images"/*$table*/, "all"/*field_ffected*/, $spot_id/*spot_id*/, $sql/*$sql_statement*/, "deleted"/*$action*/, $old_value/*$old_value*/, "n/a"/*$new_value*/, "OK"/*$error_status*/);

} // end function db_delete_journal_entry()


//#########################################################################################################
// USERS...
//#########################################################################################################
// CREATE NEW USER IN DB
function db_insert_user( 
	$user_name,  
	$user_password,
	$email)
{

	// protect from sql injection		
	$user_name = strip_invalid_chars($user_name);
	$user_password = strip_invalid_chars($user_password);
	$email = strip_invalid_chars($email);
	
	// build the sql insert statement...
	$sql="INSERT INTO users (
		user_name, 
		user_password,
		email)
	VALUES (
		'$user_name', 
		'$user_password',
		'$email')";

	// excute it...did it work?
	if (!mysql_query($sql))
  	{	
		// anytime a user touches the db, write it to a log file....
		write_to_log( "users"/*$table*/, "all"/*field_ffected*/, "n/a"/*spot_id*/, $sql/*$sql_statement*/, "added"/*$action*/, "n/a"/*$old_value*/, $user_name/*$new_value*/, "ERROR"/*$error_status*/);
		handle_sql_error("db_insert_user...if (!mysql_query($sql))", $sql);
  	}
	 
	// display a success message to the user..
	echo "<div align=center>";
	echo 'Success: A new user was created with the name "<b>' . $user_name . '</b>.</br>';
	echo "</div>";
	
	// anytime a user touches the db, write it to a log file....
	write_to_log( "users"/*$table*/, "all"/*field_ffected*/, "n/a"/*spot_id*/, $sql/*$sql_statement*/, "added"/*$action*/, "n/a"/*$old_value*/, $user_name/*$new_value*/, "OK"/*$error_status*/);

} // end function db_insert_journal_entry()

//**********************************************************************************************************************************
// CREATE NEW USER IN DB
function db_update_user( 
	$user_name,  
	$user_password,
	$email,
	$initial_spot_list_filter_country,
	$initial_spot_list_filter_state)
{
		
	// protect from sql injection		
	$user_name = strip_invalid_chars($user_name);
	$user_password = strip_invalid_chars($user_password);
	$email = strip_invalid_chars($email);
	$initial_spot_list_filter_country = strip_invalid_chars($initial_spot_list_filter_country);
	$initial_spot_list_filter_state = strip_invalid_chars($initial_spot_list_filter_state);
		
	// build the sql insert statement...		
	$sql="UPDATE users 
	SET
		user_password = '" . $user_password . "',
		email = '" . $email . "',
		initial_spot_list_filter_country = '" . $initial_spot_list_filter_country . "',
		initial_spot_list_filter_state = '" . $initial_spot_list_filter_state . "'
	WHERE 
		user_name = '" . $user_name . "'";
			
	//echo "SQL: " . $sql;
			
	// excute it...did it work?
	if (!mysql_query($sql))
  	{	
		// anytime a user touches the db, write it to a log file....
		write_to_log( "users"/*$table*/, "all"/*field_ffected*/, "n/a"/*spot_id*/, $sql/*$sql_statement*/, "updated"/*$action*/, "n/a"/*$old_value*/, "n/a"/*$new_value*/, "ERROR"/*$error_status*/);
		handle_sql_error("db_update_user...if (!mysql_query($sql))", $sql);
  	}
	 
	// display a success message to the user..
	echo "<div align=center>";
	echo 'Success: Your user settings were successfully saved.</b><br>';
	echo "</div>";
	
	// anytime a user touches the db, write it to a log file....
	write_to_log( "users"/*$table*/, "all"/*field_ffected*/, "n/a"/*spot_id*/, $sql/*$sql_statement*/, "updated"/*$action*/, "n/a"/*$old_value*/, "n/a"/*$new_value*/, "OK"/*$error_status*/);

} // end function db_insert_journal_entry()

//******************************************************************************************************************************
// Is this user name/password a valid key/value in the db??
function is_valid_user_and_password($user_name, $user_password)
{
	// protect from sql injection		
	$user_name = strip_invalid_chars($user_name);
	$user_password = strip_invalid_chars($user_password);
	
	// initialize the return value...
	$return_value = false;
	
	// does this name and password pair exist in the table??
	$sql = "SELECT * FROM `users` WHERE `user_name`='" . $user_name . "' AND `user_password`='" . $user_password . "'";
	
	// execute it.... did it work?
	$result = mysql_query($sql);
	if (!$result)
  	{                                                                          
		write_to_log( "users"/*$table*/, "all"/*field_ffected*/, $spot_id/*spot_id*/, $sql/*$sql_statement*/, "is_valid_user_and_password"/*$action*/, "n/a"/*$old_value*/, "n/a"/*$new_value*/, "ERROR"/*$error_status*/);
		// handle sql error....
		handle_sql_error("is_valid_user_and_password()", $sql);		
  	}
		
	//  grab the first record.. 
	$row = mysql_fetch_array($result, MYSQL_ASSOC); 
	
	// is there at least one row?
	if (!$row)
	{ 
		$return_value = false; // NO record found...
	}
	else
	{
		// THE SELECT STATEMENT ABOVE IS NOT CASE SENSATIVE.... ie.. $user_name = WEaVer ...would successfull find weAvR in the db...
		//SO WE MUST CHECK NOW IF THE USER NAME THEY ENTERED IS THE SAME AS WHAT IS IN THE DB..
		$db_user_name = $row['user_name'];
		$db_user_password = $row['user_password'];
		
		// check this first row...against what the user entered...
		if (($db_user_name == $user_name) && ($db_user_password == $user_password))
		{
			$return_value = true; // yes this is it!!!
		}
		else
		{
			// the first record is not it.... so roll through the other ones (if there is more than one record), and look for it...
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				// get the name from the db...
				$db_user_name = $row['user_name'];
				$db_user_password = $row['user_password'];	
					
				// is this the user and password we are looking for?	
				if (($db_user_name == $user_name) && ($db_user_password == $user_password))
					$return_value = true; // yes, we found it!!!!!!			

			} // end while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
			
		} // end else..not a user/password we want...
		
	} // end else... a row was found...
	
	// so evaluate what the return value is, and write the appropriate log file...
	if ($return_value == true)
		write_to_log( "users"/*$table*/, "all"/*field_ffected*/, $spot_id/*spot_id*/, $sql/*$sql_statement*/, "is_valid_user_and_password: YES"/*$action*/, "n/a"/*$old_value*/, "n/a"/*$new_value*/, "OK"/*$error_status*/);
	else 
		write_to_log( "users"/*$table*/, "all"/*field_ffected*/, $spot_id/*spot_id*/, $sql/*$sql_statement*/, "is_valid_user_and_password: NO"/*$action*/, "n/a"/*$old_value*/, "n/a"/*$new_value*/, "OK"/*$error_status*/);
		
	// FINALLY..return the value...
	return $return_value;
	
} // end function is_valid_user_and_password($user_name, $user_password)
//************************************************************************************************************************
function is_valid_user($user_name)
{	
	// protect from sql injection		
	$user_name = strip_invalid_chars($user_name);
	
	// initialize the return value...
	$return_value = false;
	
	// does this name exist in the table??
	$sql = "SELECT * FROM `users` WHERE `user_name`='" . $user_name . "'";
	
	// execute it.... did it work?
	$result = mysql_query($sql);
	if (!$result)
  	{   
		write_to_log( "users"/*$table*/, "all"/*field_ffected*/, $spot_id/*spot_id*/,  $sql/*$sql_statement*/, "does this user name exist"/*$action*/, "n/a"/*$old_value*/, "n/a"/*$new_value*/, "ERROR"/*$error_status*/);                                                                    
		// handle sql error....
		handle_sql_error("is_valid_user()", $sql);		
  	}
		
	//  grab the record.. 
	$row = mysql_fetch_array($result, MYSQL_ASSOC); 
	
	// is there at least one row?
	if (!$row) 
	{
		// no record found....
		$return_value = false; // NO ... we didnt find this user in the db..
	}
	else
	{ 
		// NOTE... IT IS POSSIBLE THAT MULTIPLE RECORDS ARE FOUND...ie... the select
		// statement is not case sensitive...  there could be a record for "WEaVer" ...and also one for "weavER" for example..
		// so roll through them all, checking for the one we are looking for...
		
		// get the name from the db...
		$db_user_name = $row['user_name'];
		
		// check this first row...against what the user entered...
		if ($db_user_name == $user_name)
		{
			$return_value = true; // yes... we found it.			
		}
		else
		{
			// the first record is not it.... so roll through the other ones (if there is more than one record), and look for it...
			while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
			{
				// get the name from the db...
				$db_user_name = $row['user_name'];
					
				// is this the user we are looking for?	
				if ($db_user_name == $user_name)
					$return_value = true; // yes, we found it!!!!!!			

			} // end while ($row = mysql_fetch_array($result, MYSQL_ASSOC))
			
		} // end else $db_user_name != $user_name)
		
	} // else ($row) ...we found a record with this user_name
	
	
	// so evaluate what the return value is, and write the appropriate log file...
	if ($return_value == true)
		write_to_log( "users"/*$table*/, "all"/*field_ffected*/, $spot_id/*spot_id*/, $sql/*$sql_statement*/, "does this user name exist: YES"/*$action*/, "n/a"/*$old_value*/, "n/a"/*$new_value*/, "OK"/*$error_status*/);
	else 
		write_to_log( "users"/*$table*/, "all"/*field_ffected*/, $spot_id/*spot_id*/, $sql/*$sql_statement*/, "does this user name exist: NO"/*$action*/, "n/a"/*$old_value*/, "n/a"/*$new_value*/, "OK"/*$error_status*/);
		
	// FINALLY..return the value...
	return $return_value;
		
} // end function is_valid_user($user_name)

//*************************************************************************************************
function get_num_users()
{
	// get all the videos...
	$result = mysql_query("SELECT * FROM `users` ");
	
	while($record = mysql_fetch_array($result, MYSQL_ASSOC))
		$count = $count + 1;
		
	return $count;
	
}

//*****************************************************************************************************
// this functions returns an array of the data for the record with this id..
// example of function call: $thisRow = get_journal_entry_with_this_id($_GET['journal_id']);
function get_journal_entry_record_from_id($journal_id)	  
{	
	// protect from sql injection		
	$journal_id = strip_invalid_chars($journal_id);

	//select this mystery spot...
	$sql = "SELECT * FROM `exploration_data` WHERE `journal_id` = '" . $journal_id . "'";

	// execute it....
	$result = mysql_query($sql);
	if (!$result) // did we get it?
  	{                                                                            
		// handle sql error....
		handle_sql_error("get_journal_entry_record_from_id($journal_id)", $sql);		
  	}
	
	// assuming this spot is in the db... grab its data... 
	$row = mysql_fetch_array($result, MYSQL_ASSOC); 
	
	// return the row....  
	return $row;
} // end function get_journal_entry_record_from_id($journal_id)

//*****************************************************************************************************
// this functions returns an array of the data for the record with this id..
// example of function call: $thisRow = get_journal_entry_with_this_id($_GET['journal_id']);
function get_gathering_record_from_id($gathering_id)	  
{	
	// protect from sql injection		
	$gathering_id = strip_invalid_chars($gathering_id);
	
	//select this mystery spot...
	$sql = "SELECT * FROM `gatherings` WHERE `gathering_id` = '" . $gathering_id . "'";

	// execute it....
	$result = mysql_query($sql);
	if (!$result) // did we get it?
  	{                                                                            
		// handle sql error....
		handle_sql_error("get_gathering_record_from_id($gathering_id)", $sql);		
  	}
	
	// assuming this spot is in the db... grab its data... 
	$row = mysql_fetch_array($result, MYSQL_ASSOC); 
	
	// return the row....  
	return $row;
} // end function get_journal_entry_record_from_id($journal_id)

//********************************************************************************************************
// this functions returns an array of the data for the record with this id..
function get_video_record_from_id($video_id)	  
{	

	// protect from sql injection		
	$video_id = strip_invalid_chars($video_id);
	
	//build this sql statement
	$sql = "SELECT * FROM `videos` WHERE `video_id` = '" . $video_id . "'";
	
	// execute it....
	$result = mysql_query($sql);
	if (!$result) // did we get it?
  	{                                                                            
		// handle sql error....
		handle_sql_error("get_video_record_from_id($video_id)", $sql);		
  	}

	// grab the row...... 
	$row = mysql_fetch_array($result, MYSQL_ASSOC); 
	
	// return the row.... assuming we found it....
	return $row;
} // end function get_mystery_spots_record_from_id($spot_id)

//*****************************************************************************************************
// this functions returns an array of the data for the record with this id..
// example of function call: $thisRow = get_journal_entry_with_this_id($_GET['journal_id']);
function get_image_record_from_id($image_id)	  
{	
	// protect from sql injection		
	$image_id = strip_invalid_chars($image_id);
	
	//select this mystery spot...
	$sql = "SELECT * FROM `images` WHERE `image_id` = '" . $image_id . "'";

	// execute it....
	$result = mysql_query($sql);
	if (!$result) // did we get it?
  	{                                                                            
		// handle sql error....
		handle_sql_error("get_image_record_from_id($image_id)", $sql);		
  	}
	
	// assuming this spot is in the db... grab its data... 
	$row = mysql_fetch_array($result, MYSQL_ASSOC); 
	
	// return the row....  
	return $row;
} // end function get_journal_entry_record_from_id($journal_id)

//************************************************************************************************************
//select all the journal entries for this mystery spot...
function get_all_journal_entries_from_spot_id($spot_id)	  
{
	// protect from sql injection		
	$spot_id = strip_invalid_chars($spot_id);
	
	$sql = "SELECT * FROM `exploration_data` WHERE `spot_id` = '" . $spot_id . "' ORDER BY `explore_date`";
	if (!mysql_query($sql))
  	{                                                                            
		// handle sql error....
		handle_sql_error("build_journal_entry_list($spot_id)", $sql);
  	} 
 	
	// get the result set....
	$result = mysql_query($sql);
	
	// return the journal entries...
	return $result;
	
} // end function get_all_journal_entries_from_spot_id($spot_id)

//**********************************************************************************************************

function get_all_spots()	  
{
	$sql = "SELECT * FROM `mystery_spots` ORDER BY `mystery_spot_name`";
	if (!mysql_query($sql))
  	{                                                                            
		// handle sql error....
		handle_sql_error("build_spot_list", $sql);
  	} 
 	
	// get the result set....
	$result = mysql_query($sql);
	
	// return the journal entries...
	return $result;
	
} // end function get_all_journal_entries_from_spot_id($spot_id)

//********************************************************************************************************
// This function will return the greatest unique id in a table....
// ex... unique_id column3
//           1      data1
//           2      data2
//           3      data3
// $highestId = get_highest_unique_id_in_table($table1)
// so....$highestId == 3
function get_highest_unique_id_in_table($table_name, $unique_id_field)
{	
	// protect from sql injection		
	$table_name = strip_invalid_chars($table_name);
	$unique_id_field = strip_invalid_chars($unique_id_field);
	
	//select all the mystery spots... list in descending order...
	$sql = "SELECT * FROM `" . $table_name . "` ORDER BY `" . $unique_id_field . "` DESC";

	// execute it....
	$result = mysql_query($sql);
	if (!$result) // did we get it?
  	{                                                                            
		// handle sql error....
		handle_sql_error("get_highest_unique_id_in_table($table_name, $unique_id_field)", $sql);		
  	}
	
	// roll through the record set and list the spots... the first one will be the highest unique id..
	$row = mysql_fetch_array($result, MYSQL_ASSOC); 

	// return highest unique_id....which is this first row...
	return $row[$unique_id_field];
	
} // end function get_highest_unique_id_in_table($table_name, $unique_id_field)

//********************************************************************************************************
// When inserting a new spot in the mystery_spots table, we must ensure that there are no dups...
// this function returns true or false...
function is_there_a_duplicate_spot($spot_name)
{
	//select all the mystery spots...
	$result = mysql_query("SELECT * FROM `mystery_spots`");

	// initialize the return value... assume we didnt find one. if we find a dup, we set this to TRUE below
	$return_value = "FALSE";
	
	// roll through the records...
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 
	{
		if ($row['mystery_spot_name'] == $spot_name) 
			$return_value = "TRUE";
	}
	
	// return the row.... assuming we found it....
	return $return_value;
} // end function is_there_a_duplicate_spot($spot_name)

//*********************************************************************************************************
// this function will return the gauge number for the spot with the id that you pass in....
function get_gauge_url_from_id($spot_id)
{
	// protect from sql injection		
	$spot_id = strip_invalid_chars($spot_id);
	
	//select this mystery spot...
	$sql = "SELECT * FROM `mystery_spots` WHERE `spot_id` = '" . $spot_id . "'";
	
	// execute it....
	$result = mysql_query($sql);
	if (!$result) // did we get it?
  	{                                                                            
		// handle sql error....
		handle_sql_error("get_gauge_url_from_id($spot_id)", $sql);		
  	}
	
	// grab this row....
	$row = mysql_fetch_array($result, MYSQL_ASSOC); 
	
	// if the row has a url defined, grab it...
	$gauge_url = $row['gauge_url']; 
	
	// return the row.... assuming we found it....
	return $gauge_url;
} // end function get_gauge_url_from_id($spot_id)

//*********************************************************************************************************
// this function will return the gauge number for the spot with the id that you pass in....
function get_prediction_url_from_id($spot_id)
{
	// protect from sql injection		
	$spot_id = strip_invalid_chars($spot_id);
	
	//select this mystery spot...
	$sql = "SELECT * FROM `mystery_spots` WHERE `spot_id` = '" . $spot_id . "'";
	
	// execute it....
	$result = mysql_query($sql);
	if (!$result) // did we get it?
  	{                                                                            
		// handle sql error....
		handle_sql_error("get_gauge_url_from_id($spot_id)", $sql);		
  	}
	
	// grab this row....
	$row = mysql_fetch_array($result, MYSQL_ASSOC); 
	
	// if the row has a url defined, grab it...
	$prediction_url = $row['prediction_url']; 
	
	// return the row.... assuming we found it....
	return $prediction_url;
} // end function get_gauge_url_from_id($spot_id)

//*********************************************************************************
function get_flow_type_from_id($spot_id)
{
	// protect from sql injection		
	$spot_id = strip_invalid_chars($spot_id);
	
	//select this mystery spot...
	$sql = "SELECT * FROM `mystery_spots` WHERE `spot_id` = '" . $spot_id . "'";
	 	
	// execute it....
	$result = mysql_query($sql);
	if (!$result) // did we get it?
  	{                                                                            
		// handle sql error....
		handle_sql_error("get_flow_type_from_id($spot_id)", $sql);		
  	}

	// grab this row...
	$row = mysql_fetch_array($result, MYSQL_ASSOC); 
	
	// if the flow type is defined in the db, grab it...
	$flow_type = $row['flow_type'];
	
  	// return the row.... assuming we found it....
	return $flow_type;
} // end function get_flow_type_from_id($spot_id)

//******************************************************************************************************

function email_forotten_id($email)
{

	// what are the user id and password for the user_id that was created with this email address?
	$result = get_user_records_from_email($email);
	
	if (mysql_num_rows($result) <= 0)
	{
		//no user records were found with that email!
		echo("Sorry, no User Account was created using your email address. Could not retrieve your User Id or Password.");
	}	
	else if(mysql_num_rows($result) > 1 )
	{
		// more than one account was created with this email address!...
		echo("Sorry, more than one User Account was created using your email address. Could not retrieve your User Id or Password. The administrator has been emailed informing him of the situation. Thank you.");
		
		// build the message body...
		$message = "Hello!<br><br>";
		$message .= "This person forgot their User Id or Password. But the email is defined for more than one account!?!?!<br>";
		$message .= "<strong>email: $email</strong><br>";
		$message .= "Thanks!";
		
		// this code writes a email..
		$to = 'dont_get_trashed@yahoo.com';  // who are we emailing?
		$from = "admin@sinkspots.com";	// who is it from? this will be in the body of the email...
		$subject = "SinkSpots User ID And Password";
		//$headers = "From: $from";
		
		// MAKE THE EMAIL HTML!
		$headers = "From: $from \r\n";
		$headers .= "Content-Type: text/html; charset=\"windows-1251\"\r\n";	
		
		// fire off the email..
		mail($to,$subject,$message,$headers);
	}
	else 
	{
	
				// let the user know they just got emailed...
		echo "An email has been sent with the User Id and Password that corresponds with the email address that you supplied during the creation of the User Id.<br>";
		echo "<br>You will recieve the email shortly. It might have went into your SPAM folder so keep an eye out. Thank you.<br><br>";
		
		// get the row...
		$row = mysql_fetch_array($result, MYSQL_ASSOC); 
		
		$user_id = $row['user_name'];
		$password = $row['user_password'];
	
		// build the message body...
		$message = "Hello!<br><br>";
		$message .= "You forgot your User Id or Password. Heres a friendly reminder...<br>";
		$message .= "<strong>User Id: $user_id</strong><br>";
		$message .= "<strong>Password: $password</strong><br>";
		$message .= "Thanks!";
		
		// this code writes a email..
		$to = $email;  // who are we emailing?
		$from = "admin@sinkspots.com";	// who is it from? this will be in the body of the email...
		$subject = "SinkSpots User ID And Password";
		//$headers = "From: $from";
		
		// MAKE THE EMAIL HTML!
		$headers = "From: $from \r\n";
		$headers .= "Content-Type: text/html; charset=\"windows-1251\"\r\n";	
		
		// fire off the email..
		mail($to,$subject,$message,$headers);
	} // end else

} // end function email_id

//**********************************************************************************************************	

function email_forgotten_password($user_id)
{

	// what are the user id and password for the user_id that was created with this email address?
	$result = get_user_record_from_id($user_id);
	
	if (mysql_num_rows($result) <= 0)
	{
		//no user records were found with that email!
		echo("Sorry, no User Account was created using your user id, so we could not retrieve your Password.");
	}
	else 
	{
		// get the row...
		$row = mysql_fetch_array($result, MYSQL_ASSOC); 
		 
		
		$user_id = $row['user_name'];
		$password = $row['user_password'];
		$email = $row['email'];
		
		if ($email == '')
		{
			echo "Sorry, there is no email address associated with this User Account, so we cannot email you your forgotten Password.... you are shit out of luck. The administrator has been emailed letting him know the situation... in the mean time, you could just create a new user account if you want. Thank you.";
			
			// build the message body...
			$message = "Hello!<br><br>";
			$message .= "This person forgot there password and they have no email address defined?!?!<br>";
			$message .= "<strong>User Id: $user_id</strong><br>";
			$message .= "<strong>Password: $password</strong><br><br>";
			$message .= "<strong>Email: $email</strong><br><br>";
			$message .= "Thanks!";
			
			// this code writes a email..
			$to = 'dont_get_trashed@yahoo.com';  // who are we emailing?
			$from = "admin@sinkspots.com";	// who is it from? this will be in the body of the email...
			$subject = "SinkSpots User ID And Password";
			//$headers = "From: $from";
			
			// MAKE THE EMAIL HTML!
			$headers = "From: $from \r\n";
			$headers .= "Content-Type: text/html; charset=\"windows-1251\"\r\n";
			
			// fire off the email..
			mail($to,$subject,$message,$headers);
			
		}
		else
		{
		
			// let the user know they just got emailed...
			echo "An email has been sent with your Password, to the email address that you supplied when that User Id was created.<br>";
			echo "<br>You will recieve the email shortly. It might have went into your SPAM folder so keep an eye out. Thank you.<br><br>";
	
			// build the message body...
			$message = "Hello!<br><br>";
			$message .= "You forgot your Password. Heres a friendly reminder...<br>";
			$message .= "<strong>User Id: $user_id</strong><br>";
			$message .= "<strong>Password: $password</strong><br><br>";
			$message .= "Thanks!";
			
			// this code writes a email..
			$to = $email;  // who are we emailing?
			$from = "admin@sinkspots.com";	// who is it from? this will be in the body of the email...
			$subject = "SinkSpots User ID And Password";
			//$headers = "From: $from";
			
			// MAKE THE EMAIL HTML!
			$headers = "From: $from \r\n";
			$headers .= "Content-Type: text/html; charset=\"windows-1251\"\r\n";
			
			// fire off the email..
			mail($to,$subject,$message,$headers);
			
		}
	} // end else
	

} // end function email_forotten_password($user_id)


//########################################################################################################
// FUNCTIONS THAT DYNAMICALLY BUILD STUFF:
//#########################################################################################################

function build_spot_link_list($spot_id, $current_page_name)
{


  	// how many spots are their?
	echo "<div align=center>";

	

	
	
	// set defaults to ON for these descriptive filters...	
	if (!isset($_SESSION['COUNTRY_FILTER']))
		$_SESSION['COUNTRY_FILTER'] = '[SHOW ALL]';
			
	if (!isset($_SESSION['REGION_FILTER']))
		$_SESSION['REGION_FILTER'] = '[SHOW ALL]';
		
	if (!isset($_SESSION['STATE_FILTER']))
		$_SESSION['STATE_FILTER'] = '[SHOW ALL]';
	
	if (!isset($_SESSION['SHOW_MODERATE_FILTER']))
		$_SESSION['SHOW_MODERATE_FILTER'] = 1;
			
	if (!isset($_SESSION['SHOW_EPIC_FILTER']))
		$_SESSION['SHOW_EPIC_FILTER'] = 1;
		
	if (!isset($_SESSION['SHOW_EXPLORATORY_FILTER']))
		$_SESSION['SHOW_EXPLORATORY_FILTER'] = 1;
		


	echo "<div align=left>";
	
	echo "<form action=$current_page_name?spot_id=$spot_id&action=filter name=countryfilter method=post> ";
	echo "<b>Country:</b>";
	echo "<br>";
	echo build_country_filter_dropdown($_SESSION['COUNTRY_FILTER']);
	echo "<br>";
	echo "</form>";
	echo "<br>";
	//echo "<b>Region:</b> [<a href=settings_maintenance?spot_id=" . $spot_id . "><font color=#FF6600 size=-1><em>add region</em></font></a>]";
	//echo "<br>";
	//echo build_region_filter_dropdown($_SESSION['REGION_FILTER']);
	//echo "<br>";
	//echo "<br>";
	
	echo "<form action=$current_page_name?spot_id=$spot_id&action=filter name=statefilter method=post> ";
	echo "<b>State:</b>";
	echo "<br>";
	echo build_state_filter_dropdown($_SESSION['STATE_FILTER']);
	echo "<br>";
	echo "</form>";
	
	echo "</div>"; //  left

//	echo "<input type=submit name=submit value=Filter>";
	//echo '[<a onclick="document['filter'].submit();return false' href=$current_page_name?spot_id=$spot_id&action=filter><em><font color=#FF6600 size=-1>filter</font></em></a>]"; 

	
	
	
	echo "</div>"; // center
	echo "<br><br><hr><br>";
	
  	//select all the country!
	$sql = "SELECT DISTINCT `country` FROM `mystery_spots` ORDER BY `country` ASC";
	if (!mysql_query($sql))
  	{                                                                            
		// handle sql error....
		handle_sql_error("build_spot_link_list($spot_id, $current_page_name)... country", $sql);
  	} 
	
	//get the result set...
	$country_result = mysql_query($sql);
	//echo "<ul style=list-style-type: none>"; // open the country list..
	
	// roll through the "country" result set...
	while ($country_row = mysql_fetch_array($country_result, MYSQL_ASSOC)) 
	{
		
		$country = $country_row['country'];
		
		// protect from sql injection		
		$country = strip_invalid_chars($country);
		
		//echo "<li><b>" . $country . "</b></li>"; 
  
  		// ONLY SHOW THE COUNTRY THAT THE USER FILTERED BY...	
		// if this isnt the state we want to filter by, and the user didnt select to show them all, dont show it	
		if (($_SESSION['COUNTRY_FILTER'] == "[SHOW ALL]") || ($_SESSION['COUNTRY_FILTER'] == $country))
		{

			$this_country = strtolower($country);
			// get a hint for it.
			if ($this_country == 'gb')
				$hint = 'Great Britian';
			else if ($this_country == 'us')
				$hint = 'United States';
			else if ($this_country == 'jp')
				$hint = 'Japan';
			else if ($this_country == 'es')
				$hint = 'Spain';
			else if ($this_country == 'fr')
				$hint = 'France';
			else if ($this_country == 'ca')
				$hint = 'Canada';
			else if ($this_country == 'ch')
				$hint = 'Switzerland';
			else if ($this_country == 'ie')
				$hint = 'Ireland';
			else if ($this_country == 'nz')
				$hint = 'New Zealand';		
			else 
				$hint = 'Im a computer and i dont know what country this is...';
					
			echo "<b><u>" . $country . "</u></b>"; 
			
			echo ' <img src="./flags/gif/'. strtolower($country).'.gif" alt= "'.$hint.'" title="'.$hint.'"/>';
   
//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>			
			//select all the country!
			$sql = "SELECT DISTINCT `region` FROM `mystery_spots` WHERE `country` = '" . $country . "' ORDER BY `region` ASC";
			if (!mysql_query($sql))
			{                                                                            
				// handle sql error....
				handle_sql_error("build_spot_link_list($spot_id, $current_page_name)... region", $sql);
			} 
			
			//get the result set...
			$region_result = mysql_query($sql);
			//echo "<ul style=list-style-type: none>"; // open the country list..
			
			echo "<ul>";
			// roll through the "country" result set...
			while ($region_row = mysql_fetch_array($region_result, MYSQL_ASSOC)) 
			{
				
				$region = $region_row['region'];
				//echo "<li><b>" . $region . "</b></li>"; 
				
				// ONLY SHOW THE COUNTRY THAT THE USER FILTERED BY...	
				// if this isnt the state we want to filter by, and the user didnt select to show them all, dont show it	
				if (($_SESSION['REGION_FILTER'] == "[SHOW ALL]") || ($_SESSION['REGION_FILTER'] == $region))
				{
		
							
					if ($region == '') 
						echo "<b><li><font color=#FF00FF><em>Unknown Region</em></font></li></b>"; 
					else
						echo "<b><li><font color=#FF00FF>" . $region . "</font></li></b>"; 
					//echo "<li><b>" . $region . "</b></li>";
//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
						
					// protect from sql injection		
					$region = strip_invalid_chars($region);
				
					//select all the states!
					$sql = "SELECT DISTINCT `state` FROM `mystery_spots` WHERE `country` = '" . $country . "' AND `region` = '" . $region . "' ORDER BY `state` ASC";
					if (!mysql_query($sql))
					{                                                                            
						// handle sql error....
						handle_sql_error("build_spot_link_list($spot_id, $current_page_name)... state", $sql);
					} 
					// get the result set...
					$state_result = mysql_query($sql);
				
					echo "<ul>"; // open the state list..
					// roll through the "states" result set...
					while ($state_row = mysql_fetch_array($state_result, MYSQL_ASSOC)) 
					{
					
						$state = $state_row['state'];
							
						// ONLY SHOW THE STATE THAT THE USER FILTERED BY...
						// if this isnt the state we want to filter by, and the user didnt select to show them all, dont show it	
						if (($_SESSION['STATE_FILTER'] == $state) || ($_SESSION['STATE_FILTER'] == "[SHOW ALL]")) 
						{
							
							
							
							
							if (strtolower($state) == 'scotland')
								echo "<li><b>" . $state . "</b> <img src='./flags/gif/". strtolower($state).".gif' /></li>";
							else if (strpos(strtolower($state), 'wales') != false)
								echo "<li><b>" . $state . "</b> <img src='./flags/gif/wales.gif' /></li>";
							else if ($state == '') 
								echo "<b><li><em>Unknown State</em></li></b>"; 
							 else
								echo "<li><b>" . $state . "</b>";
						
							// protect from sql injection		
							$state = strip_invalid_chars($state);
					
							//select all the rivers in this state!
							$sql = "SELECT DISTINCT `river` FROM `mystery_spots` WHERE `state` = '" . $state . "' AND `region` = '" . $region . "' AND  `country` = '" . $country . "' ORDER BY `state` ASC";
							if (!mysql_query($sql))
							{                                                                            
								// handle sql error....
								handle_sql_error("build_spot_link_list($spot_id, $current_page_name)... river", $sql);
							} 
							// get the result set...
							$river_result = mysql_query($sql);
							
							echo "<ul>"; // open the river list..
							// roll through the "river" result set...
							while ($river_row = mysql_fetch_array($river_result, MYSQL_ASSOC)) 
							{
								$river = $river_row['river'];
								
								if ($river == '') 
									echo "<b><li><font color=#FF6600><em>Unknown River</em></font></li></b>"; 
								else
									echo "<b><li><font color=#FF6600>" . $river . "</font></li></b>";
							 
									
								// protect from sql injection		
								$river = strip_invalid_chars($river);	
								
								//create the sql statement....
								$sql = "SELECT * FROM `mystery_spots` WHERE `country` = '" . $country . "' AND `region` = '" . $region . "' AND `state` = '" . $state . "' AND `river`  = '" . $river . "' ORDER BY `mystery_spot_name`";
								if (!mysql_query($sql))
								{                                                                            
									// handle sql error....
									handle_sql_error("build_spot_link_list($spot_id, $current_page_name)...", $sql);
								}  
						
								// get the result from the query...
								$spot_result = mysql_query($sql);
								
								// roll through the result set...
								while ($spot_row = mysql_fetch_array($spot_result, MYSQL_ASSOC)) 
								{
									echo "<ul>"; // open spot list..
						
									// get the color for it... if its "in" this will be green, if its not "in" it will be red, otherwise it will be blue(as in there is no gauge defined in the db..)
									$color = get_color_for_spot($spot_row["gauge_number"], $spot_row['spot_id'], $spot_row["flow_type"]);	
									//$color = "#0000FF"; // the get_color breaks..... look at email to debug... 
									
									// if this is the currently selected spot, put brackets around the link so the user knows where we are...
									if ($spot_id == $spot_row['spot_id'] )
									{
										if ($_SESSION['SHOW_CURRENT_FLOW_IN_SPOT_LIST'] == true)
										{
											 // get the current flow from usgs...
											$gauge_data = get_current_flow($spot_row["gauge_number"], $spot_row["flow_type"] );
											// this text will be colored either red or green, depending if the spot is "in"
											if (trim($gauge_data[0]) == "")
												$current_flow = "";
											else
												$current_flow = $gauge_data[0] . get_flow_type_from_id($spot_row['spot_id']);	
				
											// print the spot to the screen as a link with its id.. with brackets around it
											echo "<li><strong>[<a href=" . $current_page_name . "?spot_id=" . $spot_row['spot_id'] . "><font color=" . $color . ">" . $spot_row['mystery_spot_name'] . "</font></a>] $current_flow</strong></li>"; 
										}
										else
										{
											// print the spot to the screen as a link with its id.. with brackets around it
											echo "<li><strong>[<a href=" . $current_page_name . "?spot_id=" . $spot_row['spot_id'] . "><font color=" . $color . ">" . $spot_row['mystery_spot_name'] . "</font></a>]</strong></li>"; 
										}
									}
									else
									{
										if ($_SESSION['SHOW_CURRENT_FLOW_IN_SPOT_LIST'] == true)
										{
											// get the current flow from usgs...
											$gauge_data = get_current_flow($spot_row["gauge_number"], $spot_row["flow_type"] );
											// this text will be colored either red or green, depending if the spot is "in"
											if (trim($gauge_data[0]) == "")
												$current_flow = "";
											else
												$current_flow = $gauge_data[0] . get_flow_type_from_id($spot_row['spot_id']);	
				
											// print the spot to the screen as a link with its id....no brackets..
											echo "<li><a href=" . $current_page_name . "?spot_id=" . $spot_row['spot_id'] . "><font color=" . $color . ">" . $spot_row['mystery_spot_name'] . "</font></a> $current_flow</li>"; 
										}
										else
										{
											// print the spot to the screen as a link with its id....no brackets..
											echo "<li><a href=" . $current_page_name . "?spot_id=" . $spot_row['spot_id'] . "><font color=" . $color . ">" . $spot_row['mystery_spot_name'] . "</font></a></li>"; 
										}
									}
									
									echo "</ul>"; // close spot list
								
								} // end while ($spot_row = mysql_fetch_array($spot_result, MYSQL_ASSOC)) 
							} //end while ($river_row = mysql_fetch_array($river_result, MYSQL_ASSOC)) 			 
							echo "</ul>"; // close the river list
						
						} //end if ($_SESSION['STATE_FILTER'] != "[SHOW ALL]") && ($_SESSION['STATE_FILTER'] != $state) 
					} // end while ($state_row = mysql_fetch_array($result, MYSQL_ASSOC)) 
					echo "</ul>"; // close the state list
		
				} //end if ($_SESSION['REGION_FILTER'] != "[SHOW ALL]") && ($_SESSION['REGION_FILTER'] != $state) 							
			} // end while ($state_row = mysql_fetch_array($result, MYSQL_ASSOC)) 
			echo "</ul>"; // close the region list
		
		} // end if (($_SESSION['COUNTRY_FILTER'] != "[SHOW ALL]") && ($_SESSION['COUNTRY_FILTER'] != $country))
	} // end while ($country_row = mysql_fetch_array($result, MYSQL_ASSOC)) 
	//echo "</ul>"; // close the country list
	
} // end function build_spot_link_list()

// ******************************************************************************************************
// This function builds a table of all the journal entries for the spot that you pass in as a parameter...
function build_journal_entry_list($spot_id)
{
	// protect from sql injection		
	$spot_id = strip_invalid_chars($spot_id);
					
	//select all the journal entries for this mystery spot...
	$sql = "SELECT * FROM `exploration_data` WHERE `spot_id` = '" . $spot_id . "' ORDER BY `explore_date` DESC";
	if (!mysql_query($sql))
  	{                                                                            
		// handle sql error....
		handle_sql_error("build_journal_entry_list($spot_id)", $sql);
  	} 
 	
	// get the result set....
	$result = mysql_query($sql);

	// roll through the record set and list the spots...
	echo "<strong>Journal:</strong><br>";
	
	// what is the mystery_spot_name of this id? we are going to display it below...
	$mystery_spot_name = get_mystery_spot_name_from_id($spot_id);
	
	// are there any records?
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	if (!$row)
	{
		echo "There are no journal entries for this spot...";
	}
	else
	{
		// open the table 
		echo "<table width=100% border=1>";

		// open this row for the header
		echo "<tr>";
		// print the headers..
		echo "<td></td>"; // this is for the edit link
		echo "<td align=center><strong>Name</strong></td>";
		echo "<td align=center><strong>User</strong></td>";  
		echo "<td align=center><strong>Explore Date</strong></td>";
		echo "<td align=center><strong>Explore Flow</strong></td>";
		echo "<td align=center><strong>Quality</strong></td>";
		//echo "<td><strong>Notes</strong></td>";
		echo "<td><div align=center><strong>Flood?</strong></div></td>";
		// close this table row for the header..
		echo "</tr>";
	
		// there is at least one row, so print it:
		// open this table row...
		echo "<tr>";
		
		// print the journal entries for this spot to the screen.. 
		// if the current user is ADMIN, or the current user is the user that created this journal entry, show the edit and delete links... 
		if (($_SESSION['CURRENT_USER_NAME'] == $row['user_name']) || ($_SESSION['ADMIN_USER'] == "TRUE")) 
			echo "<td align=center><a href=journal_entry_maintenance.php?spot_id=" . $spot_id . "&journal_id=" . $row['journal_id'] . "&action=update><font color=#0000FF>edit</FONT></a> <a href=journal_entry_maintenance.php?spot_id=" . $spot_id . "&journal_id=" . $row['journal_id'] . "&action=delete><font color=#0000FF>delete</FONT></a></td>";
		else
			echo "<td></td>";
					
		echo "<td align=center>" . $mystery_spot_name . "</td>"; 
		echo "<td align=center>" . $row['user_name'] . "</td>";
		
		// formate the raw date into a 04-13-2007 12:23:60 AM/PM
		//$my_date_time = FormatMyDate($row['explore_date'], "m-d-Y g:i:s A" ); //  has second on timestamp
		$my_date_time = FormatMyDate($row['explore_date'], "m-d-Y g:i A" ); // no seconds on timestatmp
		echo "<td align=center>" . $my_date_time . "</td>";
		
		echo "<td align=right>" . $row['explore_flow'] . get_flow_type_from_id($spot_id) . "</td>";
		echo "<td align=center>" . $row['quality'] . "</td>";
		//echo "<td>" . $row['explore_notes'] . "</td>";
	
		// A value of zero is considered false. Non-zero values are considered true:
		if ($row['high_water_event'] == 0) 
		{
			echo "<td><div align=center><input type=checkbox disabled=true /></div></td>";
		}
		else 
		{
			echo "<td><div align=center><input type=checkbox disabled=true checked=checked /></div></td>";
		} 

		// close this table row..
		echo "</tr>";

		// show the notes..
		echo "<tr>";
		echo "<td><strong>Notes</strong></td>";		
		echo "<td colspan=6>" . $row['explore_notes'] . "</td>";
		echo "</tr>";

		echo "</table>";
		echo "<br>";
		// see if there are any other rows...
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 
		{
		
			echo "<table width=100% border=1>";
			// open this table row...
			
			// open this row for the header
			echo "<tr>";
			// print the headers..
			echo "<td></td>"; // this is for the edit link
			echo "<td align=center><strong>Name</strong></td>";
			echo "<td align=center><strong>User</strong></td>";  
			echo "<td align=center><strong>Explore Date</strong></td>";
			echo "<td align=center><strong>Explore Flow</strong></td>";
			echo "<td align=center><strong>Quality</strong></td>";
			//echo "<td><strong>Notes</strong></td>";
			echo "<td><div align=center><strong>Flood?</strong></div></td>";
			// close this table row for the header..
			echo "</tr>";
		
		
			echo "<tr>";

			// print the journal entries for this spot to the screen..
			// if the current user is ADMIN, or the current user is the user that created this journal entry, show the edit and delete links... 
			if (($_SESSION['CURRENT_USER_NAME'] == $row['user_name']) || ($_SESSION['ADMIN_USER'] == "TRUE"))
				echo "<td align=center><a href=journal_entry_maintenance.php?spot_id=" . $spot_id . "&journal_id=" . $row['journal_id'] . "&action=update><font color=#0000FF>edit</FONT></a> <a href=journal_entry_maintenance.php?spot_id=" . $spot_id . "&journal_id=" . $row['journal_id'] . "&action=delete><font color=#0000FF>delete</FONT></a></td>";
			else
			echo "<td></td>";
						
			echo "<td align=center>" . $mystery_spot_name . "</td>"; 
			echo "<td align=center>" . $row['user_name'] . "</td>";
			
			// format the raw date into a 04-13-2007 12:23:60 AM/PM
			//$my_date_time = FormatMyDate($row['explore_date'], "m-d-Y g:i:s A" ); //  has second on timestamp
			$my_date_time = FormatMyDate($row['explore_date'], "m-d-Y g:i A" ); // no seconds on timestatmp
			echo "<td align=center>" . $my_date_time . "</td>";			
			
			echo "<td align=right>" . $row['explore_flow'] . get_flow_type_from_id($spot_id) . "</td>";
			echo "<td align=center>" . $row['quality'] . "</td>";
			//echo "<td>" . $row['explore_notes'] . "</td>";
	
			// A value of zero is considered false. Non-zero values are considered true:
			if ($row['high_water_event'] == 0) 
				echo "<td><div align=center><input type=checkbox disabled=true /></div></td>";
			else 
				echo "<td><div align=center><input type=checkbox disabled=true checked=checked /></div></td>";
		
			// close this table row..
			echo "</tr>";
			
			// show the notes..
			echo "<tr>";
			echo "<td><strong>Notes</strong></td>";		
			echo "<td colspan=6>" . $row['explore_notes'] . "</td>";
			echo "</tr>";
			
			echo "</table>";
					echo "<br>";
		
		} // end while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 

		// close the table...
		

	} // end if ($result)
	
} // end function build_journal_entry_list($currently_selected_spot)

//*****************************************************************************************************
function build_mystery_spot_info($spot_id)
{	
	// protect from sql injection		
	$spot_id = strip_invalid_chars($spot_id);
	
	// check and see if the user wants us to refresh the flows...ie they just clicked the button...
	if ($_GET['action'] == 'refresh_flow_cache' ) // this is the first time the page has been loaded..
		  refresh_flow_cache(); // this function gets the data from usgs and fills the $_SESSION["FLOW_CACHE"] with it.. 
  	
	// roll through the record set and list the spots...
	echo "<strong>Spot Info:</strong>";
	echo " [<a href=index.php?spot_id=" . $spot_id . "&action=refresh_flow_cache ><em><font color=#0000FF>Refresh Current Flow For All Spots</font></em></a>] " . $_SESSION["CACHE_LAST_UPDATED"] . "<br>";
	
	//select all the mystery spots...
	$sql = "SELECT * FROM `mystery_spots` WHERE `spot_id` = '" . $spot_id . "'";
	
	// execute it....
	$result = mysql_query($sql);
	if (!$result) // did we get it?
  	{                                                                            
		// handle sql error....
		handle_sql_error("build_mystery_spot_info($spot_id)", $sql);		
  	}

	// assuming this spot is in the db... grab its data... 
	$row = mysql_fetch_array($result, MYSQL_ASSOC); 
	if (!$row)
	{
		echo "No spot has been selected yet...";
	}
	else
	{	
		// get the current flow from usgs...
		$gauge_data = get_current_flow( $row["gauge_number"], $row["flow_type"] );
 
 		// get the color for it... if its "in" this will be green, if its not "in" it will be red, otherwise it will be blue
		$color = get_color_for_spot($row["gauge_number"], $spot_id, $row["flow_type"]);		
		
		// did we find the gauge?
		if ($gauge_data[0] == "") 
		{
			// in case we didnt find the gauge, let the user know how to fix it... 
			// this text will be colored blue...
			$current_flow = "<font color=" . $color . ">Please Enter USGS Gage #</font>";
		}
		else if ($gauge_data[0] == "Ssn")
		{		 
			// this text will be colored either red or green, depending if the spot is "in"
			$current_flow = "<font color=" . $color . ">Gage operated seasonally. </font>" . " Recorded on " . $gauge_data[1];	
		} // end else ...
		else
		{
			// this text will be colored either red or green, depending if the spot is "in"
			$current_flow = "<font color=" . $color . ">" . $gauge_data[0] . get_flow_type_from_id($row['spot_id']) . "</font>" . " Recorded on " . $gauge_data[1];	
		} // end else ...
		
		// evaluate if there is a min and max set in the db, and display a message accordingly
		if ($row['ideal_min_flow'] == "") 
		 	$ideal_min_flow = "<font color=" . $color . ">NO MIN</font>";
		else
			$ideal_min_flow = $row['ideal_min_flow'] . get_flow_type_from_id($row['spot_id']);
		 
		if ($row['ideal_max_flow'] == "") 
		 	$ideal_max_flow = "<font color=" . $color . ">NO MAX</font>";
		else
			$ideal_max_flow = $row['ideal_max_flow'] . get_flow_type_from_id($row['spot_id']); 
		
		if ($row['ideal_flow'] == "") 
		 	$ideal_flow = "";
		else
			$ideal_flow = $row['ideal_flow'] . get_flow_type_from_id($row['spot_id']); 

		//...............................
		// get the country flag 
		$this_country = strtolower($row["country"]);
		
		// get a hint for it.
		if ($this_country == 'gb')
			$hint = 'Great Britian';
		else if ($this_country == 'us')
			$hint = 'United States';
		else if ($this_country == 'jp')
			$hint = 'Japan';
		else if ($this_country == 'es')
			$hint = 'Spain';
		else if ($this_country == 'fr')
			$hint = 'France';
		else if ($this_country == 'ca')
			$hint = 'Canada';
		else if ($this_country == 'ch')
			$hint = 'Switzerland';
		else if ($this_country == 'ie')
			$hint = 'Ireland';
		else if ($this_country == 'nz')
			$hint = 'New Zealand';		
		else 
			$hint = 'Im a computer and i dont know what country this is...';
				
		$country_flag = ' <img src="http://sinkspots.org/flags/gif/'. strtolower($this_country).'.gif" alt= "'.$hint.'" title="'.$hint.'"/>';

		// print the info out..
		
		//.....................
		// WATER TEMP
		if (trim($gauge_data[2]) == '')
			$current_water_temp_C = '';
		else
			$current_water_temp_C = trim($gauge_data[2]) . ' *C';
			
		if (trim($gauge_data[3]) == '')
			$current_water_temp_F = '';
		else
			$current_water_temp_F = trim($gauge_data[3]) . ' *F';
		
	 
		
	   if ((trim($gauge_data[3]) == '') && (trim($gauge_data[2]) != ''))
			$current_water_temp_F = '' . ((trim($gauge_data[2]) * 9) / 5) + 32 . ' *F';
 
 

		//........................
		// TUBERDITY
		if ($gauge_data[4] == '')	
			$current_turbidity = '?';
		else
			$current_turbidity = $gauge_data[4] . ' FNU';
		
		//.....................................
		// PH 
		if ($gauge_data[5] == '')	
			$current_ph = '?';
		else
			$current_ph = $gauge_data[5];
			
		
?>		<br>
		
<table border=0>
  <tr> 
    <td width="97" valign="middle"><strong>Name:</strong></td>
    <td width="10" valign="top">&nbsp;</td>
    <td width="153" align=center valign="middle" bgcolor="#FFFFCC"><strong><?php echo $row['mystery_spot_name']; ?></strong></td>
    <td width="3" valign="top">&nbsp;</td>
    <td width="103" valign="top" bordercolor="#000000" bgcolor="#FFFFFF"><strong><font color="#FF6600">Current 
      Flow:</font></strong></td>
    <td width="500"  valign="top" bordercolor="#000000" bgcolor="#FFFFFF"><strong><?php echo $current_flow; ?></strong></td>
  </tr>
  <tr> 
    <td  valign="top"><strong>River:</strong></td>
    <td valign="top">&nbsp;</td>
    <td valign="top"><input name="text" size=25 type=text value="<?php echo $row['river']; ?>" readonly /></td>
    <td valign="top">&nbsp;</td>
<td  valign="top" bordercolor="#000000" bgcolor="#FFFFFF"><strong><font color="#FF6600">Water Temp:</font></strong></td>
    <td   valign="top" bordercolor="#000000" bgcolor="#FFFFFF"><strong><?php echo $current_water_temp_F . ' ' . $current_water_temp_C; ?></strong></td>

  </tr>
  <tr> 
    <td  valign="top"><strong>Country:</strong></td>
    <td valign="top">&nbsp;</td>
    <td valign="top"><input size=1 type=text readonly value="<?php echo $row['country']; ?>" /> <?php echo $country_flag; ?></td>
    <td valign="top">&nbsp;</td>
<td  valign="top" bordercolor="#000000" bgcolor="#FFFFFF"><strong><font color="#FF6600">Turbidity:</font></strong></td>
    <td   valign="top" bordercolor="#000000" bgcolor="#FFFFFF"><strong><?php echo $current_turbidity; ?></strong></td>

  </tr>
  <tr> 
    <td  valign="top"><strong>Region:</strong></td>
    <td valign="top">&nbsp;</td>
    <td valign="top"><input name="Input" value="<?php echo $row['region']; ?>" size=25 type=text readonly /></td>
    <td valign="top">&nbsp;</td>
<td  valign="top" bordercolor="#000000" bgcolor="#FFFFFF"><strong><font color="#FF6600">PH:</font></strong></td>
    <td   valign="top" bordercolor="#000000" bgcolor="#FFFFFF"><strong><?php echo $current_ph; ?></strong></td>

  </tr>

  <tr> 
    <td  valign="top"><strong>State:</strong></td>
    <td valign="top">&nbsp;</td>
    <td valign="top"><input name="Input" value="<?php echo $row['state']; ?>" size=25 type=text readonly /></td>
    <td>&nbsp;</td>
    <td valign="top" bordercolor="#000000"><strong>Min Flow:</strong></td>
    <td valign="top" bordercolor="#000000"><?php echo $ideal_min_flow; ?></td>
 </tr>
  <tr> 
    <td ><strong>City:</strong></td>
    <td>&nbsp;</td>
    <td><input size=25 type=text readonly value="<?php echo $row['city']; ?>" /></td>
    <td>&nbsp;</td>
    <td valign="top" bordercolor="#000000"><strong>Ideal Flow:</strong></td>
    <td valign="top" bordercolor="#000000"><?php echo $ideal_flow; ?></td>     
	  </tr>
  <tr> 
    <td><strong>Lat, Long:</strong></td>
    <td>&nbsp;</td>
    <td><input size=25 type=text readonly value="<?php echo $row['latitude']; ?>,<?php echo $row['longitude']; ?>" /></td>
    <td>&nbsp;</td>
    <td valign="top" bordercolor="#000000"><strong>Max Flow:</strong></td>
    <td valign="top" bordercolor="#000000"><?php echo $ideal_max_flow; ?></td>
  </tr>
  <tr> 
    <td><strong>Gage Name:</strong></td>
    <td>&nbsp;</td>
    <td><input size=25 type=text readonly value="<?php echo $row['gauge_name']; ?>" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td ><strong>USGS Gage#:</strong></td>
    <td>&nbsp;</td>
    <td><input size=25 type=text readonly value="<?php echo $row['gauge_number']; ?>" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr> 
    <td><strong>Gage Url:</strong></td>
    <td>&nbsp;</td>
	<?php if ($row['gauge_url'] == '') { ?>
		<td colspan=5><i>none defined.. find one at <a href="http://waterdata.usgs.gov/nwis/rt" target="_blank">USGS</a></i></td>
    <?php }else { ?>	
		<td colspan=5><a href=<?php echo $row['gauge_url']; ?> target=_blank><?php echo $row['gauge_url']; ?></a></td>
	<?php }?>	
  </tr>
     <tr> 
    <td><strong>Predict Url:</strong></td>
    <td>&nbsp;</td>
    <?php if ($row['prediction_url'] == '') {?>
		<td colspan=5><i>none defined... find one at <a href="http://www.weather.gov/ahps/rfc/rfc.php" target="_blank">NOAA</a></i></td>
    <?php } else { ?>
	<td colspan=5><a href=<?php echo $row['prediction_url']; ?> target=_blank><?php echo $row['prediction_url']; ?></a></td>
	<?php } ?>
  </tr>
  <tr> 
    <td valign="top"><p><strong>Notes &amp;</strong><br>
        <strong>Directions:</strong></p></td>
    <td>&nbsp;</td>
    <td colspan=4 valign=top><textarea name=notes readonly cols=67 rows=20><?php echo $row['notes']; ?></textarea></td>
  </tr>
	  <tr>
  		<td><strong>Quality:</strong></td>
		<td colspan=4><nobr>		
		<?php 
			if ($row['spot_quality'] == "poor") 
		{
			echo "
			<input type=radio name=spot_quality value=exploratory readonly> Exploratory
			<input type=radio name=spot_quality value=poor checked=checked readonly> Poor
			<input type=radio name=spot_quality value=moderate readonly> Moderate
			<input type=radio name=spot_quality value=great readonly> Great
			<input type=radio name=spot_quality value=epic  readonly> Epic
			";
		}
		else if ($row['spot_quality'] == "moderate")
		{
			echo "
			<input type=radio name=spot_quality value=exploratory readonly> Exploratory
			<input type=radio name=spot_quality value=poor readonly> Poor
			<input type=radio name=spot_quality value=moderate checked=checked readonly> Moderate
			<input type=radio name=spot_quality value=great readonly> Great
			<input type=radio name=spot_quality value=epic  readonly> Epic
			";
        }
		else if ($row['spot_quality'] == "great")
		{
			echo "
			<input type=radio name=spot_quality value=exploratory readonly> Exploratory
			<input type=radio name=spot_quality value=poor readonly> Poor
			<input type=radio name=spot_quality value=moderate readonly> Moderate
			<input type=radio name=spot_quality value=great checked=checked readonly> Great
			<input type=radio name=spot_quality value=epic readonly > Epic
			";
		}
		else if ($row['spot_quality'] == "epic")
		{
			echo "
				<input type=radio name=spot_quality value=exploratory readonly> Exploratory
			<input type=radio name=spot_quality value=poor readonly> Poor
			<input type=radio name=spot_quality value=moderate readonly> Moderate
			<input type=radio name=spot_quality value=great readonly> Great
			<input type=radio name=spot_quality value=epic  checked=checked readonly> Epic
			";
		}
		else // exploratory
		{
			echo "
				<input type=radio name=spot_quality value=exploratory checked=checked readonly> Exploratory
			<input type=radio name=spot_quality value=poor readonly> Poor
			<input type=radio name=spot_quality value=moderate readonly> Moderate
			<input type=radio name=spot_quality value=great readonly> Great
			<input type=radio name=spot_quality value=epic readonly> Epic
			";
		}
		//.........
	
		?>
		</nobr></td>
  </tr>
</table>
<?php
	
	} // end if (!$row)
	 
	//....................................................................
	// now print out the links at the bottom.. to ADD, EDIT or DELETE...  
	echo "<br>";
               
	// if no is currently selected, then the spot_id will be "none", so dont display the edit, or delete links, since that makes no sense...
	if ($spot_id != "none") 
	{
		// display the "Edit" link..
		echo "<div align=center>";
		echo "[<a href=spot_maintenance.php?spot_id=" . $spot_id . "&action=update><em><font color=#0000FF>Edit Spot</FONT></em></a>]";
		echo "</div>";
														       
		// if the current user is ADMIN, then display the "Delete" link.. otherwise, display the "Request Delete" link
		if ($_SESSION['ADMIN_USER'] == "TRUE")
		{
			echo "<div align=center>";
			echo " [<a href=spot_maintenance.php?spot_id=" . $spot_id . "&action=delete><em><font color=#0000FF>Delete Spot</FONT></em></a>]";
			echo "</div>";
		}
		else
		{
			echo "<div align=center>";
			echo " [<a href=spot_maintenance.php?spot_id=" . $spot_id . "&action=request_delete><em><font color=#0000FF>Request Delete</FONT></em></a>]";
			echo "</div>";
		}	
	}
					 
} // end function build_mystery_spot_info($spot_id)


			//Name:<br>
			//River:<br>
			//Min:<br>
			//Current Level:<br>
			//Max:
			
function build_mystery_spot_info_mini($spot_id)
{	


/*	
	// protect from sql injection		
	$spot_id = strip_invalid_chars($spot_id);
			
	//select all the mystery spots...
	$sql = "SELECT * FROM `mystery_spots` WHERE `spot_id` = '" . $spot_id . "'";
	
	// execute it....
	$result = mysql_query($sql);
	if (!$result) // did we get it?
  	{                                                                            
		// handle sql error....
		handle_sql_error("build_mystery_spot_info($spot_id)", $sql);		
  	}

	// assuming this spot is in the db... grab its data... 
	$row = mysql_fetch_array($result, MYSQL_ASSOC); 
	if (!$row)
	{
		echo "";
	}
	else
	{	


		// get the current flow from usgs...
		$gauge_data = get_current_flow( $row["gauge_number"], $row["flow_type"] );
 
 		// get the color for it... if its "in" this will be green, if its not "in" it will be red, otherwise it will be blue
		$color = get_color_for_spot($row["gauge_number"], $spot_id, $row["flow_type"]);		
		
		// did we find the gauge?
		if ($gauge_data[0] == "") 
		{
			// in case we didnt find the gauge, let the user know how to fix it... 
			// this text will be colored blue...
			$current_flow = "<font color=" . $color . ">Please Enter USGS Gage #</font>";
		}
		else if ($gauge_data[0] == "Ssn")
		{		 
			// this text will be colored either red or green, depending if the spot is "in"
			$current_flow = "<font color=" . $color . ">Gage operated seasonally. </font>" . " Recorded on " . $gauge_data[1];	
		} // end else ...
		else
		{
			// this text will be colored either red or green, depending if the spot is "in"
			$current_flow = "<font color=" . $color . ">" . $gauge_data[0] . get_flow_type_from_id($row['spot_id']) . "</font>" . " Recorded on " . $gauge_data[1];	
		} // end else ...
		
		// evaluate if there is a min and max set in the db, and display a message accordingly
		if ($row['ideal_min_flow'] == "") 
		 	$ideal_min_flow = "<font color=" . $color . ">NO MIN</font>";
		else
			$ideal_min_flow = $row['ideal_min_flow'] . get_flow_type_from_id($row['spot_id']);
		 
		if ($row['ideal_max_flow'] == "") 
		 	$ideal_max_flow = "<font color=" . $color . ">NO MAX</font>";
		else
			$ideal_max_flow = $row['ideal_max_flow'] . get_flow_type_from_id($row['spot_id']); 
		
		if ($row['ideal_flow'] == "") 
		 	$ideal_flow = "";
		else
			$ideal_flow = $row['ideal_flow'] . get_flow_type_from_id($row['spot_id']); 

		//...............................
		// get the country flag 
		$this_country = strtolower($row["country"]);
		
		// get a hint for it.
		if ($this_country == 'gb')
			$hint = 'Great Britian';
		else if ($this_country == 'us')
			$hint = 'United States';
		else if ($this_country == 'jp')
			$hint = 'Japan';
		else if ($this_country == 'es')
			$hint = 'Spain';
		else if ($this_country == 'fr')
			$hint = 'France';
		else if ($this_country == 'ca')
			$hint = 'Canada';
		else if ($this_country == 'ch')
			$hint = 'Switzerland';
		else if ($this_country == 'ie')
			$hint = 'Ireland';
		else if ($this_country == 'nz')
			$hint = 'New Zealand';		
		else 
			$hint = 'Im a computer and i dont know what country this is...';
				
		$country_flag = ' <img src="http://sinkspots.org/flags/gif/'. strtolower($this_country).'.gif" alt= "'.$hint.'" title="'.$hint.'"/>';

		// print the info out..
		
		//.....................
		// WATER TEMP
		if (trim($gauge_data[2]) == '')
			$current_water_temp_C = '';
		else
			$current_water_temp_C = trim($gauge_data[2]) . ' *C';
			
		if (trim($gauge_data[3]) == '')
			$current_water_temp_F = '';
		else
			$current_water_temp_F = trim($gauge_data[3]) . ' *F';
		
	 
		
	   if ((trim($gauge_data[3]) == '') && (trim($gauge_data[2]) != ''))
			$current_water_temp_F = '' . ((trim($gauge_data[2]) * 9) / 5) + 32 . ' *F';
 
 

		//........................
		// TUBERDITY
		if ($gauge_data[4] == '')	
			$current_turbidity = '?';
		else
			$current_turbidity = $gauge_data[4] . ' FNU';
		
		//.....................................
		// PH 
		if ($gauge_data[5] == '')	
			$current_ph = '?';
		else
			$current_ph = $gauge_data[5];
*/			
		
//echo 'asdlkfj';		
		// ......................................
		// PRINT THE INFO IN THE MINI PANEL ON THE LEFT		
		//echo "Name:" . $row['mystery_spot_name'] . "<br>";
//		echo "River: $row['river']<br>";
//		echo "Current Flow: $current_flow<br>";
//		echo "Water Temp: $current_water_temp_F . ' ' . $current_water_temp_C<br>";
//		echo "PH: $current_ph<br>";
//		echo "Turbidity: $current_turbidity<br>";
		
//		echo "State: $row['state']<br>";
//		echo "City: $row['city']<br>";
//		echo "Country: $row['country'] $country_flag<br>";
//		echo "Region: $row['region']<br>";
//		echo "Lat, Long: $row['latitude'], $row['longitude']<br>";
//		
//		echo "Min Flow: $ideal_min_flow<br>";
//		echo "Ideal Flow: $ideal_flow<br>";
//		echo "Max Flow: $ideal_max_flow<br>";
//		
//		echo "Gage Name: $row['gauge_name']<br>";
//		echo "USGS Gage#: $row['gauge_number']<br>";
//		
//		echo "Gage Url:";
//		if ($row['gauge_url'] == '') { 
//				echo "<i>none</i><br>";
//		}else {	
//			echo "<a href=$row['gauge_url'] target=_blank>$row['gauge_number']</a><br>";
//		}	
//		
//		echo "Predict Url:"; 
//		if ($row['prediction_url'] == '') {
//			echo "<i>none</i><br>";
//		     } else { 
//		echo "<a href=$row['prediction_url'] target=_blank> $row['prediction_url']</a><br>";
//		}
//		
//		echo "Quality: $row['spot_quality']<br>";
	

	
	//} // end if (!$row)
	

	 
	 /*
	//....................................................................
	// now print out the links at the bottom.. to ADD, EDIT or DELETE...  
	echo "<br>";
               
	// if no is currently selected, then the spot_id will be "none", so dont display the edit, or delete links, since that makes no sense...
	if ($spot_id != "none") 
	{
		// display the "Edit" link..
		echo "<div align=center>";
		echo "[<a href=spot_maintenance.php?spot_id=" . $spot_id . "&action=update><em><font color=#0000FF>Edit Spot</FONT></em></a>]";
		echo "</div>";
														       
		// if the current user is ADMIN, then display the "Delete" link.. otherwise, display the "Request Delete" link
		if ($_SESSION['ADMIN_USER'] == "TRUE")
		{
			echo "<div align=center>";
			echo " [<a href=spot_maintenance.php?spot_id=" . $spot_id . "&action=delete><em><font color=#0000FF>Delete Spot</FONT></em></a>]";
			echo "</div>";
		}
		else
		{
			echo "<div align=center>";
			echo " [<a href=spot_maintenance.php?spot_id=" . $spot_id . "&action=request_delete><em><font color=#0000FF>Request Delete</FONT></em></a>]";
			echo "</div>";
		}	
	}
	*/				 
} // end function build_mystery_spot_info_mini($spot_id)
			
//****************************************************************************************************************************************
// This function builds a table of all the journal entries for the spot that you pass in as a parameter...
function build_gatherings_list($spot_id, $timeline)
{
	// get the current date..
 	$today = strtotime(date());
	
	if ($timeline == 'old')
		$sql = "SELECT * FROM `gatherings` WHERE `end_date` < '" . date("Y-m-d") . "' ORDER BY `start_date` DESC";
	else if ($timeline == 'new')
		$sql = "SELECT * FROM `gatherings` WHERE `end_date` >= '" . date("Y-m-d") . "' ORDER BY `start_date` ASC";
	else 
		$sql = "SELECT * FROM `gatherings` ORDER BY `end_date` DESC";

	//select all the journal entries for this mystery spot...
	 
	if (!mysql_query($sql))
  	{                                                                            
		// handle sql error....
		handle_sql_error("build_gatherings_list()", $sql);
  	} 
 	
	// get the result set....
	$result = mysql_query($sql);

	// roll through the record set and list the spots...
	 
	
	// what is the mystery_spot_name of this id? we are going to display it below...
	//$mystery_spot_name = get_mystery_spot_name_from_id($spot_id);
	
	// are there any records?
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	if (!$row)
	{
		echo "There are no gatherings entered yet...";
	}
	else
	{
		// open the table 
		echo "<table width=100% border=0>";

	 
		
		// print the gatherings to the screen.. 
		// if the current user is ADMIN, show the edit and delete links... 
		if ($_SESSION['ADMIN_USER'] == "TRUE") 
			echo "<td rowspan=3 valign=middle><a href=gatherings_maintenance.php?spot_id=" . $spot_id . "&gathering_id=" . $row['gathering_id'] . "&action=update><font color=#0000FF>edit</font></a> <a href=gathering_maintenance.php?spot_id=" . $spot_id . "&gathering_id=" . $row['gathering_id'] . "&action=delete><font color=#0000FF>delete</font></a></td>";
		else // otherwies, just show the edit link...
			echo "<td rowspan=3 valign=middle><a href=gatherings_maintenance.php?spot_id=" . $spot_id . "&gathering_id=" . $row['gathering_id'] . "&action=update><font color=#0000FF>edit</font></a> </td>";
					
		//..........................................................................
		// DATE FORMAT EXAMPLES: 
		//.......................................................................
		/**** format the raw date into a 04-13-2007 12:23:60 AM  **/
		// $my_date_time = FormatMyDate($row['explore_date'], "m-d-Y g:i:s A" ); //  has second on time
		//...........................................................................
		/**** format the raw date into a 04-13-2007 12:23 AM **/
		// $my_date_time = FormatMyDate($row['end_date'], "m-d-Y g:i A" ); // no seconds on time			
		//.........................................................................
		/*** Format the raw date into a "Saturday May 13th 2007" */
		// $my_date_time = FormatMyDate($row['start_date'], "l M jS Y"); // no time
		//...................................................................................
		
		echo "<td align=center width=200px><strong><a target=_blank href=" . $row['gathering_url'] . ">" . $row['gathering_name'] . "</a></strong></td>";						
		echo "<td align=left valign=left style=gathering_date>" . FormatMyDate($row['start_date'], "l M jS Y") . ' - ' . FormatMyDate($row['end_date'], "l M jS Y" ) . "</td>";	
		echo "</tr><tr>"; 
		
		echo "<td colspan=2 align=left><textarea name=gathering_info readonly=true cols=70 rows=6>" . $row['gathering_info'] . "</textarea></td>";
		echo "</tr><tr>"; 
		
		echo "<td colspan=2 align=left><nobr>Gathering URL: <a target=_blank href=" . $row['gathering_url'] . "><font color=#0000FF>" . $row['gathering_url'] . "</font></a></nobr></td>";

		echo "</tr><tr>";
		echo "<td></td><td colspan=2 align=left>Spot: <a href=http://www.sinkspots.org/index.php?spot_id=" . $row['spot_id_1'] . "><font color=#0000FF>" . get_mystery_spot_name_from_id($row['spot_id_1']) . "</font></a></td>";
		
		
		if ((trim($row['spot_id_2']) != '') && (trim($row['spot_id_2']) != null) && (trim($row['spot_id_2']) != '0'))
		{ 
			echo "</tr><tr>";
			echo "<td></td><td colspan=2 align=left>Alt Spot 1: <a  href=http://www.sinkspots.org/index.php?spot_id=" . $row['spot_id_2'] . "><font color=#0000FF>" . get_mystery_spot_name_from_id($row['spot_id_2']) . "</font></a></td>";
		}
		
		if ((trim($row['spot_id_3']) != '') && (trim($row['spot_id_3']) != null) && (trim($row['spot_id_3']) != '0'))
		{ 	
			echo "</tr><tr>";
			echo "<td></td><td colspan=2 align=left>Alt Spot 2: <a   href=http://www.sinkspots.org/index.php?spot_id=" . $row['spot_id_3'] . "><font color=#0000FF>" . get_mystery_spot_name_from_id($row['spot_id_3']) . "</font></a></td>";
		}
		
		if ((trim($row['spot_id_4']) != '') && (trim($row['spot_id_4']) != null) && (trim($row['spot_id_4']) != '0'))
		{	
			echo "</tr><tr>";
			echo "<td></td><td colspan=2 align=left>Alt Spot 3: <a  href=http://www.sinkspots.org/index.php?spot_id=" . $row['spot_id_4'] . "><font color=#0000FF>" . get_mystery_spot_name_from_id($row['spot_id_4']) . "</font></a></td>";
		}
		 
		if ((trim($row['spot_id_5']) != '') && (trim($row['spot_id_5']) != 'NULL') && (trim($row['spot_id_5']) != '0'))
		{	
			echo "</tr><tr>";
			echo "<td></td><td colspan=2 align=left>Alt Spot 4: <a   href=http://www.sinkspots.org/index.php?spot_id=" . $row['spot_id_5'] . "><font color=#0000FF>" . get_mystery_spot_name_from_id($row['spot_id_5']) . "</font></a></td>";
		}			 
		//
		//echo "<td  align=left valign=center size=100></td>";
		
		// close this table row..
		echo "</tr>";
		
		echo "<tr>";
		echo "<td><br></td><td><br></td><td><br></td>";
		echo "</tr>";
		
		echo "<tr>";
		echo "<td><br></td><td><br></td><td><br></td>";
		echo "</tr>";
		// see if there are any other rows...
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 
		{
		
			// open this table row...
			echo "<tr>";

			// print the gatherings to the screen.. 
			// if the current user is ADMIN, show the edit and delete links... 
			if ($_SESSION['ADMIN_USER'] == "TRUE") 
				echo "<td rowspan=3 valign=middle><a href=gatherings_maintenance.php?spot_id=" . $spot_id . "&gathering_id=" . $row['gathering_id'] . "&action=update><font color=#0000FF>edit</font></a> <a href=gathering_maintenance.php?spot_id=" . $spot_id . "&gathering_id=" . $row['gathering_id'] . "&action=delete><font color=#0000FF>delete</font></a></td>";
			else // otherwies, just show the edit link...
				echo "<td rowspan=3 valign=middle><a href=gatherings_maintenance.php?spot_id=" . $spot_id . "&gathering_id=" . $row['gathering_id'] . "&action=update><font color=#0000FF>edit</font></a> </td>";
						
			//..........................................................................
			// DATE FORMAT EXAMPLES: 
			//.......................................................................
			/**** format the raw date into a 04-13-2007 12:23:60 AM  **/
			// $my_date_time = FormatMyDate($row['explore_date'], "m-d-Y g:i:s A" ); //  has second on time
			//...........................................................................
			/**** format the raw date into a 04-13-2007 12:23 AM **/
			// $my_date_time = FormatMyDate($row['end_date'], "m-d-Y g:i A" ); // no seconds on time			
	   		//.........................................................................
			/*** Format the raw date into a "Saturday May 13th 2007" */
			// $my_date_time = FormatMyDate($row['start_date'], "l M jS Y"); // no time
			//...................................................................................
						
		
		echo "<td align=center width=200px  ><strong><a target=_blank href=" . $row['gathering_url'] . ">" . $row['gathering_name'] . "</a></strong></td>";						
		echo "<td align=left style=gathering_date>" . FormatMyDate($row['start_date'], "l M jS Y") . ' - ' . FormatMyDate($row['end_date'], "l M jS Y" ) . "</td>";	
		echo "</tr><tr>"; 
		
		echo "<td colspan=2 align=left><textarea name=gathering_info readonly=true cols=70 rows=6>" . $row['gathering_info'] . "</textarea></td>";
		echo "</tr><tr>"; 
		
		//echo "<td align=left>Gathering Homepage</td>";
		echo "<td  colspan=2 align=left valign=center ><nobr>Gathering URL: <a  target=_blank href=" . $row['gathering_url'] . "><font color=#0000FF>" . $row['gathering_url'] . "</font></a></nobr></td>";
		
		echo "</tr><tr>";
		echo "<td></td><td colspan=2 align=left>Spot: <a   href=http://www.sinkspots.org/index.php?spot_id=" . $row['spot_id_1'] . "><font color=#0000FF>" . get_mystery_spot_name_from_id($row['spot_id_1']) . "</font></a></td>";
		
		
		if ((trim($row['spot_id_2']) != '') && (trim($row['spot_id_2']) != null) && (trim($row['spot_id_2']) != '0'))
		{ 
			echo "</tr><tr>";
			echo "<td></td><td colspan=2 align=left>Alt Spot 1: <a   href=http://www.sinkspots.org/index.php?spot_id=" . $row['spot_id_2'] . "><font color=#0000FF>" . get_mystery_spot_name_from_id($row['spot_id_2']) . "</font></a></td>";
		}
		
		if ((trim($row['spot_id_3']) != '') && (trim($row['spot_id_3']) != null) && (trim($row['spot_id_3']) != '0'))
		{ 	
			echo "</tr><tr>";
			echo "<td></td><td colspan=2 align=left>Alt Spot 2: <a   href=http://www.sinkspots.org/index.php?spot_id=" . $row['spot_id_3'] . "><font color=#0000FF>" . get_mystery_spot_name_from_id($row['spot_id_3']) . "</font></a></td>";
		}
		
		if ((trim($row['spot_id_4']) != '') && (trim($row['spot_id_4']) != null) && (trim($row['spot_id_4']) != '0'))
		{	
			echo "</tr><tr>";
			echo "<td></td><td colspan=2 align=left>Alt Spot 3: <a   href=http://www.sinkspots.org/index.php?spot_id=" . $row['spot_id_4'] . "><font color=#0000FF>" . get_mystery_spot_name_from_id($row['spot_id_4']) . "</font></a></td>";
		}
		 
		if ((trim($row['spot_id_5']) != '') && (trim($row['spot_id_5']) != 'NULL') && (trim($row['spot_id_5']) != '0'))
		{	
			echo "</tr><tr>";
			echo "<td></td><td colspan=2 align=left>Alt Spot 4: <a   href=http://www.sinkspots.org/index.php?spot_id=" . $row['spot_id_5'] . "><font color=#0000FF>" . get_mystery_spot_name_from_id($row['spot_id_5']) . "</font></a></td>";
		}		
		
		
		
		// close this table row..
		echo "</tr>";
		
		echo "<tr>";
		echo "<td><br></td><td><br></td><td><br></td>";
		echo "</tr>";		
		echo "<tr>";
		echo "<td><br></td><td><br></td><td><br></td>";
		echo "</tr>";
		} // end while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 

		// close the table...
		echo "</table>";

	} // end if ($result)
	
} // end function build_journal_entry_list($currently_selected_spot)

//******************************************************************************************************8

// This function builds a table of all the journal entries for the spot that you pass in as a parameter...
function build_gatherings_list_for_this_spot($spot_id )
{
	// get the current date..
 	$today = strtotime(date());
	
 
	$sql = "SELECT * FROM `gatherings` WHERE `end_date` >= '" . date("Y-m-d") . "'  AND ((`spot_id_1` = '$spot_id') OR (`spot_id_2` = '$spot_id') OR (`spot_id_3` = '$spot_id') OR (`spot_id_4` = '$spot_id') OR (`spot_id_5` = '$spot_id')) AND ('$spot_id' != 'none') AND ('$spot_id' != '') ORDER BY `start_date` ASC";
 
	//die($sql);
	//select all the journal entries for this mystery spot... 
	if (!mysql_query($sql))
  	{                                                                            
	
		// handle sql error....
		handle_sql_error("build_gatherings_listfor this spot()", $sql);
  	} 
 	
	// get the result set....
	$result = mysql_query($sql);

	// roll through the record set and list the spots...
	 
	
	// what is the mystery_spot_name of this id? we are going to display it below...
	//$mystery_spot_name = get_mystery_spot_name_from_id($spot_id);
	
	// are there any records?
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	if (!$row)
	{
		echo "";
	}
	else
	{
		// open the table 
		echo "<h2><font color=orange>Up Coming Gatherings at ". get_mystery_spot_name_from_id($spot_id) . " !</font></h2>";
		echo "<table width=100% border=0>";

	 
		
		// print the gatherings to the screen.. 
		// if the current user is ADMIN, show the edit and delete links... 
		if ($_SESSION['ADMIN_USER'] == "TRUE") 
			echo "<td rowspan=3 valign=middle><a href=gatherings_maintenance.php?spot_id=" . $spot_id . "&gathering_id=" . $row['gathering_id'] . "&action=update><font color=#0000FF>edit</font></a> <a href=gathering_maintenance.php?spot_id=" . $spot_id . "&gathering_id=" . $row['gathering_id'] . "&action=delete><font color=#0000FF>delete</font></a></td>";
		else // otherwies, just show the edit link...
			echo "<td rowspan=3 valign=middle><a href=gatherings_maintenance.php?spot_id=" . $spot_id . "&gathering_id=" . $row['gathering_id'] . "&action=update><font color=#0000FF>edit</font></a> </td>";
					
		//..........................................................................
		// DATE FORMAT EXAMPLES: 
		//.......................................................................
		/**** format the raw date into a 04-13-2007 12:23:60 AM  **/
		// $my_date_time = FormatMyDate($row['explore_date'], "m-d-Y g:i:s A" ); //  has second on time
		//...........................................................................
		/**** format the raw date into a 04-13-2007 12:23 AM **/
		// $my_date_time = FormatMyDate($row['end_date'], "m-d-Y g:i A" ); // no seconds on time			
		//.........................................................................
		/*** Format the raw date into a "Saturday May 13th 2007" */
		// $my_date_time = FormatMyDate($row['start_date'], "l M jS Y"); // no time
		//...................................................................................
		
		echo "<td align=center width=200px><strong><a target=_blank href=" . $row['gathering_url'] . ">" . $row['gathering_name'] . "</a></strong></td>";						
		echo "<td align=left valign=left style=gathering_date>" . FormatMyDate($row['start_date'], "l M jS Y") . ' - ' . FormatMyDate($row['end_date'], "l M jS Y" ) . "</td>";	
		echo "</tr><tr>"; 
		
		echo "<td colspan=2 align=left><textarea name=gathering_info readonly=true cols=70 rows=6>" . $row['gathering_info'] . "</textarea></td>";
		echo "</tr><tr>"; 
		
		echo "<td colspan=2 align=left><nobr>Gathering URL: <a target=_blank href=" . $row['gathering_url'] . "><font color=#0000FF>" . $row['gathering_url'] . "</font></a></nobr></td>";

		echo "</tr><tr>";
		echo "<td></td><td colspan=2 align=left>Spot: <a href=http://www.sinkspots.org/index.php?spot_id=" . $row['spot_id_1'] . "><font color=#0000FF>" . get_mystery_spot_name_from_id($row['spot_id_1']) . "</font></a></td>";
		
		
		if ((trim($row['spot_id_2']) != '') && (trim($row['spot_id_2']) != null) && (trim($row['spot_id_2']) != '0'))
		{ 
			echo "</tr><tr>";
			echo "<td></td><td colspan=2 align=left>Alt Spot 1: <a  href=http://www.sinkspots.org/index.php?spot_id=" . $row['spot_id_2'] . "><font color=#0000FF>" . get_mystery_spot_name_from_id($row['spot_id_2']) . "</font></a></td>";
		}
		
		if ((trim($row['spot_id_3']) != '') && (trim($row['spot_id_3']) != null) && (trim($row['spot_id_3']) != '0'))
		{ 	
			echo "</tr><tr>";
			echo "<td></td><td colspan=2 align=left>Alt Spot 2: <a   href=http://www.sinkspots.org/index.php?spot_id=" . $row['spot_id_3'] . "><font color=#0000FF>" . get_mystery_spot_name_from_id($row['spot_id_3']) . "</font></a></td>";
		}
		
		if ((trim($row['spot_id_4']) != '') && (trim($row['spot_id_4']) != null) && (trim($row['spot_id_4']) != '0'))
		{	
			echo "</tr><tr>";
			echo "<td></td><td colspan=2 align=left>Alt Spot 3: <a  href=http://www.sinkspots.org/index.php?spot_id=" . $row['spot_id_4'] . "><font color=#0000FF>" . get_mystery_spot_name_from_id($row['spot_id_4']) . "</font></a></td>";
		}
		 
		if ((trim($row['spot_id_5']) != '') && (trim($row['spot_id_5']) != 'NULL') && (trim($row['spot_id_5']) != '0'))
		{	
			echo "</tr><tr>";
			echo "<td></td><td colspan=2 align=left>Alt Spot 4: <a   href=http://www.sinkspots.org/index.php?spot_id=" . $row['spot_id_5'] . "><font color=#0000FF>" . get_mystery_spot_name_from_id($row['spot_id_5']) . "</font></a></td>";
		}			 
		//
		//echo "<td  align=left valign=center size=100></td>";
		
		// close this table row..
		echo "</tr>";
		
		echo "<tr>";
		echo "<td><br></td><td><br></td><td><br></td>";
		echo "</tr>";
		
		echo "<tr>";
		echo "<td><br></td><td><br></td><td><br></td>";
		echo "</tr>";
		// see if there are any other rows...
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 
		{
		
			// open this table row...
			echo "<tr>";

			// print the gatherings to the screen.. 
			// if the current user is ADMIN, show the edit and delete links... 
			if ($_SESSION['ADMIN_USER'] == "TRUE") 
				echo "<td rowspan=3 valign=middle><a href=gatherings_maintenance.php?spot_id=" . $spot_id . "&gathering_id=" . $row['gathering_id'] . "&action=update><font color=#0000FF>edit</font></a> <a href=gathering_maintenance.php?spot_id=" . $spot_id . "&gathering_id=" . $row['gathering_id'] . "&action=delete><font color=#0000FF>delete</font></a></td>";
			else // otherwies, just show the edit link...
				echo "<td rowspan=3 valign=middle><a href=gatherings_maintenance.php?spot_id=" . $spot_id . "&gathering_id=" . $row['gathering_id'] . "&action=update><font color=#0000FF>edit</font></a> </td>";
						
			//..........................................................................
			// DATE FORMAT EXAMPLES: 
			//.......................................................................
			/**** format the raw date into a 04-13-2007 12:23:60 AM  **/
			// $my_date_time = FormatMyDate($row['explore_date'], "m-d-Y g:i:s A" ); //  has second on time
			//...........................................................................
			/**** format the raw date into a 04-13-2007 12:23 AM **/
			// $my_date_time = FormatMyDate($row['end_date'], "m-d-Y g:i A" ); // no seconds on time			
	   		//.........................................................................
			/*** Format the raw date into a "Saturday May 13th 2007" */
			// $my_date_time = FormatMyDate($row['start_date'], "l M jS Y"); // no time
			//...................................................................................
						
		
		echo "<td align=center width=200px  ><strong><a target=_blank href=" . $row['gathering_url'] . ">" . $row['gathering_name'] . "</a></strong></td>";						
		echo "<td align=left style=gathering_date>" . FormatMyDate($row['start_date'], "l M jS Y") . ' - ' . FormatMyDate($row['end_date'], "l M jS Y" ) . "</td>";	
		echo "</tr><tr>"; 
		
		echo "<td colspan=2 align=left><textarea name=gathering_info readonly=true cols=70 rows=6>" . $row['gathering_info'] . "</textarea></td>";
		echo "</tr><tr>"; 
		
		//echo "<td align=left>Gathering Homepage</td>";
		echo "<td  colspan=2 align=left valign=center ><nobr>Gathering URL: <a  target=_blank href=" . $row['gathering_url'] . "><font color=#0000FF>" . $row['gathering_url'] . "</font></a></nobr></td>";
		
		echo "</tr><tr>";
		echo "<td></td><td colspan=2 align=left>Spot: <a   href=http://www.sinkspots.org/index.php?spot_id=" . $row['spot_id_1'] . "><font color=#0000FF>" . get_mystery_spot_name_from_id($row['spot_id_1']) . "</font></a></td>";
		
		
		if ((trim($row['spot_id_2']) != '') && (trim($row['spot_id_2']) != null) && (trim($row['spot_id_2']) != '0'))
		{ 
			echo "</tr><tr>";
			echo "<td></td><td colspan=2 align=left>Alt Spot 1: <a   href=http://www.sinkspots.org/index.php?spot_id=" . $row['spot_id_2'] . "><font color=#0000FF>" . get_mystery_spot_name_from_id($row['spot_id_2']) . "</font></a></td>";
		}
		
		if ((trim($row['spot_id_3']) != '') && (trim($row['spot_id_3']) != null) && (trim($row['spot_id_3']) != '0'))
		{ 	
			echo "</tr><tr>";
			echo "<td></td><td colspan=2 align=left>Alt Spot 2: <a   href=http://www.sinkspots.org/index.php?spot_id=" . $row['spot_id_3'] . "><font color=#0000FF>" . get_mystery_spot_name_from_id($row['spot_id_3']) . "</font></a></td>";
		}
		
		if ((trim($row['spot_id_4']) != '') && (trim($row['spot_id_4']) != null) && (trim($row['spot_id_4']) != '0'))
		{	
			echo "</tr><tr>";
			echo "<td></td><td colspan=2 align=left>Alt Spot 3: <a   href=http://www.sinkspots.org/index.php?spot_id=" . $row['spot_id_4'] . "><font color=#0000FF>" . get_mystery_spot_name_from_id($row['spot_id_4']) . "</font></a></td>";
		}
		 
		if ((trim($row['spot_id_5']) != '') && (trim($row['spot_id_5']) != 'NULL') && (trim($row['spot_id_5']) != '0'))
		{	
			echo "</tr><tr>";
			echo "<td></td><td colspan=2 align=left>Alt Spot 4: <a   href=http://www.sinkspots.org/index.php?spot_id=" . $row['spot_id_5'] . "><font color=#0000FF>" . get_mystery_spot_name_from_id($row['spot_id_5']) . "</font></a></td>";
		}		
		
		
		
		// close this table row..
		echo "</tr>";
		
		echo "<tr>";
		echo "<td><br></td><td><br></td><td><br></td>";
		echo "</tr>";		
		echo "<tr>";
		echo "<td><br></td><td><br></td><td><br></td>";
		echo "</tr>";
		} // end while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 

		// close the table...
		echo "</table><hr><br>";

	} // end if ($result)
	
} // end function build_journal_entry_list($currently_selected_spot)

//*********************************************************************************************************
// pass in the name of the spot and this function will build a dropdown list with that name selected..
function build_mystery_jump_to_spot_dropdown_form($spot_id, $current_page_name)
{
	if (($_SESSION['CURRENT_PAGE_FILENAME'] == 'about.php') || 
	($_SESSION['CURRENT_PAGE_FILENAME'] == 'news.php') ||
	($_SESSION['CURRENT_PAGE_FILENAME'] == 'whats_in.php') ||
	($_SESSION['CURRENT_PAGE_FILENAME'] == 'boats.php'))
		$current_page_name = 'index.php';
	// open the form
   	echo "<form action=$current_page_name?spot_id=" . $_POST['spot_id'] . "&action=jump_to_spot name=jump_to_spot   method=post> ";
	
	//select all the mystery spots...
	$result = mysql_query("SELECT * FROM `mystery_spots` ORDER BY `mystery_spot_name`" );

	// open tag
	echo '<select name=spot_id onchange="this.form.submit();" class="mystery_jump_to_spot_dropdown" style="width:180px">';
  
  	// add this spot to the drop down...
	echo "<option value='0' selected=selected>[SELECT A SPOT]</option>";		
	
	// roll through the record set and list the spots...
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 
	{
		// if this is the currently selected spot, put brackets around the link so the user knows where we are...
		if ($spot_id == $row['spot_id'] )
		{
			// add this spot to the drop down and select it...
			echo "<option value='" . $row['spot_id'] . "' selected=selected>" . $row['mystery_spot_name'] . "</option>";			
		}
		else
		{
			// add this spot to the drop down...
			echo "<option value='" . $row['spot_id'] . "'>" . $row['mystery_spot_name'] . "</option>";		}
		
	} // end while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 

	// close tag...
	echo "</select>";

	// open the form
   	echo "</form>"; 

} // end function build_mystery_spot_dropdown($mystery_spot_name)

//*********************************************************************************************************
// pass in the name of the spot and this function will build a dropdown list with that name selected..
function build_mystery_spot_dropdown($mystery_spot_name)
{
	//select all the mystery spots...
	$result = mysql_query("SELECT * FROM `mystery_spots` ORDER BY `mystery_spot_name`" );

	// open tag
	echo "<select name=mystery_spot_name>";
  
	// roll through the record set and list the spots...
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 
	{
		// if this is the currently selected spot, put brackets around the link so the user knows where we are...
		if ($mystery_spot_name == $row['mystery_spot_name'] )
		{
			// add this spot to the drop down and select it...
			echo "<option value='" . $row['mystery_spot_name'] . "' selected=selected>" . $row['mystery_spot_name'] . "</option>";			
		}
		else
		{
			// add this spot to the drop down...
			echo "<option value='" . $row['mystery_spot_name'] . "'>" . $row['mystery_spot_name'] . "</option>";		}
		
	} // end while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 

	// close tag...
	echo "</select>";

} // end function build_mystery_spot_dropdown($mystery_spot_name)

//**********************************************************************************

function build_mystery_spot_id_dropdown($mystery_spot_id, $name_of_dropdown)
{
	//select all the mystery spots...
	$result = mysql_query("SELECT * FROM `mystery_spots` ORDER BY `mystery_spot_name`" );

	// open tag
	echo "<select name=$name_of_dropdown>";
  
 	 echo "<option value='' selected=selected>-- SELECT SPOT --</option>";
	// roll through the record set and list the spots...
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 
	{
		// if this is the currently selected spot, put brackets around the link so the user knows where we are...
		if ($mystery_spot_id == $row['spot_id'] )
		{
			// add this spot to the drop down and select it...
			echo "<option value='" . $row['spot_id'] . "' selected=selected>" . $row['mystery_spot_name'] . "</option>";			
		}
		else
		{
			// add this spot to the drop down...
			echo "<option value='" . $row['spot_id'] . "'>" . $row['mystery_spot_name'] . "</option>";		
		}
		
	} // end while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 

	// close tag...
	echo "</select>";

} // end function build_mystery_spot_dropdown($mystery_spot_name)
//********************************************************************************

function build_country_filter_dropdown($currenly_selected_country)
{
	//select all the countries of the mystery spots...
	//$result = mysql_query("SELECT * FROM `mystery_spots` WHEREORDER BY `mystery_spot_name`" );
	$sql = "SELECT DISTINCT `country` FROM `mystery_spots` ORDER BY `country` ASC";
	
	// execute it.
	$result = mysql_query($sql);
	
	// open tag
	echo '<select name=country_filter onchange="this.form.submit();" >';
	
	// put the SHOW ALL  option in there 
	echo "<option value='[SHOW ALL]' selected=selected>[SHOW ALL]</option>";			
  
	// roll through the record set and list the spots...
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 
	{
		// if this is the currently selected spot, put brackets around the link so the user knows where we are...
		if ($currenly_selected_country == $row['country'] )
		{
			// add this spot to the drop down and select it...
			echo "<option value='" . $row['country'] . "' selected=selected>" . $row['country'] . "</option>";			
		}
		else
		{
			// add this spot to the drop down...
			echo "<option value='" . $row['country'] . "'>" . $row['country'] . "</option>";		
			}
		
	} // end while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 

	// close tag...
	echo "</select>";

} // end function build_mystery_spot_dropdown($mystery_spot_name)

//******************************************************************************************************

function build_state_filter_dropdown($currenly_selected_state)
{
	
	
	if (!isset($_SESSION['COUNTRY_FILTER']) OR ($_SESSION['COUNTRY_FILTER'] == '[SHOW ALL]'))
		$cf = '1=2'; 
	else
		$cf = "`country` = '" . $_SESSION['COUNTRY_FILTER'] . "'";
	
	//select all the countries of the mystery spots...
	//$result = mysql_query("SELECT * FROM `mystery_spots` WHEREORDER BY `mystery_spot_name`" );
	$sql = "SELECT DISTINCT `state` FROM `mystery_spots` WHERE ". $cf ." AND 1=1 ORDER BY `state` ASC";
	
	// execute it.
	$result = mysql_query($sql);
	
	// open tag
	echo '<select name=state_filter onchange="this.form.submit();" >';
  
  	// put the SHOW ALL  option in there 
	echo "<option value='[SHOW ALL]' selected=selected>[SHOW ALL]</option>";			
  	
	// roll through the record set and list the spots...
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 
	{
		// if this is the currently selected spot, put brackets around the link so the user knows where we are...
		if ($currenly_selected_state == $row['state'] )
		{
			// add this spot to the drop down and select it...
			echo "<option value='" . $row['state'] . "' selected=selected>" . $row['state'] . "</option>";			
		}
		else
		{
			// add this spot to the drop down...
			echo "<option value='" . $row['state'] . "'>" . $row['state'] . "</option>";		
		}
		
	} // end while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 

	// close tag...
	echo "</select>";

} // end function build_mystery_spot_dropdown($mystery_spot_name)

//*********************************************************************************************************
function build_state_dropdown($current_state)
{
	//select all the mystery spots...
	$result = mysql_query("SELECT * FROM `settings` WHERE `key` = 'STATE'");

	// open tag
	echo "<select name=state>";

	// put the SHOW ALL  option in there 
	echo "<option value='SHOW ALL' selected=selected>SHOW ALL</option>";
	
	// roll through the record set and list the spots...
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 
	{
		// if this is the currently selected spot, put brackets around the link so the user knows where we are...
		if ($current_state == $row['value'] )
		{
			// add this spot to the drop down and select it...
			echo "<option value='" . $row['value'] . "' selected=selected>" . $row['value'] . "</option>";			
		}
		else
		{
			// add this spot to the drop down...
			echo "<option value='" . $row['value'] . "'>" . $row['value'] . "</option>";		
		}
		
	} // end while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 

	// close tag...
	echo "</select>";

} // end function build_state_dropdown($current_state)

//*********************************************************************************************************
// this builds the list of tabs at the top of the page....
function build_tab_navigation_list($currently_selected_id, $currently_selected_tab)
{
 
	echo "
	 <!-- Navigation item -->
          <ul>
          <li><a href=index.php?spot_id=" . $currently_selected_id . " class=selected>HOME</a></li>
          </ul>
          		
 		  <ul>
          <li><a href=spots.php?spot_id=" . $currently_selected_id . " class=selected>Spots</a></li>
          </ul>
   			
   		  <ul>
          <li><a href=boats.php?spot_id=" .$currently_selected_id . ">Boats</a></li>        
		  </ul>
		  		
		  <ul>		
		  <li><a href=./gear?spot_id=" .$currently_selected_id . ">PRO SHOP</a></li>
		  </ul>
		  		
		 <ul>
          <li><a href=gatherings.php?spot_id=" .$currently_selected_id . ">Gatherings</a></li>
          </ul>
		  
		 	  
		  
	" . 	  
//		  <ul>
 //         <li><a >Links</a></li>
  //        </ul>		  
		  
"		 
		  
		  <ul>
       <li><a href=news.php?spot_id=" . $currently_selected_id . ">News</a></li>
          </ul>	
		
		<ul>
          
		  <li>
		   <a href=whats_in.php?spot_id=" . $currently_selected_id . "><font color=#009900>WHATS IN RIGHT NOW!</font></a>
		</li>
          </ul>	
	
	";
			

	

} // end function build_tab_navigation_list($currently_selected_id, $currently_selected_tab)

//*********************************************************************************************************
// this builds the list of tabs at the top of the page....
function build_detailed_tab_navigation_list($currently_selected_id, $currently_selected_tab, $user_name)
{
 
	// pass the currently selected spot, through to the login page...
	$spot_id = $_GET["spot_id"];
	
	// get the spot name so we can display it next to the login name..
	$spot_name = get_mystery_spot_name_from_id($spot_id);
		if ($spot_name == "") $spot_name = "None Selected";
		
	// get the record of this spot
		$spot_row = get_mystery_spots_record_from_id($spot_id);
		
		// get the color for it... if its "in" this will be green, if its not "in" it will be red, otherwise it will be blue(as in there is no Gage defined in the db..)
		$color = get_color_for_spot($spot_row["gauge_number"], $spot_row['spot_id'], $spot_row["flow_type"]);
				
		 // get the current flow from usgs...
		$gauge_data = get_current_flow($spot_row["gauge_number"], $spot_row["flow_type"] );
		
		// this text will be colored either red or green, depending if the spot is "in"
		if (trim($gauge_data[0]) == "")
			$current_flow = "?";
		else
			$current_flow = $gauge_data[0] . get_flow_type_from_id($spot_row['spot_id']);	
		
	 
   echo '<div class=selected_spot_crap>';	
	if ($user_name == "")
	{
	 
		
			
 
		// print the spot to the screen as a link with its id.. with brackets around it
//		echo "<strong><font color=" . $color . ">" . $spot_row['mystery_spot_name'] . " " . $current_flow . "</font></strong>"; 
 		
//echo "<font color=" . echo $color; .  > echo $spot_name;  </font></strong>

echo "Selected Spot:";
 ?>
		<!--<TABLE> -->
		<!--<tr> -->
			<!-- <td width="97" valign="middle"><strong>Name:</strong></td> -->
			<!-- <td width="10" valign="top">&nbsp;</td> -->
			<!-- <td   align=center valign="middle" bgcolor="#FFFFCC"> -->
			
			<strong><?php echo $spot_name; ?></strong>
			<!-- </td> -->
			<!-- <td   valign="top" bordercolor="#000000" bgcolor="#FFFFFF"> -->
		    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<strong><font color="#FF6600">Current Flow:</font>
			<font color=<?php echo $color; ?> ><?php echo $current_flow; ?></font></strong>
 
			<!-- </td> -->
  		<!-- </tr> -->
  		<!-- </TABLE> -->
<?php 

		//echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Selected Spot: <strong>" . $spot_name . "</strong>";
	}
	else
	{
		 
		echo "Selected Spot:";
 ?>
		<!--<TABLE> -->
		<!--<tr> -->
			<!-- <td width="97" valign="middle"><strong>Name:</strong></td> -->
			<!-- <td width="10" valign="top">&nbsp;</td> -->
			<!-- <td   align=center valign="middle" bgcolor="#FFFFCC"> -->
			
			<strong><?php echo $spot_name; ?></strong>
			<!-- </td> -->
			<!-- <td   valign="top" bordercolor="#000000" bgcolor="#FFFFFF"> -->
		    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<strong><font color="#FF6600">Current Flow:</font>
			<font color=<?php echo $color; ?> ><?php echo $current_flow; ?></font></strong>
 
			<!-- </td> -->
  		<!-- </tr> -->
  		<!-- </TABLE> -->
<?php 	
	}	

echo '</div>';
 
 // <li id='active'><a href='#' id='current'>Item one</a></li>
 
	echo "<div id='navcontainer'>
<ul id='navlist'>

<li><a href=index.php?spot_id=" . $currently_selected_id . " >Info</a></li>
<li><a href=images.php?spot_id=" . $currently_selected_id  . ">Images</a></li>
<li><a href=media.php?spot_id=" . $currently_selected_id . ">Video</a></li>
 <li><a href=explore.php?spot_id=" . $currently_selected_id . ">Map</a></li>
<li><a href=gauge.php?spot_id=" . $currently_selected_id . ">Gage</a></li>
<li><a href=weather.php?spot_id=" . $currently_selected_id . ">Weather</a></li>	
</ul>
</div>
          		";
			


	

} // end function build_tab_navigation_list($currently_selected_id, $currently_selected_tab)
//*****************************************************************************************************************************
// this is basically all the crap in the title tags....  including the login stuff..
function build_title_and_login_stuff($user_name)
{
	// pass the currently selected spot, through to the login page...
	$spot_id = $_GET["spot_id"];
				
	if ($user_name == "")
	{
		
	}
	else
	{
		echo "Welcome <b>" . $user_name . "!</b> [<a href=login_commit.php?spot_id=" . $spot_id . "&action=logout>logout</a>] <font size=-2>(" . get_num_users() . " users)</font>"; 	
	}	
		

	  
} // end function build_title_and_login_stuff($user_name)

//***********************************************************************************************************************************

function build_video_urls($spot_id)
{
	// protect from sql injection		
	$spot_id = strip_invalid_chars($spot_id);
	
	//select all the journal entries for this mystery spot...
	$sql = "SELECT * FROM `videos` WHERE `spot_id` = '" . $spot_id . "' ORDER BY date_added DESC";
	if (!mysql_query($sql))
  	{                                                                            
		// handle sql error....
		handle_sql_error("build_video_urls($spot_id)", $sql);
  	} 
 	
	// get the result set....
	$result = mysql_query($sql);

	// roll through the record set and list the spots...
	echo "<strong>Videos:</strong><br>";
	
	// what is the mystery_spot_name of this id? we are going to display it below...
	$mystery_spot_name = get_mystery_spot_name_from_id($spot_id);
	
	// are there any records?
	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	if (!$row)
	{
		echo "There are no videos for this spot...<br>";
	}
	else
	{
?>	
	
		<table border="1" width=100%>
		
		
		
	<?php
/*	
		// open the table 
		echo "<table width=100% border=1>";

		// open this row for the header
		echo "<tr>";
		// print the headers..
		echo "<td align=center></td>";
		echo "<td align=center><strong>Name</strong></td>";
		echo "<td align=center><strong>User</strong></td>";
		echo "<td align=center><strong>Video</strong></td>";  
		echo "<td align=center><strong>Comment</strong></td>";
		echo "<td align=center><strong>Date Added</strong></td>";
		// close this table row for the header..
		echo "</tr>";
*/
	
	
/*	
		// there is at least one row, so print it:
		// open this table row...
		echo "<tr>";
		
		// if the current user is ADMIN, or the current user is the user that created this journal entry, show the edit and delete links... 
		if (($_SESSION['CURRENT_USER_NAME'] == $row['user_name']) || ($_SESSION['ADMIN_USER'] == "TRUE"))
			echo "<td align=center><a href=video_maintenance.php?spot_id=" . $spot_id . "&video_id=" . $row['video_id'] . "&action=update><font color=#0000FF>edit</font></a> <a href=video_maintenance.php?spot_id=" . $spot_id . "&video_id=" . $row['video_id'] . "&action=delete><font color=#0000FF>delete</font></a></td>";
		else
			echo "<td></td>";
		 			
		echo "<td valign=top>" . $mystery_spot_name . "</td>"; 
		echo "<td valign=top>" . $row['user_name'] . "</td>";
		echo "<td align=center>" . $row['video_url'] . "</td>";
		echo "<td valign=top>" . $row['video_comment'] . "</td>";
		echo "<td valign=top>" . $row['date_added'] . "</td>";
		// close this table row..
		echo "</tr>";
*/

//$row['video_id'] = "<object width=500 height=400>" . $row['video_id'] . "</object>";
?>


<table border="1" width=100%>
		<tr> 
			<td><b>Name:</b><br>
			<?php echo $mystery_spot_name;
			if (($_SESSION['CURRENT_USER_NAME'] == $row['user_name']) || ($_SESSION['ADMIN_USER'] == "TRUE"))
				echo " <a href=video_maintenance.php?spot_id=" . $spot_id . "&video_id=" . $row['video_id'] . "&action=update><font color=#0000FF>edit</font></a> <a href=video_maintenance.php?spot_id=" . $spot_id . "&video_id=" . $row['video_id'] . "&action=delete><font color=#0000FF>delete</font></a>";
			?>
			</td>
			<td rowspan="3"><?php echo $row['video_url']; ?></tr>
		<tr> 
			<td><b>User:</b><br><?php echo $row['user_name']; ?></td>
		</tr>
		<tr> 
			<td><b>Date Added:</b><br><?php echo $row['date_added']; ?></td>
		</tr>
		<tr> 
			<td colspan="2"><b>Comment:</b> <?php echo $row['video_comment']; ?></td>
		</tr>
		
		</table>
<?php
		// see if there are any other rows...
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 
		{
		
			//$row['video_id'] = "<object width=500 height=400>" . $row['video_id'] . "</object>";
?>
		<br>
		<table border="1" width=100%>
		<tr> 
			<td><b>Name:</b><br>
			<?php echo $mystery_spot_name;
			if (($_SESSION['CURRENT_USER_NAME'] == $row['user_name']) || ($_SESSION['ADMIN_USER'] == "TRUE"))
				echo " <a href=video_maintenance.php?spot_id=" . $spot_id . "&video_id=" . $row['video_id'] . "&action=update><font color=#0000FF>edit</font></a> <a href=video_maintenance.php?spot_id=" . $spot_id . "&video_id=" . $row['video_id'] . "&action=delete><font color=#0000FF>delete</font></a>";
			?>
			</td>
			<td rowspan="3"><?php echo $row['video_url']; ?></tr>
		<tr> 
			<td><b>User:</b><br><?php echo $row['user_name']; ?></td>
		</tr>
		<tr> 
			<td><b>Date Added:</b><br><?php echo $row['date_added']; ?></td>
		</tr>
		<tr> 
			<td colspan="2"><b>Comment:</b> <?php echo $row['video_comment']; ?></td>
		</tr>
		
		</table>
<?php		
/*				
			// open this table row...
			echo "<tr>";

			// if the current user is ADMIN, or the current user is the user that created this journal entry, show the edit and delete links... 
			if (($_SESSION['CURRENT_USER_NAME'] == $row['user_name']) || ($_SESSION['ADMIN_USER'] == "TRUE"))
				echo "<td align=center><a href=video_maintenance.php?spot_id=" . $spot_id . "&video_id=" . $row['video_id'] . "&action=update><font color=#0000FF>edit</font></a> <a href=video_maintenance.php?spot_id=" . $spot_id . "&video_id=" . $row['video_id'] . "&action=delete><font color=#0000FF>delete</font></a></td>";
			else
				echo "<td></td>";

			echo "<td valign=top>" . $mystery_spot_name . "</td>"; 
			echo "<td valign=top>" . $row['user_name'] . "</td>";
			echo "<td align=center>" . $row['video_url'] . "</td>";
			echo "<td valign=top>" . $row['video_comment'] . "</td>";
			echo "<td valign=top>" . $row['date_added'] . "</td>";	
			// close this table row..
			echo "</tr>";
*/			
		} // end while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 

		// close the table...
		//echo "</table>";

	} // end if ($result)

} // end function build_video_urls($spot_id)


//*****************************************************************************************************************************************

function build_video_link_list()
{	
	echo "<strong>Spots with Videos:</strong><br>";
	
	// select all the spots... 
	$result_spot = mysql_query("SELECT * FROM `mystery_spots` ORDER BY `mystery_spot_name`");
	
	// roll through the spots...	
	while ($spot_record = mysql_fetch_array($result_spot, MYSQL_ASSOC))
	{
		// what spot are we on...	
		$spot_id = $spot_record['spot_id'];
			
		// get the videos for this spot...
		$result_videos = mysql_query("SELECT * FROM `videos` WHERE `spot_id` = $spot_id");			
		
		// initialize the counter...
		$count = 0;
		
		// roll through videos for this spot...
		while ($video_record = mysql_fetch_array($result_videos, MYSQL_ASSOC))
			$count = $count + 1; // count them...	
			
		// how many spots did we find?	
		if ($count > 0)
		{		
			// print the spot name, the count and link it back to the spot
			echo "<a href=media.php?spot_id=$spot_id><font color=#0000FF>" . get_mystery_spot_name_from_id($spot_id) . " ($count)</font></a><br>";
		}				

	} // end while..
	
} // end function build_video_link_list()

//**************************************************************************************************

function build_journal_entry_link_list()
{	
	echo "<strong>Spots with Journal Entries:</strong><br>";
	
	// select all the spots... 
	$result_spot = mysql_query("SELECT * FROM `mystery_spots` ORDER BY `mystery_spot_name`");
	
	// roll through the spots...	
	while ($spot_record = mysql_fetch_array($result_spot, MYSQL_ASSOC))
	{
		// what spot are we on...	
		$spot_id = $spot_record['spot_id'];
			
		// get the videos for this spot...
		$result_videos = mysql_query("SELECT * FROM `exploration_data` WHERE `spot_id` = $spot_id");			
		
		// initialize the counter...
		$count = 0;
		
		// roll through videos for this spot...
		while ($video_record = mysql_fetch_array($result_videos, MYSQL_ASSOC))
			$count = $count + 1; // count them...	
			
		// how many spots did we find?	
		if ($count > 0)
		{		
			// print the spot name, the count and link it back to the spot
			echo "<a href=index.php?spot_id=$spot_id><font color=#0000FF>" . get_mystery_spot_name_from_id($spot_id) . " ($count)</font></a><br>";
		}				

	} // end while..
	
} // end function build_video_link_list()

//**************************************************************************************************


function build_last_videos_added($num_videos)
{

	// display a title to this list...
	//echo "<strong>Last $num_videos Video Posts:</strong><br>";
	
	// get all the videos... order them decending... newest date, to oldest data..
	$result = mysql_query("SELECT * FROM `videos` ORDER BY `date_added` DESC");
	$counter = 0;
	
	// roll through the records....
	while ($record = mysql_fetch_array($result, MYSQL_ASSOC))
	{
		// are we over the limit yet? 
		if ($counter < $num_videos)
		{	
			// we are going to show a link to this spot... grab the data from this record..
			$user_name = $record['user_name'];
			$comment = $record['video_comment'];
			$video_id = $record['video_id'];
			$spot_id = $record['spot_id'];
			$spot_name = get_mystery_spot_name_from_id($spot_id);
			
			// FORMAT THE RAW DATE WITH THIS SWEET NEW DATE FORMATING FUNCTION.....
			$date_added = $record['date_added'];
			$date_added = FormatMyDate($date_added, "m-d-Y");
			
			// show it...
			echo "<a href=media.php?spot_id=$spot_id><font color=#0000FF>$spot_name</font></a> -  <b>$comment</b><br>Posted by $user_name on $date_added";
			echo "<br>";
		}
		
		// increment the counter.
		$counter = $counter + 1;
		
	} // while ($record = mysql_fetch_array($result, MYSQL_ASSOC))

} // function get_last_videos_added($num_videos)

//**************************************************************************************************************************************************

function build_last_mpegs_added()
{


	// display a title to this list...
	echo "<strong>MPGS:</strong><br>";
	
	// get all the videos... order them decending... newest date, to oldest data..
	$result = mysql_query("SELECT * FROM `mpegs` ORDER BY `date_added` DESC");
	
	// roll through the records....
	while ($record = mysql_fetch_array($result, MYSQL_ASSOC))
	{
	
			// we are going to show a link to this spot... grab the data from this record..
			$user_name = $record['user_name'];
			$comment = $record['video_comment'];
			$filename = $record['video_filename'];
			$video_id = $record['video_id'];
			$spot_id = $record['spot_id'];
			$spot_name = get_mystery_spot_name_from_id($spot_id);
			
			// FORMAT THE RAW DATE WITH THIS SWEET NEW DATE FORMATING FUNCTION.....
			$date_added = $record['date_added'];
			$date_added = FormatMyDate($date_added, "m-d-Y");
			
			// show it...
			echo "<font color=#0000FF>$filename</font> -  <b>$comment</b><br>Posted by $user_name on $date_added";
			echo "<br>";
		
		
	} // while ($record = mysql_fetch_array($result, MYSQL_ASSOC))

} // function get_last_videos_added($num_videos)

//*********************************************************************************************************

function build_last_user_updates($num_updates)
{

	// display a title to this list...
	
	// get all the records... order them decending... newest date, to oldest data..
	$result = mysql_query("SELECT * FROM `log` ORDER BY `log_id` DESC");
	$counter = 0;
	
	// roll through the records....
	while ($record = mysql_fetch_array($result, MYSQL_ASSOC))
	{
		// are we over the limit yet? 
		if ($counter < $num_updates)
		{	
			// we are going to show a link to this spot... grab the data from this record..
			$user_name = $record['user_name'];
			$user_name = "<b>" . $user_name . "</b>";
			
			$table_affected = $record['table_affected'];
			$field_affected = $record['field_affected'];
			$action_taken = $record['action_taken'];
			$error_status = $record['error_status']; // "OK" or "ERROR"
			
			$spot_id = $record['spot_id'];
			$spot_name = get_mystery_spot_name_from_id($spot_id);
			if ($spot_id == "")
			{	
				// just clean it up if that field is not defined.... ..
				$spot_id = 1;
				$spot_name = "?";
			}
			
						
			//lets interpret the action and spell it out into a user understandable form..
			if ($action_taken == "added")
				$action_taken = "added a new";
			else if ($action_taken == "updated")
				$action_taken = "updated a";
			else if ($action_taken == "deleted")
				$action_taken = "deleted a";
		//	else if ($action_taken == "login")
		//		$action_taken = "log";
			//else if ($action_taken == "logout")	
			//	$action_taken = "login";
			
							
			// FORMAT THE RAW DATE WITH THIS SWEET NEW DATE FORMATING FUNCTION.....
			$time_stamp = $record['time_stamp'];
			$time_stamp = FormatMyDate($time_stamp, "m-d-Y");
		
			if ($table_affected == "videos")
			{
				// show it...
				echo "$user_name - $action_taken video for <a href=media.php?spot_id=$spot_id><font color=#0000FF>$spot_name</font></a> on $time_stamp";
				echo "<br>";
			}
			else if ($table_affected == "images")
			{
				// show it...
				echo "$user_name - $action_taken image for <a href=images.php?spot_id=$spot_id><font color=#0000FF>$spot_name</font></a> on $time_stamp";
				echo "<br>";
			}
			else if ($table_affected == "links")
			{
			
				// show it...
				$label = $record['old_value'];
				$link = $record['new_value'];
				
				echo "$user_name - $action_taken link on $time_stamp ~ <a href='http://".$link."' target=_blank><font color=#0000FF>".$label."</font></a>";
				echo "<br>";
			}
			else if ($table_affected == "mystery_spots")
			{
				if ($action_taken == 'added a new')
				{
					// show it...
					echo "<font color=#33CC00>$user_name - $action_taken mystery spot</font> called <a href=index.php?spot_id=$spot_id><font color=#0000FF>$spot_name</font></a> on $time_stamp";
					echo "<br>";
				}
				else
				{
					// show it...
					echo "$user_name - $action_taken mystery spot called <a href=index.php?spot_id=$spot_id><font color=#0000FF>$spot_name</font></a> on $time_stamp";
					echo "<br>";
				}
				
			}
			else if ($table_affected == "gatherings")
			{
				// show it...
				echo "$user_name - $action_taken <a href=gatherings.php><font color=#0000FF>gathering</font></a> on $time_stamp<br>";
			}
			else if (($table_affected == "journal_entries") || ($table_affected == "exploration_data"))
			{
				// show it...
				echo "$user_name - $action_taken journal entry for <a href=index.php?spot_id=$spot_id><font color=#0000FF>$spot_name</font></a> on $time_stamp";
				echo "<br>";
			}
			else if ($table_affected == "users")
			{
				// show it if they are logging in or out...
				if (($action_taken == "logout") || ($action_taken == "login"))
				{
					// KINDA OVERKILL -- 
					//echo "$user_name - $action_taken on $time_stamp";
					//echo "<br>";
					$counter = $counter - 1;
				}
				else if ($action_taken == 'added a new')
				{
					$action_taken = 'created a new';
						// show it...
					echo "<b><font color=#33CC00>" . $record['new_value'] . "</b> - $action_taken user account on $time_stamp </font>";
					echo "<br>";				
				}
				else
				{
					// skip this record...dont show it to the user...
					// OK..here i dont really want to show login failure.... 
					// so just decrement the counter so we get one more from the result set
					$counter = $counter - 1;
				}
				

			}			
			else
			{
				// show it...
				echo "$user_name - $action_taken the $table_affected for <a href=index.php?spot_id=$spot_id><font color=#0000FF>$spot_name</font></a> on $time_stamp";
				echo "<br>";
			}
	

			
		} // end if
		
		// increment the counter.
		$counter = $counter + 1;
		
	} // while ($record = mysql_fetch_array($result, MYSQL_ASSOC))

} // function get_last_user_updates($num_updates)



//*****************************************************************************************************************************************

function build_images_link_list()
{	
	echo "<strong>Spots with Images:</strong><br>";
	
	// select all the spots... 
	$result_spot = mysql_query("SELECT * FROM `mystery_spots` ORDER BY `mystery_spot_name`");
	
	// roll through the spots...	
	while ($spot_record = mysql_fetch_array($result_spot, MYSQL_ASSOC))
	{
		// what spot are we on...	
		$spot_id = $spot_record['spot_id'];
			
		// get the videos for this spot...
		$result_images = mysql_query("SELECT * FROM `images` WHERE `spot_id` = $spot_id");			
		
		// initialize the counter...
		$count = 0;
		
		// roll through videos for this spot...
		while ($image_record = mysql_fetch_array($result_images, MYSQL_ASSOC))
			$count = $count + 1; // count them...	
			
		// how many spots did we find?	
		if ($count > 0)
		{		
			// print the spot name, the count and link it back to the spot
			echo "<a href=images.php?spot_id=$spot_id><font color=#0000FF>" . get_mystery_spot_name_from_id($spot_id) . " ($count)</font></a><br>";
		}				

	} // end while..
	
} // end function build_video_link_list()

//*************************************************************************

function build_links_link_list()
{	
	//echo "<strong>Links:</strong><br>";
	
	
	// select all the spots... 
	$result = mysql_query("SELECT * FROM `links` ORDER BY `link_label`");
	
	$spot_id = $_GET['spot_id'];
	
	// roll through the spots...	
	while ($record = mysql_fetch_array($result, MYSQL_ASSOC))
	{
		// what spot are we on...	
		$link_label = $record['link_label'];
		$link_url = $record['link_url'];
	
		// strip this off if they forgot to..
		
		///$link_url = preg_replace('/http:/', '', $link_url);
		//$link_url = preg_replace('/////', '', $link_url);
		
		$link_url = str_replace('http://', '', strtolower($link_url));
			
		// only show 3 links on each row..		
		if ($counter > 2)
		{					
			echo "<br>";
			$counter = 0;
		}

		// print the link
		echo "[<a href='http://" . $link_url . "' target=_blank><font color=#0000FF>" . $link_label . "</font></a>] ";
		
		// increment the counter..				
		$counter++;
	} // end while..
	
	
	
} // end function build_video_link_list()

//*************************************************************************************
function build_last_images_added($num_images)
{
	// display a title to this list...
	//echo "<strong>Last $num_images Image Posts:</strong><br>";
	
	// get all the videos... order them decending... newest date, to oldest data..
	$result = mysql_query("SELECT * FROM `images` ORDER BY `date_added` DESC");
	$counter = 0;
	
	// roll through the records....
	while ($record = mysql_fetch_array($result, MYSQL_ASSOC))
	{
		// are we over the limit yet? 
		if ($counter < $num_images)
		{	
			// we are going to show a link to this spot... grab the data from this record..
			$user_name = $record['user_name'];
			$comment = $record['image_comment'];
			$video_id = $record['image_id'];
			$spot_id = $record['spot_id'];
			$spot_name = get_mystery_spot_name_from_id($spot_id);
			
			// FORMAT THE RAW DATE WITH THIS SWEET NEW DATE FORMATING FUNCTION.....
			$date_added = $record['date_added'];
			$date_added = FormatMyDate($date_added, "m-d-Y");
			
			// show it...
			echo "<a href=images.php?spot_id=$spot_id><font color=#0000FF>$spot_name</font></a> -  <b>$comment</b><br>Posted by $user_name on $date_added";
			echo "<br>";
		}
		
		// increment the counter.
		$counter = $counter + 1;
		
	} // while ($record = mysql_fetch_array($result, MYSQL_ASSOC))

} // function get_last_images_added($num_videos)

//*******************************************************************************************************

function get_user_records_from_email($email)	  
{	
	// protect from sql injection		
	$email = strip_invalid_chars($email);
	
	//select this mystery spot...
	$sql = "SELECT * FROM `users` WHERE `email` = '" . $email . "'";

	// execute it....
	$result = mysql_query($sql);
	if (!$result) // did we get it?
  	{                                                                            
		// handle sql error....
		handle_sql_error("get_user_records_from_email($email)", $sql);		
  	}
	
	// return the row....  
	return $result;
} // end function get_journal_entry_record_from_id($journal_id)
		
//*********************************************************************************************************		
		
function get_user_record_from_id($this_id)	  
{	
	
	// protect from sql injection		
	$this_id = strip_invalid_chars($this_id);
	
	//select this mystery spot...
	$sql = "SELECT * FROM `users` WHERE `user_name` = '" . $this_id . "'";

	// execute it....
	$result = mysql_query($sql);
	if (!$result) // did we get it?
  	{                                                                            
		// handle sql error....
		handle_sql_error("get_user_record_from_id($user_id)", $sql);		
  	}
	
	// return the row....  
	return $result;
} // end function get_journal_entry_record_from_id($journal_id)

//*********************************************************************************************************		
			
function db_insert_region($region)
{
	// protect from sql injection
	$region = strip_invalid_chars($region);
	
	// build the sql insert statement...
	$sql="INSERT INTO regions (region_name)
	VALUES (
		'$region')";
	
	// execute it.... did it work?
	if (!mysql_query($sql))
  	{

		// anytime a user touches the db, write it to a log file....
		write_to_log( "regions"/*$table_affected*/, "all"/*field_ffected*/, "0"/*spot_id*/, $sql/*$sql_stement*/, "added"/*$action*/, "n/a"/*$old_value*/, "n/a"/*$new_value*/, "ERROR"/*$error_status*/);
	
		handle_sql_error("db_insert_region", $sql);
  	}
	// it worked...echo out a success message to the user..
	echo "Success: '<strong>" . $region . "</strong>' has been added to the db.";
	
	$region_id = get_highest_unique_id_in_table("regions", "region_id");
	
	// anytime a user touches the db, write it to a log file....
	write_to_log( "regions"/*$table*/, "all"/*field_ffected*/, $spot_id/*spot_id*/, $sql/*$sql_stement*/, "added"/*$action*/, "n/a"/*$old_value*/, "n/a"/*$new_value*/, "OK"/*$error_status*/);


} // function db_insert_region($region);			

//*****************************************************************************************************************************
			
function db_insert_quality($quality)
{
	// protect from sql injection
	$quality = strip_invalid_chars($quality);
	
	// build the sql insert statement...
	$sql="INSERT INTO spot_qualities (quality_name)
	VALUES (
		'$quality')";
	
	// execute it.... did it work?
	if (!mysql_query($sql))
  	{

		// anytime a user touches the db, write it to a log file....
		write_to_log( "spot_qualities"/*$table_affected*/, "all"/*field_ffected*/, "0"/*spot_id*/, $sql/*$sql_stement*/, "added"/*$action*/, "n/a"/*$old_value*/, "n/a"/*$new_value*/, "ERROR"/*$error_status*/);
	
		handle_sql_error("db_insert_region", $sql);
  	}
	// it worked...echo out a success message to the user..
	echo "Success: '<strong>" . $quality . "</strong>' has been added to the db.";
	
	$region_id = get_highest_unique_id_in_table("spot_qualities", "quality_id");
	
	// anytime a user touches the db, write it to a log file....
	write_to_log( "spot_qualities"/*$table*/, "all"/*field_ffected*/, $spot_id/*spot_id*/, $sql/*$sql_stement*/, "added"/*$action*/, "n/a"/*$old_value*/, "n/a"/*$new_value*/, "OK"/*$error_status*/);


} // function db_insert_region($region);			

//*****************************************************************************************************************************

function build_dropdown($table_name, $key, $dropdown_name, $initial_value)
{
	// protect from sql injection		
	$table_name = strip_invalid_chars($table_name);
	$key = strip_invalid_chars($key);	
	
	//select all the mystery spots...
	$result = mysql_query("SELECT * FROM $table_name ORDER BY $key");

	// open tag
	echo "<select name=$dropdown_name>";
	
	// roll through the record set and list the spots...
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 
	{
		// if this is the currently selected spot, put brackets around the link so the user knows where we are...
		if ($initial_value == $row[$key] )
		{
			// add this spot to the drop down and select it...
			echo "<option value='" . $row[$key] . "' selected=selected>" . $row[$key] . "</option>";			
		}
		else
		{
			// add this spot to the drop down...
			echo "<option value='" . $row[$key] . "'>" . $row[$key] . "</option>";		
		}
		
	} // end while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 

	// close tag...
	echo "</select>";

} // end function build_state_dropdown($current_state)

//********************************************************************************************************

function build_number_dropdown($dropdown_name, $initial_value)
{

	// open tag
	echo "<select name=$dropdown_name>";
	
	for($i=10; $i <= 500; $i=$i+10)
	{
		// if this is the currently selected spot, put brackets around the link so the user knows where we are...
		if ($initial_value == $i)
		{
			// add this spot to the drop down and select it...
			echo "<option value='" . $i . "' selected=selected>" . $i . "</option>";			
		}
		else
		{
			// add this spot to the drop down...
			echo "<option value='" . $i . "'>" . $i . "</option>";		
		}

	}
	// close tag...
	echo "</select>";

} // end function build_state_dropdown($current_state)

//********************************************************************************************************

function build_region_filter_dropdown($currenly_selected_region)
{
	//select all the countries of the mystery spots...
	//$result = mysql_query("SELECT * FROM `mystery_spots` WHEREORDER BY `mystery_spot_name`" );
	$sql = "SELECT DISTINCT `region` FROM `mystery_spots` ORDER BY `region` ASC";
	
	// execute it....
	$result = mysql_query($sql);
	if (!$result) // did we get it?
  	{
		// anytime a user touches the db, write it to a log file....
		write_to_log( "regions"/*$table_affected*/, "all"/*field_ffected*/, "0"/*spot_id*/, $sql/*$sql_stement*/, "added"/*$action*/, "n/a"/*$old_value*/, "n/a"/*$new_value*/, "ERROR"/*$error_status*/);
		handle_sql_error("build_region_filter_dropdown", $sql);
  	}

	// open tag
	echo "<select name=region_filter>";
	
	// put the SHOW ALL  option in there 
	echo "<option value='[SHOW ALL]' selected=selected>[SHOW ALL]</option>";			
  
	// roll through the record set and list the spots...
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 
	{
		// if this is the currently selected spot, put brackets around the link so the user knows where we are...
		if ($currenly_selected_region == $row['region'] )
		{
			// add this spot to the drop down and select it...
			echo "<option value='" . $row['region'] . "' selected=selected>" . $row['region'] . "</option>";			
		}
		else
		{
			// add this spot to the drop down...
			echo "<option value='" . $row['region'] . "'>" . $row['region'] . "</option>";		
			}
		
	} // end while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 

	// close tag...
	echo "</select>";

} // end function build_mystery_spot_dropdown($mystery_spot_name)

//****************************************************************************************************

function find_region_url_for_radar($state)
{
 	// states in the pacific north west
	if (
		($state == 'OR') ||
		($state == 'WA') ||
		($state == 'ID') 
		
	)
		$this_region = 'pacnorthwest';
		
 	// states in the pacific north west
	if (
		($state == 'CA') ||
		($state == 'NV') 
	)
		$this_region = 'pacsouthwest';		
	
 	// states in the nothern rockies
	if (
		($state == 'MT') ||
		($state == 'WY') ||
		($state == 'UT') ||
		($state == 'CO') 
	)
		$this_region = 'northrockies';		

 	// states in the soutern rockies
	if (
		($state == 'AZ') ||
		($state == 'MN') 
	)
		$this_region = 'southrockies';		

	// states in the nothern plaines
	if (
		($state == 'ND') ||
		($state == 'SD') ||
		($state == 'MN') ||
		($state == 'NE') ||
		($state == 'KS') ||
		($state == 'IA') ||
		($state == 'MO')	
	)
		$this_region = 'northernplains';		

 	// states in the soutern plains
	if (
		($state == 'OK') ||
		($state == 'TX')  
	)
		$this_region = 'southernplains';
		
	
	// states in the // centgrtlakes				
	if (
		($state == 'WI') ||
		($state == 'MI') ||
		($state == 'WV') ||
		($state == 'IL') ||
		($state == 'IN') ||
		($state == 'OH') ||
		($state == 'KY')	
	)
		$this_region = 'centgrtlakes';// centgrtlakes						

	// statese in the southmissvly
	if (
		($state == 'LA') ||
		($state == 'MS') ||
		($state == 'AL') ||
		($state == 'AR') ||
		($state == 'TN') 	
	)
		$this_region = 'southmissvly';// centgrtlakes						

	// statese in the northeast
	if (
		($state == 'ME') ||
		($state == 'NH') ||
		($state == 'VT') ||
		($state == 'MA') ||
		($state == 'CT') ||
		($state == 'NY') ||
		($state == 'NJ') ||
		($state == 'RI') ||
		($state == 'PA') ||
		($state == 'DC') ||
		($state == 'DE') ||
		($state == 'MD') ||
		($state == '') ||
		($state == '') ||		
		($state == '') ||
		($state == '') 	
	)
		$this_region = 'northeast';// 


	// statese in the southeast
	if (
		($state == 'FL') ||
		($state == 'GA') ||
		($state == 'AL') ||
		($state == 'TN') ||
		($state == 'NC') ||
		($state == 'SC') ||
		($state == '') ||
		($state == '') ||
		($state == '') ||
		($state == '') ||
		($state == '') ||
		($state == '') ||
		($state == '') ||
		($state == '') ||
		($state == '') ||
		($state == '') ||
		($state == '') 	
	)
		$this_region = 'southeast';


	// CLEAN IT UP
	if ($this_region == '')	
		$this_region = 'index';
		
	return $this_region;
		
} // end function find_region_url_for_radar($state)

//*******************************************************************************************************

function build_list_of_spots_that_are_in()
{
	
	// get all the spots...
	$sql = "SELECT * FROM `mystery_spots` ORDER BY `mystery_spot_name` ASC";
	
	// execute it....
	$result = mysql_query($sql);
	if (!$result) // did we get it?
  	{
		// anytime a user touches the db, write it to a log file....
		write_to_log( "spots"/*$table_affected*/, "all"/*field_ffected*/, "0"/*spot_id*/, $sql/*$sql_stement*/, "added"/*$action*/, "n/a"/*$old_value*/, "n/a"/*$new_value*/, "ERROR"/*$error_status*/);
		handle_sql_error("build_list_of_spots_that_are_in", $sql);
  	}
	
	
	//echo "<ul>"; // open spot list..
	echo "<table>";
	
	$spot_data_array = array();
	
	while ($spot_row = mysql_fetch_array($result, MYSQL_ASSOC)) 
	{
						
		// get the color for it... if its "in" this will be green, if its not "in" it will be red, otherwise it will be blue(as in there is no gauge defined in the db..)
		$color = get_color_for_spot($spot_row["gauge_number"], $spot_row['spot_id'], $spot_row["flow_type"]);	
		
		if ($color != '#009900')
			continue; // skip this spot..its not in.
		
		// get the current flow from usgs...
		$gauge_data = get_current_flow($spot_row["gauge_number"], $spot_row["flow_type"] );
		
		// this text will be colored either red or green, depending if the spot is "in"
		if (trim($gauge_data[0]) == "")
			$current_flow = "";
		else
			$current_flow = $gauge_data[0] . get_flow_type_from_id($spot_row['spot_id']);	

		echo "<tr>";
		
		// print the spot to the screen as a link with its id....no brackets..
		$name_link = "<a href=http://sinkspots.com/index.php?spot_id=" . $spot_row['spot_id'] . "><font color=" . $color . ">" . $spot_row['mystery_spot_name'] . "</font></a>";
		echo "<td>" .  $name_link . "</td>";
		echo "<td>" . $spot_row['city'] . ', ' . $spot_row['state'] . "</td>";
		echo "<td>" . $current_flow . "</td>"; 
	
		echo "</tr>";
		
		$spot_data_array[$spot_id]['name_link'] = $name_link;
		$spot_data_array[$spot_id]['city'] = $spot_row['city'];
		$spot_data_array[$spot_id]['state']  =$spot_row['state'];
		$spot_data_array[$spot_id]['region'] = $spot_row['region'];
		$spot_data_array[$spot_id]['current_flow'] = $current_flow;
		
	} // end while
	
	//echo "</ul>"; // close spot list	
	echo "</table>";
	
	echo "<HR>";
	
	return $spot_data_array;
}

//***********************************************************************************************************
function build_list_of_spots_mobile()
{
	
	// get all the spots...
	$sql = "SELECT * FROM `mystery_spots` ORDER BY `mystery_spot_name` ASC";
	
	// execute it....
	$result = mysql_query($sql);
	if (!$result) // did we get it?
  	{
		// anytime a user touches the db, write it to a log file....
		write_to_log( "spots"/*$table_affected*/, "all"/*field_ffected*/, "0"/*spot_id*/, $sql/*$sql_stement*/, "added"/*$action*/, "n/a"/*$old_value*/, "n/a"/*$new_value*/, "ERROR"/*$error_status*/);
		handle_sql_error("build_list_of_spots_mobile", $sql);
  	}
	
	
	//echo "<ul>"; // open spot list..
	echo "<table border=0>";
	
	echo "<tr>";
	echo "<td><b>Spot</b></td>";
	echo "<td><b>Flow</b></td>";
	echo "<td><b>City</b></td>";
	echo "<td><b>State</b></td>";
	echo "<td><b>Country</b></td>";
	echo "<td><b>Gage Updated</b></td>";
	
	echo "</tr>";
	while ($spot_row = mysql_fetch_array($result, MYSQL_ASSOC)) 
	{
						
		// get the color for it... if its "in" this will be green, if its not "in" it will be red, otherwise it will be blue(as in there is no gauge defined in the db..)
		$color = get_color_for_spot($spot_row["gauge_number"], $spot_row['spot_id'], $spot_row["flow_type"]);	
		
		//if ($color != '#009900')
		//	continue; // skip this spot..its not in.
		
		// get the current flow from usgs...

		$gauge_data = get_current_flow($spot_row["gauge_number"], $spot_row["flow_type"] );
		
		// this text will be colored either red or green, depending if the spot is "in"
		if (trim($gauge_data[0]) == "")
		{
			$current_flow = "";
			$gauge_data[1] = '<font color=#0000FF>no gage assigned</font>';
		}
		else
			$current_flow = "<font color=" . $color . ">" . $gauge_data[0] . get_flow_type_from_id($spot_row['spot_id']) . "</font>";	

		if ($alt == 'even')
		{
			echo "<tr class=odd_row>";
			$alt = 'odd';
		}
		else
		{
			echo "<tr class=even_row>";
			$alt = 'even';
		}
		
		
		// print the spot to the screen as a link with its id....no brackets..
		echo "<td width=2%><a href=http://sinkspots.com/index.php?spot_id=" . $spot_row['spot_id'] . "><font color=" . $color . ">" . $spot_row['mystery_spot_name'] . "</font></a></td>";
		echo "<td width=2%><a href=" . $spot_row['gauge_url'] . ">" . $current_flow . "</a></td>"; 
		
		if (($spot_row['latitude'] != '') && ($spot_row['longitude'] != ''))
			echo "<td width=2%><a href=http://maps.google.com/maps?q=" . $spot_row['latitude'] . "," . $spot_row['longitude'] . "&center=" . $spot_row['latitude'] . "," . $spot_row['longitude'] . "&z=5&maptype=hybrid >" . $spot_row['city'] . "</a></td>"; 
	
		else
			echo "<td width=2%>" . $spot_row['city'] . "</td>"; 
	
		echo "<td width=2%>" . $spot_row['state'] . "</td>"; 
		echo "<td width=2%>" . $spot_row['country'] . "</td>"; 
		echo "<td>" . $gauge_data[1] . "</td>";
		
		echo "</tr>";	
	} // end while
	
	//echo "</ul>"; // close spot list	
	echo "</table>";
}

//***********************************************************************************************************

function build_flag_list()
{
	$sql = "SELECT DISTINCT `country` FROM `mystery_spots` ORDER BY `country` ASC";
	if (!mysql_query($sql))
  	{                                                                            
		// handle sql error....
		handle_sql_error("build_spot_link_list($spot_id, $current_page_name)... country", $sql);
  	} 
	
	//get the result set...
	$country_result = mysql_query($sql);
	

	// roll through the "country" result set...
	while ($country_row = mysql_fetch_array($country_result, MYSQL_ASSOC)) 
	{
		$country = strtolower($country_row['country']);
		
		// get a hint for it.
		if ($country == 'gb')
			$hint = 'Great Britian';
		else if ($country == 'us')
			$hint = 'United States';
		else if ($country == 'jp')
			$hint = 'Japan';
		else if ($country == 'es')
			$hint = 'Spain';
		else if ($country == 'fr')
			$hint = 'France';
		else if ($country == 'ca')
			$hint = 'Canada';
		else if ($country == 'ch')
			$hint = 'Switzerland';
		else if ($country == 'ie')
			$hint = 'Ireland';
		else if ($country == 'nz')
			$hint = 'New Zealand';		
		else 
			$hint = 'Im a computer and i dont know what country this is...';	
			
			
		echo '<li><img src="./flags/gif/'. $country .'.gif" alt= "'.$hint.'" title="'.$hint.'" /></li> ';
	}
}

//***********************************************************************************************************

?>
