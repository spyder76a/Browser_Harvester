<?php
if ($_GET) {
	if ($_GET['data-url']) {
		$targetURL = $_GET['data-url'];
	}
	if ($_GET['data-requestor']) {
		$requestor = $_GET['data-requestor'];
	}
}

//
// Get Browser details
include('browser.php');
$browser_info = browser_detection('full');
// Clear Vars
$full = '';
$handheld = '';
$tablet = '';
$os = '';
// $mobile_device, $mobile_browser, $mobile_browser_number, $mobile_os, $mobile_os_number, $mobile_server, $mobile_server_number
if ( $browser_info[8] == 'mobile' ) {
	$handheld = '<h4 class="right-bar">Handheld Device:</h4><p class="right-bar">';
	if ( $browser_info[13][8] ) {
		if ( $browser_info[13][0] ) {
			$tablet = ' (tablet)';
			$device = 'tablet';
		}
		else {
			$handheld .= ucwords($browser_info[13][8]) . ' Tablet</br>';
			$device = ucwords($browser_info[13][8]) . 'tablet';
		}
	}
	if ( $browser_info[13][0] ) {
		$handheld .= 'Type: ' . ucwords( $browser_info[13][0] );
		if ( $browser_info[13][7] ) {
			$handheld = $handheld  . ' v: ' . $browser_info[13][7];
		}
		$handheld = $handheld  . $tablet . '<br />';
	}
	if ( $browser_info[13][3] ) {
		// detection is actually for cpu os here, so need to make it show what is expected
		if ( $browser_info[13][3] == 'cpu os' ) {
			$browser_info[13][3] = 'ios';
			$device = 'ipad';
		}
		$handheld .= 'OS: ' . ucwords( $browser_info[13][3] ) . ' ' .  $browser_info[13][4] . '<br />';
		// don't write out the OS part for regular detection if it's null
		if ( !$browser_info[5] ) {
			$os_starter = '';
			$os_finish = '';
		}
	}
	// let people know OS couldn't be figured out
	if ( !$browser_info[5] && $os_starter ) {
		$os_starter .= 'OS: N/A';
	}
	if ( $browser_info[13][1] ) {
		$handheld .= 'Browser: ' . ucwords( $browser_info[13][1] ) . ' ' .  $browser_info[13][2] . '<br />';
	}
	if ( $browser_info[13][5] ) {
		$handheld .= 'Server: ' . ucwords( $browser_info[13][5] . ' ' .  $browser_info[13][6] ) . '<br />';
	}
	$handheld .= '</p>';
}

switch ($browser_info[5]) {
	case 'win':
		$os .= 'Windows ';
		break;
	case 'nt':
		$os .= 'Windows NT ';
		break;
	case 'lin':
		$os .= 'Linux ';
		break;
	case 'mac':
		$os .= 'Mac ';
		break;
	case 'iphone':
		$os .= 'iPhone ';
		break;
	case 'ios':
		$os .= 'iPhone ';
		break;
	case 'unix':
		$os .= 'Unix';
		break;
	default:
		$os .= $browser_info[5];
}
$osLoot = $os;

if ( $browser_info[5] == 'nt' ) {
	if ( $browser_info[5] == 'nt' ) {
		switch ( $browser_info[6] ) {
			case '5.0':
				$os .= '5.0 (Windows 2000)';
				$osVer = '5.0 (Windows 2000)';
				break;
			case '5.1':
				$os .= '5.1 (Windows XP)';
				$osVer = '5.1 (Windows XP)';
				break;
			case '5.2':
				$os .= '5.2 (Windows XP x64 Edition or Windows Server 2003)';
				$osVer = '5.2 (Windows XP x64 Edition or Windows Server 2003)';
				break;
			case '6.0':
				$os .= '6.0 (Windows Vista)';
				$osVer = '6.0 (Windows Vista)';
				break;
			case '6.1':
				$os .= '6.1 (Windows 7)';
				$osVer = '6.1 (Windows 7)';
				break;
			case '6.2':
				$os .= '6.2 (Windows 8)';
				$osVer = '6.2 (Windows 8)';
				break;
			case '6.3':
				$os .= '6.3 (Windows 8.1)';
				$osVer = '6.3 (Windows 8.1)';
				break;
			case 'ce':
				$os .= 'CE';
				$osVer = 'CE';
				break;
			# note: browser detection 5.4.5 and later return always
			# the nt number in <number>.<number> format, so can use it
			# safely.
			default:
				if ( $browser_info[6] != '' ) {
					$os .= $browser_info[6];
					$osVer = $browser_info[6];
				}
				else {
					$os .= '(version unknown)';
					$osVer - 'Not Detected';
				}
				break;
		}
	}
}
elseif ( $browser_info[5] == 'iphone' ) {
	$os .=  'OS X (iPhone)';
	$osVer = 'iOS';
}
// note: browser detection now returns os x version number if available, 10 or 10.4.3 style
elseif ( ( $browser_info[5] == 'mac' ) && ( strstr( $browser_info[6], '10' ) ) ) {
	$os .=  'OS X ' . $browser_info[6];
	$osVer = 'OS X ' . $browser_info[6];
}
elseif ( $browser_info[5] == 'lin' ) {
	$os .= ( $browser_info[6] != '' ) ? 'Distro: ' . ucwords($browser_info[6] ) : 'Smart Move!!!';
	$osVer = ucwords($browser_info[6]);
}
// default case for cases where version number exists
elseif ( $browser_info[5] && $browser_info[6] ) {
	$os .=  " " . ucwords( $browser_info[6] );
	$osVer = ucwords($browser_info[6]);
}
elseif ( $browser_info[5] && $browser_info[6] == '' ) {
	$os .=  ' (version unknown)';
	$osVer =  'version unknown';
}
elseif ( $browser_info[5] ) {
	$os .=  ucwords( $browser_info[5] );
	$osVer =  ucwords( $browser_info[5] );
}
$os = $os_starter . $os . $os_finish;
$full .= $handheld . $os . '<br>';


