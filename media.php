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
        <h1 class="pagetitle">Videos...</h1>

        <!-- Content unit - One column -->
        <div class="column1-unit"> 
		
		
              <?php build_video_urls($currently_selected_id); ?>
              <br>
              <br>
              <strong>Add a video for this spot:</strong><br>
              <table>
                <?php 
		  echo "<form class=normalize_it name=add_video action=video_commit.php?spot_id=" . $_GET['spot_id'] . "&action=add_video method=post>"; ?>
                <tr> 
                  <td>Enter the HTML Code to embed your <a href="http://www.youtube.com"><font color="#0000FF">you 
                    tube</font></a> video within a html page: </td>
                  <td></td>
                </tr>
                <tr> 
                  <td><textarea name="video_url" id="video_url" cols=70 rows=6></textarea> 
                  </td>
                  <td></td>
                </tr>
                <tr> 
                  <td colspan="2">Example: <font size="-1"><em>&lt;object width=425 
                    height=355&gt;&lt;param name=movie value=http://www.youtube.com/v/AJ4nX3u0rpA&rel=1&gt;&lt;/param&gt;&lt;param 
                    name=wmode value=transparent&gt;&lt;/param&gt;&lt;embed src=http://www.youtube.com/v/AJ4nX3u0rpA&rel=1 
                    type=application/x-shockwave-flash wmode=transparent width=425 
                    height=355&gt;&lt;/embed&gt;&lt;/object&gt;</em></font><br> 
                    <br></td>
                </tr>
                <tr> 
                  <td>Comment about your video:</td>
                  <td></td>
                </tr>
                <tr> 
                  <td><input background="#FFFFFF" type="text" name="video_comment" id="video_comment" size="100" /></td>
                  <td></td>
                </tr>
                <tr> 
                  <td><input name="submit_button" type=submit value='Add Video' /></td>
                  <td></td>
                </tr>
                <?php echo "</form>"; ?> 
              </table>
              <br>
              <hr>
              <form action=media.php?action=build_user_updates&spot_id=<?php echo $currently_selected_id; ?> method=post>
                <?php 
					// did the user just press the show button?
					if ($_POST['num_media'] != '')$_SESSION['num_media'] = $_POST['num_media'];
					// is this the first time the page has loaded? set the initial value..
					if ($_SESSION['num_media'] == '') $_SESSION['num_media'] = 30;
					echo "<nobr><strong>Last ";
					echo build_number_dropdown('num_media', $_SESSION['num_media']);
					echo " Video Posts:</strong></nobr>";
					?>
                <input name=submit_name type=submit value="Show!"/>
              </form>
              <hr>
              <?php
			  build_last_videos_added($_SESSION['num_media']);
			  echo "<hr>";
			  build_video_link_list();
			  ?>
            
			
			</div>
        <?php include 'footer.php'; ?>
      