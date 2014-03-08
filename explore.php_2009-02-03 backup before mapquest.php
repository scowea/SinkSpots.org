<?php session_start(); 
###################################################################################################
## Written By: 	Scott M. Weaver
## Date: 		2008-01-02
## Notes:  
#######################################################################################################
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<?php 
// these are all the shared functions... 
include 'includes/functions.php'; 

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
					
?>

  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <meta name="keywords" content="squirt, squirt boat, mysterymove, mystery move, mystery trance, mystery zombie, mystery, kayak, sinkspots, sink" />
    <title>Sink Spots v3.0</title>

    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="css/print.css" type="text/css" media="print" />

<script type="text/javascript" src="includes/js/prototype.js"></script>

<!-- BEGIN GOOGLE MAP API.... -->	
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAJbtRcONEO0fN-qCTjDZ4sBRCHqwBfhDRZKas_NAmFeIlpDFvuhSWSA3odgyzyx4rE02SEVWroizJ5A"
      type="text/javascript">
</script>

<script type="text/javascript">

    //<![CDATA[

	var map = null;
    var geocoder = null;

    function load(strBubble, strLat, strLong, strZoom_Level, strCoordinates) 
	{
      	if (GBrowserIsCompatible()) 
		{
			// get the reference to the map element in the html....
        	map = new GMap2(document.getElementById("map_canvas")); 
        
			// center the map...
			map.setCenter(new GLatLng(strLat, strLong), parseInt(strZoom_Level));  // lat, long = 37.4419, -122.1419			
			
			// this is the search functionality...
			geocoder = new GClientGeocoder();
		
        	//This code would open a bubble window with text
			map.openInfoWindow(map.getCenter(), document.createTextNode(strBubble)); 
			
			// add a map control ...zoom...
			map.addControl(new GLargeMapControl()); //
				
			// add a map type control  ...
			map.addControl(new GMapTypeControl());
			
			// set the map type to be the satillite. Valid values: [G_NORMAL_MAP,G_SATELLITE_MAP,G_HYBRID_MAP,G_DEFAULT_MAP_TYPES]
			// add the terrain button....
			map.addMapType(G_PHYSICAL_MAP);
			map.setMapType(G_HYBRID_MAP); // but initialy set it to the hybrid view...
			
			// add a marker on the map for every spot in the db....
			addMarkersForAllSpots(strCoordinates);
			
			// shit for the directions
			gdir = new GDirections(map, document.getElementById("directions"));
        	//GEvent.addListener(gdir, "load", onGDirectionsLoad);
        	GEvent.addListener(gdir, "error", handleErrors);
			
			// listener to get the lat/long and display it back to the html...
			GEvent.addListener(map, "moveend", function() 
				{
					var center = map.getCenter();
				   
					var latmany = 1.0 * center.lat();
					var lat3 = latmany.toFixed(4); 
					var lat3 = lat3+'';
				
					var lonmany = 1.0 * center.lng();
					var lon3 = lonmany.toFixed(4); 
					var lon3 = lon3+'';
					
					var zoom = map.getZoom();
					$('zoom_level').value = zoom;
					
					$('latitude').value = lat3;
					$('longitude').value = lon3;
				} // end function ()
			); // end GEvent.addListener
		
      	}// end if (GBrowserIsCompatible())
    } // end function load(strBubble, strLat, strLong)

    function showAddress(address) 
	{
		if (geocoder) 
		{
        	geocoder.getLatLng(address, function(point) 
				{
            		if (!point) {alert(address + " not found");} 
					else 
					{
              			map.setCenter(point, 13);
              			var marker = new GMarker(point);
              			map.addOverlay(marker);
              			marker.openInfoWindowHtml(address);
            		} // end else
          		}// end function
        	); // end getLatLng
      	} // end if (geocoder)	
    } // end function showAddress(address)

	function addMarkersForAllSpots(strCoordinates)
	{
		// split the string apart into an array of all the coordinates...	
		var arrCoordinates = strCoordinates.split(";");
		
		// ROLL THROUGH THE ENTIRE ARRAY OF thisCoordinates..
		for (var i = 0; i < (arrCoordinates.length-1); i++)
		{ 
			// split each element of the coordinate array apart into the long and lat....
			var arrlonglat = arrCoordinates[i].split(",");
			
			// create a point for this long lat...
			var point = new GPoint(arrlonglat[0],arrlonglat[1]);
		
			// get the title of this spot from the array...
			var markerTitle = arrlonglat[2];
			
			// create the marker at this point...
			var marker = new GMarker(point,{clickable: true, title:markerTitle});
			
			// Add the marker to the map in order to display this location on the map.
			map.addOverlay(marker);
		} // end for (var i = 0; i < (arrCoordinates.length-1); i++) 
	} // end function addMarkersForAllSpots(strCoordinates)
	
	function setDirections(fromAddress, toAddress, locale) 
	{
      	gdir.load("from: " + fromAddress + " to: " + toAddress, { "locale": locale });
    } // end function setDirections(fromAddress, toAddress, locale)
	
	function handleErrors()
	{
	   if (gdir.getStatus().code == G_GEO_UNKNOWN_ADDRESS)
	     alert("No corresponding geographic location could be found for one of the specified addresses. This may be due to the fact that the address is relatively new, or it may be incorrect.\nError code: " + gdir.getStatus().code);
	   else if (gdir.getStatus().code == G_GEO_SERVER_ERROR)
	     alert("A geocoding or directions request could not be successfully processed, yet the exact reason for the failure is not known.\n Error code: " + gdir.getStatus().code);
	   
	   else if (gdir.getStatus().code == G_GEO_MISSING_QUERY)
	     alert("The HTTP q parameter was either missing or had no value. For geocoder requests, this means that an empty address was specified as input. For directions requests, this means that no query was specified in the input.\n Error code: " + gdir.getStatus().code);

		//   else if (gdir.getStatus().code == G_UNAVAILABLE_ADDRESS)  <--- Doc bug... this is either not defined, or Doc is wrong
		//     alert("The geocode for the given address or the route for the given directions query cannot be returned due to legal or contractual reasons.\n Error code: " + gdir.getStatus().code);
	     
	   else if (gdir.getStatus().code == G_GEO_BAD_KEY)
	     alert("The given key is either invalid or does not match the domain for which it was given. \n Error code: " + gdir.getStatus().code);

	   else if (gdir.getStatus().code == G_GEO_BAD_REQUEST)
	     alert("A directions request could not be successfully parsed.\n Error code: " + gdir.getStatus().code);
	    
	   else alert("An unknown error occurred.");
	   
	} // end function handleErrors()

    //]]>
    </script>
