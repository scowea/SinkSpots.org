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
      $DB_USER=$_SESSION['db_user'];            /* usually like this: prefix_name             */
      $DB_PASS=$_SESSION['db_pass'];           /* must be already encrypted (recommended)   */
      $DB_HOST=$_SESSION['db_host'];               /* usually localhost                          */
      $DB_NAME=$_SESSION['db_name'];                /* usually like this: prefix_dbName           */
    
    //ob_start();
      $db_conn = DB::factory('mysql'); 
      $db_conn -> connect(DB::parseDSN('mysql://'.$DB_USER.':'.$DB_PASS.'@'.$DB_HOST.'/'.$DB_NAME));
    
    ##  *** put a primary key on the first place 
      $sql=" SELECT * FROM boats ";
       
    ##  *** set needed options
      $debug_mode = false;
      $messaging = true;
      $unique_prefix = "f_";  
      $dgrid = new DataGrid($debug_mode, $messaging, $unique_prefix, DATAGRID_DIR);
    ##  *** set data source with needed options
      $default_order_field = "date_posted";
      $default_order_type = "ASC";
      $dgrid->dataSource($db_conn, $sql, $default_order_field, $default_order_type);	    
    
	
		
	// set priveledges accordingly..
	$modes = array(
		  "add"     =>array("view"=>true, "edit"=>false, "type"=>"link"),
		  "edit"    =>array("view"=>true, "edit"=>true, "type"=>"link",  "byFieldValue"=>""),
		  "cancel"  =>array("view"=>true, "edit"=>true, "type"=>"link"),
		  "details" =>array("view"=>true, "edit"=>false, "type"=>"link"),
		 // "delete"  =>array("view"=>true, "edit"=>true, "type"=>"image")
		  
	);	
		
	$dgrid->SetModes($modes);
	
	//*******************************************
	
	$bottom_paging = array(
			 "results"=>true, "results_align"=>"left", 
			 "pages"=>true, "pages_align"=>"center", 
			 "page_size"=>true, "page_size_align"=>"right");
	$top_paging = array(
			 "results"=>true, "results_align"=>"left",
			 "pages"=>true, "pages_align"=>"center",
			 "page_size"=>true, "page_size_align"=>"right");
	$pages_array = array("10"=>"10", "25"=>"25", "50"=>"50", "100"=>"100", "250"=>"250", "500"=>"500", "1000"=>"1000");
	$default_page_size = 25;
	$paging_arrows = array("first"=>"|<<", "previous"=>"<<", "next"=>">>", "last"=>">>|");
	$dgrid->SetPagingSettings($bottom_paging, $top_paging, $pages_array, $default_page_size);
	
