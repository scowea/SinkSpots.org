<?php session_start(); 
error_reporting(0);
//error_reporting(1);
include('includes\mobile_redirect.inc.php');
###################################################################################################
## Written By: 	Scott M. Weaver
## Date: 		2008-01-02
## Notes:  
#######################################################################################################
$_SESSION['CURRENT_PAGE_FILENAME'] = 'index.php';
$_SESSION['NAV_BUTTON_TEXT'] = 'Journal';
include('header.php');
?>
      <?php 
	   build_detailed_tab_navigation_list($currently_selected_id, $_SESSION['NAV_BUTTON_TEST'], $user_name); 
?>
         <!-- Pagetitle -->
        <h1 class="pagetitle">Spot Info...</h1>

        <!-- Content unit - One column -->
        <div class="column1-unit">
               
       <?php build_gatherings_list_for_this_spot($currently_selected_id); ?>        
                                    
         <p>
		 
<?php build_mystery_spot_info($currently_selected_id); ?>
<hr>
<br>

<?php 

 

 
if (file_exists('journal_entry_datagrid.php') == true)
	require('journal_entry_datagrid.php');
else
	echo '';


echo '<h1>Journal...</h1>';
build_journal_entry_list($currently_selected_id); // build a table of all the journal entries for the currently selected spot ?>
<br>

<?php echo "[<a href=journal_entry_maintenance.php?spot_id=" . $currently_selected_id . "&action=add><em><font color=#0000FF>Add Journal Entry</font></em></a>]"; ?> 
<hr>
<?php 


build_journal_entry_link_list(); ?>

			</p>
			</div>
			 <hr class="clear-contentunit" />       
		  <?php include 'footer.php'; ?>