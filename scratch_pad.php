<hr>
<MARQUEE direction="right">
    	<blink>
        	<font color="#0000FF"><b> ...Scratch Pad... </b></font>
		</blink>
</MARQUEE>
<hr>
<?php

//##############################################################################################################################################
// RANDOM FUNCTIONS USED IN SCRATCH PAD CODE...
//##############################################################################################################################################

function dateDiff($dt1, $dt2, $split) 
{
	$date1 = (strtotime($dt1) != -1) ? strtotime($dt1) : $dt1;
	$date2 = (strtotime($dt2) != -1) ? strtotime($dt2) : $dt2;
	$dtDiff = $date1 - $date2;
	$totalDays = intval($dtDiff/(24*60*60));
	
	$totalSecs = $dtDiff-($totalDays*24*60*60); // this doesnt look at days!?! .. so check $dif['d'] == 0 to see if its the same day.
	$dif['totalSecs'] = $totalSecs; // not including any days in the total seconds. you would think 1 day difference with identical minutes/seconds should equal == 86,400 seconds, but actually this var will say zero.
	$dif['h'] = $h = intval($totalSecs/(60*60));
	$dif['m'] = $m = intval(($totalSecs-($h*60*60))/60);
	$dif['s'] = $totalSecs-($h*60*60)-($m*60);
	
	// use this if you want the TOTAL seconds between two dates.  above, the $dif['totalSecs'] could be the same if you compare 
	// two different days...
	$dif['totalSecs_including_days'] = $totalSecs + ($totalDays*24*60*60); // 86400seconds in one full day..ie 24 hours. ie 1440 mins.
	
    // set up array as necessary
  	switch($split) 
	{
		case 'yw': # split years-weeks-days
			$dif['y'] = $y = intval($totalDays/365);
			$dif['w'] = $w = intval(($totalDays-($y*365))/7);
			$dif['d'] = $totalDays-($y*365)-($w*7);
			break;
		case 'y': # split years-days
			$dif['y'] = $y = intval($totalDays/365);
			$dif['d'] = $totalDays-($y*365);
			break;
		case 'w': # split weeks-days
			$dif['w'] = $w = intval($totalDays/7);
			$dif['d'] = $totalDays-($w*7);
			break;
		case 'd': # don't split -- total days
			$dif['d'] = $totalDays;
			break;
		default:
			die("Error in dateDiff(). Unrecognized \$split parameter. Valid values are 'yw', 'y', 'w', 'd'. Default is 'yw'.");
    }
    return $dif;
} // end function dateDiff($dt1, $dt2, $split) 	

//*************************************************************************************************************************

function connect_to_server_and_db()
{

	// connect and select the db.
	$sybaseSrv = 'SYBLEOPARD';//
	$sybaseDb =  'lpr_pentech';
	$sybaseAcct = 'sa';	//'sa';		//'report'; //'sa'; 		//'sa';  	//'report';
	$sybasePass = 'hcdtc0';		//'hcdtc0';	//'bitut2'; //'lady632!b'; 	//'hcdtc0'; //'bitut2';
	
	// this will suppress the stupid message: "Warning: Sybase: Server message: Changed database context to 'master'.
	//(severity 10, procedure N/A) in /var/www/html/DBAdmins/phpSybaseAdmin/test.php on line 4"
	sybase_min_client_severity(100);
	sybase_min_server_severity(100);
		
	// connect to the server..
	$lspkdb = sybase_connect($sybaseSrv, $sybaseAcct, $sybasePass);
	if ($lspkdb == FALSE)
		die("problem: " . $sybaseSrv . " connection has failed! for acct: " . $sybaseAcct . " and pass: " . $sybasePass);
	else
	{	
		
		echo "Successfully connected to the " . $sybaseSrv . " server...<br>";
		// select the db...
		if (sybase_select_db($sybaseDb, $lspkdb) == FALSE)
			 die("problem: " . $sybaseSrv . " connection has failed! for acct: " . $sybaseAcct . " and pass: " . $sybasePass);
		else
			echo "Successfully selected the " . $sybaseDb . " database...<br>";
	}
	
	echo "<br>";
	
	// return the db handle
	return $lspkdb;

} // end function connect_to_server_and_db()


//##############################################################################################################################################
//##############################################################################################################################################

//****************************************************************************************
//...dummy data..
/*
$tmp_J1_segs = 1;
$tmp_J2_segs = 2; 

$rdw = 426; // representing the base record.
echo "rdw: " . $rdw . "<br>";

$rdw = $rdw + (100 * $tmp_J1_segs); // adding in the j1 segs.
echo "rdw added j1's: " . $rdw . "<br>";

$rdw = $rdw + (200 * $tmp_J2_segs); // adding in the j2 segs.
echo "rdw added j1's and j2's: " . $rdw . "<br>";

// keep a TOTAL total.. that we stick in the trailer record. these are global vars.
$total_J1_segs = $total_J1_segs + $tmp_J1_segs;
$total_J2_segs = $total_J2_segs + $tmp_J2_segs;			
		
//$rdw = "'" . $rdw . "";		
//echo "rdw: " . $rdw . "<br>";		
		
$rdw = str_pad(substr(trim($rdw), 0,  4),  4, '0', STR_PAD_LEFT);		
echo "formatting rdw: " . $rdw . "<br>";	
*/
//****************************************************************************************

