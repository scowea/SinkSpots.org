<?php  
###################################################################################################
## Written By: 	Scott M. Weaver
## Date: 		2008-01-02
## Notes:  
#######################################################################################################
$_SESSION['CURRENT_PAGE_FILENAME'] = 'weather.php';
$_SESSION['NAV_BUTTON_TEXT'] = 'Weather';
include('header.php');
?>

     <?php 
	   build_detailed_tab_navigation_list($currently_selected_id, $_SESSION['NAV_BUTTON_TEST'], $user_name); 
?>
        <!-- Pagetitle -->
        <h1 class="pagetitle">Weather...</h1>

        <!-- Content unit - One column -->
        <div class="column1-unit"> 
 <strong>Local 
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
              <br>
              <br>
              <img src="http://icons-pe.wunderground.com/data/640x480/2xpa_ir_anim.gif" /> 
              <br>
              <br>
              <img src="http://icons-pe.wunderground.com/data/640x480/2xat_ir_anim.gif" /> 
              <br>
              <br>
              <a name="europe-precip">Precipitation Radar - Europe</a> <img align="top" style="border-width: 0px; height: 512px; width: 512px;" usemap="#ImageMapctl00_ContentPlaceHolder1_img" src="http://www.meteox.com/images.aspx?jaar=-3&amp;voor=&amp;soort=loop3uur" title="" id="ctl00_ContentPlaceHolder1_img"/> 
              <img border="0" src="http://www.skystef.be/images/radarleg.gif"/> 
            </div>
             
        <?php include 'footer.php'; ?>
     