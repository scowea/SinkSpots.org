 <?php session_start(); 
###################################################################################################
## Written By: 	Scott M. Weaver
## Date: 		2008-01-02
## Notes:  
##
 		
###################################################################################################
$_SESSION['CURRENT_PAGE_FILENAME'] = 'index.php';
$_SESSION['NAV_BUTTON_TEXT'] = 'Journal';
include('header.php');
?>

 <!-- Pagetitle -->
        <h1 class="pagetitle">Video Maintenance...</h1>

        <!-- Content unit - One column -->
        <div class="column1-unit"> 
            <?php 
// if no user has logged in, dont them them add or edit or delete a video...
if ($_SESSION['CURRENT_USER_NAME'] == "")
{
	echo "You must be logged in to edit or delete any videos.<br>";
	echo "Please <a href=login.php?spot_id=" . $currently_selected_id . ">login</a>.<br><br>";
	die("<p align=center>[<a href=media.php?spot_id=" . $currently_selected_id . "><em>Cancel: Go Back</em></a>]</p>"); 
}


if ($_GET['action'] == 'delete' )
{
	// select this spot and populate some vars...
	$row = get_video_record_from_id($_GET['video_id']);

	// make sure this is a valid user ..they could only really get here if they typed the url in with this action...
	if ($_SESSION['ADMIN_USER'] == "") // if this is not the admin...
		if ($_SESSION['CURRENT_USER_NAME'] != $row['user_name']) // and the current user is not the user that created the journal entry...
			die("Only the administrator and the user who created it are authorized to delete this video. Sorry....");
	
	// warn the user on last time before we delete it...
	// warn the user again...
	echo "You are about to delete this video from the database. Do you really want to do this???<br>";

	echo "
  		 <table border='1'>
		<form action=video_commit.php?spot_id=" . $currently_selected_id . "&video_id=" . $row['video_id'] . "&action=delete method=post>
  		  <input name=submit type=submit value='Delete Video' />"; 
		  
	// we want the inputs on the form to be readonly....
	$read_only = " readonly=true ";
	$name_read_only = " readonly=true " ; // this is only used for the spot name
}
else if ($_GET['action'] == 'update' )
{
	// select this spot and populate some vars...
	$row = get_video_record_from_id($_GET['video_id']);

	// make sure this is a valid user ..they could only really get here if they typed the url in with this action...
	if ($_SESSION['ADMIN_USER'] == "") // if this is not the admin...
		if ($_SESSION['CURRENT_USER_NAME'] != $row['user_name']) // and the current user is not the user that created the journal entry...
			die("Only the administrator and the user who created it are authorized to edit this video. Sorry....");

	echo "
  		 <table border='1'>
	<form action=video_commit.php?spot_id=" . $currently_selected_id . "&video_id=" . $row['video_id'] . "&action=update method=post>
  		  <input name=submit type=submit value='Update Video' />"; 	  
		  
	// we want the inputs on the form to be edittable, so leave this blank so this attribute is not included in the input tag
	$read_only = "";  
	$name_read_only = " readonly=true " ; // this is only used for the spot name

}
else
	echo "Error: unknown action type of '" . $_GET['action'] ."' was sent to this page. This link you clicked to get here is broken.";
	
	
?>
            <tr> 
              <td> <strong>Name:</strong></td>
              <td><input type="text" name="mystery_spot_name" <?php echo $name_read_only ?> value=" <?php echo $currently_selected_spot; ?> "/> 
              </td>
            </tr>
            <tr> 
              <td height="30"><strong>User:</strong></td>
              <td><input type="text" name="user_name" <?php echo $name_read_only ?> value="<?php echo $row['user_name'] ?>"/> 
              </td>
            </tr>
            <tr> 
              <td height="26"><strong>Video:</strong></td>
              <td> 
                <?php 
			  // if this is a update... leave the video spot blank...otherwise, show the embedded video...
			  if ($_GET['action'] == 'update') // show the text....
			  	echo "<textarea type=text name=video_url" . $read_only . " cols=70 rows=6>" . $row['video_url'] . "</textarea>";	
			  else if ($_GET['action'] == 'delete') // show the vid
			  	echo $row['video_url'];
			  	
			  ?>
              </td>
            </tr>
            <tr> 
              <td height="26"><strong>Comment:</strong></td>
              <td><input type="text" name="video_comment" size="100" <?php echo $read_only ?> value="<?php echo $row['video_comment'] ?>"/> 
              </td>
            </tr>
            <tr> 
              <td height="26"><strong>Date Added:</strong></td>
              <td><input type="text" name="data_added" <?php echo $name_read_only ?> value="<?php echo $row['date_added'] ?>"/></td>
            </tr></form>
            
      </table>
      <?php 
echo "<p align=center>[<a href=media.php?spot_id=" . $currently_selected_id . "><em>Cancel: Go Back</em></a>]</p>"; 
?>
    </div>
     <?php include 'footer.php'; ?>
      