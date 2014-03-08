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
	echo "<div align=center>";
	echo "You must be logged in to add or edit any mystery spots.<br>";
	echo "Please [<a href=login.php?spot_id=" . $currently_selected_id . "><font color=#0000FF>login</font></a>]<br><br>";
	echo "</div>";
	die(""); 
}

// evaluate if this is a add or a edit 
if ($_GET['action'] == 'add' )
{
	echo "<table width='107%' border='1'>
		<form action=spot_commit.php?action=add method=post>
  		  <input name=submit type=submit value='Add Spot' />";
		  
	// we want the inputs on the form to be enabled....
	$read_only = "";  // make it blank so we dont include this attribute on the input tag
}
else if ($_GET['action'] == 'add_lat_long' )
{
	// the user clicked the add button...
	if ($_POST["submit_button"] == "Add Spot")
	{
		echo "<table width='107%' border='1'>
			<form action=spot_commit.php?action=add method=post>
			  <input name=submit type=submit value='Add Spot' />";
			  
		// we want the inputs on the form to be enabled....
		$read_only = "";  // make it blank so we dont include this attribute on the input tag
		
		// fill the lat and long inputs, from what the user had from the explore.php page.....
		$row['latitude'] = $_POST['latitude'];
		$row['longitude'] = $_POST['longitude'];
	}
	else // "Update"
	{
		echo "<font color=#0000FF>The Latitude and Longitude have bee updated below with the coordinates from the map.  Please click the Update button to save these changes.</font><br><br>";
		
		// select this spot and populate some vars...
		$row = get_mystery_spots_record_from_id($currently_selected_id);
	
		echo "<table width='107%' border='1'>
			<form action=spot_commit.php?spot_id=" . $currently_selected_id . "&action=update method=post>
			  <input name=submit type=submit value='Update Spot' />"; 	 
			  
		// we want the inputs on the form to be enabled....
		$read_only = " ";  // make it blank so we dont include this attribute on the input tag
		
		// fill the lat and long inputs, from what the user had from the explore.php page.....
		$row['latitude'] = $_POST['latitude'];
		$row['longitude'] = $_POST['longitude'];
	}
}
else if ($_GET['action'] == 'delete')
{
	// make sure this is a valid user ..they could only really get here if they typed the url in with this action...
	if ($_SESSION['ADMIN_USER'] == "")
		die("Only the administrator is authorized to delete spots. Please request a delete and the administrator will be emailed.");
	
	// warn the user again...
	echo "You are about to DELETE this spot and all its journal entries from the database. Do you really want to do this???<br><br>";

	// select this spot and populate some vars... 
	$row = get_mystery_spots_record_from_id($currently_selected_id);

	echo "<table width='107%' border='1'>
		<form action=spot_commit.php?spot_id=" . $currently_selected_id . "&action=delete method=post><input name=submit type=submit value='Delete Spot' />"; 
		  
	// we want the inputs on the form to be readonly....
	$read_only = " readonly=true ";
	
}
else if ($_GET['action'] == 'request_delete')
{
	// warn the user again...
	echo "You are about to REQUEST from the administrator, to DELETE this spot and all its journal entries from the database. Do you really want to do this???<br><br>" ;

	// select this spot and populate some vars... 
	$row = get_mystery_spots_record_from_id($currently_selected_id);

	echo "<table width='107%' border='1'>
			<form action=spot_commit.php?spot_id=" . $currently_selected_id . "&action=request_delete method=post>
  		  <input name=submit type=submit value='Request Delete' />"; 
		  
	// we want the inputs on the form to be readonly....
	$read_only = " readonly=true ";
}
else if($_GET['action'] == 'update' )
{
	// select this spot and populate some vars...
	$row = get_mystery_spots_record_from_id($currently_selected_id);

	echo "<table width='107%' border='1'>
		<form action=spot_commit.php?spot_id=" . $currently_selected_id . "&state=" . $_POST['state'] . "&action=update method=post>
  		  <input name=submit type=submit value='Update Spot' />"; 	 
		  
	// we want the inputs on the form to be enabled....
	$read_only = " ";  // make it blank so we dont include this attribute on the input tag
}
else
	echo "Error: unknown action type of '" . $_GET['action'] ."' was sent to this page. This link you clicked to get here is broken.";
		
