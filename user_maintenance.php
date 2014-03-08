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

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta name="keywords" content="squirt, squirt boat, mysterymove, mystery move, mystery trance, mystery zombie, mystery, kayak, sinkspots, sink" />
    <title>Sink Spots v3.0</title>

    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="css/print.css" type="text/css" media="print" /></head>
  <body>

<?php 
// these are all the shared functions...
include 'includes/functions.php';  
// what spot id where we looking at before we got to this page?
$currently_selected_id = $_GET["spot_id"];
// what user are we editting?
$user_record = get_user_record_from_id($_GET['user_id']); // pass through url...
?>

<div class="wrapper"> 
  <div class="container"> 
    <div class="icon"> 
      <?php display_icon(); ?>
    </div>
    <?php 
	$user_id = $_SESSION['CURRENT_USER_NAME'];
   	build_title_and_login_stuff($user_id)	  		
	?>
    <?php build_tab_navigation_list($currently_selected_id, "Journal"); ?>
    <br class="clear" />
    <div id="body"> 
      <div class="sidebar"> 
        <div class="content"> 
          <?php build_spot_link_list($currently_selected_id, "index.php" /*current_page_name*/);  // roll through out all the spots and create the links... ?>
        </div>
        <!-- end class="content" -->
      </div>
      <!-- end class="sidebar"-->
      <div class="content"> <strong>User Settings:</strong><br>
        <table width="22%" border="0">
          <?php
		  
// open the form...
echo "<form action=user_commit.php?spot_id=" . $currently_selected_id . "&action=login method=post>";
?>
          <tr> 
            <td align=left>Name:</td>
            <td align=left><input name=user_id readonly=true type=text value='<?php echo $user_record['user_name']; ?>' /> 
            </td>
          </tr>
          <tr> 
            <td align=left>Email: <em>if you forget your password, i can email 
              it to you...</em></td>
            <td align=left><input name=email type=text value'<?php echo $user_record['user_email']; ?>'/></td>
          </tr>
          <tr> 
            <td align=left></td>
            <td align=center><input name=submit type=submit value="Save Info"/> 
          </tr></form>
        </table>
      </div>
      <!-- end class="content"-->
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
	<img src="images/tab_over.gif" style="display: none; visibility:hidden; width:0; height:0; position:absolute; top: -100px; left: -200px;"  />
</body>
</html>