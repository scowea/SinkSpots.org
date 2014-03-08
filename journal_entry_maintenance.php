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
        <h1 class="pagetitle">Exploration Journal...</h1>

        <!-- Content unit - One column -->
        <div class="column1-unit"> 
            <?php 
// if no user has logged in, dont them them add or edit or delete a journal entry...
if ($_SESSION['CURRENT_USER_NAME'] == "")
{
	echo "<div align=center>";
	echo "You must be logged in to add, edit or delete any journal entries.<br>";
	echo "Please [<a href=login.php?spot_id=" . $currently_selected_id . "><font color=#0000FF>login</font></a>]<br><br>";
	echo "</div>";
	die(""); 
}

// evaluate if this is a add or a edit 
if ($_GET['action'] == 'add' )
{

	echo "
  		 <table width='107%' border='1'>
		<form action=journal_entry_commit.php?spot_id=" . $currently_selected_id . "&action=add method=post>
  		  <input name=submit type=submit value='Add Journal Entry' />";
		  
	// we want the inputs on the form to be edittable, so leave this blank so this attribute is not included in the input tag
	$read_only = "";
	$disabled = ""; // this is only used for the check box... 	  
	$name_read_only = " readonly=true " ; // this is only used for the spot name
	
	// get todays date so we can default the date of a journal entry we create..
	$explore_date = date("Y-m-d");
	
}
else if ($_GET['action'] == 'delete' )
{
	// select this spot and populate some vars...
	$row = get_journal_entry_record_from_id($_GET['journal_id']);

	// make sure this is a valid user ..they could only really get here if they typed the url in with this action...
	if ($_SESSION['ADMIN_USER'] == "") // if this is not the admin...
		if ($_SESSION['CURRENT_USER_NAME'] != $row['user_name']) // and the current user is not the user that created the journal entry...
			die("Only the administrator and the user who created it are authorized to delete this journal entry. Sorry....");
	
	// warn the user on last time before we delete it...
	// warn the user again...
	echo "You are about to delete this journal entry from the database. Do you really want to do this???<br>";

	echo "
  		 <table width='107%' border='1'>
		<form action=journal_entry_commit.php?spot_id=" . $currently_selected_id . "&journal_id=" . $_GET['journal_id'] . "&action=delete method=post>
  		  <input name=submit type=submit value='Delete Journal Entry' />"; 
		  
	// we want the inputs on the form to be readonly....
	$read_only = " readonly=true ";
	$disabled = " disabled=true "; // this is only used for the check box... 
	$name_read_only = " readonly=true " ; // this is only used for the spot name
	 
	$explore_date = $row['explore_date'];

}
else if ($_GET['action'] == 'request_delete')
{
	// warn the user again...
	echo "Only the Administrator can delete journal entries.<BR><BR>Press the button below to REQUEST from the administrator, to DELETE this journal entries from the database. Do you really want to do this???<br><br>" ;

	// select this spot and populate some vars...
	$row = get_journal_entry_record_from_id($_GET['journal_id']);

	echo "
  		 <table width='107%' border='1'>
		<form action=journal_entry_commit.php?spot_id=" . $currently_selected_id . "&journal_id=" . $_GET['journal_id'] . "&action=request_delete method=post>
  		  <input name=submit type=submit value='Request Delete of Journal Entry' />"; 
		  
	// we want the inputs on the form to be readonly....
	$read_only = " readonly=true ";
	$disabled = " disabled=true "; // this is only used for the check box... 
	$name_read_only = " readonly=true " ; // this is only used for the spot name
	 
	$explore_date = $row['explore_date'];

}
else if ($_GET['action'] == 'update' )
{
	// select this spot and populate some vars...
	$row = get_journal_entry_record_from_id($_GET['journal_id']);

	// make sure this is a valid user ..they could only really get here if they typed the url in with this action...
	if ($_SESSION['ADMIN_USER'] == "") // if this is not the admin...
		if ($_SESSION['CURRENT_USER_NAME'] != $row['user_name']) // and the current user is not the user that created the journal entry...
			die("Only the administrator and the user who created it are authorized to edit this journal entry. Sorry....");


	echo "
  		 <table width='107%' border='1'>
	<form action=journal_entry_commit.php?spot_id=" . $currently_selected_id . "&journal_id=" . $_GET['journal_id'] . "&action=update method=post>
  		  <input name=submit type=submit value='Update Journal Entry' />"; 	  
		  
	// we want the inputs on the form to be edittable, so leave this blank so this attribute is not included in the input tag
	$read_only = "";  
	$name_read_only = " readonly=true " ; // this is only used for the spot name
	$disabled = ""; // this is only used for the check box... 
	
	$explore_date = $row['explore_date'];
}
else
	echo "Error: unknown action type of '" . $_GET['action'] ."' was sent to this page. This link you clicked to get here is broken.";
	
?>
            <tr> 
              <td width="13%"> <strong>Name:</strong></td>
              <td width="87%"> 
                <?php 
	  
	  //if ($_GET['action'] == 'add' )
	  //	build_mystery_spot_dropdown($currently_selected_spot); 
	  //else 
	  	echo "<input type=text name=mystery_spot_name " . $name_read_only . " value='" . $currently_selected_spot . "' />";
	?>
              </td>
            </tr>
            <tr> 
              <td height="30"><strong>Explore Date:</strong></td>
              <td><input type="text" name="explore_date" <?php echo $read_only ?> value="<?php echo $explore_date; ?>"/>
                (Enter in the format: YYYY-MM-DD)</td>
            </tr>
            <tr> 
              <td height="26"><strong>Explore Flow:</strong></td>
              <td><input type="text" name="explore_flow" <?php echo $read_only ?> value="<?php echo $row['explore_flow'] ?>"/> 
                <?php echo get_flow_type_from_id($currently_selected_id); ?> </td>
            </tr>
            <tr> 
              <td height="26"><strong>Quality:</strong></td>
              <td><input type="text" name="quality" <?php echo $read_only ?> value="<?php echo $row['quality'] ?>"/>
                (On a scale from 0 to 10, with a 10 meaning excellent) </td>
            </tr>
            <tr> 
              <td height="26"><strong>Notes:</strong></td>
              <td><textarea name="explore_notes" <?php echo $read_only ?> cols="67" rows="4"><?php echo $row['explore_notes'] ?></textarea></td>
            </tr>
            <tr> 
              <td><strong>Flood?</strong></td>
              <?php
	  // A value of zero is considered false. Non-zero values are considered true:
	  if ($row['high_water_event'] == 0) 
			echo "<td><input type=checkbox " . $disabled. " name=high_water_event /> </td>";
		else 
			echo "<td><input type=checkbox " . $disabled . " name=high_water_event checked=checked /></td>";
		 
	  ?>
            </tr></form>
            
      </table>
      <?php 
echo "<p align=center>[<a href=index.php?spot_id=" . $currently_selected_id . "><em><font color=#0000FF>Cancel: Go Back</font></em></a>]</p>"; 
?>
    </div>
   <?php include 'footer.php'; ?>
      