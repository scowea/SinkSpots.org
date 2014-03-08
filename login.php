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
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-10031413-1");
pageTracker._trackPageview();
} catch(err) {}</script>


 <!-- Pagetitle -->
        <h1 class="pagetitle">Welcome back my friend...</h1>

        <!-- Content unit - One column -->
        <div class="column1-unit"> 
 

          <strong> 
          Please login below.</strong><br>
          <br>
          <form name=login_form action=login_commit.php?spot_id=<?php echo $currently_selected_id; ?>&action=login method=post>
            <table border="0">
              <tr> 
                <th align=left>Name:</th>
                <td align=left><input name=user_name id=user_name type=text/></td>
              </tr>
              <tr> 
                <th align=left>Password:</th>
                <td align=left><input name=user_password type=password /></td>
              </tr>
              <tr> 
                <td align=left><input name=submit type=submit value="Login"/></td>
                <td align=left></td>
              </tr>
              <tr> 
                <td align=left><br></td>
                <td align=left></td>
              </tr>
              <tr> 
                <td colspan=2 align=center> [<a href=new_user.php?spot_id=<?php echo $currently_selected_id; ?> ><em><font color=#0000FF>Create 
                  New User</font></em></a>] </td>
              </tr>
              <tr> 
                <td colspan=2 align=center> [<a href=forgot_id_or_password.php?spot_id=<?php echo $currently_selected_id; ?> ><em><font color=#0000FF>Forgot 
                  Id or Password?</font></em></a>] </td>
              </tr>
            </table>
          </form>
        </div>
        
        <?php include 'footer.php'; ?>
      