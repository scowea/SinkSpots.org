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
	// get the id from the url, so we can build the links below. if there is no id, this func will return "none"
	$currently_selected_id = get_spot_id_from_url($_GET['spot_id']);
?>

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta name="keywords" content="squirt, squirt boat, mysterymove, mystery move, mystery trance, mystery zombie, mystery, kayak, sinkspots, sink" />
    <title>Sink Spots</title>

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
    <?php build_tab_navigation_list($currently_selected_id, "Weather"); ?>
    <br class="clear" />
    <div id="body"> 
      <table width="100%" border="0" >
        <tr align="left"> 
          <td valign="top" align="left"> <div class="sidebar"> 
              <div class="content"> 
                <?php build_spot_link_list($currently_selected_id, "weather.php" /*current_page_name*/);  // roll through out all the spots and create the links... ?>
              </div>
              <!-- end class="content" -->
            </div>
            <!-- end class="sidebar"-->
          </td>
          <td valign="top" align="left"> <div class="stuff_on_the_right"> <strong>Local 
              Conditions:</strong><br>
              <?php 
			  // get the city for this spot...
			  $city = get_field_from_table('city' /*field name*/, 'mystery_spots' /*table name*/, $currently_selected_id /*unique id*/, "spot_id" /* name of unique id field in table*/);
			  if ($city == "")
			  	echo "Please enter a city for this spot on the Journal tab, to get the current weather.<br>";
			  // replace the blanks with &nbsp;
			  $city = str_replace(" ", "+", $city);  	
								
			  // get the state for this spot..
			  $state = get_field_from_table('state' /*field name*/, 'mystery_spots' /*table name*/, $currently_selected_id /*unique id*/, "spot_id" /* name of unique id field in table*/);
			  if ($state == "")
			  	echo "Please enter a state for this spot on the Journal tab, to get the current weather.<br>";
			  
			  // get the country for this spot..
			  $country = get_field_from_table('region' /*field name*/, 'mystery_spots' /*table name*/, $currently_selected_id /*unique id*/, "spot_id" /* name of unique id field in table*/);
			  $country = strtoupper($country);
			  if ($country == "USA") 
			  	$country = "US"; //  weather url will barf if its USA.... it must be US...
				
				//&nbsp
			  // build the weather url with this city and state...
			  $weather_url = "http://www.weatherforyou.net/fcgi-bin/hw3/hw3.cgi?config=png&forecast=zone&alt=hwizone7day5&place='" . $city . "'&state='" . $state . "'&country='" . $country. "'&hwvbg=white&hwvtc=black&hwvdisplay=&daysonly=2&maxdays=7";
			  ?>
              <img src=<?php echo $weather_url; ?> width="504" border="0" style="height: 188px"/><br>
              <br>
              <strong>Radar:</strong><br>
			  <?php $region_url = find_region_url_for_radar($state); ?>
			   
              <iframe src="http://radar.weather.gov/Conus/<?php echo $region_url; ?>_loop.php" width="800" height="800"></iframe>
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