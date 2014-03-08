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
	$user_id = $_SESSION['CURRENT_USER_NAME'];
   	build_title_and_login_stuff($user_id)	  		
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
	$user_id = $_POST["user_id"];
	$user_email = $_POST["user_email"];
 
	if ($_GET['action'] == "update")
	{
		
				
			
	}// end if ($_GET['action'] == "login")
	else if ($_GET['action'] == "add")
	{
		
	}
	else if ($_GET['action'] == "delete")
	{
	
	} // end else if ($_GET['action'] == "new")
	else
		echo "Error: unknown action type of '" . $_GET['action'] ."' so nothing was done to the db.";

?>
              <?php 
// if there is no user name set, and we didnt just log out, then show the back link...
//if (($_SESSION['CURRENT_USER_NAME'] == "") && ($_GET['action'] != "logout"))
//	echo "<p align=center>[<a href=login.php?spot_id=" . $currently_selected_id . "><em>Cancel: Go Back</em></a>]</p>"; 
//else // either the user just logged in, or logged out, so show the home link
//	echo "<p align=center>[<a href=index.php?spot_id=" . $currently_selected_id . "><em>Home</em></a>]</p>"; 
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