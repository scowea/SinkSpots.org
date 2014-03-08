<?php 
###################################################################################################
## Written By: 	Scott M. Weaver
## Date: 		2008-01-02
## Notes:  		The following piece of code "include 'includes/functions.php';" must be at the top 
## 				of any pages in order to use any of these functions....
###################################################################################################

// CONNECT TO THE DB
function db_connect()
{
	// connect to localhost Mysql with user / pw
	$con = mysql_connect('localhost', 'weaver', 'slink2Sink'); 
	// did it work?
	if (!$con)
	{
		// no.. error out
		die('Could not Connect to the db: ' . mysql_error());
	}
	
	// success...so select the db..
	mysql_select_db("weaver", $con); //database
	
	return $con;
}
//********************************************************************************************
// DISCONNECT FROM THE DB
function db_disconnect($con)
{
	// close the connection.
	mysql_close($con);
}
//***************************************************************************************************
// INSERT A MYSTERY SPOT RECORD INTO THE DB

// These are the fields for a record in the mystery_spots table:
// 01. "unique_id"  ...auto-incremented
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
	$region, 
	$state,  
	$city,  
	$longitude,  
	$latitude,  
	$gauge_name,  
	$gauge_number, 
	$gauge_url,
	$ideal_min_flow,
	$ideal_flow,
	$ideal_max_flow,
	$flow_type,  
	$notes )
{
	//make sure there are no invalid chars...  ...namely a single and double quotes...which will make the sql statement barf...
	$mystery_spot_name = strip_invalid_chars($mystery_spot_name);
	$river = strip_invalid_chars($river);
	$region = strip_invalid_chars($region);
	$state = strip_invalid_chars($state);
	$city = strip_invalid_chars($city);
	$longitude = strip_invalid_chars($longituge); 
	$latitude = strip_invalid_chars($latitude);
	$gauge_name = strip_invalid_chars($gauge_name);
	$gauge_number = strip_invalid_chars($gauge_number);
	$gauge_url = strip_invalid_chars($gauge_url);
	$ideal_min_flow = strip_invalid_chars($ideal_min_flow);
	$ideal_flow = strip_invalid_chars($ideal_flow);
	$ideal_max_flow = strip_invalid_chars($ideal_max_flow);
	$flow_type = strip_invalid_chars($flow_type);
	$notes = strip_invalid_chars($notes);
	
  	// connect to the db...
	$con = db_connect();
	
	// build the sql insert statement...
	$sql="INSERT INTO mystery_spots (
		mystery_spot_name, 
		river, 
		region, 
		state, 
		city, 
		longitude, 
		latitude, 
		gauge_name, 
		gauge_number, 
		gauge_url, 
		ideal_min_flow, 
		ideal_flow, 
		ideal_max_flow, 
		flow_type,
		notes)
	VALUES (
		'$mystery_spot_name', 
		'$river', 
		'$region', 
		'$state', 
		'$city', 
		'$longitude', 
		'$latitude', 
		'$gauge_name', 
		'$gauge_number', 
		'$gauge_url', 
		'$ideal_min_flow', 
		'$ideal_flow', 
		'$ideal_max_flow', 
		'$flow_type', 
		'$notes')";

	// execute it.... did it work?
	if (!mysql_query($sql))
  	{
		handle_sql_error("db_insert_mystery_spot", $sql);
  	}
	// it worked...echo out a success message to the user..
	echo "Success: '<strong>" . $mystery_spot_name . "</strong>' has been added to the db.";
	
	// disconnect from the db..
	db_disconnect($con);
 
} // end function db_insert_mystery_spot()

//*******************************************************************************************************
// UPDATE A MYSTERY SPOT RECORD IN THE DB

