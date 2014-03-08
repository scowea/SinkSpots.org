<?php session_start(); 
###################################################################################################
## Written By: 	Scott M. Weaver
## Date: 		2008-01-02
## Notes:  
##
// These are the fields for a record in the `images` table:
// "image_id" 
// "spot_id"
// "image_filename"
// "image_comment"
// "user_name"		
###################################################################################################
$_SESSION['CURRENT_PAGE_FILENAME'] = 'whats_in.php';
$_SESSION['NAV_BUTTON_TEXT'] = 'Whats In';
include('header.php');
?>
<script language="javascript" type="text/javascript" src="includes/js/jquery-1.3.2.js"></script>
        <script>
  $(document).ready(function(){
    $.getJSON("http://api.flickr.com/services/feeds/photos_public.gne?tags=underwater&tagmode=all&format=json&jsoncallback=?",
        function(data){
          $.each(data.items, function(i,item){
            	$("<img/>").attr("src", item.media.m).appendTo("#container_flick");
           	//$("<p>&nbsp;</p>").appendTo("#container_flick");
            if ( i == 5 ) return false;
          });
        });
  });

</script>
   <!-- Pagetitle -->
       

        <!-- Content unit - One column -->
        <div class="column1-unit"> 
              <?php
 
 	// get the user name and password that was entered in the form...
	$user_name = $_POST["user_name"];
	$user_password = $_POST["user_password"];
 	$user_confirm_password = $_POST["user_confirm_password"];	
	$email = $_POST['email'];
	
	
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
				echo 'Welcome Back <b>' . $user_name  . '</b>! You have successfully logged in.<br><br>';
				echo '
					  <div id="container_flick"></div>';
				//echo "<img src='./images/dalai_lama.jpg' />";
				//echo '<br><br><i>"All that we are is the result of what we have thought" - Buddha<strong></strong></i>';
                
				//echo 'You are a member of <a href=http://www.sinkspots.com/team_awesome.php target=_blank><font color=#0000FF>Team Awesome</font></a>... where your dreams can become reality...';
				
				echo "Empty your mind, be formless, shapeless - like water. Now you put water into a cup, it becomes the cup, you put water into a bottle, it becomes the bottle, you put it in a teapot, it becomes the teapot. Now water can flow or it can crash. Be water, my friend.";
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
		email_forotten_id($email);
		

	}
	else if ($_GET['action'] == "forgot_password")
	{
	
		// email the user_id and password to the email address
		email_forgotten_password($user_name);
	
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
					// did they enter the same password both times
					if ($user_password != $user_confirm_password)
						echo "<div align=center>They passwords you entered did not match. Please make sure you enter the same password.</div>";
					else
					{
						// 4. finally, insert the user...
						// insert the new user...
						db_insert_user( $user_name,  $user_password, $email);
						
						// set the session vars...
						$_SESSION['CURRENT_USER_NAME'] = $user_name;
						$_SESSION['ADMIN_USER'] = "";
						
						// welcome back the user..they are awesome...
						echo '<div align=center><br>Welcome <b>' . $user_name  . '</b>! You have successfully logged in.</div>';
					} 
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
           
        <?php include 'footer.php'; ?>
    