<!-- END GOOGLE MAP API -->

</head>

 <!-- BEGIN GOOGLE MAP API -->
<?php 
// assign the name of the mystery spot to the text to be displayed in the bubble on the map
$bubble_text = $currently_selected_spot;

// if no lat or long is defined for this spot, then just display generic text in the bubble on the map...
if (($latitude == "43.0789") && ($longitude == "-79.0762"))
	$bubble_text = "Find a mystery spot...";
?>
 
 <body onload='load(<?php echo '"' . $bubble_text . '","' . $latitude . '","' . $longitude . '","' . $zoom_level . '","' . $strCoordinates . '"' ; ?> )' onunload='GUnload()' >

<!-- END GOOGLE MAP API-->
    
<div class="wrapper"> 
  <div class="container"> 
    <div class="icon"> 
      <?php display_icon(); ?>
    </div>
    <?php 
		$user_name = $_SESSION['CURRENT_USER_NAME'];
   		build_title_and_login_stuff($user_name)	  		
	?>
    <?php build_tab_navigation_list($currently_selected_id, "Map"); ?>
    <br class="clear" />
    <div id="body"> 
      <div class="sidebar"> 
        <div class="content"> 
          <?php build_spot_link_list($currently_selected_id, "explore.php" /*current_page_name*/);  // roll through out all the spots and create the links... ?>
        </div>
        <!-- end class="content" -->
      </div>
      <!-- end class="sidebar"-->
      <div class="content"> 
        <table width="100%" border="0" >
          <form action="#" onsubmit="showAddress(this.address.value); return false">
            <tr> 
              <td valign="middle" >Search for an address:</td>
              <td valign="middle"><input type="text" size="60" name="address" value="Anytown, USA" /> 
              </td>
              <td valign="middle"><input type="submit" value="Find It!" class= "submit"/></td>
            </tr>
          </form>
        </table>
        <div id="map_canvas" style="width: 700px; height: 600px"></div>
        <div align="center"> 
          <table width="100%" border="0">
            <?php echo "<form name=latlong action=spot_maintenance.php?spot_id=" . $_GET['spot_id'] . "&action=add_lat_long method=post>"; ?> 
            <tr> 
              <td align="left" valign="middle"><b>Latitude:</b> <input type="text" name="latitude" id="latitude" value="<?php echo $latitude; ?>"/></td>
              <td align="left" valign="middle"><b>Longitude:</b> <input type="text" name="longitude" id="longitude" value="<?php echo $longitude; ?>"/></td>
              <td></td>
              <td></td>
            </tr>
            <tr> 
              <td colspan="4">Add New Spot With This Lat/Long: 
                <input name="submit_button" type=submit value='Add Spot' /> </td>
            </tr>
            <tr> 
              <td colspan="4">Update <b><?php echo $currently_selected_spot ?></b> 
                With This Lat/Long: 
                <input name="submit_button" type=submit value='Update' /></td>
            </tr>
            <?php echo "</form>"; ?> 
          </table>
        </div>
        <?php 
			// if we are centered on niagra falls, then no lat long has been set..let the user know...
			if (($latitude == "43.0789") && ($longitude == "-79.0762"))
			{
				// if the spot name is blank, then no spot is currently selected...so tell the user what to do...
				if ($currently_selected_spot == "")				
					echo '<br><font color=#FF0000>Find the location of a spot on the map, then press the Add button above to create a new spot with those coordinates.</font>';		
				else
					echo '<br><font color=#FF0000>No latitude or longitude has been entered for "<b>' . $currently_selected_spot . '</b>".<br> Find the location of the spot on the map, then press the Update button above to save the coordinates.</font>';							
			}
		 ?>
        <hr>
        <table>
          <form action="#" onsubmit="setDirections(this.from.value, this.to.value, this.locale.value); return false">
            <tr> 
              <th>Where are you departing from: </th>
              <td><input type="text" size="25" id="fromAddress" name="from" value=""/></td>
              <th align="right">&nbsp;&nbsp;To:&nbsp;</th>
              <td align="right"><input type="text" size="25" id="toAddress" name="to" value="<?php echo $latitude . "," . $longitude ?>"/> 
            </tr>
            <tr> 
              <th>Language:&nbsp;</th>
              <td colspan="3"><select id="locale" name="locale">
                  <option value="en" selected>English</option>
                  <option value="fr">French</option>
                  <option value="de">German</option>
                  <option value="ja">Japanese</option>
                  <option value="es">Spanish</option>
                </select> <input name="submit" type="submit" value="Get Directions!" /> 
              </td>
            </tr>
          </form>
        </table>
        <div id="directions" style="width: 275px"></div>
        <hr>
        <div align="center"> 
          <table width="100%" border="0">
            <?php echo "<form name=zoom action=zoom_commit.php?spot_id=" . $_GET['spot_id'] . "&action=update method=post>"; ?> 
            <tr> 
              <td>Update <b><?php echo $currently_selected_spot ?></b> To Be Initially 
                Zoomed To This Level: 
                <input type="text" name="zoom_level" id="zoom_level" size="2" value="<?php echo $zoom_level; ?>"/>
                (0 to 20) </td>
              <td><input name="submit_button" type=submit value='Update' /></td>
            </tr>
            <?php echo "</form>"; ?> 
          </table>
        </div>
        <!-- end div align="center"  -->
        <?PHP 
	  		// DEBUGGING CODE: show what all the coordinates are for every spot in the db:
	  
			// split the page string into lines...with the end line as the delimiter..
			//$spot_info = preg_split('/;/', $strCoordinates); // the forward slashes are the excape characters...  split it by the endline char...

			// initialize the counter...
			$i = 0; 
			
			echo "<hr><strong>Coordinates of every spot in the db:</strong> <br>";
			echo"<table>";
			
			echo"<tr>";
			echo "<th align=left><u>Name</u></th>";
			echo "<th align=left><u>Lat</u></th>";
			echo "<th align=left><u>Long</u></th>";
			echo "</tr>";
			
			$result = get_all_spots();
			
			// roll through the spots...
			while ($record = mysql_fetch_array($result, MYSQL_ASSOC))
			{			
				$spot_id = $record['spot_id'];
				$name = $record['mystery_spot_name']; 
				$lat = $record['latitude'];
				if ($lat == "") $lat = "<font color=#FF0000>NOT SET</font>";
				
				$long = $record['longitude'];
				if ($long == "") $long = "<font color=#FF0000>NOT SET</font>";
				
	  			echo "<tr>";			
				echo "<td><a href=explore.php?spot_id=$spot_id><font color=#0000FF>" . $name . "</font></a></td><td>$lat</td><td>$long</td>";
				echo "</tr>";
			}
				
			echo "</table>";
		?>
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