// These are the fields for a record in the mystery_spots table:
// 01. "unique_id"
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
	$region, 
	$state,  
	$city,  
	$longitude,  
	$latitude,  
	$gauge_name,  
	$gauge_number, 
	$gauge_url,
	$ideal_min_flow,
	$ideal_flow,
	$ideal_max_flow, 
	$flow_type, 
	$notes )
{

	//make sure there are no invalid chars...  ...namely a single and double quotes...which will make the sql statement barf...
	$mystery_spot_name = strip_invalid_chars($mystery_spot_name);
	$river = strip_invalid_chars($river);
	$region = strip_invalid_chars($region);
	$state = strip_invalid_chars($state);
	$city = strip_invalid_chars($city);
	$longitude = strip_invalid_chars($longituge); 
	$latitude = strip_invalid_chars($latitude);
	$gauge_name = strip_invalid_chars($gauge_name);
	$gauge_number = strip_invalid_chars($gauge_number);
	$gauge_url = strip_invalid_chars($gauge_url);
	$ideal_min_flow = strip_invalid_chars($ideal_min_flow);
	$ideal_flow = strip_invalid_chars($ideal_flow);
	$ideal_max_flow = strip_invalid_chars($ideal_max_flow);
	$flow_type = strip_invalid_chars($flow_type);
	$notes = strip_invalid_chars($notes);
	
  	// connect to the db...
	$con = db_connect();
	
	// build the sql insert statement...
	$sql="UPDATE mystery_spots 
	SET 
		mystery_spot_name = '" . $mystery_spot_name . "',
		river = '" . $river . "',
		region = '" . $region . "',
		state = '" . $state . "', 
		city = '" . $city . "', 
		longitude = '" . $longitude . "', 
		latitude = '" . $latitude . "', 
		gauge_name = '" . $gauge_name . "', 
		gauge_number = '" . $gauge_number . "', 
		gauge_url = '" . $gauge_url . "', 
		ideal_min_flow = '" . $ideal_min_flow . "', 
		ideal_flow = '" . $ideal_flow . "', 
		ideal_max_flow = '" . $ideal_max_flow . "', 
		flow_type = '" . $flow_type . "',
		notes = '" . $notes . "'
	WHERE 
		unique_id = '" . $spot_id . "'";

	// execute it.... did it work?
	if (!mysql_query($sql))
  	{
		handle_sql_error("db_update_mystery_spot", $sql);
  	}
	// it worked...echo out a success message to the user..
	echo "Success: '<strong>" . $mystery_spot_name . "</strong>' has been updated in the db.";
	
	// disconnect from the db..
	db_disconnect($con);
 
} // end function db_update_mystery_spot()

//*******************************************************************************************************
// this function deletes a record from the mystery_spots table with the corresponding name
function db_delete_mystery_spot($this_name)
{
  	// connect to the db...
	$con = db_connect();
	
	// 1. delete all the journal entries for this spot.
	$sql_journal_entries="DELETE FROM exploration_data WHERE mystery_spot_name = '" . $this_name . "'";
	
	// execute it.... did it work?
	if (!mysql_query($sql_journal_entries))
  	{                                                                            
		handle_sql_error("db_delete_mystery_spot...if (!mysql_query($sql_journal_entries))", $sql_journal_entries);
  	}
	
	// 2. delete the spot...
	// build the sql statement to delete this spot...
	$sql_spot="DELETE FROM mystery_spots WHERE mystery_spot_name = '" . $this_name . "'";

	// execute it.... did it work?
	if (!mysql_query($sql_spot))
  	{
		handle_sql_error("db_delete_mystery_spot...if (!mysql_query($sql_spot))", $sql_spot);
  	}
	
	// it worked...echo out a success message to the user..
	echo "Success: '<strong>" . $this_name . "</strong>' has been deleted from the db.";
	
	// disconnect from the db..
	db_disconnect($con);
 
} // end function db_insert_mystery_spot()

