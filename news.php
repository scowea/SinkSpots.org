<?php session_start(); 
###################################################################################################
## Written By: 	Scott M. Weaver
## Date: 		2008-01-02
## Notes:  
##	
###################################################################################################
$_SESSION['CURRENT_PAGE_FILENAME'] = 'news.php';
$_SESSION['NAV_BUTTON_TEXT'] = 'News';
include('header.php');
?>
  <!-- Pagetitle -->
        <h1 class="pagetitle">News...</h1>

        <!-- Content unit - One column -->
        <div class="column1-unit"> 
              
              <form action=news.php?action=build_user_updates&spot_id=<?php echo $currently_selected_id; ?> method=post>
                <?php 
					// did the user just press the show button?
					if ($_POST['num_user_updates'] != '')$_SESSION['num_user_updates'] = $_POST['num_user_updates'];
					// is this the first time the page has loaded? set the initial value..
					if ($_SESSION['num_user_updates'] == '') $_SESSION['num_user_updates'] = 30;
					echo "<nobr><strong>Last ";
					echo build_number_dropdown('num_user_updates', $_SESSION['num_user_updates']);
					echo " User Updates:</strong></nobr>";
					?>
                <input name=submit_name type=submit value="Show!"/>
              </form>
              <hr>
              <?php echo build_last_user_updates($_SESSION['num_user_updates']); ?> 
              <hr>
              <br>
              <br>
              <div align="center"> <strong>Links:</strong><br>
                <?php echo build_links_link_list(); ?><br>
                [<a href=./links_maintenance.php?action=add&spot_id=<?php echo $currently_selected_id; ?> ><font color=#FF0000>Add 
                A Link!</font></a>] <br>
                <br>
                <TABLE BORDER=0>
                  <TR> 
                    <TD align="LEFT"></TD >
                    <TD align="LEFT"> </TD>
                    <td align="center"><img src="./flags/gif/gb.gif" alt= "GB" title="Great Britain" /> 
                      <img src="./flags/gif/us.gif" alt= "US" title="United States" /></td>
                    <td align="center"><img src="./flags/gif/fr.gif" alt= "France" title="France" /></td>
                    <td align="center"><img src="./flags/gif/jp.gif" alt= "Japan" title="Japan" /></td>
                    <td align="center"><img src="./flags/gif/de.gif" alt= "Germany" title="Germany" /> 
                    </td>
                    <td align="center"><img src="./flags/gif/es.gif" alt= "Spain" title="Spain" /></td>
                  </TR>
                  <TR> 
                    <TD align="LEFT"><img src="./flags/gif/us.gif" alt= "US" title="United States" /> 
                      <strong>Angst Board:</strong></TD >
                    <TD align="LEFT"> <font color=#0000FF>><(((�></font> </TD>
                    <td align="center"> [<a href=http://www.angstkayak.com/messageboard/index.html  target="_blank"><strong>English</strong></font></a>] 
                    </td>
                    <td align="center"> [<a href=http://74.125.93.104/translate_c?hl=fr&sl=en&u=http://www.angstkayak.com/messageboard/index.html  target="_blank"><font color=#0000FF>French</font></a>] 
                    </td>
                    <td align="center"> [<a href=http://74.125.93.104/translate_c?hl=ja&sl=en&u=http://www.angstkayak.com/messageboard/index.html  target="_blank"><font color=#0000FF>Japanese</font></a>] 
                    </td>
                    <td align="center"> [<a href=http://74.125.93.104/translate_c?hl=de&sl=en&u=http://www.angstkayak.com/messageboard/index.html  target="_blank"><font color=#0000FF>German</font></a>] 
                    </td>
                    <td align="center"> [<a href=http://74.125.93.104/translate_c?hl=es&sl=en&u=http://www.angstkayak.com/messageboard/index.html  target="_blank"><font color=#0000FF>Spanish</font></a>] 
                    </td>
                  </TR>
                  <TR> 
                    <TD align="LEFT"><img src="./flags/gif/gb.gif" alt= "GB" title="Great Britain" /> 
                      <strong>Downtime Board:</strong></TD >
                    <TD align="LEFT"> <font color=#0000FF>><(((�></font> </TD>
                    <td align="left">[<a href=http://www.downtimekayaks.com/forum/viewforum.php?f=1  target="_blank"><strong>English</strong></a>] 
                    </td>
                    <td align="left"> [<a href=http://74.125.93.104/translate_c?hl=fr&sl=en&u=http://www.downtimekayaks.com/forum/viewforum.php?f=1  target="_blank"><font color=#0000FF>French</font></a>] 
                    </td>
                    <td align="left"> [<a href=http://74.125.93.104/translate_c?hl=ja&sl=en&u=http://www.downtimekayaks.com/forum/viewforum.php?f=1  target="_blank"><font color=#0000FF>Japanese</font></a>] 
                    </td>
                    <td align="left"> [<a href=http://74.125.93.104/translate_c?hl=de&sl=en&u=http://www.downtimekayaks.com/forum/viewforum.php?f=1  target="_blank"><font color=#0000FF>German</font></a>] 
                    </td>
                    <td align="left"> [<a href=http://74.125.93.104/translate_c?hl=es&sl=en&u=http://www.downtimekayaks.com/forum/viewforum.php?f=1  target="_blank"><font color=#0000FF>Spanish</font></a>] 
                    </td>
                  </TR>
                  <TR> 
                    <TD align="LEFT"><img src="./flags/gif/us.gif" alt= "US" title="United States" /> 
                      <strong>CBoats Board:</strong></TD>
                    <TD align="LEFT"> <font color=#0000FF><�)))><</font> </TD>
                    <TD align="left"> [<a href=http://www.cboats.net/cforum/viewforum.php?f=2  target="_blank"><strong>English</strong></a>] 
                    </TD>
                    <TD align="left"> [<a href=http://74.125.93.104/translate_c?hl=fr&sl=en&u=http://www.cboats.net/cforum/viewforum.php?f=2  target="_blank"><font color=#0000FF>French</font></a>] 
                    </TD>
                    <TD align="left"> [<a href=http://74.125.93.104/translate_c?hl=ja&sl=en&u=http://www.cboats.net/cforum/viewforum.php?f=2  target="_blank"><font color=#0000FF>Japanese</font></a>] 
                    </TD>
                    <TD align="left"> [<a href=http://74.125.93.104/translate_c?hl=de&sl=en&u=http://www.cboats.net/cforum/viewforum.php?f=2  target="_blank"><font color=#0000FF>German</font></a>] 
                    </TD>
                    <TD align="left"> [<a href=http://74.125.93.104/translate_c?hl=es&sl=en&u=http://www.cboats.net/cforum/viewforum.php?f=2  target="_blank"><font color=#0000FF>Spanish</font></a>] 
                    </TD>
                  </TR>
                  <TR> 
                    <TD align="LEFT"><img src="./flags/gif/us.gif" alt= "US" title="United States" /> 
                      <strong>Playak Board Search:</strong></TD >
                    <TD align="LEFT"> <font color=#0000FF><�)))><</font> </TD>
                    <TD align="left"> [<a href=http://playak.com/paddle-news.php?cat=Forums&lg=en&search=squirt  target="_blank"><strong>English</strong></a>] 
                    </TD>
                    <TD align="left"> [<a href=http://74.125.93.104/translate_c?hl=fr&sl=en&u=http://playak.com/paddle-news.php?cat=Forums&lg=en&search=squirt  target="_blank"><font color=#0000FF>French</font></a>] 
                    </TD>
                    <TD align="left"> [<a href=http://74.125.93.104/translate_c?hl=ja&sl=en&u=http://playak.com/paddle-news.php?cat=Forums&lg=en&search=squirt  target="_blank"><font color=#0000FF>Japanese</font></a>] 
                    </TD>
                    <TD align="left"> [<a href=http://74.125.93.104/translate_c?hl=de&sl=en&u=http://playak.com/paddle-news.php?cat=Forums&lg=en&search=squirt  target="_blank"><font color=#0000FF>German</font></a>] 
                    </TD>
                    <TD align="left"> [<a href=http://74.125.93.104/translate_c?hl=es&sl=en&u=http://playak.com/paddle-news.php?cat=Forums&lg=en&search=squirt  target="_blank"><font color=#0000FF>Spanish</font></a>] 
                    </TD>
                  </TR>
                  <TR> 
                    <TD align="LEFT"><img src="./flags/gif/fr.gif" alt= "France" title="France" /> 
                      <strong>Skunk Board:</strong></TD >
                    <TD align="LEFT"><font color=#0000FF>><(((�></font></TD>
                    <TD align="left"> [<a href=http://74.125.93.104/translate_c?hl=en&sl=fr&u=http://www.villecourt.com/squirt/forum/list.php?2 target="_blank"><font color=#0000FF>English</font></a>] 
                    </TD>
                    <TD align="left"> [<a href=http://www.villecourt.com/squirt/forum/list.php?2  target="_blank"><strong>French</strong></a>] 
                    </TD>
                    <TD align="left"> [<a href=http://74.125.93.104/translate_c?hl=ja&sl=fr&u=http://www.villecourt.com/squirt/forum/list.php?2  target="_blank"><font color=#0000FF>Japanese</font></a>] 
                    </TD>
                    <TD align="left"> [<a href=http://74.125.93.104/translate_c?hl=de&sl=fr&u=http://www.villecourt.com/squirt/forum/list.php?2  target="_blank"><font color=#0000FF>German</font></a>] 
                    </TD>
                    <TD align="left"> [<a href=http://74.125.93.104/translate_c?hl=es&sl=fr&u=http://www.villecourt.com/squirt/forum/list.php?2  target="_blank"><font color=#0000FF>Spanish</font></a>] 
                    </TD>
                  </TR>
                  <TR> 
                    <TD align="LEFT"><img src="./flags/gif/jp.gif" alt= "Japan" title="Japan" /> 
                      <strong>Bomber Shiro Blog:</strong></TD >
                    <TD align="LEFT"><font color=#0000FF>><(((�></font></TD>
                    <TD align="left"> [<a href=http://translate.google.com/translate?hl=en&sl=ja&u=http://godeep.exblog.jp target="_blank"><font color=#0000FF>English</font></a>] 
                    </TD>
                    <TD align="left"> [<a href=http://translate.google.com/translate?hl=fr&sl=ja&u=http://godeep.exblog.jp  target="_blank"><font color=#0000FF>French</font></a>] 
                    </TD>
                    <TD align="left"> [<a href=http://godeep.exblog.jp  target="_blank"><strong>Japanese</strong></a>] 
                    </TD>
                    <TD align="left"> [<a href=http://translate.google.com/translate?hl=de&sl=ja&u=http://godeep.exblog.jp  target="_blank"><font color=#0000FF>German</font></a>] 
                    </TD>
                    <TD align="left"> [<a href=http://translate.google.com/translate?hl=es&sl=ja&u=http://godeep.exblog.jp  target="_blank"><font color=#0000FF>Spanish</font></a>] 
                    </TD>
                  </TR>
                  <TR> 
                    <TD align="LEFT"><img src="./flags/gif/jp.gif" alt= "Japan" title="Japan" /> 
                      <strong>Deepster Blog:</strong></TD >
                    <TD align="LEFT"><font color=#0000FF><�)))><</font></TD>
                    <TD align="left"> [<a href=http://translate.google.com/translate?hl=en&sl=ja&u=http://deepster.xii.jp target="_blank"><font color=#0000FF>English</font></a>] 
                    </TD>
                    <TD align="left"> [<a href=http://translate.google.com/translate?hl=fr&sl=ja&u=http://deepster.xii.jp  target="_blank"><font color=#0000FF>French</font></a>] 
                    </TD>
                    <TD align="left"> [<a href=http://deepster.xii.jp  target="_blank"><strong>Japanese</strong></a>] 
                    </TD>
                    <TD align="left"> [<a href=http://translate.google.com/translate?hl=de&sl=ja&u=http://deepster.xii.jp  target="_blank"><font color=#0000FF>German</font></a>] 
                    </TD>
                    <TD align="left"> [<a href=http://translate.google.com/translate?hl=es&sl=ja&u=http://deepster.xii.jp  target="_blank"><font color=#0000FF>Spanish</font></a>] 
                    </TD>
                  </TR>
                  <TR> 
                    <TD align="LEFT"><img src="./flags/gif/jp.gif" alt= "Japan" title="Japan" /> 
                      <strong>Squirtist Blog:</strong></TD >
                    <TD align="LEFT"><font color=#0000FF><�)))><</font></TD>
                    <TD align="left"> [<a href=http://translate.google.com/translate?hl=en&sl=ja&u=http://sakurazaka.cocolog-nifty.com/ target="_blank"><font color=#0000FF>English</font></a>] 
                    </TD>
                    <TD align="left"> [<a href=http://translate.google.com/translate?hl=fr&sl=ja&u=http://sakurazaka.cocolog-nifty.com/  target="_blank"><font color=#0000FF>French</font></a>] 
                    </TD>
                    <TD align="left"> [<a href=http://sakurazaka.cocolog-nifty.com/  target="_blank"><strong>Japanese</strong></a>] 
                    </TD>
                    <TD align="left"> [<a href=http://translate.google.com/translate?hl=de&sl=ja&u=http://sakurazaka.cocolog-nifty.com/  target="_blank"><font color=#0000FF>German</font></a>] 
                    </TD>
                    <TD align="left"> [<a href=http://translate.google.com/translate?hl=es&sl=ja&u=http://sakurazaka.cocolog-nifty.com/  target="_blank"><font color=#0000FF>Spanish</font></a>] 
                    </TD>
                  </TR>
                  <TR> 
                    <TD align="LEFT"><img src="./flags/gif/jp.gif" alt= "Japan" title="Japan" /> 
                      <strong>Fun Forever:</strong></TD >
                    <TD align="LEFT"><font color=#0000FF><�)))><</font></TD>
                    <TD align="left"> [<a href=http://74.125.93.104/translate_c?hl=en&sl=ja&u=http://www.fun-forever.com target="_blank"><font color=#0000FF>English</font></a>] 
                    </TD>
                    <TD align="left"> [<a href=http://74.125.93.104/translate_c?hl=fr&sl=ja&u=http://www.fun-forever.com  target="_blank"><font color=#0000FF>French</font></a>] 
                    </TD>
                    <TD align="left"> [<a href=http://www.fun-forever.com  target="_blank"><strong>Japanese</strong></a>] 
                    </TD>
                    <TD align="left"> [<a href=http://74.125.93.104/translate_c?hl=de&sl=ja&u=http://www.fun-forever.com  target="_blank"><font color=#0000FF>German</font></a>] 
                    </TD>
                    <TD align="left"> [<a href=http://74.125.93.104/translate_c?hl=es&sl=ja&u=http://www.fun-forever.com  target="_blank"><font color=#0000FF>Spanish</font></a>] 
                    </TD>
                  </TR>
                  <TR> 
                    <TD align="LEFT"><img src="./flags/gif/jp.gif" alt= "Japan" title="Japan" /> 
                      <strong>Squirt Together:</strong></TD >
                    <TD align="LEFT"><font color=#0000FF>><(((�></font></TD>
                    <TD align="left"> [<a href=http://74.125.93.104/translate_c?hl=en&sl=ja&u=http://squirtogether.blog.drecom.jp/ target="_blank"><font color=#0000FF>English</font></a>] 
                    </TD>
                    <TD align="left"> [<a href=http://74.125.93.104/translate_c?hl=fr&sl=ja&u=http://squirtogether.blog.drecom.jp/  target="_blank"><font color=#0000FF>French</font></a>] 
                    </TD>
                    <TD align="left"> [<a href=http://squirtogether.blog.drecom.jp/  target="_blank"><strong>Japanese</strong></a>] 
                    </TD>
                    <TD align="left"> [<a href=http://74.125.93.104/translate_c?hl=de&sl=ja&u=http://squirtogether.blog.drecom.jp/  target="_blank"><font color=#0000FF>German</font></a>] 
                    </TD>
                    <TD align="left"> [<a href=http://74.125.93.104/translate_c?hl=es&sl=ja&u=http://squirtogether.blog.drecom.jp/  target="_blank"><font color=#0000FF>Spanish</font></a>] 
                    </TD>
                  </TR>
                </TABLE>
                <br>
                <br>
                <br>
              </div>
 
              <div align="center"> <br>
                <table>
                  <tr> 
                    <td colspan="2" align=center><strong><u>Comments/Questions 
                      for Admin?</u>:</strong></td>
                  </tr>
                  <tr> 
                    <td>Email: </td>
                    <td><a href="mailto:sinkspots@gmail.com"><font color=#0000FF>sinkspots@gmail.com</font></a></td>
                  </tr>             
                  <tr> 
                    <td>Facebook: </td>
                    <td align=left><a href=http://www.facebook.com/people/Sink-Spots/100000239166539 target=_blank><img src="images/FaceBook-32x32.png" /></a></td>
                  </tr>
                  <tr> 
                    <td>Twitter: </td>
                    <td align=left><a href=http://www.twitter.com/SinkSpots target=_blank><img src="images/tweet.gif" /></a></td>
                  </tr>
                </table>
              </div>
              <br>
              <div align="center"> If you have any ideas, <a href="mailto:sinkspots@yahoo.com">email</a> 
                me and ill put it on the list... <br>
               </div>
              </div>
  
        <?php include 'footer.php'; ?>
      