?>
            <tr> 
              <td width="13%"><strong>Name:</strong></td>
              <td width="18%"><input  name="mystery_spot_name" <?php echo $read_only ?> type="text" value="<?php echo $row['mystery_spot_name'] ?>"  /> 
              </td>
              <td width="2%">&nbsp;</td>
              <td colspan="2"><strong>Notes / Directions:</strong></td>
            </tr>
            <tr> 
              <td height="30"><strong>River:</strong></td>
              <td><input type="text" name="river" <?php echo $read_only ?> value="<?php echo $row['river'] ?>"/></td>
              <td>&nbsp;</td>
              <td colspan="2" rowspan="4"><textarea name="notes" <?php echo $read_only ?> cols="67" rows="6"><?php echo $row['notes'] ?></textarea></td>
            </tr>
            <!-- BEGIN - THIS IS THE CRAP TO DYNAMICLY BUILD THE COUNTRY/STATE DROPDOWNS -->
            <!-- The id of the country field(s).  If more than one, seperate with spaces -->
            <input type="hidden" value="countrySelect" name="cs_config_country_field" id="cs_config_country_field"> 
            <!-- <input type="hidden" value="stateSelect"   name="cs_config_state_field"   id="cs_config_state_field"> -->
            <!-- The id of the the fields holding the default values.  If more than one, seperate with spaces -->
            <input type="hidden" value="countryDefault" name="cs_config_country_default" id="cs_config_country_default"> 
            <!-- <input type="hidden" value="stateDefault"   name="cs_config_state_default"   id="cs_config_state_default">  -->
            <!-- The actual default values -->
            <input type="hidden" value="<?php echo $row['country'] ?>" name="countryDefault" id="countryDefault"> 
            <!-- <input type="hidden" value="<?php //echo $row['state'] ?>"   name="stateDefault"   id="stateDefault"> -->
            <SCRIPT type="text/javascript" SRC="country_state.js"></SCRIPT> 
            <!-- END - THIS IS THE CRAP TO DYNAMICLY BUILD THE COUNTRY/STATE DROPDOWNS -->
            <tr> 
              <td height="26"><strong>Country:</strong></td>
              <td> <div> 
                  <select id='countrySelect' name='country' >
                  </select>
                </div></td>
              <td>&nbsp;</td>
            </tr>
            <tr> 
              <td height="26"><strong>Region:</strong></td>
              <td><?php echo build_dropdown('regions'/*$table_name*/, 'region_name'/*$key*/, 'region'/*$dropdown_name*/, $row['region']/*$initial_value*/); ?></td>
              <td>&nbsp;</td>
            </tr>
            <tr> 
              <td height="26"><strong>State:</strong></td>
              <td><input type="text" name="state" <?php echo $read_only ?> value="<?php echo $row['state'] ?>"/></td>
              <td>&nbsp;</td>
            </tr>
            <!-- BEGIN - THIS IS THE CRAP TO DYNAMICLY BUILD THE COUNTRY/STATE DROPDOWNS -->
            <SCRIPT type="text/javascript">initCountry(); </SCRIPT>
            <!-- END - THIS IS THE CRAP TO DYNAMICLY BUILD THE COUNTRY/STATE DROPDOWNS -->
            <tr> 
              <td height="28"><strong>City:</strong></td>
              <td><input type="text" name="city" <?php echo $read_only ?> value="<?php echo $row['city'] ?>"/></td>
              <td>&nbsp;</td>
            </tr>
            <tr> 
              <td><strong>Latitude:</strong></td>
              <td><input type="text" name="latitude" <?php echo $read_only ?> value="<?php echo $row['latitude'] ?>"/></td>
              <td>&nbsp; </td>
              <td><strong>Flow Type:</strong></td>
              <td> 
                <?php
	  // A value of zero is considered false. Non-zero values are considered true:
	  if ($row['flow_type'] == "ft") 
		{
			echo "
			<label><input name=flow_type type=radio value=cfs />cfs</label>
          	<label><input type=radio name=flow_type value=ft checked=checked/>ft</label>";
		}
		else  // $row['flow_type'] == "cfs"
		{
			// default 
			echo "
			<label><input name=flow_type type=radio value=cfs checked=checked />cfs</label>
          	<label><input type=radio name=flow_type value=ft />ft</label>";
		}
		 
	  ?>
              </td>
            </tr>
            <tr> 
              <td><strong>Longitude:</strong></td>
              <td><input type="text" name="longitude" <?php echo $read_only ?> value="<?php echo $row['longitude'] ?>"/></td>
              <td>&nbsp;</td>
              <td width="12%"><strong>Min Flow:</strong></td>
              <td width="55%"><input type="text" name="ideal_min_flow" <?php echo $read_only ?> value="<?php echo $row['ideal_min_flow'] ?>"/></td>
            </tr>
            <tr> 
              <td height="23"><strong>Gage Name:</strong></td>
              <td><input type="text" name="gauge_name" <?php echo $read_only ?> value="<?php echo $row['gauge_name'] ?>"/></td>
              <td>&nbsp;</td>
              <td><strong>Ideal Flow:</strong></td>
              <td><input type="text" name="ideal_flow" <?php echo $read_only ?> value="<?php echo $row['ideal_flow'] ?>"/></td>
            </tr>
            <tr> 
              <td height="23"><strong>Gage #:</strong></td>
              <td><input type="text" name="gauge_number" <?php echo $read_only ?> value="<?php echo $row['gauge_number'] ?>"/></td>
              <td>&nbsp;</td>
              <td><strong>Max Flow:</strong></td>
              <td><input type="text" name="ideal_max_flow" <?php echo $read_only ?> value="<?php echo $row['ideal_max_flow'] ?>"/></td>
            </tr>
            <tr> 
              <td height="23"><strong>Gage Url:</strong></td>
              <td colspan="4"><input name="gauge_url" <?php echo $read_only ?> type="text" size="105" value="<?php echo $row['gauge_url'] ?>"/></td>
            </tr>
            <tr> 
              <td height="23"><strong>Prediction Url:</strong></td>
              <td colspan="4"><input name="prediction_url" <?php echo $read_only ?> type="text" size="105" value="<?php echo $row['prediction_url'] ?>"/></td>
            </tr>
            <tr> 
              <td><strong>Quality:</strong></td>
              <td colspan=4> 
                <?php 
		if ($row['spot_quality'] == "poor") 
		{
			echo "
			<input type=radio name=spot_quality value=exploratory > Exploratory
			<input type=radio name=spot_quality value=poor checked=checked> Poor
			<input type=radio name=spot_quality value=moderate > Moderate
			<input type=radio name=spot_quality value=great > Great
			<input type=radio name=spot_quality value=epic  > Epic
			";
		}
		else if ($row['spot_quality'] == "moderate")
		{
			echo "
			<input type=radio name=spot_quality value=exploratory > Exploratory
			<input type=radio name=spot_quality value=poor > Poor
			<input type=radio name=spot_quality value=moderate checked=checked> Moderate
			<input type=radio name=spot_quality value=great > Great
			<input type=radio name=spot_quality value=epic  > Epic
			";
        }
		else if ($row['spot_quality'] == "great")
		{
			echo "
			<input type=radio name=spot_quality value=exploratory > Exploratory
			<input type=radio name=spot_quality value=poor > Poor
			<input type=radio name=spot_quality value=moderate > Moderate
			<input type=radio name=spot_quality value=great checked=checked> Great
			<input type=radio name=spot_quality value=epic  > Epic
			";
		}
		else if ($row['spot_quality'] == "epic")
		{
			echo "
				<input type=radio name=spot_quality value=exploratory > Exploratory
			<input type=radio name=spot_quality value=poor > Poor
			<input type=radio name=spot_quality value=moderate > Moderate
			<input type=radio name=spot_quality value=great > Great
			<input type=radio name=spot_quality value=epic  checked=checked> Epic
			";
		}
		else // exploratory
		{
			echo "
				<input type=radio name=spot_quality value=exploratory checked=checked>Exploratory
			<input type=radio name=spot_quality value=poor > Poor
			<input type=radio name=spot_quality value=moderate > Moderate
			<input type=radio name=spot_quality value=great > Great
			<input type=radio name=spot_quality value=epic > Epic
			";
		}

		?>
              </td>
            </tr>
      </table></form>
      <br>
      <i><B>Admin Note:</B> The latitude/longitude <B>MUST</B> be in the format 
      like 52.886728, 6.231823.... and <b>NOT</b> +52° 53' 12.22", +6° 13' 54.56 
      <br>
      <br>
      If any spot has a invalid lat/lng format then the entire Google Map API 
      will not function properly. Untill we make the code a little smarter, please 
      take note of this and make sure you input it correctly!! <br>
      <br>
      To convert a lat/lng like that plug it into <a href=http://maps.google.com>maps.google.com</a> 
      and it will tell the format that Sink Spots requires.<br>
      <br>
      Thank You, <br>
      SS Development Team<br>
      <br>
      </i> 
      <?php 
echo "<p align=center>[<a href=index.php?spot_id=" . $currently_selected_id . "><em><font color=#0000FF>Cancel: Go Back</font></em></a>]</p>"; 
?>
    </div>
    <?php include 'footer.php'; ?>
     