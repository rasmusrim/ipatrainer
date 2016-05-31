<?PHP

// Class for displaying templates.
function templateDisplay($file, $fieldsArr, $part = "", $withConstants = false) {
		
	if(!is_array($fieldsArr)) {
		print('$fieldsArr is no array in ' . $file . ':' . $part);
		exit();
	}
	
	
	$patternArr = array();
	$replacementArr = array();
	
		
	if(is_file($file)) {
		$linesArr = file($file);
		
		if($part) {
			$html = templateSplitParts($linesArr, $part);	
		} else {
			$html = join('', $linesArr);
		}
	} elseif(is_array($file)) {
			
		if($part) {
			if(!$file[$part]) {
				print($part . 'not found in template array');
				exit();
			}
			$html = $file[$part];
		} else {
			
			$html = join('', $file);
		}
	} else {
		print($file . ' is neither array nor file!');
		exit();
	}
				
	// Adding constants to fields
	if($withConstants) {
		$fieldsArr = array_merge($fieldsArr, getConstants());
	}
	
	
	// Making replace values
	foreach($fieldsArr as $key => $field) {
		$patternArr[] = "[field_$key]";
		$patternArr[] = "[field_slashes_$key]";
		$patternArr[] = "[field_html_$key]";
		
		
		$replacementArr[] = htmlClean($field);
		$replacementArr[] = htmlClean(addslashes($field));
		$replacementArr[] = $field;
	
	}
	
 	// Replacing values
	while($html != $oldHtml) {	
		$oldHtml = $html;
		
		for($i = 0; $i < sizeof($patternArr); $i++) {
			$html = str_replace($patternArr[$i], $replacementArr[$i], $html);
		}
	}
	
	// Delete all fields that were not associated to any values
	$html = preg_replace("/\[field_.*\]/U", "", $html);
		
	return($html);

}

/* This function splits a template file into the different parts of the template which are in the
   format of [template_xxx] where $part will have to be xxx. If no $part is entered, the function
   returns an array of all parts. */
function templateSplitParts($linesArr, $part = ""){
	foreach($linesArr as $line) {
		if(preg_match("/\[template_(\w*)\]/U", $line, $matches)) {
		
			$currentMatch = $matches[1];
			
		} elseif(!$part || $part == $currentMatch) {
			$retArr[$currentMatch] .= $line;
		}
		
	}

	if(!$part) {
		return $retArr;	
	} else {
		return $retArr[$part];
	}
}

function templateLoad($filename) {
	if(!is_file($filename)) {
		print("$filename is no file!");
		exit();
	}
	
	$linesArr = file($filename);
	
	return templateSplitParts($linesArr);
}

function getConstants($prefix = "BOOKED") {
	$constantsArr = get_defined_constants();
	
	foreach($constantsArr as $name => $value) {
		if(preg_match("/^" . $prefix . "_/", $name)) {
			$retConstantsArr[$name] = $value;
		}
	}
	
	return $retConstantsArr;
}