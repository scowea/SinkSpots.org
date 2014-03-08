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
    <meta name="keywords" content="squirt, squirt boat, mysterymove, mystery move, mystery trance, mystery zombie, mystery, kayak, sinkspots, sink" />
    <title>Sink Spots v3.0</title>

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
    <?php build_tab_navigation_list($currently_selected_id, "Explore");?>
    <!-- end id="navigation"  -->
    <br class="clear" />
    <div id="body"> 
      <table width="100%" border="0" >
        <tr align="left"> 
          <td valign="top" align="left"> <div class="sidebar"> 
              <div class="content"> 
                <?php build_spot_link_list($currently_selected_id, "explore.php" /*current_page_name*/);  // roll through out all the spots and create the links... ?>
              </div>
              <!-- end class="content" -->
            </div>
            <!-- end class="sidebar"-->
          </td>
          <td valign="top" align="left"> <div class="stuff_on_the_right"> 
              <?php

	// if no user has logged in, dont them them add or edit or delete a journal entry...
	if ($_SESSION['CURRENT_USER_NAME'] == "")
	{
		echo "You must be logged in to update the zoom level.<br>";
		echo "Please <a href=login.php?spot_id=" . $currently_selected_id . ">login</a>.<br><br>";
		die("<p align=center>[<a href=explore.php?spot_id=" . $currently_selected_id . "><em>Cancel: Go Back To Explore Tab</em></a>]</p>"); 
	}

    // evaluate what are we doing with the spot... 
	if ($_GET['action'] == "update")
	{ 		
		if (($currently_selected_id == "") || ($currently_selected_id == "none")) 
		{
			echo "There is no mystery spot currently selected. You can only update the initial zoom level of a selected spot...sorry.";
		}
		else
		{
			// update the record
			db_update_zoom_level(
				$currently_selected_id,
				$_POST["zoom_level"]);  	
		}
			
		
	} // end if ($_GET['action'] != "update")
	else
		echo "Error: unknown action type of '" . $_GET['action'] ."' so nothing was done to the db."; ?>
              <hr>
              <?php echo "<p align=center>[<a href=explore.php?spot_id=" . $currently_selected_id . "><em>Go Back To The Map</em></a>]</p>" ; ?> 
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