<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html><head>
	<title>Stream Weaver 3.0 - Beta</title>
	
<!-- BEGIN GOOGLE MAP API....	
	<script src="http://maps.google.com/maps?file=api&amp;v=2&amp;key=ABQIAAAAK9CU88G8QdXgJbvmDjjRQhRjQqw_83GVD87nNGnmiTQInSf5IhTWVCLrRmU1NFcrirE81ifgJ40LJw"
      type="text/javascript"></script>
    <script type="text/javascript">

    //<![CDATA[

    function load() {
      if (GBrowserIsCompatible()) {
        var map = new GMap2(document.getElementById("map"));
        map.setCenter(new GLatLng(37.4419, -122.1419), 13);
      }
    }

    //]]>
    </script>
END GOOGLE MAP API -->

</head>

<!-- BEGIN GOOGLE MAP API 
 <body onload="load()" onunload="GUnload()">
END GOOGLE MAP API-->

<body>
<table width="100%" border="0">
  <tr>
    <td><big><big><big> <span style="font-weight: bold;">Stream Weaver</span>... </big></big></big> 
  <em>a tool for aquatic exploration...</em></td>
    <td align=right>[<a href=http://weaver.lunarcharc.com/login.php><font size="-1">Login</font></a>]</td>
  </tr>
</table>
 
<?php include 'includes/functions.php'; // these are all the shared functions... ?>

<?php

// get the spot name.. 	
$currently_selected_spot = get_mystery_spot_name_from_id($_GET['spot_id']);  // we use this below when selection the journal entries...	

// get the id from the url, so we can build the link below. 
//if there is no id, this func will return "none"
$currently_selected_id = get_spot_id_from_url($_GET['spot_id']);

?>

<?php build_spot_link_list($currently_selected_spot);  // roll through out all the spots and create the links... ?>
<hr><br>
<?php build_mystery_spot_info($currently_selected_spot); ?>
<br>


<?php 

echo "[<a href=spot_maintenance.php?spot_id=" . $currently_selected_id . "&action=add><em>Add Spot</em></a>]"; 

if ($currently_selected_id != "none") 
{
	echo "[<a href=spot_maintenance.php?spot_id=" . $currently_selected_id . "&action=update><em>Edit Spot</em></a>]";
	echo " [<a href=spot_maintenance.php?spot_id=" . $currently_selected_id . "&action=delete><em>Delete Spot</em></a>]";
}
?>  

 
<hr><br>
<?php build_journal_entry_list($currently_selected_spot); // build a table of all the journal entries for the currently selected spot ?>
<br>
<?php 
echo "[<a href=journal_entry_maintenance.php?spot_id=" . $currently_selected_id . "&action=add><em>Add Journal Entry</em></a>]";
?>
<hr><br>
<strong>Explore:</strong><br>
<!-- <div id="map" style="width: 500px; height: 400px"></div> -->
<hr><br>

<strong>Current Flow:</strong><br>
<?php 

$gauge_url = get_gauge_url_from_id($currently_selected_id);
if ($gauge_url == "") // not defined...
{
	echo "Enter a Gauge URL for this spot, to get a graph of the real-time flow...<br>";
}
else
	echo "<iframe src=" . $gauge_url . " width=600 height=500 style=font-size: 12pt></iframe><br>"; 
	
?>

<strong>Find A Gauge URL At USGS:</strong>&nbsp; <a href="http://waterdata.usgs.gov/nwis/rt">http://waterdata.usgs.gov/nwis/rt</a>
<hr>
<div align="center"><br>
   
  <strong>Written By: Scott M. Weaver </strong><br>
  <a href=http://weaver.lunarcharc.com/backups><font size="-1">Source Code</font></a></div>
<p>&nbsp;</p>
<p>&nbsp;</p>

</body></html>