//***************************************************************************************************
// INSERT A JOURNAL ENTRY RECORD INTO THE DB
// These are the fields for a record in the `exploration_data` table:
// 01. "unique_id" ...auto incremented
// 02. "mystery_spot_name" 
// 03. "explore_date"  
// 04. "explore_flow"  
// 05. "quality"  
// 06. "explore_notes"  
// 07. "high_water_event"  
function db_insert_journal_entry( 
	$mystery_spot_name,  
	$explore_date,  
	$explore_flow, 
	$quality,  
	$explore_notes,  
	$high_water_event)
{

	//make sure there are no invalid chars...  ...namely a single and double quotes...which will make the sql statement barf...
	$mystery_spot_name = strip_invalid_chars($mystery_spot_name);
	$explore_date = strip_invalid_chars($explore_date);
	$explore_flow = strip_invalid_chars($explore_flow);
	$quality = strip_invalid_chars($quality);
	$explore_notes = strip_invalid_chars($explore_notes);  
	$high_water_event = strip_invalid_chars($high_water_event);
	
 	// connect to the db...
	$con = db_connect();
		
	// build the sql insert statement...
	$sql="INSERT INTO exploration_data (
		mystery_spot_name, 
		explore_date, 
		explore_flow, 
		quality,  
		explore_notes,  
		high_water_event)
	VALUES (
		'$mystery_spot_name', 
		'$explore_date', 
		'$explore_flow', 
		'$quality', 
		'$explore_notes', 
		'$high_water_event')";

	// excute it...did it work?
	if (!mysql_query($sql))
  	{
		handle_sql_error("db_insert_journal_entry...if (!mysql_query($sql))", $sql);
  	}
	
	// display a success message to the user..
	echo "Success: A journal entry for '<strong>" . $mystery_spot_name . "</strong>' has been added to the db.";
	
	// close the db connection...
	db_disconnect($con);
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
	$mystery_spot_name,  
	$explore_date,  
	$explore_flow, 
	$quality,  
	$explore_notes,  
	$high_water_event)
{

	//make sure there are no invalid chars...  ...namely a single and double quotes...which will make the sql statement barf...
	$mystery_spot_name = strip_invalid_chars($mystery_spot_name);
	$explore_date = strip_invalid_chars($explore_date);
	$explore_flow = strip_invalid_chars($explore_flow);
	$quality = strip_invalid_chars($quality);
	$explore_notes = strip_invalid_chars($explore_notes);  
	$high_water_event = strip_invalid_chars($high_water_event);
	
 	// connect to the db...
	$con = db_connect();
				
	// build the sql update statement...
	$sql="UPDATE exploration_data 
	SET
		mystery_spot_name = '" . $mystery_spot_name . "',
		explore_date = '" . $explore_date . "', 
		explore_flow = '" . $explore_flow . "', 
		quality = '" . $quality . "',  
		explore_notes = '" . $explore_notes . "',  
		high_water_event = '" . $high_water_event . "'
	WHERE 
		unique_id = '" . $journal_id . "'";
		
	// excute it...did it work?
	if (!mysql_query($sql))
  	{
		handle_sql_error("db_update_journal_entry...if (!mysql_query($sql))", $sql);
  	}
	
	// display a success message to the user..
	echo "Success: A journal entry for '<strong>" . $mystery_spot_name . "</strong>' has been updated in the db.";
		
	// close the db connection...
	db_disconnect($con);
} // end function db_insert_journal_entry()

//**********************************************************************************************************
// this function deletes a record from the exploration table with the corresponding unique_id
function db_delete_journal_entry($id)
{
  	// connect to the db...
	$con = db_connect();
	
	// delete this journal entry 
	$sql_journal_entry="DELETE FROM exploration_data WHERE unique_id = '" . $id . "'";
	
	// execute it.... did it work?
	if (!mysql_query($sql_journal_entry))
  	{                                                                            
		handle_sql_error("db_delete_journal_entry...if (!mysql_query($sql_journal_entry))", $sql_journal_entry);
  	}
		
	// it worked...echo out a success message to the user..
	echo "Success: the journal entry has been deleted from the db.";
	
	// disconnect from the db..
	db_disconnect($con);
 
} // end function db_delete_journal_entry()

//*******************************************************************************************************
// CREATE NEW USER IN DB
function db_insert_user( 
	$user_name,  
	$user_password)
{
	//make sure there are no invalid chars...  ...namely a single and double quotes...which will make the sql statement barf...
	$user_name = strip_invalid_chars($user_name);
	$user_password = strip_invalid_chars($user_password);
	
	//##################################################################
	// DONT STRIP INVALID CHARS...WE SHOULD REALLY JUST VALIDATE INPUT ...
	//###################################################################
	
 	// connect to the db...
	$con = db_connect();
		
	// build the sql insert statement...
	$sql="INSERT INTO users (
		user_name, 
		user_password)
	VALUES (
		'$user_name', 
		'$user_password')";

	// excute it...did it work?
	if (!mysql_query($sql))
  	{
		handle_sql_error("db_insert_user...if (!mysql_query($sql))", $sql);
  	}
	
	// display a success message to the user..
	echo 'Success: A new user was created with the name "<b>' . $user_name . '</b>" and password "<b>' . $user_password . '</b>". Please login.';
	
	// close the db connection...
	db_disconnect($con);
} // end function db_insert_journal_entry()

//******************************************************************************************************************************

