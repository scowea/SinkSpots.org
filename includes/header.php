<?php session_start(); 
###################################################################################################
## Written By: 	Scott M. Weaver
## Date: 		2008-01-02
## Notes: 
##
## header...just the opening html tag, and the head...		
###################################################################################################
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>


// these are all the shared functions... 
include 'includes/functions.php'; 
// get the id from the url, so we can build the link below. if there is no id, this func will return "none"
$currently_selected_id = get_spot_id_from_url($_GET['spot_id']);
if (($_POST['action'] == 'jump_to_spot') || ($_GET['action'] == 'jump_to_spot'))
{
	if (isset($_POST['spot_id']))
	{
		$currently_selected_id = $_POST['spot_id'];
		echo "ping";
	}
	else
	{
		$currently_selected_id = $_GET['spot_id'];
	echo "pong";
	}
$currently_selected_spot = get_mystery_spot_name_from_id($currently_selected_id);
?>

<head>
    <title>Sink<font color="#000000">Spots</font>......</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name="keywords" content="squirt, squirt boat, mysterymove, mystery move, mystery trance, mystery zombie, mystery, kayak, sinkspots, sink" />
    <link rel="stylesheet" href="css/style.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="css/print.css" type="text/css" media="print" />
	<link rel="shortcut icon" href="images/favicon.ico" >
</head>
