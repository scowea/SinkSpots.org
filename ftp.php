<?php

/* Configuration Options */
$phpftp_host="localhost";
$phpftp_version="1.1";

/* Comment this out if you don't want the version footer */
$show_version_footer=1;

/* How large a file will you accept?  You may also need to edit your
php.ini file and change upload_max_filesize appropriately */
$max_file_size="1000000";

/* The temporary directory $phpftp_tmpdir must exist and be writable
   by your web server.
   Hint:  mkdir /var/tmp/xfers && chmod 1777 /var/tmp/xfers */
$phpftp_tmpdir="";

/* $use_mime_lookup
   Turning this on creates a dependency upon the
   http://www.inebria.com/mime_lookup/ MIME type lookup library.
   Setting this variable to "1" enables it.  "0" disables.
   If you turn it on, put the mime_lookup.php file in the same directory
   as ftp.php and uncomment the 'include("html/html/mime_lookup.php");' statement. */
$use_mime_lookup="0";

/* include("html/html/mime_lookup.php"); */

/* We enclose the top and bottom in functions because sometimes
   we might not send them (ie, in a file-download situation) */
   
// END OF DEFINITIONS **********************************************************************

function phpftp_top() 
{
    global $phpftp_version;
	?>
	<!-- function phpftp_top -->
	<html>
	<head>
	<title>PHP FTP Client <?php echo $phpftp_version; ?></title>
	</head>
	<body bgcolor="#ffffff">
	<?php
}

// END OF FUNCTION TOP ********************************************************************************

function phpftp_bottom() 
{
    global $phpftp_version;
    global $show_version_footer;
	if (isset($show_version_footer)) 
	{
		?>
		<p>version <?php echo $phpftp_version; ?></p>
		<?php
	}

	?>
	</body>
	</html>
	<?php
}

// END OF FUNCTION BOTTOM *****************************************************************************

/* This is the form used for initially collecting username/passwd */

function phpftp_login() 
{
    phpftp_top();
	?>
	<!-- function phpftp_login -->
	<p>
	<form action="ftp.php" method=post>
	<p><table border=0>
	<tr><td>
	Login:
	</td><td>
	<input name="phpftp_user" type="text">
	</td></tr>
	<tr><td>
	Password:
	</td><td>
	<input name="phpftp_passwd" type="password">
	</td></tr>
	</table>
	</p><p>
	<input type="hidden" name="function" value="dir">
	<input type="submit" value="connect">
	</p>
	</form>
	<p>
	
	<!-- this is the main login form --> 
	
	<?php
		phpftp_bottom();
}

// END OF LOGIN FORM *******************************************************************************************

/* This function does not return TRUE/FALSE - it returns the value of
   $ftp, the current FTP stream. */

function phpftp_connect($phpftp_user,$phpftp_passwd) 
{
    global $phpftp_host;
    $ftp = ftp_connect($phpftp_host);
    if ($ftp) {
        if (ftp_login($ftp,$phpftp_user,urldecode($phpftp_passwd))) {
            return $ftp;
        }
    }
}

// END FUNCTION phpftp_connect ************************************************************************************