function is_valid_user_and_password($user_name, $user_password)
{
	// connect to the db...
	$con = db_connect();
	
	// does this name and password pair exist in the table??
	$sql = "SELECT * FROM `users` WHERE `user_name`='" . $user_name . "' AND `user_password`='" . $user_password . "'";
	
	// execute it.... did it work?
	//select this mystery spot...
	$result = mysql_query($sql);
	if (!$result)
  	{                                                                            
		// handle sql error....
		handle_sql_error("is_valid_user_and_password()", $sql);		
  	}
		
	//  grab the record.. 
	$row = mysql_fetch_array($result, MYSQL_ASSOC); 
	
	// is there at least one row?
	if (!$row) 
		return false; // NO
	else
		return true; // yes

	// disconnect from the db..
	db_disconnect($con);
}
//************************************************************************************************************************
function is_valid_user($user_name)
{
	// connect to the db...
	$con = db_connect();
	
	// does this name and password pair exist in the table??
	$sql = "SELECT * FROM `users` WHERE `user_name`='" . $user_name . "'";
	
	// execute it.... did it work?
	//select this mystery spot...
	$result = mysql_query($sql);
	if (!$result)
  	{                                                                            
		// handle sql error....
		handle_sql_error("is_valid_user()", $sql);		
  	}
		
	//  grab the record.. 
	$row = mysql_fetch_array($result, MYSQL_ASSOC); 
	
	// is there at least one row?
	if (!$row) 
		return false; // NO
	else
		return true; // yes

	// disconnect from the db..
	db_disconnect($con);
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
}

//******************************************************************************************************
function get_mystery_spot_name_from_id($this_id)
{
	// what is the id?
	//echo "<br>You just selected this unique_id: <strong>" . $_GET['spot_id'] . "</strong><br>";

	// now select that row in the db to get the mystery_spot_name..
	// connect to the db... 
	$con = db_connect(); 
  
	//select all the mystery spots...
	$result = mysql_query("SELECT * FROM `mystery_spots` WHERE unique_id = '" . $this_id . "'");

	// roll through the record set and list the spots...
	$row = mysql_fetch_array($result, MYSQL_ASSOC); 

	// save this to a var so we can use it in the select statement below for the select statement...
	$mystery_spot_name = $row['mystery_spot_name'];  // we use this below when selection the journal entries...	
	
	// disconnect from the db... 
	db_disconnect($con);  

	// return the spot...
	return $mystery_spot_name;
	
} // end get_currently_selected_spot()

//*********************************************************************************************************
function get_id_from_mystery_spot_name($this_name)
{
	// what is the id?
	//echo "<br>You just selected this unique_id: <strong>" . $_GET['spot_id'] . "</strong><br>";

	// now select that row in the db to get the mystery_spot_name..
	// connect to the db... 
	$con = db_connect(); 
  
	//select all the mystery spots...
	$result = mysql_query("SELECT * FROM `mystery_spots` WHERE mystery_spot_name = '" . $this_name . "'");

	// roll through the record set and list the spots...
	$row = mysql_fetch_array($result, MYSQL_ASSOC); 

	// save this to a var so we can use it in the select statement below for the select statement...
	$unique_id = $row['unique_id'];  // we use this below when selection the journal entries...	
	
	// disconnect from the db... 
	db_disconnect($con);  

	// return the spot...
	return $unique_id;
	
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
}

//********************************************************************************************************
// this functions returns an array of the data for the record with this id..
function get_mystery_spots_record_from_id($this_id)	  
{	
	// connect to the db... 
	$con = db_connect(); 
  
	//select this mystery spot...
	$result = mysql_query("SELECT * FROM `mystery_spots` WHERE `unique_id` = '" . $this_id . "'");

	// assuming this spot is in the db... grab its data... 
	$row = mysql_fetch_array($result, MYSQL_ASSOC); 
	//if (!$row)
	//{
		//echo "didnt get the row";
	//}
    //	else
	//{
	//	echo "got the row";
	//   }
	
  	// disconnect from the db... 
	db_disconnect($con); 
	
	// return the row.... assuming we found it....
	return $row;
}

//*****************************************************************************************************
// this functions returns an array of the data for the record with this id..
// example of function call: $thisRow = get_journal_entry_with_this_id($_GET['journal_id']);
function get_journal_entry_record_from_id($this_id)	  
{	
	// connect to the db... 
	$con = db_connect(); 
  
	//select this mystery spot...
	$result = mysql_query("SELECT * FROM `exploration_data` WHERE `unique_id` = '" . $this_id . "'");

	// assuming this spot is in the db... grab its data... 
	$row = mysql_fetch_array($result, MYSQL_ASSOC); 
	//if (!$row)
	//{
		//echo "didnt get the row";
	//}
    //	else
	//{
	//	echo "got the row";
	//   }
	
  	// disconnect from the db... 
	db_disconnect($con); 
	
	// return the row.... assuming we found it....
	return $row;
}

