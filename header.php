 <?php 
ini_set('error_reporting', 0);
error_reporting(0);
session_start(); 
###################################################################################################
## Written By: 	Scott M. Weaver
## Date: 		2008-01-02
## Notes:  
#######################################################################################################
?>
<?php 
// these are all the shared functions... 
include 'includes/functions.php'; 
// get the id from the url, so we can build the link below. if there is no id, this func will return "none"
$currently_selected_id = get_spot_id_from_url($_GET['spot_id']);
if (($_POST['action'] == 'jump_to_spot') || ($_GET['action'] == 'jump_to_spot'))
{
	if (isset($_POST['spot_id']))
	{
		$currently_selected_id = $_POST['spot_id'];
	}
	else
	{
		$currently_selected_id = $_GET['spot_id'];
	}
}
// get the spot name.. we pass this name to the google map to put it in the bubble message... 	
$currently_selected_spot = get_mystery_spot_name_from_id($currently_selected_id);  
?>


<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-10031413-1");
pageTracker._trackPageview();
} catch(err) {}</script>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">

<head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta http-equiv="cache-control" content="no-cache" />
  <meta http-equiv="expires" content="3600" />
  <meta name="revisit-after" content="2 days" />
  <meta name="robots" content="index,follow" />
  <meta name="publisher" content="Simple Solutions Software" />
  <meta name="copyright" content="2008" />
  <meta name="author" content="Simple Solutions Software" />
  <meta name="distribution" content="global" />
  <meta name="description" content="An interactive archive of mystery move spots." />
  <meta name="keywords" content="mystery move, squirt, squirt boating, squirt boat, charc, downtime, down time" />
  <link rel="stylesheet" type="text/css" media="screen,projection,print" href="./css/layout4_setup.css" />
  <link rel="stylesheet" type="text/css" media="screen,projection,print" href="./css/layout4_text.css"/>
  <link rel="icon" type="image/x-icon" href="./favicon.ico" />
  <title>Sink Spots v4.1</title>
  
  
  		<script src="js/jquery-1.4.4.min.js" type="text/javascript"></script>
		<!--script src="prettyphoto/js/jquery.lint.js" type="text/javascript" charset="utf-8"></script-->
		<link rel="stylesheet" href="css/prettyPhoto.css" type="text/css" media="screen" title="prettyPhoto main stylesheet" charset="utf-8" />
		<script src="js/jquery.prettyPhoto.js" type="text/javascript" charset="utf-8"></script>
		
		<style type="text/css" media="screen">
			* { margin: 0; padding: 0; }
			
			body {
				font: 62.5%/1.2 Arial, Verdana, Sans-Serif;
				padding: 0 20px;
			}
			
			h4 { margin: 15px 0 5px 0; }
			
			h4, p { font-size: 1.2em; }
			
			ul li { display: inline; }
			
			.wide {
				border-bottom: 1px #000 solid;
				width: 4000px;
			}
			
			.img_stopper ul li{
				display: inline;
				width: 100%;
			}
			ul#navlist
{
margin-left: 0;
padding-left: 0;
white-space: nowrap;
}

#navlist li
{
display: inline;
list-style-type: none;
}

#navlist a { padding: 3px 10px; }

#navlist a:link, #navlist a:visited
{
color: #fff;
background-color: #036;
text-decoration: none;
}

#navlist a:hover
{
color: #fff;
background-color: #369;
text-decoration: none;
}
		</style>
</head>

<!-- Global IE fix to avoid layout crash when single word size wider than column width -->
<!--[if IE]><style type="text/css"> body {word-wrap: break-word;}</style><![endif]-->