function phpftp_list($phpftp_user,$phpftp_passwd,$phpftp_dir) 
{
    global $phpftp_host;
    phpftp_top();
    $ftp = @phpftp_connect($phpftp_user,$phpftp_passwd);
    if (!$ftp) 
	{
		?>
		<strong>FTP login failed!</strong>
		<a href="ftp.php">Start over?</a>
		<?php
        phpftp_bottom();
    } else 
	{
        if (!$phpftp_dir) 
		{
            $phpftp_dir=ftp_pwd($ftp);
        }
		
        if (!@ftp_chdir($ftp,$phpftp_dir)) 
		{
			?>
			<font color="#ff0000"><strong>Can't enter that directory!</strong></font><p><p>
			<?php
            $phpftp_dir=ftp_pwd($ftp);
        }
        echo "<strong>Current host:</strong> " . $phpftp_host . "<br>\n";
        echo "<strong>Current directory:</strong> " . $phpftp_dir . "<br>\n";
        if ($phpftp_dir == "/") 
		{
            $phpftp_dir="";
        }

        if ($contents = ftp_rawlist($ftp,"")) 
		{
            $d_i=0;
            $f_i=0;
            $l_i=0;
            $i=0;
            while ($contents[$i]) 
			{
                $item[] = split("[ ]+",$contents[$i],9);
                $item_type=substr($item[$i][0],0,1);
                if ($item_type == "d") {
                    /* it's a directory */
                    $nlist_dirs[$d_i]=$item[$i][8];
                    $d_i++;
                } elseif ($item_type == "l") {
                    /* it's a symlink */
                    $nlist_links[$l_i]=$item[$i][8];
                    $l_i++;
                } elseif ($item_type == "-") {
                    /* it's a file */
                    $nlist_files[$f_i]=$item[$i][8];
                    $nlist_filesize[$f_i]=$item[$i][4];
                    $f_i++;
                } elseif ($item_type == "+") {
                    /* it's something on an anonftp server */
                    $eplf=split(",",implode(" ",$item[$i]),5);
                    if ($eplf[2] == "r") {
                        /* it's a file */
                        $nlist_files[$f_i]=trim($eplf[4]);
                        $nlist_filesize[$f_i]=substr($eplf[3],1);
                        $f_i++;
                    } elseif ($eplf[2] == "/") {
                        /* it's a directory */
                        $nlist_dirs[$d_i]=trim($eplf[3]);
                        $d_i++;
                    }
                } /* ignore all others */
                $i++;
            } // end while
			?>
			<table border=0 cellspacing=10>
			<?php
            if (count($nlist_dirs)>0) 
			{
				?>
				<tr><td align=left valign=top>
				<strong>Directories</strong><br>
				<form action="ftp.php" method=post>
				<input type="hidden" name="function" value="cd">
				<input type="hidden" name="phpftp_user" value="<?php echo $phpftp_user; ?>">
				<input type="hidden" name="phpftp_passwd" value="<?php echo $phpftp_passwd; ?>">
				<input type="hidden" name="phpftp_dir" value="<?php echo $phpftp_dir; ?>">
				<select name="select_directory" size="10" width="100">
				<?php
								for ($i=0; $i < count($nlist_dirs); $i++) 
								{
									echo "<option value=\"" . $nlist_dirs[$i] . "\">" . $nlist_dirs[$i] . "</option>\n";
								}
				?>
				</select><br>
				<input type="submit" value="Enter Directory">
				</form>
				<form action="ftp.php" method=post>
				<?php
						$cdup=dirname($phpftp_dir);
						if ($cdup == "") {
							$cdup="/";
						}
				?>
				<input type="hidden" name="function" value="dir">
				<input type="hidden" name="phpftp_user" value="<?php echo $phpftp_user; ?>">
				<input type="hidden" name="phpftp_passwd" value="<?php echo $phpftp_passwd; ?>">
				<input type="hidden" name="phpftp_dir" value="<?php echo $cdup; ?>">
				<input type="submit" value="Go up one directory">
				</form>
				</td>
				<?php
            }

            if (count($nlist_files)>0) 
			{
				?>
				<td align=left valign=top>
				<strong>Files</strong><br>
				<form action="ftp.php" method=post>
				<input type="hidden" name="function" value="get">
				<input type="hidden" name="phpftp_user" value="<?php echo $phpftp_user; ?>">
				<input type="hidden" name="phpftp_passwd" value="<?php echo $phpftp_passwd; ?>">
				<input type="hidden" name="phpftp_dir" value="<?php echo $phpftp_dir; ?>">
				<select name="select_file" size="10">
				<?php
				for ($i=0; $i < count($nlist_files); $i++) 
				{
				echo "<option value=\"" . $nlist_files[$i] . "\">" . $nlist_files[$i] ."  ($nlist_filesize[$i] bytes)". "</option>\n";
                } 
				?>
				</select><br>
				<input type="submit" value="Download File">
				</form>
				</td></tr>
				<?php
            }
        } // end if contents = rawlist
		else 
		{
			?>
			<font color="#ff0000"><strong>Directory empty or not readable</strong></font>
			<?php
        }
		?>
		</table>
		<table border=0 cellspacing=10>
		<tr>
			<td align="left" valign="top">
			<form enctype="multipart/form-data" action="ftp.php" method="POST">
			<input type="hidden" name="max_file_size" value="<?php echo $max_file_size ?>">
			<input type="hidden" name="phpftp_user" value="<?php echo $phpftp_user; ?>">
			<input type="hidden" name="phpftp_passwd" value="<?php echo $phpftp_passwd; ?>">
			<input type="hidden" name="phpftp_dir" value="<?php echo $phpftp_dir; ?>">
			<input type="file"   name="phpftp_file"><BR>
			<input type="hidden" name="function" value="put">
			<input type="submit" value="Upload this:">
			</form>	
			</td>
		</tr>
		</table>	
		<table border=0 cellspacing=10>
		<tr>
			<td align="left" valign="top">
			<form action="ftp.php" method=post>
			<input type="hidden" name="function" value="mkdir">
			<input type="hidden" name="phpftp_user" value="<?php echo $phpftp_user; ?>">
			<input type="hidden" name="phpftp_passwd" value="<?php echo $phpftp_passwd; ?>">
			<input type="hidden" name="phpftp_dir" value="<?php echo $phpftp_dir; ?>">
			<input type="submit" value="Make subdirectory:">
			<input name="new_dir" type="text">
			</form>
			</td>
		</tr>
		</table>
		<?php
				ftp_quit($ftp);
				phpftp_bottom();
    } // end if ftp
}

