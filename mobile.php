<?php session_start(); ?>
<html>
<head><title>SinkSpots Mobile - Beta
</title>
<link rel=Stylesheet href=style_mobile.css></head>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-10031413-1");
pageTracker._trackPageview();
} catch(err) {}</script>
<body>
<h2>SinkSpots Mobile - <I>Beta</I>!</h2>
<p><b>...out and about? lost and confused? <br>
  ... lookin to get down and already left town?</b><br><br>
  <i>All the real time gage data comes from USGS which only covers the USA, and new data is pulled everytime you refresh this page!</i><br>
   <font color="#0000FF">
   <?php 
   if ($_SESSION["CACHE_LAST_UPDATED"] != '')
   		echo "Gages " . $_SESSION["CACHE_LAST_UPDATED"]; ?>
   </font><br>
   <br>
  <?php
	include("includes/functions.php");
	refresh_flow_cache();			
	build_list_of_spots_mobile();	
		
?>
</p>
<img src="images/fishrider.jpg" width="286" height="275">
<br>
&copy; 2009 SinkSpots.org <small>[ <a target=_blank href="audio/mobile_welcome.wav">Use Disclaimer</a> ] </small><br><br>
</body>
</html>