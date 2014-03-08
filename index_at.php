<?php session_start(); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php include 'includes/functions_at.php'; // these are all the shared functions... ?>
<?php 
// get the spot name.. 	
$currently_selected_spot = get_mystery_spot_name_from_id($_GET['spot_id']);  // we use this below when selection the journal entries...	

// get the id from the url, so we can build the link below. if there is no id, this func will return "none"
$currently_selected_id = get_spot_id_from_url($_GET['spot_id']);
?>

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Stream Weaver 3.0 - Beta</title>
    
	<script type="text/javascript" src="includes/js/prototype.js"></script>
	<script type="text/javascript" src="includes/js/effects.js"></script>
	<script type="text/javascript" src="includes/js/accordion.js"></script>	

    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="css/print.css" type="text/css" media="print" />
    <link rel="stylesheet" href="css/styles_nav.css" type="text/css" media="screen" />
</head>
<body>
	dds
<div class="wrapper"> 
  <div class="container"> 
    <div class="icon"> <img src="images/wave.gif" width="140" height="98" /> </div>
    <div id="title">
      <?php 
		  		$user_name = $_SESSION['CURRENT_USER_NAME'];
				if ($user_name == "")
					echo "[<a href=login.php>login</a>]";
				else
					echo "Welcome Back <b>" . $user_name . "!</b>"; 
		  ?>
      <br>
      <br>
      <h1> Stream Weaver </h1>
      <em>...a tool for aquatic exploration...</em></div>
    <!-- end id="title"-->
    <div id="navigation"> 
      <ul>
        <li> <?php echo "<a href=index.php?spot_id=" . $currently_selected_id . " class=selected>Journal</a>"; ?></li>
        <li> <?php echo "<a href=gauge.php?spot_id=" . $currently_selected_id . ">Gauge</a>"; ?> 
        </li>
        <li> <?php echo "<a href=weather.php?spot_id=" . $currently_selected_id . ">Weather</a>"; ?> 
        </li>
        <li> <?php echo "<a href=explore.php?spot_id=" . $currently_selected_id . ">Explore</a>"; ?> 
        </li>
        <li> <?php echo "<a href=news.php?spot_id=" . $currently_selected_id . ">News</a>"; ?> 
        </li>
      </ul>
    </div>
    <!-- end id="navigation"  -->
    <br class="clear" />
    <div id="body"> 
      <div class="sidebar"> 
        <div class="content"> 
          <?php build_spot_link_list($currently_selected_spot, "index.php" /*current_page_name*/);  // roll through out all the spots and create the links... ?>
        </div>
        <!-- end class="content" -->
      </div>
      <!-- end class="sidebar"-->
      <div class="content"> 
        <?php build_mystery_spot_info($currently_selected_spot); ?>
        <br>
        <?php 
					echo "[<a href=spot_maintenance.php?spot_id=" . $currently_selected_id . "&action=add><em>Add Spot</em></a>]"; 

					if ($currently_selected_id != "none") 
					{
						echo " [<a href=spot_maintenance.php?spot_id=" . $currently_selected_id . "&action=update><em>Edit Spot</em></a>]";
						echo " [<a href=spot_maintenance.php?spot_id=" . $currently_selected_id . "&action=delete><em>Delete Spot</em></a>]";
					}
					?>
        <hr>
        <br>
        <?php build_journal_entry_list($currently_selected_spot); // build a table of all the journal entries for the currently selected spot ?>
        <br>
        <?php echo "[<a href=journal_entry_maintenance.php?spot_id=" . $currently_selected_id . "&action=add><em>Add Journal Entry</em></a>]"; ?> 
      </div>
      <!-- end class="content"-->
      <br class="clear" />
    </div>
    <!-- end id="body"-->
    <br class="clear" />
    ASD </div>
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
<img src="images/tab_over.gif" style="display: none; visibility:hidden; width:0; height:0; position:absolute; top: -100px; left: -200px;" alt="I am soooo fake pre-loading this image so the navigation doesn't skip while loading the over state.  I know I could use the sliding doors technique to avoid this fate, but I am too lazy." />asdasdaS 
<script type="text/javascript">
	new accordion('accordion');

</script>

</body>
</html>