//********************************************************************************************************
// This function will return the greatest unique id in a table....
// ex... unique_id column3
//           1      data1
//           2      data2
//           3      data3
// $highestId = get_highest_unique_id_in_table($table1)
// so....$highestId == 3
function get_highest_unique_id_in_table($table_name)
{	
	// connect to the db... 
	$con = db_connect(); 
  
	//select all the mystery spots... list in descending order...
	$result = mysql_query("SELECT * FROM `" . $table_name . "` ORDER BY `unique_id` DESC");

	// roll through the record set and list the spots...the first one will be the highest unique id..
	$row = mysql_fetch_array($result, MYSQL_ASSOC); 

	// disconnect from the db... 
	db_disconnect($con);  

	// return highest unique_id....
	return $row['unique_id'];
	
} // end get_currently_selected_spot()
//********************************************************************************************************
// When inserting a new spot in the mystery_spots table, we must ensure that there are no dups...
// this function returns true or false...
function is_there_a_duplicate_spot($old_spot_name, $new_spot_name)
{
	// connect to the db... 
	$con = db_connect(); 
  
	//select all the mystery spots...
	$result = mysql_query("SELECT * FROM `mystery_spots`");

	// initialize the return value... assume we didnt find one. if we find a dup, we set this to TRUE below
	$return_value = "FALSE";
	
	// roll through the records...
	while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 
	{
		if ($row['mystery_spot_name'] == $new_spot_name) 
			$return_value = "TRUE";
	}
	
  	// disconnect from the db... 
	db_disconnect($con); 
	
	// return the row.... assuming we found it....
	return $return_value;
	
}
//*********************************************************************************************************
// this function will return the gauge number for the spot with the id that you pass in....
function get_gauge_url_from_id($this_id)
{

	// connect to the db... 
	$con = db_connect(); 
  
	//select this mystery spot...
	$result = mysql_query("SELECT * FROM `mystery_spots` WHERE `unique_id` = '" . $this_id . "'");

	// assuming this spot is in the db... grab its data... 
	$row = mysql_fetch_array($result, MYSQL_ASSOC); 
	$gauge_url = $row['gauge_url'];
	
	//if (!$row)
	//{
		//echo "didnt get the row";
	//}
    //	else
	//{
	//	echo "got the row";
	//   }
	
  	// disconnect from the db... 
	db_disconnect($con); 
	
	// return the row.... assuming we found it....
	return $gauge_url;
}
//*********************************************************************************
function get_flow_type_from_id($this_id)
{
	// connect to the db... 
	$con = db_connect(); 
  
	//select this mystery spot...
	$result = mysql_query("SELECT * FROM `mystery_spots` WHERE `unique_id` = '" . $this_id . "'");

	// assuming this spot is in the db... grab its data... 
	$row = mysql_fetch_array($result, MYSQL_ASSOC); 
	$flow_type = $row['flow_type'];
	
	//if (!$row)
	//{
		//echo "didnt get the row";
	//}
    //	else
	//{
	//	echo "got the row";
	//   }
	
  	// disconnect from the db... 
	db_disconnect($con); 
	
	// return the row.... assuming we found it....
	return $flow_type;
}

//*******************************************************************************************************
// if you need just one field from a table, pass in the unique_id of the record, and the table and field
function get_field_from_table(
	$this_field /*field name*/, 
	$this_table /*table name*/, 
	$this_id /*unique key*/)
{
		
	// connect to the db... 
	$con = db_connect(); 
   
   	// build the query...
	$sql="SELECT * FROM `" . $this_table . "` WHERE `unique_id` = '" . $this_id . "'";
	// execute it.... did it work?
	//if (!mysql_query($sql))
  	//{                                                                            
	//	// no ...error out..
  	//	die('Error: ' . mysql_error());
  	//}  
	
	//select this mystery spot...
	$result = mysql_query($sql);//("SELECT * FROM `" . $table_name . "` WHERE `unique_id` = '" . $this_id . "'");

	// assuming this spot is in the db... grab its row... 
	$row = mysql_fetch_array($result, MYSQL_ASSOC); 

	// grab the data out of the row.. 			  
	$this_value = $row[$this_field];   
	
	// DEBUGING CODE:
 	//echo "in func... <br>" .  
	 //     "id:" . $this_id . "<br>" .   
	//	  "table:" . $this_table . "<br>" .
	//		  "field:" . $this_field . "<br>" . 
	//	  "value:" . $this_value . "<br>" . 
	//	  "row for latitude:" . $row['latitude'] . "<br>" . 
	//	  "sql:" . $sql . "<br>";
	//	  //"$row['longitude']:" . $row['longitude'] . "<br>";
	
  	// disconnect from the db... 
	db_disconnect($con); 
	
	// return the row.... assuming we found it....
	return $this_value;
}

