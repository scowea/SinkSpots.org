<?php session_start(); 
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
        <h1 class="pagetitle">Settings...</h1>

        <!-- Content unit - One column -->
        <div class="column1-unit"> 
<?php 
// if no user has logged in, dont them them add or edit or delete a journal entry...
if ($_SESSION['CURRENT_USER_NAME'] == "")
{
	echo "You must be logged in to modify any user settings.<br>";
	echo "Please <a href=login.php?spot_id=" . $currently_selected_id . ">login</a>.<br><br>";
	die("<p align=center>[<a href=index.php?spot_id=" . $currently_selected_id . "><em>Cancel: Go Back</em></a>]</p>"); 
}
?>

<?php 
// get the result set.
$result = get_user_record_from_id($_SESSION['CURRENT_USER_NAME']);
// get the row...
$row = mysql_fetch_array($result, MYSQL_ASSOC); 
?>

<h3><u>User Settings</u>:</h3>

<table border='0'>
<form action=settings_commit.php?spot_id=<?php echo $currently_selected_id; ?>&action=update method=post>
<tr>
	<th align=left>Password:</td>
	<td><input name=user_password type="password" value=<?php echo $row['user_password']; ?> ></td>
</tr>
<tr>
	<td align=left><em><font color="#FF0000">Confirm Password:</font></em></td>
	<td><input name=confirm_user_password type="password" value=<?php echo $row['user_password']; ?> ></td>
</tr>
<tr>
	<th align=left>Email:</td>
	<td><input name=email size=60 type="text" value=<?php echo $row['email']; ?> ><br>
					<em><font size="-1">(if you forget your password, 
                      you can have it emailed to this address)</font></em></td>
</tr>

<!--
<tr>
	<td>Initially Filter The Spot List With This Country:</td>
	  <td> //echo build_country_filter_dropdown($row['initial_spot_list_filter_country']); ?><em><b><font color="#FF0000" size=-1>...This 
        will save but does not actually work yet. Working on it....</font></b></em></td>
</tr>
<tr>
	<td>Initially Filter The Spot List With This State:</td>
	  <td> echo //build_state_filter_dropdown($row['initial_spot_list_filter_state']); ?> 
        <em><b><font color="#FF0000" size=-1>...This will save but does not actually 
        work yet. Working on it...</font></b></em></td>
</tr>
-->
<tr>
	<td><input name=submit type=submit value='Save Settings' /></td>
	  <td></td> 	  
</tr>
</form>       
</table>

<br>
<br>
<hr>

<h3><u>Add A Region</u>:</h3>
<table border='0'>
<form action=settings_commit.php?spot_id=<?php echo $currently_selected_id; ?>&action=add_region method=post>
<tr>
	<th align=left>Region:</td>
	<td><input name=region size=60 type="text" ></td>
</tr>
<tr>
	<td><input name=submit type=submit value='Add Region' /></td>
	  <td></td> 	  
</tr>
</form>       
</table>

<br>
<B>Regions Already Added:</B><?php echo build_dropdown('regions'/*$table_name*/, 'region_name'/*$key*/, 'region'/*$dropdown_name*/, ''/*$initial_value*/); ?>

<br>
<br>
<hr>

<h3><u>Add A Spot Quality</u>:</h3>
<table border='0'>
<form action=settings_commit.php?spot_id=<?php echo $currently_selected_id; ?>&action=add_quality method=post>
<tr>
	<th align=left>Spot Quality:</td>
	<td><input name=spot_quality size=60 type="text" ></td>
</tr>
<tr>
	<td><input name=submit type=submit value='Add Spot Quality' /></td>
	  <td></td> 	  
</tr>
</form>       
</table>

<br>
<B>Spot Qualities Already Added:</B><?php echo build_dropdown('spot_qualities'/*$table_name*/, 'quality_name'/*$key*/, 'quality'/*$dropdown_name*/, ''/*$initial_value*/); ?>


       </div>
      <?php include 'footer.php'; ?>
     