<?php

////////////////////////////////////////////////////////////////////////////////
//                                                                            //
//   Copyright (C) 2007  Phorum Development Team                              //
//   http://www.phorum.org                                                    //
//                                                                            //
//   This program is free software. You can redistribute it and/or modify     //
//   it under the terms of either the current Phorum License (viewable at     //
//   phorum.org) or the Phorum License that was distributed with this file    //
//                                                                            //
//   This program is distributed in the hope that it will be useful,          //
//   but WITHOUT ANY WARRANTY, without even the implied warranty of           //
//   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                     //
//                                                                            //
//   You should have received a copy of the Phorum License                    //
//   along with this program.                                                 //
////////////////////////////////////////////////////////////////////////////////

if (!defined("PHORUM_ADMIN")) return;

include_once('./include/api/forums.php');

$folder_id = (int)((isset($_GET["parent_id"])) ? $_GET["parent_id"] : 0);
$parent_parent_id = (int)((isset($_GET["pparent"])) ? $_GET["pparent"] : 0);

// Load the info for the current folder.
$folder = phorum_api_forums_get($folder_id);

// Load the list of forums and folders that are in the current folder.
$forums = phorum_api_forums_by_folder($folder_id);

// Change the display order of the items in the list.
if (isset($_GET['display_up']) || isset($_GET['display_down']))
{
    if (isset($_GET['display_up'])) {
        $forum_id = (int)$_GET['display_up'];
        $movement = 'up';
    } else {
        $forum_id = (int)$_GET['display_down'];
        $movement = 'down';
    }

    phorum_api_forums_change_order($folder_id, $forum_id, $movement, 1);

    // Get a fresh forum list with updated order.
    $forums = phorum_api_forums_by_folder($folder_id);
}

$rows = '';
foreach($forums as $forum_id => $forum)
{
    if ($forum["folder_flag"])
    {
        $type="folder";
        $actions="<a href=\"{$PHORUM["admin_http_path"]}?module=editfolder&forum_id=$forum_id\">Edit</a>&nbsp;&#149;&nbsp;<a href=\"{$PHORUM["admin_http_path"]}?module=deletefolder&forum_id=$forum_id\">Delete</a>";
        $mainurl="{$PHORUM["admin_http_path"]}?module=default&parent_id=$forum_id";
    } else {
        $type="forum";
        $actions="<a href=\"{$PHORUM["admin_http_path"]}?module=editforum&forum_id=$forum_id\">Edit</a>&nbsp;&#149;&nbsp;<a href=\"{$PHORUM["admin_http_path"]}?module=deleteforum&forum_id=$forum_id\">Delete</a>";
        $mainurl=NULL;
    }

    $rows.="<tr><th align=\"left\" valign=\"top\" class=\"PhorumAdminTableRow forum-title\">";
    if ($mainurl) $rows .= "<a href=\"$mainurl\">";
    $rows .= "<span class=\"icon-$type\"></span>";
    $rows .= '<strong>' . ($forum['vroot'] == $forum['forum_id'] ? 'Virtual root: ' : '') . $forum['name'] . '</strong>';
    if ($mainurl) $rows .= "</a>";
    $rows .= "<p class=\"forum-description\">$forum[description]</p></th><td class=\"PhorumAdminTableRow\"><a href=\"{$PHORUM["admin_http_path"]}?module=default&display_up=$forum_id&parent_id=$folder_id\"><img border=\"0\" src=\"{$PHORUM["http_path"]}/images/arrow_up.png\" alt=\"Up\" title=\"Up\"/></a>&nbsp;<a href=\"{$PHORUM["admin_http_path"]}?module=default&display_down=$forum_id&parent_id=$folder_id\"><img border=\"0\" src=\"{$PHORUM["http_path"]}/images/arrow_down.png\" alt=\"Down\" title=\"Down\"/></a></td><td class=\"PhorumAdminTableRow\">$actions</td></tr>\n";
}

if (empty($rows)) {
    $rows="<tr><td colspan=\"3\" class=\"PhorumAdminTableRow\" style=\"padding:15px\">There are no forums or folders in this folder.</td></tr>\n";
}

if ($folder_id > 0)
{
    $elts = array();
    foreach ($folder['forum_path'] as $id => $name) {
        if (empty($elts)) {
            if (empty($folder['vroot'])) {
                $name = 'Root folder';
            } else {
                $elts[] = "<a href=\"{$PHORUM["admin_http_path"]}?module=default&parent_id={$folder['parent_id']}\">Back to parent folder</a>";
                $name = 'Virtual Root "'.$folder['name'].'"';
            }
        }
        if ($folder_id == $id) {
            $elts[] = '<strong>' . $name . '</strong>';
        } else {
            $elts[] = "<a href=\"{$PHORUM["admin_http_path"]}?module=default&parent_id=$id\">$name</a>";
        }
    }

    $path = implode(' / ', $elts);
}
else {
    $path='<strong>Root folder</strong>';
}

?>

<div class="PhorumAdminTitle">
  Forum and folder settings
</div>

<div class="PhorumAdminBreadcrumbs">
  <?php
  if (empty($folder['forum_id'])) {
      print "<span class=\"icon-folder\"></span>";
  } else {
      print "<a href=\"{$PHORUM["admin_http_path"]}?module=default&parent_id={$parent_parent_id}\"><span class=\"icon-folder-up\"></span></a>";
  }
  echo "$path";
  ?>
</div>

<table border="0" cellspacing="2" cellpadding="3" width="100%">
<?php echo $rows; ?>
</table>
