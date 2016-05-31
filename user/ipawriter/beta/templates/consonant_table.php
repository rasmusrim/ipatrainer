<?PHP
// If no consonant table has been selected, show the one with all characters
if(!$_COOKIE['ipawriter_selected_consonant_table']) {
	$_COOKIE['ipawriter_selected_consonant_table'] = 1;
}


// Getting information about table
require(CACHE_PATH . '/consonant_tables/' . $_COOKIE['ipawriter_selected_consonant_table'] . '.php');
require(CACHE_PATH . '/consonants.php');




// Making table
foreach($consonantTableConfArr['consonants'] as $consonantID) {
	$consonantArr = $consonantsByIDArr[$consonantID]; 	
	
	$cellsArr[$consonantArr['col']][$consonantArr['row']][$consonantArr['voiced']]['content'] = '<div class="IPA_consonant" id="consonant_' . $consonantID . '"><script>document.write("\\u' . $consonantArr['unicode'] . '");</script></div>' . "\n";
	$cellsArr[$consonantArr['col']][$consonantArr['row']][$consonantArr['voiced']]['onClick'] = 'addCharacter(\'' . $consonantArr['unicode'] . '\');' . "\n";
		

}

// Allowing custom header names
foreach($consonantTableConfArr['cols'] as $key => $value) {
	if($consonantTableConfArr['colNames'][$key]) {
		$colsArr[$value] = $consonantTableConfArr['colNames'][$value];
	} else {
		$colsArr[$value] = $langArr['articulation']['places'][$value];
	}
		
}

foreach($consonantTableConfArr['rows'] as $key => $value) {
		
	if($consonantTableConfArr['rowNames'][$value]) {
		$rowsArr[$value] = $consonantTableConfArr['rowNames'][$value];
	} else {
		$rowsArr[$value] = $langArr['articulation']['manners'][$value];
	}
}

drawTable($cellsArr, $colsArr, $rowsArr, $consonantTableConfArr['cols'], $consonantTableConfArr['rows']);

