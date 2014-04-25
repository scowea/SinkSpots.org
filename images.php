<?php session_start(); 
###################################################################################################
## Written By: 	Scott M. Weaver
## Date: 		2008-01-02
## Notes: 
##
// These are the fields for a record in the `images` table:
// "image_id" 
// "spot_id"
// "image_filename"
// "image_comment"    		
###################################################################################################
$_SESSION['CURRENT_PAGE_FILENAME'] = 'images.php';
$_SESSION['NAV_BUTTON_TEXT'] = 'Images';
include('header.php');
?>
     <?php 
	   build_detailed_tab_navigation_list($currently_selected_id, $_SESSION['NAV_BUTTON_TEST'], $user_name); 
?>
        <!-- Pagetitle -->
        <h1 class="pagetitle">Images...</h1>

        <!-- Content unit - One column -->
        <div class="column1-unit">
                               
        
              <table width="100%" align=center border="0" cellspacing="1" cellpadding="0">
                <?php
				
			//	ini_set('max_execution_time', 0);
				//datafix_create_thumbs_for_all_images();
			
			// get the image information and display in table 
			//***********************************************************
			// GET all images for this spot_id....  
			// ....we can assume that there is a folder that exists called .../images/"spot_id"
			
			echo "<h1>Images Of $currently_selected_spot:</h1>";
			
			// build the sql statement...
			$sql = "SELECT * FROM `images` WHERE `spot_id` = '" . $currently_selected_id . "' ORDER BY `image_id` DESC";
			
			// execute it.... did it work?
			$result = mysql_query($sql);
			$result_comments = $result; // save a second set of the result set...for the comments...
			if (!$result)
  			{                                                                          
				write_to_log( "users"/*$table*/, $sql/*$sql_statement*/, "build_image_list"/*$action*/, "n/a"/*$old_value*/, "n/a"/*$new_value*/, "ERROR"/*$error_status*/);
				// handle sql error....
				handle_sql_error("build_image_list", $sql);		
  			}
			else
			{
				$num=mysql_numrows($result); // num is the total number of rows (images) for this spot...
			
			}
			

			// if there are no spots yet, tell the user....
			if ($num == 0)
				echo "There are no pictures for this spot...";
			else
			{ 
			
				//echo '<table cellpadding="0" cellspacing="0">';
				echo '<div class="img_stopper">';
				echo '<ul class="gallery clearfix">';
					//echo '<tr>';
					$counter=0;	
				while($row = mysql_fetch_array($result, MYSQL_ASSOC))
				{
					
					if ($counter == 10)
					{ 
					$counter = 0;
						//echo "</tr><tr>";
					}	
					$counter++;			
					$spot_id = $row['spot_id'];
					$image_filename = $row['image_filename'];
					$image_id = $row['image_id'];
					$image_comment = $row['image_comment'];
					$user_name = $row['user_name'];
					$date_added = $row['date_added'];
					
					$title = "[<a href=image_maintenance.php?spot_id=$spot_id&image_id=$image_id&action=update>Edit</a>] [<a href=image_maintenance.php?spot_id=$spot_id&image_id=$image_id&action=delete>Delete</a>] ";
					$comment = "<b>Comment:</b> " . $row['image_comment'];
					$title .= $comment . "<br>";
					$title .= "<b>Date Added:</b> " . FormatMyDate($row['date_added'], "m/d/Y g:i A") . "<br>";
					$title .= "<b>Added By:</b> " . $row['user_name'] . "";
					
					
					// set the variables
					echo ('<li class="img_stopper"><a  href="http://www.sinkspots.org/images/' . $spot_id . '/' . $image_filename . '" rel="prettyPhoto[gallery1]" title="'.$title.'"><img src="../images/' . $spot_id . '/thumbs/' . $image_filename . '" width="60" height="60" ></a></li>');		
					//echo ('<font color=#0000FF size=-2>[<a href=image_maintenance.php?spot_id=' . $spot_id . '&image_id=' . $image_id . '&action=update>Edit</a>] [<a href=image_maintenance.php?spot_id=' . $spot_id . '&image_id=' . $image_id . '&action=delete>Delete</a>]</font><font   size=-2><br>' . $image_comment. '</font>');
					
					
					//echo '<li><a href="images/fullscreen/1.jpg" rel="prettyPhoto[gallery1]" title="You can add caption to pictures. You can add caption to pictures. You can add caption to pictures."><img src="images/thumbnails/t_1.jpg" width="60" height="60" alt="Red round shape" /></a></li>';
									
				}	 
				echo '</ul>';
				echo '</div>';
				//	echo '</tr>';
				//echo '</table>';			
			} // end while 
			
			
		
		?>
		
              </table>
              
  		<script type="text/javascript" charset="utf-8">
		$(document).ready(function(){
			$(".gallery:first a[rel^='prettyPhoto']").prettyPhoto({animationSpeed:'slow',theme:'light_square',slideshow:8000, autoplay_slideshow: true});
			$(".gallery:gt(0) a[rel^='prettyPhoto']").prettyPhoto({animationSpeed:'slow',slideshow:8000, autoplay_slideshow: true});			 
		});
		</script
        
              <br>
              <div align="center"> <?php echo "<a href=image_maintenance.php?spot_id=" . $currently_selected_id . "&action=add><em><font color=#0000FF size=+1>Add New Image For This Spot</font></em></a>"; ?><br><br><br> 
              </div>
              <hr>
              <form action=images.php?action=build_user_updates&spot_id=<?php echo $currently_selected_id; ?> method=post>
                <?php 
					// did the user just press the show button?
					if ($_POST['num_images'] != '')$_SESSION['num_images'] = $_POST['num_images'];
					// is this the first time the page has loaded? set the initial value..
					if ($_SESSION['num_images'] == '') $_SESSION['num_images'] = 30;
					echo "<nobr><strong>Last ";
					echo build_number_dropdown('num_images', $_SESSION['num_images']);
					echo " Image Posts:</strong></nobr>";
					?>
                <input name=submit_name type=submit value="Show!"/>
              </form>
              <hr>
              <?php echo build_last_images_added($_SESSION['num_images']); ?> 
             <br> <hr><br>
              <?php echo build_images_link_list(); ?> </div>
            <!-- end class="stuff_on_the_right -->
          </td>
        </tr>
      </table>
	  
	                  </div>
        <hr class="clear-contentunit" />    
    <?php include 'footer.php'; ?>