// END FUNCTION PHPFTP_LIST - LISTS ITEMS IN REMOTE DIRECTORY ***********************************************************

function phpftp_cd($phpftp_user,$phpftp_passwd,$phpftp_dir,$select_directory)
{

    $new_directory=$phpftp_dir . "/" . $select_directory;
    phpftp_list($phpftp_user,$phpftp_passwd,$new_directory);
}

// END FUNCTION PHPFTP_CD CHANGE DIRECTORY ***********************************************

function phpftp_mkdir($phpftp_user,$phpftp_passwd,$phpftp_dir,$new_dir) 
{
    $ftp = @phpftp_connect($phpftp_user,$phpftp_passwd);
    if ($phpftp_dir == "") 
	{
        $phpftp_dir="/";
    }
    if (!$ftp) 
	{
        @ftp_quit($ftp);
        phpftp_top();
		?>
		<font color="#ff0000"><strong>FTP login failed!</strong></font><p><p>
		<a href="ftp.php">Start over?</a>
		<?php
        phpftp_bottom();
    } else 
	{
        $dir_path = $phpftp_dir . "/" . $new_dir;
        @ftp_mkdir($ftp,$dir_path);
        @ftp_quit($ftp);
        phpftp_list($phpftp_user,$phpftp_passwd,$phpftp_dir);		
    }
};

// END FUNCTION PHPFTP_MKDIR - MAKES A NEW DIRECTORY ON REMOTE SERVER *****************************************
    

function phpftp_get($phpftp_user,$phpftp_passwd,$phpftp_dir,$select_file) 
{
    $ftp = @phpftp_connect($phpftp_user,$phpftp_passwd);
    if ($phpftp_dir == "") {
        $phpftp_dir="/";
    }
    if ((!$ftp) || (!@ftp_chdir($ftp,$phpftp_dir))) 
	{
        @ftp_quit($ftp);
        phpftp_top();
		?>
		<font color="#ff0000"><strong>FTP login failed!</strong></font><p><p>
		<a href="ftp.php">Start over?</a>
		<?php
        phpftp_bottom();
    } else 
	{
        srand((double)microtime()*1000000);
        $randval = rand();
        $tmpfile="c:";
        if (!ftp_get($ftp,$tmpfile,$select_file,FTP_BINARY)) {
            ftp_quit($ftp);
            phpftp_top();
			
			echo $tmpfile . $select_file;
			?>
			<font color="#ff0000"><strong>FTP get failed!</strong></font><p><p>
			<a href="ftp.php">Start over?</a>
			<?php
            phpftp_bottom();
        } else 
		{
            ftp_quit($ftp);
            global $use_mime_lookup;
            if ($use_mime_lookup == "1") {
                $file_mime_type=mime_lookup(substr(strrchr($select_file,"."),1));
            }
            if (!$file_mime_type) {
                $file_mime_type="application/octet-stream";
            }
            header("Content-Type: " . $file_mime_type);
            header("Content-Disposition: attachment; filename=" . $select_file);
            readfile($tmpfile);
        }
        @unlink($tmpfile);
    } // END IF FTP
}

