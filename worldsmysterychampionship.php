<?php 
// these are all the shared functions..
session_start(); 
include 'includes/functions.php';

// get every lat and long from every mystery spot...
$strCoordinates = get_all_coordinates();

// no coordinates is set... center the map on JAPAN 36.16094,136.798095
$longitude = "136.977539";
$latitude = "36.178678";
$zoom_level = 4;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Worlds Mystery Championship - 2010</title>

<!-- BEGIN GOOGLE MAP API.... -->	
<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAJbtRcONEO0fN-qCTjDZ4sBRCHqwBfhDRZKas_NAmFeIlpDFvuhSWSA3odgyzyx4rE02SEVWroizJ5A" type="text/javascript">
</script>
<!-- END GOOGLE MAP API.... -->

<script type="text/javascript" src="includes/js/prototype.js"></script>

<script type="text/javascript">

    //<![CDATA[

	var map = null;
    var geocoder = null;

    function load(strBubble, strLat, strLong, strZoom_Level, strCoordinates) 
	{
	
	 	//########################################################
	    // GOOGLE MAP
      	if (GBrowserIsCompatible()) 
		{
			// get the reference to the map element in the html....
        	map = new GMap2(document.getElementById("map_canvas")); 
        
			// center the map...
			map.setCenter(new GLatLng(strLat, strLong), parseInt(strZoom_Level));  // lat, long = 37.4419, -122.1419			
			
			// this is the search functionality...
			geocoder = new GClientGeocoder();
		
        	//This code would open a bubble window with text
			//map.openInfoWindow(map.getCenter(), document.createTextNode(strBubble)); 
			// get all the info for this spot...
			var arrBubble = strBubble.split(",");
			var mystery_spot_name = arrBubble[0];
			var country = arrBubble[1];
			var state = arrBubble[2]; 
			var city = arrBubble[3]; 
			var river = arrBubble[4]; 
			var spot_id = arrBubble[5];
			var lat = arrBubble[6];
			var lng = arrBubble[7];
			if ((lat == '') || (lng == '')) 
				var html = "Find a mystery spot in Japan...";
			else
				var html = "<b>" + mystery_spot_name + "</b><br>Location: " + city + ", " + state + " " + country + "<br>River: " + river + "<br><a target=_blank href=http://www.sinkspots.org/index.php?spot_id=" + spot_id + " ><br>Latitude: " + lat + "<br>Longitude: " + lng + "<br><font color=#0000FF>View Spot Details</font></a>" ;
				
				
			if ((lat == '') || (lng == '')) 
				var blah = 'blah';
			else
				map.openInfoWindow(map.getCenter(), html); 
			
			// add a map control ...zoom...
			map.addControl(new GLargeMapControl()); //
				
			// add a map type control  ...
			map.addControl(new GMapTypeControl());
			
			// set the map type to be the satillite. Valid values: [G_NORMAL_MAP,G_SATELLITE_MAP,G_HYBRID_MAP,G_DEFAULT_MAP_TYPES]
			// add the terrain button....
			map.addMapType(G_PHYSICAL_MAP);
			map.addMapType(WMS_TOPO_MAP);
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
			
			map.enableScrollWheelZoom();

		
      	}// end if (GBrowserIsCompatible())
    } // end function load(strBubble, strLat, strLong)

	function WMSCreateMap( name, copyright, baseUrl, layer, minResolution, maxResolution, urlArg ){
	
		var tileLayer = new GTileLayer( new GCopyrightCollection( copyright ), minResolution, maxResolution );
		tileLayer.baseUrl = baseUrl;
		tileLayer.layer = layer;
		tileLayer.getTileUrl = WMSGetTileUrl;
		tileLayer.getCopyright = function () { return copyright; };
		var tileLayers = [ tileLayer ];
			return new GMapType( tileLayers, G_SATELLITE_MAP.getProjection(), name, {urlArg: 'o' } );
	}
	
	function WMSGetTileUrl( tile, zoom ){
		var southWestPixel = new GPoint( tile.x * 256, ( tile.y + 1 ) * 256 );
		var northEastPixel = new GPoint( ( tile.x + 1 ) * 256, tile.y * 256 );
		var southWestCoords = G_NORMAL_MAP.getProjection().fromPixelToLatLng( southWestPixel, zoom );
		var northEastCoords = G_NORMAL_MAP.getProjection().fromPixelToLatLng( northEastPixel, zoom );
		var bbox = southWestCoords.lng() + ',' + southWestCoords.lat() + ',' + northEastCoords.lng() + ',' + northEastCoords.lat();
		return this.baseUrl + '?VERSION=1.1.1&REQUEST=GetMap&LAYERS=' + this.layer + '&STYLES=&SRS=EPSG:4326&BBOX=' + bbox + '&WIDTH=256&HEIGHT=256&FORMAT=image/jpeg&BGCOLOR=0xCCCCCC&EXCEPTIONS=INIMAGE';
	}
	
	var WMS_TOPO_MAP = WMSCreateMap( 'Topo', 'Imagery by USGS / Web Service by TerraServer', 'http://www.terraserver-usa.com/ogcmap6.ashx', 'DRG', 3, 17, 't' );



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
	
	//******************************************************************************************************
	
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
			var mystery_spot_name = arrlonglat[2];
			
			// get the title of this spot from the array... this is like the "hint" text
			var country = arrlonglat[3];
			var state = arrlonglat[4]; 
			var city = arrlonglat[5]; 
			var river = arrlonglat[6]; 
			var spot_id = arrlonglat[7]; 
			
			// create the marker at this point...
			var marker = createMarker(point, arrlonglat[0],arrlonglat[1],mystery_spot_name, country, state, city, river, spot_id);
			
			// Add the marker to the map in order to display this location on the map.
			map.addOverlay(marker);
		} // end for (var i = 0; i < (arrCoordinates.length-1); i++) 
	} // end function addMarkersForAllSpots(strCoordinates)
	
	//******************************************************************************************************
	
	function createMarker(point, lng, lat, mystery_spot_name, country, state, city, river, spot_id) {
	
		var html = "<b>" + mystery_spot_name + "</b><br>Location: " + city + ", " + state + " " + country + "<br>River: " + river + "<br>Latitude: " + lat + "<br>Longitude: " + lng + "<br><a target=_blank href=http://www.sinkspots.org/index.php?spot_id=" + spot_id + " ><font color=#0000FF>View Spot Details</font></a>" ;
		
		var marker = new GMarker(point,{clickable: true, title:mystery_spot_name});
		
		GEvent.addListener(marker, 'click', function() {
			marker.openInfoWindowHtml(html);
		});
		
		return marker;
	}
	
	//******************************************************************************************************
	
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
<?PHP 
$bubble_text = $spot_record['mystery_spot_name'] . ',' .
	$spot_record['country'] . ',' .
	$spot_record['state'] . ',' .
	$spot_record['city'] . ',' .
	$spot_record['river'] . ',' .
	$spot_record['spot_id']  . ',' .
	$spot_record['latitude']  . ',' .
	$spot_record['longitude'];