//########################################################################################################
// FUNCTIONS THAT DYNAMICALLY BUILD STUFF:
//#########################################################################################################

function build_spot_link_list($spot_name, $current_page_name)
{
	// connect to the db... 
	$con = db_connect(); 
  
	//select all the states!
	$state_result = mysql_query("SELECT DISTINCT `state` FROM `mystery_spots` ORDER BY `state` ASC" );
	
	// roll through the record set and list the spots...
	echo "<H2>Mystery Spots:</H2>";
	echo '<div id="accordion">';
	//echo "<ul>"; // open the state list..
	
	// roll through the states...
	while ($state_row = mysql_fetch_array($state_result, MYSQL_ASSOC)) 
	{
		$state = $state_row['state'];
		//echo "<li class='accordion_toggle'><a href='#'>" . $state . "</a></li>";
		echo '<div class="accordion_toggle"><a href="#" id="'. $state . '">'. $state . '</a></div>';
	
		//create the sql statement....
		$sql = "SELECT * FROM `mystery_spots` WHERE `state` = '" . $state . "' ORDER BY `mystery_spot_name`";
		if (!mysql_query($sql))
  		{                                                                            
			// no ...error out..
			echo $sql . "<br>";
  			die('Error: ' . mysql_error());
  		}  

		// get the result from the query...
		$spot_result = mysql_query($sql);
						echo '<div class="accordion_content">';

			echo "<ul>"; // open spot list..

		while ($spot_row = mysql_fetch_array($spot_result, MYSQL_ASSOC)) 
		{
			
			// if this is the currently selected spot, put brackets around the link so the user knows where we are...
			if ($spot_name == $spot_row['mystery_spot_name'] )
			{
				// print the spot to the screen as a link with its id.. with brackets around it
				echo "<li><strong>[<a href=" . $current_page_name . "?spot_id=" . $spot_row['unique_id'] . ">" . $spot_row['mystery_spot_name'] . "</a>]</strong></li>"; 
			}
			else
			{
				// print the spot to the screen as a link with its id....no brackets..
				echo "<li><a href=" . $current_page_name . "?spot_id=" . $spot_row['unique_id'] . ">" . $spot_row['mystery_spot_name'] . "</a></li>"; 
			}
			
			
		} // end while ($spot_row = mysql_fetch_array($spot_result, MYSQL_ASSOC)) 			 
			echo "</ul>"; // close spot list
		echo "</div>";
	} // end while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 

	//echo "</ul>"; // close the state list
		echo "</div>";

	//echo "</div>";

	// disconnect from the db... 
	db_disconnect($con); 
} // end function build_spot_link_list()

