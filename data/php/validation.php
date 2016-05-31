<?PHP
function isEurDate($str) {
	if(preg_match("/^\d\d\-\d\d\-\d\d\d\d$/", $str)) {
		$str = dateEur2Am($str);
		return isAmDate($str);
		
	} else {
		return false;
	}	
}

function isAmDate($str) {
	if(preg_match("/^\d\d\d\d\-\d\d\-\d\d$/", $str)) {
		
		list($year, $month, $day) = explode("-", $str);
		
		$timestamp = makeTimestamp($str);
		
		if($month > 12 || $day > date("t", $timestamp)) {
			return false;
		}
	} else {
		return false;
	}	
	
	return true;
}

function isTime($str) {
	if(preg_match("/^\d\d\:\d\d$/", $str)) {
		
		list($hour, $minute) = explode(":", $str);
		
		if($hour > 23 || $minute > 59) {
			return false;
		}
	
	} else {
		return false;
	}	

	return true;	
}

function isYear($str) {
	return preg_match('/^\d\d\d\d$/', $str);
	
}

function isAmDateTime($str) {
	list($date, $time) = explode(" ", $str);
	
	return (isAmDate($date) && isTime($time));
}

function isFloat($str) {
	return preg_match("/\-?\d*\.?\d*/", $str);
}

function isInt($str) {
	return preg_match("/^\-?\d*$/", $str);
}

function isEmail($email_address) {
     //Assumes that valid email addresses consist of user_name@domain.tld
     $at = strpos($email_address, "@");
     $dot = strrpos($email_address, ".");
     
     if($at === false || 
        $dot === false || 
        $dot <= $at + 1 ||
        $dot == 0 || 
        $dot == strlen($email_address) - 1) {
     	return(false);
 	}
        
     $user_name = substr($email_address, 0, $at);
     $domain_name = substr($email_address, $at + 1, strlen($email_address));
     
     if(Validate_String($user_name) === false || 
        Validate_String($domain_name) === false) {
        return(false);
 	}
     return(true);
}

function Validate_String($str) {
	return preg_match("/^[_a-z0-9-.]+$/", $str);
}

function isUltraSafe($str) {
	return preg_match("/^\w*$/i", $str);
}
?>