?>    

 <body  alink="#FFCC66" vlink="#FFFFCC" link="#FFCC66" bgcolor="#0B0000" text="#CCCCCC" onload='load(<?php echo '"' . $bubble_text . '","' . $latitude . '","' . $longitude . '","' . $zoom_level . '","' . $strCoordinates . '"' ; ?> )' onunload='GUnload()' >

<div align="center" >


<font size="-2" > 
<table border="0" >
  <tr align="center" valign="middle">
     <td scope="col"></th>
    <td scope="col">[<a target=_blank href=http://www.sinkspots.org/worldsmysterychampionship.php >english</a>]</td>
    <td scope="col">[<a target=_blank href=http://74.125.93.104/translate_c?hl=fr&sl=en&u=http://www.sinkspots.org/worldsmysterychampionship.php >french</a>]</td>
    <td scope="col">[<a target=_blank href=http://74.125.93.104/translate_c?hl=ja&sl=en&u=http://www.sinkspots.org/worldsmysterychampionship.php >japanese</a>]</td>
    <td scope="col">[<a target=_blank href=http://74.125.93.104/translate_c?hl=de&sl=en&u=http://www.sinkspots.org/worldsmysterychampionship.php >german</a>]</td>
    <td scope="col">[<a target=_blank href=http://74.125.93.104/translate_c?hl=es&sl=en&u=http://www.sinkspots.org/worldsmysterychampionship.php >spanish</a>]</td>
    <td scope="col">[<a target=_blank href=http://translate.google.com/translate?js=y&prev=_t&hl=en&ie=UTF-8&layout=1&eotf=1&u=http%3A%2F%2Fwww.sinkspots.org%2Fworldsmysterychampionship.php&sl=en&tl=no >norwegian</a>]</td>
    <td scope="col">[<a target=_blank href=http://translate.google.com/translate?hl=ie&sl=en&tl=ga&u=http%3A%2F%2Fwww.sinkspots.org%2Fworldsmysterychampionship.php >irish</a>]</td>
  </tr>
  <tr align="center" valign="middle">
  <td>Translate:</td>
    <td><a target=_blank href=http://www.sinkspots.org/worldsmysterychampionship.php >
<img src="./flags/gif/gb.gif" alt= "GB" title="Great Britain"  style="border-style: none" />
<img src="./flags/gif/ca.gif" alt= "Canada" title="Canada"  style="border-style: none" />
<img src="./flags/gif/us.gif" alt= "US" title="United States"  style="border-style: none" />
<img src="./flags/gif/nz.gif" alt= "New Zealand" title="New Zealand"  style="border-style: none" /></a></td>

    <td><a target=_blank href=http://74.125.93.104/translate_c?hl=fr&sl=en&u=http://www.sinkspots.org/worldsmysterychampionship.php >
<img src="./flags/gif/fr.gif" alt= "France" title="France" style="border-style: none" /></a></td>
    
    <td><a target=_blank href=http://74.125.93.104/translate_c?hl=ja&sl=en&u=http://www.sinkspots.org/worldsmysterychampionship.php >
<img src="./flags/gif/jp.gif" alt= "Japan" title="Japan" style="border-style: none" /></a></td>
    
    <td><a target=_blank href=http://74.125.93.104/translate_c?hl=de&sl=en&u=http://www.sinkspots.org/worldsmysterychampionship.php >
<img src="./flags/gif/de.gif" alt= "Germany" title="Germany" style="border-style: none" /> 
<img src="./flags/gif/ch.gif" alt= "Switzerland" title="Switzerland" style="border-style: none" /></a></td>
    
    <td><a target=_blank href=http://74.125.93.104/translate_c?hl=es&sl=en&u=http://www.sinkspots.org/worldsmysterychampionship.php >
<img src="./flags/gif/es.gif" alt= "Spain" title="Spain" style="border-style: none" /></a></td>
    
    <td><a target=_blank href=http://translate.google.com/translate?js=y&prev=_t&hl=en&ie=UTF-8&layout=1&eotf=1&u=http%3A%2F%2Fwww.sinkspots.org%2Fworldsmysterychampionship.php&sl=en&tl=no >
<img src="./flags/gif/no.gif" alt= "Norway" title="Norway" style="border-style: none" /></a></td>
   
    <td><a target=_blank href=http://translate.google.com/translate?hl=ie&sl=en&tl=ga&u=http%3A%2F%2Fwww.sinkspots.org%2Fworldsmysterychampionship.php >
<img src="./flags/gif/ie.gif" alt= "Ireland" title="Ireland" style="border-style: none" /></a></td>
  </tr>
</table><hr>




<?php
/*
<a target=_blank href=http://www.sinkspots.org/worldsmysterychampionship.php >
[english]
<img src="./flags/gif/gb.gif" alt= "GB" title="Great Britain" />
<img src="./flags/gif/us.gif" alt= "US" title="United States" />
<img src="./flags/gif/nz.gif" alt= "New Zealand" title="New Zealand" /></a>&nbsp;

<a target=_blank href=http://74.125.93.104/translate_c?hl=fr&sl=en&u=http://www.sinkspots.org/worldsmysterychampionship.php >
[french]
<img src="./flags/gif/fr.gif" alt= "France" title="France" /></a>&nbsp;
                   
<a target=_blank href=http://74.125.93.104/translate_c?hl=ja&sl=en&u=http://www.sinkspots.org/worldsmysterychampionship.php >
[japanese]
<img src="./flags/gif/jp.gif" alt= "Japan" title="Japan" /></a>&nbsp;
                   
<a target=_blank href=http://74.125.93.104/translate_c?hl=de&sl=en&u=http://www.sinkspots.org/worldsmysterychampionship.php >
[german]
<img src="./flags/gif/de.gif" alt= "Germany" title="Germany" /> 
<img src="./flags/gif/ch.gif" alt= "Switzerland" title="Switzerland" /></a>&nbsp;
                   
<a target=_blank href=http://74.125.93.104/translate_c?hl=es&sl=en&u=http://www.sinkspots.org/worldsmysterychampionship.php >
[spanish]
<img src="./flags/gif/es.gif" alt= "Spain" title="Spain" /></a>&nbsp;

<a target=_blank href=http://translate.google.com/translate?js=y&prev=_t&hl=en&ie=UTF-8&layout=1&eotf=1&u=http%3A%2F%2Fwww.sinkspots.org%2Fworldsmysterychampionship.php&sl=en&tl=no >
[norwegian]
<img src="./flags/gif/no.gif" alt= "Norway" title="Norway" /></a>&nbsp;

<a target=_blank href=http://translate.google.com/translate?hl=ie&sl=en&tl=ga&u=http%3A%2F%2Fwww.sinkspots.org%2Fworldsmysterychampionship.php >
[irish]
<img src="./flags/gif/ie.gif" alt= "Ireland" title="Ireland" /></a>&nbsp;
*/
?>

</font></div>
<div align="center">
  <h2><font color="#CCCCCC">Worlds Mystery Championship - 2010</font></h2>
		

	  <img src="./images/underwater_whirlpool.jpg" />
      <br>
      <br>
</div>

	  
<p>In 2010 the World Mystery Championships will be held in Japan!  They will be held in conjunction with the annual "<a href="http://translate.google.com/translate?hl=en&sl=ja&u=http://squirtogether.blog.drecom.jp/" target="_blank">Squirtogether</a>"- but possibly as a separate competition.  A large contingent of 14 American boaters will be attending thanks to the generosity of Taiki Sugawara and Hiro Enomoto who will be driving 2 vans full of 7 'gaijin' each.  The competition is usually the second weekend in September.
</p>
<p>
Anyone is welcome to come and compete of course.  But the transportation will have to be arranged.  Hiro will try to help- but it's hard to find 'babysitters' who can take several days off from work to drive tourists around. Hiro's email is:

 <a href="mailto:init_003@hotmail.com">init_003@hotmail.com</a>.  You might have to consider getting an <a  target="_blank" href="http://www.idlservice.com/app/idlbenefits.php">international driver's license</a> and renting a vehicle at the airport. Depending on your home country, an IDL  is <a target="_blank" href="http://www.japan-guide.com/e/e2024.html">required</a> for a foreigner to rent or drive a car in Japan. But please read the fine details as  Japan does not recognize IDL's from all countries and has specific instructions for certain individuals, depending on what country your home drivers license was issued in.</p>



<table><tr>
<td><img src="http://sinkspots.org/images/art_334_whirlpool.jpg" width="407" height="267"  /></td>
<td>
The venue was originally picked to be the "<a href="http://sinkspots.com/index.php?spot_id=251" target="_blank">JB</a>" spot-  near Hiro's house~ an excellent lefty regular/righty backcut.  But a flood has altered it and it will probably take another flood to make it good enough now. 

There are excellent alternatives however-  the much loved "<a href="http://sinkspots.com/index.php?spot_id=143" target="_blank">Borubas</a>" in southern Honshu which is recovering from a flood 3 years ago-  but still quite fun is one alternative. 

Another is "<a  target="_blank" href="http://www.sinkspots.org/index.php?spot_id=260">Nishimasu</a>"- a seam similar to <a href="http://sinkspots.com/index.php?spot_id=88" target="_blank">Consumption Junction</a> in the eastern US.  It is near Nagano and features very cool clean water and a nearby wasabi ice cream store.  Nearby Nishimasu, just downstream, is the "<a href="http://sinkspots.com/index.php?spot_id=198" target="_blank">Corner Pocket</a>" which was changed a few years ago- but might be in the mood now.  It was really nice- quite detailed with many options and huge downtime potential.

Another possible option is "<a  target="_blank" href="http://www.sinkspots.org/index.php?spot_id=259">The Hideaway</a>" on the Nagara River- not far from Nagoya.  It's a powerful deep lefty regular(reminicent of a scaled down <a href="http://sinkspots.com/index.php?spot_id=103" target="_blank">Halls of Karma</a>-  where the first 'Flying Fish' move was done by Kuma-chan.

The Japanese hunt new spots all the time- so there might be a surprise too!  The US crew will visit many of these arenas in any case.</td>
</tr></table>


<table><tr>
<td>
The American crew will also be visiting the Naruto Straits- which are world-famous tidal whirlpools.  Our Japanese hosts aren't comfortable with us playing there in squirt boats (there's also sharks and huge jellyfish in the area) - but there are commercial rides where you can go amongst the whirlpools in large boats.<br>
<a href="http://en.wikipedia.org/wiki/Naruto_whirlpool" target="_blank">http://en.wikipedia.org/wiki/Naruto_whirlpool</a>

</td>
<td>
<img src="http://upload.wikimedia.org/wikipedia/commons/8/87/Hiroshige_Wild_sea_breaking_on_the_rocks.jpg"  width="200" height="200"  />
</td>
</tr></table>

<table><tr>
<td>
<img src="http://www.japan-guide.com/g6/XYZeXYZe4100_175.jpg"  width="200" height="200" />
</td>
<td>
And it's possible we will visit the sacred town of Nara with it's ancient temples.<br>
 <a href="http://www.japan-guide.com/e/e2165.html" target="_blank">http://www.japan-guide.com/e/e2165.html</a>
</td>
</tr></table> 
 
 
<p>
The US teams will be trying to organize and fly from maybe 4 US cities for a coordinated arrival at Narita Airport-  where Taiki and Hiro will pick us up and become our drivers/caretakers.  We will be camping the whole time.  We can keep in touch and updated on developments at this site.
 </p>
<br><br>

<div align="center">
<table width="70%" border="0" >
          <form action="#" onsubmit="showAddress(this.address.value); return false">
            <tr> 
              <td valign="middle" >Search for an address:</td>
              <td valign="middle"><input type="text" size="60" name="address" value="" /> 
              </td>
              <td valign="middle"><input type="submit" value="Find It!" class= "submit"/></td>
            </tr>
          </form>
        </table>
        <div id="map_canvas" style="width: 800px; height: 600px" ></div>

   
        <hr>
        <table>
          <form action="#" onsubmit="setDirections(this.from.value, this.to.value, this.locale.value); return false">
            <tr> 
              <th>Where are you departing from: </th>
              <td><input type="text" size="25" id="fromAddress" name="from" value=""/></td>
              <th align="right">&nbsp;&nbsp;To:&nbsp;</th>
              <td align="right"><input type="text" size="25" id="toAddress" name="to" value=""/> 
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

</div>

</body>
</html>
