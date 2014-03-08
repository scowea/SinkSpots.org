<?php session_start(); 
###################################################################################################
## Written By: 	Scott M. Weaver
## Date: 		2008-01-02
## Notes:  
#######################################################################################################
$_SESSION['CURRENT_PAGE_FILENAME'] = 'gatherings.php';
$_SESSION['NAV_BUTTON_TEXT'] = 'Gatherings';
include('header.php');
?>	  
<!-- Pagetitle -->
<h1 class="pagetitle">Upcoming Gatherings...
<font size="-1">
	<?php echo "[<a href=gatherings_maintenance.php?spot_id=" . $currently_selected_id . "&action=add><em><font color=#0000FF>Add Gathering</font></em></a>]"; ?> 
</font>
</h1>

<!-- Content unit - One column -->
<div class="column1-unit">  
<?php build_gatherings_list($currently_selected_id, 'new'); // build a table of all the gatherings in the db ?>
</div>
<br>

<h1 class="pagetitle">Past Gatherings...
<font size="-1">
	<?php echo "[<a href=gatherings_maintenance.php?spot_id=" . $currently_selected_id . "&action=add><em><font color=#0000FF>Add Gathering</font></em></a>]"; ?> 
</font>
</h1>
   
<div class="column1-unit"> 
<?php build_gatherings_list($currently_selected_id, 'old'); // build a table of all the gatherings in the db ?>
</div>
    
<?php include 'footer.php'; ?>   