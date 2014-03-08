<?php  
###################################################################################################
## Written By: 	Scott M. Weaver
## Date: 		2008-01-02
## Notes:  
#######################################################################################################
$_SESSION['CURRENT_PAGE_FILENAME'] = 'boats.php';
$_SESSION['NAV_BUTTON_TEXT'] = 'Boats';
include('header.php');
?>
 <!-- Pagetitle -->
        <h1 class="pagetitle">Boat Gallery...</h1>

        <!-- Content unit - One column -->
        <div class="column1-unit"> 
<?php
 


echo "<i>Lets see your glass! ...For Sale, Not For Sale, whatever... </i><br><br>";
include ('boats2_datagrid.php');
?>

      
        
       </div>
    <?php include 'footer.php'; ?>
     