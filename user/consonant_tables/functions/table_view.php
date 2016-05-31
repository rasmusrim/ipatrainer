<?PHP

require('templates/header.tmpl.php');

// Getting information about table
require(CACHE_PATH . '/consonant_tables/' . $_GET['consonantTableID'] . '.php');
require(CACHE_PATH . '/consonants.php');



// Load template
$templateArr = templateLoad('consonant_tables/templates/table_view.tmpl');

// Making table
foreach($consonantTableConfArr['consonants'] as $consonantID) {
	$consonantArr = $consonantsByIDArr[$consonantID]; 	
	
	if($_COOKIE['soundOff'] != 'true') {	
		$cellsArr[$consonantArr['col']][$consonantArr['row']][$consonantArr['voiced']]['content'] = '<img src="' . GFX_URL . '/consonants/' . $consonantArr['col'] . '.' . $consonantArr['row'] . '.' . $consonantArr['voiced'] . '.gif">';
		$cellsArr[$consonantArr['col']][$consonantArr['row']][$consonantArr['voiced']]['onClick'] = 'soundManager.play(\'player' . $consonantArr['col'] . '_' . $consonantArr['row'] . '_' . $consonantArr['voiced'] . '\');';

	} else {
		$cellsArr[$consonantArr['col']][$consonantArr['row']][$consonantArr['voiced']]['content'] = '<img src="' . GFX_URL . '/consonants/' . $consonantArr['col'] . '.' . $consonantArr['row'] . '.' . $consonantArr['voiced'] . '.gif" border="0">';
	}	 
	
	if($_COOKIE['soundOff'] != 'true') {	
		$soundmanagerString .= 'soundManager.createSound("player' . $consonantArr['col'] . '_' . $consonantArr['row'] . '_' . $consonantArr['voiced'] . '", "' . SND_URL . '/consonants/' . $consonantArr['col'] . '.' . $consonantArr['row'] . '.' . $consonantArr['voiced'] . '.mp3");' . "\n";
	} 


}

// Displaying header
$consonantTableConfArr['GFX_URL'] = GFX_URL;
$consonantTableConfArr['FLASH_URL'] = FLASH_URL;
$consonantTableConfArr['soundmanagerString'] = $soundmanagerString;
$consonantTableConfArr['consonantTableID'] = $_GET['consonantTableID'];

if($_COOKIE['soundOff'] != 'true') { // Sound is on
	$consonantTableConfArr['muteMessage'] = 'Click on the IPA characters to hear what they sound like.<br><br>';
} else { // Sound is off
	$consonantTableConfArr['muteMessage'] = 'You have chosen to mute all sounds. If you demute them (by clicking "Turn sound on" in the upper <br>right corner of your browser), you can click on the characters to hear what they sound like.<br><br>';
}

print(templateDisplay($templateArr, $consonantTableConfArr, 'header'));

// Allowing custom header names
foreach($consonantTableConfArr['cols'] as $key => $value) {
	if($consonantTableConfArr['colNames'][$key]) {
		$colsArr[$value] = $consonantTableConfArr['colNames'][$value];
	} else {
		$colsArr[$value] = $languageArr['articulation']['places'][$value];
	}
		
}

foreach($consonantTableConfArr['rows'] as $key => $value) {
		
	if($consonantTableConfArr['rowNames'][$value]) {
		$rowsArr[$value] = $consonantTableConfArr['rowNames'][$value];
	} else {
		$rowsArr[$value] = $languageArr['articulation']['manners'][$value];
	}
}

drawTable($cellsArr, $colsArr, $rowsArr, $consonantTableConfArr['cols'], $consonantTableConfArr['rows']);

// Displaying footer
$fieldsArr['adminID'] = $_GET['adminID'];
$fieldsArr['consonantTableID'] = $_GET['consonantTableID'];


print(templateDisplay($templateArr, $fieldsArr, 'footer'));

require('templates/footer.tmpl.php');


?>