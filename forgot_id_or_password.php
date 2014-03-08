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
        <h1 class="pagetitle">Forgot Your Password?...</h1>

        <!-- Content unit - One column -->
        <div class="column1-unit"> 
              <div align=center> <strong>Remember your User Id?</strong> 
                <table border="0">
                  <form action=login_commit.php?action=forgot_password method=post>
                    <tr> 
                      <td><b>User Id:</b></td>
                      <td><input name=user_name type=text size=30 /></td>
                    </tr>
                    <tr> 
                      <td colspan=2 align=center><input name=submit_name type=submit value="Find Password"/></td>
                    </tr>
                  </form>
                </table>
                <br>
                <br>
                <strong>Remember the Email you supplied when your User Id was 
                created?</strong> 
                <table border="0">
                  <form action=login_commit.php?action=forgot_id method=post>
                    <tr> 
                      <td><b>Email:</b></td>
                      <td> <input name=email type=text/ size=50> </td>
                    </tr>
                    <tr> 
                      <td colspan=2 align=center><input name=submit_email type=submit value="Find User Id & Password"/></td>
                    </tr>
                  </form>
                </table>
                <br>
                <br>
              </div>
            </div>
            
        <?php include 'footer.php'; ?>
      