<?php header("Content-type: text/html; charset=utf-8"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <title>PHP DataGrid :: Sample #1 (code)</title>
   <?php // old value: charset=UTF-8..  <meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" /> ?>
   <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
    <meta name='keywords' content='datagridview, adminpanel, gridview, datalist, datagrid paging, programming, php, free script, free download, trial soft, datagrid, script, freeware, software, download, MySQL, database, web '/>
    <meta name='description' content='Advanced Power of PHP - best solutions for web developers' />
    <meta content='ApPHP' name='author'></meta>
    

    <link href="../css/datagrid_style_x-blue.css" type="text/css" rel="stylesheet" />
  </head>
<body>

<?php    
    ################################################################################   
    ## +---------------------------------------------------------------------------+
    ## | 1. Creating & Calling:                                                    | 
    ## +---------------------------------------------------------------------------+
    ##  *** only relative (virtual) path (to the current document)
	//header("Content-type: text/html; charset=ISO-8859-1");
	  ini_set('allow_call_time_pass_reference', TRUE);
	  //ini_set('error_reporting', E_ALL);
	  
      define ("DATAGRID_DIR", "./apphp_datagrid/");
      define ("PEAR_DIR", "./apphp_datagrid/pear/");
      
      require_once(DATAGRID_DIR.'datagrid.class.php');
      require_once(PEAR_DIR.'PEAR.php');
      require_once(PEAR_DIR.'DB.php');
    
    ##  *** creating variables that we need for database connection 
      $DB_USER='weaver';            /* usually like this: prefix_name             */
      $DB_PASS='slink2Sink';           /* must be already encrypted (recommended)   */
      $DB_HOST='localhost';               /* usually localhost                          */
      $DB_NAME='weaver';                /* usually like this: prefix_dbName           */
    
    //ob_start();
      $db_conn = DB::factory('mysql'); 
      $db_conn -> connect(DB::parseDSN('mysql://'.$DB_USER.':'.$DB_PASS.'@'.$DB_HOST.'/'.$DB_NAME));
    
    ##  *** put a primary key on the first place 
      $sql=" SELECT id, key_field, value_field FROM grid_test ";
       
    ##  *** set needed options
      $debug_mode = true;
      $messaging = true;
      $unique_prefix = "f_";  
      $dgrid = new DataGrid($debug_mode, $messaging, $unique_prefix, DATAGRID_DIR);
    ##  *** set data source with needed options
      $default_order_field = "key_field";
      $default_order_type = "ASC";
      $dgrid->dataSource($db_conn, $sql, $default_order_field, $default_order_type);	    
    
    ## +---------------------------------------------------------------------------+
    ## | 6. View Mode Settings:                                                    | 
    ## +---------------------------------------------------------------------------+
    ##  *** set columns in view mode
       $dgrid->setAutoColumnsInViewMode(true);  
    
    ## +---------------------------------------------------------------------------+
    ## | 7. Add/Edit/Details Mode settings:                                        | 
    ## +---------------------------------------------------------------------------+
    ##  ***  set settings for edit/details mode
      $table_name = "grid_test";
      $primary_key = "id";
      $condition = "";
      $dgrid->setTableEdit($table_name, $primary_key, $condition);
      $dgrid->setAutoColumnsInEditMode(true);
      
    ## +---------------------------------------------------------------------------+
    ## | 8. Bind the DataGrid:                                                     | 
    ## +---------------------------------------------------------------------------+
    ##  *** set debug mode & messaging options
        $dgrid->bind();        
        //ob_end_flush();
    ################################################################################    


echo "<a href=manual_insert.php>execute manual insert</a>";
?>



</body>
</html>