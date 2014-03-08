<?php  
###################################################################################################
## Written By: 	Scott M. Weaver
## Date: 		2008-01-02
## Notes:  
#######################################################################################################
$_SESSION['CURRENT_PAGE_FILENAME'] = 'spots.php';
$_SESSION['NAV_BUTTON_TEXT'] = 'Spots';
include('header.php');
?>
<!-- Pagetitle -->
        <h1 class="pagetitle">Find A Spot!...</h1>

        <!-- Content unit - One column -->
        <div class="column1-unit"> 
<?php

 
include ('spots_datagrid.php');
?>

      
        
       </div>
      <?php include 'footer.php'; ?>
       