<?php 
if (trim($_SERVER['SCRIPT_NAME']) == "/explore.php")
{	
// get the id from the url, so we can build the link below. if there is no id, this func will return "none"
$currently_selected_id = get_spot_id_from_url($_GET['spot_id']);

// get the spot name.. we pass this name to the google map to put it in the bubble message... 	
$currently_selected_spot = get_mystery_spot_name_from_id($currently_selected_id);  

// get the latitude and longitude...
$latitude = get_field_from_table('latitude' /*field name*/, 'mystery_spots' /*table name*/, $currently_selected_id /*unique id*/, "spot_id" /* name of unique id field in table*/);
if ($latitude == "") $latitude = "0"; // not defined in the db...
$longitude = get_field_from_table('longitude' /*field name*/ , 'mystery_spots' /*table name*/, $currently_selected_id /*unique id*/, "spot_id" /* name of unique id field in table*/); 												
if ($longitude == "") $longitude = "0"; // not defined in the db...

// get the inital zoom level from the db..
$zoom_level = get_field_from_table('zoom_level' /*field name*/, 'mystery_spots' /*table name*/, $currently_selected_id /*unique id*/, "spot_id" /* name of unique id field in table*/);
if ($zoom_level == "") $zoom_level = 15; // not defined in the db...

// get every lat and long from every mystery spot...
$strCoordinates = get_all_coordinates();

// set the defaults...
if (($latitude == "0") || ($longitude == "0"))
{
	// no coordinates is set... center the map on niagra falls
	$longitude = "-79.0762";
	$latitude = "43.0789";
	$zoom_level = 17;
}

// assign the name of the mystery spot to the text to be displayed in the bubble on the map
$bubble_text = $currently_selected_spot;

// if no lat or long is defined for this spot, then just display generic text in the bubble on the map...
if (($latitude == "43.0789") && ($longitude == "-79.0762"))
	$bubble_text = "Find a mystery spot...";
	
	echo "<body onload=" ."'" . "load(" . '"' . $bubble_text . '","' . $latitude . '","' . $longitude . '","' . $zoom_level . '","' . $strCoordinates . '"' . ")" . "'" . " onunload='GUnload()' >";
	//echo "<body >";
	//echo $_SERVER['SCRIPT_NAME'] .'!!!!!!!!!!!';
}
else
{
	echo "<body>";
	//echo $_SERVER['SCRIPT_NAME'];
}
?>
  <!-- Main Page Container -->
  <div class="page-container">

   <!-- For alternative headers START PASTE here -->

    <!-- A. HEADER -->      
    <div class="header">
      
      <!-- A.1 HEADER TOP -->
      
    <div class="header-top"> 
  
      <!-- Sitelogo and sitename -->
      <a class="sitelogo" href="#" title="Go to Start page"></a> 
   
      <div class="sitename"> 
         
        <h1><a href="#" title="Go to Start page">Sink Spots<span style="font-weight:normal;font-size:50%;">&bull;org 
          v4.1</span></a></h1>
        <h2>A tool for aquatic exploration...</h2>
		 <?php 
		$user_name = $_SESSION['CURRENT_USER_NAME'];
   		build_title_and_login_stuff($user_name)	  		
		