// ******************************************************************************************************
// This function builds a table of all the journal entries for the spot that you pass in as a parameter...
function build_journal_entry_list($currently_selected_name)
{

	// what is the mystery_spot id of this name?
	$spot_id = get_id_from_mystery_spot_name($currently_selected_name);
	
	// connect to the db... 
	$con = db_connect(); 
  	
	//select all the journal entries for this mystery spot...
	$result = mysql_query("SELECT * FROM `exploration_data` WHERE mystery_spot_name = '" . $currently_selected_name . "' ORDER BY `explore_date`");

	// roll through the record set and list the spots...
	echo "<strong>Journal:</strong><br>";

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
		echo "<td align=center><strong>Explore Date</strong></td>";
		echo "<td align=center><strong>Explore Flow</strong></td>";
		echo "<td align=center><strong>Quality</strong></td>";
		echo "<td><strong>Notes</strong></td>";
		echo "<td><div align=center><strong>Flood?</strong></div></td>";
		// close this table row for the header..
		echo "</tr>";
	
		// there is at least one row, so print it:
		// open this table row...
		echo "<tr>";
		// print the journal entries for this spot to the screen.. 
		echo "<td align=center><a href=journal_entry_maintenance.php?spot_id=" . $spot_id . "&journal_id=" . $row['unique_id'] . "&action=update>edit</a> <a href=journal_entry_maintenance.php?spot_id=" . $spot_id . "&journal_id=" . $row['unique_id'] . "&action=delete>delete</a></td>";
		echo "<td align=center>" . $row['mystery_spot_name'] . "</td>"; 
		echo "<td align=center>" . $row['explore_date'] . "</td>";
		echo "<td align=right>" . $row['explore_flow'] . get_flow_type_from_id($spot_id) . "</td>";
		echo "<td align=center>" . $row['quality'] . "</td>";
		echo "<td>" . $row['explore_notes'] . "</td>";
	
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

		// see if there are any other rows...
		while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 
		{
		
			// open this table row...
			echo "<tr>";

			// print the journal entries for this spot to the screen..
			echo "<td align=center><a href=journal_entry_maintenance.php?spot_id=" . $spot_id . "&journal_id=" . $row['unique_id'] . "&action=update>edit</a> <a href=journal_entry_maintenance.php?spot_id=" . $spot_id . "&journal_id=" . $row['unique_id'] . "&action=delete>delete</a></td>";
			echo "<td align=center>" . $row['mystery_spot_name'] . "</td>"; 
			echo "<td align=center>" . $row['explore_date'] . "</td>";
			echo "<td align=right>" . $row['explore_flow'] . get_flow_type_from_id($spot_id) . "</td>";
			echo "<td align=center>" . $row['quality'] . "</td>";
			echo "<td>" . $row['explore_notes'] . "</td>";
	
	
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
		} // end while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) 

		// close the table...
		echo "</table>";

	} // end if ($result)

	// disconnect from the db... 
	db_disconnect($con); 
	
} // end function build_journal_entry_list($currently_selected_spot)

//*****************************************************************************************************
function build_mystery_spot_info($mystery_spot_name)
{	
	// connect to the db... 
	$con = db_connect(); 
  
  	// roll through the record set and list the spots...
	echo "<strong>Spot Info:</strong><br>";
  
	//select all the mystery spots...
	$result = mysql_query("SELECT * FROM `mystery_spots` WHERE mystery_spot_name = '" . $mystery_spot_name . "'");

	// assuming this spot is in the db... grab its data... 
	$row = mysql_fetch_array($result, MYSQL_ASSOC); 
	if (!$row)
	{
		echo "No spot has been selected yet...";
	}
	else
	{	
	
		// print the info out..
		echo "
		<table width=107% border=1>
    		<tr> 
      			<td width=11%><strong>Name:</strong></td>
      			<td width=18%>" . $row['mystery_spot_name'] . "</td>
      			<td width=4%>&nbsp;</td>
      			<td colspan=2><strong>Notes / Directions:</strong></td>
    		</tr>
    		<tr> 
      			<td height=30><strong>River:</strong></td>
      			<td>" . $row['river'] . "</td>
      			<td>&nbsp;</td>
      			<td colspan=2 rowspan=4 valign=top>" . $row['notes'] . "</td>
    		</tr>
    		<tr> 
      			<td height=26><strong>Region:</strong></td>
      			<td>" . $row['region'] . "</td>
      			<td>&nbsp;</td>
    		</tr>
    		<tr> 
     	 		<td height=26><strong>State:</strong></td>
     	 		<td>" . $row['state'] . "</td>
     	 		<td>&nbsp;</td>
   	 		</tr>
    		<tr> 
      			<td height=26><strong>City:</strong></td>
      			<td>" . $row['city'] . "</td>
      			<td>&nbsp;</td>
    		</tr>
    		<tr> 
      			<td><strong>Longitude:</strong></td>
      			<td>" . $row['longitude'] . "</td>
      			<td>&nbsp;</td>
				<td><strong>Current Flow:</strong></td>
	  			<td><font color=#0000FF>See Gage...</font> 
    			</td>
    		</tr>
    		<tr> 
      			<td><strong>Latitude:</strong></td>
      			<td>" . $row['latitude'] . "</td>
      			<td>&nbsp; </td>
      			<td width=11%><strong>Min Flow:</strong></td>
      			<td width=56%>" . $row['ideal_min_flow'] . get_flow_type_from_id($row['unique_id']) . "</td>
    		</tr>
    		<tr> 
      			<td height=23><strong>Gage Name:</strong></td>
      			<td>" . $row['gauge_name'] . "</td>
      			<td>&nbsp;</td>
      			<td><strong>Ideal Flow:</strong></td>
      			<td>" . $row['ideal_flow'] . get_flow_type_from_id($row['unique_id']) . "</td>
    		</tr>
    		<tr> 
      			<td height=23><strong>Gage #:</strong></td>
      			<td>" . $row['gauge_number'] . "</td>
      			<td>&nbsp;</td>
      			<td><strong>Max Flow:</strong></td>
      			<td>" . $row['ideal_max_flow'] . get_flow_type_from_id($row['unique_id']) . "</td>
    		</tr>
    		<tr> 
      			<td height=23><strong>Gage Url:</strong></td>
      			<td colspan=4>" . $row['gauge_url'] . "</td>
    		</tr>
  		</table>";
	
	} // end if (!$row)
	  
  	// disconnect from the db... 
	db_disconnect($con); 
}

