<?PHP
function HTMLClean($string) {
	if(!is_string($string)) {
		return $string;
	}
	
	return htmlspecialchars($string, ENT_QUOTES);
}

function HTMLCleanArr($array) {
	if(!is_array($array)) {
		return $array;
	}
	
	foreach($array as $key => $content) {
		if(is_array($content)) {
			$content = HTMLCleanArr($content);
		} else {
			$content = HTMLClean($content);
		}
		
		$key = HTMLClean($key);
		
		$retArr[$key] = $content;
	}
	
	return $retArr;
}

?>