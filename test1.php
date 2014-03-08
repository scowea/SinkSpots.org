<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>

<?php


	// create the error message...
	$message = "Error in " . $function . "<br>";
	$message = $message + "sql statement: " . $sql . "<br>";
	$message = $message + "sql error: " . mysql_error(); 

	echo $message;

?>

</body>
</html>