//		<font size=-2>(php echo get_num_users();  users)</font>
	?>
      </div>
    
        <!-- Navigation Level 0 -->
        
      <div class="nav0"> 
        <ul>
		<?php echo build_flag_list(); ?>

        </ul>
      </div>			

        <!-- Navigation Level 1 -->
        
      <div class="nav1"> 
	     
        <ul>
          <li><a href=login.php?spot_id=<?php echo $currently_selected_id; ?> >Login</a> </li>
		  
          <li><a title="User Settings" href=settings_maintenance.php?spot_id=" . $spot_id . ">Settings</a></li>
          <li><a title="Get to know who we are" href=about.php?spot_id=" . $spot_id . ">About</a></li>
          <li><a href="mailto:sinkspots@yahoo.com" title="Get in touch with us">Contact</a></li>
        </ul>
      </div>              
      </div>
        
      <!-- A.2 HEADER MIDDLE -->
      <div class="header-middle"> 


 
   
        <!-- Site message -->
         
      <div class="sitemessage"> 
     
       <h1>SWEET &bull; EPIC &bull; DOWNTIME</h1>
        <h2><br />
          All beta is 100% user contributed and maintained.<br />
          <br />
          &rsaquo;&rsaquo;&nbsp;Live it. Love it.<br />
        </h2>
        <h3><a href="#"></a></h3>
      </div>        
      </div>
      
      <!-- A.3 HEADER BOTTOM -->
      <div class="header-bottom">
      
        <!-- Navigation Level 2 (Drop-down menus) -->
        <div class="nav2">
	
	
	   <?php 
	   build_tab_navigation_list($currently_selected_id, $_SESSION['NAV_BUTTON_TEST']); 
	   ?>
         
			

		  
        </div>
	  </div>

      <!-- A.4 HEADER BREADCRUMBS -->

      <!-- Breadcrumbs -->
      <div class="header-breadcrumbs">
        

        <!-- Search form -->                  
        
      </div>
      
     
    </div>

    <!-- For alternative headers END PASTE here -->


    <!-- B. MAIN -->
    <div class="main">
 
      <!-- B.1 MAIN NAVIGATION -->
      <div class="main-navigation">

        <!-- Navigation Level 3 -->
        
      <div class="round-border-topright"></div>
        <h1 class="first"><?php echo get_num_spots(); ?> Mystery Spots</h1>  
		
	<div align=center>
	<br>
	[<a href=spot_maintenance.php?action=add><em><font color=#0000FF>Add New Spot</font></em></a>]<br>
	<br>
	<hr>
	<br>
	<br>
	
		<?php 
		
			if ($_SESSION["CACHE_LAST_UPDATED"] == "") // this is the first time the page has been loaded..
		refresh_flow_cache(); // this function gets the data from usgs and fills the $_SESSION["FLOW_CACHE"] with it.. 
  

	
	//show the jump to dropdown
	echo "<b>Jump To Spot:</b>";
	echo "<br>";
	echo build_mystery_jump_to_spot_dropdown_form($spot_id, $current_page_name);
	echo "<br>";
	echo "[<a href=spots.php?><font color=#0000FF size=-1>Find A Spot!</font></a>]"; 
	
	
	echo "<br><br><hr><br>";
	
	//show the jump to dropdown
	echo "<b>SinkSpots <a href=mobile.php>Mobile</a> <i>Beta</i></b>";
	echo "";

	// show the country dropdown
	//echo "<table BORDER=1>";
	
	//echo "<tr>";
	//echo "<h3>Filter By:</h3>";
	
	
	//echo build_flag_list(); 
		?>
		
		
	</div>
 
             
        <h1>Show Only... </h1>
		
		  <?php 
		    	// see if the user just clicked on the link to build this spot list with the current flow by the spot name...
  	if ($_GET['action'] == 'show_cfs_ft')
		$_SESSION['SHOW_CURRENT_FLOW_IN_SPOT_LIST'] = true;

  	// see if the user just clicked on the link to build this spot list with the current flow by the spot name...
	if ($_GET['action'] == 'hide_cfs_ft')
		$_SESSION['SHOW_CURRENT_FLOW_IN_SPOT_LIST'] = false;
	
	if (($_POST['action'] == 'filter') || ($_GET['action'] == 'filter'))
	{
		// get the value from the <select name=country_filter>, and assign it to the session var.. 
		if(isset($_POST['country_filter']))
		{ 
			$_SESSION['STATE_FILTER'] = null;
			$_SESSION['COUNTRY_FILTER'] = $_POST['country_filter'];
		}
		//$_SESSION['REGION_FILTER'] = $_POST['region_filter'];
		if(isset($_POST['state_filter']))
			$_SESSION['STATE_FILTER'] = $_POST['state_filter'];
	}
	
	// set this default to on, so it shows the cfs/ft numbers next to the spot name in the list, when the \
	// page is first loaded...
	if (!isset(	$_SESSION['SHOW_CURRENT_FLOW_IN_SPOT_LIST']))
		$_SESSION['SHOW_CURRENT_FLOW_IN_SPOT_LIST'] = true;
		
 
	
	
		  build_spot_link_list($currently_selected_id, $_SESSION['CURRENT_PAGE_FILENAME'] /*current_page_name*/);  // roll through out all the spots and create the links...
		  
		   ?>
      </div>

<!-- B.2 MAIN CONTENT -->
      <div class="main-content">
      
 
