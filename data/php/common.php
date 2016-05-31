<?PHP

function dateAm2Eur($date, $delimiter = '-') {

   list($date, $time) = split(' ', $date);

   if($time) {
	   $time = ' ' . $time;
   }

  	// Is the date actually in american format?
	if(!preg_match("/^\d\d\d\d-\d\d-\d\d$/", $date)) {
		return $date;
	}

	list($year, $month, $day) = split($delimiter, $date);
	return ($day . $delimiter . $month . $delimiter . $year . $time);
}

function dateEur2Am($date, $delimiter = '-') {
   // Chopping off any unnecessary time information
   $date = substr($date, 0, 10);

  	// Is the date actually in american format?
	if(!preg_match("/^\d\d\-\d\d-\d\d\d\d$/", $date)) {
		return $date;
	}


	list($day, $month, $year) = split($delimiter, $date);
	return ($year . $delimiter . $month . $delimiter . $day);
}


// Returns a randomly-generated string with input length
// Blake Caldwell <blake@pluginbox.com>
function generatePassword($length){
	static $srand;
	if($srand != true){
		$srand = true;
		srand((double)microtime() * 1000000);# only seed once!
	}

	$chars = '23456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';

	$len = strlen($chars) - 1;

	for($i = 0; $i < $length; $i++){
		$result .= substr($chars, rand(0, $len), 1);
	}
	return $result;
}

function microtimeGet() {
    list($usec, $sec) = explode(' ', microtime());
    return $usec;
}

function addTime($time1, $time2) {

	list($hour1, $minute1) = explode(':', $time1);
	list($hour2, $minute2) = explode(':', $time2);

	$addedHour = $hour1 + $hour2;
	$addedMinute = $minute1 + $minute2;

	if($addedMinute >= 60) {
		$hour3 = floor($addedMinute / 60);
		$addedMinute -= ($hour3 * 60);

		$addedHour += $hour3;
	}

	if(strlen($addedHour) == 1) {
		$addedHour = '0' . $addedHour;
	}

	if(strlen($addedMinute) == 1) {
		$addedMinute = '0' . $addedMinute;
	}

	return $addedHour . ':' . $addedMinute;
}

function makeTimestamp($datetime) {

	list($date, $time) = explode(' ', $datetime);

	if(!preg_match('/^\d\d\d\d\-\d\d\-\d\d$/', $date)) {
		print('Wrong date format in makeTimestamp: ' . $date);
		exit();
	}

	if($time && !preg_match('/^\d\d\:\d\d\:?\d?\d?$/', $time)) {
		print('Wrong time format in makeTimestamp: ' . $time);
		exit();
	}


	list($year, $month, $day) = explode('-', $date);
	list($hour, $minute, $second) = explode(':', $time);

	$retVal = mktime($hour, $minute, $second, $month, $day, $year, 0);

	return $retVal;
}

function convertDateTime($dateTime) {
	list($date, $time) = explode(" ", $dateTime);

	$date = dateAm2Eur($date);
	$time = substr($time, 0, 5);

	return $date . " " . $time;
}

function beautifyNumber($number) {
	$number = (int)$number; // Converting to integer

	$digitsArr = preg_split("//", $number, -1, PREG_SPLIT_NO_EMPTY);

	$size = sizeof($digitsArr);
	for($i = $size; $i > -1; $i--) {
		$retNumber = $digitsArr[$i] . $retNumber;

		if($a % 3 == 0) {
			$retNumber = " " . $retNumber;
		}
		$a++;
	}
	return ltrim(rtrim($retNumber));
}



function lethalError($msg) {

	$clientArr = unserialize($_SESSION['loggedInClientArr']);

	$msg = 'Time: ' . date('d-m-Y H:i') . "\n" .
		   'Where: ' . $_SERVER['PHP_SELF'] . "\n" .
		   'Who: ' . $clientArr['name'] . ' (' . $clientArr['username'] . ')' . "\n" .
		   'IP: ' . $_SERVER['REMOTE_ADDR'] . "\n" .
		   'Error message: ' . "\n" . $msg . "\n" .
		   'GET: ' . serialize($_GET) . "\n" .
		   'POST: ' . serialize($_POST) . "\n" .
		   'SESSION: ' . serialize($_SESSION) . "\n" .
		   'COOKIE: ' . serialize($_COOKIE) . "\n" .
		   'Browser: ' . $_SERVER['HTTP_USER_AGENT'] . "\n";

	if($_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
		print('Error:<br>' . $msg);
		exit();
	} else {
		mail("rasmusrim@gmail.com", "IPA feilmelding", $msg);
		print('An unexpected error occured. Please try again.');
		exit();
	}
}

function encrypt($string, $key) {
	$result = '';
	for($i = 1; $i <= strlen($string); $i++) {
		$char = substr($string, $i - 1, 1);
		$keychar = substr($key, ($i % strlen($key)) - 1, 1);
		$char = chr(ord($char) + ord($keychar));
		$result .= $char;
	}
	return $result;
}

