<?php session_start(); 
###################################################################################################
## Written By: 	Scott M. Weaver
## Date: 		2008-01-02
## Notes:  
##
// These are the fields for a record in the `gatherings` table:
// `gathering_id` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
// `start_date` DATE NOT NULL ,
// `end_date` DATE NOT NULL ,
// `gathering_info` TEXT NOT NULL ,
// `gathering_url` TEXT NOT NULL ,
// `misc_text1` TEXT NOT NULL		
###################################################################################################
$_SESSION['CURRENT_PAGE_FILENAME'] = 'news.php';
$_SESSION['NAV_BUTTON_TEXT'] = 'News';
include('header.php')
?>

<?php

	// if no user has logged in, dont them them add or edit or delete a journal entry...
	if ($_SESSION['CURRENT_USER_NAME'] == "")
	{
		echo "You must be logged in to add or edit Links.<br>";
		echo "Please login: [<a href=login.php>login</a>]<br><br>";
		die("<p align=center>[<a href=news.php?spot_id=" . $_GET["spot_id"] . "><em>Cancel: Go Back</em></a>]</p>"); 
	}
	 
	if ($_GET['action'] == "add")
	{ 
		// create a new record....
		db_add_link(    
			$_SESSION['CURRENT_USER_NAME'],  
			$_POST["link_url"],  
			$_POST["link_label"]);
			
	} // end if ($_GET['action'] == "add")
	else if ($_GET['action'] == "delete")
	{
		// get the journal entry record before we delete it, to grab the username from the record....
		$row = get_journal_entry_record_from_id($_GET["journal_id"]);	
		
		// make sure this is a valid user ..they could only really get here if they typed the url in with this action...
		if ($_SESSION['ADMIN_USER'] == "") // if this is not the admin...
			//if ($_SESSION['CURRENT_USER_NAME'] != $row['user_name']) // and the current user is not the user that created the journal entry...
				die("Only the administrator is authorized to delete this Gathering. Sorry....");

		// kill it...
		db_delete_gathering($_GET["gathering_id"]);
		
	} // end else if ($_GET['action'] == "delete")
	else if ($_GET['action'] == "request_delete") 
	{
		echo "An email has been sent to the Administrator requesting the delete of the Gathering.";
		$message = 'the user ' . $_SESSION['CURRENT_USER_NAME'] . '\n' . 
			' just requested the delete of a Gathering with this gatherin id: ' . $_GET["gathering_id"] . '\n' .
			' start date: ' . $_POST["start_date"] .  '\n' .
			' end date: ' . $_POST["end_date"] .  '\n' .
			' gathering name: ' . $_POST["gathering_name"] . '\n' .
			' gathering info: ' . $_POST["gathering_info"] . '\n' .
			' gathering url: ' . $_POST["gathering_url"];

		$subject = 'delete gathering request';
		email_message($message, $subject);
	}
	else if ($_GET['action'] == "update")
	{
		// get the journal entry record before we delete it, to grab the username from the record....
		$row = get_gathering_record_from_id($_GET["gathering_id"]);	
		
		// make sure this is a valid user ..they could only really get here if they typed the url in with this action...
		//if ($_SESSION['ADMIN_USER'] == "") // if this is not the admin...
		//	if ($_SESSION['CURRENT_USER_NAME'] != $row['user_name']) // and the current user is not the user that created the journal entry...
		//		die("Only the administrator and the user who created it are authorized to edit this journal entry. Sorry....");
		
		// update it...
		db_update_gathering(
		$_GET["gathering_id"], 
		$_POST["start_date"],  
		$_POST["end_date"], 
		$_POST["gathering_name"],  
		$_POST["gathering_info"], 
		$_POST["gathering_url"]);
		
	} // end else if ($_GET['action'] == "update")
	else
		echo "Error: unknown action type of '" . $_GET['action'] ."' so nothing was done to the db.";
			
		
?>
              <hr>
              <?php 
echo "<p align=center>[<a href=news.php?spot_id=" . $currently_selected_id . "><em>Go Home</em></a>]</p>"; 
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