<?php  
###################################################################################################
## Written By: 	Scott M. Weaver
## Date: 		2008-01-02
## Notes:  
#######################################################################################################
$_SESSION['CURRENT_PAGE_FILENAME'] = 'gauge.php';
$_SESSION['NAV_BUTTON_TEXT'] = 'Gauge';
include('header.php');
?>
     <?php 
	   build_detailed_tab_navigation_list($currently_selected_id, $_SESSION['NAV_BUTTON_TEST'], $user_name); 
?>
        <!-- Pagetitle -->
        <h1 class="pagetitle">Gage...</h1>

        <!-- Content unit - One column -->
        <div class="column1-unit"> 


<strong>Current Flow:</strong><br>
        <?php 
			$gauge_url = get_gauge_url_from_id($currently_selected_id);
			if ($gauge_url == "") // not defined...
			{
				echo "Enter a Gage URL for this spot, to get a graph of the real-time flow...<br>";
			}
			else
			{
				echo "<iframe src=" . $gauge_url . " width=750 height=500 style=font-size: 12pt></iframe><br>"; 
				echo "<strong>Gage Url: </strong><a href=$gauge_url target=_blank>$gauge_url</a><br><br>";
			}	
		?>

        <?php 
			$prediction_url = get_prediction_url_from_id($currently_selected_id);
			if ($prediction_url == "") // not defined...
			{
				echo "<strong>Prediction Url:</strong> Enter a Prediction URL for this spot, to get a graph of the real-time flow prediction...<br>";
			}
			else
			{
				//echo "<iframe src=" . $prediction_url . " width=750 height=500 style=font-size: 12pt></iframe><br>"; 
				echo "<strong>Prediction Url: </strong><a href=$prediction_url target=_blank>$prediction_url</a><br><br>";
			}	
		?>
		<br>		
        <strong>Find A Gage URL At <a href="http://waterdata.usgs.gov/nwis/rt" target="_blank">USGS</a> 
        , <a href="http://www.americanwhitewater.org/content/River_view_" target="_blank">American 
        White Water</a> Or <a href="http://www.weather.gov/ahps/" target="_blank">NOAA</a></strong> 
		
		
		
		 
	</div>
<?php include 'footer.php'; ?>