//*****************************************************************************************
/*
$amount = '88888888889999';
echo "amount: " . $amount . "<br>";

$amount = trim($amount);

// grab the decimal..
$clip = substr($amount, -3, 1);

echo "end clip: " . $clip . "<br>";
	
// if its a decimal, just trunc off the last 3 characters...	
if ($clip == '.')
	$amount = substr($amount, 0, -3);	
	
echo "clipped amount: " . $amount . "<br>";

//.......................................................................
// if the amount is null? make it zero.
if (($amount == '') || ($amount == NULL) || ($amount == 0))
	$amount = 0;

//.........................................................
// if the amount is greater than 999,999,999 
// $1,000,000,000 == 1 billion dollars
if ($amount > 999999999)
	$amount = 999999999;
	
// pad it with zero's....
$amount = str_pad($amount,  9, '0', STR_PAD_LEFT); 	// datatype: numeric

echo "ending dollar amount: " . $amount . "<br>";
 	
//$amount = str_pad(substr(trim($total_status_code_88), 			0,  9),  9, '0', STR_PAD_LEFT); // POS. 201-209 = Total Status 88			
*/
//*****************************************************************************************************	
	
/*	
$in_date = date_create('2008-08-12 14:52:11');//'00000000';

echo 'date before: ' . $in_date . "<br>";	
	
// if is null, we must catch this....
if (($in_date == NULL) || ($in_date == '') || ($in_date == '00000000'))
 	$in_date = str_pad('',  8, '0', STR_PAD_LEFT); // 8 zeros...
else
{
	$strtime = strtotime(trim($in_date));
	echo 'date strtotime: ' . $strtime . "<br>"; 
		
	$in_date = date('mdY', $strtime); 
}
	
echo 'date after: ' . $in_date . "<br>"; 
*/			
	

//***********************************************************************************************************
/*
$start_timestamp = '02/12/09 9:04:40';
$end_timestamp = '02/12/09 9:12:51';

echo "Stored Proc Execution: Start Timestamp: " . $start_timestamp . '<br>';
echo "Stored Proc Execution: Finished Timestamp: " . $end_timestamp . '<br>';

// figure out the difference..
$timestamp_diff = dateDiff($end_timestamp, $start_timestamp, 'd');

echo "hours: " . $timestamp_diff['h'] . '<br>';
echo "mins: " . $timestamp_diff['m'] . '<br>';
echo "secs: " . $timestamp_diff['s'] . '<br>';

echo "Total secs: " . $timestamp_diff['totalSecs'] . '<br>';


echo "Total secs / 60: " .  ($timestamp_diff['totalSecs'] / 60) . '<br>';
echo "Total secs mod 60: " .  fmod($timestamp_diff['totalSec'], 60) . '<br>';



echo "<br>";
*/


//###########################################################################################################
// HELPER FUNCTIONS
//###########################################################################################################
// returns Array of Int values for difference between two dates
// $date1 > $date2 --> positive integers are returned
// $date1 < $date2 --> negative integers are returned

// $split recognizes the following:
//   'yw' = splits up years, weeks and days (default)
//   'y'  = splits up years and days
//   'w'  = splits up weeks and days
//   'd'  = total days

// examples:
//   $dif1 = dateDiff() or dateDiff('yw')
//   $dif2 = dateDiff('y')
//   $dif3 = dateDiff('w')
//   $dif4 = dateDiff('d')

// assuming dateDiff returned 853 days, the above
// examples would have a print_r output of:
//   $dif1 == Array( [y] => 2 [w] => 17 [d] => 4 )
//   $dif2 == Array( [y] => 2 [d] => 123 )
//   $dif3 == Array( [w] => 121 [d] => 6 )
//  $dif4 == Array( [d] => 847 )

// note: [h] (hours), [m] (minutes), [s] (seconds) are always returned as elements of the Array


/*
// 1. look for this history profile record...

//echo "ping: 1<br>";
	connect_to_server_and_db();
	
	$this_lse_s = 'TEST_1234';
	$this_les_s = 'TEST_7890';

//	echo "lse: " . $this_lse_s . "<br>";
//	echo "les: " . $this_les_s . "<br>";
	
	$pmt_hist_q = "select * from metro2_pmt_hist_profile where lse_s = '" . $this_lse_s . "' AND les_s = '" . $this_les_s . "'";
//echo "ping: 2<br>";
	$pmt_hist_rs = sybase_query($pmt_hist_q); // execute it.	
//echo "ping: 3<br>";	
	if (!$pmt_hist_rs)
		die ('<br>Problem executing query: ' . $pmt_hist_q . '<br>');
//echo "ping: 4<br>";
	// get the count for the total base records.
	$pmt_hist_num_rows = sybase_num_rows($pmt_hist_rs);
//echo "pmt_hist_num_rows: " . $pmt_hist_num_rows . "<br>";	

	// 		A. if it doesnt exist, create it
	if ($pmt_hist_num_rows == 0)
	{

		$create_pmt_hist_q = 
			'insert into metro2_pmt_hist_profile (lse_s, les_s, pmt_hist_profile, last_metro2_run_date) 
				values ("' . $this_lse_s . '", "' . $this_les_s . '", "BBBBBBBBBBBBBBBBBBBBBBBB", NULL)';
	
		$create_pmt_hist_rs = sybase_query($create_pmt_hist_q); // execute it.	

		if (!$create_pmt_hist_rs)
			die ('<br>Problem executing insert query: ' . $create_pmt_hist_q . '<br>');
						
	}

*/
//........................................................................................................................................
	
	$today = date('m/d/y G:i:s');
	echo "<br>today: " . $today;

	$today_month = date('m', strtotime($today));	
	echo "<br>todays month: " . $today_month;
	
	

		
?>
