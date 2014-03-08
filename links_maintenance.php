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
$_SESSION['CURRENT_PAGE_FILENAME'] = 'links.php';
$_SESSION['NAV_BUTTON_TEXT'] = 'News';
include('header.php');
?>

 
<?php 
// if no user has logged in, dont them them add or edit or delete a journal entry...

if ($_SESSION['CURRENT_USER_NAME'] == "")
{
	echo "You must be logged in to add or edit any links.<br>";
	echo "Please <a href=login.php?spot_id=" . $currently_selected_id . ">login</a>.<br><br>";
	die("<p align=center>[<a href=news.php?spot_id=" . $currently_selected_id . "><em>Cancel: Go Back</em></a>]</p>"); 
}

// evaluate if this is a add or a edit 
if ($_GET['action'] == 'add' )
{

	echo "
  		 <table border='0'>
		<form action=links_commit.php?spot_id=" . $currently_selected_id . "&action=add method=post>
  		  <input name=submit type=submit value='Add Link' />";
		  
	// we want the inputs on the form to be edittable, so leave this blank so this attribute is not included in the input tag
	$read_only = "";
	$disabled = ""; // this is only used for the check box... 	  
	$name_read_only = " readonly=true " ; // this is only used for the spot name
	
}
else if ($_GET['action'] == 'delete' )
{
	// select this spot and populate some vars...
	$row = get_gathering_record_from_id($_GET['gathering_id']);

	// make sure this is a valid user ..they could only really get here if they typed the url in with this action...
	if ($_SESSION['ADMIN_USER'] != "") // if this is not the admin...
			die("Only the administrator is authorized to delete this gathering. Sorry....");
	
	// warn the user on last time before we delete it...
	// warn the user again...
	echo "You are about to delete this gathering from the database. Do you really want to do this???<br>";

	echo "
  		 <table border='1'>
		<form action=gathering_commit.php?spot_id=" . $currently_selected_id . "&gathering_id=" . $_GET['gathering_id'] . "&action=delete method=post>
  		  <input name=submit type=submit value='Delete Gathering' />"; 
		  
	// we want the inputs on the form to be readonly....
	$read_only = " readonly=true ";
	$disabled = " disabled=true "; // this is only used for the check box... 
	$name_read_only = " readonly=true " ; // this is only used for the spot name

}
else if ($_GET['action'] == 'request_delete')
{
	// warn the user again...
	echo "Only the Administrator can delete gatherings.<BR><BR>Press the button below to REQUEST from the administrator, to DELETE this gathering from the database. Do you really want to do this???<br><br>" ;

	// select this spot and populate some vars...
	$row = get_gathering_record_from_id($_GET['gathering_id']);

	echo "
  		 <table border='1'>
		<form action=gathering_commit.php?spot_id=" . $currently_selected_id . "&gathering_id=" . $_GET['gathering_id'] . "&action=request_delete method=post>
  		  <input name=submit type=submit value='Request Delete of Gathering' />"; 
		  
	// we want the inputs on the form to be readonly....
	$read_only = " readonly=true ";
	$disabled = " disabled=true "; // this is only used for the check box... 
	$name_read_only = " readonly=true " ; // this is only used for the spot name

}
else if ($_GET['action'] == 'update' )
{
	// select this spot and populate some vars...
	$row = get_gathering_record_from_id($_GET['gathering_id']);

	// make sure this is a valid user ..they could only really get here if they typed the url in with this action...
	//if ($_SESSION['ADMIN_USER'] == "") // if this is not the admin...
	//	if ($_SESSION['CURRENT_USER_NAME'] != $row['user_name']) // and the current user is not the user that created the journal entry...
	//		die("Only the administrator and the user who created it are authorized to edit this journal entry. Sorry....");

	echo "
  		 <table border='1'>
	<form action=gatherings_commit.php?spot_id=" . $currently_selected_id . "&gathering_id=" . $_GET['gathering_id'] . "&action=update method=post>
  		  <input name=submit type=submit value='Update Gathering' />"; 	  
		  
	// we want the inputs on the form to be edittable, so leave this blank so this attribute is not included in the input tag
	$read_only = "";  
	$name_read_only = " readonly=true " ; // this is only used for the spot name
	$disabled = ""; // this is only used for the check box... 

}
else
	echo "Error: unknown action type of '" . $_GET['action'] ."' was sent to this page. This link you clicked to get here is broken.";
	
?>
            
            
            <tr> 
              <td><nobr><strong>Link Url - http://</strong></nobr></td>
              <td><input size=100 type="text" name="link_url" <?php echo $read_only ?> value="<?php echo $row['link_url'] ?>"/></td>
            </tr>
            <tr> 
              <td><nobr><strong>Link Label:</strong></nobr></td>
              <td><input size=100 type="text" name="link_label" <?php echo $read_only ?> value="<?php echo $row['link_label'] ?>"/></td>
            </tr>
            
			</form>
            
      </table>
      <?php 
echo "<p align=center>[<a href=news.php?spot_id=" . $currently_selected_id . "><em>Cancel: Go Back</em></a>]</p>"; 
?>
    </div>
    <!-- end class="stuff_on_the_right --></td>
    </tr> </table> <br class="clear" />
  </div>
  <!-- end id="body"-->
  <br class="clear" />
</div>
  <!-- end class="container"-->
  <br class="clear" />
  <div id="footer"> 
    <div id="footHead"> 
      <div class="clear"></div>
    </div>
    <!-- end id="footHead"-->
    <div id="footBody"> 
      <div class="container"> <br>
      </div>
      <div class="clear"></div>
      <div id="copyright"><?php include 'footer.php'; ?>
      </div>
      <!-- id="copyright" -->
    </div>
    <!--- end class="footBody"-->
  </div>
  <!--- end id="footer"-->
</div>
<!-- id="wrapper" -->
<img src="images/tab_over.gif" style="display: none; visibility:hidden; width:0; height:0; position:absolute; top: -100px; left: -200px;" alt="I am soooo fake pre-loading this image so the navigation doesn't skip while loading the over state.  I know I could use the sliding doors technique to avoid this fate, but I am too lazy." />
</body>
</html>