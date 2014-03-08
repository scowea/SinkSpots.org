<?php 
	session_start(); 
	include 'includes/functions.php';

	// these are what we pass through the url...
	$spot_id = $_GET['spot_id'];
	$image_id = $_GET['image_id'];

	// get the row for this image_id..
	$row = get_image_record_from_id($image_id);
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>

<head>
    <title>Sink Spots v3.0......</title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name="keywords" content="squirt, squirt boat, mysterymove, mystery move, mystery trance, mystery zombie, mystery, kayak, sinkspots, sink" />
	<link rel="shortcut icon" href="images/favicon.ico" >
</head>

<body bgcolor="#000000">

<table  border="0" align="center" cellpadding="0" cellspacing="0">
<?php	              
	// if the current user is ADMIN, or the current user is the user that created this journal entry, show the edit and delete links... 
	//if (($_SESSION['CURRENT_USER_NAME'] == trim($row['user_name'])) || ($_SESSION['ADMIN_USER'] == "TRUE")) 
echo "<tr><td align=left><font color=#FFFFFF>[</font><a href=images.php?spot_id=" . $spot_id . "&image_id=" . $row['image_id'] . "&action=delete><font size=+2>See All Pictures For This Spot</font></a><font color=#FFFFFF>] ><(((�> [</font><a href=image_maintenance.php?spot_id=" . $spot_id . "&image_id=" . $row['image_id'] . "&action=update>Edit Picture</a><font color=#FFFFFF>] [</font><a href=image_maintenance.php?spot_id=" . $spot_id . "&image_id=" . $row['image_id'] . "&action=delete>Delete Picture</a><font color=#FFFFFF>]</font></td></tr>";
		//echo "<tr><td align=left></td></tr>";
?>
	                    

		<td colspan=2 align=left><font color="#FFFFFF"><b>Comment:</b> <?php echo $row['image_comment']; ?></font></td>
	</tr>
	<tr>
		<td colspan=2 align=left><font color="#FFFFFF"><b>Date Added:</b> <?php echo FormatMyDate($row['date_added'], "m/d/Y g:i A"); ?></font></td>
	</tr>
	<tr>
		<td colspan=2 align=left><font color="#FFFFFF"><b>Added By:</b> <?php echo $row['user_name']; ?></font></td>
	</tr>
	<tr>
	<?php echo '<td colspan=2 align="center" valign="top"><img width="100%" src="../images/' . $spot_id . '/' . $row['image_filename'] . '" border="0" /></td>'; ?></tr>
	<tr>
<?php	              
	// if the current user is ADMIN, or the current user is the user that created this journal entry, show the edit and delete links... 
	//if (($_SESSION['CURRENT_USER_NAME'] == trim($row['user_name'])) || ($_SESSION['ADMIN_USER'] == "TRUE")) 

	//	echo "<tr><td align=left><font color=#FFFFFF>[</font><a href=image_maintenance.php?spot_id=" . $spot_id . "&image_id=" . $row['image_id'] . "&action=update>Edit Picture</a><font color=#FFFFFF>] [</font><a href=image_maintenance.php?spot_id=" . $spot_id . "&image_id=" . $row['image_id'] . "&action=delete>Delete Picture</a><font color=#FFFFFF>]</font></td></tr>";
echo "<tr><td align=left><font color=#FFFFFF>[</font><a href=images.php?spot_id=" . $spot_id . "&image_id=" . $row['image_id'] . "&action=delete><font size=+2>See All Pictures For This Spot</font></a><font color=#FFFFFF>] ><(((�> [</font><a href=image_maintenance.php?spot_id=" . $spot_id . "&image_id=" . $row['image_id'] . "&action=update>Edit Picture</a><font color=#FFFFFF>] [</font><a href=image_maintenance.php?spot_id=" . $spot_id . "&image_id=" . $row['image_id'] . "&action=delete>Delete Picture</a><font color=#FFFFFF>]</font></td></tr>";
?>

</table>

</body>
</html>
