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


// get the date from the form
$user_name = $_SESSION['CURRENT_USER_NAME'];
$password = $_POST['user_password'];
$confirm_password = $_POST['confirm_user_password'];
$email = $_POST['email'];
$country_filter = $_POST['country_filter'];
$state_filter = $_POST['state_filter'];
$region = $_POST['region'];
$spot_quality = $_POST['spot_quality'];

// CLEAN USER INPUT...
//$region = CleanUserInput($region);
///$email = CleanUserInput($email);
//$/confirm_password = CleanUserInput($confirm_password);
//$password = CleanUserInput($password);

if ($_POST['submit'] == 'Add Region')
{

	// i should probably check if this region already exists....
	//echo "ping";
	// insert the new region into the db...
	db_insert_region($region);


}
else if ($_POST['submit'] == 'Add Spot Quality')
{


	db_insert_quality($spot_quality);
}
else
{
	// initiallize it.
	$validation_passed = true;
	 
	// do alittle damn validation...
	//..................
	// VALIDATION HERE!
	//...............
	if (($password == '') || ($confirm_password == ''))
	{
		echo "Your password cannot be blank.";
		$validation_passed = false;
	}
	else if ($password != $confirm_password)
	{
		echo "Your passwords must be the same.";
		$validation_passed = false;
	}
	
	if ($validation_passed == true)
	{
		// now update the record...
		// update the record..
		db_update_user( 
			$user_name,  
			$password,
			$email,
			$country_filter,
			$state_filter);
			
	} // end if ($validation_passed == true)

} // end else



?>
 
       
       </div>
      <?php include 'footer.php'; ?>
      