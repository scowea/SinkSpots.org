<?php session_start(); 
###################################################################################################
## Written By: 	Scott M. Weaver
## Date: 		2008-01-02
## Notes:  
##	
###################################################################################################
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php 
// these are all the shared functions... 
include 'includes/functions.php'; 
// get the id from the url, so we can build the 
$currently_selected_id = get_spot_id_from_url($_GET['spot_id']);
?>

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Stream Weaver 3.0 - Beta</title>
    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="css/print.css" type="text/css" media="print" /></head>
  <body>
    
<div class="wrapper"> 
  <div class="container"> 
    <div class="icon"> 
      <?php display_icon(); ?>
    </div>
    <?php 
	$user_name = $_SESSION['CURRENT_USER_NAME'];
   	build_title_and_login_stuff($user_name)	  		
	?>
    <?php build_tab_navigation_list($currently_selected_id, "News"); ?>
    <br class="clear" />
    <div id="body"> 
      <table width="100%" border="0" >
        <tr align="left"> 
          <td valign="top" align="left"> <div class="sidebar"> 
              <div class="content"> 
                <?php build_spot_link_list($currently_selected_id, "news.php" /*current_page_name*/);  // roll through out all the spots and create the links... ?>
              </div>
              <!-- end class="content" -->
            </div>
            <!-- end class="sidebar"-->
          </td>
          <td valign="top" align="left"> 
          <div class="stuff_on_the_right"> 
<?php 

// CONNECT TO THE FORUM DB..
phorum_db_mysql_connect();

//select this mystery spots...
$sql = "SELECT password FROM `_users` WHERE username = 'admin'";

// execute it.... did it work?
$result = mysql_query($sql);
if (!$result) echo mysql_error();                                                                     
	// handle sql error....
	//handle_sql_error("FORUM ADMIN", $sql);		


// get this row for this spot....
//$row = mysql_fetch_array($result, MYSQL_ASSOC); 
echo "<BR><BR><BR><BR>PING<BR><BR>";
// get the name field from the row..
//echo  = $row['PASSWORD(password)'];   	


	
?>
              
            </div>
            <!-- end class="stuff_on_the_right"-->
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
	<img src="images/tab_over.gif" style="display: none; visibility:hidden; width:0; height:0; position:absolute; top: -100px; left: -200px;" />
</body>
</html>