## +---------------------------------------------------------------------------+
    ## | 5. Filtering Settings:  (search)                                          | 
    ## +---------------------------------------------------------------------------+
	
	$filtering_option = true;
	$dgrid->AllowFiltering($filtering_option);
	
	// arrays to build dropdowns or radio buttons.
	$translate_credit_check_response = array("Approved"=>"Approved", "Declined"=>"Declined", "N/A"=>"N/A");
	$translate_boolean = array(0=>"No", 1=>"Yes");
	$models_array = array(
		"~?Unknown?~"=>"~?Unknown?~",
		"Acrobat"=>"Acrobat",
		"Angst"=>"Angst",
		"Asylum"=>"Asylum",
		"Bigfoot"=>"Bigfoot",
		"Ceamweaver"=>"Ceamweaver",
		"Drain"=>"Drain",
		"Fantum"=>"Fantum",
		"Fish"=>"Fish",
		"Hellbender"=>"Hellbender",
		"KOR"=>"KOR",
		"Maestro"=>"Maestro",
		"Meltdown"=>"Meltdown",
		"Mystryss"=>"Mystryss",
		"Ninja"=>"Ninja",
		"Prize"=>"Prize",
		"Projet"=>"Projet",
		"Shimmer"=>"Shimmer",
		"Skunk"=>"Skunk",
		"Sin"=>"Sin",
		"Shred"=>"Shred",
		"Shy KOR"=>"Shy KOR",
		"Shy Ninja"=>"Shy Ninja",
		"Sneaker"=>"Sneaker",
		"Soft KOR"=>"Soft KOR",
		"Soft Ninja"=>"Soft Ninja",
		"Spy"=>"Spy",
		"Underdawg"=>"Underdawg",
		"Urge"=>"Urge",
		"Venom"=>"Venom",
		"Voodoo Rocket"=>"Voodoo Rocket",
		"Vulcan"=>"Vulcan",
		"Whirld"=>"Whirld",
		"Whisper"=>"Whisper",					
	);
	
	
	//..................
	// this code builds the dependent dropdown country-state
	$country_name = (isset($_REQUEST['f__ff_mystery_spots_country']) ? $_REQUEST['f__ff_mystery_spots_country'] : "");
	$state_name = (isset($_REQUEST['f__ff_mystery_spots_state']) ? $_REQUEST['f__ff_mystery_spots_state'] : "");
	$city_name = (isset($_REQUEST['f__ff_mystery_spots_city']) ? $_REQUEST['f__ff_mystery_spots_city'] : "");

	// create the state filter condition..
	$city_filter_condition = "";
