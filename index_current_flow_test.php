<?php session_start(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

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
    <div class="icon"> <img src="images/wave.gif" width="140" height="98" /> </div>
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
              <?php build_mystery_spot_info($currently_selected_id); ?>
              <hr>
              <br>
              <?php build_journal_entry_list($currently_selected_id); // build a table of all the journal entries for the currently selected spot ?>
              <br>
              <?php echo "[<a href=journal_entry_maintenance.php?spot_id=" . $currently_selected_id . "&action=add><em>Add Journal Entry</em></a>]"; ?> 
            
			<br>
			<hr>PARSING TEXT:<BR>
<?php







?>
<iframe id=current_flow src=<?php echo $url; ?> width=750 height=600></iframe>
	
				  
				  
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
      <div id="copyright"> 
        <div class="container"> &copy; Copyright 2008 <a href="mailto:dont_get_trashed@yahoo.com">Scott 
          M. Weaver</a> - <a href=http://weaver.lunarcharc.com/backups>Source</a> 
        </div>
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