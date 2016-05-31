<?PHP
error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);

// If no consonant table has been selected, show the one with all characters
if(!$_COOKIE['ipawriter_selected_vowel_trapezium']) {
	$_COOKIE['ipawriter_selected_vowel_trapezium'] = 1;
}

// Getting information about trapezium
require(CACHE_PATH . '/vowel_trapeziums/' . $_COOKIE['ipawriter_selected_vowel_trapezium'] . '.php');
require(CACHE_PATH . '/vowels.php');

// Adding vowels
foreach($vowelTrapeziumConfArr['vowels'] as $vowelID => $vowelArr) {
			
	$trapeziumArr[$vowelID] = '
					
		<table border="0" cellspacing="0" cellpadding="0" style="top:' . ($vowelArr['y'] - 12) . 'px; left:' . $vowelArr['x'] . 'px; position: absolute;" class="rowNotMouseOver">
			<tr>
				<td onClick="addCharacter(\'' . $vowelsArr[$vowelID]['unicode'] . '\');"> 
			
				<div id="vowel_' . $vowelID . '" class="IPA_vowel" onMouseOver="this.className=\'IPA_vowel rowMouseOver\';" onMouseOut="this.className=\'IPA_vowel rowNotMouseOver\';" style="width: 35px;">&#' . hexdec($vowelsArr[$vowelID]['unicode']) . ';</div>
				</td>
			</tr>
		</table>
	 ';
}

// Getting custom headers
foreach($languageArr['vowelArticulation']['cols'] as $colID => $string) {
		
	if($vowelTrapeziumConfArr['colNames'][$colID]) {
		$languageArr['vowelArticulation']['cols'][$colID] = $vowelTrapeziumConfArr['colNames'][$colID];
	} 	
	
}


foreach($languageArr['vowelArticulation']['rows'] as $rowID => $string) {

	if($vowelTrapeziumConfArr['rowNames'][$rowID]) { 
		$languageArr['vowelArticulation']['rows'][$rowID] = $vowelTrapeziumConfArr['rowNames'][$rowID];
	} 	

}

// Drawing trapezium
drawTrapezium($trapeziumArr, $languageArr['vowelArticulation']['cols'], $languageArr['vowelArticulation']['rows'], $colHeaderAnchorsArr, $rowHeaderAnchorsArr);


?>
