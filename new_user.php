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
// "user_name"		
###################################################################################################
$_SESSION['CURRENT_PAGE_FILENAME'] = 'whats_in.php';
$_SESSION['NAV_BUTTON_TEXT'] = 'Whats In';
include('header.php');
?>

<!-- Pagetitle -->
        <h1 class="pagetitle">Create New User...</h1>

        <!-- Content unit - One column -->
        <div class="column1-unit"> 
		
              <div align="center"> 
                <table  border="0">
                  <?php
// open the form...
echo "<form action=login_commit.php?spot_id=" . $currently_selected_id . "&action=new method=post>";
?>
                  <tr> 
                    <td><b>Name:</b></td>
                    <td> <input name=user_name type=text/> </td>
                  </tr>
                  <tr> 
                    <td><b>Password:</b></td>
                    <td> <input name=user_password type=password /></td>
                  </tr>
                  <tr> 
                    <td><b><em><font color="#FF0000" size=-1>Confirm Password:</font></em></b></td>
                    <td> <input name=user_confirm_password type=password /></td>
                  </tr>
                  <tr> 
                    <td><b>Email:</b></td>
                    <td> <input name=email size=60 type=text /> <br> <em><font size="-1">(if 
                      you forget your password, you can have it emailed to this 
                      address)</font></em></td>
                  </tr>
                  <tr> 
                    <td align=center>&nbsp; </td>
                    <td align=center><input name=submit type=submit value='Create New User' /></td>
                  </tr></form>
                </table>
                <?php 
//echo "<p align=center>[<a href=index.php?spot_id=" . $currently_selected_id . "><em>Cancel: Go Back</em></a>]</p>" ;
?>
              </div>
             </div>
 
        <?php include 'footer.php'; ?>
      