switch ( $browser_info[0] ) {
	case 'moz':
		$a_temp = $browser_info[10];// use the moz array
		$full .= ($a_temp[0] != 'mozilla') ? 'Mozilla/ ' . ucwords($a_temp[0]) . ' ' : ucwords($a_temp[0]) . ' ';
		$full .= $a_temp[1] . '<br />';
		$full .= 'ProductSub: ';
		$full .= ( $a_temp[4] != '' ) ? $a_temp[4] : 'Not Available';
		$ua = 'mozilla';
		$uaVer = $a_temp[1];
		break;
	case 'ns':
		$full .= 'Browser: Netscape<br />';
		$full .= 'Full Version Info: ' . $browser_info[1];
		$ua = 'Netscape';
		$uaVer = $browser_info[1];
		break;
	case 'webkit':
		$a_temp = $browser_info[11];// use the webkit array
		$full .= 'User Agent: ';
		$full .= ucwords($a_temp[0]) . ' ' . $a_temp[1];
		$ua = ucwords($a_temp[0]);
		$uaVer = $a_temp[1];
		break;
	case 'ie':
		$full .= 'User Agent: ';
		$full .= strtoupper($browser_info[7]);
		$ua = strtoupper($browser_info[7]);
		// $browser_info[14] will only be set if $browser_info[1] is also set
		if ( $browser_info[14] ) {
			if ( $browser_info[14] != $browser_info[1] ) {
				$full .= '<br />(compatibility mode)';
				$full .= '<br />Actual Version: ' . number_format( $browser_info[14], '1', '.', '' );
				$full .= '<br />Compatibility Version: ' . $browser_info[1];
				$mode = 'compatibility mode' . $browser_info[1];
				$uaVer = number_format( $browser_info[14], '1', '.', '' );
			}
			else {
				if ( is_numeric($browser_info[1]) && $browser_info[1] < 11 ) {
					$full .= '<br />(standard mode)';
					$mode = 'standard';
				}
				$full .= '<br />Full Version Info: ' . $browser_info[1];
				$uaVer = $browser_info[1];
			}
		}
		else {
			$full .= '<br />Full Version Info: ';
			$full .= ( $browser_info[1] ) ? $browser_info[1] : 'Not Available';
			$uaVer = 'unknown';
		}
		break;
	default:
		$full .= 'User Agent: ';
		$full .= ucwords($browser_info[7]);
		$full .= '<br />Full Version Info: ';
		$full .= ( $browser_info[1] ) ? $browser_info[1] : 'Not Available';
		$ua = strtoupper($browser_info[7]);
		$uaVer = 'unknown';
		break;
}

if ( $browser_info[1] != $browser_info[9] ) {
	$full .= '<br />Main Version Number: ' . $browser_info[9];
}
if ( $browser_info[17][0] ) {
	$full .= '<br />Layout Engine: ' . ucfirst( ( $browser_info[17][0] ) );
	if ( $browser_info[17][1] ) {
		$full .= '<br />Engine Version: ' . ( $browser_info[17][1] );
	}
}

// Output
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>clickCheck</title>
<script src="scripts/jquery.min.js"></script>
</head>
<body>

<div>

		<?php 
		
		echo $full . '</p>';?>
</div>

<script type="text/javascript">
$(document).ready(function() {
	//alert('Document Ready');
	var targeturl = '<?php echo($targetURL); ?>';
	//alert(targeturl);
	//
	var url = '/Security/testRedirection/harvest.php',
		method = 'POST',
		data = {};
	data['cammo'] = '<?php echo($targetURL); ?>',
	data['requestor'] = '<?php echo($requestor); ?>',
	data['ip'] = '<?php echo $_SERVER['REMOTE_ADDR']; ?>',
	data['proxy'] = '<?php echo $_SERVER['HTTP_X_FORWARDED_FOR']; ?>',
	data['device'] = '<?php echo($device); ?>',
	data['os'] = '<?php echo($osLoot); ?>',
	data['osver'] = '<?php echo($osVer); ?>',
	data['ua'] = '<?php echo($ua); ?>',
	data['uaver'] = '<?php echo($uaVer); ?>',
	data['mode'] = '<?php echo($mode); ?>',
	//data['blob'] = '<?php echo($full); ?>';
	$.ajax({
		url: url,
		type: method,
		data: data,
		success: function(response) {											// When the request has been successful
			alert(response);
			//window.location.href = targeturl;									// Append the data from the requested page to the container
		}
	});
});




</script>
</body>
</html>