/*
	$state_sql =
	"SELECT *
	FROM mystery_spots
	WHERE state = '".strip_invalid_chars($state_name)."'";


	$result = mysql_query($state_sql);
	//echo '<br>sql: ' . $country_sql;
	//echo '<br>num rows:' . mysql_num_rows($result);
	
	if(mysql_num_rows($result) > 0)
	{
		$city_filter_condition .= " spot_id IN (-1";
		
		while($row = mysql_fetch_array($result))
		{
			$city_filter_condition .= ", ".$row[0];
		}
		$city_filter_condition .= ")";
	}
	else 
	{ 
		$city_filter_condition = ""; 
	}
*/	
    //echo '<br>state filter condition: ' . $state_filter_condition;
	
	//................................................	
	
	$filtering_fields = array(
	
		"Status"=>array(
			"type"=>"dropdownlist",
			"table"=>"boats",
			"field"=>"status",
			"filter_condition"=>"",
			"show_operator"=>false,
			"default_operator"=>"like",
			"case_sensitive"=>false,
			"comparison_type"=>"string",
			"width"=>"",
			"on_js_event"=>""),
			
		"Selling Price"=>array(
			"type"=>"dropdownlist",
			"table"=>"boats",
			"field"=>"price",
			"filter_condition"=>"",
			"show_operator"=>false,
			"default_operator"=>"like",
			"case_sensitive"=>false,
			"comparison_type"=>"string",
			"width"=>"",
			"on_js_event"=>""),	
			
		"Model"=>array(
			"type"=>"dropdownlist",
			"table"=>"boats",
			"field"=>"model",
			"filter_condition"=>"",
			"show_operator"=>false,
			"default_operator"=>"like",
			"case_sensitive"=>false,
			"comparison_type"=>"string",
			"width"=>"",
			"on_js_event"=>""),
				
		"Rider Weight (lbs)"=>array(
			"type"=>"dropdownlist",
			"table"=>"boats",
			"field"=>"cut_weight",
			"filter_condition"=>"",
			"show_operator"=>false,
			"default_operator"=>"like",
			"case_sensitive"=>false,
			"comparison_type"=>"string",
			"width"=>"",
			"on_js_event"=>""),
			
		"Rider Inseam (inches)"=>array(
			"type"=>"dropdownlist",
			"table"=>"boats",
			"field"=>"cut_inseam",
			"filter_condition"=>"",
			"show_operator"=>false,
			"default_operator"=>"like",
			"case_sensitive"=>false,
			"comparison_type"=>"string",
			"width"=>"",
			"on_js_event"=>""),
			
		"Rider Foot Size"=>array(
			"type"=>"dropdownlist",
			"table"=>"boats",
			"field"=>"cut_foot_size",
			"filter_condition"=>"",
			"show_operator"=>false,
			"default_operator"=>"like",
			"case_sensitive"=>false,
			"comparison_type"=>"string",
			"width"=>"",
			"on_js_event"=>""),
			
		"How It Floats For Me"=>array(
			"type"=>"dropdownlist",
			"table"=>"boats",
			"field"=>"chop",
			"filter_condition"=>"",
			"show_operator"=>false,
			"default_operator"=>"like",
			"case_sensitive"=>false,
			"comparison_type"=>"string",
			"width"=>"",
			"on_js_event"=>""),			
			
		"Description"=>array(
			"type"=>"textbox",
			"table"=>"boats",
			"field"=>"state",
			"filter_condition"=>"",
			"show_operator"=>false|true,
			"default_operator"=>"%like%",
			"case_sensitive"=>false,
			"comparison_type"=>"string",
			"width"=>"",
			"on_js_event"=>""),
			
		"Location - State"=>array(
			"type"=>"dropdownlist",
			"table"=>"boats",
			"field"=>"location_state",
			"filter_condition"=>"",
			"show_operator"=>false,
			"default_operator"=>"=",
			"case_sensitive"=>false,
			"comparison_type"=>"string",
			"width"=>"",
			"on_js_event"=>"onchange=\"reload(this.form);\""),			
			
		"Location - City"=>array(
			"type"=>"dropdownlist",
			"table"=>"boats",
			"condition"=>$city_filter_condition,
			"field"=>"location_city",
			"filter_condition"=>"",
			"show_operator"=>false,
			"default_operator"=>"=",
			"case_sensitive"=>false,
			"comparison_type"=>"string",
			"width"=>"",
			"on_js_event"=>""),									
			
	);
	$dgrid->SetFieldsFiltering($filtering_fields);

	
	
  
    ## +---------------------------------------------------------------------------+
    ## | 6. View Mode Settings:                                                    | 
    ## +---------------------------------------------------------------------------+
    ##  *** set columns in view mode
	
	
		$vm_columns = array(
    	"id"  =>array(	"header"=>"id", 
				  		"type"=>"label",    
						"req_type"=>"rt", 
						//"width"=>"210px", 
						"title"=>"", 
						"readonly"=>"false",  
						"maxlength"=>"-1", 
						"default"=>"", 
						"unique"=>"false", 
						"unique_condition"=>"", 
						"visible"=>"false",  // NOT VISIBLE
						"on_js_event"=>""),
				
    	"picture_url"  =>array("header"=>"Picture(s)", 
						"type"=>"image",     
						"align"=>"center",
						"width"=>"100px", 
						"wrap"=>"nowrap", 
						"text_length"=>"-1", 
						"case"=>"normal|upper|lower|camel", 
						"summarize"=>"false", 
						"sort_type"=>"string|numeric", 
						"sort_by"=>"", 
						"visible"=>"true", 
						"on_js_event"=>"", 
						"target_path"=>"images/boats/", 
						"default"=>"", 
						"image_width"=>"170px", 
						"image_height"=>"90px", 
						"linkto"=>"", 
						"magnify"=>"true", 
						"magnify_type"=>"lightbox",
						"magnify_power"=>"3"),				
					
    	"owner"  =>array("header"=>"Owner", 
				  		"type"=>"label",    
						"req_type"=>"rt", 
						//"width"=>"210px", 
						"title"=>"", 
						"readonly"=>"false", 
						"maxlength"=>"-1", 
						"default"=>"", 
						"unique"=>"false", 
						"unique_condition"=>"", 
						"visible"=>"true", 
						"on_js_event"=>""),					
					
    	"status"  =>array("header"=>"Status", 
				  		"type"=>"label",    
						"req_type"=>"rt", 
						//"width"=>"210px", 
						"title"=>"", 
						"readonly"=>"false", 
						"maxlength"=>"-1", 
						"default"=>"", 
						"unique"=>"false", 
						"unique_condition"=>"", 
						"visible"=>"true", 
						"on_js_event"=>""),
						
 	"price"  =>array("header"=>"Selling Price", 
				  		"type"=>"label",    
						"req_type"=>"rt", 
						//"width"=>"210px", 
						"title"=>"", 
						"readonly"=>"false", 
						"maxlength"=>"-1", 
						"default"=>"", 
						"unique"=>"false", 
						"unique_condition"=>"", 
						"visible"=>"true", 
						"on_js_event"=>""),						
		
    	"model"  =>array("header"=>"Model", 
				  		"type"=>"label",    
						"req_type"=>"rt", 
						//"width"=>"210px", 
						"title"=>"", 
						"readonly"=>"false", 
						"maxlength"=>"-1", 
						"default"=>"", 
						"unique"=>"false", 
						"unique_condition"=>"", 
						"visible"=>"true", 
						"on_js_event"=>""),
						
    	"cut_weight"  =>array("header"=>"Rider Weight (lbs)", 
				  		"type"=>"label",    
						"req_type"=>"rn", 
						//"width"=>"210px", 
						"title"=>"", 
						"readonly"=>"false", 
						"maxlength"=>"-1", 
						"default"=>"", 
						"unique"=>"false", 
						"unique_condition"=>"", 
						"visible"=>"true", 
						"on_js_event"=>""),
						
						
		"cut_inseam"  =>array("header"=>"Rider Inseam (inches)", 
				  		"type"=>"label",    
						"req_type"=>"rn", 
						//"width"=>"210px", 
						"title"=>"", 
						"readonly"=>"false", 
						"maxlength"=>"-1", 
						"default"=>"", 
						"unique"=>"false", 
						"unique_condition"=>"", 
						"visible"=>"true", 
						"on_js_event"=>""),
						
		"cut_foot_size"  =>array("header"=>"Rider Foot Size", 
				  		"type"=>"label",    
						"req_type"=>"rt", 
						//"width"=>"210px", 
						"title"=>"", 
						"readonly"=>"false", 
						"maxlength"=>"-1", 
						"default"=>"", 
						"unique"=>"false", 
						"unique_condition"=>"", 
						"visible"=>"true", 
						"on_js_event"=>""),						

		"chop"  =>array("header"=>"How It Floats For Me", 
				  		"type"=>"label",    
						"req_type"=>"rt", 
						//"width"=>"210px", 
						"title"=>"", 
						"readonly"=>"false", 
						"maxlength"=>"-1", 
						"default"=>"", 
						"unique"=>"false", 
						"unique_condition"=>"", 
						"visible"=>"true", 
						"on_js_event"=>""),		

    	"location_city"  =>array("header"=>"Location - City", 
				  		"type"=>"label",    
						"req_type"=>"rt", 
						//"width"=>"210px", 
						"title"=>"", 
						"readonly"=>"false", 
						"maxlength"=>"-1", 
						"default"=>"", 
						"unique"=>"false", 
						"unique_condition"=>"", 
						"visible"=>"true", 
						"on_js_event"=>""),			
						
    	"location_state"  =>array("header"=>"Location - State", 
				  		"type"=>"label",    
						"req_type"=>"rt", 
						//"width"=>"210px", 
						"title"=>"", 
						"readonly"=>"false", 
						"maxlength"=>"-1", 
						"default"=>"", 
						"unique"=>"false", 
						"unique_condition"=>"", 
						"visible"=>"true", 
						"on_js_event"=>""),													
						
    	"description"  =>array("header"=>"Description", 
				  		"type"=>"label", 
						"text_length"=>"150", 
						"tooltip"=>"true", 
						"tooltip_type"=>"simple", 
						
						"req_type"=>"rt", 
						//"width"=>"210px", 
						"title"=>"", 
						"readonly"=>"false", 
						"maxlength"=>"-1", 
						"default"=>"", 
						"unique"=>"false", 
						"unique_condition"=>"", 
						"visible"=>"true", 
						"on_js_event"=>""),
						
													
											
	); // end $em_columns = array(
	
	$dgrid->SetColumnsInViewMode($vm_columns);  
	  
	  //$dgrid->setAutoColumnsInViewMode(true);  
    
    ## +---------------------------------------------------------------------------+
    ## | 7. Add/Edit/Details Mode settings:                                        | 
    ## +---------------------------------------------------------------------------+
    ##  ***  set settings for edit/details mode
	    ##  ***  set settings for edit/details mode	
	$em_columns = array(	
	

	
	
		"picture_url"    =>array("header"=>"Main Picture", 
						"type"=>"image",     
						"req_type"=>"st", 
						"width"=>"220px", 
						"title"=>"", 
						"readonly"=>"false",
						"maxlength"=>"-1", 
						"default"=>"", 
						"unique"=>"false", 
						"unique_condition"=>"",
						"visible"=>"true", 
						"on_js_event"=>"",
						"target_path"=>"images/boats/", 
						"max_file_size"=>"5M", 
						"image_width"=>"170px",
						"image_height"=>"90px", 
						"resize_image"=>"false", 
						"resize_width"=>"",
						"resize_height"=>"", 
						"magnify"=>"true", 
						"magnify_type"=>"popup", 
						"magnify_power"=>"3", 
						"file_name"=>"",
						"host"=>"local|remote"),	
						
		"picture_2_url"    =>array("header"=>"Picture 2", 
						"type"=>"image",     
						"req_type"=>"st", 
						"width"=>"220px", 
						"title"=>"", 
						"readonly"=>"false",
						"maxlength"=>"-1", 
						"default"=>"", 
						"unique"=>"false", 
						"unique_condition"=>"",
						"visible"=>"true", 
						"on_js_event"=>"",
						"target_path"=>"images/boats/", 
						"max_file_size"=>"5M", 
						"image_width"=>"170px",
						"image_height"=>"90px", 
						"resize_image"=>"false", 
						"resize_width"=>"", 
						"resize_height"=>"",
						"magnify"=>"true", 
						"magnify_type"=>"popup", 
						"magnify_power"=>"3", 
						"file_name"=>"",
						"host"=>"local|remote"),	
						
		"picture_3_url"    =>array("header"=>"Picture 3", 
						"type"=>"image",     
						"req_type"=>"st", 
						"width"=>"220px", 
						"title"=>"", 
						"readonly"=>"false",
						"maxlength"=>"-1", 
						"default"=>"", 
						"unique"=>"false", 
						"unique_condition"=>"",
						"visible"=>"true", 
						"on_js_event"=>"",
						"target_path"=>"images/boats/", 
						"max_file_size"=>"5M", 
						"image_width"=>"170px",
						"image_height"=>"90px", 
						"resize_image"=>"false", 
						"resize_width"=>"", 
						"resize_height"=>"",
						"magnify"=>"true", 
						"magnify_type"=>"popup", 
						"magnify_power"=>"3", 
						"file_name"=>"",
						"host"=>"local|remote"),	
						
		"picture_4_url"    =>array("header"=>"Picture 4", 
						"type"=>"image",     
						"req_type"=>"st", 
						"width"=>"220px", 
						"title"=>"", 
						"readonly"=>"false",
						"maxlength"=>"-1", 
						"default"=>"", 
						"unique"=>"false", 
						"unique_condition"=>"",
						"visible"=>"true", 
						"on_js_event"=>"",
						"target_path"=>"images/boats/", 
						"max_file_size"=>"5M", 
						"image_width"=>"170px",
						"image_height"=>"90px", 
						"resize_image"=>"false", 
						"resize_width"=>"", 
						"resize_height"=>"",
						"magnify"=>"true", 
						"magnify_type"=>"popup", 
						"magnify_power"=>"3", 
						"file_name"=>"",
						"host"=>"local|remote"),	
						
		"picture_5_url"    =>array("header"=>"Picture 5", 
						"type"=>"image",     
						"req_type"=>"st", 
						"width"=>"220px", 
						"title"=>"", 
						"readonly"=>"false",
						"maxlength"=>"-1", 
						"default"=>"", 
						"unique"=>"false", 
						"unique_condition"=>"",
						"visible"=>"true", 
						"on_js_event"=>"",
						"target_path"=>"images/boats/", 
						"max_file_size"=>"5M", 
						"image_width"=>"170px",
						"image_height"=>"90px", 
						"resize_image"=>"false", 
						"resize_width"=>"", 
						"resize_height"=>"",
						"magnify"=>"true", 
						"magnify_type"=>"popup", 
						"magnify_power"=>"3", 
						"file_name"=>"",
						"host"=>"local|remote"),	
						
		"picture_6_url"    =>array("header"=>"Picture 6", 
						"type"=>"image",     
						"req_type"=>"st", 
						"width"=>"220px", 
						"title"=>"", 
						"readonly"=>"false",
						"maxlength"=>"-1", 
						"default"=>"", 
						"unique"=>"false", 
						"unique_condition"=>"",
						"visible"=>"true", 
						"on_js_event"=>"",
						"target_path"=>"images/boats/", 
						"max_file_size"=>"5M", 
						"image_width"=>"170px",
						"image_height"=>"90px", 
						"resize_image"=>"false", 
						"resize_width"=>"", 
						"resize_height"=>"",
						"magnify"=>"true", 
						"magnify_type"=>"popup", 
						"magnify_power"=>"3", 
						"file_name"=>"",
						"host"=>"local|remote"),	
								
    	"owner"  =>array("header"=>"Owner", 
				  		"type"=>"textbox",    
						"req_type"=>"st", 
						//"width"=>"210px", 
						"title"=>"", 
						"readonly"=>"false", 
						"maxlength"=>"-1", 
						"default"=>"", 
						"unique"=>"false", 
						"unique_condition"=>"", 
						"visible"=>"true", 
						"on_js_event"=>""),								
																																			
    	"status"  =>array("header"=>"Status", 
				  		"type"=>"textbox",    
						"req_type"=>"st", 
						//"width"=>"210px", 
						"title"=>"", 
						"readonly"=>"false", 
						"maxlength"=>"-1", 
						"default"=>"", 
						"unique"=>"false", 
						"unique_condition"=>"", 
						"visible"=>"true", 
						"on_js_event"=>""),
		
		    	"price"  =>array("header"=>"Selling Price", 
				  		"type"=>"textbox",    
						"req_type"=>"st", 
						//"width"=>"210px", 
						"title"=>"", 
						"readonly"=>"false", 
						"maxlength"=>"-1", 
						"default"=>"", 
						"unique"=>"false", 
						"unique_condition"=>"", 
						"visible"=>"true", 
						"on_js_event"=>""),
		
    	"model"  =>array("header"=>"Model", 
				  		"type"=>"enum",
						"source"=> $models_array,   
						"req_type"=>"st", 
						//"width"=>"210px", 
						"title"=>"", 
						"readonly"=>"false", 
						"maxlength"=>"-1", 
						"default"=>"", 
						"unique"=>"false", 
						"unique_condition"=>"", 
						"visible"=>"true", 
						"on_js_event"=>""),
						
    	"cut_weight"  =>array("header"=>"Rider Weight (lbs)", 
				  		"type"=>"textbox",    
						"req_type"=>"sn", 
						//"width"=>"210px", 
						"title"=>"", 
						"readonly"=>"false", 
						"maxlength"=>"-1", 
						"default"=>"", 
						"unique"=>"false", 
						"unique_condition"=>"", 
						"visible"=>"true", 
						"on_js_event"=>""),
						
		"cut_inseam"  =>array("header"=>"Rider Inseam (inches)", 
				  		"type"=>"textbox",    
						"req_type"=>"sn", 
						//"width"=>"210px", 
						"title"=>"", 
						"readonly"=>"false", 
						"maxlength"=>"-1", 
						"default"=>"", 
						"unique"=>"false", 
						"unique_condition"=>"", 
						"visible"=>"true", 
						"on_js_event"=>""),
						
		"cut_foot_size"  =>array("header"=>"Rider Foot Size", 
				  		"type"=>"textbox",    
						"req_type"=>"sn", 
						//"width"=>"210px", 
						"title"=>"", 
						"readonly"=>"false", 
						"maxlength"=>"-1", 
						"default"=>"", 
						"unique"=>"false", 
						"unique_condition"=>"", 
						"visible"=>"true", 
						"on_js_event"=>""),		
						
		"chop"  =>array("header"=>"How It Floats For Me", 
				  		"type"=>"textbox",    
						"req_type"=>"st", 
						//"width"=>"210px", 
						"title"=>"", 
						"readonly"=>"false", 
						"maxlength"=>"-1", 
						"default"=>"", 
						"unique"=>"false", 
						"unique_condition"=>"", 
						"visible"=>"true", 
						"on_js_event"=>""),											
					
    	"location_city"  =>array("header"=>"Location - City", 
				  		"type"=>"textbox",    
						"req_type"=>"st", 
						//"width"=>"210px", 
						"title"=>"", 
						"readonly"=>"false", 
						"maxlength"=>"-1", 
						"default"=>"", 
						"unique"=>"false", 
						"unique_condition"=>"", 
						"visible"=>"true", 
						"on_js_event"=>""),		
						
    	"location_state"  =>array("header"=>"Location - State", 
				  		"type"=>"textbox",    
						"req_type"=>"st", 
						//"width"=>"210px", 
						"title"=>"", 
						"readonly"=>"false", 
						"maxlength"=>"-1", 
						"default"=>"", 
						"unique"=>"false", 
						"unique_condition"=>"", 
						"visible"=>"true", 
						"on_js_event"=>""),												
						
    	"description"  =>array("header"=>"Description", 
				  		"type"=>"textarea",    
						"req_type"=>"st", 
						//"width"=>"210px", 
						"title"=>"", 
						"resizable"=>"false", 
						"rows"=>"7", 
						"cols"=>"50",
						"width"=>"500px",
						"edit_type"=>"wysiwyg",
						"readonly"=>"false", 
						"maxlength"=>"-1", 
						"default"=>"", 
						"unique"=>"false", 
						"unique_condition"=>"", 
						"visible"=>"true", 
						"on_js_event"=>""),
						

/*
    	"date_posted"  =>array("header"=>"Date Posted", 
				  		"type"=>"textbox",    
						"req_type"=>"st", 
						//"width"=>"210px", 
						"title"=>"", 
						"readonly"=>"false", 
						"maxlength"=>"-1", 
						"default"=>"", 
						"unique"=>"false", 
						"unique_condition"=>"", 
						"visible"=>"true", 
						"on_js_event"=>""),	

	*/							
	); // end $em_columns = array(

	//$auto_column_in_edit_mode =true;
	//$dgrid->SetAutoColumnsInEditMode($auto_column_in_edit_mode);

	$dgrid->SetColumnsInEditMode($em_columns);
	
      $table_name = "boats";
      $primary_key = "id";
      $condition = "";
      $dgrid->setTableEdit($table_name, $primary_key, $condition);
     // $dgrid->setAutoColumnsInEditMode(true);
      
    ## +---------------------------------------------------------------------------+
    ## | 8. Bind the DataGrid:                                                     | 
    ## +---------------------------------------------------------------------------+
    ##  *** set debug mode & messaging options
        $dgrid->bind();        
        //ob_end_flush();
    ################################################################################    

?>