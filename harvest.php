<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Harvest</title>
</head>
<body>
<?php

if ($_POST) {
	
	// Set Default timezone
		date_default_timezone_set('UTC');
	
	
	
	foreach ($_POST as $field => $value) {
		if ($value) {
			echo "Post item: $field is $value <br/>";
		}
	}
} else if ($_GET) {
	
	
} else {
	die ('Nothing to see here');
}

?>

</body>
</html>

<?php 

function dbConect() {
	global $con;
	// Set database connection 
	$dbHost = "127.0.0.1";							// Set the Database Hostname
	$dbUser = "root";								// Set the database username
	$dbPass = "JRR9fql4";							// Set the database password for the user
	$dbName = "clickTracker";						// Set the name of the database to use
}
?>
	