<?php session_start(); 
###################################################################################################
## Written By: 	Scott M. Weaver
## Date: 		2008-01-02
## Notes:  
##	
###################################################################################################
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>

<?php 
// these are all the shared functions... 
include 'includes/functions.php'; 
// get the id from the url, so we can build the link below. if there is no id, this func will return "none"
$currently_selected_id = get_spot_id_from_url($_GET['spot_id']);
?>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Stream Weaver 3.0 - Beta</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="css/print.css" type="text/css" media="print" />
</head>

<body>
<div class="wrapper"> 
  <div class="container"> 
    <div class="icon"> 
      <?php display_icon(); ?>
    </div>
    <?php 
	// show the title "stream weaver" and the login link...
	$user_name = $_SESSION['CURRENT_USER_NAME'];
   	build_title_and_login_stuff($user_name)	  		
	?>
    <?php build_tab_navigation_list($currently_selected_id, "Journal");?>
    <!-- end id="navigation"  -->
    <br class="clear" />
    <div id="body"> 
      <table width="100%" border="0" >
        <tr align="left"> 
          <td valign="top" align="left"> <div class="sidebar"> 
              <div class="content"> 
                <?php build_spot_link_list($currently_selected_id, "index.php" /*current_page_name*/);  // roll through out all the spots and create the links... ?>
              </div>
              <!-- end class="content" -->
            </div>
            <!-- end class="sidebar"-->
          </td>
          <td valign="top" align="left"> <div class="stuff_on_the_right"> 
              <?php
 
 	// get the user name and password that was entered in the form...
	$user_name = $_POST["user_name"];
	$user_password = $_POST["user_password"];
 
	if ($_GET['action'] == "login")
	{
		// is this a valid user name?
		if (is_valid_user($user_name) == true)
		{
			// the user name they entered is in the db...
			// so now check if the password is correct...
			if(is_valid_user_and_password($user_name, $user_password) == true)
			{
				// set the session var so we can get the username later...
				$_SESSION['CURRENT_USER_NAME'] = $user_name;
				
				// set a admin session user so we know that this is the admin....
				if ($user_name == "admin")
					$_SESSION['ADMIN_USER'] = "TRUE";
				else 
					$_SESSION['ADMIN_USER'] = ""; 
				
				// welcome back the user..they are awesome...
				echo "<div align=center>";
				echo 'Welcome Back <b>' . $user_name  . '</b>! You have successfully logged in.';
				echo "</div>";
				
				// anytime a user touches the db, write it to a log file....
				write_to_log( "users"/*$table*/, "all"/*field_affected*/, "n/a"/*spot_id*/, "n/a"/*$sql_statement*/, "login"/*$action*/, "n/a"/*$old_value*/, $_SESSION['CURRENT_USER_NAME']/*$new_value*/, "OK"/*$error_status*/);

			}
			else // end if(is_valid)user_and_password($user_name, $password) == true)
			{
				echo "<div align=center>";
				echo 'The password you entered is not correct for the user name "<b>' . $user_name . '</b>"';
				echo "</div>";
			}
		}
		else // end if (is_valid_user($user_name) == true)
		{
			echo "<div align=center>";
			echo 'This user name "<b>' . $user_name . '</b>" does not yet exist.';	
			echo "</div>";
		}
			
	}// end if ($_GET['action'] == "login")
	else if ($_GET['action'] == "logout")
	{
		echo "<div align=center>";
		// let the user know hes logged out..
		echo 'You have successfully logged out.  Goodbye <b>' . $_SESSION['CURRENT_USER_NAME'] . '</b>!';
		echo "</div>";
		
		// anytime a user touches the db, write it to a log file....
		write_to_log( "users"/*$table*/, "all"/*field_affected*/, "n/a"/*spot_id*/, "n/a"/*$sql_statement*/, "logout"/*$action*/, "n/a"/*$old_value*/, $_SESSION['CURRENT_USER_NAME']/*$new_value*/, "OK"/*$error_status*/);
	
		// clear out the session vars, which essentially logs out the user
		$_SESSION['CURRENT_USER_NAME'] = "";
		$_SESSION['ADMIN_USER'] = "";
	}
	else if ($_GET['action'] == "forgot_id")
	{
		// email the user_id and password to the email address
		email_forotten_id($_POST['email']);
		
		// let the user know they just got emailed...
		echo "An email has been sent with the User Id and Password that corresponds with the email address that you supplied during the creation of the User Id.<br>";
		echo "<br>You will recieve the email shortly. Thank you.<br><br>";
	}
	else if ($_GET['action'] == "forgot_password")
	{
		// email the user_id and password to the email address
		email_forotten_password($_POST['user_id']);

		// let the user know they just got emailed...
		echo "An email has been sent with your Password, to the email address that you supplied when that User Id was created.<br>";
		echo "<br>You will recieve the email shortly. Thank you.<br><br>";
	}
	else if ($_GET['action'] == "new")
	{
		// 1. check to see if there is invalid chars in the input....
		if ((input_contains_invalid_chars($user_name) == true) || (input_contains_invalid_chars($user_password) == true))
	    	echo "<div align=center>You cannot have a single or double quote in your user name or password. Please choose another user name or password.</div>";
		else 
		{
			// 2. check to make sure this isnt a duplicate...usernames must be unique...
			// // is this a valid user name? this function will return true if the username already exists in the db....
			if (is_valid_user($user_name) == true)
				echo "<div align=center>The user name " . $user_name . " already exists. Please choose another user name.</div>";
			else
			{
				// 3. check to make sure the username or password isnt blank...that is invalid...
				if (($user_name == "") || ($user_password == ""))
					echo "<div align=center>You cannot have a blank user name or password. Please enter a valid user name and password.</div>";
				else
				{
					// 4. finally, insert the user...
					// insert the new user...
					db_insert_user( $user_name,  $user_password);
					
					// set the session vars...
					$_SESSION['CURRENT_USER_NAME'] = $user_name;
					$_SESSION['ADMIN_USER'] = "";
					
					// welcome back the user..they are awesome...
					echo '<div align=center><br>Welcome <b>' . $user_name  . '</b>! You have successfully logged in.</div>';
				} // end if (($user_name == "") || ($user_password == ""))
			} // end if (is_valid_user($user_name) == true)
		} // end if ((input_contains_invalid_chars($user_name) == true) || (input_contains_invalid_chars($user_password) == true))
	} // end else if ($_GET['action'] == "new")
	else
		echo "Error: unknown action type of '" . $_GET['action'] ."' so nothing was done to the db.";

?>
              <?php 
// if there is no user name set, and we didnt just log out, then show the back link...
if (($_SESSION['CURRENT_USER_NAME'] == "") && ($_GET['action'] != "logout"))
	echo "<p align=center>[<a href=login.php?spot_id=" . $currently_selected_id . "><em><font color=#0000FF>Try Again</font></em></a>]</p>"; 
else // either the user just logged in, or logged out, so show the home link
	echo "<p align=center>[<a href=index.php?spot_id=" . $currently_selected_id . "><em><font color=#0000FF>Home</font></em></a>]</p>"; 
?>
            </div>
            <!-- end class="stuff_on_the_right -->
          </td>
        </tr>
      </table>
      <br class="clear" />
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