// END FUNCTION PHPFTP_GET - GET'S THE FILE FROM THE REMOTE SERVER ****************************************

function phpftp_put($phpftp_user,$phpftp_passwd,$phpftp_dir,$phpftp_file)
{
	if ($phpftp_dir == "") 
	{
        $phpftp_dir="/";
    }
	
	$target_path = $phpftp_dir;
	$target_path = $target_path . "/" . basename( $_FILES['phpftp_file']['name']); 
	
	echo "<BR>  target path  = " . ltrim($target_path,"/"); 
	
	$target_path = ltrim($target_path,"/");
		
	if(move_uploaded_file($_FILES['phpftp_file']['tmp_name'], $target_path)) {
		echo "The file ".  basename( $_FILES['phpftp_files']['name']) . 
		" has been uploaded to " . $phpftp_dir;
	} else{
		echo "There was an error uploading the file, please try again!";
	}
}

function phpftp_putOLD($phpftp_user,$phpftp_passwd,$filedir,$uploadedfile) 
{
    srand((double)microtime()*1000000);
    $randval = rand();
    $tmpfile="";

	$tmpfile = $tmpfile . basename( $_FILES['userfile']['name']); //$_FILES['uploadedfile']['tmp_name'], $target_path)
	
    if (!@move_uploaded_file($_FILES['userfile']['tmp_name'], $tmpfile)) 
	{ //$userfile,$tmpfile)
        phpftp_top();
		?>
		<font color="#ff0000"><strong>Upload failed!  Can't create temp file?</strong></font>
		<p><p>
		<a href="ftp.php">Start over?</a>
		<?php
        phpftp_bottom();
    } else 
	{
        if (!$ftp = @phpftp_connect($phpftp_user,$phpftp_passwd)) 
		{
            unlink($tmpfile);
            phpftp_top(); 
			?>
			<font color="#ff0000"><strong>FTP login failed!</strong></font><p><p>
			<a href="ftp.php">Start over?</a>
			<?php
            phpftp_bottom();
        } else 
		{
            ftp_chdir($ftp,$phpftp_dir);
            ftp_put($ftp,$userfile_name,$tmpfile,FTP_BINARY);
            ftp_quit($ftp);
            unlink($tmpfile);
            phpftp_list($phpftp_user,$phpftp_passwd,$phpftp_dir);
        }
    } // END IF MOVE_UPLAOD_FILES
}

// END FUNCTION PHPFTP_PUT - PUT'S THE FILE ON THE SERVER *************************************************************

switch($function) {
    case "dir";
        phpftp_list($phpftp_user,$phpftp_passwd,$phpftp_dir);
        break;
    case "cd";
        phpftp_cd($phpftp_user,$phpftp_passwd,$phpftp_dir,$select_directory);
        break;
    case "get";
        phpftp_get($phpftp_user,$phpftp_passwd,$phpftp_dir,$select_file);
        break;
    case "put";
        phpftp_put($phpftp_user,$phpftp_passwd,$phpftp_dir,$userfile,$userfile_name);
        break;
    case "mkdir";
        phpftp_mkdir($phpftp_user,$phpftp_passwd,$phpftp_dir,$new_dir);
        break;
    case "";
        phpftp_login();
        break;
}

?>