function decrypt($string, $key) {
	$result = '';
	for($i = 1; $i <= strlen($string); $i++) {
		$char = substr($string, $i - 1, 1);
		$keychar = substr($key, ($i % strlen($key)) - 1, 1);
		$char = chr(ord($char) - ord($keychar));
		$result .= $char;
	}
	return $result;
}

/*function array_combine($keys, $values) {
	$size = sizeof($keys);

	for($i = 0; $i < $size; $i++) {
		$retArr[$keys[$i]] = $values[$i];
	}

	return $retArr;
}*/

function vardumparray(&$a) {

    if(is_array($a)==1) {
      $out.="\n<TABLE BORDER=1 CELLSPACING=1 CELLPADDING=5>";
      $out.="\n\t<tr bgcolor=0066AA><td colspan=3 align=center><font color=white>Array</FONT></TD></TR>";

      while(list($one,$two)=each($a)) {
          if (is_object($two)) {
           $out.="<tr bgcolor=006633><td colspan=3 align=center><Font color=white>Object</FONT></TD></TR>";
           $out.= "<tr >
                           <td valign=top>$one</td>
                           <td valign=top>=></td>
                           <td align=left valign=top>" . vardumparray($two) . "</td></tr>";
        }
        elseif (is_array($two)) {
           $out.= "<tr>
                           <td valign=top>$one</td>
                        <td valign=top>=></td>
                        <td align=left valign=top>" . vardumparray($two) . "</td></tr>";
        }
        else {
           $out.= "<tr>
                           <td valign=top>$one</td>
                        <td valign=top>=></td>
                        <td align=left valign=top>" . $two . "</td></tr>";
        }
      }
      $out.= "\n</TABLE>";
      return $out;
    }

    elseif (is_object($a)==1) {
        $out.="\n<TABLE BORDER=1 CELLSPACING=1 CELLPADDING=5>";
        $out.="\n\t<tr bgcolor=#FF6666><td align=center><font color=white>Object</FONT></TD></TR>";
        $out.='<tr bgcolor=white><td align=center>';
        $arr=get_object_vars($a);
        $out.=vardumparray($arr);
        $out.='</TD></TR>';
        $out.= "\n</TABLE>";
        return $out;
    }
    else {
      printf( "%s",$a);
    }
}

function pa($a) {
    print vardumparray($a);
}

function stripSlashesArray($tmpArr) {
	foreach($tmpArr as $key => $content) {
		$retArr[$key] = stripslashes($content);
	}

	return $retArr;
}

function beautifyNumbersArr($arr, $form) {
	$intArr = getInts($form);

	if(!$intArr) {
		return $arr;
	}

	foreach($intArr as $key) {
		$arr[$key] = beautifyNumber($arr[$key]);
	}

	return $arr;
}

function deBeautifyNumbersArr($arr, $form) {
	$intArr = getInts($form);

	if(!$intArr) {
		return $arr;
	}

	foreach($intArr as $key) {
		$arr[$key] = str_replace(' ', '', $arr[$key]);
	}

	return $arr;
}


function urlExists($url) {
	$url_info = parse_url($url);
	
	if (!$hwnd = @fsockopen($url_info['host'], 80, $errno, $errstr)) {
				
		if ($errno == 97) { /* invalid hostname DNS error */
			return -1;
		} else {
			// Connection failure
			return -2;
		}
	}
		
	$uri = @$url_info['path'] . '?' . @$url_info['query'];

	$http = "HEAD $uri HTTP/1.1\r\n";
	$http .= "Host: {$url_info['host']}\r\n";
	$http .= "Connection: close\r\n\r\n";

	@fwrite($hwnd, $http);

	$response = fgets($hwnd);
	print('<b>Response:</b> ' . $response . '...');	
	$response_match = "/^HTTP\/1\.\d ([0-9]+) (.*)$/";

	fclose($hwnd);

	if (preg_match($response_match, $response, $matches)) {
		if ($matches[1] == 404) { /* not found response */
			return false;
		} else if ($matches[1] == 200) { /* found */
			return true;
		} else if (preg_match("/^30[0-9]$/", $matches[1])) { /* found somewhere else */
			return -3;
		} else {
			
			return -4;
		}	
	} else {
		// Bad response
		return -5;
	} 
}

function array2code($arr) {
				
	
	foreach($arr as $key => $value) {
		if(is_array($value)) {
			$value = array2code($value);				
		} else {
			$value = '"' . $value . '"';
		}
		
		$arrayElementsArr[] = '"' . $key . '" => ' . $value;
	}
	
	return 'array(' . join(', ', $arrayElementsArr) . ')';
}


function showLabel($key, $capitalStart) {
	global $languageArr;
	
	if($capitalStart) {
		return(ucfirst($languageArr[$key]));
	} else {
		return($languageArr[$key]);
	}
	
	
}	
		
function array_ucfirst($arr) {
	foreach($arr as $key => $value) {
		$arr[$key] = ucfirst($value);
	}
	
	return $arr;
}
	
	
?>