//*********************************************************************************************************
// pass in the name of the spot and this function will build a dropdown list with that name selected..
function build_mystery_spot_dropdown($mystery_spot_name)
{
	// connect to the db... 
	$con = db_connect(); 
	
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

	// disconnect from the db... 
	db_disconnect($con); 
	
}

//*********************************************************************************************************
function build_state_dropdown($current_state)
{
	// connect to the db... 
	$con = db_connect(); 
	
	//select all the mystery spots...
	$result = mysql_query("SELECT * FROM `settings` WHERE `key` = 'STATE'");

	// open tag
	echo "<select name=state>";

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

	// disconnect from the db... 
	db_disconnect($con); 
	
}

//*********************************************************************************************************

function change_mystery_spot_name($old_name, $new_name)
{

	// connect to the db...
	$con = db_connect();
				
	// update all the journal entries....
	$sql="UPDATE exploration_data 
	SET
		mystery_spot_name = '" . $new_name . "',
	WHERE 
		mystery_spot_name = '" . $old_name . "'";
		
	// excute it...did it work?
	if (!mysql_query($sql))
  	{
		// no ..error out and exit...
  		die('Error... could not update record in db: ' . mysql_error());
  	}
	
	
	// update the mystery spot...
		// update all the journal entries....
	$sql="UPDATE mystery_spots 
	SET
		mystery_spot_name = '" . $new_name . "',
	WHERE 
		mystery_spot_name = '" . $old_name . "'";
		
	// excute it...did it work?
	if (!mysql_query($sql))
  	{
		// no ..error out and exit...
  		die('Error... could not update record in db: ' . mysql_error());
  	}
	

	// display a success message to the user..
	echo "Success: The name has been changed from <strong>" . $old_name . "</strong> to <strong>" . $new_name . "</strong> in the db.";
		
	// close the db connection...
	db_disconnect($con);
	

}

//******************************************************************************************************
function email_message($message, $subject)
{
	// this code writes a email..
	$to = "dont_get_trashed@yahoo.com";
	$from = "admin@streamweaver.com";
	$headers = "From: $from";
	mail($to,$subject,$message,$headers);
}
//***********************************************************************************************************************
function write_to_log_file($message)
{
	//$file=fopen("/log.txt","a") or exit("Unable to open log file!");
	//fwrite($file, $message);
	//fclose($file);
}
//*************************************************************************************************
function strip_invalid_chars($in_string)
{
	// create array of invalid chars..
	$invalid_chars = array('"',"'");
	
	// strip out this chars that will make a insert or update statement barf....
	$in_string = str_replace($invalid_chars, "", $in_string);
	
	// return the valid string so we can stick in in the database...
	return $in_string;
}

//*(************************************************************************************************************************

function handle_sql_error($function, $sql)
{
	// create the error message...
	$message = "Error in " . $function . "<br>";
	$message = $message + "sql statement: " . $sql . "<br>";
	$message = $message + "sql error: " . mysql_error(); 
	
	// send email to admin with this message....
	email_message($message, "sql error");
	
	// write the message to a flat txt file...
	write_to_log_file($message);
	
	// ...error out..
  	die('There was an error, sorry. An email has been sent to the Administrator with the details.');
}

//***************************************************************************************************************************

?>